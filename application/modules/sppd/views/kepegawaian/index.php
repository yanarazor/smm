<script src="http://localhost/simpedas/themes/admin/plugins/jQuery/jquery-2.2.3.min.js"></script>
<?php
$this->load->library('convert');
$convert = new convert();
$num_columns	= 15;
$can_delete	= $this->auth->has_permission('sppd.Kepegawaian.Delete');
$can_edit		= $this->auth->has_permission('sppd.Kepegawaian.Edit');
$has_records	= isset($records) && is_array($records) && count($records) && $total>0;

?>
<div class="admin-box">
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
                	<b>Tahun</b>
                </td>  
                
            </tr> 
            <tr>
            	<td>
                	<input id='keyword' type='text' name='keyword' maxlength="20" value="<?php echo set_value('keyword', isset($keyword) ? $keyword : ''); ?>" />
                </td>
                
				<td>
					<select name="bulan" id="bulan"  style="width:150px" class="chosen-select-deselect">
						<option value="">-- Pilih Bulan --</option>						 
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
                <td>
					<input id='tahun' type='text' name='tahun' style="width:100px" value="<?php echo set_value('tahun', isset($tahun) ? $tahun : ''); ?>" />
					
                </td>
                <td valign="top">
                	 <input type="submit" name="Act" class="btn btn-primary" value="Cari "  />
               	</td> 
            
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
					
					<th>Pejabat Berwenang Memberi Perintah</th>
					<th>Pegawai</th>
					<th>Maksud Perjalanan Dinas</th>
					<th>Anggaran</th>
					<th>Kegiatan</th>
					<th>Angkutan</th>
					<th>Tempat Berangkat</th>
					<th>Instansi Tujuan</th>
					<th>Provinsi</th>
					<th>Berangkat</th>
					<th>Jam Berangkat</th>
					<th>Status</th>
					<th>Laporan <br> Perjalanan</th>
					<th>SPJ</th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						<?php echo lang('bf_with_selected'); ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('sppd_delete_confirm'))); ?>')" />
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
					<td><?php echo anchor(SITE_AREA . '/kepegawaian/sppd/edit/' . $record->id, '<span class="icon-pencil"></span>' .  $record->nama); ?></td>
				<?php else : ?>
					<td><?php e($record->nama); ?></td>
				<?php endif; ?>
					<td><?php e($record->display_name) ?></td>
					<td><?php e($record->maksud) ?></td>
					<td><?php e($record->anggaran) ?></td>
					<td>
						<?php e($record->no_keg) ?>-
						<?php e($record->judul_kegiatan) ?>
					</td>
					<td><?php e($record->angkutan) ?></td>
					<td><?php e($record->tempat_berangkat) ?></td>
					<td><?php e($record->instansi_tujuan) ?></td>
					<td><?php e($record->prov) ?></td>
					<td>
						<?php e($record->hari) ?>
						<?php 
						 if($record->tanggal_berangkat != '' and $record->tanggal_berangkat != "0000-00-00")
						  {
						  	e($convert->fmtDate($record->tanggal_berangkat,"dd month yyyy"));
						  }
						
						?>
					</td>
					 
					<td><?php e($record->jam_berangkat) ?></td>
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
					<td>
						<?php if($record->laporan_perjalanan_text != ""){ ?>
						<a href="<?php echo base_url();?>admin/kepegawaian/sppd/createlaporan/<?php echo isset($record->id) ? $record->id : ''; ?>" class="show-modal" tooltip="Laporan Perjalanan">
						<?php
						echo $record->laporan_perjalanan_text !="" ? "<span class='label label-success'><i class='fa fa-eye'></i> Sudah</span>":"" ;
						?>
						</a>
						
						<?php }else{ 
						?>
						<a href="<?php echo base_url();?>admin/kepegawaian/sppd/createlaporan/<?php echo isset($record->id) ? $record->id : ''; ?>" class="show-modal" tooltip="Laporan Perjalanan">
						<?php
						echo $record->laporan_perjalanan_text =="" ? "<span class='label label-warning'>Belum</span>":"" ;
						?>
						</a>
						<?php
						} 
						?>
						
					</td>
					<td>
						<?php 
							 echo $record->status_pj =="1" ? "<span class='label label-success'>Sudah</span>":"" ;
							 echo $record->status_pj =="0" ? "<span class='label label-danger'>Belum</span>":"" ;
						?> 
					</td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan="13">No records found that match your selection.</td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php echo form_close(); ?>
	 <?php echo $this->pagination->create_links(); ?>
</div>