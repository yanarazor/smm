<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/masters/master_izin') ?>" id="list"><?php echo lang('master_izin_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Master_Izin.Masters.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/masters/master_izin/create') ?>" id="create_new"><?php echo lang('master_izin_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>