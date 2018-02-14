<?php

$num_columns	= 12;
$can_delete	= $this->auth->has_permission('Pegawai.kepegawaian.Delete');
$can_edit		= $this->auth->has_permission('Pegawai.kepegawaian.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
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
					<th rowspan="2" class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					<th rowspan="2">NIP</th>
					<th rowspan="2">No Absen</th>
					<th rowspan="2">Nama</th>
					<th rowspan="2">Jabatan</th>
					<th rowspan="2">Golongan</th>
					<th rowspan="2">Nomor Rekening</th>
					<th rowspan="2">SKP</th>
					<th colspan="3">Cuti</th>
				</tr>
				<tr>
					<th>Tahun ini</th>
					<th>Telah Diambil</th>
					<th>Sisa</th>
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
						$sisa = 0;
				?>
				<tr>
					<?php if ($can_delete) : ?>
					<td class="column-check"><input type="checkbox" name="checked[]" value="<?php echo $record->id; ?>" /></td>
					<?php endif;?>
					
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/kepegawaian/pegawai/edit/' . $record->id, '<span class="icon-pencil"></span>' .  $record->nip); ?></td>
				<?php else : ?>
					<td><?php e($record->nip); ?></td>
				<?php endif; ?>
					<td><?php e($record->no_absen) ?></td>
					<td><?php e($record->nama) ?></td>
					<td><?php e($record->nama_jabatan) ?>
						FT : <?php e($record->jabatan_ft) ?><br>
						FU : <?php e($record->jabatan_fu) ?>
					</td>
					<td><?php e($record->pangkat) ?>/<?php e($record->gol) ?></td>
					<td><?php e($record->nomor_rekening) ?></td>
					<td><?php e($record->skp) ?></td>
					<td><?php 
						$cuti = (int)$record->sisa_cuti;
						e($record->sisa_cuti); 
					?>
					</td>
					<td><?php 
					$diambil =isset($datacutis[$record->no_absen]) ? (double)$datacutis[$record->no_absen] : 0;
					echo isset($datacutis[$record->no_absen]) ? $datacutis[$record->no_absen] : 0; ?></td>
					<td><?php 
					$sisa = $cuti - $diambil;
					echo $sisa; ?>
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