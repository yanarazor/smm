<?php

$num_columns	= 10;
$can_delete	= $this->auth->has_permission('Daftar_induk_rekaman.Rekaman.Delete');
$can_edit		= $this->auth->has_permission('Daftar_induk_rekaman.Rekaman.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	 <br>
	<form action="<?php $this->uri->uri_string() ?>" method="get" accept-charset="utf-8">
	 <table>
        	<tr>
				<td>
                	Penanggung Jawab
                </td>
                <td>:
                </td>
                <td>
                	<select name="pj" id="pj" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($bidangs) && is_array($bidangs) && count($bidangs)):?>
						<?php foreach($bidangs as $bidang):?>
							<option value="<?php echo $bidang->id?>" <?php if(isset($pj))  echo  ($bidang->id==$pj) ? "selected" : ""; ?>> <?php e(ucfirst($bidang->bidang)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
                	 
               	</td> 
               	</tr>
               	<tr>
            	<td>
                	Nama Rekaman
                </td>
                <td>:
                </td>
                <td>
                	<input id='ta' type='text' name='ta' maxlength="20" value="<?php echo set_value('ta', isset($ta) ? $ta : ''); ?>" />
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
					<th class="column-check" rowspan="2"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th rowspan="2">Nama</th>
					<th rowspan="2">Nomor</th>
					<th colspan="2">Lama Simpan</th>
					<th rowspan="2">Tempat Simpan</th>
					<th rowspan="2">Penanggung Jawab</th> 
					<th rowspan="2">Personil Penanggung Jawab</th> 
				</tr>
				<tr>
					<th>
						Aktif
					</th>
					<th>
						In Aktif
					</th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						<?php echo lang('bf_with_selected'); ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('daftar_induk_rekaman_delete_confirm'))); ?>')" />
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
					<td><?php echo anchor(SITE_AREA . '/rekaman/daftar_induk_rekaman/edit/' . $record->id, '<span class="icon-pencil"></span>' .  $record->nama); ?></td>
				<?php else : ?>
					<td><?php e($record->nama); ?></td>
				<?php endif; ?>
					<td><?php e($record->nomor) ?></td>
					<td><?php e($record->lama_simpan) ?></td>
					<td><?php e($record->lama_simpan_inactive) ?></td>
					<td><?php e($record->tempat_simpan) ?></td>
					<td><?php e($record->pj) ?></td> 
					<td><?php e($record->penanggung_jawab_personil) ?></td> 
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