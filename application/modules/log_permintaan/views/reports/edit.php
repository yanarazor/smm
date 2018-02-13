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

if (isset($log_permintaan))
{
	$log_permintaan = (array) $log_permintaan;
}
$id = isset($log_permintaan['id']) ? $log_permintaan['id'] : '';

?>
<div class="admin-box">
	<h3>log permintaan</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('kode_permintaan') ? 'error' : ''; ?>">
				<?php echo form_label('Kode Permintaan'. lang('bf_form_label_required'), 'log_permintaan_kode_permintaan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='log_permintaan_kode_permintaan' type='text' name='log_permintaan_kode_permintaan' maxlength="10" value="<?php echo set_value('log_permintaan_kode_permintaan', isset($log_permintaan['kode_permintaan']) ? $log_permintaan['kode_permintaan'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('kode_permintaan'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('kode_detil_permintaan') ? 'error' : ''; ?>">
				<?php echo form_label('Kode Barang detil', 'log_permintaan_kode_detil_permintaan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='log_permintaan_kode_detil_permintaan' type='text' name='log_permintaan_kode_detil_permintaan' maxlength="10" value="<?php echo set_value('log_permintaan_kode_detil_permintaan', isset($log_permintaan['kode_detil_permintaan']) ? $log_permintaan['kode_detil_permintaan'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('kode_detil_permintaan'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('user_id') ? 'error' : ''; ?>">
				<?php echo form_label('User ID', 'log_permintaan_user_id', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='log_permintaan_user_id' type='text' name='log_permintaan_user_id' maxlength="10" value="<?php echo set_value('log_permintaan_user_id', isset($log_permintaan['user_id']) ? $log_permintaan['user_id'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('user_id'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('tanggal_jam') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Jam'. lang('bf_form_label_required'), 'log_permintaan_tanggal_jam', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='log_permintaan_tanggal_jam' type='text' name='log_permintaan_tanggal_jam'  value="<?php echo set_value('log_permintaan_tanggal_jam', isset($log_permintaan['tanggal_jam']) ? $log_permintaan['tanggal_jam'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal_jam'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('aksi') ? 'error' : ''; ?>">
				<?php echo form_label('Aksi', 'log_permintaan_aksi', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='log_permintaan_aksi' type='text' name='log_permintaan_aksi' maxlength="100" value="<?php echo set_value('log_permintaan_aksi', isset($log_permintaan['aksi']) ? $log_permintaan['aksi'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('aksi'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('keterangan') ? 'error' : ''; ?>">
				<?php echo form_label('Keterangan', 'log_permintaan_keterangan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'log_permintaan_keterangan', 'id' => 'log_permintaan_keterangan', 'rows' => '5', 'cols' => '80', 'value' => set_value('log_permintaan_keterangan', isset($log_permintaan['keterangan']) ? $log_permintaan['keterangan'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('keterangan'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('log_permintaan_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/reports/log_permintaan', lang('log_permintaan_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Log_permintaan.Reports.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('log_permintaan_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('log_permintaan_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>