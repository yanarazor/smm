<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/dokumen/usulan_dokumen_internal') ?>" id="list">
		<i class="icon-list" <i=""></i> &nbsp;
		<?php echo lang('usulan_dokumen_internal_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Usulan_Dokumen_Internal.Dokumen.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/dokumen/usulan_dokumen_internal/create') ?>" id="create_new">
		<i class="icon-plus" <i=""></i> &nbsp;
		<?php echo lang('usulan_dokumen_internal_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>