<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/logbook/bukusaku') ?>"><?php echo lang('bukusaku_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Bukusaku.Logbook.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/logbook/bukusaku/create') ?>" class="show-modal">Tambah</a>
	</li>
	<?php endif; ?>
</ul>