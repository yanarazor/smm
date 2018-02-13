<?php

$num_columns	= 16;
$can_delete	= $this->auth->has_permission('Laporan_Ketidaksesuaian.Ketidaksesuaian.Delete');
$can_edit		= $this->auth->has_permission('Laporan_Ketidaksesuaian.Ketidaksesuaian.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
<br>
	 <ul class="nav nav-tabs">
	
		<li<?php echo $filter_type == 'all' ? ' class="active"' : ''; ?>><?php echo anchor(base_url()."index.php/admin/ketidaksesuaian/laporan_ketidaksesuaian", "Usulan"); ?></li>
		<?php if($this->auth->has_permission('Laporan_Ketidaksesuaian.Ketidaksesuaian.pengecekan')){ ?>
		<li<?php echo $filter_type == 'periksa' ? ' class="active"' : ''; ?>><?php echo anchor(base_url()."index.php/admin/ketidaksesuaian/laporan_ketidaksesuaian/list_periksa", "Periksa"); ?></li>
		<?php } ?>
		<?php if($this->auth->has_permission('Laporan_Ketidaksesuaian.Ketidaksesuaian.pengesahan')){ ?>
		<li<?php echo $filter_type == 'penyelesaian' ? ' class="active"' : ''; ?>><?php echo anchor(base_url()."index.php/admin/ketidaksesuaian/laporan_ketidaksesuaian/list_penyelesaian", "Penyelesaian"); ?></li>
		 <?php } ?>
		 
	</ul>
    <form action="<?php $this->uri->uri_string() ?>" method="get" accept-charset="utf-8">
	 <table>
        	<tr>
				<td>
                	Status
                </td>
                <td>:
                </td>
                <td>
                	<select name="tindakan" id="tindakan" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($tindakans) && is_array($tindakans) && count($tindakans)):?>
						<?php foreach($tindakans as $tindakan):?>
							<option value="<?php echo $tindakan->id?>" <?php if(isset($tindakan))  echo  ($tindakan->id==$tindakan) ? "selected" : ""; ?>> <?php e(ucfirst($tindakan->tindakan)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
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
					
					<th>Nomor</th>
					<th>Kegiatan</th>
					<th>Penanggung Jawab</th>
					<th>Tanggal Penemuan</th>
					<th>Bidang</th>
					<th>Ketidaksesuaian</th>
					<th>Seharusnya</th>
					<th>Status Verifikasi</th>
					<th>Tindakan</th>
					<th>Tgl Verifikasi</th>
					<th>Tgl Persetujuan Kabid</th>
					<th>Keterangan</th>
					<th>Batas Waktu Penyelesaian</th>
					<th>Status Close</th>
					<th>Tgl Close</th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						<?php echo lang('bf_with_selected'); ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('laporan_ketidaksesuaian_delete_confirm'))); ?>')" />
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
					<td><?php echo anchor(SITE_AREA . '/ketidaksesuaian/laporan_ketidaksesuaian/'.$action.'/' . $record->id, '<span class="icon-pencil"></span>' .  $record->id); ?></td>
				<?php else : ?>
					<td><?php e($record->id); ?></td>
				<?php endif; ?>
					<td><?php e($record->kegiatan) ?></td>
					<td><?php e($record->user_penanggung_jawab) ?></td>
					<td><?php e($record->tanggal_penemuan) ?></td>
					<td><?php e($record->bidang) ?></td>
					<td><?php e($record->ketidaksesuaian) ?></td>
					<td><?php e($record->seharusnya) ?></td>
					<td>
					<?php if($record->status_evaluasi_swm!=""){
								echo $record->status_evaluasi_swm=="1" ? "<span class='label label-success'>Setuju</span>":"<span class='label label-warning'>Tidak Setuju</span>" ;
							}
					?>
					</td>
					<td><?php e($record->tindakan) ?></td>
					<td><?php e($record->tgl_persetujuan_swm) ?></td>
					<td><?php e($record->tgl_persetujuan_kabid) ?></td>
					<td><?php e($record->keterangan) ?></td>
					<td><?php e($record->batas_waktu_penyelesaian) ?></td>
					<td>
					<?php
						echo $record->status_close=="1" ? "<span class='label label-success'>Closed</span>":"<span class='label label-warning'>Open</span>" ;
					?>
					</td>
					<td>
					<?php 
					   if($record->status_close=="1"){
						   e($record->tgl_close);
					   }
					?></td>
					
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
</div>