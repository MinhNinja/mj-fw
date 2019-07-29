<?php
/**
 * Simple tool to catch the log
 */

namespace mj\libraries;

use mj\config;

class debug{

    // do not support tree of logs
    private static $logs;

    public function stop(){
        $arr = func_get_args();
        foreach( $arr as $i => $sth ){
            var_dump($sth);
            echo '<br>';
        }
        die('<br>--stop debug--');
    }

    public function log(){
        $arr = func_get_args();
        foreach( $arr as $i => $sth ){
            self::$logs[] = $sth;
        }
    }

    public function show($exit = 0){
        
        if( config::$debug > 0){

            $debug = 'No log found';

            if( is_array(self::$logs) && count(self::$logs)){
                ob_start();
                foreach(self::$logs as $log){ 
                    var_dump( $log );
                    echo '<br>';
                }
                $debug = ob_get_clean();
            }
            // TODO: stylist & nicer print
            echo '<div class="container pt-3 pb-3">';
            if(  config::$debug === 1 ) echo '<!--';
            echo $debug;
            if(  config::$debug === 1 ) echo '-->';
            echo '</div>';

            if($exit) exit(0);
        }
    }
}