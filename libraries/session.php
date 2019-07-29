<?php

namespace mj\libraries;

use mj\libraries\application as App;

class session{

    public function set($key, $value){
        $_SESSION[$key] = $value;
    }

    public function get($key, $format = ''){
        return App::use('input')->session()->find($key, $format);
    }

    public function getOnce($key, $format = ''){
        $tmp = $this->get($key, $format);
        $this->set($key, null);
        return $tmp;
    }
}