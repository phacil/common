<?php

namespace Phacil\Common\AbstractClass;

abstract class AbstractCollection extends AbstractArrayAccessObject implements \IteratorAggregate, \Countable, \ArrayAccess {

    const TYPE_ARRAY = 'array';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_CALLABLE = 'callable';
    const TYPE_FLOAT = 'float';
    const TYPE_INTEGER = 'integer';
    const TYPE_NULL = 'null';
    const TYPE_NUMERIC = 'numeric';
    const TYPE_OBJECT = 'object';
    const TYPE_SCALAR = 'scalar';
    const TYPE_STRING = 'string';
    const TYPE_MIXED = 'mixed';

    protected $elements = [];
    protected $type;
    protected $final = false;

    public function __construct(Array $array = []) {
        
        $final = $this->final;
        $this->final = false;
        foreach ($array as $key => $value) {
            $this->set($key, $value);
        }
        $this->final = $final;
        return $this;
    }

    protected function container() {
        $this->container = 'elements';
    }

    protected function checkType($type, $value) {
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

    public function add($arg1, $arg2 = null) {
        $this->checkFinal();
        if ($arg2 && array_key_exists($arg1, $this->elements)) {
            throw new Exception('key already exists!');
        } else {
            $this->set($arg1, $arg2);
        }

        return $this;
    }

    public function remove($key) {
        if (array_key_exists($key, $this->elements)) {
            unset($this->elements[$key]);
            return $this;
        }
    }

//Checking if the cursor is at a valid item
    public function check() {
        if (!is_null($this->key())) {
            return true;
        } else {
            return false;
        }
    }

//Returning object for given posistion
    public function get($key) {
        return $this->elements[$key];
    }

    public function set($arg1, $arg2 = null) {
        $this->checkFinal();
        if (!$arg2) {
            if ($this->checkType($this->type, $arg1)) {
                $this->elements[] = $arg1;
            } else {
                throw new \Exception('valor ' . $arg1 . ' não condiz com o tipo ' . $this->type);
            }
        } else {
            if ($this->checkType($this->type, $arg2)) {
                $this->elements[$arg1] = $arg2;
            } else {
                throw new \Exception('valor referente a chave ' . $arg1 . ' não condiz com o tipo ' . $this->type);
            }
        }

        return $this;
    }

    public function filter(callable $function) {
        $class = get_class($this);
        return new $class(array_filter($this->elements, $function));
    }

    public function each(callable $function) {

        foreach ($this->elements as $value) {
            $function($value);
        }
        return $this;
    }

    public function getIterator() {
        return new \ArrayIterator($this->elements);
    }

    public function count() {
        return count($this->elements);
    }

    //Checking if the collection is empty or not
    public function isEmpty() {
        if ($this->count() < 1) {
            return true;
        }

        return false;
    }

    //Checking if a given object exists in collection
    public function contains($obj) {
        foreach ($this->array_elements as $element) {
            if ($element === $obj) {
                $this->rewind();
                return true;
            }
        }
        $this->rewind();
        return false;
    }
    
    public function getElements() {
        return $this->elements;
    }
    
    public function checkFinal(){
        if($this->final){
            throw new \Exception("This collection doesn't support new elements");
        }
    }

}
