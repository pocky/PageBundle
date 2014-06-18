<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Application\Form\Handler;

use Black\Bundle\PageBundle\Application\Command\Bus\CreateWebPageBus;
use Black\Bundle\PageBundle\Domain\Model\WebPageInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Black\Bundle\CommonBundle\Application\Form\Handler\HandlerInterface;

/**
 * Class WebPageFormHandler
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class WebPageFormHandler implements HandlerInterface
{
    /**
     * @var \Symfony\Component\Form\FormInterface
     */
    protected $form;

    /**
     * @var null|\Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var \Black\Bundle\PageBundle\Application\Command\Bus\CreateWebPageBus
     */
    protected $bus;

    /**
     * @param FormInterface    $form
     * @param RequestStack     $requestStack
     * @param CreateWebPageBus $bus
     */
    public function __construct(
        FormInterface $form,
        RequestStack $requestStack,
        CreateWebPageBus $bus
    ) {
        $this->form    = $form;
        $this->request = $requestStack->getCurrentRequest();
        $this->bus     = $bus;
    }

    /**
     * @param WebPageInterface $webPage
     *
     * @return bool
     */
    public function process(WebPageInterface $webPage)
    {
        $this->form->setData($webPage);

        if ('POST' === $this->request->getMethod()) {
            $this->form->handleRequest($this->request);

            if ($this->form->isValid()) {
                return $this->execute($webPage);
            }

            return $this->stop();
        }
    }

    /**
     * @param WebPageInterface $webPage
     *
     * @return mixed
     */
    public function execute(WebPageInterface $webPage)
    {
        $page = $this->bus->handle($webPage);

        return $page;
    }

    /**
     * @return bool
     */
    public function stop()
    {
        return false;
    }
}
