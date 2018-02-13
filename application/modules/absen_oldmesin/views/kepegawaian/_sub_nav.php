<ul class="nav nav-pills">
	 <?php if ($this->auth->has_permission('Absen.Kepegawaian.Rekap')) : ?>
		<li <?php echo $this->uri->segment(4) == 'rekapum' ? 'class="active"' : '' ?> >
			<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/absen/rekapum') ?>" id="rekap">Uang Makan</a>
		</li>
	<?php endif; ?>
	 <?php if ($this->auth->has_permission('Absen.Kepegawaian.Rekap')) : ?>
		<li <?php echo $this->uri->segment(4) == 'rekap' ? 'class="active"' : '' ?> >
			<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/absen/rekap') ?>" id="rekap">Rekap</a>
		</li>
	<?php endif; ?>
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/absen') ?>" id="rekap">List</a>
	</li>
	<?php if ($this->auth->has_permission('Absen.Kepegawaian.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/absen/create') ?>"><?php echo lang('absen_new'); ?></a>
	</li>
	<?php endif; ?>
	
	<?php if ($this->auth->has_permission('Absen.Kepegawaian.Upload')) : ?>
	   <li <?php echo $this->uri->segment(4) == 'upload' ? 'class="active"' : '' ?> >
		   <a href="<?php echo site_url(SITE_AREA .'/kepegawaian/absen/upload') ?>" id="upload">Upload</a>
	   </li>
	<?php endif; ?>
</ul>