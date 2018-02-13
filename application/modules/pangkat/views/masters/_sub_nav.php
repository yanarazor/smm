<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/masters/pangkat') ?>"><?php echo lang('pangkat_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Pangkat.Masters.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/masters/pangkat/create') ?>"><?php echo lang('pangkat_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>