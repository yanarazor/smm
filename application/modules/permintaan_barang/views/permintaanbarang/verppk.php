
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
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal" id="frmpermintaan"'); ?>
	<fieldset>

			<div class="control-group <?php echo form_error('nomor') ? 'error' : ''; ?>">
				<?php echo form_label('Nomor'. lang('bf_form_label_required'), 'permintaan_barang_nomor', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='permintaan_barang_nomor'  readonly type='text' name='permintaan_barang_nomor' maxlength="10" value="<?php echo set_value('permintaan_barang_nomor', isset($permintaan_barang['nomor']) ? $permintaan_barang['nomor'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nomor'); ?></span>
				</div>
			</div>

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

			<div class="control-group <?php echo form_error('tanggal_permintaan') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Permintaan', 'permintaan_barang_tanggal_permintaan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo set_value('permintaan_barang_tanggal_permintaan', isset($permintaan_barang['tanggal_permintaan']) ? $permintaan_barang['tanggal_permintaan'] : ''); ?>
					<span class='help-inline'><?php echo form_error('tanggal_permintaan'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('anggaran') ? 'error' : ''; ?>">
				<?php echo form_label('Anggaran', 'permintaan_barang_anggaran', array('class' => 'control-label') ); ?>
				<div class='controls' aria-labelled-by='status_kabag_label'>
					<?php echo isset($permintaan_barang['anggaran']) ? $permintaan_barang['anggaran'] : "";  ?> 
					<span class='help-inline'><?php echo form_error('permintaan_barang_anggaran'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('kegiatan') ? 'error' : ''; ?>">
				<?php echo form_label('Kegiatan', 'permintaan_barang_kegiatan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="permintaan_barang_kegiatan" id="permintaan_barang_kegiatan" class="chosen-select-deselect" style="width:700px">
						<option value="">-- Pilih  --</option>
						<?php if (isset($kegiatans) && is_array($kegiatans) && count($kegiatans)):?>
						<?php foreach($kegiatans as $rec):?>
							<option value="<?php echo $rec->kode?>" <?php if(isset($permintaan_barang['kegiatan']))  echo  ($rec->kode==$permintaan_barang['kegiatan']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->judul)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('kegiatan'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('tanggal_selesai') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Permintaan Selesai', 'permintaan_barang_tanggal_selesai', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo set_value('permintaan_barang_tanggal_selesai', isset($permintaan_barang['tanggal_selesai']) ? $permintaan_barang['tanggal_selesai'] : ''); ?>
					<span class='help-inline'><?php echo form_error('tanggal_selesai'); ?></span>
				</div>
			</div>
			 
			</fieldset>
			 
			 
			<fieldset>
		   	<legend> Mohon Dapat disediakan barang-barang sebagai berikut </legend>
			    
			   <table class="divbarang table table-striped" border="1">
			   		<tr>
			   			<th class="column-check"><input class="check-all" type="checkbox" /></th> 
			   			<th> Mak </th>
			   			<th> Nama Barang </th>
			   			<th> Spek </th>
			   			<th> Jumlah (user) </th>
			   			<th> Satuan </th>
			   			<th> Perkiraan Harga </th>
			   			<th> Jumlah (Pengadaan) </th>
			   			<th> File </th>
			   			<th> Catatan </th>
			   		</tr>
				   <?php
					  echo $this->load->view('permintaanbarang/detilpermintaanppk',array("data_detil"=>$data_detil,"index"=>'0'));
				   ?>
			   </table>
			 catatan Atasan : <?php echo isset($permintaan_barang['catatan_atasan']) ? $permintaan_barang['catatan_atasan'] : ''; ?>
			   <br>
			   catatan KPU : <?php echo isset($permintaan_barang['catatan_kpu']) ? $permintaan_barang['catatan_kpu'] : ''; ?>
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="Setuju"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/permintaanbarang/permintaan_barang/ppk', lang('permintaan_barang_cancel'), 'class="btn btn-warning"'); ?>
				
			 
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>
<script>  	
	
	$(document).ready(function() {	  
		$("#frmpermintaan").validationEngine(); 
	 
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
  