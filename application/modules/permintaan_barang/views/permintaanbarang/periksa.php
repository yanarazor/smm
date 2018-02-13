<?php

$num_columns	= 10;
$can_delete	= $this->auth->has_permission('Permintaan_Barang.Permintaanbarang.Delete');
$can_edit		= $this->auth->has_permission('Permintaan_Barang.Permintaanbarang.atasan');
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
                	<b>Bulan</b>
                </td>  
                <td>
                	<b>Tahun</b>
                </td>  
                <td>
                	<b>Kegiatan</b>
                </td>  
                 <td>
                	<b>Status</b>
                </td> 
            </tr> 
            <tr>
            	<td>
                	<input id='keyword' type='text' name='keyword' width="50px" maxlength="20" value="<?php echo set_value('keyword', isset($keyword) ? $keyword : ''); ?>" />
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
                <td>
					<select name="kg" id="kg" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($kegiatans) && is_array($kegiatans) && count($kegiatans)):?>
						<?php foreach($kegiatans as $rec):?>
							<option value="<?php echo $rec->kode?>" <?php if(isset($permintaan_barang['kegiatan']))  echo  ($rec->kode==$permintaan_barang['kegiatan']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->judul)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
                </td>
                <td>
                	<select name="status" id="status" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($status_permintaans) && is_array($status_permintaans) && count($status_permintaans)):?>
						<?php foreach($status_permintaans as $rec):?>
							<option value="<?php echo $rec->id?>" <?php if(isset($status))  echo  ($rec->id==$status) ? "selected" : ""; ?>> <?php e(ucfirst($rec->nama_status)); ?></option>
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
					<th>User</th>
					<th>Tanggal Permintaan</th>
					<th>Anggaran</th>
					<th>Kegiatan</th>
					<th>Tanggal Permintaan Selesai</th>
					<!--
					<th>Status PPK/PJ Kegiatan</th>
					<th>Status Kasubag KPU</th>
					-->
					<th>Status Permintaan</th>
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
				<tr <?php if($record->status_permintaan == "1") { ?> class="rowred" <?php } ?>>
					<?php if ($can_delete) : ?>
					<td class="column-check"><input type="checkbox" name="checked[]" value="<?php echo $record->id; ?>" /></td>
					<?php endif;?>
					
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/permintaanbarang/permintaan_barang/verpj/' . $record->id, '<span class="icon-pencil"></span>' .  $record->nomor); ?></td>
				<?php else : ?>
					<td><?php e($record->nomor); ?></td>
				<?php endif; ?>
					<td><?php e($record->display_name) ?></td>
					<td><?php e($record->tanggal_permintaan) ?></td>
					<td><?php e($record->anggaran) ?></td>
					<td><?php e($record->kegiatan) ?></td>
					<td><?php e($record->tanggal_selesai) ?></td>
					<!--
					<td>
						<?php
							echo $record->status_atasan =="" ? "<span class='label label-warning'>Menunggu Persetujuan</span>":"" ; 
							echo $record->status_atasan =="1" ? "<span class='label label-success'>Ya</span>":"" ;
							echo $record->status_atasan =="2" ? "<span class='label label-warning'>Tidak</span>":"" ;
						?> 
					</td>
					<td>
						<?php
							echo $record->status_kabag=="" ? "<span class='label label-warning'>Menunggu Persetujuan</span>":"" ; 
							 echo $record->status_kabag=="1" ? "<span class='label label-success'>Ya</span>":"" ;
							 echo $record->status_kabag=="2" ? "<span class='label label-warning'>Tidak</span>":"" ;
						?> 
					</td>
					-->
					<td>
						<?php 
						if($record->nama_status == "Pengadaan")
							echo $record->nama_status == "Pengadaan" ? "<span class='label label-info'>Pengadaan</span>":"" ; 
						else if($record->nama_status == "Selesai")
							echo $record->nama_status == "Selesai" ? "<span class='label label-success'>Selesai</span>":"" ; 
						else if($record->nama_status == "Persediaan")
							echo $record->nama_status == "Persediaan" ? "<span class='label label-danger'>Persediaan</span>":"" ; 
						else
							echo "<span class='label label-warning'>".$record->nama_status."</span>"; 
						?>
						<?php
							echo isset($record->catatan_atasan) ? "<br>".$record->catatan_atasan : ""; 
							echo isset($record->catatan_kpu) ? "<br>".$record->catatan_kpu : ""; 
						?> 
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
	 <?php echo $this->pagination->create_links(); ?>
</div>