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

if (isset($status_barang))
{
	$status_barang = (array) $status_barang;
}
$id = isset($status_barang['id']) ? $status_barang['id'] : '';

?>
<div class="admin-box">
	<h3>Status Barang</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('status') ? 'error' : ''; ?>">
				<?php echo form_label('Status'. lang('bf_form_label_required'), 'status_barang_status', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='status_barang_status' type='text' name='status_barang_status' maxlength="20" value="<?php echo set_value('status_barang_status', isset($status_barang['status']) ? $status_barang['status'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('status'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('status_barang_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/masters/status_barang', lang('status_barang_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Status_Barang.Masters.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('status_barang_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('status_barang_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>