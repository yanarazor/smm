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

if (isset($master_izin))
{
	$master_izin = (array) $master_izin;
}
$id = isset($master_izin['id']) ? $master_izin['id'] : '';

?>
<div class="admin-box">
	<h3>Master Izin</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('nama_izin') ? 'error' : ''; ?>">
				<?php echo form_label('Izin'. lang('bf_form_label_required'), 'master_izin_nama_izin', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='master_izin_nama_izin' type='text' name='master_izin_nama_izin' maxlength="100" value="<?php echo set_value('master_izin_nama_izin', isset($master_izin['nama_izin']) ? $master_izin['nama_izin'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nama_izin'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('master_izin_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/masters/master_izin', lang('master_izin_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Master_Izin.Masters.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('master_izin_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('master_izin_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>