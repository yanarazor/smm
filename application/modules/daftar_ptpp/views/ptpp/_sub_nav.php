<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/ptpp/daftar_ptpp') ?>">
		<i class="icon-list" <i=""></i> &nbsp;
		<?php echo lang('daftar_ptpp_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Daftar_ptpp.Ptpp.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/ptpp/daftar_ptpp/create') ?>">
		<i class="icon-plus" <i=""></i> &nbsp;
		<?php echo lang('daftar_ptpp_new'); ?></a>
	</li>
	<?php if(isset($link)){ ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/ptpp/daftar_ptpp/') ?>/<?php echo isset($link) ? $link : ""; ?>&audit=<?php echo isset($audit) ? $audit : ""; ?>&status=<?php echo isset($status_ptpp) ? $status_ptpp:""; ?>&bid=<?php echo isset($bid) ? $bid :""; ?>" target="_blank">
			<i class="icon-print" <i=""></i> &nbsp;
			Print
		</a>
	</li>
	<?php } ?>
	<?php endif; ?>
</ul>