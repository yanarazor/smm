<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery.timepicker.css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.timepicker.js"></script>
 
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

if (isset($izin_keluar))
{
	$izin_keluar = (array) $izin_keluar;
}
$id = isset($izin_keluar['id']) ? $izin_keluar['id'] : '';

?>
<div class="admin-box">
	 <div class="alert alert-block alert-warning fade in">
	   <a class="close" data-dismiss="alert">&times;</a>
	   <h4 class="alert-heading">Perhatian :</h4>
	   Izin meninggalkan tempat kerja dipergunakan untuk pegawai yang sudah absen datang dan bekerja di kantor, lalu memerlukan izin di tengah-tengah jam kerja, kemudian kembali lagi ke kantor untuk bekerja dan menerakan absen pulang.
   </div>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('izin_keluar_tanggal') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal'. lang('bf_form_label_required'), 'izin_keluar_tanggal', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='izin_keluar_tanggal' type='text' name='izin_keluar_tanggal' class="datepicker"  value="<?php echo set_value('izin_keluar_tanggal', isset($izin_keluar['tanggal']) ? $izin_keluar['tanggal'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('izin_keluar_tanggal'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('izin_keluar_dari_jam') ? 'error' : ''; ?>">
				<?php echo form_label('Dari Jam'. lang('bf_form_label_required'), 'izin_keluar_dari_jam', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='izin_keluar_dari_jam' autofocus style="width:100px" type='text' class="timeformat"  type='text' name='izin_keluar_dari_jam'  value="<?php echo set_value('izin_keluar_dari_jam', isset($izin_keluar['dari_jam']) ? $izin_keluar['dari_jam'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('izin_keluar_dari_jam'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('izin_keluar_sampai_jam') ? 'error' : ''; ?>">
				<?php echo form_label('Sampai Jam'. lang('bf_form_label_required'), 'izin_keluar_sampai_jam', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='izin_keluar_sampai_jam' style="width:100px" type='text' class="timeformat"  type='text' name='izin_keluar_sampai_jam' value="<?php echo set_value('izin_keluar_sampai_jam', isset($izin_keluar['sampai_jam']) ? $izin_keluar['sampai_jam'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('izin_keluar_sampai_jam'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('keterangan') ? 'error' : ''; ?>">
				<?php echo form_label('Keterangan', 'izin_keluar_keterangan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'izin_keluar_keterangan', 'id' => 'izin_keluar_keterangan', 'rows' => '5', 'cols' => '80','tabindex'=>'0', 'value' => set_value('izin_keluar_keterangan', isset($izin_keluar['keterangan']) ? $izin_keluar['keterangan'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('keterangan'); ?></span>
				</div>
			</div> 
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('izin_keluar_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/kepegawaian/izin_keluar', lang('izin_keluar_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript">	  
$("#izin_keluar_keterangan").focus();
$('.timeformat').timepicker({ 'timeFormat': 'H:i:s' });
</script>