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

if (isset($permintaan_barang))
{
	$permintaan_barang = (array) $permintaan_barang;
}
$id = isset($permintaan_barang['id']) ? $permintaan_barang['id'] : '';

?>
<div class="admin-box">
	<h3>Permintaan Barang</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('nomor') ? 'error' : ''; ?>">
				<?php echo form_label('Nomor'. lang('bf_form_label_required'), 'permintaan_barang_nomor', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='permintaan_barang_nomor' type='text' name='permintaan_barang_nomor' maxlength="10" value="<?php echo set_value('permintaan_barang_nomor', isset($permintaan_barang['nomor']) ? $permintaan_barang['nomor'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nomor'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('user_request') ? 'error' : ''; ?>">
				<?php echo form_label('User', 'permintaan_barang_user_request', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='permintaan_barang_user_request' type='text' name='permintaan_barang_user_request' maxlength="10" value="<?php echo set_value('permintaan_barang_user_request', isset($permintaan_barang['user_request']) ? $permintaan_barang['user_request'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('user_request'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('tanggal_permintaan') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Permintaan', 'permintaan_barang_tanggal_permintaan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='permintaan_barang_tanggal_permintaan' type='text' name='permintaan_barang_tanggal_permintaan'  value="<?php echo set_value('permintaan_barang_tanggal_permintaan', isset($permintaan_barang['tanggal_permintaan']) ? $permintaan_barang['tanggal_permintaan'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal_permintaan'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('anggaran') ? 'error' : ''; ?>">
				<?php echo form_label('Anggaran', 'permintaan_barang_anggaran', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='permintaan_barang_anggaran' type='text' name='permintaan_barang_anggaran' maxlength="10" value="<?php echo set_value('permintaan_barang_anggaran', isset($permintaan_barang['anggaran']) ? $permintaan_barang['anggaran'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('anggaran'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('kegiatan') ? 'error' : ''; ?>">
				<?php echo form_label('Kegiatan', 'permintaan_barang_kegiatan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='permintaan_barang_kegiatan' type='text' name='permintaan_barang_kegiatan' maxlength="10" value="<?php echo set_value('permintaan_barang_kegiatan', isset($permintaan_barang['kegiatan']) ? $permintaan_barang['kegiatan'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('kegiatan'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('tanggal_selesai') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Permintaan Selesai', 'permintaan_barang_tanggal_selesai', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='permintaan_barang_tanggal_selesai' type='text' name='permintaan_barang_tanggal_selesai'  value="<?php echo set_value('permintaan_barang_tanggal_selesai', isset($permintaan_barang['tanggal_selesai']) ? $permintaan_barang['tanggal_selesai'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal_selesai'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('status_atasan') ? 'error' : ''; ?>">
				<?php echo form_label('Status Atasan', '', array('class' => 'control-label', 'id' => 'permintaan_barang_status_atasan_label') ); ?>
				<div class='controls' aria-labelled-by='permintaan_barang_status_atasan_label'>
					<label class='radio' for='permintaan_barang_status_atasan_option1'>
						<input id='permintaan_barang_status_atasan_option1' name='permintaan_barang_status_atasan' type='radio' class='' value='option1' <?php echo set_radio('permintaan_barang_status_atasan', 'option1', TRUE); ?> />
						Radio option 1
					</label>
					<label class='radio' for='permintaan_barang_status_atasan_option2'>
						<input id='permintaan_barang_status_atasan_option2' name='permintaan_barang_status_atasan' type='radio' class='' value='option2' <?php echo set_radio('permintaan_barang_status_atasan', 'option2'); ?> />
						Radio option 2
					</label>
					<span class='help-inline'><?php echo form_error('status_atasan'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('status_kabag') ? 'error' : ''; ?>">
				<?php echo form_label('Status Kabag', '', array('class' => 'control-label', 'id' => 'permintaan_barang_status_kabag_label') ); ?>
				<div class='controls' aria-labelled-by='permintaan_barang_status_kabag_label'>
					<label class='radio' for='permintaan_barang_status_kabag_option1'>
						<input id='permintaan_barang_status_kabag_option1' name='permintaan_barang_status_kabag' type='radio' class='' value='option1' <?php echo set_radio('permintaan_barang_status_kabag', 'option1', TRUE); ?> />
						Radio option 1
					</label>
					<label class='radio' for='permintaan_barang_status_kabag_option2'>
						<input id='permintaan_barang_status_kabag_option2' name='permintaan_barang_status_kabag' type='radio' class='' value='option2' <?php echo set_radio('permintaan_barang_status_kabag', 'option2'); ?> />
						Radio option 2
					</label>
					<span class='help-inline'><?php echo form_error('status_kabag'); ?></span>
				</div>
			</div>

			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
					2 => 2,
				);

				echo form_dropdown('permintaan_barang_status_permintaan', $options, set_value('permintaan_barang_status_permintaan', isset($permintaan_barang['status_permintaan']) ? $permintaan_barang['status_permintaan'] : ''), 'Status Permintaan');
			?>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('permintaan_barang_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/reports/permintaan_barang', lang('permintaan_barang_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Permintaan_Barang.Reports.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('permintaan_barang_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('permintaan_barang_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>