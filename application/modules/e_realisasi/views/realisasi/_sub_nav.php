<ul class="nav nav-pills">
 
	<?php if ($this->auth->has_permission('E_Realisasi.Realisasi.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/realisasi/e_realisasi/ambildata') ?>">Ambil Data</a>
	</li>
	 <?php endif; ?>
</ul>