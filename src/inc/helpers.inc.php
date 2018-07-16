<?php

use Phacil\Common\Classes\Raw;
use Phacil\Common\Classes\Collection;

/**
 * 
 * @param type $value
 * @param type $bindings
 * @return Raw
 */

function raw($value, $bindings = null){
    return new Raw($value, $bindings);
}

/**
 * 
 * @param array $elements
 * @return Collection
 */
function collection(Array $elements){
    return new Collection($elements);
}