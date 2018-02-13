<ul>
	<?php if ($this->auth->has_permission('Daftar_ptpp.Ptpp.Create')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/ptpp/daftar_ptpp/create') ?>">
			<?php echo lang('bf_add_new'); ?></a>
	</li>
	<?php endif; ?>
	 
</ul>
