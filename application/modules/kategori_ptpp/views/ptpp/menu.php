<ul>
	<?php if ($this->auth->has_permission('Kategori_Ptpp.Ptpp.Create')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/ptpp/kategori_ptpp/create') ?>">
			<?php echo lang('bf_add_new'); ?></a>
	</li>
	<?php endif; ?>
	 
</ul>
