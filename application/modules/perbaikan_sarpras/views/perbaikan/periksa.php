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
			<div class="control-group <?php echo form_error('lokasi') ? 'error' : ''; ?>">
				<?php echo form_label('Lokasi/Ruangan', 'lokasi', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='lokasi' type='text' readonly name='lokasi' maxlength="50" value="<?php echo set_value('lokasi', isset($perbaikan_sarpras['lokasi']) ? $perbaikan_sarpras['lokasi'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('lokasi'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('merek') ? 'error' : ''; ?>">
				<?php echo form_label('Merek', 'merek', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='merek' type='text' readonly name='merek' maxlength="50" value="<?php echo set_value('merek', isset($perbaikan_sarpras['merek']) ? $perbaikan_sarpras['merek'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('merek'); ?></span>
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
				<legend>Verifikasi</legend>
				<div class="control-group <?php echo form_error('status_kpu') ? 'error' : ''; ?>">
					<?php echo form_label('Setuju?', '', array('class' => 'control-label', 'id' => 'status_kpu_label') ); ?>
					<div class='controls' aria-labelled-by='status_kpu_label'>
						<label class='radio' for='status_kpu_option1'>
							<input id='status_kpu_option1'  class="validate[required]" name='status_kpu' type='radio' class='' value='1' <?php if(isset($perbaikan_sarpras['status_kpu']) and $perbaikan_sarpras['status_kpu']=="1") echo "checked"; ?> />
							Setuju
						</label>
						<br>
						<label class='radio' for='status_kpu_option2'>
							<input id='status_kpu_option2' name='status_kpu' type='radio' class='' value='2' <?php if(isset($perbaikan_sarpras['status_kpu']) and $perbaikan_sarpras['status_kpu']=="2") echo "checked"; ?> />
							Tidak Setuju
						</label>
						<span class='help-inline'><?php echo form_error('status_kpu'); ?></span>
					</div>
				</div>
				<div class="control-group <?php echo form_error('catatan') ? 'error' : ''; ?>">
					<?php echo form_label('Catatan', 'catatan', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<?php echo form_textarea( array( 'name' => 'catatan', 'id' => 'catatan', 'rows' => '5', 'cols' => '80','style'=>'width:500px',  'value' => set_value('catatan', isset($perbaikan_sarpras['catatan_kpu']) ? $perbaikan_sarpras['catatan_kpu'] : '') ) ); ?>
						<span class='help-inline'><?php echo form_error('catatan'); ?></span>
					</div>
				</div>
				 
				 <div class="control-group <?php echo form_error('biaya_kalibrasi') ? 'error' : ''; ?>">
					<?php echo form_label('Biaya', 'biaya_kalibrasi', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<input id='biaya_kalibrasi' type='text' name='biaya_kalibrasi' maxlength="100" value="<?php echo set_value('biaya_kalibrasi', isset($perbaikan_sarpras['biaya_kalibrasi']) ? $perbaikan_sarpras['biaya_kalibrasi'] : ''); ?>" />
						<span class='help-inline'><?php echo form_error('biaya_kalibrasi'); ?></span>
					</div>
				</div>
				<div class="control-group <?php echo form_error('anggaran') ? 'error' : ''; ?>">
				<?php echo form_label('Anggaran', 'anggaran', array('class' => 'control-label') ); ?>
				<div class='controls' aria-labelled-by='surat_izin_status_atasan_label'>
					<label class='radio' for='anggaran_option1'>
						<input id='anggaran_option1' onclick="changeanggaran(this);" class="validate[required]" name='anggaran' type='radio' class='' value='Tematik' <?php if(isset($perbaikan_sarpras['anggaran']) and $perbaikan_sarpras['anggaran']=="Tematik") echo "checked"; ?> />
						Tematik
					</label>
					<br>
					<label class='radio' for='anggaran_option2'>
						<input id='anggaran_option2' onclick="changeanggaran(this);" name='anggaran' type='radio' class='' value='PNBP' <?php if(isset($perbaikan_sarpras['anggaran']) and $perbaikan_sarpras['anggaran']=="PNBP") echo "checked"; ?> />
						PNBP
					</label>
					<br>
					<label class='radio' for='anggaran_option3'>
						<input id='anggaran_option3' onclick="changeanggaran(this);" name='anggaran' type='radio' class='' value='Rutin' <?php if(isset($perbaikan_sarpras['anggaran']) and $perbaikan_sarpras['anggaran']=="Rutin") echo "checked"; ?> />
						Rutin
					</label>
					<br>
					<span class='help-inline'><?php echo form_error('anggaran'); ?></span>
				</div>
				<div class="control-group <?php echo form_error('anggaran') ? 'error' : ''; ?>">
					<div class='controls'>
						<?php
							if($perbaikan_sarpras['status_ppk'] == "1")
								echo "Biaya telat disetujui PPK";
						?>
					</div>
				</div>
			</div>
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('perbaikan_sarpras_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/perbaikan/perbaikan_sarpras/periksakpu', lang('perbaikan_sarpras_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>

<script>  	
	$(document).ready(function() {	
		$("#frminput").validationEngine();
	});	
	   
</script>
