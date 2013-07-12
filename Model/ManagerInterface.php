<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Black\Bundle\PageBundle\Model;

/**
 *
 * @author dallas62
 */
interface ManagerInterface
{
    /**
     * @return mixed
     */
    public function getManager();
    
    /**
     * @return mixed
     */
    public function getRepository();
    
    /**
     * @return mixed
     */
    public function createInstance();
}
