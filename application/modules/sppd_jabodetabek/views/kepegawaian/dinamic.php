 
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
				<i class="icon-minus"></i> Delete
			</a>
			<span class='help-inline'><?php echo form_error('data_pengujian_id_pengujian'); ?></span>
		</div>
	</div>
	 
 
<script type="text/javascript"> 
    
function deletediv(kode){ 
	$("#divpengujian_"+kode).remove();
	$("#divquantity_"+kode).remove();
	$("#divjmlharga_"+kode).remove();
	hitungTotall();
}

$(document).ready(function() {	  
	 
	   
	});
</script>
 <link href="<?php echo base_url(); ?>assets/css/chosen/chosen.css" rel="stylesheet" type="text/css" />
<script language='JavaScript' type='text/javascript' src='<?php echo base_url(); ?>assets/js/chosen/chosen.jquery.js'></script>
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