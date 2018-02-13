
<?php

$validation_errors = validation_errors();

if ($validation_errors) :
?>
<div class="alert alert-block alert-error fade in">
	<a class="close" data-dismiss="alert">&times;</a>
	<h4 class="alert-heading">Please fix the following errors:</h4>
	<?php echo $validation_errors; ?>
</div>
<?php
endif;

if (isset($permintaan_barang_detil))
{
	$permintaan_barang_detil = (array) $permintaan_barang_detil;
}
$id = isset($permintaan_barang_detil['id']) ? $permintaan_barang_detil['id'] : '';

?>
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
	<fieldset>
		<legend> Mohon Dapat dibelikan barang sebagai berikut </legend> 
			<div class="control-group <?php echo form_error('nama_barang') ? 'error' : ''; ?>">
				<?php echo form_label('Nama Barang'. lang('bf_form_label_required'), 'permintaan_barang_detil_nama_barang', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='nama_barang' type='text' name='nama_barang' maxlength="10" class="span10" value="<?php echo set_value('permintaan_barang_detil_nama_barang', isset($permintaan_barang_detil['nama_barang']) ? $permintaan_barang_detil['nama_barang'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nama_barang'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('spek_barang') ? 'error' : ''; ?>">
				<?php echo form_label('Spek'. lang('bf_form_label_required'), 'permintaan_barang_detil_spek_barang', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='spek_barang' type='text' name='spek_barang' maxlength="10" class="span10" value="<?php echo set_value('permintaan_barang_detil_spek_barang', isset($permintaan_barang_detil['spek_barang']) ? $permintaan_barang_detil['spek_barang'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('spek_barang'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('jumlah') ? 'error' : ''; ?>">
				<?php echo form_label('Jumlah'. lang('bf_form_label_required'), 'permintaan_barang_detil_spek_barang', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='jumlah' type='text' name='jumlah' maxlength="10" value="<?php echo set_value('permintaan_barang_detil_spek_barang', isset($permintaan_barang_detil['jml_barang_pengadaan']) ? $permintaan_barang_detil['jml_barang_pengadaan'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('jumlah'); ?></span>
				</div>
			</div>
		   	
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="Kirim Permintaan"  />
				 
			 
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>
<script>  	
	var index = <?php echo $jumlahdetil; ?>;
	$(document).ready(function() {	   
	   $( "#btnaddbarang" ).click(function() {
	   		
	   		
			var nilai = index;
			var json_url = "<?php echo base_url() ?>admin/permintaanbarang/permintaan_barang_detil/getbarang/";
			$.ajax({    type: "POST",
			   url: json_url,
			   data: "index="+nilai,
			   success: function(data){ 
				   $('.divbarang').append(data);
			   }});
			index = index + 1;
			return false; 
			   
	   });
	 
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
  