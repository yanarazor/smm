<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/dokumen/usulan_dokumen_eksternal') ?>" id="list">
		<i class="icon-list" <i=""></i> &nbsp;
		<?php echo lang('usulan_dokumen_eksternal_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Usulan_Dokumen_Eksternal.Dokumen.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/dokumen/usulan_dokumen_eksternal/create') ?>" id="create_new">
		<i class="icon-plus" <i=""></i> &nbsp;
		<?php echo lang('usulan_dokumen_eksternal_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>