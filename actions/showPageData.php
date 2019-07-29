<?php

namespace mj\actions;

use mj\libraries\application as App;

/**
 * if not logged, force to redirect before move to next action
 */
class showPageData extends action{

    public function processLogic(){

        $getData = App::use('input')->get()->all();
        $postData = App::use('input')->post()->all();
        $urlData = App::use('input')->url()->all();
        $this->vars(compact('getData', 'urlData', 'postData'));
    }

    public function prepareContent(){
        App::_('_content', $this->loadView('page.demo'));
    }
}