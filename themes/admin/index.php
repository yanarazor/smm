<?php
	Assets::add_js( array( 'bootstrap.min.js', 'jwerty.js'), 'external', true);
?>
<?php echo theme_view('partials/_header'); ?>
<div id="content" class="span10">
				
				<div>
					<ul class="breadcrumb">
                    	
						<li><i class="icon-th"></i>
                        	<a href="#">Beranda</a> <span class="divider">/</span></li>
						<li>
                        <?php if (isset($toolbar_title)) : ?>
								<?php echo $toolbar_title ?>
                            <?php endif; ?>
                            </li>
                            <div class="pull-right">
							<!--<a href="add-new-product.php" class="btn btn-success">List</a>
                            <a href="add-new-product.php" class="btn btn-success">New</a> -->
                            <?php Template::block('sub_nav', ''); ?>
                          
						</div>
					</ul>
				</div>
				<!-- end: breadcrumb -->
				 	
				<div class="row-fluid">

					<div class="box span12">
						
						<div class="box-content" id="box-content">
							<?php echo Template::message(); ?>
        					  <?php echo isset($content) ? $content : Template::content(); ?>
						</div>
					</div><!--/span-->
				
				</div><!--/row-->
				
			</div>
			<!-- end: content -->

<?php echo theme_view('partials/_footer'); ?>
