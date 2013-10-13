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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * @var
     */
    protected $manager;

    /**
     * @var \Black\Bundle\SeoBundle\Model\SeoInterface
     */
    protected $seo;

    /**
     * @var \Symfony\Component\Security\Core\SecurityContext
     */
    protected $context;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var \Symfony\Component\HttpFoundation\Response
     */
    protected $response;

    /**
     * @var \Symfony\Component\HttpKernel\Kernel
     */
    protected $kernel;

    /**
     * @param PageManagerInterface $manager
     * @param SeoInterface         $seo
     * @param SecurityContext      $context
     * @param Request              $request
     * @param Kernel               $kernel
     */
    public function __construct(PageManagerInterface $manager, SeoInterface $seo, SecurityContext $context, Request $request, Kernel $kernel)
    {
        $this->manager = $manager;
        $this->seo      = $seo;
        $this->context  = $context;
        $this->request  = $request;
        $this->kernel   = $kernel;
    }

    /**
     * @param string $property
     *
     * @return array|NotFoundHttpException
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
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
            throw new NotFoundHttpException('Requested page not found.');
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
     * @param Object $object
     */
    protected function formatSeo($object)
    {
        if ($this->getSeo() && $object->getSeo()) {
            $seo = $this->getSeo();

            if ($object->getSeo()->getTitle()) {
                $seo->setTitle($object->getSeo()->getTitle());
            }

            if ($object->getSeo()->getDescription()) {
                $seo->setDescription($object->getSeo()->getDescription());
            }

            if ($object->getSeo()->getKeywords()) {
                $seo->setKeywords($object->getSeo()->getKeywords());
            }
        }
    }

    /**
     * @param Object $object
     *
     * @return Response
     */
    protected function prepareResponse($object)
    {
        $response = $this->getResponse();

        if ('prod' === $this->getKernel()->getEnvironment()) {
            $response->setEtag($object->computeEtag());
            $response->setLastModified($object->getUpdatedAt());
            $response->setPublic();
        }

        return $response;
    }

    /**
     * @return mixed|null
     */
    protected function getRequestParam()
    {
        $request = $this->getRequest();

        return $request->get('slug');
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
     * @param array $role
     *
     * @return bool
     */
    protected function checkRole($role)
    {
        $context   = $this->getContext();

        return $context->isGranted($role);
    }

    /**
     * @return mixed
     */
    protected function getUser()
    {
        return $this->getToken()->getUser();
    }

    /**
     * @return mixed
     */
    private function getManager()
    {
        return $this->manager;
    }

    /**
     * @return SeoInterface
     */
    private function getSeo()
    {
        return $this->seo;
    }

    /**
     * @return SecurityContext
     */
    private function getContext()
    {
        return $this->context;
    }

    /**
     * @return null|\Symfony\Component\Security\Core\Authentication\Token\TokenInterface
     */
    private function getToken()
    {
        return $this->getContext()->getToken();
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
     * @return Kernel
     */
    private function getKernel()
    {
        return $this->kernel;
    }
}
