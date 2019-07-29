<?php
use mj\libraries\helper;

?>

<h1>Submitted data by GET method</h1>
<?php var_dump($getData);?>
<hr>


<h1>Submitted data by POST method</h1>
<?php var_dump($postData); ?>
<hr>

<h2>Data Found in URL</h2>
<p><?php var_dump($urlData);?></p>
<hr>

<?php if( isset($moreInfo)) { ?>
    <h2>Action 'beforeProcess' has beend called</h2>
    <p><?php var_dump($moreInfo);?></p>
<?php } else { ?>
    <h2>Action 'beforeProcess' was not set</h2>
    <p>Nothing to show</p>
<?php } ?>

<hr>

<?php echo $this->loadView('widget.demo_links') ?>