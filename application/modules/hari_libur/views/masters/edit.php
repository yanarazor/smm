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

if (isset($hari_libur))
{
	$hari_libur = (array) $hari_libur;
}
$id = isset($hari_libur['id']) ? $hari_libur['id'] : '';

?>
<div class="admin-box">
	<h3>Hari Libur</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('tanggal') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal'. lang('bf_form_label_required'), 'hari_libur_tanggal', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='hari_libur_tanggal' type='text' name='hari_libur_tanggal'  value="<?php echo set_value('hari_libur_tanggal', isset($hari_libur['tanggal']) ? $hari_libur['tanggal'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('keterangan') ? 'error' : ''; ?>">
				<?php echo form_label('Keterangan', 'hari_libur_keterangan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='hari_libur_keterangan' type='text' name='hari_libur_keterangan' maxlength="50" value="<?php echo set_value('hari_libur_keterangan', isset($hari_libur['keterangan']) ? $hari_libur['keterangan'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('keterangan'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('hari_libur_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/masters/hari_libur', lang('hari_libur_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Hari_Libur.Masters.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('hari_libur_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('hari_libur_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>