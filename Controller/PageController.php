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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class PageController
 *
 * @Route("/page")
 *
 * @package Black\Bundle\PageBundle\Controller
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class PageController extends Controller
{
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
        $documentManager    = $this->getManager();
        $documents          = $documentManager->findPublishedPages();

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
     * @Route("/{slug}.html", name="page_show")
     * @Template()
     * 
     * @return Template
     */
    public function showAction($slug)
    {
        $proxy      = $this->getProxy();
        $response   = $proxy->createResponse($slug);

        return $this->render(
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

    /**
     * @return DocumentManager
     */
    protected function getManager()
    {
        return $this->get('black_page.manager.page');
    }

    /**
     * @return object
     */
    protected function getProxy()
    {
        return $this->get('black_page.proxy');
    }
}
