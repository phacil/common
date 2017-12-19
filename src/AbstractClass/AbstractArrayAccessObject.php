<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Phacil\Common\AbstractClass;

/**
 * Description of AbstractArrayAccessObject
 *
 * @author alisson
 */
abstract class AbstractArrayAccessObject implements \ArrayAccess
{
    protected $container;
    
    abstract protected function container();

    public function offsetExists($offset)
    {
        return isset($this->{$this->container}[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->{$this->container}[$offset]) ? $this->elements[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset))
        {
            $this->{$this->container}[] = $value;
        } else
        {
            $this->elements[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {

        unset($this->{$this->container}[$offset]);
    }
}
