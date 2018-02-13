<ul>
	<?php if ($this->auth->has_permission('Permintaan_Barang.Permintaanbarang.Create')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/permintaanbarang/permintaan_barang/create') ?>">
			Permintaan barang persediaan 
		</a>
	</li>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/permintaanbarang/permintaan_barang/createbmn') ?>">
			Permintaan barang bmn
		</a>
	</li>
	<?php endif; ?>
	<?php if ($this->auth->has_permission('Permintaan_Barang.Permintaanbarang.atasan')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/permintaanbarang/permintaan_barang/periksa') ?>">
			Persetujuan Atasan/PJ
		</a>
	</li>
	<?php endif; ?>
	<?php if ($this->auth->has_permission('Permintaan_Barang.Permintaanbarang.btu')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/permintaanbarang/permintaan_barang/periksakb') ?>">
			Persetujuan Kasubag/KPU
		</a>
	</li>
	<?php endif; ?>
	<?php if ($this->auth->has_permission('Permintaan_Barang.Permintaanbarang.persediaan')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/permintaanbarang/permintaan_barang/persediaan') ?>">
			Petugas Persediaan
		</a>
	</li>
	<?php endif; ?>
	<?php if ($this->auth->has_permission('Permintaan_Barang.Permintaanbarang.bmn')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/permintaanbarang/permintaan_barang/bmn') ?>">
			Petugas BMN
		</a>
	</li>
	<?php endif; ?>
	<?php if ($this->auth->has_permission('Permintaan_Barang.Permintaanbarang.PPK')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/permintaanbarang/permintaan_barang/ppk') ?>">
			Persetujuan PPK
		</a>
	</li>
	<?php endif; ?>
	<?php if ($this->auth->has_permission('Permintaan_Barang.Permintaanbarang.pengadaan')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/permintaanbarang/permintaan_barang/pengadaan') ?>">
			Petugas Pengadaan
		</a>
	</li>
	<?php endif; ?>
</ul>
