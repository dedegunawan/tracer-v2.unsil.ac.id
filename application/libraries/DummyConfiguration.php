<?php

/**
 *
 */
class DummyConfiguration
{
    var $known_method;
    var $known_property;
    function __construct() {
        $default_property = @func_get_arg(0);
        $default_method = @func_get_arg(1);
        $this->known_method = $default_method ? $default_method: array();
        $this->known_property = $default_property ? $default_property: array();
    }
    function __call($method_name, $args)
    {
        if (array_key_exists($method_name, $this->known_method)) {
            return call_user_func_array($this->known_method[$method_name], $args);
        }
        else {
            return '';
        }
    }
    function __get($property_name) {
        if (array_key_exists($property_name, $this->known_property)) {
            return $this->known_property[$property_name];
        }
        else {
            return '';
        }
    }
    function __set($property_name, $value) {
        $this->known_property[$property_name] = $value;
    }
}

 ?>
