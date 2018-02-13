<ul class="nav nav-pills">
	 
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/audit/rekapitulasi_laporan_audit/') ?>/<?php echo isset($link) ? $link : ""; ?>&status=<?php echo isset($status_ptpp) ? $status_ptpp : "";?>&ai=<?php echo isset($ai) ? $ai : ""; ?>&bidang=<?php echo isset($id_bidang) ? $id_bidang : ""; ?>" target="_blank">
			<i class="icon-print" <i=""></i> &nbsp;
			Print
		</a>
	</li>
</ul>