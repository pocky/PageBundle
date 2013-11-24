<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Controller;

use Black\Bundle\CommonBundle\Controller\ControllerInterface;
use Black\Bundle\CommonBundle\Doctrine\ManagerInterface;
use Black\Bundle\CommonBundle\Form\Handler\HandlerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Black\Bundle\PageBundle\Proxy\ProxyInterface;

/**
 * Class PageController
 *
 * @Route("/page", service="black_page.controller.page")
 *
 * @package Black\Bundle\PageBundle\Controller
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class PageController implements ControllerInterface
{
    /**
     * @var \Black\Bundle\CommonBundle\Controller\ControllerInterface
     */
    protected $controller;
    /**
     * @var \Black\Bundle\CommonBundle\Form\Handler\HandlerInterface
     */
    protected $handler;
    /**
     * @var \Black\Bundle\CommonBundle\Doctrine\ManagerInterface
     */
    protected $manager;
    /**
     * @var \Black\Bundle\PageBundle\Proxy\ProxyInterface
     */
    protected $proxy;

    /**
     * @param ControllerInterface    $controller
     * @param HttpExceptionInterface $exception
     * @param ManagerInterface       $manager
     * @param HandlerInterface       $handler
     * @param ProxyInterface         $proxy
     */
    public function __construct(
        ControllerInterface $controller,
        HttpExceptionInterface $exception,
        ManagerInterface $manager,
        HandlerInterface $handler,
        ProxyInterface $proxy
    )
    {
        $this->controller   = $controller;
        $this->manager      = $manager;
        $this->handler      = $handler;
        $this->proxy        = $proxy;

        $controller->setException($exception);
        $controller->setManager($manager);
        $controller->setHandler($handler);
    }

    /**
     * @Method({"GET", "POST"})
     * @Route("/new", name="page_create")
     * @Template()
     *
     * @return array
     */
    public function createAction()
    {
        return $this->controller->createAction();
    }

    /**
     * @Method({"POST", "GET"})
     * @Route("/{value}/delete", name="page_delete")
     *
     * @param $value
     *
     * @return mixed
     */
    public function deleteAction($value)
    {
        return $this->controller->deleteAction($value);
    }

    /**
     * @return mixed
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @return HandlerInterface
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @return ManagerInterface
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @Method("GET")
     * @Route("/index.html", name="page_index")
     * @Template()
     *
     * @return Template
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function indexAction()
    {
        return $this->controller->indexAction();
    }

    /**
     * @Method("GET")
     * @Route("/menu", name="_pages_menu")
     * @Template()
     *
     * @return Template
     */
    public function menuPagesAction()
    {
        $documents = $this->pageManager->findPublishedPages();

        return array(
            'documents' => $documents,
        );
    }

    /**
     * @param integer $max
     * 
     * @Method("GET")
     * @Route("/recent/{max}", name="_pages_recent")
     * @Template()
     * 
     * @return Template
     */
    public function recentPagesAction($max = 3)
    {
        $documents = $this->pageManager->findLastPublishedPages($max);

        return array(
            'documents' => $documents
        );
    }

    /**
     * @param string $slug
     *
     * @Method("GET")
     * @Route("/{value}.html", name="page_show")
     * @Template()
     *
     * @return Template
     */
    public function showAction($value)
    {
        $response   = $this->proxy->createResponse($value);

        return array(
            'document' => $response['object']
        );
    }

    /**
     * @Method({"GET", "POST"})
     * @Route("/{value}/update", name="page_update")
     * @Template()
     *
     * @param $value
     *
     * @return mixed
     */
    public function updateAction($value)
    {
        return $this->controller->updateAction($value);
    }
}
