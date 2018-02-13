
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
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
	<fieldset>

			<div class="control-group <?php echo form_error('nomor') ? 'error' : ''; ?>">
				<?php echo form_label('Nomor'. lang('bf_form_label_required'), 'permintaan_barang_nomor', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='permintaan_barang_nomor' readonly type='text' name='permintaan_barang_nomor' maxlength="10" value="<?php echo set_value('permintaan_barang_nomor', isset($permintaan_barang['nomor']) ? $permintaan_barang['nomor'] : ''); ?>" />
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
					<?php echo isset($permintaan_barang['tanggal_permintaan']) ? $permintaan_barang['tanggal_permintaan'] : ''; ?>	
					<span class='help-inline'><?php echo form_error('tanggal_permintaan'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('anggaran') ? 'error' : ''; ?>">
				<?php echo form_label('Anggaran', 'permintaan_barang_anggaran', array('class' => 'control-label') ); ?>
				<div class='controls' aria-labelled-by='status_atasan_label'>
					<label class='radio' for='permintaan_barang_anggaran_option1'>
						<input id='permintaan_barang_anggaran_option1' name='permintaan_barang_anggaran' type='radio' class='' value='Tematik' <?php if(isset($permintaan_barang['anggaran']) and $permintaan_barang['anggaran']=="Tematik") echo "checked"; ?> />
						Tematik
					</label>
					<br>
					<label class='radio' for='permintaan_barang_anggaran_option2'>
						<input id='permintaan_barang_anggaran_option2' name='permintaan_barang_anggaran' type='radio' class='' value='PNBP' <?php if(isset($permintaan_barang['anggaran']) and $permintaan_barang['anggaran']=="PNBP") echo "checked"; ?> />
						PNBP
					</label>
					<br>
					<label class='radio' for='permintaan_barang_anggaran_option3'>
						<input id='permintaan_barang_anggaran_option3' name='permintaan_barang_anggaran' type='radio' class='' value='Rutin' <?php if(isset($permintaan_barang['anggaran']) and $permintaan_barang['anggaran']=="Rutin") echo "checked"; ?> />
						Rutin
					</label>
					<br>
					<label class='radio' for='permintaan_barang_anggaran_option4'>
						<input id='permintaan_barang_anggaran_option4' name='permintaan_barang_anggaran' type='radio' class='' value='Instansi Lain' <?php if(isset($permintaan_barang['anggaran']) and $permintaan_barang['anggaran']=="Instansi Lain") echo "checked"; ?> />
						Instansi Lain
					</label>
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
					<?php echo isset($permintaan_barang['tanggal_selesai']) ? $permintaan_barang['tanggal_selesai'] : ''; ?>	
				</div>
			</div>
			 
			</fieldset>
			<fieldset>
				<legend>Status Permintaan</legend>
				<div class="control-group <?php echo form_error('status_permintaan') ? 'error' : ''; ?>">
				<?php echo form_label('Status', 'permintaan_barang_kegiatan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="status_permintaan" id="status_permintaan" class="chosen-select-deselect" style="width:700px">
						<option value="">-- Pilih  --</option>
						<?php if (isset($status_permintaans) && is_array($status_permintaans) && count($status_permintaans)):?>
						<?php foreach($status_permintaans as $rec):?>
							<option value="<?php echo $rec->id?>" <?php if(isset($permintaan_barang['status_permintaan']))  echo  ($rec->id==$permintaan_barang['status_permintaan']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->nama_status)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('status_permintaan'); ?></span>
				</div>
			</div>
			<fieldset>
				 
			<fieldset>
		   	<legend> Mohon Dapat disediakan barang-barang sebagai berikut </legend>
			    
			   <table class="divbarang table table-striped" border="1">
			   		<tr>
			   			<th> No </th>
			   			<th> Mak </th>
			   			<th> Nama Barang </th>
			   			<th> Spek </th>
			   			<th> Brg diminta </th>
			   			<th> Brg Ada </th>
			   			<th> Satuan </th>
			   			<th> Perkiraan Harga </th>
			   			<th> Jumlah </th>
			   			<th> File </th>
			   			<th> # </th>
			   		</tr>
				   <?php
					  echo $this->load->view('permintaanbarang/barangdetil',array("data_detil"=>$data_detil,"id"=>$id,"index"=>'0'));
				   ?>
			   </table>
			   catatan Atasan : <?php echo isset($permintaan_barang['catatan_atasan']) ? $permintaan_barang['catatan_atasan'] : ''; ?>
			   <br>
			   catatan KPU : <?php echo isset($permintaan_barang['catatan_kpu']) ? $permintaan_barang['catatan_kpu'] : ''; ?>
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('permintaan_barang_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/permintaanbarang/permintaan_barang/persediaan', lang('permintaan_barang_cancel'), 'class="btn btn-warning"'); ?>
				<?php echo lang('bf_or'); ?>
			 <input type="submit" name="sendmail" class="btn btn-danger" value="Save dan Kirim Email"  />
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>
<script>  	
	var index = <?php echo $jumlahdetil; ?>;
	$(document).ready(function() {	   
	   $( "#btnaddbarang" ).click(function() {
	   		
	   		
			var nilai = index;
			var json_url = "<?php echo base_url() ?>admin/permintaanbarang/permintaan_barang/getbarang/";
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
  