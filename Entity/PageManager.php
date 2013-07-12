<?php
/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Entity;

use Black\Bundle\PageBundle\Model\PageManagerInterface;
use Black\Bundle\PageBundle\Entity\BaseManager;

class PageManager extends BaseManager implements PageManagerInterface
{
    public function findPageBySlug($slug)
    {
        return $this->getRepository()->getPageBySlug($slug);
    }

    public function findPageById($id)
    {
        return $this->getRepository()->getPageByid($id);
    }

    public function findDraftPages()
    {
        return $this->getRepository()->getPagesByStatus('draft');
    }

    public function findPublishedPages()
    {
        return $this->getRepository()->getPagesByStatus('publish');
    }

    public function findLastPublishedPages($limit = 3)
    {
        return $this->getRepository()->getPages('publish', $limit);
    }

    public function findLastDraftPages($limit = 3)
    {
        return $this->getRepository()->getPages('draft', $limit);
    }
}
