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
 * Class CreateWebPageFormHandler
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class CreateWebPageFormHandler extends WebPageFormHandler
{

}
