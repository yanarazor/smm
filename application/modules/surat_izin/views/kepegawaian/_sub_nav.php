<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/surat_izin/other') ?>" id="list">
		<i class="icon-list" <i=""></i> &nbsp;
		<?php echo lang('surat_izin_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Surat_Izin.Kepegawaian.Other')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/surat_izin/other_create') ?>" id="create_new">
		<i class="icon-plus" <i=""></i> &nbsp;
		<?php echo lang('surat_izin_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>