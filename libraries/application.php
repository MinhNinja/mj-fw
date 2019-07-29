<?php

namespace mj\libraries;

use mj\languages\text as Txt;

use mj\config;

class application{

    private static $storage;
    private static $factory;
    private static $loaded;

    public static function _($key, $sth = null){
        if($sth === null) return self::find($key, self::$storage);
        self::$storage[$key] = $sth;
    }

    public static function find($key, $arr){
        $k = is_array($key) ? $key : explode('.', $key);
        if(count($k) > 1){
            $x = array_shift($k);
            return isset($arr[$x]) ? ( count($k) > 1 ? self::find( $k,  $arr[$x]) : $arr[$x][$k[0]] )  : '';
        }
        return isset($arr[$key]) ? $arr[$key] : '';
    }

    public function push($key, $sth){
        $exist = self::_($key);
        if(!is_array($exist)) $exist = [];
        $exist = array_merge($exist, $sth);
        self::_($key, $exist);
    }

    public static function use( $object ){

        if( self::$loaded === null ){
            self::$factory = [];
            self::$storage = [];
            self::$loaded = 1;
        }
        
        switch( $object ){
            case 'user' :
                $user = session::get('_user');
                if(empty($user)){
                    $user = user::getInstance();
                    session::set('_user', $user);
                }
                return $user;
            case 'input' :
                if( !isset( self::$factory['input'] ) ){
                    self::$factory['input'] = new input(); 
                }
                return self::$factory['input'];
            case 'sm' :
            case 'sitemap' :
            case 'route' :
            case 'router' : // sometime we confuse the word
                if( !isset( self::$factory['route'] ) ){
                    self::$factory['route'] = new sitemap(); 
                }
                return self::$factory['route'];
            case 'filter' :
                if( !isset( self::$factory['filter'] ) ){
                    self::$factory['filter'] = new filter(); 
                }
                return self::$factory['filter'];
            case 'session' :
            case 'ss' :
                if( !isset( self::$factory['session'] ) ){
                    self::$factory['session'] = new session(); 
                }
                return self::$factory['session'];
            case 'env' :
                if( !isset( self::$factory['env'] ) ){
                    self::$factory['env'] = new env(); 
                }
                return self::$factory['env']; 
            default: return $object;
        }
    }

    public static function process(){

        $controller = new controller();
        $controller->process();
    }

    public static function generateOutput(){

        //TODO implement cache

        $format = self::use('input')->get('format', '');

        $layout = config::$template['script_path'];

        switch($format):
            case 'json':
                echo json_encode( App::_('_content') );
                break;
            case 'error':
                $layout = 'error';
            default:
                ob_start();
                include MJ_PATH. 'templates/'. $layout .'.php';
                $res = ob_get_clean();
                echo $res;
                break;
        endswitch;

    }

    // shortcut functions
    public static function env(){
        return self::use('env');
    }

    public static function input(){
        return self::use('input');
    }

    public static function sm(){
        return self::use('sitemap');
    }

    public static function ss(){
        return self::use('session');
    }

    public static function filter(){
        return self::use('filter');
    }

    public static function user(){
        return self::use('user');
    }

    public static function userId(){
        $user = self::use('user');
        if( property_exists($user, 'ID')) return $user->ID;
        if( property_exists($user, 'id')) return $user->id;
        return 0;
    }

}