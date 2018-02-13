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

if (isset($daftar_induk_rekaman))
{
	$daftar_induk_rekaman = (array) $daftar_induk_rekaman;
}
$id = isset($daftar_induk_rekaman['id']) ? $daftar_induk_rekaman['id'] : '';

?>
<div class="admin-box">
	 
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>


			<div class="control-group <?php echo form_error('daftar_induk_rekaman_nama') ? 'error' : ''; ?>">
				<?php echo form_label('Nama'. lang('bf_form_label_required'), 'daftar_induk_rekaman_nama', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='daftar_induk_rekaman_nama' type='text' name='daftar_induk_rekaman_nama' maxlength="255" value="<?php echo set_value('daftar_induk_rekaman_nama', isset($daftar_induk_rekaman['nama']) ? $daftar_induk_rekaman['nama'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('daftar_induk_rekaman_nama'); ?></span>
				</div>
			</div>


			<div class="control-group <?php echo form_error('daftar_induk_rekaman_nomor') ? 'error' : ''; ?>">
				<?php echo form_label('Nomor'. lang('bf_form_label_required'), 'daftar_induk_rekaman_nomor', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='daftar_induk_rekaman_nomor' type='text' name='daftar_induk_rekaman_nomor' maxlength="100" value="<?php echo set_value('daftar_induk_rekaman_nomor', isset($daftar_induk_rekaman['nomor']) ? $daftar_induk_rekaman['nomor'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('daftar_induk_rekaman_nomor'); ?></span>
				</div>
			</div>


			<div class="control-group <?php echo form_error('lama_simpan') ? 'error' : ''; ?>">
				<?php echo form_label('Lama Simpan (Arsip Aktif)', 'daftar_induk_rekaman_lama_simpan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='daftar_induk_rekaman_lama_simpan' type='text' name='daftar_induk_rekaman_lama_simpan' maxlength="50" value="<?php echo set_value('daftar_induk_rekaman_lama_simpan', isset($daftar_induk_rekaman['lama_simpan']) ? $daftar_induk_rekaman['lama_simpan'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('lama_simpan'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('lama_simpan_inactive') ? 'error' : ''; ?>">
				<?php echo form_label('Lama Simpan (Arsip In Aktif)', 'lama_simpan_inactive', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='lama_simpan_inactive' type='text' name='lama_simpan_inactive' maxlength="50" value="<?php echo set_value('lama_simpan_inactive', isset($daftar_induk_rekaman['lama_simpan_inactive']) ? $daftar_induk_rekaman['lama_simpan_inactive'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('lama_simpan_inactive'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('tempat_simpan') ? 'error' : ''; ?>">
				<?php echo form_label('Tempat Simpan', 'daftar_induk_rekaman_tempat_simpan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='daftar_induk_rekaman_tempat_simpan' type='text' name='daftar_induk_rekaman_tempat_simpan' maxlength="200" value="<?php echo set_value('daftar_induk_rekaman_tempat_simpan', isset($daftar_induk_rekaman['tempat_simpan']) ? $daftar_induk_rekaman['tempat_simpan'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tempat_simpan'); ?></span>
				</div>
			</div>


			<div class="control-group <?php echo form_error('penanggung_jawab') ? 'error' : ''; ?>">
				<?php echo form_label('Penanggung Jawab', 'daftar_induk_rekaman_penanggung_jawab', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="daftar_induk_rekaman_penanggung_jawab" id="daftar_induk_rekaman_penanggung_jawab" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($bidangs) && is_array($bidangs) && count($bidangs)):?>
						<?php foreach($bidangs as $bidang):?>
							<option value="<?php echo $bidang->id?>" <?php if(isset($daftar_induk_rekaman['penanggung_jawab']))  echo  ($role->role_id==$daftar_induk_rekaman['penanggung_jawab']) ? "selected" : ""; ?>> <?php e(ucfirst($bidang->bidang)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
						 
					</select>
					<span class='help-inline'><?php echo form_error('penanggung_jawab'); ?></span>
				</div>
			</div>
 			<div class="control-group <?php echo form_error('penanggung_jawab_personil') ? 'error' : ''; ?>">
				<?php echo form_label('Personil Penanggung Jawab Rekaman', 'penanggung_jawab_personil', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='penanggung_jawab_personil' type='text' name='penanggung_jawab_personil' maxlength="50" value="<?php echo set_value('penanggung_jawab_personil', isset($daftar_induk_rekaman['penanggung_jawab_personil']) ? $daftar_induk_rekaman['penanggung_jawab_personil'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('penanggung_jawab_personil'); ?></span>
				</div>
			</div>


			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('daftar_induk_rekaman_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/rekaman/daftar_induk_rekaman', lang('daftar_induk_rekaman_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>