<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/audit/jadwal_audit') ?>" id="list"><?php echo lang('jadwal_audit_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Jadwal_Audit.Audit.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/audit/jadwal_audit/create') ?>" id="create_new"><?php echo lang('jadwal_audit_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>