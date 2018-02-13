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

if (isset($tindakan))
{
	$tindakan = (array) $tindakan;
}
$id = isset($tindakan['id']) ? $tindakan['id'] : '';

?>
<div class="admin-box">
	 <br>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('tindakan') ? 'error' : ''; ?>">
				<?php echo form_label('Tindakan'. lang('bf_form_label_required'), 'tindakan_tindakan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='tindakan_tindakan' type='text' name='tindakan_tindakan' maxlength="100" value="<?php echo set_value('tindakan_tindakan', isset($tindakan['tindakan']) ? $tindakan['tindakan'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tindakan'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('tindakan_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/ketidaksesuaian/tindakan', lang('tindakan_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Tindakan.Ketidaksesuaian.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('tindakan_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('tindakan_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>