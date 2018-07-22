<?php

require 'vendor/autoload.php';

$col = collection(['User'=>['nome'=>'Alisson'],2,3]);

//unset($col['User']['nome']);

//$col['User']['nome'] = 'dasdasda';

//isset($col['User']['nome']);

pr($col->getElements());
//
//$Col = collection(['User'=>['nome'=>'Alisson'],2,3])->filter(function($item){
//    return $item > 1;
//})->getElements();
//
//foreach($Col as $elem):
//    echo $elem;
//endforeach;