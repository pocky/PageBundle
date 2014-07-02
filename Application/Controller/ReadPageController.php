<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Application\Controller;

use Black\Bundle\PageBundle\Infrastructure\Service\WebPageReadService;

/**
 * Class ReadPageController
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class ReadPageController
{
    /**
     * @var \Black\Bundle\PageBundle\Infrastructure\Service\WebPageReadService
     */
    protected $service;

    /**
     * @param WebPageReadService $service
     */
    public function __construct(WebPageReadService $service)
    {
        $this->service = $service;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function readPageAction($id)
    {
        $page = $this->service->read($id);

        return $page;
    }
}
