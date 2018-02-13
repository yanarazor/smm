<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/reports/daftar_ptpp') ?>" id="list"><?php echo lang('daftar_ptpp_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Daftar_ptpp.Reports.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/reports/daftar_ptpp/create') ?>" id="create_new"><?php echo lang('daftar_ptpp_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>