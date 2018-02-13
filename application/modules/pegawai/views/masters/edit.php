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

if (isset($pegawai))
{
	$pegawai = (array) $pegawai;
}
$id = isset($pegawai['id']) ? $pegawai['id'] : '';

?>
<div class="admin-box">
	<h3>Pegawai</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('nip') ? 'error' : ''; ?>">
				<?php echo form_label('NIP'. lang('bf_form_label_required'), 'pegawai_nip', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='pegawai_nip' type='text' name='pegawai_nip' maxlength="25" value="<?php echo set_value('pegawai_nip', isset($pegawai['nip']) ? $pegawai['nip'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nip'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('no_absen') ? 'error' : ''; ?>">
				<?php echo form_label('No Absen'. lang('bf_form_label_required'), 'pegawai_no_absen', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='pegawai_no_absen' type='text' name='pegawai_no_absen' maxlength="10" value="<?php echo set_value('pegawai_no_absen', isset($pegawai['no_absen']) ? $pegawai['no_absen'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('no_absen'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('nama') ? 'error' : ''; ?>">
				<?php echo form_label('Nama'. lang('bf_form_label_required'), 'pegawai_nama', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='pegawai_nama' type='text' name='pegawai_nama' maxlength="50" value="<?php echo set_value('pegawai_nama', isset($pegawai['nama']) ? $pegawai['nama'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nama'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('jabatan') ? 'error' : ''; ?>">
				<?php echo form_label('Jabatan', 'jabatan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select class="validate[required] text-input" name="pegawai_jabatan" id="pegawai_jabatan" class="chosen-select-deselect" style="width:700px">
						<option value="">-- Pilih  --</option>
						<?php if (isset($jabatans) && is_array($jabatans) && count($jabatans)):?>
						<?php foreach($jabatans as $rec):?>
							<option value="<?php echo $rec->id?>" <?php if(isset($pegawai['jabatan']))  echo  ($rec->id==$pegawai['jabatan']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->nama_jabatan)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('jabatan'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('golongan') ? 'error' : ''; ?>">
				<?php echo form_label('Golongan', 'permintaan_barang_kegiatan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select class="validate[required] text-input" name="pegawai_golongan" id="pegawai_golongan" class="chosen-select-deselect" style="width:700px">
						<option value="">-- Pilih  --</option>
						<?php if (isset($golongans) && is_array($golongans) && count($golongans)):?>
						<?php foreach($golongans as $rec):?>
							<option value="<?php echo $rec->kode_pangkat?>" <?php if(isset($pegawai['golongan']))  echo  ($rec->kode_pangkat==$pegawai['golongan']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->pangkat)); echo $rec->kode_pangkat; ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('golongan'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('nomor_rekening') ? 'error' : ''; ?>">
				<?php echo form_label('Nomor Rekening', 'pegawai_nomor_rekening', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='pegawai_nomor_rekening' type='text' name='pegawai_nomor_rekening' maxlength="30" value="<?php echo set_value('pegawai_nomor_rekening', isset($pegawai['nomor_rekening']) ? $pegawai['nomor_rekening'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nomor_rekening'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('pegawai_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/masters/pegawai', lang('pegawai_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Pegawai.Masters.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('pegawai_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('pegawai_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>