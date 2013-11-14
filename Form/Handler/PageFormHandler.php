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

use Black\Bundle\PageBundle\Model\PageManagerInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Black\Bundle\PageBundle\Model\PageInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class PageFormHandler
 *
 * @package Black\Bundle\PageBundle\Form\Handler
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class PageFormHandler
{
    /**
     * @var \Symfony\Component\Form\FormInterface
     */
    protected $form;
    /**
     * @var \Black\Bundle\PageBundle\Model\PageManagerInterface
     */
    protected $pageManager;
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
     * @param FormInterface $form
     * @param PageManagerInterface $pageManager
     * @param Request $request
     * @param Router $router
     * @param SessionInterface $session
     */
    public function __construct(FormInterface $form, PageManagerInterface $pageManager, Request $request, Router $router, SessionInterface $session)
    {
        $this->form         = $form;
        $this->pageManager  = $pageManager;
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
    public function process(PageInterface $page)
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
    protected function onDelete($page)
    {
        $this->pageManager->remove($page);
        $this->pageManager->flush();

        $this->setFlash('success', 'black.bundle.page.success.page.admin.page.delete');
        $this->setUrl($this->generateUrl('admin_page_index'));

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
            $this->pageManager->persist($page);
        }

        $this->pageManager->flush();

        if ($this->form->get('save')->isClicked()) {
            $this->setUrl($this->generateUrl('admin_page_edit', array('id' => $page->getId())));

            return true;
        }

        if ($this->form->get('saveAndAdd')->isClicked()) {
            $this->setUrl($this->generateUrl('admin_page_new'));

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

    /**
     * @param $url
     */
    protected function setUrl($url)
    {
        $this->url = $url;
    }
}
