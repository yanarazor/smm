<ul>
	<?php if ($this->auth->has_permission('Laporan_Ketidaksesuaian.Ketidaksesuaian.Create')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/ketidaksesuaian/laporan_ketidaksesuaian/create') ?>">
			<?php echo lang('bf_add_new'); ?></a>
	</li>
	<?php endif; ?>
	 
</ul>
