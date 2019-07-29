<?php
/**
 * @package mj - PHP mini applciation for fast integration and implement
 * @version standalone
 * @author Pham Minh
 * @website http://minh.ninja
 * @github
 * 
 */

namespace mj;

define( 'MJ_PATH', __DIR__.'/');

spl_autoload_register(function($className) {

    if(strpos($className, 'mj\\') === 0){
        
        $className = substr($className, 3);
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);

        if(!file_exists(MJ_PATH . $className . '.php')){
            throw new \Exception('Invalid class '.$className);
        }
        
        require_once MJ_PATH . $className . '.php';

    }
});