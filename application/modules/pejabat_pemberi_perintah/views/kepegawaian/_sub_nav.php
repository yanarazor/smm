<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/pejabat_pemberi_perintah') ?>"><?php echo lang('pejabat_pemberi_perintah_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Pejabat_Pemberi_Perintah.Kepegawaian.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/pejabat_pemberi_perintah/create') ?>"><?php echo lang('pejabat_pemberi_perintah_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>