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

if (isset($absen))
{
	$absen = (array) $absen;
}
$id = isset($absen['id']) ? $absen['id'] : '';

?>
<div class="admin-box">
	<h3>Absen</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('nik') ? 'error' : ''; ?>">
				<?php echo form_label('Nik'. lang('bf_form_label_required'), 'absen_nik', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='absen_nik' type='text' name='absen_nik' maxlength="30" value="<?php echo set_value('absen_nik', isset($absen['nik']) ? $absen['nik'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nik'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('nama') ? 'error' : ''; ?>">
				<?php echo form_label('Nama'. lang('bf_form_label_required'), 'absen_nama', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='absen_nama' type='text' name='absen_nama' maxlength="100" value="<?php echo set_value('absen_nama', isset($absen['nama']) ? $absen['nama'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nama'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('tanggal') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal'. lang('bf_form_label_required'), 'absen_tanggal', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='absen_tanggal' type='text' name='absen_tanggal'  value="<?php echo set_value('absen_tanggal', isset($absen['tanggal']) ? $absen['tanggal'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('jam') ? 'error' : ''; ?>">
				<?php echo form_label('Jam', 'absen_jam', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='absen_jam' type='text' name='absen_jam'  value="<?php echo set_value('absen_jam', isset($absen['jam']) ? $absen['jam'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('jam'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('sn_mesin') ? 'error' : ''; ?>">
				<?php echo form_label('SN mesin', 'absen_sn_mesin', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='absen_sn_mesin' type='text' name='absen_sn_mesin' maxlength="30" value="<?php echo set_value('absen_sn_mesin', isset($absen['sn_mesin']) ? $absen['sn_mesin'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('sn_mesin'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('verifikasi') ? 'error' : ''; ?>">
				<?php echo form_label('Verifikasi', 'absen_verifikasi', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='absen_verifikasi' type='text' name='absen_verifikasi' maxlength="20" value="<?php echo set_value('absen_verifikasi', isset($absen['verifikasi']) ? $absen['verifikasi'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('verifikasi'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('model') ? 'error' : ''; ?>">
				<?php echo form_label('Model', 'absen_model', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='absen_model' type='text' name='absen_model' maxlength="20" value="<?php echo set_value('absen_model', isset($absen['model']) ? $absen['model'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('model'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('absen_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/kepegawaian/absen', lang('absen_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>