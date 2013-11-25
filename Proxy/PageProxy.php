<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Proxy;

use Black\Bundle\SeoBundle\Model\SeoInterface;
use Black\Bundle\PageBundle\Model\PageManagerInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Black\Bundle\PageBundle\Exception\PageNotFoundException;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class PageProxy
 *
 * @package Black\Bundle\PageBundle\Proxy
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class PageProxy implements ProxyInterface
{
    /**
     * @var \Symfony\Component\Security\Core\SecurityContext
     */
    protected $context;
    /**
     * @var
     */
    protected $manager;
    /**
     * @var
     */
    protected $proxyEnabled;
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;
    /**
     * @var \Symfony\Component\HttpFoundation\Response
     */
    protected $response;
    /**
     * @var \Black\Bundle\SeoBundle\Model\SeoInterface
     */
    protected $seo;

    /**
     * @param PageManagerInterface $manager
     * @param SecurityContext      $context
     * @param                      $proxyEnabled
     * @param Request              $request
     * @param SeoInterface         $seo
     */
    public function __construct(
        PageManagerInterface $manager,
        SecurityContext $context,
        $proxyEnabled,
        Request $request,
        SeoInterface $seo
    )
    {
        $this->manager      = $manager;
        $this->context      = $context;
        $this->proxyEnabled = $proxyEnabled;
        $this->request      = $request;
        $this->seo          = $seo;

    }

    /**
     * @param $property
     *
     * @return array
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function createResponse($property)
    {
        $authenticated  = $this->checkRole('IS_AUTHENTICATED_FULLY');

        try {
            $object         = $this->createQuery($property);
        } catch (\Exception $e) {
            $object = null;
        }
        if (!$object) {
            throw new PageNotFoundException();
        }

        $this->formatSeo($object);
        $response = $this->prepareResponse($object);

        if ($response->isNotModified($this->getRequest())) {
            return array(
                'object'   => $object,
                'response' => $response,
            );
        }

        if (false === $this->checkRole('ROLE_SUPER_ADMIN')) {
            if (true === $object->isPrivate() && $object->getAuthor() != $this->getUser()) {
                throw new AccessDeniedException();
            }

            if (true === $object->isProtected() && false === $authenticated) {
                throw new AccessDeniedException();
            }
        }

        return array(
            'object'    => $object,
            'response'  => $response
        );
    }

    /**
     * @return mixed
     */
    protected function createQuery()
    {
        $param  = $this->getRequestParam();
        $object = $this->getManager()->findPageBySlug($param);

        return $object;
    }

    /**
     * @param Object $object
     */
    protected function formatSeo($object)
    {
        $seo = $this->getSeo();

        if ($meta = $object->getSeo()) {

            if ($meta->getTitle()) {
                $seo->setTitle($meta->getTitle());
            }

            if ($meta->getDescription()) {
                $seo->setDescription($meta->getDescription());
            }

            if ($meta->getKeywords()) {
                $seo->setKeywords($meta->getKeywords());
            }
        }
    }

    /**
     * @return mixed|null
     */
    protected function getRequestParam()
    {
        $request = $this->getRequest();

        return $request->get('value');
    }

    /**
     * @param array $role
     *
     * @return bool
     */
    protected function checkRole($role)
    {
        $context   = $this->getContext();

        if ($context->getToken()) {
            return $context->isGranted($role);
        }

        return;
    }

    /**
     * @return mixed
     */
    protected function getUser()
    {
        return $this->getToken()->getUser();
    }

    /**
     * @param Object $object
     *
     * @return Response
     */
    protected function prepareResponse($object)
    {
        $response = $this->getResponse();

        if ($this->proxyEnabled) {
            $response->setEtag($object->computeEtag());
            $response->setLastModified($object->getUpdatedAt());
            $response->setPublic();
        }

        return $response;
    }

    /**
     * @return SecurityContext
     */
    private function getContext()
    {
        return $this->context;
    }

    /**
     * @return mixed
     */
    private function getManager()
    {
        return $this->manager;
    }

    /**
     * @return Request
     */
    private function getRequest()
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    private function getResponse()
    {
        return new Response();
    }

    /**
     * @return SeoInterface
     */
    private function getSeo()
    {
        return $this->seo;
    }

    /**
     * @return null|\Symfony\Component\Security\Core\Authentication\Token\TokenInterface
     */
    private function getToken()
    {
        return $this->getContext()->getToken();
    }
}
