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

if (isset($status_permintaan))
{
	$status_permintaan = (array) $status_permintaan;
}
$id = isset($status_permintaan['id']) ? $status_permintaan['id'] : '';

?>
<div class="admin-box">
	<h3>Status Permintaan</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('nama_status') ? 'error' : ''; ?>">
				<?php echo form_label('Status'. lang('bf_form_label_required'), 'status_permintaan_nama_status', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='status_permintaan_nama_status' type='text' name='status_permintaan_nama_status' maxlength="50" value="<?php echo set_value('status_permintaan_nama_status', isset($status_permintaan['nama_status']) ? $status_permintaan['nama_status'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nama_status'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('status_permintaan_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/masters/status_permintaan', lang('status_permintaan_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Status_Permintaan.Masters.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('status_permintaan_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('status_permintaan_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>