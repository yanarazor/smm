<?php
$this->load->library('convert');
	$convert = new convert();
?>
<?php if (isset($data_detil) && is_array($data_detil) && count($data_detil)) : 
$index = 0;
foreach ($data_detil as $recorddetil) :
//print_r($recorddetil);
//echo $recorddetil->nip;
?> 
 
	<tr> 
		<td>
			<input type="checkbox" name="checked[]" value="<?php echo $recorddetil->id; ?>" />
		</td>
		<td width="30px" height="40px">
			<?php echo $recorddetil->mark; ?>
			  
		</td>
		<td height="20p%" style="padding-right:20px;">
			 <?php echo $recorddetil->nama_barang; ?>
		</td>
		<td width="40%">
			<?php echo $recorddetil->spek_barang; ?>
		  </td>
		  <td width="5%">
			 <?php echo $recorddetil->jumlah_barang; ?>
		  </td>
		  <td width="5%">
			 <?php echo $recorddetil->satuan; ?>
		  </td>
		  <td width="10%">
			 <?php 
			 	echo $convert->toRpnosimbol($recorddetil->harga_barang);
			 ?>
		  </td>
		  <td width="10%">
		  	<?php 
			 	echo $convert->toRpnosimbol($recorddetil->jml_barang_pengadaan);
			?>
		  </td>
		  <td valign="middle"> 
			  <a href="<?php echo base_url();?>assets/uploaded/<?=$recorddetil->file_name ?>" target="blank">
			  <?php
				  echo $recorddetil->file_name !="" ? "<span class='label label-warning'>Lihat</span>":"" ; 
			  ?> 
			  </a>
		  </td>
		  <td>
		  	<textarea id='spek_<?=$index?>' type='text' class=""  name='catatan_ppk_<?php echo $recorddetil->id; ?>' rows="2" style="width:100px"><?php echo $recorddetil->catatan_ppk; ?></textarea> 
		  </td>
	</tr>
 
<?php
$index++;
endforeach;
else:
?>
    
	<tr id="divbarang_<?=$index?>"> 
		<td width="30px">
			<?php echo $index+1; ?>.
		</td>
		<td width="30px" height="40px">
			 <select id='mark_<?=$index?>' name="mark[]" style="width:80px">
			 	<option value="">Pilih</option>
			 	<option value="521211">521211 - Bahan</option>
			 	<option value="521811">521811 - Barang untuk persediaan barang konsumsi</option>
			 	<option value="523112">523112 - Barang persediaan pemeliharaan</option>
			 </select>
		</td>
		<td height="40px" style="padding-right:20px;">
			 <input id='nama_barang_<?=$index?>' type='text' name='nama_barang[]' maxlength="100" />
		</td>
		
		<td width="200px">
			<input id='spek_<?=$index?>' type='text' name='spek[]' maxlength="250" style="width:300px"/>
		  </td>
		  <td width="200px">
			 <input id='jumlah_<?=$index?>'  onchange="hitungjumlah('<?=$index?>')" type='text' name='jumlah[]' maxlength="10" width="20px" class="span10"/>
		  </td>
		  <td width="300px">
			 <input id='satuan_<?=$index?>' type='text' name='satuan[]' maxlength="100" class="span14" style="width:80px"/>
		  </td>
		  <td width="200px">
			 <input id='harga_<?=$index?>' onchange="hitungjumlah('<?=$index?>')" type='text' name='harga[]' maxlength="10" class="span13"/>
		  </td>
		  <td width="200px">
			 <input id='jumlah_all_<?=$index?>' type='text' name='jumlah_all[]' maxlength="10" width="20px" class="span13"/>
		  </td>
		  <td width="200px"> 
			 <input type="file" name="file_upload_<?=$index?>"/>
		  </td>
	</tr>
 
			
<?php
endif;
?>			
<script type="text/javascript"> 
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
function deletediv(kode){ 
	$("#divbarang_"+kode).remove();
	 
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