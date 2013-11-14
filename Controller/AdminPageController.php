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

use Black\Bundle\PageBundle\Exception\PageNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class AdminPageController
 *
 * @Route("/admin/page")
 *
 * @package Black\Bundle\PageBundle\Controller
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class AdminPageController extends Controller
{
    /**
     * @Method("GET")
     * @Route("/index.html", name="admin_page_index")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     * 
     * @return array
     */
    public function indexAction()
    {
        $csrf               = $this->container->get('form.csrf_provider');

        $keys = array(
            'id',
            'black.bundle.admin.controller.adminPage.index.text',
        );

        return array(
            'keys'      => $keys,
            'csrf'      => $csrf
        );
    }

    /**
     * @Method("GET")
     * @Route("/list.json", name="admin_pages_json")
     * @Secure(roles="ROLE_ADMIN")
     * 
     * @return Response
     */
    public function ajaxListAction()
    {
        $manager       = $this->getManager();
        $repository    = $manager->getRepository();
        $rawDocuments  = $repository->findAll();

        $documents = array('aaData' => array());

        foreach ($rawDocuments as $document) {
            $documents['aaData'][] = array(
                $document->getId(),
                $document->getName(),
                null
            );
        }
        return new Response(json_encode($documents));
    }

    /**
     * @Method({"GET", "POST"})
     * @Route("/new", name="admin_page_new")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()\
     * 
     * @return array
     */
    public function newAction()
    {
        $documentManager    = $this->getManager();
        $document           = $documentManager->createInstance();
        $document->setStatus('draft');
        $document->setEnabled('public');
        $document->setDatePublished(new \DateTime());

        $formHandler    = $this->get('black_page.page.form.handler');
        $process        = $formHandler->process($document);

        if ($process) {
            return $this->redirect($formHandler->getUrl());
        }

        return array(
            'document'  => $document,
            'form'      => $formHandler->getForm()->createView()
        );
    }

    /**
     * @param string $id The document ID
     *
     * @Method({"GET", "POST"})
     * @Route("/{id}/edit", name="admin_page_edit")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @throws AccessDeniedException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function editAction($id)
    {
        $documentManager    = $this->getManager();
        $repository         = $documentManager->getRepository();

        $document = $repository->findOneById($id);

        if (!$document) {
            throw new PageNotFoundException();
        }

        if (false === $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            if (true === $document->isPrivate() && $document->getAuthor() != $this->getUser()) {
                throw new AccessDeniedException();
            }
        }

        $formHandler    = $this->get('black_page.page.form.handler');
        $process        = $formHandler->process($document);

        if ($process) {
            return $this->redirect($formHandler->getUrl());
        }

        return array(
            'document'      => $document,
            'form'          => $formHandler->getForm()->createView()
        );
    }

    /**
     * @param      $id
     * @param null $token
     *
     * @Method({"POST", "GET"})
     * @Route("/{id}/delete/{token}", name="admin_page_delete")
     * @Secure(roles="ROLE_ADMIN")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction($id, $token = null)
    {
        $form       = $this->createDeleteForm($id);
        $request    = $this->getRequest();

        $form->handleRequest($request);

        if (null !== $token) {
            $token = $this->get('form.csrf_provider')->isCsrfTokenValid('delete', $token);
        }

        if ($form->isValid() || true === $token) {

            $dm         = $this->getManager();
            $repository = $dm->getRepository();
            $document   = $repository->findOneById($id);

            if (!$document) {
                throw $this->createNotFoundException('Unable to find this document.');
            }

            $dm->remove($document);
            $dm->flush();

            $this->get('session')->getFlashBag()->add('success', 'black.bundle.page.success.page.admin.page.delete');

        } else {
            $this->getFlashBag->add('error', 'black.bundle.page.error.page.admin.page.not.valid');
        }

        return $this->redirect($this->generateUrl('admin_page_index'));
    }

    /**
     * @Method({"POST"})
     * @Route("/batch", name="admin_page_batch")
     *
     * @return array
     *
     * @throws \Symfony\Component\Serializer\Exception\InvalidArgumentException If method does not exist
     */
    public function batchAction()
    {
        $request    = $this->getRequest();
        $token      = $this->get('form.csrf_provider')->isCsrfTokenValid('batch', $request->get('token'));

        if (!$ids = $request->get('ids')) {
            $this->get('session')->getFlashBag()->add('error', 'black.bundle.page.error.page.admin.page.no.item');

            return $this->redirect($this->generateUrl('admin_page_index'));
        }

        if (!$action = $request->get('batchAction')) {
            $this->get('session')->getFlashBag()->add('error', 'black.bundle.page.error.page.admin.page.no.action');

            return $this->redirect($this->generateUrl('admin_page_index'));
        }

        if (!method_exists($this, $method = $action . 'Action')) {
            throw new Exception\InvalidArgumentException(
                sprintf('You must create a "%s" method for action "%s"', $method, $action)
            );
        }

        if (false === $token) {
            $this->get('session')->getFlashBag()->add('error', 'black.bundle.page.error.page.admin.page.csrf');

            return $this->redirect($this->generateUrl('admin_page_index'));
        }

        foreach ($ids as $id) {
            $this->$method($id, $this->get('form.csrf_provider')->generateCsrfToken('delete'));
        }

        return $this->redirect($this->generateUrl('admin_page_index'));
    }

    /**
     * @param $id
     *
     * @return \Symfony\Component\Form\Form
     */
    protected function createDeleteForm($id)
    {
        $form = $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm();

        return $form;
    }

    /**
     * @return DocumentManager
     */
    protected function getManager()
    {
        return $this->get('black_page.manager.page');
    }
}
