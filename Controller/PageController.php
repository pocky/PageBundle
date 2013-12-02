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
class PageController extends CommonController
{
    /**
     * @var \Black\Bundle\PageBundle\Proxy\ProxyInterface
     */
    protected $proxy;

    /**
     * @param Configuration    $configuration
     * @param HandlerInterface $handler
     * @param ProxyInterface   $proxy
     */
    public function __construct(Configuration $configuration, HandlerInterface $handler, ProxyInterface $proxy)
    {
        parent::__construct($configuration, $handler);

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
        return parent::createAction();
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
        return parent::deleteAction($value);
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
        return parent::indexAction();
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
        $documents = $this->configuration->getManager()->findPublishedPages();

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
        $documents = $this->configuration->getManager()->findLastPublishedPages($max);

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
        return parent::updateAction($value);
    }
}
