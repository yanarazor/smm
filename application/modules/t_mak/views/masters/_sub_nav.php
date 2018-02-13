<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/masters/t_mak') ?>"><?php echo lang('t_mak_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('T_mak.Masters.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/masters/t_mak/create') ?>"><?php echo lang('t_mak_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>