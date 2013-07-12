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
    public function computeEtag();
    
    public function getId();
    
    public function getAbout();
    
    public function getAuthor();
    
    public function getDatePublished();
    
    public function getImage();
    
    public function getStatus();
    
    public function getText();
    
    public function getPrimaryImageOfPage();
    
    public function getEnabled();
    
    public function isPublic();
    public function isProtected();
    public function isPrivate();
    
    public function getRouteName();
    public function upload();
    
    public function getAbsolutePath();
    public function getWebPath();
    public function getUploadDir();
}
