<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/settings/status_ptpp') ?>" id="list"><?php echo lang('status_ptpp_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Status_Ptpp.Settings.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/settings/status_ptpp/create') ?>" id="create_new"><?php echo lang('status_ptpp_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>