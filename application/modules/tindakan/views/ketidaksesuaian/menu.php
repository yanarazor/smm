<ul>
	<?php if ($this->auth->has_permission('Tindakan.Ketidaksesuaian.Create')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/ketidaksesuaian/tindakan/create') ?>">
			<?php echo lang('bf_add_new'); ?></a>
	</li>
	<?php endif; ?>
	 
</ul>
