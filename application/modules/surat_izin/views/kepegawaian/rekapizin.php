<?php
	$this->load->library('convert');
	$convert = new convert();

$num_columns	= 12;
$can_delete	= $this->auth->has_permission('Surat_Izin.Kepegawaian.Delete');
$can_edit		= $this->auth->has_permission('Surat_Izin.Kepegawaian.Edit');
$has_records	= isset($records) && is_array($records) && count($records);
//$idizin = $this->uri->segment(5);
?>
<div class="admin-box">
	 <br>
	<ul class="nav nav-tabs">
		<li<?php echo $idizin == '3' ? ' class="active"' : ''; ?>><?php echo anchor(base_url()."index.php/admin/kepegawaian/surat_izin/rekap/3", "Terlambat Hadir"); ?></li>
		<li<?php echo $idizin == '2' ? ' class="active"' : ''; ?>><?php echo anchor(base_url()."index.php/admin/kepegawaian/surat_izin/rekap/2", "Pulang Cepat"); ?></li>
		<li<?php echo $idizin == '1' ? ' class="active"' : ''; ?>><?php echo anchor(base_url()."index.php/admin/kepegawaian/surat_izin/rekapizin/1", "Tidak Masuk"); ?></li>
		<li<?php echo $idizin == '4' ? ' class="active"' : ''; ?>><?php echo anchor(base_url()."index.php/admin/kepegawaian/surat_izin/rekapizin/4", "Sakit"); ?></li>
		<li<?php echo $idizin == '20'? ' class="active"' : ''; ?>><?php echo anchor(base_url()."index.php/admin/kepegawaian/surat_izin/lupa_timer/", "Lupa Timer"); ?></li>
		<li<?php echo $idizin == '21'? ' class="active"' : ''; ?>><?php echo anchor(base_url()."index.php/admin/kepegawaian/surat_izin/keluar/", "Keluar Kantor"); ?></li>
		
	</ul> 
	 <form action="<?php $this->uri->uri_string() ?>" method="get" accept-charset="utf-8">
	 <table>
        	<tr> 
            	<td>
                	<b>Kata Kunci</b>
                </td> 
                 
                <td>
                	<b>Status</b>
                </td> 
            </tr> 
            <tr>
            	<td>
                	<input id='keyword' type='text' name='keyword' maxlength="20" value="<?php echo set_value('keyword', isset($keyword) ? $keyword : ''); ?>" />
                </td>
                 
				<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                	<label class='radio' for='1'>
						<input id='status1' name='status' type='radio' value='1' <?php echo $status=="1" ? "checked" : "" ?> />
						Oke
					</label>
					</br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='radio' for='2'>
						<input id='status2' name='status' type='radio' value='2' <?php echo $status=="2" ? "checked" : "" ?> />
						Tidak
					</label>
                </td>
                <td valign="top">
                	 <input type="submit" name="Act" class="btn btn-primary" value="Cari "  />
               	</td> 
            </tr>
            
        </table>
    <?php echo form_close(); ?>
   <div class="alert alert-block alert-warning fade in ">
      <a class="close" data-dismiss="alert">&times;</a>
       Jumlah :  <?php echo isset($total) ? $total : ''; ?>
    </div>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th>User</th>
					<th>izin</th>
					<th>Selama</th>
					<th>Hari</th>
					<th>Dari Tanggal</th>
					<th>Sampai Tanggal</th>
					<th>Alasan</th>
					<th>Catatan</th>
					<th>Status Atasan</th>
					<th>Tanggal Dibuat</th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						<?php echo lang('bf_with_selected'); ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('surat_izin_delete_confirm'))); ?>')" />
					</td>
				</tr>
				<?php endif; ?>
			</tfoot>
			<?php endif; ?>
			<tbody>
				<?php
				if ($has_records) :
					foreach ($records as $record) :
				?>
				<tr>
					<?php if ($can_delete) : ?>
					<td class="column-check"><input type="checkbox" name="checked[]" value="<?php echo $record->id; ?>" /></td>
					<?php endif;?>
					
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/kepegawaian/surat_izin/'.$modul.'/' . $record->id, '<span class="icon-pencil"></span>' .  $record->user_pengusul); ?></td>
				<?php else : ?>
					<td><?php e($record->user_pengusul); ?></td>
				<?php endif; ?>
					<td><?php e($record->nama_izin) ?></td>
					<td><?php e($record->lama) ?> <?php e($record->satuan) ?></td>

					<td><?php e($record->hari) ?></td>
					<td><?php e($convert->fmtDate($record->tanggal,"dd month yyyy")) ?></td>
					<td><?php e($convert->fmtDate($record->tanggal_selesai,"dd month yyyy")) ?></td>
					<td><?php e($record->alasan) ?></td>
					<td><?php e($record->catatan) ?></td> 
					<td>
						<?php 
							 echo $record->status_atasan=="1" ? "<span class='label label-success'>Disetujui</span>":"" ;
							 echo $record->status_atasan=="2" ? "<span class='label label-danger'>Ditolak</span>":"" ;
							  echo $record->status_atasan=="" ? "<span class='label label-warning'>Menunggu persetujuan</span>":"" ;
							if($record->status_atasan=="2"){
								echo "<br>Alasan: ".$record->alasan_ditolak;
							}
						?> 
					</td>
					<td><?php e($convert->fmtDate($record->tanggal_dibuat,"dd month yyyy")) ?></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">No records found that match your selection.</td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php echo form_close(); ?>
	 <?php echo $this->pagination->create_links(); ?>
</div>