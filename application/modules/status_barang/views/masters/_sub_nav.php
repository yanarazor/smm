<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/masters/status_barang') ?>" id="list"><?php echo lang('status_barang_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Status_Barang.Masters.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/masters/status_barang/create') ?>" id="create_new"><?php echo lang('status_barang_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>