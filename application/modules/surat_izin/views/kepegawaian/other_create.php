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

if (isset($surat_izin))
{
	$surat_izin = (array) $surat_izin;
}
$id = isset($surat_izin['id']) ? $surat_izin['id'] : '';

?>
<div class="admin-box">
	 
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>
			<div class="control-group <?php echo form_error('sppd_jabodetabek_pegawai') ? 'error' : ''; ?>">
				<?php echo form_label('Pegawai'. lang('bf_form_label_required'), 'sppd_jabodetabek_pegawai', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="sppd_jabodetabek_pegawai" id="sppd_jabodetabek_pegawai" class="chosen-select-deselect" onchange="getinfo(this.value)">
						<option value="">-- Pilih  --</option>
						<?php if (isset($users) && is_array($users) && count($users)):?>
						<?php foreach($users as $rec):?>
							<option value="<?php echo $rec->id?>" <?php if(isset($sppd_jabodetabek['pegawai']))  echo  ($rec->id==$sppd_jabodetabek['pegawai']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->display_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('sppd_jabodetabek_pegawai'); ?></span>
				</div>
			</div>
			<div id="infopangkat">
				
			</div>
  			<div class="control-group <?php echo form_error('izin') ? 'error' : ''; ?>">
				<?php echo form_label('Izin'. lang('bf_form_label_required'), 'sppd_jabodetabek_pejabat', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="surat_izin_izin" id="surat_izin_izin" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($master_izins) && is_array($master_izins) && count($master_izins)):?>
						<?php foreach($master_izins as $rec):?>
							<option value="<?php echo $rec->id?>" <?php if(isset($surat_izin['izin']))  echo  ($rec->id==$surat_izin['izin']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->nama_izin)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('sppd_jabodetabek_pejabat'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('surat_izin_lama') ? 'error' : ''; ?>">
				<?php echo form_label('Selama'. lang('bf_form_label_required'), 'surat_izin_lama', array('class' => 'control-label') ); ?>
				<div class="input-prepend input-append">
					<input id='surat_izin_lama' type='text' name='surat_izin_lama' maxlength="20" value="<?php echo set_value('surat_izin_lama', isset($surat_izin['lama']) ? $surat_izin['lama'] : ''); ?>" />
					 <span class="add-on">Hari</span>
					<span class='help-inline'><?php echo form_error('surat_izin_lama'); ?></span>
				</div>
			</div>
 
			<div class="control-group <?php echo form_error('surat_izin_tanggal') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Mulai'. lang('bf_form_label_required'), 'surat_izin_tanggal', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='surat_izin_tanggal' type='text'  class='datepicker' name='surat_izin_tanggal'  value="<?php echo set_value('surat_izin_tanggal', isset($surat_izin['tanggal']) ? $surat_izin['tanggal'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('surat_izin_tanggal'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('surat_izin_tanggal_selesai') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Selesai'. lang('bf_form_label_required'), 'surat_izin_tanggal_selesai', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='surat_izin_tanggal_selesai' class='datepicker'  type='text' name='surat_izin_tanggal_selesai'  value="<?php echo set_value('surat_izin_tanggal_selesai', isset($surat_izin['tanggal_selesai']) ? $surat_izin['tanggal_selesai'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('surat_izin_tanggal_selesai'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('surat_izin_alasan') ? 'error' : ''; ?>">
				<?php echo form_label('Alasan'. lang('bf_form_label_required'), 'surat_izin_alasan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'surat_izin_alasan', 'id' => 'surat_izin_alasan', 'rows' => '5', 'cols' => '80', 'value' => set_value('surat_izin_alasan', isset($surat_izin['alasan']) ? $surat_izin['alasan'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('surat_izin_alasan'); ?></span>
				</div>
			</div>
			</fieldset>
			<?php if(isset($surat_izin['status_atasan'])): ?>
				<fieldset>
				<legend>Persetujuan</legend>
				<div class="control-group <?php echo form_error('status_atasan') ? 'error' : ''; ?>">
					<?php echo form_label('Status Atasan', '', array('class' => 'control-label', 'id' => 'surat_izin_status_atasan_label') ); ?>
					<div class='controls' aria-labelled-by='surat_izin_status_atasan_label'>
						<label class='radio' for='surat_izin_status_atasan_option1'>
							<input id='surat_izin_status_atasan_option1' name='surat_izin_status_atasan' type='radio' class='' value='1' <?php echo set_radio('surat_izin_status_atasan', '1', TRUE); ?> />
							Setuju
						</label>
						<br>
						<label class='radio' for='surat_izin_status_atasan_option2'>
							<input id='surat_izin_status_atasan_option2' name='surat_izin_status_atasan' type='radio' class='' value='2' <?php echo set_radio('surat_izin_status_atasan', '2'); ?> />
							Tidak Setuju
						</label>
						<span class='help-inline'><?php echo form_error('status_atasan'); ?></span>
					</div>
				</div>
			<!--
				<div class="control-group <?php echo form_error('tanggal_dibuat') ? 'error' : ''; ?>">
					<?php echo form_label('Tanggal Dibuat', 'surat_izin_tanggal_dibuat', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<input id='surat_izin_tanggal_dibuat' type='text' name='surat_izin_tanggal_dibuat'  value="<?php echo set_value('surat_izin_tanggal_dibuat', isset($surat_izin['tanggal_dibuat']) ? $surat_izin['tanggal_dibuat'] : ''); ?>" />
						<span class='help-inline'><?php echo form_error('tanggal_dibuat'); ?></span>
					</div>
				</div>
			-->
			<?php endif; ?>
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('surat_izin_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<input type="reset" name="reset" class="btn btn-warning" value="Cancel"  />
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>
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
<script type="text/javascript">	  
	$(document).ready(function() {	  
		 
		  
	});
	function getinfo(kode){
		var id_pegawai = kode; 
		var json_url = "<?php echo base_url() ?>index.php/admin/settings/users/getinfouser/?id_pegawai="+id_pegawai;
		var post_data = "id_pegawai="+id_pegawai;
		$.ajax({
			url: json_url,
			type:"get",
			data: post_data,
			dataType: "html",
			timeout:180000,
			success: function (result) {
				$('#infopangkat').html(result);
		},
		error : function(error) {
			alert(error);
		} 
	});        
	} 
	
</script>