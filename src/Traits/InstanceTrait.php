<?php

namespace Phacil\Common\Traits;

trait InstanceTrait {
    
    private static $instance = null;    
    
    public static function getInstance() {
        return self::$instance;
    }

    public static function setInstance($instance) {
        self::$instance = $instance;
    }
}
