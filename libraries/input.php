<?php

namespace mj\libraries;

use mj\libraries\application as App;
use mj\libraries\session;

class input{

    private $data;
    private $value;
    private $url;

    public function all(){
        return $this->data;
    }

    public function from($input){
        $this->data = $input;
        return $this;
    }

    public function post(){
        return $this->from($_POST);
    }

    public function session(){
        return $this->from($_SESSION); 
    }

    public function url(){
        return $this->from($this->url); 
    }

    public function setUrlVar($key, $value = ''){

        if (!is_array($this->url)){
            $this->url = [];
        } 
        
        if (is_array($key)){
            $this->url = array_merge($this->url, $key);
        } else {
            $this->url[$key] = $value;
        }
    }

    public function find( $key, $format = '' ){

        $this->value = isset($this->data[$key]) ? $this->data[$key] : null;

        $format = strtolower($format);

        $filter = App::use('filter');

        switch($format){
            case 'int': 
            case 'integer': return $filter->set($this->value)->toInt();
            case 'unit': return $filter->set($this->value)->toUnit();
            case 'word': return $filter->set($this->value)->toWord();
            case 'bool':
            case 'boolean': return $filter->set($this->value)->toBool();
            case 'cmd': return $filter->set($this->value)->toCmd();
            case 'alnum': return $filter->set($this->value)->toAlnum();
            case 'base64': return $filter->set($this->value)->toBase64();
            case 'username': return $filter->set($this->value)->toUsername();
            case 'skiphtml': return $filter->set($this->value)->toSkipHtml();
            case 'datetime': return $filter->set($this->value)->toDatetime();
            case 'date': return $filter->set($this->value)->toDate();
            case 'time': return $filter->set($this->value)->toTime();
            case 'array': return $filter->set($this->value)->toArray();
            // raw
            case '': return $this->value;
            default: return $this; // for next process
        }
    }

    public function get($key = null, $format = ''){

        if( $key === null ){
            return $this->from($_GET);
        }

        $value = $this->url()->find($key, $format);

        // not found in Input, try POST
        if( $this->value === null ){
            $value = $this->post()->find($key, $format);
        } else {
            return $value;
        }
        
        // not found in POST, try GET
        if( $this->value === null ){
            $value = $this->get()->find($key, $format);
        }

        return $value;
    }

    public function getPageOffset( $object = ''){
        return $this->getStatus($object, 'start', 0);
    }

    public function setPageOffset( $object = '', $default = 0){
        session::set( $object.'.start', $default);
    }

    public function getPageSort( $object = '', $default = 'id-ASC'){
        return $this->getStatus($object, 'sort', $default);
    }

    public function getStatus( $object, $key, $default){

        $tmp = $this->get()->find($key, '');

        if( $tmp === null ){
            $tmp = $this->session()->find( $object.'.'.$key, '');
            if( $tmp === null ){
                session::set( $object.'.'.$key, $default);
                $tmp = $default;
            }
        }else{
            $oldTmp = session::get( $object.'.'.$key, '');
            if( $tmp !== $oldTmp ){
                session::set( $object.'.'.$key, $tmp);
            }
        }

        return $tmp;
    }
}