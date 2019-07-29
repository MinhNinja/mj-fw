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

class sitemap{

	private $map;
	
    public function getMap(){
        // set all the maps, because we have to register with wp_rewrite
        if(empty($this->map)){
            foreach( config::$endpoints as $x){
                list($name, $slug) = $x;
                $params = isset($x[2]) ? $x[2] : array();
                $task = isset($x[3]) ? $x[3] : str_replace('-', '_', $name);
                $this->map[$name] = new sitenode($name, $slug, $params, $task);
            }
        }
        return $this->map;
    }

    public function get($nodeName, $fnc = ''){
        $map = $this->getMap();
        if( !isset( $map[$nodeName] )) return false;
        if( empty($fnc) ) return $map[$nodeName];
        if( method_exists($map[$nodeName], $fnc)) return $map[$nodeName]->$fnc();
        $fnc = 'get'. ucfirst($fnc);
        if( method_exists($map[$nodeName], $fnc)) return $map[$nodeName]->$fnc();
        return false;
    }

    public function isHome(){

        $current = App::use('env')->getCurrentUriPath();
        $current = App::env()->getConfigUrl( trim( $current, '/') . '/' );
        $current = str_replace( ['http://', 'https://'], '', $current);
        $home = $this->get('home', 'url');
        $home = str_replace( ['http://', 'https://'], '', $home);
        
        return $home == $current;
    }
}