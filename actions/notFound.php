<?php

namespace mj\actions;

use mj\libraries\application as App;

class notFound extends action{
    
    public function processLogic(){
        $this->setError('Action not found.');
    }

    public function prepareContent(){
        App::_('_content', $this->loadView('system'));
    }
}