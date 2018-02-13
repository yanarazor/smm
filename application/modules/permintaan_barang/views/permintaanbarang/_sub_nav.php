<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/permintaanbarang/permintaan_barang') ?>"><?php echo lang('permintaan_barang_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Permintaan_Barang.Permintaanbarang.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/permintaanbarang/permintaan_barang/create') ?>"><?php echo lang('permintaan_barang_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>