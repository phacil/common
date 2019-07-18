<?php

require '../vendor/autoload.php';

$col = phacil\collection(['User'=>['nome'=>'Alisson'],2,3]);

//unset($col['User']['nome']);

//$col['User']['nome'] = 'dasdasda';

//isset($col['User']['nome']);

phacil\pr($col->getElements());
//
//$Col = collection(['User'=>['nome'=>'Alisson'],2,3])->filter(function($item){
//    return $item > 1;
//})->getElements();
//
//foreach($Col as $elem):
//    echo $elem;
//endforeach;

class Enum extends \Phacil\Common\AbstractClass\AbstractEnum{

    const TESTE = 'teste';
    const TESTE2 = 'teste2';

}

phacil\pr(new Enum('TESTE'));
phacil\pr(Enum::toArray());
phacil\pr(Enum::toList());
phacil\pr(Enum::toListKeys());
phacil\pr(new Enum(2));