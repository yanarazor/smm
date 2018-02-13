<ul>
	<?php if ($this->auth->has_permission('Surat_Izin.Kepegawaian.Create')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/surat_izin/terlambat') ?>">
			Terlambat Hadir
		</a>
	</li>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/surat_izin/plgcepat') ?>">
			Pulang Cepat
		</a>
	</li>

	<li>
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/izin_keluar/create') ?>">
			Izin Meninggalkan Tempat Kerja
		</a>
	</li>

	<li>
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/surat_izin/tidakmasuk') ?>">
			Tidak Masuk/Cuti
		</a>
	</li>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/surat_izin/sakit') ?>">
			Sakit
		</a>
	</li>
	<?php if ($this->auth->has_permission('Lupa_timer.Kepegawaian.Create')) : ?>
		<li>
			<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/lupa_timer/create') ?>">
				Lupa Timer
			</a>
		</li>
	<?php endif; ?>
	<?php if ($this->auth->has_permission('Surat_Izin.Kepegawaian.Other')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/surat_izin/other') ?>">
			Izin Lain
		</a>
	</li>
	<?php endif; ?>
	
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/surat_izin/rekap') ?>">
			Rekap Saya
		</a>
	</li>
	<?php endif; ?>
	<?php if($this->auth->has_permission('Surat_Izin.Kepegawaian.Periksa')): ?>
	  <li>
		  <a href="<?php echo site_url(SITE_AREA .'/kepegawaian/surat_izin/rekapvf') ?>">
			  Permintaan Izin Bawahan
		  </a>
	  </li>
	<?php endif; ?>
	<?php if ($this->auth->has_permission('Surat_Izin.Kepegawaian.Rekap')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/surat_izin/resume') ?>">
			Rekap Izin
		</a>
	</li>
	<?php endif; ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/surat_izin/sisacuti') ?>">
			Sisa Cuti
		</a>
	</li>
</ul>
