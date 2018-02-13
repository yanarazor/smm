<?php if (isset($data_detil) && is_array($data_detil) && count($data_detil)) : 
$index = 0;
foreach ($data_detil as $recorddetil) :
//print_r($recorddetil);
//echo $recorddetil->nip;
?> 
 
	<tr> 
		<td>
			<?php echo $index+1; ?>.
		</td>
		<td width="30px" height="40px">
			<?php echo $recorddetil->mark; ?>
		</td>
		<td width="200px" style="padding-right:20px;">
			 <input id='kode_<?=$index?>' type='hidden' name='kode[]' maxlength="250" style="width:300px" value="<?php echo $recorddetil->id; ?>"/>
			 <input id='nama_barang' type='hidden' name='nama_barang[]' value="<?php echo $recorddetil->nama_barang; ?>" maxlength="100" />
			 <?php echo $recorddetil->nama_barang; ?>
		</td>
		<td width="300px">
			<input id='spek_<?=$index?>' type='hidden' name='spek[]' maxlength="250" style="width:300px" value="<?php echo $recorddetil->spek_barang; ?>"/>
			<?php echo $recorddetil->spek_barang; ?>
		  </td>
		  <td width="100px">
			 <input id='jumlah_awal_<?=$index?>' type='text' name='jumlah[]' readonly maxlength="10" width="20px" class="span5" value="<?php echo $recorddetil->jumlah_barang; ?>"/>
		  </td>
		  <td width="100px">
			 <input id='jumlah_<?=$index?>' type='text' name='jumlahada[]' onchange="hitungjumlah('<?=$index?>')"  maxlength="10" width="20px" class="span5" value="<?php echo $recorddetil->jumlah_barang_ada; ?>"/>
		  </td>
		  <td width="200px">
			 <input id='satuan_<?=$index?>' type='text' name='satuan[]' readonly maxlength="100" class="span10" value="<?php echo $recorddetil->satuan; ?>"/>
		  </td>
		  <td width="200px">
			 <input id='harga_<?=$index?>' type='text' name='harga[]' onchange="hitungjumlah('<?=$index?>')" maxlength="10" class="span13" value="<?php echo $recorddetil->harga_barang; ?>"/>
		  </td>
		  <td width="200px">
			 <input id='jumlah_all_<?=$index?>' type='text' name='jumlah_all[]' readonly maxlength="10" width="20px" class="span13" value="<?php echo $recorddetil->jumlah_all; ?>"/>
		  </td>
		   <td valign="middle"> 
			  <a href="<?php echo base_url();?>assets/uploaded/<?=$recorddetil->file_name ?>" target="blank">
			  <?php
				  echo $recorddetil->file_name !="" ? "<span class='label label-warning'>Lihat</span>":"" ; 
			  ?> 
			  </a>
		  </td>
		  <td>
		  	<input id='status_barang_<?php echo $recorddetil->id; ?>' type='hidden' name='status_barang[]' maxlength="10" width="20px" class="span13" value="<?php echo $recorddetil->status_barang; ?>"/>
				<div class="dropdown pull-right">
					<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"> <span id="span_<?php echo $recorddetil->id; ?>"><?php echo $recorddetil->statusbarang; ?></span> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="#" onclick="changestatus('<?php echo $recorddetil->id; ?>','1')" kode="">Barang ada</a></li>  
						<li><a href="#" onclick="changestatus('<?php echo $recorddetil->id; ?>','2')" kode="">Ada sebagian</a></li>  
						<li><a href="#" onclick="changestatus('<?php echo $recorddetil->id; ?>','3')" kode="">Kirim ke Pengadaan</a></li>  
						<li><a href="#" onclick="changestatus('<?php echo $recorddetil->id; ?>','5')" kode="">Batal</a></li>  
					</ul>
				</div>
				<?php
							echo $recorddetil->status_pengadaan =="1" ? "<span class='label label-warning'></span>":"" ; 
							echo $recorddetil->status_pengadaan =="2" ? "<span class='label label-warning'>Proses Pembelian</span>":"" ; 
							echo $recorddetil->status_pengadaan =="3" ? "<span class='label label-warning'>Sudah dibeli</span>":"" ;
							echo $recorddetil->status_pengadaan =="4" ? "<span class='label label-warning'>Barang tidak ada</span>":"" ;
							echo $recorddetil->status_pengadaan =="5" ? "<span class='label label-warning'>Menunggu Uang Muka</span>":"" ;
						?> 
		  </td>
	</tr>
 
<?php
$index++;
endforeach;
else:
?>
    
	<tr id="divbarang_<?=$index?>"> 
		<td colspan="7">
			Tidak ada barang yang diminta
		</td>
		 
	</tr>
 
			
<?php
endif;
?>			
<script type="text/javascript"> 
function changestatus(kode,stat){
	var statusbarang = "";
	if(stat == "1")
		statusbarang = "Ada";
	if(stat == "2")
		statusbarang = "Ada Sebagian";
	if(stat == "3")
		statusbarang = "Pengadaan";
	if(stat == "5")
		statusbarang = "Batal";
	
	
	if(stat != "1"){ 
			$.fancybox({
					'width'			: 720,
					'height'		: 400,
					 
					'autoSize'		: true,
					'type'			: 'iframe',
					'titlePosition'	: 'inside', 
					'overlayShow'	: true,
					'overlayColor'	: '#000000',
					'overlayOpacity': '0.85',
					'href'			: '<?php echo base_url();?>admin/permintaanbarang/permintaan_barang/createpengadaan/'+kode+'/'+stat+'/<?php echo $id;?>'
					});
	}
		
	$("#span_"+kode).html(statusbarang); 
	$("#status_barang_"+kode).val(stat); 
	
	return false;
}
 
function hitungjumlah(kode){
	var jumlahsatuan = $("#jumlah_"+kode).val(); 
	var hargasatuan = $("#harga_"+kode).val(); 
	if(jumlahsatuan != "" && hargasatuan != "")
	{
		var jumlahharga = jumlahsatuan * hargasatuan;
		$("#jumlah_all_"+kode).val(jumlahharga)
	}
	//var json_url = "<?php echo base_url() ?>index.php/admin/pengujian/master_pengujian/getdataharga/?id_pengujian="+data_pengujian_id_pengujian;
	 
}
</script>
 
<script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
</script>