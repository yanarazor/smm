<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/masters/jabatan') ?>"><?php echo lang('jabatan_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Jabatan.Masters.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/masters/jabatan/create') ?>"><?php echo lang('jabatan_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>