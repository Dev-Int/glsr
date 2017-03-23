<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Helper;

/**
 * Description of Entity
 *
 * @author Laurent
 */
abstract class Entity
{
    abstract protected function testReturnParam(Entity $entity, $entityName);
}
