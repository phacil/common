<?php

namespace Phacil\Common\AbstractClass;

abstract class AbstractCollection extends AbstractArrayAccessObject implements \IteratorAggregate, \Countable, \ArrayAccess
{
    protected $elements = [];
    protected $type;

    public function __construct(Array $array = [])
    {
        $this->type();
        $this->container();
        foreach ($array as $key => $value)
        {
            $this->set($key, $value);
        }
        return $this;
    }

    abstract public function type($type = null);
    
    protected function container(){
        $this->container = 'elements';
    }

    protected function checkType($type, $value)
    {
        switch ($type) {
            case 'array':
                return is_array($value);
            case 'bool':
            case 'boolean':
                return is_bool($value);
            case 'callable':
                return is_callable($value);
            case 'float':
            case 'double':
                return is_float($value);
            case 'int':
            case 'integer':
                return is_int($value);
            case 'null':
                return is_null($value);
            case 'numeric':
                return is_numeric($value);
            case 'object':
                return is_object($value);
            case 'resource':
                return is_resource($value);
            case 'scalar':
                return is_scalar($value);
            case 'string':
                return is_string($value);
            case 'mixed':
                return true;
            default:
                return ($value instanceof $type);
        }
    }

    public function add($arg1, $arg2 = null)
    {
        if ($arg2 && array_key_exists($arg1, $this->elements))
        {
            throw new Exception('key already exists!');
        } else
        {
            $this->set($arg1, $arg2);
        }

        return $this;
    }

    public function remove($key)
    {
        if (array_key_exists($key, $this->elements))
        {
            unset($this->elements[$key]);
            return $this;
        }
    }

    //Checking if the cursor is at a valid item
    public function check()
    {
        
    }

    //Returning object for given posistion
    public function get($key)
    {
        return $this->elements[$key];
    }

    public function set($arg1, $arg2 = null)
    {
        if (!$arg2)
        {
            if ($this->checkType($this->type, $arg1))
            {
                $this->elements[] = $arg1;
            } else
            {
                throw new \Exception('valor ' . $arg1 . ' não condiz com o tipo ' . $this->type);
            }
        } else
        {
            if ($this->checkType($this->type, $arg2))
            {
                $this->elements[$arg1] = $arg2;
            } else
            {
                throw new \Exception('valor referente a chave ' . $arg1 . ' não condiz com o tipo ' . $this->type);
            }
        }

        return $this;
    }

    public function filter(callable $function)
    {
        $class = get_class($this);
        return new $class(array_filter($this->elements, $function));
    }

    public function each(callable $function)
    {

        foreach ($this->elements as $value)
        {
            $function($value);
        }
        return $this;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->elements);
    }

    public function count()
    {
        return count($this->elements);
    }

}
