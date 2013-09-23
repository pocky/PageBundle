<?php

/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\PageBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Black\Bundle\PageBundle\Model\PageInterface;

class PageFormHandler
{
    protected $request;
    protected $form;
    protected $factory;
    protected $session;

    public function __construct(FormInterface $form, Request $request, SessionInterface $session)
    {
        $this->form     = $form;
        $this->request  = $request;
        $this->session  = $session;
    }

    public function process(PageInterface $page)
    {
        $this->form->setData($page);

        if ('POST' === $this->request->getMethod()) {

            $this->form->bind($this->request);

            if ($this->form->isValid()) {

                $page->upload();
                $this->setFlash('success', 'success.page.admin.page.edit');

                return true;
            } else {
                $this->setFlash('error', 'error.page.admin.page.not.valid');
            }
        }
    }

    public function getForm()
    {
        return $this->form;
    }

    protected function setFlash($name, $msg)
    {
        return $this->session->getFlashBag()->add($name, $msg);
    }
}
