<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/ketidaksesuaian/tindakan') ?>" id="list">
		<i class="icon-list" <i=""></i> &nbsp;
		<?php echo lang('tindakan_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Tindakan.Ketidaksesuaian.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/ketidaksesuaian/tindakan/create') ?>" id="create_new">
		<i class="icon-plus" <i=""></i> &nbsp;
		<?php echo lang('tindakan_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>