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
 * @Route("/admin/page")
 */
class AdminPageController extends Controller
{
    /**
     * Show lists of Persons
     *
     * @Method("GET")
     * @Route("/index.html", name="admin_page_index")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function indexAction()
    {
        $documentManager    = $this->getManager();
        $repository         = $documentManager->getRepository();

        $rawDocuments       = $repository->findAll();
        $csrf               = $this->container->get('form.csrf_provider');

        $documents = array();

        foreach ($rawDocuments as $document) {

            $documents[] = array(
                'id'                         => $document->getId(),
                'page.admin.page.name.text'  => $document->getName()
            );
        }

        return array(
            'documents' => $documents,
            'csrf'      => $csrf
        );
    }

    /**
     * Displays a form to create a new Person document.
     *
     * @Method({"GET", "POST"})
     * @Route("/new", name="admin_page_new")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function newAction()
    {
        $documentManager    = $this->getManager();
        $document           = $documentManager->createInstance();
        $document->setStatus('draft');

        $formHandler    = $this->get('black_page.page.form.handler');
        $process        = $formHandler->process($document);

        if ($process) {
            $documentManager->persist($document);
            $documentManager->flush();

            return $this->redirect($this->generateUrl('admin_page_edit', array('id' => $document->getId())));
        }

        return array(
            'document'  => $document,
            'form'      => $formHandler->getForm()->createView()
        );
    }

    /**
     * Displays a form to edit an existing Person document.
     *
     * @Method({"GET", "POST"})
     * @Route("/{id}/edit", name="admin_page_edit")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     *
     * @param string $id The document ID
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
            throw $this->createNotFoundException('Unable to find Person document.');
        }

        if (false === $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            if (true === $document->isPrivate() && $document->getAuthor() != $this->getUser()) {
                throw new AccessDeniedException();
            }
        }

        $deleteForm = $this->createDeleteForm($id);

        $formHandler    = $this->get('black_page.page.form.handler');
        $process        = $formHandler->process($document);

        if ($process) {
            $documentManager->flush();

            return $this->redirect($this->generateUrl('admin_page_edit', array('id' => $id)));
        }

        return array(
            'document'      => $document,
            'form'          => $formHandler->getForm()->createView(),
            'delete_form'   => $deleteForm->createView()
        );
    }

    /**
     * Deletes a Page document.
     *
     * @Method({"POST", "GET"})
     * @Route("/{id}/delete/{token}", name="admin_page_delete")
     * @Secure(roles="ROLE_ADMIN")
     *
     * @param string $id The document ID
     * @param null $token
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction($id, $token = null)
    {
        $form       = $this->createDeleteForm($id);
        $request    = $this->getRequest();

        $form->bind($request);

        if (null !== $token) {
            $token = $this->get('form.csrf_provider')->isCsrfTokenValid('delete' . $id, $token);
        }

        if ($form->isValid() || true === $token) {

            $dm         = $this->getManager();
            $repository = $dm->getRepository();
            $document   = $repository->findOneById($id);

            if (!$document) {
                throw $this->createNotFoundException('Unable to find Person document.');
            }

            $dm->remove($document);
            $dm->flush();

            $this->get('session')->getFlashBag()->add('success', 'success.page.admin.page.delete');

        } else {
            $this->getFlashBag->add('error', 'error.page.admin.page.not.valid');
        }

        return $this->redirect($this->generateUrl('admin_persons'));
    }

    /**
     * Batch action for 1/n document.
     *
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
            $this->get('session')->getFlashBag()->add('error', 'error.page.admin.page.no.item');
            return $this->redirect($this->generateUrl('admin_persons'));
        }

        if (!$action = $request->get('batchAction')) {
            $this->get('session')->getFlashBag()->add('error', 'error.page.admin.page.no.action');
            return $this->redirect($this->generateUrl('admin_persons'));
        }

        if (!method_exists($this, $method = $action . 'Action')) {
            throw new Exception\InvalidArgumentException(
                sprintf('You must create a "%s" method for action "%s"', $method, $action)
            );
        }

        if (false === $token) {
            $this->get('session')->getFlashBag()->add('error', 'error.page.admin.page.csrf');

            return $this->redirect($this->generateUrl('admin_persons'));
        }

        foreach ($ids as $id) {
            $this->$method($id, $token);
        }

        return $this->redirect($this->generateUrl('admin_persons'));

    }

    private function createDeleteForm($id)
    {
        $form = $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm();

        return $form;
    }

    /**
     * Returns the DocumentManager
     *
     * @return DocumentManager
     */
    protected function getManager()
    {
        return $this->get('black_page.manager.page');
    }
}
