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

if (isset($status_ptpp))
{
	$status_ptpp = (array) $status_ptpp;
}
$id = isset($status_ptpp['id']) ? $status_ptpp['id'] : '';

?>
<div class="admin-box">
	<h3>Status Ptpp</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('status') ? 'error' : ''; ?>">
				<?php echo form_label('Status'. lang('bf_form_label_required'), 'status_ptpp_status', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='status_ptpp_status' type='text' name='status_ptpp_status' maxlength="200" value="<?php echo set_value('status_ptpp_status', isset($status_ptpp['status']) ? $status_ptpp['status'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('status'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('status_ptpp_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/settings/status_ptpp', lang('status_ptpp_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>