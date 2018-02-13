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

if (isset($audit_internal))
{
	$audit_internal = (array) $audit_internal;
}
$id = isset($audit_internal['id']) ? $audit_internal['id'] : '';

?>
<div class="admin-box">
	 
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('audit_internal_judul') ? 'error' : ''; ?>">
				<?php echo form_label('Judul'. lang('bf_form_label_required'), 'audit_internal_judul', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='audit_internal_judul' type='text' name='audit_internal_judul' maxlength="100" value="<?php echo set_value('audit_internal_judul', isset($audit_internal['judul']) ? $audit_internal['judul'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('audit_internal_judul'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('audit_internal_dari_tanggal') ? 'error' : ''; ?>">
				<?php echo form_label('Dari Tanggal'. lang('bf_form_label_required'), 'audit_internal_dari_tanggal', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='audit_internal_dari_tanggal' type='text' name='audit_internal_dari_tanggal'  value="<?php echo set_value('audit_internal_dari_tanggal', isset($audit_internal['dari_tanggal']) ? $audit_internal['dari_tanggal'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('audit_internal_dari_tanggal'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('audit_internal_sampai_tanggal') ? 'error' : ''; ?>">
				<?php echo form_label('Sampai Tanggal'. lang('bf_form_label_required'), 'audit_internal_sampai_tanggal', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='audit_internal_sampai_tanggal' type='text' name='audit_internal_sampai_tanggal'  value="<?php echo set_value('audit_internal_sampai_tanggal', isset($audit_internal['sampai_tanggal']) ? $audit_internal['sampai_tanggal'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('audit_internal_sampai_tanggal'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('audit_internal_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/audit/audit_internal', lang('audit_internal_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>