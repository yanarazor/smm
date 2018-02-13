<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/ptpp/status_ptpp') ?>" id="list">
		<i class="icon-list" <i=""></i> &nbsp;
		<?php echo lang('status_ptpp_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Status_Ptpp.Ptpp.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/ptpp/status_ptpp/create') ?>" id="create_new">
		<i class="icon-plus" <i=""></i> &nbsp;
		<?php echo lang('status_ptpp_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>