<?php

namespace mj\actions\admin;

use mj\libraries\application as App;
use mj\languages\text as Txt;
use mj\actions\action;

class testAdmin extends action{

    public function processLogic(){
        //
    }

    public function prepareContent(){
        App::_('_content', 
            'This demo show how to use Subfolder for Action'.
            $this->loadView('widget.demo_links')
        );
    }
}