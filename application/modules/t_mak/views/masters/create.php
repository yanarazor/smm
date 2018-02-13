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

if (isset($t_mak))
{
	$t_mak = (array) $t_mak;
}
$id = isset($t_mak['id']) ? $t_mak['id'] : '';

?>
<div class="admin-box">
	<h3>t mak</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('kdmak') ? 'error' : ''; ?>">
				<?php echo form_label('Kode Mak'. lang('bf_form_label_required'), 't_mak_kdmak', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='t_mak_kdmak' type='text' name='t_mak_kdmak' maxlength="6" value="<?php echo set_value('t_mak_kdmak', isset($t_mak['kdmak']) ? $t_mak['kdmak'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('kdmak'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('nmmak') ? 'error' : ''; ?>">
				<?php echo form_label('Nama Mak'. lang('bf_form_label_required'), 't_mak_nmmak', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='t_mak_nmmak' type='text' name='t_mak_nmmak' maxlength="200" value="<?php echo set_value('t_mak_nmmak', isset($t_mak['nmmak']) ? $t_mak['nmmak'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nmmak'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('t_mak_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/masters/t_mak', lang('t_mak_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>