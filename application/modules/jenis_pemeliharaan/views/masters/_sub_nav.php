<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/masters/jenis_pemeliharaan') ?>"><?php echo lang('jenis_pemeliharaan_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Jenis_Pemeliharaan.Masters.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/masters/jenis_pemeliharaan/create') ?>"><?php echo lang('jenis_pemeliharaan_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>