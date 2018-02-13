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

if (isset($jabatan))
{
	$jabatan = (array) $jabatan;
}
$id = isset($jabatan['id']) ? $jabatan['id'] : '';

?>
<div class="admin-box">
	<h3>Jabatan</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('nama_jabatan') ? 'error' : ''; ?>">
				<?php echo form_label('Nama Jabatan'. lang('bf_form_label_required'), 'jabatan_nama_jabatan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='jabatan_nama_jabatan' type='text' name='jabatan_nama_jabatan' maxlength="50" value="<?php echo set_value('jabatan_nama_jabatan', isset($jabatan['nama_jabatan']) ? $jabatan['nama_jabatan'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nama_jabatan'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('kelas_jabatan') ? 'error' : ''; ?>">
				<?php echo form_label('Kelas Jabatan', 'jabatan_kelas_jabatan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='jabatan_kelas_jabatan' type='text' name='jabatan_kelas_jabatan' maxlength="2" value="<?php echo set_value('jabatan_kelas_jabatan', isset($jabatan['kelas_jabatan']) ? $jabatan['kelas_jabatan'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('kelas_jabatan'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('tukin') ? 'error' : ''; ?>">
				<?php echo form_label('Tunjangan Kinerja'. lang('bf_form_label_required'), 'jabatan_tukin', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='jabatan_tukin' type='text' name='jabatan_tukin' maxlength="10" value="<?php echo set_value('jabatan_tukin', isset($jabatan['tukin']) ? $jabatan['tukin'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tukin'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('jabatan_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/settings/jabatan', lang('jabatan_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>