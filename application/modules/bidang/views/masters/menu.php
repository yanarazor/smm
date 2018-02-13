<ul>
	<?php if ($this->auth->has_permission('Bidang.Masters.Create')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/masters/bidang/create') ?>">
			<?php echo lang('bf_add_new'); ?></a>
	</li>
	<?php endif; ?>
	 
</ul>
