<ul>
	<?php if ($this->auth->has_permission('Jenis_Dokumen.Dokumen.Create')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/dokumen/jenis_dokumen/create') ?>">
			<?php echo lang('bf_add_new'); ?></a>
	</li>
	<?php endif; ?>
	 
</ul>
