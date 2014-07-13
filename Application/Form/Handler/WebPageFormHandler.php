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
use Black\Bundle\PageBundle\Application\DTO\WebPageDTO;
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
     * @param FormInterface    $form
     * @param RequestStack     $requestStack
     */
    public function __construct(
        FormInterface $form,
        RequestStack $requestStack
    ) {
        $this->form    = $form;
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @return bool|mixed
     */
    public function process()
    {
        if ('POST' === $this->request->getMethod()) {
            $this->form->handleRequest($this->request);

            if ($this->form->isValid()) {
                return $this->form->getData();
            }

            return $this->stop();
        }
    }

    /**
     * @return bool
     */
    public function stop()
    {
        return false;
    }
}
