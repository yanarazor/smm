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

			<div class="control-group <?php echo form_error('keluhan') ? 'error' : ''; ?>">
				<?php echo form_label('Keluhan', 'perbaikan_sarpras_keluhan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'perbaikan_sarpras_keluhan', 'id' => 'perbaikan_sarpras_keluhan', 'rows' => '5', 'cols' => '80','readonly'=>'readonly','style'=>'width:500px', 'value' => set_value('perbaikan_sarpras_keluhan', isset($perbaikan_sarpras['keluhan']) ? $perbaikan_sarpras['keluhan'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('keluhan'); ?></span>
				</div>
			</div>
			</fieldset>
			<fieldset>
				<legend>Perbaikan</legend>
				<div class="control-group <?php echo form_error('rekomendasi') ? 'error' : ''; ?>">
					<?php echo form_label('Hasil Pengecekan dan Rekomendasi', 'rekomendasi', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<?php echo form_textarea( array( 'name' => 'rekomendasi', 'id' => 'rekomendasi', 'rows' => '5', 'cols' => '80','style'=>'width:500px',  'value' => set_value('rekomendasi', isset($perbaikan_sarpras['rekomendasi']) ? $perbaikan_sarpras['rekomendasi'] : '') ) ); ?>
						<span class='help-inline'><?php echo form_error('rekomendasi'); ?></span>
					</div>
				</div>
				<div class="control-group <?php echo form_error('biaya_kalibrasi') ? 'error' : ''; ?>">
					<?php echo form_label('Biaya', 'biaya_kalibrasi', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<input id='biaya_kalibrasi' type='text' name='biaya_kalibrasi' maxlength="100" value="<?php echo set_value('biaya_kalibrasi', isset($perbaikan_sarpras['biaya_kalibrasi']) ? $perbaikan_sarpras['biaya_kalibrasi'] : ''); ?>" />
						<span class='help-inline'>Jika memerlukan Biaya</span>
					</div>
				</div>
				<div class="control-group <?php echo form_error('status') ? 'error' : ''; ?>">
					<?php echo form_label('Status Perbaikan', 'status', array('class' => 'control-label') ); ?>
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
			<div class="control-group <?php echo form_error('anggaran') ? 'error' : ''; ?>">
					<div class='controls'>
						<?php
							if($perbaikan_sarpras['status_ppk'] == "1")
								echo "Biaya telat disetujui PPK";
						?>
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