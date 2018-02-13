<?php
    Assets::add_js( array('vendors.js','styleswitcher.js','shCore.js','shBrushXml.js','shBrushJScript.js','app.js'));
    Assets::add_css( array('bootstrap.min.css','font-awesome.min.css', 'animate.css','style.css'));

    $inline  = '$(".dropdown-toggle").dropdown();';
    $inline .= '$(".tooltips").tooltip();';

    Assets::add_js( $inline, 'inline' );
?>
<!doctype html>
<head>
    <meta charset="utf-8">

    <title><?php echo isset($page_title) ? $page_title .' : ' : ''; ?> <?php if (class_exists('Settings_lib')) e(settings_item('site.title')); else echo 'Bonfire'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <meta name="description" content="">
    <meta name="author" content="">

    <?php echo Assets::css(); ?>
	<script language='JavaScript' type='text/javascript' src='<?php echo base_url(); ?>assets/js/jquery-1.7.2.js'></script>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico">
</head>
<body>
