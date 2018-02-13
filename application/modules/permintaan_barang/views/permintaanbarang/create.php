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
			<!--
			<div class="control-group <?php echo form_error('user_request') ? 'error' : ''; ?>">
				<?php echo form_label('Pengusul', 'permintaan_barang_user_request', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="permintaan_barang_user_request" id="permintaan_barang_user_request" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($users) && is_array($users) && count($users)):?>
						<?php foreach($users as $rec):?>
							<option value="<?php echo $rec->id?>" <?php if(isset($permintaan_barang['user_request']))  echo  ($rec->id==$permintaan_barang['user_request']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->display_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('user_request'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('permintaan_barang_anggaran') ? 'error' : ''; ?>">
				<?php echo form_label('Penandatangan', 'permintaan_barang_anggaran', array('class' => 'control-label') ); ?>
				<div class='controls' aria-labelled-by='surat_izin_status_atasan_label'>
					<label class='radio' for='tanda_tangan'>
						<input id='tanda_tangan_option1' class="validate[required]" name='tanda_tangan' type='radio' class='' value='1' <?php if(isset($permintaan_barang['anggaran']) and $permintaan_barang['anggaran']=="Tematik") echo "checked"; ?> />
						Atasan Langsung
					</label>
					<br>
					<label class='radio' for='tanda_tangan_option2'>
						<input class="validate[required] text-input" id='tanda_tangan_option2' name='tanda_tangan' type='radio' class='' value='2' <?php if(isset($permintaan_barang['anggaran']) and $permintaan_barang['anggaran']=="PNBP") echo "checked"; ?> />
						PJ Kegiatan
					</label>
					 
					<span class='help-inline'><?php echo form_error('permintaan_barang_anggaran'); ?></span>
				</div>
			</div>
			-->
			<!--
			<div class="control-group <?php echo form_error('tanggal_permintaan') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Permintaan', 'permintaan_barang_tanggal_permintaan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='permintaan_barang_tanggal_permintaan' class="datepicker" type='text' name='permintaan_barang_tanggal_permintaan'  value="<?php echo set_value('permintaan_barang_tanggal_permintaan', isset($permintaan_barang['tanggal_permintaan']) ? $permintaan_barang['tanggal_permintaan'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal_permintaan'); ?></span>
				</div>
			</div>
			-->
			<div class="control-group <?php echo form_error('permintaan_barang_anggaran') ? 'error' : ''; ?>">
				<?php echo form_label('Anggaran', 'permintaan_barang_anggaran', array('class' => 'control-label') ); ?>
				<div class='controls' aria-labelled-by='surat_izin_status_atasan_label'>
					<select class="validate[required] text-input" name="permintaan_barang_anggaran" id="permintaan_barang_anggaran" class="chosen-select-deselect"  onchange="changeanggaran(this);">
						<option value="">-- Pilih  --</option>
						<option value="Tematik">Tematik</option>
						<option value="PNBP">PNBP</option>
						<option value="Rutin">Rutin</option>
					</select>
					 
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
				<?php echo form_label('Tanggal Persetujuan PPK', 'permintaan_barang_tanggal_selesai', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='permintaan_barang_tanggal_selesai'   class="datepicker validate[required][custom[date],future[NOW]] text-input" type='text' name='permintaan_barang_tanggal_selesai'  value="<?php echo set_value('permintaan_barang_tanggal_selesai', isset($permintaan_barang['tanggal_selesai']) ? $permintaan_barang['tanggal_selesai'] : ''); ?>" />

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
					  echo $this->load->view('permintaanbarang/dinamicedit',array("index"=>'0'));
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
			var json_url = "<?php echo base_url() ?>admin/permintaanbarang/permintaan_barang/getbarang/";
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
$("#permintaan_barang_kegiatan").live('change', function(event) {
	
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