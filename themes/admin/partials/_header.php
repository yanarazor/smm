<?php
	Assets::add_css( array(
		'bootstrap.css',
		'bootstrap-responsive.css',
		'font-awesome.min.css',
		'style.css',
	));

	if (isset($shortcut_data) && is_array($shortcut_data['shortcut_keys'])) {
		Assets::add_js($this->load->view('ui/shortcut_keys', $shortcut_data, true), 'inline');
	}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo isset($toolbar_title) ? $toolbar_title .' : ' : ''; ?> <?php echo $this->settings_lib->item('site.title') ?></title>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>logo.ico">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="noindex" />
	<?php echo Assets::css(null, true); ?>
	<script src="<?php echo Template::theme_url('js/modernizr-2.5.3.js'); ?>"></script>
    <!-- <script language='JavaScript' type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.js'></script> -->
    <script src="<?php echo base_url(); ?>assets/js/validation/jquery-1.8.2.min.js" type="text/javascript"></script>
	<script language='JavaScript' type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.ui.accordion.js'></script>
    <script language='JavaScript' type='text/javascript' src='<?php echo base_url();?>assets/js/toogle.js'></script>
	<script language='JavaScript' type='text/javascript' src='<?php echo base_url();?>assets/js/jquery-ui-1.8.13.min.js'></script>  
	<!-- sweet alert -->
    <script src="<?php echo base_url(); ?>themes/admin/js/sweetalert.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/admin/css/sweetalert.css">

   
    
</head>
<body class="desktop">
 
	<noscript>
		<p>Javascript is required to use Bonfire's admin.</p>
	</noscript>

		<!-- start: Header -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container">
				<a class="brand" href="<?php echo base_url();?>">
					<img src="<?php echo base_url();?>assets/images/LogoSemar.png" height="50"/>
					<?php //echo anchor( '/', html_escape($this->settings_lib->item('site.title')), 'class="brand"' ); ?>                            
					<!--<?php echo anchor( '/', $this->settings_lib->item('site.title'), '' ); ?> -->
                </a> 
					 
							 
				<!-- start: Header Menu -->
				<div class="btn-group pull-right" >
                <!--
					<a class="btn" href="notifications.php"><i class="icon-bell"></i> Notifications <span class="label label-success">2</span></a>				
					<a class="btn" href="store-settings.php"><i class="icon-wrench"></i> Store Settings</a>
                    -->
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-user"></i> 
						<?php echo (isset($current_user->display_name) && !empty($current_user->display_name)) ? $current_user->display_name : ($this->settings_lib->item('auth.use_usernames') ? $current_user->username : $current_user->email); ?> <span class="caret"></span>
                     </a>
                    <ul class="dropdown-menu toolbar-profile">
                        <li>
                            <div class="inner">
                                <div class="toolbar-profile-img">
                                    <?php //echo gravatar_link($current_user->email, 96, null, $current_user->display_name) ?>
                                </div>
                                <div class="toolbar-profile-info">
                                    <li><?php echo $current_user->display_name ?></li>
                                    <li><?php e($current_user->email) ?></li>
                                    <li><a href="<?php echo site_url(SITE_AREA .'/settings/users/edit') ?>"><?php echo lang('bf_user_settings')?></a></li>
                                    <li class="divider"></li>
                                    <li><a href="<?php echo site_url('logout'); ?>"><?php echo lang('bf_action_logout')?></a></li>
                                </div>
                            </div>
                        </li>
                    </ul>
				</div>
				<!-- end: Header Menu -->
                <?php //echo Contexts::render_menu('text', 'normal'); ?>
			</div>
		</div>
      
	</div>
	<div id="under-header"></div>

 <div class="container-fluid">
		<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
		<div class="row-fluid">
			
			<!-- start: Main Menu -->
			<div class="span2 main-menu-span">
				<div class="nav-collapse sidebar-nav">
                <!-- start: Main Menu -->
					<!--<ul class="nav nav-tabs nav-stacked main-menu">
						<li class="nav-header">Navigation</li>
						<li><a href="<?php echo base_url();?>index.php/admin/master/instansi"><i class="icon-th"></i> Penyimpanan</a></li>
						<li><a href="#"><i class="icon-th"></i> Input Data</a></li>
						 
					</ul>
				 -->
                  
					<ul class="nav nav-tabs nav-stacked main-menuq">
						<!--<li class="nav-header">Admin Navigation</li>-->
                        
                         
						 <?php
	   				 
							$menu = $this->uri->segment(3);  
						 	$mainmenu = $this->uri->segment(2);  
							echo Contexts::render_menuaccordion('text', 'normal',$mainmenu,$menu); 
						  
						?>
					</ul>
                    
                     <div id="sr_content">
                           
                     </div>
				</div><!--/.well -->
			</div><!--/span-->
			<!-- end: Main Menu -->
<!-- Ajax Loader Image/Overlay -->
<div id="loader">
	<div class="box">
		<img src="<?php echo Template::theme_url('images/ajax_loader.gif')?>" />
	</div>
</div>

<!-- End Ajax Loader Image/Overlay -->
