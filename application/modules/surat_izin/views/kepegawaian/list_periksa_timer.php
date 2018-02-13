<?php
$this->load->library('convert');
	$convert = new convert();
$num_columns	= 9;
$can_delete	= $this->auth->has_permission('Lupa_Timer.Kepegawaian.Delete');
$can_edit		= $this->auth->has_permission('Lupa_Timer.Kepegawaian.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	 <br>
	<ul class="nav nav-tabs">
		
		<?php if($this->auth->has_permission('Surat_Izin.Kepegawaian.Periksa')){ ?>
		<li<?php echo $idizin == '3' ? ' class="active"' : ''; ?>><?php echo anchor(base_url()."index.php/admin/kepegawaian/surat_izin/rekapvf/3", "Terlambat Hadir"); ?></li>
		<li<?php echo $idizin == '2' ? ' class="active"' : ''; ?>><?php echo anchor(base_url()."index.php/admin/kepegawaian/surat_izin/rekapvf/2", "Pulang Cepat"); ?></li>
		<li<?php echo $idizin == '1' ? ' class="active"' : ''; ?>><?php echo anchor(base_url()."index.php/admin/kepegawaian/surat_izin/rekapvfizin/1", "Tidak Masuk"); ?></li>
		<li<?php echo $idizin == '4' ? ' class="active"' : ''; ?>><?php echo anchor(base_url()."index.php/admin/kepegawaian/surat_izin/rekapvfizin/4", "Sakit"); ?></li>
		<li<?php echo $idizin == '20' ? ' class="active"' : ''; ?>><?php echo anchor(base_url()."index.php/admin/kepegawaian/surat_izin/list_periksa_timer", "Lupa Timer"); ?></li>
		<li<?php echo $idizin == '21' ? ' class="active"' : ''; ?>><?php echo anchor(base_url()."index.php/admin/kepegawaian/surat_izin/list_periksa_keluar", "Keluar Kantor"); ?></li>
		
		<?php } ?>
	</ul> 
	 <form action="<?php $this->uri->uri_string() ?>" method="get" accept-charset="utf-8">
	 <table>
        	<tr> 
            	<td>
                	<b>Kata Kunci</b>
                </td> 
                <td>
                	<b>Bulan</b>
                </td> 
                <td>
                	<b>Status</b>
                </td> 
            </tr> 
            <tr>
            	<td>
                	<input id='keyword' type='text' name='keyword' maxlength="20" value="<?php echo set_value('keyword', isset($keyword) ? $keyword : ''); ?>" />
                </td>
                 <td>
                	<select name="bulan" id="bulan"  style="width:150px" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>						 
						<option value="01" <?php if(isset($bulan))  echo  ($bulan=="01") ? "selected" : ""; ?>> Januari </option>
						<option value="02" <?php if(isset($bulan))  echo  ($bulan=="02") ? "selected" : ""; ?>> Februari </option>
						<option value="03" <?php if(isset($bulan))  echo  ($bulan=="03") ? "selected" : ""; ?>> Maret </option>
						<option value="04" <?php if(isset($bulan))  echo  ($bulan=="04") ? "selected" : ""; ?>> April </option>
						<option value="05" <?php if(isset($bulan))  echo  ($bulan=="05") ? "selected" : ""; ?>> Mei </option>
						<option value="06" <?php if(isset($bulan))  echo  ($bulan=="06") ? "selected" : ""; ?>> Juni </option>
						<option value="07" <?php if(isset($bulan))  echo  ($bulan=="07") ? "selected" : ""; ?>> Juli </option>
						<option value="08" <?php if(isset($bulan))  echo  ($bulan=="08") ? "selected" : ""; ?>> Agustus </option>
						<option value="09" <?php if(isset($bulan))  echo  ($bulan=="09") ? "selected" : ""; ?>> September </option>
						<option value="10" <?php if(isset($bulan))  echo  ($bulan=="10") ? "selected" : ""; ?>> Oktober </option>
						<option value="11" <?php if(isset($bulan))  echo  ($bulan=="11") ? "selected" : ""; ?>> November </option>
						<option value="12" <?php if(isset($bulan))  echo  ($bulan=="12") ? "selected" : ""; ?>> Desember </option>
						
					</select>
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
					<th>Tanggal Absen</th>
					<th>Absen</th>
					<th>Jam Sebernarnya</th>
					 
					<th>Status</th>
					<th>Tanggal Dibuat</th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				 
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						<a href="<?php echo base_url() ?>index.php/admin/kepegawaian/surat_izin/rekapvtimerxls/<?=$idizin?>/?keyword=<?=$keyword?>&bulan=<?=$bulan?>&status=<?=$status?>" class="btn btn-primary"> Download xls </a>
				
					</td>
				</tr>
				 
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
					<td><?php echo anchor(SITE_AREA . '/kepegawaian/lupa_timer/periksa/' . $record->id, '<span class="icon-pencil"></span>' .  $record->user_pengusul); ?></td>
				<?php else : ?>
					<td><?php e($record->user_pengusul); ?></td>
				<?php endif; ?>
					<td><?php e($convert->fmtDate($record->tanggal_absen,"dd month yyyy")) ?></td>
					 
					<td><?php e($record->absen) ?></td>
					<td><?php e($record->jam_sebenarnya) ?></td>
					 
					<td>
						<?php 
							 echo $record->status_atasan=="1" ? "<span class='label label-success'>Disetujui</span>":"" ;
							 echo $record->status_atasan=="2" ? "<span class='label label-danger'>Ditolak</span>":"" ;
							echo $record->status_atasan=="" ? "<span class='label label-warning'>Menunggu persetujuan</span>":"" ;
							echo $record->status_atasan=="0" ? "<span class='label label-warning'>Menunggu persetujuan</span>":"" ;
							if($record->status_atasan=="2"){
								echo "<br>Alasan: ".$record->alasan_ditolak;
							}
						?> 
					</td>
					<td><?php 
						if($record->date_created != "" and $record->date_created != "0000-00-00")
							e($convert->fmtDate($record->date_created,"dd month yyyy")) ?>
					</td>
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