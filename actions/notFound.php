<?php

namespace mj\actions;

use mj\libraries\application as App;
use mj\libraries\action;

class notFound extends action{
    
    public function processLogic(){
        $this->setError('Action not found.');
    }

    public function prepareContent(){
        App::_('_content', $this->loadView('system'));
    }
}