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

if (isset($rencana_tahunan))
{
	$rencana_tahunan = (array) $rencana_tahunan;
}
$id = isset($rencana_tahunan['id']) ? $rencana_tahunan['id'] : '';

?>
<div class="admin-box">
	<h3>Rencana Tahunan</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('tahun') ? 'error' : ''; ?>">
				<?php echo form_label('Tahun'. lang('bf_form_label_required'), 'rencana_tahunan_tahun', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='rencana_tahunan_tahun' type='text' name='rencana_tahunan_tahun' maxlength="4" value="<?php echo set_value('rencana_tahunan_tahun', isset($rencana_tahunan['tahun']) ? $rencana_tahunan['tahun'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tahun'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('dari_tanggal') ? 'error' : ''; ?>">
				<?php echo form_label('Dari Tanggal'. lang('bf_form_label_required'), 'rencana_tahunan_dari_tanggal', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='rencana_tahunan_dari_tanggal' type='text' name='rencana_tahunan_dari_tanggal'  value="<?php echo set_value('rencana_tahunan_dari_tanggal', isset($rencana_tahunan['dari_tanggal']) ? $rencana_tahunan['dari_tanggal'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('dari_tanggal'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('sampai_tanggal') ? 'error' : ''; ?>">
				<?php echo form_label('Sampai Tanggal'. lang('bf_form_label_required'), 'rencana_tahunan_sampai_tanggal', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='rencana_tahunan_sampai_tanggal' type='text' name='rencana_tahunan_sampai_tanggal'  value="<?php echo set_value('rencana_tahunan_sampai_tanggal', isset($rencana_tahunan['sampai_tanggal']) ? $rencana_tahunan['sampai_tanggal'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('sampai_tanggal'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('id_bidang') ? 'error' : ''; ?>">
				<?php echo form_label('Bidang'. lang('bf_form_label_required'), 'rencana_tahunan_id_bidang', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='rencana_tahunan_id_bidang' type='text' name='rencana_tahunan_id_bidang' maxlength="4" value="<?php echo set_value('rencana_tahunan_id_bidang', isset($rencana_tahunan['id_bidang']) ? $rencana_tahunan['id_bidang'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('id_bidang'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('status_wm') ? 'error' : ''; ?>">
				<?php echo form_label('Status WM', '', array('class' => 'control-label', 'id' => 'rencana_tahunan_status_wm_label') ); ?>
				<div class='controls' aria-labelled-by='rencana_tahunan_status_wm_label'>
					<label class='radio' for='rencana_tahunan_status_wm_option1'>
						<input id='rencana_tahunan_status_wm_option1' name='rencana_tahunan_status_wm' type='radio' class='' value='option1' <?php echo set_radio('rencana_tahunan_status_wm', 'option1', TRUE); ?> />
						Radio option 1
					</label>
					<label class='radio' for='rencana_tahunan_status_wm_option2'>
						<input id='rencana_tahunan_status_wm_option2' name='rencana_tahunan_status_wm' type='radio' class='' value='option2' <?php echo set_radio('rencana_tahunan_status_wm', 'option2'); ?> />
						Radio option 2
					</label>
					<span class='help-inline'><?php echo form_error('status_wm'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('rencana_tahunan_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/audit/rencana_tahunan', lang('rencana_tahunan_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Rencana_Tahunan.Audit.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('rencana_tahunan_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('rencana_tahunan_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>