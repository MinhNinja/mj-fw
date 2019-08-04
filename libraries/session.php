<?php

namespace mj\libraries;

use mj\libraries\application as App;

class session{

    public function set($key, $value){
        $_SESSION[$key] = $value;
    }

    public function get($key){
        return isset($_SESSION[$key]) ? $_SESSION[$key] : '';
    }

    public function getOnce($key){
        $tmp = $this->get($key);
        $this->set($key, null);
        return $tmp;
    }
}