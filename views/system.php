<?php

use mj\libraries\application as App;

?>
<h2>Unexpected problem occured</h2>

<?php echo $this->loadView('widget.message') ?>

<p>Back to <a href="<?php echo App::env()->getConfigUrl() ?>">home</a></p>