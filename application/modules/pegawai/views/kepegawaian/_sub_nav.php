<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/pegawai') ?>"><?php echo lang('pegawai_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Pegawai.Kepegawaian.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/pegawai/create') ?>"><?php echo lang('pegawai_new'); ?></a>
	</li>
	<?php endif; ?>
	<?php if ($this->auth->has_permission('Pegawai.Kepegawaian.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'ambildata' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/pegawai/ambildata') ?>">Ambil Data</a>
	</li>
	<?php endif; ?>
</ul>