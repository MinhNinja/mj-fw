<?php
namespace mj\templates;

use mj\libraries\application as App;
use mj\libraries\asset;
use mj\config;

$siteUrl = config::$siteUrl.'/';
$homeUrl = App::use('sm')->get('home', 'url');

asset::addJs( $siteUrl.'assets/js/jquery.min.js', 'jquery1.12.4');
asset::addJsWith( $siteUrl.'assets/js/jquery-migrate.min.js', 'jquery1.12.4');
asset::addJsWith( $siteUrl.'assets/js/popper.min.js', 'jquery1.12.4', 'popper5.2.2');
asset::addJsWith( $siteUrl.'assets/js/bootstrap.min.js', 'jquery1.12.4', 'bootstrap5.2.2');
asset::addJsWith( $siteUrl.'assets/js/theme-script.min.js', 'jquery1.12.4', 'bootstrap5.2.2');

asset::addCss( $siteUrl.'assets/css/style.css', 'site');
asset::addCss( $siteUrl.'assets/css/bootstrap.min.css', 'bootstrap5.2.2');
asset::addCssWith('https://use.fontawesome.com/releases/v5.8.2/css/all.css?ver=5.2.2', 'bootstrap5.2.2');

?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <title><?php echo App::_('_page_title') ?></title>
    <meta name='robots' content='noindex,follow' />
    <link rel='dns-prefetch' href='//use.fontawesome.com' />
    <link rel='dns-prefetch' href='//s.w.org' /> 

    <?php asset::generateCssLinks(); ?>
    <?php asset::generateStyleSheet(); ?>

</head>
<body class="blog custom-background hfeed">
<div id="page" class="site">

    <header id="masthead" class="site-header navbar-static-top navbar-light" role="banner">
        <div class="container">
            <nav class="navbar navbar-expand-xl p-0 justify-content-between">
                <div class="navbar-brand">
                    <a href="<?php echo $homeUrl ?>">
                        <img src="<?php echo $siteUrl ?>demo-logo-276.png" alt="<?php echo config::$siteName ?>">
                        </a> &nbsp;
                        <a class="site-title" href="<?php echo $homeUrl ?>"><?php echo config::$siteName ?></a>
                    
                </div>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav" aria-controls="" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </nav>

        </div>
	</header><!-- #masthead -->
    <div id="content" class="site-content">
		<div class="container">
			<div class="row">
                
                <section id="primary" class="content-area col-sm-12 col-md-12 col-lg-12">
                    <main id="main" class="site-main" role="main">
                    
                    <?php if($msg):
                            $msg_type = App::use('ss')->get('_msg_type');

                        ?>
                            <div class="alert alert-<?php echo $msg_type ? $msg_type : 'warning'  ?>">
                                <?php echo $msg ?>
                            </div>
                        <?php endif; ?>
                    
                    </main><!-- #main -->
                </section><!-- #primary -->

			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- #content -->
    <footer id="colophon" class="site-footer navbar-light" role="contentinfo">
		<div class="container pt-3 pb-3">
            <div class="site-info">
                &copy; 2019 <a href="<?php echo App::use('sitemap')->get('home', 'url') ?>">MJ Application - Demo</a>                
            </div><!-- close .site-info -->
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php asset::generateJsLinks(); ?>
<?php asset::generateJavascript(); ?>

</body>
</html>