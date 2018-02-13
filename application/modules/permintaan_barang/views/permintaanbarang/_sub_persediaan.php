<ul class="nav nav-pills">
	 
	<?php if ($this->auth->has_permission('Permintaan_Barang.Permintaanbarang.persediaan')) : ?>
	<li <?php echo $this->uri->segment(4) == 'printtandaterima' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/permintaanbarang/permintaan_barang/printtandaterima') ?>/<?php echo isset($id) ? $id : ""; ?>"  target="_blank">Print Tanda Terima</a>
	</li>
	<?php endif; ?>
	<?php if ($this->auth->has_permission('Permintaan_Barang.Permintaanbarang.bmn')) : ?>
	<li <?php echo $this->uri->segment(4) == 'printtandaterima' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/permintaanbarang/permintaan_barang/printtandaterimabmn') ?>/<?php echo isset($id) ? $id : ""; ?>"  target="_blank">Print Tanda Terima BMN</a>
	</li>
	<?php endif; ?>
</ul>