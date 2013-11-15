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

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Black\Bundle\PageBundle\Model\PageManagerInterface;
use Black\Bundle\PageBundle\Proxy\ProxyInterface;

/**
 * Class PageController
 *
 * @package Black\Bundle\PageBundle\Controller
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class PageController
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface
     */
    private $templating;

    /**
     * @var \Black\Bundle\PageBundle\Model\PageManagerInterface
     */
    private $pageManager;

    /**
     * @var \Black\Bundle\PageBundle\Proxy\ProxyInterface
     */
    private $proxy;

    /**
     * @param EngineInterface      $templating
     * @param PageManagerInterface $pageManager
     * @param ProxyInterface       $proxy
     */
    public function __construct(EngineInterface $templating, PageManagerInterface $pageManager, ProxyInterface $proxy)
    {
        $this->templating   = $templating;
        $this->pageManager  = $pageManager;
        $this->proxy        = $proxy;
    }

    /**
     * @Method("GET")
     * @Route("/all.html", name="pages")
     * @Template()
     * 
     * @return Template
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function indexAction()
    {
        $documents          = $this->pageManager->findPublishedPages();

        if (!$documents) {
            throw new PageNotFoundException();
        }

        return array(
            'documents' => $documents,
        );
    }

    /**
     * @param string $slug
     *
     * @Method("GET")
     * @Route("/page/{slug}.html", name="page_show")
     *
     * @return Template
     */
    public function showAction($slug)
    {
        $response   = $this->proxy->createResponse($slug);

        return $this->templating->renderResponse(
            'BlackPageBundle:Page:show.html.twig',
            array('document' => $response['object']),
            $response['response']
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
        $documentManager    = $this->getManager();
        $documents = $documentManager->findLastPublishedPages($max);

        return array(
            'documents' => $documents
        );
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
        $documentManager    = $this->getManager();
        $documents = $documentManager->findPublishedPages();

        return array(
            'documents' => $documents,
        );
    }
}
