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

if (isset($daftar_periksa_audit))
{
	$daftar_periksa_audit = (array) $daftar_periksa_audit;
}
$id = isset($daftar_periksa_audit['id']) ? $daftar_periksa_audit['id'] : '';

?>
<div class="admin-box">
	<h3>Daftar Periksa Audit</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('daftar_periksa_audit_id_jadwal_audit') ? 'error' : ''; ?>">
				<?php echo form_label('Audit Internal', 'daftar_periksa_audit_id_jadwal_audit', array('class' => 'control-label') ); ?>
				<div class='controls'>
                	<select name="daftar_periksa_audit_id_jadwal_audit" id="daftar_periksa_audit_id_jadwal_audit" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($audit_internals) && is_array($audit_internals) && count($audit_internals)):?>
						<?php foreach($audit_internals as $audit_internal):?>
							<option value="<?php echo $audit_internal->id?>" <?php if(isset($daftar_periksa_audit['id_jadwal_audit']))  echo  ($audit_internal->id==$daftar_periksa_audit['id_jadwal_audit']) ? "selected" : ""; ?>> <?php e(ucfirst($audit_internal->judul)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
                    <span class='help-inline'><?php echo form_error('daftar_periksa_audit_id_jadwal_audit'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('id_bidang') ? 'error' : ''; ?>">
				<?php echo form_label('Bidang', 'daftar_periksa_audit_id_bidang', array('class' => 'control-label') ); ?>
				<div class='controls'>
                	<select name="daftar_periksa_audit_id_bidang" id="daftar_periksa_audit_id_bidang" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($bidangs) && is_array($bidangs) && count($bidangs)):?>
						<?php foreach($bidangs as $bidang):?>
							<option value="<?php echo $bidang->id?>" <?php if(isset($daftar_periksa_audit['id_bidang']))  echo  ($bidang->id==$daftar_periksa_audit['id_bidang']) ? "selected" : ""; ?>> <?php e(ucfirst($bidang->bidang)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('id_bidang'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('deskripsi') ? 'error' : ''; ?>">
				<?php echo form_label('Deskripsi', 'daftar_periksa_audit_deskripsi', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'daftar_periksa_audit_deskripsi', 'id' => 'daftar_periksa_audit_deskripsi','style'=>'width:600px', 'rows' => '5', 'cols' => '80', 'value' => set_value('daftar_periksa_audit_deskripsi', isset($daftar_periksa_audit['deskripsi']) ? $daftar_periksa_audit['deskripsi'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('deskripsi'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('klausul_iso') ? 'error' : ''; ?>">
				<?php echo form_label('Klausul Iso', 'daftar_periksa_audit_klausul_iso', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'daftar_periksa_audit_klausul_iso', 'id' => 'daftar_periksa_audit_klausul_iso','style'=>'width:600px', 'rows' => '5', 'cols' => '80', 'value' => set_value('daftar_periksa_audit_klausul_iso', isset($daftar_periksa_audit['klausul_iso']) ? $daftar_periksa_audit['klausul_iso'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('klausul_iso'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('bukti_obyektif') ? 'error' : ''; ?>">
				<?php echo form_label('Bukti Obyektif', 'daftar_periksa_audit_bukti_obyektif', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'daftar_periksa_audit_bukti_obyektif', 'id' => 'daftar_periksa_audit_bukti_obyektif','style'=>'width:600px', 'rows' => '5', 'cols' => '80', 'value' => set_value('daftar_periksa_audit_bukti_obyektif', isset($daftar_periksa_audit['bukti_obyektif']) ? $daftar_periksa_audit['bukti_obyektif'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('bukti_obyektif'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('kesesuaian') ? 'error' : ''; ?>">
				<?php echo form_label('Kesesuaian', '', array('class' => 'control-label', 'id' => 'daftar_periksa_audit_kesesuaian_label') ); ?>
				<div class='controls' aria-labelled-by='daftar_periksa_audit_kesesuaian_label'>
					 
						<input id='daftar_periksa_audit_kesesuaian_option1' name='daftar_periksa_audit_kesesuaian' type='radio' class='' value='1' <?php echo set_radio('daftar_periksa_audit_kesesuaian', '1'); ?> />
						Sesuai
				 
                    <br />
					 
						<input id='daftar_periksa_audit_kesesuaian_option2' name='daftar_periksa_audit_kesesuaian' type='radio' class='' value='0' <?php echo set_radio('daftar_periksa_audit_kesesuaian', '0'); ?> />
						Tidak
					 
					<span class='help-inline'><?php echo form_error('kesesuaian'); ?></span>
				</div>
			</div>  
			  
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('daftar_periksa_audit_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/audit/daftar_periksa_audit', lang('daftar_periksa_audit_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript">	  

$(document).ready(function() {	  
	 $('#daftar_periksa_audit_deskripsi').wysiwyg();
	 $('#daftar_periksa_audit_klausul_iso').wysiwyg();
	 $('#daftar_periksa_audit_bukti_obyektif').wysiwyg();
});
	
	 
</script>