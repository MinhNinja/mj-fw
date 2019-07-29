<?php

use mj\libraries\application as App;
use mj\libraries\helper;
use mj\languages\text as Txt;
use mj\config;

if( App::userId() ){
    $msg = App::use('ss')->get('_msg');
    App::use('ss')->set('_msg', '');
}else{
    $msg = App::use('input')->get('msg', 'base64');
    if(!empty($msg)) $msg = base64_decode($msg);
}

if($msg):
    $msg_type = App::use('ss')->get('_msg_type');

?>
    <div class="alert alert-<?php echo $msg_type ? $msg_type : 'warning'  ?>">
        <?php echo $msg ?>
    </div>
<?php 
endif;