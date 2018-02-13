<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/sppd') ?>"><?php echo lang('sppd_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('sppd.Kepegawaian.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/sppd/create') ?>"><?php echo lang('sppd_new'); ?></a>
	</li>
	<?php endif; ?>
	<li <?php echo $this->uri->segment(4) == 'print' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/sppd/printsppd/') ?><?php if(isset($id)) echo "/".$id; ?>" target="_blank">Print</a>
	</li>
	<li <?php echo $this->uri->segment(4) == 'reprint' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/sppd/reprintsppd/') ?><?php if(isset($id)) echo "/".$id; ?>" target="_blank">Print Ulang</a>
	</li>
</ul>