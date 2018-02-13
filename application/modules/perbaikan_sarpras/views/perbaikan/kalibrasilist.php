<?php

$num_columns	= 11;
$can_delete	= $this->auth->has_permission('Perbaikan_sarpras.Perbaikan.Delete');
$can_edit		= $this->auth->has_permission('Perbaikan_sarpras.Perbaikan.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<form action="<?php $this->uri->uri_string() ?>" method="get" accept-charset="utf-8">
	 <table>
        	<tr> 
            	<td>
                	<b>Nomor</b>
                </td> 
                <td>
                	<b>user</b>
                </td>   
                 <td>
                	<b>Status</b>
                </td> 
            </tr> 
            <tr>
            	<td>
                	<input id='keyword' type='text' name='keyword' maxlength="20" value="<?php echo set_value('keyword', isset($keyword) ? $keyword : ''); ?>" />
                </td>
                
				<td valign="top">
					<select name="pg" id="pg" class="chosen-select-deselect">
						<option value="">-- Pegawai  --</option>
						<?php if (isset($users) && is_array($users) && count($users)):?>
						<?php foreach($users as $rec):?>
							<option value="<?php echo $rec->id?>" <?php if(isset($pg))  echo  ($rec->id==$pg) ? "selected" : ""; ?>> <?php e(ucfirst($rec->display_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
                </td>
                
                <td>
                	<select name="status" id="status" >
						<option value="">-- Pilih  --</option>
						<?php if (isset($status_pemeliharaans) && is_array($status_pemeliharaans) && count($status_pemeliharaans)):?>
						<?php foreach($status_pemeliharaans as $rec):?>
							<option value="<?php echo $rec->id?>" <?php if(isset($status))  echo  ($rec->id==$status) ? "selected" : ""; ?>> <?php e(ucfirst($rec->status_perbaikan)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
                	 
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
					
					<th>Nomor</th>
					<th>Jenis Pemeliharaan</th>
					<th>Nama Sarpras</th>
					<th>Nomor Inventaris</th>
					<th>Model</th>
					<th>User</th>
					<th>Tanggal Kirim</th>
					<th>Catatan</th>
					<th>Rekomendasi</th>
					<th>Status</th>
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
					<td><?php echo anchor(SITE_AREA . '/perbaikan/perbaikan_sarpras/perbaikankalibrasi/' . $record->id, '<span class="icon-pencil"></span>' .  $record->nomor); ?></td>
				<?php else : ?>
					<td><?php e($record->nomor); ?></td>
				<?php endif; ?>
					<td><?php e($record->jenis_perbaikan) ?></td>
					<td><?php e($record->nama_sarpras) ?></td>
					<td><?php e($record->nomor_inventaris) ?></td>
					<td><?php e($record->model_type) ?></td>
					<td><?php e($record->display_name) ?></td>
					<td><?php e($record->tanggal_kirim) ?></td>
					<td><?php echo $record->catatan_kpu; ?></td>
					<td><?php echo $record->rekomendasi; ?></td>
					<td align="center">
						<span class='label <?php echo $record->status == "8" ? "label-success": "label-warning" ?>'>
							<?php e($record->status_perbaikan) ?>
						</span>
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
</div>