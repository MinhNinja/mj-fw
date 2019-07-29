<?php

namespace mj\languages;

use mj\config;

class text{

    protected static $text;

    public static function _e( $label ){
        echo static::_( $label );
    }

    public static function _( $label ){
        if( empty( static::$text ) ){

            $file = (string) file_get_contents( MJ_PATH. 'languages/'. config::$defaultLanguage .'.ini');

            $tmp = explode( "\n", $file );

            static::$text = [];

            foreach( $tmp as $line ){
                $line = explode( ' = ', $line );
                if( count($line) > 1 ){
                    static::$text[$line[0]] = $line[1];
                }
            }
        }
        return isset( static::$text[ $label ] ) ? static::$text[ $label ] : '__'.$label.'__' ;
    }

}