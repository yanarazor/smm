<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/skp') ?>"><?php echo lang('skp_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Skp.Kepegawaian.Create') and $this->uri->segment(4) != "create" and $this->uri->segment(4) != "edit") : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/skp/create') ?>">Tambah</a>
	</li>
	<?php endif; ?>
	<?php if ($this->auth->has_permission('Skp.Kepegawaian.Create') and isset($nip) and isset($tahun)) : ?>
	<li <?php echo $this->uri->segment(4) == 'laporan' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/skp/laporan') ?>/<?php echo isset($tahun) ? $tahun : "";  ?>/<?php echo isset($nip) ? $nip : "";  ?>">Laporan SKP</a>
	</li>
	<?php endif; ?>
</ul>