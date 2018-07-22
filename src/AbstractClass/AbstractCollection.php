<?php

namespace Phacil\Common\AbstractClass;

abstract class AbstractCollection implements \IteratorAggregate, \Countable {

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

    //protected $elements = [];
    protected $type;
    protected $final = false;
    protected $elements = [];

    public function __construct(Array $array = [])
    {

        $final = $this->final;
        $this->final = false;
        foreach ($array as $key => $value)
        {
            $this->set($key, $value);
        }
        $this->final = $final;
        return $this;
    }

    protected function checkType($type, $value)
    {
        switch ($type)
        {
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
        $this->checkFinal();
        if ($arg2 && array_key_exists($arg1, $this->elements))
        {
            throw new Exception('key already exists!');
        } else
        {
            $this->set($arg1, $arg2);
        }

        return $this;
    }

    protected function clean()
    {
        $this->checkFinal();
        $this->elements = [];
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

    //Checking if the collection is empty or not
    public function isEmpty()
    {
        if ($this->count() < 1)
        {
            return true;
        }

        return false;
    }

    //Checking if a given object exists in collection
    public function contains($obj)
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

    public function getElements()
    {
        return $this->elements;
    }

    public function checkFinal()
    {
        if ($this->final)
        {
            throw new \Exception("This collection doesn't support new elements");
        }
    }

    public function get($key)
    {
        $parsed = explode('.', $key);
        $find = true;
        $result = $this->elements;
        while ($parsed)
        {
            $next = array_shift($parsed);
            if (isset($result[$next]))
            {
                $result = $result[$next];
            } else
            {
                $find = false;
                break;
            }
        }

        if ($find)
        {
            return $result;
        } else
        {
            trigger_error('Key doesn\t exists');
        }
    }

    public function set($key, $value)
    {
        $this->checkFinal();
        $parsed = explode('.', $key);
        $result = & $this->elements;
        while (count($parsed) > 1)
        {
            $next = array_shift($parsed);
            if (!isset($result[$next]) || !is_array($result[$next]))
            {
                $result[$next] = [];
            }
            $result = & $result[$next];
        }

        if (func_num_args() == 1)
        {
            if ($this->checkType($this->type, $key))
            {
                $result[] = array_shift($parsed);
            } else
            {
                throw new \Exception('valor ' . $key . ' não condiz com o tipo ' . $this->type);
            }
        } else
        {
            if ($this->checkType($this->type, $key))
            {
                $result[array_shift($parsed)] = $value;
            } else
            {
                throw new \Exception('valor referente a chave ' . $key . ' não condiz com o tipo ' . $this->type);
            }
        }

        //$result[array_shift($parsed)] = $value;
        return $this;
    }

    public function check($key)
    {
        $parsed = explode('.', $key);
        $find = true;
        $result = $this->elements;
        while ($parsed)
        {
            $next = array_shift($parsed);
            if (isset($result[$next]))
            {
                $result = $result[$next];
            } else
            {
                return false;
            }
        }
        return true;
    }

    public function delete($key)
    {
        $this->checkFinal();
        $parsed = explode('.', $key);
        $result = & $this->elements;
        while (count($parsed) > 1)
        {
            $next = array_shift($parsed);
            if (!isset($result[$next]) || !is_array($result[$next]))
            {
                $result[$next] = [];
            }
            $result = & $result[$next];
        }
        unset($result[array_shift($parsed)]);
        return $this;
    }

}
