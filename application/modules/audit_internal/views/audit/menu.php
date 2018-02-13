<ul>
	<?php if ($this->auth->has_permission('Audit_Internal.Audit.Create')) : ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/audit/audit_internal/create') ?>">
			<?php echo lang('bf_add_new'); ?></a>
	</li>
	<?php endif; ?>
	 
</ul>
