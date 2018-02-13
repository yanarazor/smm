<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/masters/sub_bidang') ?>" id="list"><?php echo lang('sub_bidang_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Sub_Bidang.Masters.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/masters/sub_bidang/create') ?>" id="create_new"><?php echo lang('sub_bidang_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>