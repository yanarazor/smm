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
	 
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>
 		<div class="control-group <?php echo form_error('tanggal') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal'. lang('bf_form_label_required'), 'izin_keluar_tanggal', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='izin_keluar_tanggal' type='text' name='izin_keluar_tanggal' class="datepicker"  value="<?php echo set_value('izin_keluar_tanggal', isset($izin_keluar['tanggal']) ? $izin_keluar['tanggal'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('dari_jam') ? 'error' : ''; ?>">
				<?php echo form_label('Dari Jam'. lang('bf_form_label_required'), 'izin_keluar_dari_jam', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='izin_keluar_dari_jam' style="width:100px" type='text' class="timeformat"  type='text' name='izin_keluar_dari_jam'  value="<?php echo set_value('izin_keluar_dari_jam', isset($izin_keluar['dari_jam']) ? $izin_keluar['dari_jam'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('dari_jam'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('sampai_jam') ? 'error' : ''; ?>">
				<?php echo form_label('Sampai Jam'. lang('bf_form_label_required'), 'izin_keluar_sampai_jam', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='izin_keluar_sampai_jam' style="width:100px" type='text' class="timeformat"  type='text' name='izin_keluar_sampai_jam'  value="<?php echo set_value('izin_keluar_sampai_jam', isset($izin_keluar['sampai_jam']) ? $izin_keluar['sampai_jam'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('sampai_jam'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('keterangan') ? 'error' : ''; ?>">
				<?php echo form_label('Keterangan', 'izin_keluar_keterangan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'izin_keluar_keterangan', 'id' => 'izin_keluar_keterangan', 'rows' => '5', 'cols' => '80', 'value' => set_value('izin_keluar_keterangan', isset($izin_keluar['keterangan']) ? $izin_keluar['keterangan'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('keterangan'); ?></span>
				</div>
			</div>
  
  			</fieldset>
			 
				<fieldset>
				<legend>Persetujuan</legend>
				<div class="control-group <?php echo form_error('status_atasan') ? 'error' : ''; ?>">
					<?php echo form_label('Status Atasan', '', array('class' => 'control-label', 'id' => 'surat_izin_status_atasan_label') ); ?>
					<div class='controls' aria-labelled-by='surat_izin_status_atasan_label'>
						<label class='radio' for='surat_izin_status_atasan_option1'>
							<input id='status_atasan' name='status_atasan' type='radio' class='' value='1' <?php if(isset($izin_keluar['status_atasan']) and $izin_keluar['status_atasan']=="1") echo "checked"; ?> />
							Setuju
						</label>
						<br>
						<label class='radio' for='surat_izin_status_atasan_option2'>
							<input id='status_atasan2' name='status_atasan' type='radio' class='' value='2' <?php if(isset($izin_keluar['status_atasan']) and $izin_keluar['status_atasan']=="2") echo "checked"; ?> />
							Tidak Setuju
						</label>
						<span class='help-inline'><?php echo form_error('status_atasan'); ?></span>
					</div>
				</div>
				<div class="control-group <?php echo form_error('alasan_ditolak') ? 'error' : ''; ?>">
				   <?php echo form_label('Alasan (Jika Ditolak)', 'alasan_ditolak', array('class' => 'control-label') ); ?>
				   <div class='controls'>
					   <?php echo form_textarea( array( 'name' => 'alasan_ditolak', 'id' => 'alasan_ditolak', 'rows' => '5', 'cols' => '80', 'value' => set_value('alasan_ditolak', isset($izin_keluar['alasan_ditolak']) ? $izin_keluar['alasan_ditolak'] : '') ) ); ?>
					   <span class='help-inline'><?php echo form_error('alasan_ditolak'); ?></span>
				   </div>
				</div>
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="Simpan"  />
				<?php echo lang('bf_or'); ?>
				<input type="reset" name="reset" class="btn btn-warning" value="Cancel"  />
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript">	  
$('.timeformat').timepicker({ 'timeFormat': 'H:i:s' });
</script>