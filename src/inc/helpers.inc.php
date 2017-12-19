<?php

use Phacil\Common\Classes\Raw;

/**
 * 
 * @return \Phacil\Integration\Pagination\Raw
 */
function raw($value, $bindings = null){
    return new Raw($value, $bindings);
}


