<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Black\Bundle\PageBundle\Model\PageInterface;
use Black\Bundle\PageBundle\Model\PageManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Black\Bundle\CommonBundle\Form\Handler\HandlerInterface;

/**
 * Class PageFormHandler
 *
 * @package Black\Bundle\PageBundle\Form\Handler
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class PageFormHandler implements HandlerInterface
{
    /**
     * @var
     */
    protected $factory;
    /**
     * @var \Symfony\Component\Form\FormInterface
     */
    protected $form;
    /**
     * @var
     */
    protected $manager;
    /**
     * @var
     */
    protected $parameters;
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected $router;
    /**
     * @var \Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    protected $session;
    /**
     * @var
     */
    protected $url;

    /**
     * @param FormInterface        $form
     * @param PageManagerInterface $manager
     * @param Request              $request
     * @param Router               $router
     * @param SessionInterface     $session
     */
    public function __construct(
        FormInterface $form,
        PageManagerInterface $manager,
        Request $request,
        Router $router,
        SessionInterface $session,
        array $parameters = array()
    )
    {
        $this->form         = $form;
        $this->manager      = $manager;
        $this->parameters   = $parameters;
        $this->request      = $request;
        $this->router       = $router;
        $this->session      = $session;
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param PageInterface $page
     *
     * @return bool|mixed|void
     */
    public function process($page)
    {
        $this->form->setData($page);

        if ('POST' === $this->request->getMethod()) {

            $this->form->handleRequest($this->request);

            if ($this->form->has('delete') && $this->form->get('delete')->isClicked()) {
                return $this->onDelete($page);
            }

            if ($this->form->isValid()) {
                return $this->onSave($page);
            } else {
                return $this->onFailed();
            }
        }
    }

    /**
     * @param $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param       $route
     * @param array $parameters
     * @param       $referenceType
     *
     * @return mixed
     */
    protected function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->router->generate($route, $parameters, $referenceType);
    }

    /**
     * @param $page
     *
     * @return bool
     */
    protected function onDelete(PageInterface $page)
    {
        $this->manager->remove($page);
        $this->manager->flush();

        $this->setFlash('success', 'black.bundle.page.success.page.admin.page.delete');
        $this->setUrl($this->generateUrl($this->parameters['route']['index']));

        return true;
    }

    /**
     * @return bool
     */
    protected function onFailed()
    {
        $this->setFlash('error', 'black.bundle.page.error.page.admin.page.not.valid');

        return false;
    }

    /**
     * @param PageInterface $page
     *
     * @return mixed
     */
    protected function onSave(PageInterface $page)
    {
        $page->upload();

        if (!$page->getId()) {
            $this->manager->persist($page);
        }

        $this->manager->flush();

        if ($this->form->get('save')->isClicked()) {
            $this->setFlash('success','black.bundle.page.success.page.admin.page.save');
            $this->setUrl($this->generateUrl($this->parameters['route']['update'], array('value' => $page->getId())));

            return true;
        }

        if ($this->form->get('saveAndAdd')->isClicked()) {
            $this->setFlash('success','black.bundle.page.success.page.admin.page.saveAndAdd');
            $this->setUrl($this->generateUrl($this->parameters['route']['create']));

            return true;
        }
    }

    /**
     * @param $name
     * @param $msg
     * @return mixed
     */
    protected function setFlash($name, $msg)
    {
        return $this->session->getFlashBag()->add($name, $msg);
    }
}
