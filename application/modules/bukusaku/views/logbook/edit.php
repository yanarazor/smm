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

if (isset($bukusaku))
{
	$bukusaku = (array) $bukusaku;
}
$id = isset($bukusaku['id']) ? $bukusaku['id'] : '';

?>
<div class="admin-box">
	<h3>bukusaku</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('nip_pegawai') ? 'error' : ''; ?>">
				<?php echo form_label('Pegawai'. lang('bf_form_label_required'), 'bukusaku_nip_pegawai', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='bukusaku_nip_pegawai' type='text' name='bukusaku_nip_pegawai' maxlength="30" value="<?php echo set_value('bukusaku_nip_pegawai', isset($bukusaku['nip_pegawai']) ? $bukusaku['nip_pegawai'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nip_pegawai'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('tanggal') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal', 'bukusaku_tanggal', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='bukusaku_tanggal' type='text' name='bukusaku_tanggal'  value="<?php echo set_value('bukusaku_tanggal', isset($bukusaku['tanggal']) ? $bukusaku['tanggal'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('pk') ? 'error' : ''; ?>">
				<?php echo form_label('Pk', 'bukusaku_pk', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='bukusaku_pk' type='text' name='bukusaku_pk' maxlength="50" value="<?php echo set_value('bukusaku_pk', isset($bukusaku['pk']) ? $bukusaku['pk'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('pk'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('jam') ? 'error' : ''; ?>">
				<?php echo form_label('Jam', 'bukusaku_jam', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='bukusaku_jam' type='text' name='bukusaku_jam'  value="<?php echo set_value('bukusaku_jam', isset($bukusaku['jam']) ? $bukusaku['jam'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('jam'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('kegiatan') ? 'error' : ''; ?>">
				<?php echo form_label('Kegiatan', 'bukusaku_kegiatan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'bukusaku_kegiatan', 'id' => 'bukusaku_kegiatan', 'rows' => '5', 'cols' => '80', 'value' => set_value('bukusaku_kegiatan', isset($bukusaku['kegiatan']) ? $bukusaku['kegiatan'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('kegiatan'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('bukusaku_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/logbook/bukusaku', lang('bukusaku_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Bukusaku.Logbook.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('bukusaku_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('bukusaku_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>