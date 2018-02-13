<ul>
	<?php if ($this->auth->has_permission('Sppd_jabodetabek.Kepegawaian.Create')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/sppd_jabodetabek/create') ?>">
			Buat SPPD
		</a>
	</li>
	<?php endif; ?>
	<?php if($this->auth->has_permission('Sppd_jabodetabek.Kepegawaian.Periksa')): ?>
	  <li>
		  <a href="<?php echo site_url(SITE_AREA .'/kepegawaian/sppd_jabodetabek/listsppd') ?>">
			  Verifikasi SPPD
		  </a>
	  </li>
	<?php endif; ?>
	 
</ul>
