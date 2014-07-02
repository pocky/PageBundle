<?php
/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Infrastructure\CQRS\Command;

use Black\DDD\DDDinPHP\Infrastructure\CQRS\CommandInterface;

/**
 * Class RemoveWebPageCommand
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
final class RemoveWebPageCommand implements CommandInterface
{
    /**
     * @var
     */
    protected $webPageId;

    /**
     * @param $webPageId
     */
    public function __construct($webPageId)
    {
        $this->webPageId    = $webPageId;
    }

    /**
     * @return mixed
     */
    public function getWebPageId()
    {
        return $this->webPageId;
    }
}