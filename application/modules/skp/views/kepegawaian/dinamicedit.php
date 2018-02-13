<?php if (isset($records) && is_array($records) && count($records)) : 
$index = 0;
foreach ($records as $recorddetil) :
//print_r($recorddetil);
//echo $recorddetil->nip;
?> 
 
	<tr> 
		<td>
			<?php echo $index+1; ?>.
		</td>
		<td height="40px" style="padding-right:20px;">
			<input id='id_<?=$index?>' type='hidden' name='id[]' value="<?php echo $recorddetil->id; ?>" maxlength="100"/>
			<textarea id='kegiatan_<?=$index?>' class="validate[required]"  type='text' name='kegiatan[]' rows="2" style="width:100%"><?php echo $recorddetil->kegiatan; ?></textarea> 
		</td>
		<td width="50px">
			<input id='ak_<?=$index?>' type='text' name='ak[]' style="width:20px" value="<?php echo $recorddetil->ak; ?>" maxlength="10" readonly class="full-left" />
		</td>
		<td width="150px">
			<input id='target_<?=$index?>' type='text' name='target[]' style="width:50px" value="<?php echo $recorddetil->target; ?>" maxlength="10" class="full-left" />
		</td>
		<td width="20px">
			<input id='satuan_<?=$index?>' type='text' name='satuan[]' style="width:100px" value="<?php echo $recorddetil->satuan; ?>" maxlength="100" class="full-left"/>
		</td>
		<td width="20px">
			<input id='kual_<?=$index?>' type='text' name='kual[]' style="width:40px" value="<?php echo $recorddetil->kual; ?>" maxlength="100" class="full-left"/>
		</td>
		<td width="250px">
			<input id='waktu_<?=$index?>' type='text' name='waktu[]' style="width:40px" value="<?php echo $recorddetil->waktu; ?>" maxlength="50"/> Hari
		</td>
		<td width="200px">
			<input id='biaya_<?=$index?>'  class="auto"  type='text' name='biaya[]' value="<?php echo $recorddetil->biaya; ?>" maxlength="100" style="width:100px"/>
		</td>
		  <td>
					  
			  <a href="#" class='delete' kode="<?php e($recorddetil->id); ?>">
			  <span class="fa-stack">
			   <i class="fa fa-square fa-stack-2x"></i>
			   <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
			  </span>
			  </a>
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
			 <textarea id='kegiatan_<?=$index?>' class="validate[required]"  type='text' name='kegiatan[]' rows="2" style="width:100%"></textarea> 
		</td>
		<td width="50px">
			<input id='ak_<?=$index?>' type='text' name='ak[]' style="width:20px" maxlength="10" readonly class="full-left" />
		</td>
		<td width="150px">
			<input id='target_<?=$index?>' type='text' name='target[]' style="width:50px" maxlength="10" class="full-left" />
		</td>
		<td width="20px">
			<input id='satuan_<?=$index?>' type='text' name='satuan[]' style="width:100px" maxlength="100" class="full-left"/>
		</td>
		<td width="20px">
			<input id='kual_<?=$index?>' type='text' name='kual[]' style="width:40px" maxlength="100" class="full-left"/>
		</td>
		<td width="250px">
			<input id='waktu_<?=$index?>' type='text' name='waktu[]' style="width:40px" maxlength="50"/> Hari
		</td>
		<td width="200px">
			<input id='biaya_<?=$index?>'  class="auto"  type='text' name='biaya[]' maxlength="100" style="width:100px"/>
		</td>
	</tr>
 
			
<?php
endif;
?>			
<script type="text/javascript"> 
 
function deletediv(kode){ 
	$("#divbarang_"+kode).remove();
	 
}

</script>
 