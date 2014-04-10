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
 * Class WebPageRepositoryInferface
 *
 * @package Black\Bundle\PageBundle\Model
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
interface WebPageRepositoryInferface
{
    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getWebPageBySlug($slug);

    /**
     * @param $id
     * @return mixed
     */
    public function getWebPageById($id);

    /**
     * @param $status
     * @return mixed
     */
    public function getWebPagesByStatus($status);

    /**
     * @param      $status
     * @param null $limit
     * @return mixed
     */
    public function getWebPages($status, $limit = null);

    /**
     * @param $text
     * @return mixed
     */
    public function searchWebPage($text);

    /**
     * @param $author
     * @return mixed
     */
    public function getWebPagesByAuthor($author);
}