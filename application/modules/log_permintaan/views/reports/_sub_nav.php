<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/reports/log_permintaan') ?>"><?php echo lang('log_permintaan_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Log_permintaan.Reports.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/reports/log_permintaan/create') ?>"><?php echo lang('log_permintaan_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>