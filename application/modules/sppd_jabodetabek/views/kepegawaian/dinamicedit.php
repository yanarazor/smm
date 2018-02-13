<?php if (isset($data_pengikut) && is_array($data_pengikut) && count($data_pengikut)) : 
$no = 1;
foreach ($data_pengikut as $recorddetil) :

?> 
	<div class="control-group <?php echo form_error('data_pengujian_id_pengujian') ? 'error' : ''; ?>" id="divpengikut_<?php echo $recorddetil->id; ?>">
		<?php echo form_label('Pengikut '.$no, 'data_pengujian_id_pengujian', array('class' => 'control-label') ); ?>
		<div class='controls'>
			<select name="pengikut[]" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($users) && is_array($users) && count($users)):?>
						<?php foreach($users as $rec):?>
							<option value="<?php echo $rec->id?>" <?php if(isset($recorddetil->id_user))  echo  ($rec->id==$recorddetil->id_user) ? "selected" : ""; ?>> <?php e(ucfirst($rec->display_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
			
			 <?php if($no=="1"): ?>
           <a href="#"  class="btn btn-small btnaddpengikut">
               <i class="icon-plus"></i> Tambah
            </a>
            <?php endif; ?>
            <?php if($no!="1"): ?>
                <a href="#" onclick="deletediv('<?php echo $no; ?>')" class="btn btn-small btndel">
                    <i class="icon-minus"></i> Delete
                </a>
             <?php endif; ?>
			<span class='help-inline'><?php echo form_error('data_pengujian_id_pengujian'); ?></span>
		</div>
	</div>
<?php
$no++;
endforeach;
else:
?>
    <div class="control-group <?php echo form_error('data_pengujian_id_pengujian') ? 'error' : ''; ?>">
		<?php echo form_label('Pengikut'. lang('bf_form_label_required'), 'data_pengujian_id_pengujian', array('class' => 'control-label') ); ?>
		<div class='controls'>
			<select name="pengikut[]" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($users) && is_array($users) && count($users)):?>
						<?php foreach($users as $rec):?>
							<option value="<?php echo $rec->id?>" <?php if(isset($sppd_jabodetabek['pegawai']))  echo  ($rec->id==$sppd_jabodetabek['pegawai']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->display_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
			
			<a href="#" onclick="deletediv('')" class="btn btn-small btndel">
				<i class="icon-plus"<i class="icon-minus"></i> Delete
			</a>
			<span class='help-inline'><?php echo form_error('data_pengujian_id_pengujian'); ?></span>
		</div>
	</div>
			
<?php
endif;
?>			
<script type="text/javascript"> 
function getharga(kode){
	
	var data_pengujian_id_pengujian = $("#id_pengujian_"+kode).val(); 
	var json_url = "<?php echo base_url() ?>index.php/admin/pengujian/master_pengujian/getdataharga/?id_pengujian="+data_pengujian_id_pengujian;
	$.getJSON(json_url,function(data){
		$("#hargasatuan_"+kode).val(data.harga);
		$("#quantity_"+kode).val('1');
		$("#jmlharga_"+kode).val(data.harga);
		 
		hitungTotall();
	});
}
function deletediv(kode){ 
	$("#divpengikut_"+kode).remove();
	 
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