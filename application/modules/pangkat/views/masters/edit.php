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

if (isset($pangkat))
{
	$pangkat = (array) $pangkat;
}
$id = isset($pangkat['id']) ? $pangkat['id'] : '';

?>
<div class="admin-box">
	<h3>Pangkat</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('pangkat') ? 'error' : ''; ?>">
				<?php echo form_label('Pangkat'. lang('bf_form_label_required'), 'pangkat_pangkat', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='pangkat_pangkat' type='text' name='pangkat_pangkat' maxlength="30" value="<?php echo set_value('pangkat_pangkat', isset($pangkat['pangkat']) ? $pangkat['pangkat'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('pangkat'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('golongan') ? 'error' : ''; ?>">
				<?php echo form_label('Golongan', 'pangkat_golongan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='pangkat_golongan' type='text' name='pangkat_golongan' maxlength="10" value="<?php echo set_value('pangkat_golongan', isset($pangkat['golongan']) ? $pangkat['golongan'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('golongan'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('pajak') ? 'error' : ''; ?>">
				<?php echo form_label('Pajak', 'pangkat_pajak', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='pangkat_pajak' type='text' name='pangkat_pajak' maxlength="5" value="<?php echo set_value('pangkat_pajak', isset($pangkat['pajak']) ? $pangkat['pajak'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('pajak'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('pangkat_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/masters/pangkat', lang('pangkat_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Pangkat.Masters.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('pangkat_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('pangkat_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>