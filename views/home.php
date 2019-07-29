<?php

use mj\libraries\application as App;
use mj\libraries\helper;
use mj\languages\text as Txt;
use mj\config;

?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2><?php Txt::_e('Demo homepage') ?></h2>
            <?php echo $this->loadView('widget.message') ?>
        </div>
        <div class="col-12">
            <h3>Version 0.1</h3>
            <ul>
                <li>Multi language support</li>
                <li>Nice SEF link support</li>
                <li>Multi action support</li>
                <li>Multi template support</li>
            </ul>
        </div>
        <div class="col-12">
            <h3>User information</h3>
            <?php var_dump(App::use('user')) ?>
        </div>
    </div>
    <?php echo $this->loadView('widget.demo_links') ?>
</div>