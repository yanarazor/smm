<ul>
	<?php if ($this->auth->has_permission('sppd.Kepegawaian.Create')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/sppd/create') ?>">
			Buat SPD
		</a>
	</li>
	<?php endif; ?>
	<?php if($this->auth->has_permission('sppd.Kepegawaian.Periksa')): ?>
	  <li>
		  <a href="<?php echo site_url(SITE_AREA .'/kepegawaian/sppd/listsppd') ?>">
			  Verifikasi SPD
		  </a>
	  </li>
	<?php endif; ?>
	 
</ul>
