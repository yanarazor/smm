<ul>
	<?php if ($this->auth->has_permission('Usulan_Perubahan_Dokumen.Dokumen.Create')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/dokumen/usulan_perubahan_dokumen_eksternal/create') ?>">
			<?php echo lang('bf_add_new'); ?></a>
	</li>
	<?php endif; ?>
	 
</ul>
