<?php

namespace Phacil\Common\Classes;

class Reflective {

    /**
     * Return class of Object
     * @param type $object
     * @param type $with_namespaces
     */
    static public function className($object, $with_namespaces = false)
    {
        $classNameWithNamespaces = get_class($object);
        if (!$with_namespaces)
        {
            $name = explode('\\', $classNameWithNamespaces);
            return end($name);
        }
        return $classNameWithNamespaces;
    }

}
