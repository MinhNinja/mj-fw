<?php

namespace mj\actions;

use mj\libraries\action;

/**
 * process before main Action
 */
class beforeProcess extends action{

    public function processLogic(){

        $moreInfo = 'More Info get initalized';
        $this->vars(compact('moreInfo'));
    }
}