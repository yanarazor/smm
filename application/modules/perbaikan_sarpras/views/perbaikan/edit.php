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
					<select class="validate[required] text-input" name="perbaikan_sarpras_jenis" id="perbaikan_sarpras_jenis" class="chosen-select-deselect" style="width:500px">
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
				<?php echo form_label('Nama Sarana dan Prasarana', 'perbaikan_sarpras_nama_sarpras', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='perbaikan_sarpras_nama_sarpras' class="validate[required] text-input"  type='text' name='perbaikan_sarpras_nama_sarpras' maxlength="100" value="<?php echo set_value('perbaikan_sarpras_nama_sarpras', isset($perbaikan_sarpras['nama_sarpras']) ? $perbaikan_sarpras['nama_sarpras'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nama_sarpras'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('nomor_inventaris') ? 'error' : ''; ?>">
				<?php echo form_label('Nomor Inventaris', 'perbaikan_sarpras_nomor_inventaris', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='perbaikan_sarpras_nomor_inventaris' type='text' name='perbaikan_sarpras_nomor_inventaris' maxlength="20" value="<?php echo set_value('perbaikan_sarpras_nomor_inventaris', isset($perbaikan_sarpras['nomor_inventaris']) ? $perbaikan_sarpras['nomor_inventaris'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nomor_inventaris'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('lokasi') ? 'error' : ''; ?>">
				<?php echo form_label('Lokasi/Ruangan', 'lokasi', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='lokasi' type='text' name='lokasi' maxlength="50" value="<?php echo set_value('lokasi', isset($perbaikan_sarpras['lokasi']) ? $perbaikan_sarpras['lokasi'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('lokasi'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('merek') ? 'error' : ''; ?>">
				<?php echo form_label('Merek', 'merek', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='merek' type='text' name='merek' maxlength="50" value="<?php echo set_value('merek', isset($perbaikan_sarpras['merek']) ? $perbaikan_sarpras['merek'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('merek'); ?></span>
				</div>
			</div>
			<div class="divkeluhan">
			<div class="control-group <?php echo form_error('keluhan') ? 'error' : ''; ?>">
				<?php echo form_label('Keluhan', 'perbaikan_sarpras_keluhan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'perbaikan_sarpras_keluhan', 'id' => 'perbaikan_sarpras_keluhan', 'rows' => '5', 'cols' => '80','style'=>'width:500px', 'value' => set_value('perbaikan_sarpras_keluhan', isset($perbaikan_sarpras['keluhan']) ? $perbaikan_sarpras['keluhan'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('keluhan'); ?></span>
				</div>
			</div>
			</div>
			<?php if($perbaikan_sarpras['jenis'] == 5) { ?> 
			<div class="divkalibrasi">
				<div class="control-group <?php echo form_error('spesifikasi_alat') ? 'error' : ''; ?>">
					<?php echo form_label('Spesifikasi Alat', 'spesifikasi_alat', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<?php echo form_textarea( array( 'name' => 'spesifikasi_alat', 'id' => 'spesifikasi_alat', 'rows' => '5', 'cols' => '80','style'=>'width:500px', 'value' => set_value('spesifikasi_alat', isset($perbaikan_sarpras['spesifikasi_alat']) ? $perbaikan_sarpras['spesifikasi_alat'] : '') ) ); ?>
						<span class='help-inline'>Rentang ukur, ketelitian, kelas,dll</span>
					</div>
				</div>
				<div class="control-group <?php echo form_error('kalibrasi_diminta') ? 'error' : ''; ?>">
					<?php echo form_label('Kalibrasi Diminta', 'kalibrasi_diminta', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<?php echo form_textarea( array( 'name' => 'kalibrasi_diminta', 'id' => 'kalibrasi_diminta', 'rows' => '5', 'cols' => '80','style'=>'width:500px', 'value' => set_value('kalibrasi_diminta', isset($perbaikan_sarpras['kalibrasi_diminta']) ? $perbaikan_sarpras['kalibrasi_diminta'] : '') ) ); ?>
						<span class='help-inline'>Rentang Ukur Kalibrasi yang diminta</span>
					</div>
				</div>
			</div>	
			<?php } ?>
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('perbaikan_sarpras_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/perbaikan/perbaikan_sarpras', lang('perbaikan_sarpras_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Perbaikan_sarpras.Perbaikan.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('perbaikan_sarpras_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('perbaikan_sarpras_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>
<script>  	
	<?php if($perbaikan_sarpras['jenis'] != 5) { ?> 
		$(".divkalibrasi").hide(1000);
 		$(".divkeluhan").show(1000);
	<?php }else{ ?>
		$(".divkalibrasi").show(1000);
 		$(".divkeluhan").hide(1000);
 	<?php } ?>
	var index = 0;
	$(document).ready(function() {	 
		$("#frminput").validationEngine();
	});	
	$( "#perbaikan_sarpras_jenis" ).change(function() {
 		var valjenis = $( "#perbaikan_sarpras_jenis" ).val();
 		if(valjenis == "1"){
 			$("#merek").val("-");
 			$("#perbaikan_sarpras_nomor_inventaris").val("-");
 		}else{
 			$("#merek").val("");
 			$("#perbaikan_sarpras_nomor_inventaris").val("3.");
 		}
 		if(valjenis == "5"){
 			$(".divkalibrasi").show(1000);
 			$(".divkeluhan").hide(1000);
 		}else{
 			$(".divkalibrasi").hide(1000);
 			$(".divkeluhan").show(1000);
 		}
 		return false;				 	
	});
</script>