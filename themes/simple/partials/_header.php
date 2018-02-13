<?php
	Assets::add_css( array(
		'bootstrap.css',
		'bootstrap-responsive.css',
		'font-awesome.min.css',
		'style.css',
	));

	 
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo isset($toolbar_title) ? $toolbar_title .' : ' : ''; ?> <?php echo $this->settings_lib->item('site.title') ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="noindex" />
	<?php echo Assets::css(null, true); ?>
	<script src="<?php echo Template::theme_url('js/modernizr-2.5.3.js'); ?>"></script>
    <script language='JavaScript' type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.js'></script>  
	<script language='JavaScript' type='text/javascript' src='<?php echo base_url();?>assets/js/jquery-ui-1.8.13.min.js'></script> 
    
</head>
<body class="desktop">
<!--[if lt IE 7]>
		<p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or
		<a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p>
<![endif]-->


	<noscript>
		<p>Javascript is required to use Bonfire's admin.</p>
	</noscript>

	 
			<!-- end: Main Menu -->
<!-- Ajax Loader Image/Overlay -->
<div id="loader">
	<div class="box">
		<img src="<?php echo Template::theme_url('images/ajax_loader.gif')?>" />
	</div>
</div>

<!-- End Ajax Loader Image/Overlay -->
