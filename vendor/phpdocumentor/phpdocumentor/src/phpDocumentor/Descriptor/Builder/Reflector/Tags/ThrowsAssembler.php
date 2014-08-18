<?php
/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @copyright 2010-2014 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Descriptor\Builder\Reflector\Tags;

use phpDocumentor\Descriptor\Builder\Reflector\AssemblerAbstract;
use phpDocumentor\Descriptor\Tag\ThrowsDescriptor;
use phpDocumentor\Reflection\DocBlock\Tag\ThrowsTag;
use phpDocumentor\Reflection\DocBlock\Type\Collection;

class ThrowsAssembler extends AssemblerAbstract
{
    /**
     * Creates a new Descriptor from the given Reflector.
     *
     * @param ThrowsTag $data
     *
     * @return ThrowsDescriptor
     */
    public function create($data)
    {
        $descriptor = new ThrowsDescriptor($data->getName());
        $descriptor->setDescription($data->getDescription());
        $descriptor->setTypes(
            $this->builder->buildDescriptor(new Collection($data->getTypes()))
        );

        return $descriptor;
    }
}
