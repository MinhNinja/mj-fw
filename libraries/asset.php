<?php

/**
 * Wrapper for addScript, addScriptDeclration, addStylesheet, addStyleDeclaration
 * so we could put dependencies for script
 */

namespace mj\libraries;

class asset{

    private static $assets = [];
    private static $jsLinks;
    private static $jsInline = [];
    private static $cssLinks;
    private static $cssInline = [];


    private static function addAsset($type, $links, $id = null , $parent = null){
        $links = (array)$links;
        if( empty($id) ) $id = md5(json_encode($links));

        if(isset(self::$assets[$type][$id])){
            self::$assets[$type][$id]['list'] = array_merge(self::$assets[$type][$id]['list'], $links);
            if( $parent !== null ){
                if(!isset(self::$assets[$type][$parent])){
                    self::addAsset($type, [], $parent);
                }
                self::$assets[$type][$id]['parent'] = $parent;
            }
        }else{
            self::$assets[$type][$id] = ['list'=>$links];
            self::$assets[$type][$id]['parent'] = $parent === null ? false : $parent;
        }
    }

    public static function addCss($links, $id){
        self::addAsset('css', $links, $id);
    }

    public static function addJs($links, $id){
        self::addAsset('js', $links, $id);
    }

    public static function addJsWith($links, $parent, $id = null){
        self::addAsset('js', $links, $id, $parent);
    }

    public static function addCssWith($links, $parent, $id = null){
        self::addAsset('css', $links, $id, $parent);
    }

    public static function processAssets(){
        foreach(self::$assets as $type=>$assets)
            foreach($assets as $arr)
                self::processAsset($arr, $type);
    }

    private static function processAsset( &$arr, $type = 'css' ){
        if( isset($arr['done']) || empty($arr)) return;
        if( $arr['parent'] ){
            self::processAsset( self::$assets[$type][ $arr['parent'] ], $type );
        } 
        foreach($arr['list'] as $link){
            if($type == 'css'){
                self::$cssLinks[] = '<link rel="stylesheet" type="text/css" href="'. $link .'" >';
            }else{
                self::$jsLinks[] = '<script src="' . $link. '"></script>';
            }
        }
        $arr['done'] = true; 
    }

    public static function addJsInline($str){
        self::$jsInline[] = $str;
    }

    public static function addCssInline($str){
        self::$cssInline[] = $str;
    }

    public static function generateStyleSheet(){
        if( count(self::$cssInline) ){
            array_unshift(self::$cssInline, '<style>');
            array_push(self::$cssInline, '</style>');
            echo implode( "\n", self::$cssInline);
        }
    }

    public static function generateJavascript(){
        if( count(self::$jsInline) ){
            array_unshift(self::$jsInline, '<script>');
            array_push(self::$jsInline, '</script>');
            echo implode( "\n", self::$jsInline);
        }
    }

    public static function generateCssLinks(){
        if( is_null( self::$cssLinks ) ){
            self::$cssLinks = [];
            self::$jsLinks = [];
            self::processAssets();
        }

        echo implode( "\n", self::$cssLinks);
    }

    public static function generateJsLinks(){
        if( is_null( self::$jsLinks ) ){
            self::$cssLinks = [];
            self::$jsLinks = [];
            self::processAssets();
        }

        echo implode( "\n", self::$jsLinks);
    }
}