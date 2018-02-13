<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/dokumen/daftar_induk_dokumen') ?>" id="list">
		<i class="icon-list" <i=""></i> &nbsp;
		<?php echo lang('daftar_induk_dokumen_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Daftar_Induk_Dokumen.Dokumen.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/dokumen/daftar_induk_dokumen/create') ?>" id="create_new">
		<i class="icon-plus" <i=""></i> &nbsp;
		<?php echo lang('daftar_induk_dokumen_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>