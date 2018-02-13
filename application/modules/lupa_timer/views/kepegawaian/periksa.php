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

if (isset($lupa_timer))
{
	$lupa_timer = (array) $lupa_timer;
}
$id = isset($lupa_timer['id']) ? $lupa_timer['id'] : '';

?>
<div class="admin-box">
	 
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>
 
			<div class="control-group <?php echo form_error('tanggal_absen') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Absen'. lang('bf_form_label_required'), 'lupa_timer_tanggal_absen', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='nip' type='hidden' name='nip'  value="<?php echo set_value('nip', isset($lupa_timer['nip']) ? $lupa_timer['nip'] : ''); ?>" />
					<input id='nama' type='hidden' name='nama'  value="<?php echo set_value('nama', isset($lupa_timer['user_pengusul']) ? $lupa_timer['user_pengusul'] : ''); ?>" />
					
					<input id='lupa_timer_tanggal_absen' type='text' name='lupa_timer_tanggal_absen'  value="<?php echo set_value('lupa_timer_tanggal_absen', isset($lupa_timer['tanggal_absen']) ? $lupa_timer['tanggal_absen'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal_absen'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('absen') ? 'error' : ''; ?>">
				<?php echo form_label('Absen'. lang('bf_form_label_required'), 'surat_izin_satuan', array('class' => 'control-label') ); ?>
				<div class='controls' aria-labelled-by='surat_izin_status_atasan_label'>
					<label class='radio' for='surat_izin_satuan1'>
						<input id='absen1' name='lupa_timer_absen' type='radio' class='' value='Masuk' <?php if(isset($lupa_timer['absen']) and $lupa_timer['absen']=="Masuk") echo "checked"; ?> />
						Masuk
					</label>
					<br>
					<label class='radio' for='surat_izin_satuan2'>
						<input id='absen2' name='lupa_timer_absen' type='radio' class='' value='Pulang' <?php if(isset($lupa_timer['absen']) and $lupa_timer['absen']=="Pulang") echo "checked"; ?> />
						Pulang
					</label> 
					<span class='help-inline'><?php echo form_error('absen'); ?></span>
				</div>
				 
			</div>
 
			<div class="control-group <?php echo form_error('jam_sebenarnya') ? 'error' : ''; ?>">
				<?php echo form_label('Jam Sebernarnya', 'lupa_timer_jam_sebenarnya', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='lupa_timer_jam_sebenarnya' style="width:90px" type='text' class="timeformat"  name='lupa_timer_jam_sebenarnya' maxlength="10" value="<?php echo set_value('lupa_timer_jam_sebenarnya', isset($lupa_timer['jam_sebenarnya']) ? $lupa_timer['jam_sebenarnya'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('jam_sebenarnya'); ?></span>ex : 17:30
				</div>
			</div>
  			</fieldset>
			 
				<fieldset>
				<legend>Persetujuan</legend>
				<div class="control-group <?php echo form_error('status_atasan') ? 'error' : ''; ?>">
					<?php echo form_label('Status Atasan', '', array('class' => 'control-label', 'id' => 'surat_izin_status_atasan_label') ); ?>
					<div class='controls' aria-labelled-by='surat_izin_status_atasan_label'>
						<label class='radio' for='surat_izin_status_atasan_option1'>
							<input id='status_atasan' name='status_atasan' type='radio' class='' value='1' <?php if(isset($lupa_timer['status_atasan']) and $lupa_timer['status_atasan']=="1") echo "checked"; ?> />
							Setuju
						</label>
						<br>
						<label class='radio' for='surat_izin_status_atasan_option2'>
							<input id='status_atasan2' name='status_atasan' type='radio' class='' value='2' <?php if(isset($lupa_timer['status_atasan']) and $lupa_timer['status_atasan']=="2") echo "checked"; ?> />
							Tidak Setuju
						</label>
						<span class='help-inline'><?php echo form_error('status_atasan'); ?></span>
					</div>
				</div>
				<div class="control-group <?php echo form_error('alasan_ditolak') ? 'error' : ''; ?>">
				   <?php echo form_label('Alasan (Jika Ditolak)', 'alasan_ditolak', array('class' => 'control-label') ); ?>
				   <div class='controls'>
					   <?php echo form_textarea( array( 'name' => 'alasan_ditolak', 'id' => 'alasan_ditolak', 'rows' => '5', 'cols' => '80', 'value' => set_value('alasan_ditolak', isset($lupa_timer['alasan_ditolak']) ? $lupa_timer['alasan_ditolak'] : '') ) ); ?>
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