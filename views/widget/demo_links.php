<?php
use mj\libraries\application as App;
use mj\languages\text as Txt;
use mj\libraries\asset;

?>
<h2>Demo buttons</h2>
<div class="row">
    <div class="col-6 ">
        <form class="form-inline " method="POST"
            action="<?php echo  App::sm()->get('test-url-var')->url(['id'=>rand(1,9999)]);  ?>"> 
                <p><input type="text" name="infoText" value="<?php echo $infoText ?>" class="form-control ml-2" ></p>
                <p><input type="date" name="infoDate" value="<?php echo $infoDate ?>" class="form-control ml-2" ></p>
                <br>
            <button class="btn btn-success btn-submit-post ml-2" type="submit"><?php Txt::_e('Submit POST method') ?></button>
            <button class="btn btn-primary btn-submit-get ml-2" type="button"><?php Txt::_e('Submit GET method') ?></button>
        </form>
    </div>
    <div class="col-3 text-center">
        <a class="btn btn-warning ml-2" type="button" href="<?php echo App::sm()->get('test-multi-level-path', 'url') ?>" >
            <?php Txt::_e('Multi level path') ?></a>
    </div>
    <div class="col-3 text-center">
        <a class="btn btn-danger ml-2" type="button" href="<?php echo App::env()->getConfigUrl( 'not-set-slug' )  ?>">
            <?php Txt::_e('Show error page') ?></a>
    </div>
</div>
<?php
$js = <<<js
jQuery(document).ready(function($) {
    $(".btn-submit-get").click(function(){
        this.form.method = 'GET';
        this.form.submit();
    });
});
js;

asset::addJsInline($js);