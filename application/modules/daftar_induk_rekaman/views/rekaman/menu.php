<ul>
	<?php if ($this->auth->has_permission('Daftar_induk_rekaman.Rekaman.Create')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/rekaman/daftar_induk_rekaman/create') ?>">
			<?php echo lang('bf_add_new'); ?></a>
	</li>
	<?php endif; ?>
	 
</ul>
