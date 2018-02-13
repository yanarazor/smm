<style>
hr {
  margin: 5px 0;
  border-bottom: 1px solid #fefefe;
}
@media print {
    body {
		 font-family: 'Arial';
		 font-size: 12px;
		 font-style: normal;
		 font-variant: normal;
    }
    hr {
	  margin: 5px 0;
	  border-bottom: 1px solid #fefefe;
	}
    .headjudul {
		font-size : 34pt;
    }
    .headjudul1 {
		font-size : 17pt;
    }
    .headjudul2 {
		font-size : 14pt;
    }
    .headjudul3 {
		font-size : 22pt;
    }
	table {
		border-collapse: collapse;
		
	}
	table .tabel{
		font-size: 20pt;
	}
	table .tabel{
		font-size: 20pt;
	}
	td{
		padding:2px;
	}
	.checkboxOne {
		width: 40px;
		height: 40px;
		background-color: #e9ecee;
		color: #99a1a7;
		border: 1px solid #adb8c0;
	}
	@font-face {
		font-family: 'Arial';
	}
	/* use this class to attach this font to any element i.e. <p class="fontsforweb_fontid_507">Text with this font applied</p> */
	.btnprint{
		display: none;
	}
}
</style>
<?php

$num_columns	= 10;
$can_delete	= $this->auth->has_permission('Daftar_Periksa_Audit.Audit.Delete');
$can_edit		= $this->auth->has_permission('Daftar_Periksa_Audit.Audit.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	 
	<?php echo form_open($this->uri->uri_string()); ?>
		<center><b>Daftar Periksa Audit</b></center>
		<table border="1" width="100%">
			<thead>
				<tr>
					
					<th class="column-check">No</th>

					<th>Audit</th>
					<th  width="30%">Klausul Iso
					/Deskripsi</th>
					<th width="40%">Bukti Obyektif/Kesesuaian</th>
					<th >Bidang/
					Tanggal/Auditor</th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				 
			</tfoot>
			<?php endif; ?>
			<tbody>
				<?php
				if ($has_records) :
					$no = 1;
					foreach ($records as $record) :

				?>
				<tr>
					<td class="column-check" valign="top"><?php echo $no; ?>.</td>
					
				 
					<td valign="top"><?php e($record->judul); ?></td>
				 
					<td valign="top">
						<b><u>Klausul ISO </u></b> :
						<?php echo $record->klausul_iso; ?>
						<br>
						<b><u>Deskripsi </u></b> :
						<?php echo $record->deskripsi; ?>
					</td>
					<td valign="top">
					<b><u>Bukti Objektif</u></b> : <?php echo $record->bukti_obyektif; ?> <br>
					<b><u>Kesesuaian </u><b> : 
					<?php if($record->kesesuaian!=""){
							echo $record->kesesuaian=="1" ? "<span class='label label-success'>Sesuai</span>":"<span class='label label-warning'>Tidak</span>" ;
						}
					?>
					</td>
					<td valign="top">
						<b><u>Bidang </u></b> :
						<?php e($record->bidang) ?>
					<br>
					<b><u>Tanggal </u></b> :
						<?php e($record->tanggal) ?><br>
					
					<b><u>Auditor </u></b> :
						<?php e($record->user_pembuat) ?>
					
							
					</td>
                    
                    </tr>
				<?php
					$no++;
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