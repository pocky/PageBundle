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

use Black\Bundle\CommonBundle\Controller\CommonController;
use Black\Bundle\CommonBundle\Configuration\Configuration;
use Black\Bundle\CommonBundle\Form\Handler\HandlerInterface;
use Black\Bundle\PageBundle\Proxy\ProxyInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class PageController
 *
 * @Route("/page", service="black_page.controller.page")
 *
 * @package Black\Bundle\PageBundle\Controller
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class PageController
{
    /**
     * @var \Black\Bundle\PageBundle\Proxy\ProxyInterface
     */
    protected $proxy;

    /**
     * @param ProxyInterface   $proxy
     */
    public function __construct(ProxyInterface $proxy)
    {
        $this->proxy    = $proxy;
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
        return array();
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
        return array();
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
        return array();
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
        $documents = $this->getManager()->findPublishedPages();

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
        $documents = $this->getManager()->findLastPublishedPages($max);

        return array(
            'documents' => $documents
        );
    }

    /**
     * @param string $value
     *
     * @Method("GET")
     * @Route("/{value}.html", name="page_read")
     * @Template()
     *
     * @return Template
     */
    public function readAction($value)
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
        return array();
    }
}
