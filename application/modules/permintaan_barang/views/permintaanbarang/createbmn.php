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

if (isset($permintaan_barang))
{
	$permintaan_barang = (array) $permintaan_barang;
}
$id = isset($permintaan_barang['id']) ? $permintaan_barang['id'] : '';

?>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/validation/validationEngine.jquery.css" type="text/css"/>
	
	<script src="<?php echo base_url(); ?>assets/js/validation/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8">
	</script>
	<script src="<?php echo base_url(); ?>assets/js/validation/jquery.validationEngine.js" type="text/javascript" charset="utf-8">
	</script>
 
<div class="admin-box">
	<?php echo form_open_multipart($this->uri->uri_string(), 'class="form-horizontal" id="frmpermintaan"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('permintaan_barang_nomor') ? 'error' : ''; ?>">
				<?php echo form_label('Nomor'. lang('bf_form_label_required'), 'permintaan_barang_nomor', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='permintaan_barang_nomor' type='text' name='permintaan_barang_nomor' maxlength="10" value="<?php echo $noauto; ?>" readonly/>
					<span class='help-inline'><?php echo form_error('permintaan_barang_nomor'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('permintaan_barang_anggaran') ? 'error' : ''; ?>">
				<?php echo form_label('Anggaran', 'permintaan_barang_anggaran', array('class' => 'control-label') ); ?>
				<div class='controls' aria-labelled-by='surat_izin_status_atasan_label'>
					<label class='radio' for='permintaan_barang_anggaran_option1'>
						<input id='permintaan_barang_anggaran_option1' onclick="changeanggaran(this);" class="validate[required]" name='permintaan_barang_anggaran' type='radio' class='' value='Tematik' <?php if(isset($permintaan_barang['anggaran']) and $permintaan_barang['anggaran']=="Tematik") echo "checked"; ?> />
						Tematik
					</label>
					<br>
					<label class='radio' for='permintaan_barang_anggaran_option2'>
						<input id='permintaan_barang_anggaran_option2' onclick="changeanggaran(this);" name='permintaan_barang_anggaran' type='radio' class='' value='PNBP' <?php if(isset($permintaan_barang['anggaran']) and $permintaan_barang['anggaran']=="PNBP") echo "checked"; ?> />
						PNBP
					</label>
					<br>
					<label class='radio' for='permintaan_barang_anggaran_option3'>
						<input id='permintaan_barang_anggaran_option3' onclick="changeanggaran(this);" name='permintaan_barang_anggaran' type='radio' class='' value='Rutin' <?php if(isset($permintaan_barang['anggaran']) and $permintaan_barang['anggaran']=="Rutin") echo "checked"; ?> />
						Rutin
					</label>
					<br>
					 
					<span class='help-inline'><?php echo form_error('permintaan_barang_anggaran'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('permintaan_barang_kegiatan') ? 'error' : ''; ?>">
				<?php echo form_label('Kegiatan', 'permintaan_barang_kegiatan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select class="validate[required] text-input" name="permintaan_barang_kegiatan" id="permintaan_barang_kegiatan" class="chosen-select-deselect" style="width:700px">
						<option value="">-- Pilih  --</option>
						<?php if (isset($kegiatans) && is_array($kegiatans) && count($kegiatans)):?>
						<?php foreach($kegiatans as $rec):?>
							<option value="<?php echo $rec->kode?>" <?php if(isset($permintaan_barang['kegiatan']))  echo  ($rec->kode==$permintaan_barang['kegiatan']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->judul)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('permintaan_barang_kegiatan'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('permintaan_barang_tanggal_selesai') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Permintaan Selesai', 'permintaan_barang_tanggal_selesai', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='permintaan_barang_tanggal_selesai'   class="datepicker validate[required][custom[date],future[NOW]] text-input" type='text' name='permintaan_barang_tanggal_selesai'  value="<?php echo set_value('permintaan_barang_tanggal_selesai', isset($permintaan_barang['tanggal_selesai']) ? $permintaan_barang['tanggal_selesai'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('permintaan_barang_tanggal_selesai'); ?></span>
				</div>
			</div>
			<!--
			<div class="control-group <?php echo form_error('status_atasan') ? 'error' : ''; ?>">
				<?php echo form_label('Status Atasan', '', array('class' => 'control-label', 'id' => 'permintaan_barang_status_atasan_label') ); ?>
				<div class='controls' aria-labelled-by='permintaan_barang_status_atasan_label'>
					<label class='radio' for='permintaan_barang_status_atasan_option1'>
						<input id='permintaan_barang_status_atasan_option1' name='permintaan_barang_status_atasan' type='radio' class='' value='option1' <?php echo set_radio('permintaan_barang_status_atasan', 'option1', TRUE); ?> />
						Radio option 1
					</label>
					<label class='radio' for='permintaan_barang_status_atasan_option2'>
						<input id='permintaan_barang_status_atasan_option2' name='permintaan_barang_status_atasan' type='radio' class='' value='option2' <?php echo set_radio('permintaan_barang_status_atasan', 'option2'); ?> />
						Radio option 2
					</label>
					<span class='help-inline'><?php echo form_error('status_atasan'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('status_kabag') ? 'error' : ''; ?>">
				<?php echo form_label('Status Kabag', '', array('class' => 'control-label', 'id' => 'permintaan_barang_status_kabag_label') ); ?>
				<div class='controls' aria-labelled-by='permintaan_barang_status_kabag_label'>
					<label class='radio' for='permintaan_barang_status_kabag_option1'>
						<input id='permintaan_barang_status_kabag_option1' name='permintaan_barang_status_kabag' type='radio' class='' value='option1' <?php echo set_radio('permintaan_barang_status_kabag', 'option1', TRUE); ?> />
						Radio option 1
					</label>
					<label class='radio' for='permintaan_barang_status_kabag_option2'>
						<input id='permintaan_barang_status_kabag_option2' name='permintaan_barang_status_kabag' type='radio' class='' value='option2' <?php echo set_radio('permintaan_barang_status_kabag', 'option2'); ?> />
						Radio option 2
					</label>
					<span class='help-inline'><?php echo form_error('status_kabag'); ?></span>
				</div>
			</div>

			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
					2 => 2,
				);

				echo form_dropdown('permintaan_barang_status_permintaan', $options, set_value('permintaan_barang_status_permintaan', isset($permintaan_barang['status_permintaan']) ? $permintaan_barang['status_permintaan'] : ''), 'Status Permintaan');
			?>
			-->
			<fieldset>
		   	<legend> Mohon Dapat disediakan barang-barang sebagai berikut </legend>
			   <input id="txtarry" name="txtarry" type="hidden" value="0"/>
				   <a href="#"  class="btn btn-small btn-primary pull-left" id="btnaddbarang">
					   <i class="icon-plus"></i> Tambah
				   </a>
			   <table class="divbarang table table-striped" border="1">
			   		<tr>
			   			<th> No </th>
			   			<th> Mak </th>
			   			<th> Nama Barang </th>
			   			<th> Spek </th>
			   			<th> Jumlah </th>
			   			<th> Satuan </th>
			   			<th> Perkiraan Harga </th>
			   			<th> Jumlah </th>
			   			<th> File </th>
			   			<th> # </th>
			   		</tr>
				   <?php
					  echo $this->load->view('permintaanbarang/dinamicbmn',array("index"=>'0'));
				   ?>
			   </table>
			
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="Kirim Permintaan"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/permintaanbarang/permintaan_barang', lang('permintaan_barang_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>

<script>  	

	var index = 0;
	$(document).ready(function() {	
		   
	$("#frmpermintaan").validationEngine();
	   $( "#btnaddbarang" ).click(function() {
	   		index = index + 1;
			var nilai = index;
			var json_url = "<?php echo base_url() ?>admin/permintaanbarang/permintaan_barang/getbarangbmn/";
			$.ajax({    type: "POST",
			   url: json_url,
			   data: "index="+nilai,
			   success: function(data){ 
				   $('.divbarang').append(data);
			   }});
			return false; 
			   
	   });
	 
	});	
	 
$(".delete").live('click', function(event) {
	if (confirm("Hapus baris ini?")) {
       $(this).parent().parent().remove();
       return false;
    }
	return false;
});
 function changeanggaran(anggaran) {
    currentValue = anggaran.value;
    $("#permintaan_barang_kegiatan").empty().append("<option>loading...</option>");
	 var json_url = "<?php echo base_url(); ?>admin/masters/kegiatan/getkegiatan?kegiatan=" + encodeURIComponent(currentValue);
	 //alert(json_url);
	 $.getJSON(json_url,function(data){
		 $("#permintaan_barang_kegiatan").empty(); 
		 if(data==""){
			 $("#permintaan_barang_kegiatan").append("<option value=\"\">-- Pilih --</option>");
		 }
		 else{
			 $("#permintaan_barang_kegiatan").append("<option value=\"\">-- Pilih --</option>");
			 for(i=0; i<data.id.length; i++){
				 $("#permintaan_barang_kegiatan").append("<option value=\"" + data.id[i]  + "\">" + data.judul[i] +"</option>");
			 }
		 }
		 
	 });
	 return false;
}
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