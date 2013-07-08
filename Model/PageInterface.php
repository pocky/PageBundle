<?php
/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\PageBundle\Model;

interface PageInterface
{
    function computeEtag();
    function getStatusPublication();
    
    function getId();
    
    function setAbout($about);
    function getAbout();
    
    function setAuthor($author);
    function getAuthor();
    
    function setDatePublished($datePublished);
    function getDatePublished();
    
    function setImage($image);
    function getImage();
    
    function setStatus($status);
    function getStatus();
    
    function setText($text);
    function getText();
    
    function setPrimaryImageOfPage($primaryImageOfPage);
    function getPrimaryImageOfPage();
    
    static function getStatusEnabled();
    
    function setEnabled($enabled);
    function getEnabled();
    
    function isPublic();
    function isProtected();
    function isPrivate();
    
    function getRouteName();
    function upload();
    
    function getAbsolutePath();
    function getWebPath();
    function getUploadDir();
}
