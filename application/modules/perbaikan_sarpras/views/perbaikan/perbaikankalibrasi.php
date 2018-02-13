<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/validation/validationEngine.jquery.css" type="text/css"/>
	
<script src="<?php echo base_url(); ?>assets/js/validation/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8">
</script>
<script src="<?php echo base_url(); ?>assets/js/validation/jquery.validationEngine.js" type="text/javascript" charset="utf-8">
</script>
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

if (isset($perbaikan_sarpras))
{
	$perbaikan_sarpras = (array) $perbaikan_sarpras;
}
$id = isset($perbaikan_sarpras['id']) ? $perbaikan_sarpras['id'] : '';

?>
<div class="admin-box">
	<h3>Perbaikan sarpras</h3>
		<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal" id="frminput"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('nomor') ? 'error' : ''; ?>">
				<?php echo form_label('Nomor'. lang('bf_form_label_required'), 'perbaikan_sarpras_nomor', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='perbaikan_sarpras_nomor' readonly type='text' name='perbaikan_sarpras_nomor' maxlength="10" value="<?php echo set_value('perbaikan_sarpras_nomor', isset($perbaikan_sarpras['nomor']) ? $perbaikan_sarpras['nomor'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nomor'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('jenis') ? 'error' : ''; ?>">
				<?php echo form_label('Jenis Pemeliharaan'. lang('bf_form_label_required'), 'perbaikan_sarpras_jenis', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select readonly name="perbaikan_sarpras_jenis" id="perbaikan_sarpras_jenis" class="chosen-select-deselect" style="width:500px">
						<option value="">-- Pilih  --</option>
						<?php if (isset($jenis_pemeliharaans) && is_array($jenis_pemeliharaans) && count($jenis_pemeliharaans)):?>
						<?php foreach($jenis_pemeliharaans as $rec):?>
							<option value="<?php echo $rec->id?>" <?php if(isset($perbaikan_sarpras['jenis']))  echo  ($rec->id==$perbaikan_sarpras['jenis']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->jenis)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('jenis'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('nama_sarpras') ? 'error' : ''; ?>">
				<?php echo form_label('Nama Sarpras', 'perbaikan_sarpras_nama_sarpras', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='perbaikan_sarpras_nama_sarpras' readonly  type='text' name='perbaikan_sarpras_nama_sarpras' maxlength="100" value="<?php echo set_value('perbaikan_sarpras_nama_sarpras', isset($perbaikan_sarpras['nama_sarpras']) ? $perbaikan_sarpras['nama_sarpras'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nama_sarpras'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('nomor_inventaris') ? 'error' : ''; ?>">
				<?php echo form_label('Nomor Inventaris', 'perbaikan_sarpras_nomor_inventaris', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='perbaikan_sarpras_nomor_inventaris' type='text' readonly name='perbaikan_sarpras_nomor_inventaris' maxlength="20" value="<?php echo set_value('perbaikan_sarpras_nomor_inventaris', isset($perbaikan_sarpras['nomor_inventaris']) ? $perbaikan_sarpras['nomor_inventaris'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nomor_inventaris'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('merek') ? 'error' : ''; ?>">
				<?php echo form_label('Merek/Type alat', 'merek', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='merek' type='text' name='merek' readonly maxlength="50" value="<?php echo set_value('merek', isset($perbaikan_sarpras['merek']) ? $perbaikan_sarpras['merek'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('merek'); ?></span>
				</div>
			</div>
			<div class="divkalibrasi">
				<div class="control-group <?php echo form_error('spesifikasi_alat') ? 'error' : ''; ?>">
					<?php echo form_label('Spesifikasi Alat', 'spesifikasi_alat', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<?php echo form_textarea( array( 'name' => 'spesifikasi_alat','readonly'=>'readonly', 'id' => 'spesifikasi_alat', 'rows' => '5', 'cols' => '80','style'=>'width:500px', 'value' => set_value('spesifikasi_alat', isset($perbaikan_sarpras['spesifikasi_alat']) ? $perbaikan_sarpras['spesifikasi_alat'] : '') ) ); ?>
						<span class='help-inline'>Rentang ukur, ketelitian, kelas,dll</span>
					</div>
				</div>
				<div class="control-group <?php echo form_error('kalibrasi_diminta') ? 'error' : ''; ?>">
					<?php echo form_label('Kalibrasi Diminta', 'kalibrasi_diminta', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<?php echo form_textarea( array( 'name' => 'kalibrasi_diminta','readonly'=>'readonly', 'id' => 'kalibrasi_diminta', 'rows' => '5', 'cols' => '80','style'=>'width:500px', 'value' => set_value('kalibrasi_diminta', isset($perbaikan_sarpras['kalibrasi_diminta']) ? $perbaikan_sarpras['kalibrasi_diminta'] : '') ) ); ?>
						<span class='help-inline'>Rentang Ukur Kalibrasi yang diminta</span>
					</div>
				</div>
			</div>	
			</fieldset>
			<fieldset>
				<legend>Hasil</legend>
				<div class="control-group <?php echo form_error('lab_kalibrasi') ? 'error' : ''; ?>">
					<?php echo form_label('Lab Kalibrasi', 'lab_kalibrasi', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<input id='lab_kalibrasi' type='text' name='lab_kalibrasi' maxlength="100" value="<?php echo set_value('lab_kalibrasi', isset($perbaikan_sarpras['lab_kalibrasi']) ? $perbaikan_sarpras['lab_kalibrasi'] : ''); ?>" />
						<span class='help-inline'><?php echo form_error('lab_kalibrasi'); ?></span>
					</div>
				</div>
				<div class="control-group <?php echo form_error('biaya_kalibrasi') ? 'error' : ''; ?>">
					<?php echo form_label('Biaya Kalibrasi', 'biaya_kalibrasi', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<input id='biaya_kalibrasi' type='text' name='biaya_kalibrasi' maxlength="100" value="<?php echo set_value('biaya_kalibrasi', isset($perbaikan_sarpras['biaya_kalibrasi']) ? $perbaikan_sarpras['biaya_kalibrasi'] : ''); ?>" />
						<span class='help-inline'><?php echo form_error('biaya_kalibrasi'); ?></span>
					</div>
				</div>
				<div class="control-group <?php echo form_error('status') ? 'error' : ''; ?>">
					<?php echo form_label('Status', 'status', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<select name="status" class="validate[required] text-input"  id="status" >
							<option value="">-- Pilih  --</option>
							<?php if (isset($status_pemeliharaans) && is_array($status_pemeliharaans) && count($status_pemeliharaans)):?>
							<?php foreach($status_pemeliharaans as $rec):?>
								<option value="<?php echo $rec->id?>" <?php if(isset($perbaikan_sarpras['status']))  echo  ($rec->id==$perbaikan_sarpras['status']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->status_perbaikan)); ?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
						<span class='help-inline'><?php echo form_error('status'); ?></span>
					</div>
				</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('perbaikan_sarpras_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/perbaikan/perbaikan_sarpras', lang('perbaikan_sarpras_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>

<script>  	
	$(document).ready(function() {	
		$("#frminput").validationEngine();
	});	
	   
</script>