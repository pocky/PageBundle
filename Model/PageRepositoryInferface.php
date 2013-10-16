<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Model;

/**
 * Class PageRepositoryInferface
 *
 * @package Black\Bundle\PageBundle\Model
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
interface PageRepositoryInferface
{
    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getPageBySlug($slug);

    /**
     * @param $id
     * @return mixed
     */
    public function getPageById($id);

    /**
     * @param $status
     * @return mixed
     */
    public function getPagesByStatus($status);

    /**
     * @param      $status
     * @param null $limit
     * @return mixed
     */
    public function getPages($status, $limit = null);

    /**
     * @param $text
     * @return mixed
     */
    public function searchPage($text);

    /**
     * @param $author
     * @return mixed
     */
    public function getPagesByAuthor($author);
}
