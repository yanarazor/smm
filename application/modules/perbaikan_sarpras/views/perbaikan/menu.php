<ul>
	<?php if ($this->auth->has_permission('Perbaikan_sarpras.Perbaikan.Create')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/perbaikan/perbaikan_sarpras/create') ?>">
			Buat Permintaan
		</a>
	</li>
	<?php endif; ?>
	<?php if ($this->auth->has_permission('Perbaikan_sarpras.Perbaikan.Kpu')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/perbaikan/perbaikan_sarpras/periksakpu') ?>">
			KPU
		</a>
	</li>
	<?php endif; ?>
	<?php if ($this->auth->has_permission('Perbaikan_sarpras.Perbaikan.Ppk')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/perbaikan/perbaikan_sarpras/periksappk') ?>">
			PPK
		</a>
	</li>
	<?php endif; ?>
	 
	<?php if ($this->auth->has_permission('Perbaikan_sarpras.Perbaikan.Gedung')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/perbaikan/perbaikan_sarpras/gedunglist') ?>">
			Gedung Bangunan
		</a>
	</li>
	<?php endif; ?>
	<?php if ($this->auth->has_permission('Perbaikan_sarpras.Perbaikan.Jarkom')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/perbaikan/perbaikan_sarpras/jarkomlist') ?>">
			Jaringan
		</a>
	</li>
	<?php endif; ?>
	<?php if ($this->auth->has_permission('Perbaikan_sarpras.Perbaikan.Perlengkapan')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/perbaikan/perbaikan_sarpras/perlengkapanlist') ?>">
			Perlengkapan
		</a>
	</li>
	<?php endif; ?>
	<?php if ($this->auth->has_permission('Perbaikan_sarpras.Perbaikan.Lab')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/perbaikan/perbaikan_sarpras/lablist') ?>">
			Peralatan Lab
		</a>
	</li>
	<?php endif; ?>
	<?php if ($this->auth->has_permission('Perbaikan_sarpras.Perbaikan.Kalibrasi')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/perbaikan/perbaikan_sarpras/kalibrasilist') ?>">
			Kalibrasi
		</a>
	</li>
	<?php endif; ?>
</ul>
