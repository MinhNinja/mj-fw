<?php

namespace mj\libraries;

class filter{

    private $value;

    public function set( $value ){
        $this->value = $value;
        return $this;
    }

    public function toInt( $default = 0 ){
        
        if( $this->value === null ){
            $value = $default;
        } else {
            preg_match('/-?[0-9]+/', (string) $this->value, $matches);
            $value = @ (int) $matches[0];
        }
        return $value;
    }

    public function toArray(){
        return empty( $this->value ) && ( $this->value === 0) ? [] : (array) $this->value;
    }

    public function toUnit( $default = 0 ){

        if( $this->value === null ){
            $value = $default;
        } else {
            preg_match('/-?[0-9]+/', (string) $this->value, $matches);
            $value = @ abs( (int) $matches[0] );
        }
        return $value;
    }

    public function toBool(){

        return (bool) $this->value;
    }

    // Only allow characters a-z, and underscores
    public function toWord( $default = '' ){

        if( $this->value === null ){
            $value = $default;
        } else {
            $value = (string) preg_replace('/[^A-Z_]/i', '', $this->value);
        }
        return $value;
    }

    // Allow a-z and 0-9 only
    public function toAlnum( $default = '' ){

        if( $this->value === null ){
            $value = $default;
        } else {
            preg_match('/-?[0-9]+/', (string) $this->value, $matches);
            $value = @ abs( (int) $matches[0] );
        }
        return $value;
    }

    // Allow a-z, 0-9, underscore, dot, dash. Also remove leading dots from result. 
    public function toCmd( $default = '' ){

        if( $this->value === null ){
            $value = $default;
        } else {
            $value = (string) preg_replace('/[^A-Z0-9_\.-]/i', '', $this->value);
            $value = ltrim($value, '.');
        }
        return $value;
    }

    // Allow a-z, 0-9, slash, plus, equals.
    public function toBase64( $default = '' ){

        if( $this->value === null ){
            $value = $default;
        } else {
            $value = (string) preg_replace('/[^A-Z0-9\/+=]/i', '', $this->value);
        }
        return $value;
    }

    // Strips all invalid username characters.
    public function toUsername( $default = '' ){

        if( $this->value === null ){
            $value = $default;
        } else {
            $value = (string) preg_replace('/[\x00-\x1F\x7F<>"\'%&]/', '', $this->value);
        }
        return $value;
    }

    public function toSkipHtml( $default = '' ){

        if( $this->value === null ){
            $value = $default;
        } else {
            $value = strip_tags( $this->value );
        }
        return $value;
    }

    /**
     * $date = "2014-04-01 12:00:00";
     * preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/',$date, $matches);
     * print_r($matches);
     * $matches will be:
     * 
     *  Array ( 
     *        [0] => 2014-04-01 12:00:00 
     *        [1] => 2014 
     *        [2] => 04 
     *        [3] => 01 
     *        [4] => 12 
     *        [5] => 00 
     *        [6] => 00
     *  )
     */
    public function toDate( $default = '0000-00-00' ){
        if( $this->value === null ){
            $value = $default;
        } else {
            $found = preg_match('/(\d{4})-(\d{2})-(\d{2})/', (string) $this->value, $matches);
            $value = $found ? (string) $matches[0] : $default;
        }
        return $value;
    }

    public function toTime( $default = '00:00:00' ){
        if( $this->value === null ){
            $value = $default;
        } else {
            $found = preg_match('/(\d{2}):(\d{2}):(\d{2})/', (string) $this->value, $matches);
            $value = $found ? (string) $matches[0] : $default;
        }
        return $value;
    }

    public function toDatetime( $default = '0000-00-00 00:00:00' ){
        if( empty( $this->value ) ){
            $value = $default;
        } else {
            $found = preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/', (string) $this->value, $matches);
            $value = $found ? (string) $matches[0] : $default;
        }
        return $value;
    }
}