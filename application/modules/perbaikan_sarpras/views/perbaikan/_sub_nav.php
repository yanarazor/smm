<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/perbaikan/perbaikan_sarpras') ?>"><?php echo lang('perbaikan_sarpras_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Perbaikan_sarpras.Perbaikan.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/perbaikan/perbaikan_sarpras/create') ?>"><?php echo lang('perbaikan_sarpras_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>