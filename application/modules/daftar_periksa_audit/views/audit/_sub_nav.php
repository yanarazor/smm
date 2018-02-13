<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/audit/daftar_periksa_audit') ?>"><?php echo lang('daftar_periksa_audit_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Daftar_Periksa_Audit.Audit.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/audit/daftar_periksa_audit/create') ?>"><?php echo lang('daftar_periksa_audit_new'); ?></a>
	</li>
	<?php endif; ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/audit/daftar_periksa_audit/') ?>/<?php echo isset($link) ? $link : ""; ?>&ai=<?php echo isset($ai) ? $ai : ""; ?>&bidang=<?php echo isset($bidang) ? $bidang : ""; ?>" target="_blank">
			<i class="icon-print" <i=""></i> &nbsp;
			Print
		</a>
	</li>
</ul>