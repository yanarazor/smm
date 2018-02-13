<?php
	$this->load->library('convert');
	$convert = new convert();

$num_columns	= 8;
$can_delete	= $this->auth->has_permission('Absen.Kepegawaian.Delete');
$can_edit		= $this->auth->has_permission('Absen.Kepegawaian.Edit');
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
                	<b>Tanggal</b>
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
                	 <input id='nip' type='text' style="width:150px" name='nip' maxlength="20" value="<?php echo set_value('nip', isset($nip) ? $nip : ''); ?>" />
                </td>
                <td>
					<input id='nama' type='text' name='nama' maxlength="100" value="<?php echo set_value('nama', isset($nama) ? $nama : ''); ?>" />
					 
                </td>
                 <td>
					<input id='tgl' type='text' style="width:100px" name='tgl' value="<?php echo set_value('tgl', isset($tgl) ? $tgl : ''); ?>" />
					
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
                 <td>
					<input id='tahun' type='text' name='tahun' style="width:100px" value="<?php echo set_value('tahun', isset($tahun) ? $tahun : ''); ?>" />
					
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
					
					<th>Nik</th>
					<th>Nama</th>
					
					<th>Tanggal</th>
					<th>Jam</th>
					 
					<th>Verifikasi</th>
					<th>Model</th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						<?php echo lang('bf_with_selected'); ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('absen_delete_confirm'))); ?>')" />
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
					<td><?php echo anchor(SITE_AREA . '/kepegawaian/absen/edit/' . $record->id, '<span class="icon-pencil"></span>' .  $record->nik); ?></td>
				<?php else : ?>
					<td><?php e($record->nik); ?></td>
				<?php endif; ?>
					<td><?php e($record->nama) ?></td>
					<td>
					<?php
					//$date = '2015-04-22';
					  $weekday = date('l', strtotime($record->tanggal)); // note: first arg to date() is lower-case L
					  echo $convert->getday($weekday); // SHOULD display Wednesday
					?>,
					<?php e($convert->fmtDate($record->tanggal,"dd month yyyy")) ?></td>
					<td><?php e($record->jam) ?></td>
					 
					<td><?php e($record->verifikasi) ?></td>
					<td><?php e($record->model) ?></td>
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