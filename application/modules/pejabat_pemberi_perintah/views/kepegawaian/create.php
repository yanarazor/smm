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

if (isset($pejabat_pemberi_perintah))
{
	$pejabat_pemberi_perintah = (array) $pejabat_pemberi_perintah;
}
$id = isset($pejabat_pemberi_perintah['id']) ? $pejabat_pemberi_perintah['id'] : '';

?>
<div class="admin-box">
	<h3>Pejabat Pemberi Perintah</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('nama') ? 'error' : ''; ?>">
				<?php echo form_label('Jabatan'. lang('bf_form_label_required'), 'pejabat_pemberi_perintah_nama', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='pejabat_pemberi_perintah_nama' type='text' name='pejabat_pemberi_perintah_nama' maxlength="50" value="<?php echo set_value('pejabat_pemberi_perintah_nama', isset($pejabat_pemberi_perintah['nama']) ? $pejabat_pemberi_perintah['nama'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nama'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('pejabat_pemberi_perintah_nama_pejabat') ? 'error' : ''; ?>">
				<?php echo form_label('Nama'. lang('bf_form_label_required'), 'pejabat_pemberi_perintah_nama', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='pejabat_pemberi_perintah_nama_pejabat' type='text' name='pejabat_pemberi_perintah_nama_pejabat' maxlength="50" value="<?php echo set_value('pejabat_pemberi_perintah_nama_pejabat', isset($pejabat_pemberi_perintah['nama_pejabat']) ? $pejabat_pemberi_perintah['nama_pejabat'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('pejabat_pemberi_perintah_nama_pejabat'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('nip') ? 'error' : ''; ?>">
				<?php echo form_label('Nip', 'pejabat_pemberi_perintah_nip', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='pejabat_pemberi_perintah_nip' type='text' name='pejabat_pemberi_perintah_nip' maxlength="30" value="<?php echo set_value('pejabat_pemberi_perintah_nip', isset($pejabat_pemberi_perintah['nip']) ? $pejabat_pemberi_perintah['nip'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nip'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('pejabat_pemberi_perintah_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/kepegawaian/pejabat_pemberi_perintah', lang('pejabat_pemberi_perintah_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>