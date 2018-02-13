<?php

$num_columns	= 10;
$can_delete	= $this->auth->has_permission('Pegawai.Masters.Delete');
$can_edit		= $this->auth->has_permission('Pegawai.Masters.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<h3>Pegawai</h3>
	<form action="<?php $this->uri->uri_string() ?>" method="get" accept-charset="utf-8">
	 <table>
        	<tr> 
            	<td>
                	<b>NIP</b>
                </td>
				<td>
                	<b>Nama</b>
                </td>
                <td>
                	 
                </td>
                
            </tr>
            <tr>
            	<td>
                	 <input id='nip' type='text' style="width:150px" name='nip' maxlength="20" value="<?php echo set_value('nip', isset($nip) ? $nip : ''); ?>" />
                </td>
                <td>
					<input id='nama' type='text' name='nama' maxlength="100" value="<?php echo set_value('nama', isset($nama) ? $nama : ''); ?>" />
					 
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
					
					<th>NIP</th>
					<th>No Absen</th>
					<th>Nama</th>
					<th>Jabatan ST <br> Grade</th>
					<th>Jabatan FT<br> Grade</th>
					<th>Jabatan FU<br> Grade</th>
					<th>Pangkat/Golongan</th>
					<th>Nomor Rekening</th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						<?php echo lang('bf_with_selected'); ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('pegawai_delete_confirm'))); ?>')" />
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
					<td><?php echo anchor(SITE_AREA . '/masters/pegawai/edit/' . $record->id,  $record->nip); ?></td>
				<?php else : ?>
					<td><?php e($record->nip); ?></td>
				<?php endif; ?>
					<td><?php e($record->no_absen) ?></td>
					<td><?php e($record->nama) ?></td>
					<td><?php e($record->jabatan) ?> <?php echo $record->grade != "" ? "| ".$record->grade : "" ?></td>
					<td><?php e($record->jabatan_ft) ?> <?php echo $record->grade_ft != "" ? "| ".$record->grade_ft : "" ?></td>
					<td><?php e($record->jabatan_fu) ?> <?php echo $record->grade_fu != "" ? "| ".$record->grade_fu : "" ?></td>
					<td><?php e($record->pangkat) ?>/<?php e($record->gol) ?></td>
					<td><?php e($record->nomor_rekening) ?></td>
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
	<center>
	    <?php echo $this->pagination->create_links(); ?>
	</center>
</div>