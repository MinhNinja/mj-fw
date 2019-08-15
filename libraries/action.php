<?php

namespace mj\libraries;

use mj\libraries\application as App;

class action{

    // context of current action
    protected $task;
    public function __construct($task){
        $this->task = $task;
    }

    public function vars( $sth ){

        $_vars = App::_('_content_vars');
        if( is_array($_vars )){
            $_vars = array_merge($_vars, $sth);
        } else {
            $_vars = $sth;
        }
        App::_('_content_vars', $_vars);
    }

    public function processLogic(){
        // fill $vars here
    }

    public function prepareContent(){
        // load view and fill vars
    }

    protected $redirect;
    public function getRedirect(){
        return empty($this->redirect) ? '' : $this->redirect;
    }

    protected $continue;
    public function processResult(){
        return ( $this->continue === null || $this->continue === true );
    }

    public function loadView($view){

        $_vars = App::_('_content_vars');
        if(is_array($_vars)) extract($_vars);

        ob_start();
        include MJ_PATH. 'views/'. str_replace('.', '/', $view) . '.php';
        $res = ob_get_clean();
        return $res;
    }

    public function setMsg($msg, $redirect = '', $type = 'info'){
        
        $this->vars([
            '_msg' => $msg,
            '_msg_type' => $type
        ]);

        $this->continue = false;

        if( !empty($redirect) ){
            //* use session to send message with user
            if( App::userId() ){
                $this->redirect = $redirect;
                App::use('ss')->set('_msg', $msg);
                App::use('ss')->set('_msg_type', $type);

            } else {
                $last = substr($redirect, -1);
                $msg = base64_encode($msg);
                if( $last == '?' ) $this->redirect = $redirect.'msg='. $msg;
                else $this->redirect = $redirect.'?msg='. $msg;
            }
        }

        return false;
    }

    public function setError($msg, $redirect = ''){
        return $this->setMsg($msg, $redirect, 'warning');
    }

    /**
     * content_type:
     * https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/MIME_types/Complete_list_of_MIME_types
     * 
     */

    public function export($file_name, $content_type, $content){

        header("Expires: 0");
        header("Cache-Control: no-cache, no-store, must-revalidate"); 
        header('Cache-Control: pre-check=0, post-check=0, max-age=0', false); 
        header("Pragma: no-cache");	
        header("Content-type: {$content_type}");
        header("Content-Disposition:attachment; filename={$file_name}");
        header("Content-Type: application/force-download");

        echo $content; //readfile("{$file_url}");
        exit();
    }
}