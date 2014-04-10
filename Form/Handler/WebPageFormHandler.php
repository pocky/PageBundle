<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Black\Bundle\CommonBundle\Configuration\Configuration;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Black\Bundle\CommonBundle\Form\Handler\HandlerInterface;
use Black\Bundle\PageBundle\Model\PageInterface;

/**
 * Class WebPageFormHandler
 *
 * @package Black\Bundle\PageBundle\Form\Handler
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class WebPageFormHandler implements HandlerInterface
{
    /**
     * @var \Symfony\Component\Form\FormInterface
     */
    protected $form;
    /**
     * @var
     */
    protected $configuration;
    /**
     * @var
     */
    protected $url;

    /**
     * @param FormInterface $form
     * @param Configuration $configuration
     */
    public function __construct(
        FormInterface $form,
        Configuration $configuration
    )
    {
        $this->form             = $form;
        $this->configuration    = $configuration;
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param PageInterface $page
     *
     * @return bool|mixed|void
     */
    public function process($page)
    {
        $this->form->setData($page);

        if ('POST' === $this->configuration->getRequest()->getMethod()) {

            $this->form->handleRequest($this->configuration->getRequest());

            if ($this->form->has('delete') && $this->form->get('delete')->isClicked()) {
                return $this->onDelete($page);
            }

            if ($this->form->isValid()) {
                return $this->onSave($page);
            } else {
                return $this->onFailed();
            }
        }
    }

    /**
     * @param $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param       $route
     * @param array $parameters
     * @param       $referenceType
     *
     * @return mixed
     */
    protected function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->configuration->getRouter()->generate($route, $parameters, $referenceType);
    }

    /**
     * @param $page
     *
     * @return bool
     */
    protected function onDelete(PageInterface $page)
    {
        $this->configuration->getManager()->remove($page);
        $this->configuration->getManager()->flush();

        $this->configuration->setFlash('success', 'black.bundle.page.success.page.admin.page.delete');
        $this->setUrl($this->generateUrl($this->configuration->getParameter('route')['index']));

        return true;
    }

    /**
     * @return bool
     */
    protected function onFailed()
    {
        $this->configuration->setFlash('error', 'black.bundle.page.error.page.admin.page.not.valid');

        return false;
    }

    /**
     * @param PageInterface $page
     *
     * @return mixed
     */
    protected function onSave(PageInterface $page)
    {
        $page->upload();

        if (!$page->getId()) {
            $this->configuration->getManager()->persist($page);
        }

        $this->configuration->getManager()->flush();

        if ($this->form->get('save')->isClicked()) {
            $this->configuration->setFlash('success', 'black.bundle.page.success.page.admin.page.save');
            $this->setUrl($this->generateUrl($this->configuration->getParameter('route')['update'], array('value' => $page->getId())));

            return true;
        }

        if ($this->form->get('saveAndAdd')->isClicked()) {
            $this->configuration->setFlash('success', 'black.bundle.page.success.page.admin.page.saveAndAdd');
            $this->setUrl($this->generateUrl($this->configuration->getParameter('route')['create']));

            return true;
        }
    }
}
