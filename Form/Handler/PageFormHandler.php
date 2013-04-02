<?php

/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Blackroom\Bundle\PageBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Blackroom\Bundle\PageBundle\Model\PageInterface;

class PageFormHandler
{
    protected $request;
    protected $form;
    protected $factory;
    protected $session;
    protected $manager;

    public function __construct(FormInterface $form, Request $request, SessionInterface $session, ManagerRegistry $manager)
    {
        $this->form     = $form;
        $this->request  = $request;
        $this->session  = $session;
        $this->manager  = $manager->getManager();
    }

    public function process(PageInterface $page)
    {
        $this->form->setData($page);

        if ('POST' === $this->request->getMethod()) {

            $this->form->bind($this->request);

            if ($this->form->isValid()) {

                $page->upload();
                $this->setFlash('success', $page->getName() . ' was successfully updated!');

                return true;
            } else {
                $this->setFlash('failure', 'The form is not valid');
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