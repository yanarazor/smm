<?php

$num_columns	= 12;
$can_delete	= $this->auth->has_permission('Surat_Izin.Kepegawaian.Delete');
$can_edit		= $this->auth->has_permission('Surat_Izin.Kepegawaian.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	 
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
					<th>Status Atasan</th>
					<th>Tanggal Dibuat</th>
				</tr>
			</thead>
			<tfoot>
				 
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
					</td>
				</tr>
				 
			</tfoot>
			 
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
					<td><?php echo anchor(SITE_AREA . '/kepegawaian/surat_izin/periksa/' . $record->id, '<span class="icon-pencil"></span>' .  $record->user_pengusul); ?></td>
				<?php else : ?>
					<td><?php e($record->user_pengusul); ?></td>
				<?php endif; ?>
					<td><?php e($record->nama_izin) ?></td>
					<td><?php e($record->lama) ?> <?php e($record->satuan) ?></td>

					<td><?php e($record->hari) ?></td>
					<td><?php e($record->tanggal) ?></td>
					<td><?php e($record->tanggal_selesai) ?></td>
					<td><?php e($record->alasan) ?></td>
					<td>
						<?php 
							 echo $record->status_atasan=="1" ? "<span class='label label-success'>Ya</span>":"" ;
							 echo $record->status_atasan=="2" ? "<span class='label label-warning'>Tidak Setuju</span>":"" ;
						?> 
					</td>
					<td><?php e($record->tanggal_dibuat) ?></td>
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