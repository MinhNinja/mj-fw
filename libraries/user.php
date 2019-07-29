<?php

namespace mj\libraries;

use mj\config;

class user{

    public static function getInstance(){
        
        if( empty(config::$classUser) ){

            $user = new \StdClass;
            $user->ID = 0;
            $user->name = 'guest';
            $user->logged_at = date('Y-m-d H:i:s');
            return $user;
        }
        
        $check = str_replace('\\', DIRECTORY_SEPARATOR, config::$classUser);

        if( file_exists(MJ_PATH . $check . '.php')){

            $className = 'mj\\'.config::$classUser;
            return new $className;

        } else {

            throw new \Exception('Class not found '.$check);
        }
    }
}