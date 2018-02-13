<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/sppd_jabodetabek') ?>"><?php echo lang('sppd_jabodetabek_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('SPPD_Jabodetabek.Kepegawaian.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/sppd_jabodetabek/create') ?>"><?php echo lang('sppd_jabodetabek_new'); ?></a>
	</li>
	<?php endif; ?>
	<li <?php echo $this->uri->segment(4) == 'print' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/sppd_jabodetabek/printsppd/') ?><?php if(isset($id)) echo "/".$id; ?>">Print</a>
	</li>
</ul>