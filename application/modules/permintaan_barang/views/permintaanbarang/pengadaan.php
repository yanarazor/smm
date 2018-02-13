<?php
$this->load->library('convert');
$convert = new convert();
$num_columns	= 12;
$can_delete	= $this->auth->has_permission('Permintaan_Barang.Permintaanbarang.Delete');
$can_edit		= $this->auth->has_permission('Permintaan_Barang.Permintaanbarang.atasan');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box" style="min-height:400px">
	<form action="<?php $this->uri->uri_string() ?>" method="get" accept-charset="utf-8">
	 <table>
        	<tr> 
            	<td>
                	<b>Nomor</b>
                </td> 
                <td>
                	<b>User</b>
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
					<th>Tanggal Permintaan/ <br>Dikirim Pengadaan</th>
					<th>MAK</th>
					<th>Kegiatan</th>
					<th>Nama Barang</th>
					<th>Spek</th>
					<th>Jumlah</th>
					<th>Harga Barang</th>
					<th>Catatan</th>
					<th>Status Pembelian</th>
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
				<tr <?php if($record->stat_baca == "" or $record->stat_baca == "0") { ?> class="rowred" <?php } ?>>
					<?php if ($can_delete) : ?>
					<td class="column-check"><input type="checkbox" name="checked[]" value="<?php echo $record->id; ?>" <?php if($record->stat_baca == "" or $record->stat_baca == "0") { ?> style="background-color: red;" <?php } ?> /></td>
					<?php endif;?>
					<td><?php e($record->nomor); ?>-<?php e($record->nomor_detil); ?></td>
					<td><?php e($record->display_name) ?></td>
					<td><?php e($record->tanggal_permintaan) ?>/<?php e($record->tgl_kirim_pengadaan) ?></td>
					<td><?php e($record->mark) ?></td>
					<td><?php e($record->kegiatan) ?></td>
					<td><?php e($record->nama_barang) ?></td>
					<td><?php e($record->spek_barang) ?>
					
					 <a href="<?php echo base_url();?>assets/uploaded/<?=$record->file_name ?>" target="blank">
					   <?php
						   echo $record->file_name !="" ? "<br><span class='label label-warning'>Lihat</span>":"" ; 
					   ?> 
					   </a>
			  		</td>
					<td>
						<?php e($record->jml_barang_pengadaan) ?>
						<?php e($record->satuan) ?>
					</td>
					<td>
						<?php
							echo $convert->toRpnosimbol($record->harga_barang);
						?>
					</td>
					<td><?php e($record->catatan_ppk) ?>
					<td>
						<span id="span_<?php echo $record->id; ?>"></span>
						 
						<div class="dropdown pull-right">
							<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $record->nama_status_pengadaan; ?> <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="#" onclick="changestatus('<?php echo $record->id; ?>','1','<?php echo $record->idpermintaan; ?>')" kode="">Pengadaan</a></li>  
								<li><a href="#" onclick="changestatus('<?php echo $record->id; ?>','2','<?php echo $record->idpermintaan; ?>')" kode="">Proses Pembelian</a></li>  
								<li><a href="#" onclick="changestatus('<?php echo $record->id; ?>','3','<?php echo $record->idpermintaan; ?>')" kode="">Sudah Dibeli</a></li>  
								<li><a href="#" onclick="changestatus('<?php echo $record->id; ?>','4','<?php echo $record->idpermintaan; ?>')" kode="">Barang Tidak ada</a></li>  
								<li><a href="#" onclick="changestatus('<?php echo $record->id; ?>','5','<?php echo $record->idpermintaan; ?>')" kode="">Menunggu Uang Muka</a></li>  
								<li><a href="#" onclick="changestatus('<?php echo $record->id; ?>','6','<?php echo $record->idpermintaan; ?>')" kode="">Tidak ada di POK</a></li>  
								<li><a href="#" onclick="changestatus('<?php echo $record->id; ?>','','<?php echo $record->idpermintaan; ?>')" kode="">Batal (kirim Ke persediaan)</a></li>  
							</ul>
						</div>
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
<script type="text/javascript"> 
function changestatus(kode,stat,idpermintaan){
	var statusbarang = "";
	//alert(idpermintaan);
	var json_url = "<?php echo base_url() ?>admin/permintaanbarang/permintaan_barang/savestatpengadaan";
	var post_data = "kode="+kode+"&stat="+stat+"&id="+idpermintaan;
	//alert(json_url+"?"+post_data);
		$.ajax({
			url: json_url,
			type:"post",
			data: post_data,
			dataType: "html",
			timeout:180000,
			success: function (result) {
				alert(result);
				$('#span_'+kode).html(result);
		},
		error : function(error) {
			alert(error);
		} 
	});   
	return false;
}
</script>