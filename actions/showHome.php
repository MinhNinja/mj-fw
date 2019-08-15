<?php

namespace mj\actions;

use mj\libraries\application as App;
use mj\libraries\action;

/**
 * if not logged, force to redirect before move to next action
 */
class showHome extends action{

    public function prepareContent(){
        App::_('_content', $this->loadView('home'));
    }
}