<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/masters/kegiatan') ?>"><?php echo lang('kegiatan_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Kegiatan.Masters.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/masters/kegiatan/create') ?>"><?php echo lang('kegiatan_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>