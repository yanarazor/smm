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

$num_columns	= 19;
$can_delete	= $this->auth->has_permission('Daftar_ptpp.Ptpp.Delete');
$can_edit		= $this->auth->has_permission('Daftar_ptpp.Ptpp.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
		<center><b>Daftar PKTP</b></center>
		<table border="1" width="100%">
			<thead>
				<tr>
					 
					
					<th>Ditujukan Kepada</th>
					<th>Bidang</th>
					<th width="120px">#</th>
					<!--
					<th>Diajukan Oleh</th>
					<th>No PTPP</th>
					 
					<th>Referensi</th>
					
					<th>Kategori</th>
					-->
					<th width="30%">Deskripsi Ketidaksesuaian / Hasil Investigasi</th>
				 
					<th width="30%">Koreksi / Tindakan Perbaikan</th>
					<th>Status Verifikasi</th>
					<th>Status</th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						 
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
					 
				<?php if ($can_edit) : ?>
					<td valign="top"><?php echo anchor(SITE_AREA . '/ptpp/daftar_ptpp/'.$action."/" .$record->id, '<span class="icon-pencil"></span>' .  $record->user_tujuan); ?></td>
				<?php else : ?>
					<td valign="top"><?php e($record->user_tujuan); ?></td>
				<?php endif; ?>
					<td valign="top"><?php e($record->bidang) ?></td>
					<!--
					<td><?php e($record->user_pembuat) ?></td>
					<td><?php e($record->no_ptpp) ?></td>
					 
					<td><?php e($record->referensi) ?></td>
					
					<td><?php e($record->kat) ?></td>
					-->
					<td valign="top">
						No : <?php e($record->no_ptpp) ?> <br>
						Tanggal : <?php e($record->tanggal_pengusulan) ?> <br>
						Pembuat : <?php e($record->user_pembuat) ?> 
						<br>
						<?php e($record->kat) ?>
						</td>
					<td valign="top">
					<b><u>Deskripsi Ketidaksesuaian </u> : </b><?php echo strip_tags($record->deskripsi_ketidaksesuaian); ?>
					<br>
					<b><u>Hasil Investigasi </u>: </b> <?php echo strip_tags($record->hasil_investigasi); ?></td>
					 
					<td valign="top">
					<b><u>Koreksi </u> : </b> <?php echo strip_tags($record->tindakan_koreksi); ?>
					<br>
					
					<b><u>Tindakan Perbaikan </u> : </b><?php echo strip_tags($record->tindakan_korektif); ?></td>
					<td>
					<?php if($record->status_persetujuan!=""){
								echo $record->status_persetujuan=="1" ? "<span class='label label-success'>Setuju</span>":"<span class='label label-warning'>Tidak Setuju</span>" ;
							}
					?>
					</td>
					<td><?php e($record->status_ptpp) ?></td>
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
</div>