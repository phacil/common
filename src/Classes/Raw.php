<?php
namespace Phacil\Common\Classes;

class Raw
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @var array
     */
    protected $bindings;

    /**
     * Raw constructor.
     * @param string $value
     * @param array|string $bindings
     */
    public function __construct($value, $bindings = [])
    {
        $this->value = (string)$value;
        $this->bindings = (array)$bindings;
    }

    public function getBindings()
    {
        return $this->bindings;
    }

    public function get(){
        
        $str = $this->value;
        
        foreach($this->bindings as $k => $v){
           $str = str_replace_first('?', $v, $str);
        }
       
        return $str;
    }
}
