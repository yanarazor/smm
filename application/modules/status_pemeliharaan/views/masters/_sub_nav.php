<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/masters/status_pemeliharaan') ?>" id="list"><?php echo lang('status_pemeliharaan_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Status_pemeliharaan.Masters.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/masters/status_pemeliharaan/create') ?>" id="create_new"><?php echo lang('status_pemeliharaan_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>