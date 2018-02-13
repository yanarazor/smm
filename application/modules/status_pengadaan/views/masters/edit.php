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

if (isset($status_pengadaan))
{
	$status_pengadaan = (array) $status_pengadaan;
}
$id = isset($status_pengadaan['id']) ? $status_pengadaan['id'] : '';

?>
<div class="admin-box">
	<h3>Status Pengadaan</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('status_pengadaan') ? 'error' : ''; ?>">
				<?php echo form_label('Status'. lang('bf_form_label_required'), 'status_pengadaan_status_pengadaan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='status_pengadaan_status_pengadaan' type='text' name='status_pengadaan_status_pengadaan' maxlength="20" value="<?php echo set_value('status_pengadaan_status_pengadaan', isset($status_pengadaan['status_pengadaan']) ? $status_pengadaan['status_pengadaan'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('status_pengadaan'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('status_pengadaan_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/masters/status_pengadaan', lang('status_pengadaan_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Status_Pengadaan.Masters.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('status_pengadaan_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('status_pengadaan_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>