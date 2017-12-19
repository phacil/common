<?php

namespace Phacil\Common\Classes;

/**
 * Description of Collection
 *
 * @author alisson
 */
class Collection implements Iterator, ArrayAccess
{
    //The array
    private $array_elements = [];
    
    //Adding an object into a collection
    function add($arg1, $arg2 = false)
    {
        if (!$arg2)
        {
            $this->array_elements[] = $arg1;
        } else
        {
            if (!array_key_exists($arg1, $this->array_elements))
            {
                $this->array_elements[$arg1] = $arg2;
            }
        }
        $this->count();
        return $this;
    }

    //Getting the length of the array
    function count()
    {
        $this->lenght = count($this->array_elements);
        return $this->lenght;
    }

    //Removing a specified kye
    function remove($key)
    {
        if (array_key_exists($key, $this->array_elements))
        {
            unset($this->array_elements[$key]);
            $this->count();
            return $this;
        }
    }

    //Checking if the cursor is at a valid item
    function valid()
    {
        if (!is_null($this->key()))
        {
            return true;
        } else
        {
            return false;
        }
    }

    //Returning object for given posistion
    function get($key)
    {
        return $this->array_elements[$key];
    }

    //Checking if the collection is empty or not
    function isEmpty()
    {
        if ($this->count() < 1)
            return true;
        else
            return false;
    }

    //Checking if a given object exists in collection
    function contains($obj)
    {
        foreach ($this->array_elements as $element)
        {
            if ($element === $obj)
            {
                $this->rewind();
                return true;
            }
        }
        $this->rewind();
        return false;
    }
}