<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/reports/laporan_ketidaksesuaian') ?>" id="list"><?php echo lang('laporan_ketidaksesuaian_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Laporan_Ketidaksesuaian.Reports.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/reports/laporan_ketidaksesuaian/create') ?>" id="create_new"><?php echo lang('laporan_ketidaksesuaian_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>