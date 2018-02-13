<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/izin_keluar') ?>" id="list"><?php echo lang('izin_keluar_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Izin_Keluar.Kepegawaian.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/izin_keluar/create') ?>" id="create_new"><?php echo lang('izin_keluar_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>