<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/masters/hari_libur') ?>"><?php echo lang('hari_libur_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Hari_Libur.Masters.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/masters/hari_libur/create') ?>"><?php echo lang('hari_libur_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>