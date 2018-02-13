 
	<tr id="divbarang_<?=$index?>"> 
		<td width="30px">
			<?php echo $index+1; ?>.
		</td>
		<td width="30px" height="40px">
			<select id='mark_<?=$index?>' class="validate[required]" name="mark[]" style="width:80px">
				  <option value="">Pilih</option>
				  <?php if (isset($recordtmak) && is_array($recordtmak) && count($recordtmak)):?>
				  <?php foreach($recordtmak as $record):?>
					   <option value="<?php echo $record->kdmak;?>" <?php if(isset($recorddetil->mark))  echo  ($rec->kdmak == $recorddetil->mark) ? "selected" : ""; ?>><?php echo $record->nmmak; ?></option>
				   <?php endforeach;?>
				  <?php endif;?>
			  </select>
		</td>
		<td width="400px" height="40px" style="padding-right:20px;">
			 <textarea id='nama_barang_<?=$index?>' class="validate[required]" type='text' name='nama_barang[]' rows="2" style="width:200px"></textarea> 
		</td>
		 
		<td width="200px">
				<textarea id='spek_<?=$index?>' class="validate[required]" type='text' name='spek[]' rows="5" style="width:200px"></textarea> 
		  </td>
		  <td width="200px">
			 <input id='jumlah_<?=$index?>'  onchange="hitungjumlah('<?=$index?>')" type='text' name='jumlah[]' maxlength="10" width="20px" class="span10"/>
		  </td>
		  <td width="200px">
		  	<select id='satuan_<?=$index?>' class="validate[required]" name="satuan[]" style="width:80px">
				  <option value="">Pilih</option>
				  <option value="Buah">Buah</option>
				  <option value="Rim">Rim</option>
				  <option value="Pak">Pak</option>
				  <option value="Dus">Dus</option>
				  <option value="Lembar">Lembar</option>
				  <option value="Liter">Liter</option>
				  <option value="Paket">Paket</option>
				  <option value="Unit">Unit</option>
				  <option value="Box">Box</option>
			  </select>
		  </td>
		  <td width="200px">
			 <input id='harga_<?=$index?>'  onchange="hitungjumlah('<?=$index?>')" type='text' name='harga[]' maxlength="10" class="span13"/>
		  </td>
		  <td width="200px">
			 <input id='jumlah_all_<?=$index?>' type='text' name='jumlah_all[]' maxlength="10" width="20px" class="span13"/>
		  </td>
		  <td width="200px"> 
			 <input type="file" name="file_upload_<?=$index?>"/>
		  </td>
		  <td valign="middle"> 
			<a href="#"  class="btn-small btn-danger pull-left delete" >
				<i class="icon-min">Del</i>
			</a>
		  </td>
	</tr>
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

</script>
 