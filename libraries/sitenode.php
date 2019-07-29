<?php
/**
 * @package     Minh.ninja
 * @subpackage  Application
 *
 * @copyright   Joomaio
 * @license     Commercial
 * @description	WP version
 * 
 */

namespace mj\libraries;

use mj\config;
use mj\libraries\application as App;

class sitenode{

    protected $task;
    protected $input;
    protected $name;
    protected $slug;

    public function __construct(string $name, string $slug, array $properties, string $task){
        $this->name = $name;
        $this->slug = $slug; // TODO : $this->slug = wpx::get_option('sgcpNodeApp.'.$this->name));
        $this->task = $task;
		$this->input = array();
		$this->app	= APP_NAME;
        foreach($properties as $key=>$format){
            // ordering of input is important
            $this->input[$key] = $format;
        }
    }

    public function getTask(){
        return $this->task;
    }

    // alias for shorter name function
    public function url($obj=null){
        return $this->getSefUrl($obj);
    }

    public function getSefUrl($obj=null){
        
        $path = trim( $this->slug, '/');
        if(!empty($obj)){
            foreach( $this->input as $key=>$format){
                // todo filter obj value when add
                $path .= '/'. ( is_object($obj) ? $obj->$key : $obj[$key] );
            } 
        }

        return App::env()->getConfigUrl( $path. '/' );
    }

    public function getBaseUrl(){
        $url =  'index.php?app='. $this->app .'&task='.$this->task;
        if(count($this->input)){
            $count = 1;
            foreach( $this->input as $key=>$format){
                // todo filter obj value when add
                $url .= '&'.$key.'=$matches['.$count.']';
                $count++;
            }
        }
        return $url;
    }

    public function mapInput(&$res, $params){
        if(count($this->input)){
            $count = 0;
            foreach( $this->input as $key=>$format){
                $res[$key] = $params[$count];
                $count++;
            }
        }
    }

    public function getRegSlug( $start_reg = '', $start_slug = '', $end_slug = '', $end_reg = ''  ){
        
        $url = $start_slug. trim( $this->slug, '/') . $end_slug;
        
        foreach( $this->input as $format){
            $url .= '\/'.$format;
        }
        return $start_reg . $url . $end_reg;
    }
}
