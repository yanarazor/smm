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
			<select id='mark_<?=$index?>' class="validate[required]" name="mark[]" style="width:80px">
				  <option value="">Pilih</option>
				  <?php if (isset($recordtmak) && is_array($recordtmak) && count($recordtmak)):?>
				  <?php foreach($recordtmak as $record):?>
					   <option value="<?php echo $record->kdmak;?>" <?php if(isset($recorddetil->mark))  echo  ($record->kdmak == $recorddetil->mark) ? "selected" : ""; ?>><?php echo $record->nmmak; ?></option>
				   <?php endforeach;?>
				  <?php endif;?>
			  </select>
		</td>
		<td height="40px" style="padding-right:20px;">
			<textarea id='nama_barang_<?=$index?>' class="validate[required]"  type='text' name='nama_barang[]' rows="2" style="width:200px"><?php echo $recorddetil->nama_barang; ?></textarea> 
		</td>
		<td width="200px" height="40px">
			<textarea id='spek_<?=$index?>' type='text' class="validate[required]"  name='spek[]' rows="2" style="width:200px"><?php echo $recorddetil->spek_barang; ?></textarea> 
		  </td>
		  <td width="200px">
			 <input id='jumlah_<?=$index?>' type='text' name='jumlah[]' maxlength="10" width="20px" class="span10" value="<?php echo $recorddetil->jumlah_barang; ?>"/>
		  </td>
		  <td width="200px">
		  	<select id='satuan_<?=$index?>' class="validate[required]" name="satuan[]" style="width:80px">
				  <option value="">Pilih</option>
				  <option value="Buah" <?php echo $recorddetil->satuan == "Buah" ? "selected" : ""; ?>>Buah</option>
				  <option value="Rim" <?php echo $recorddetil->satuan == "Rim" ? "selected" : ""; ?>>Rim</option>
				  <option value="Pak" <?php echo $recorddetil->satuan == "Pak" ? "selected" : ""; ?>>Pak</option>
				  <option value="Dus" <?php echo $recorddetil->satuan == "Dus" ? "selected" : ""; ?>>Dus</option>
				  <option value="Lembar" <?php echo $recorddetil->satuan == "Lembar" ? "selected" : ""; ?>>Lembar</option>
				  <option value="Liter" <?php echo $recorddetil->satuan == "Liter" ? "selected" : ""; ?>>Liter</option>
				  <option value="Paket" <?php echo $recorddetil->satuan == "Paket" ? "selected" : ""; ?>>Paket</option>
				  <option value="Unit" <?php echo $recorddetil->satuan == "Unit" ? "selected" : ""; ?>>Unit</option>
				  <option value="Box" <?php echo $recorddetil->satuan == "Box" ? "selected" : ""; ?>>Box</option>
			  </select>
			 <!--<input id='satuan_<?=$index?>' type='text' name='satuan[]' maxlength="100"  style="width:70px"value="<?php echo $recorddetil->satuan; ?>"/>-->
		  </td>
		  <td width="200px">
			 <input id='harga_<?=$index?>' type='text' name='harga[]' onchange="hitungjumlah('<?=$index?>')"  maxlength="10" style="width:100px" value="<?php echo $recorddetil->harga_barang; ?>"/>
		  </td>
		  <td width="200px">
			 <input id='jumlah_all_<?=$index?>' type='text' name='jumlah_all[]' maxlength="10" width="20px"  style="width:100px" value="<?php echo $recorddetil->jumlah_all; ?>"/>
		  </td>
		  <td valign="middle"> 
		   
			  <a href="<?php echo base_url();?>assets/uploaded/<?=$recorddetil->file_name ?>" target="blank">
			  <?php
				  echo $recorddetil->file_name !="" ? "<span class='label label-warning'>Lihat</span>":"" ; 
			  ?> 
			  </a>
			  
			  	<input type="file" name="file_upload_<?=$index?>" title=" sd"/>
			  
		  </td>
		  <td> 
			 <?php
			 	echo "<span class='label label-warning'>".$recorddetil->statusbarang."</span>";
			 ?> 
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
		 
		<td height="40px" style="padding-right:20px;">
			 <textarea id='nama_barang_<?=$index?>' class="validate[required]"  type='text' name='nama_barang[]' rows="2" style="width:400px"></textarea> 
		</td>
		
		<td width="250px">
			<input id='target_<?=$index?>' onchange="hitungjumlah('<?=$index?>')" type='text' name='target[]' maxlength="100"/>
		  </td>
		  <td width="20px">
			 <input id='jumlah_<?=$index?>' onchange="hitungjumlah('<?=$index?>')" type='text' name='jumlah[]' maxlength="50"/>
		  </td>
		  <td width="100px">
			 <input id='harga_<?=$index?>'  class="auto"  onchange="hitungjumlah('<?=$index?>')" type='text' name='harga[]' style="width:50px" maxlength="10"/>
		  </td>
		  <td width="200px">
			 <input id='jumlah_all_<?=$index?>'  class="auto"  type='text' name='jumlah_all[]' maxlength="10" style="width:100px"/>
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
 