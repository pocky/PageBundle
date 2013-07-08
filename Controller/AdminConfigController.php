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
use Symfony\Component\Serializer\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Controller managing the person profile`
 *
 * @Route("/admin/config")
 */
class AdminConfigController extends Controller
{
    /**
     * Display a page form based on PageConfigType.
     *
     * @Route("/page.html", name="admin_config_page")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     *
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function pageAction()
    {
        $documentManager    = $this->getManager();
        $document           = $documentManager->findPropertyByName('Page');

        if (!$document) {
            throw $this->createNotFoundException('The property Page does not exist');
        }

        $formHandler    = $this->get('black_page.config.form.handler');
        $process        = $formHandler->process($document);

        if ($process) {
            $documentManager->updateProperty($document);

            return $this->redirect($this->generateUrl('admin_config_page'));
        }

        return array(
            'document'  => $document,
            'form'      => $formHandler->getForm()->createView()
        );
    }

    /**
     * Returns the DocumentManager
     *
     * @return DocumentManager
     */
    protected function getManager()
    {
        return $this->get('black_engine.manager.config');
    }
}
