<?php

/*
 * This file is part of the Blackengine package.
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
use Symfony\Component\Serializer\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Controller managing the person profile`
 *
 * @Route("/page")
 */
class PageController extends Controller
{
    /**
     * index of Pages
     *
     * @Method("GET")
     * @Route("/all.html", name="pages")
     * @Template()
     */
    public function indexAction()
    {
        $documentManager    = $this->getDocumentManager();
        $documents = $documentManager->findPublishedPages();

        if (!$documents) {
            $t = $this->get('translator')->trans('page.not.found');
            throw $this->createNotFoundException($t);
        }

        return array(
            'documents' => $documents,
        );
    }

    /**
     * Show page by slug
     *
     * @Method("GET")
     * @Route("/{slug}.html", name="page_show")
     * @Template()
     */
    public function showAction($slug)
    {
        $documentManager    = $this->getDocumentManager();
        $document = $documentManager->findPageBySlug($slug);

        if (!$document) {
            throw $this->createNotFoundException('page.not.found');
        }

        if ($document->getSeo()) {
            $seo = $this->get('black_seo.seo');
            $seo
                ->setTitle($document->getSeo()->getTitle())
                ->setDescription($document->getSeo()->getDescription())
            ;

            if ($document->getSeo()->getKeywords()) {
                $seo->setKeywords($document->getSeo()->getKeywords());
            }
        }

        return array(
            'document' => $document,
        );
    }

    /**
     * Recent pages (embed action)
     *
     * @Method("GET")
     * @Route("/recent/{max}", name="_pages_recent")
     * @Template()
     */
    public function recentPagesAction($max = 3)
    {
        $documentManager    = $this->getDocumentManager();
        $documents = $documentManager->findLastPublishedPages($max);

        return array(
            'documents' => $documents,
        );
    }

    /**
     * Create a menu (embed action)
     *
     * @Method("GET")
     * @Route("/menu", name="_pages_menu")
     * @Template()
     */
    public function menuPagesAction()
    {
        $documentManager    = $this->getDocumentManager();
        $documents = $documentManager->findPublishedPages();

        return array(
            'documents' => $documents,
        );
    }

    /**
     * Returns the DocumentManager
     *
     * @return DocumentManager
     */
    protected function getDocumentManager()
    {
        return $this->get('black_page.manager.page');
    }
}
