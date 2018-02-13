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
 
			<div class="control-group <?php echo form_error('tanggal_absen') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Absen'. lang('bf_form_label_required'), 'lupa_timer_tanggal_absen', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='lupa_timer_tanggal_absen' type='text' readonly name='lupa_timer_tanggal_absen'  value="<?php echo set_value('lupa_timer_tanggal_absen', isset($lupa_timer['tanggal_absen']) ? $lupa_timer['tanggal_absen'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal_absen'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('jam_sebenarnya') ? 'error' : ''; ?>">
				<?php echo form_label('Jam Sebernarnya', 'lupa_timer_jam_sebenarnya', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='lupa_timer_jam_sebenarnya' style="width:80px" type='text' class="timeformat" name='lupa_timer_jam_sebenarnya' maxlength="10" value="<?php echo set_value('lupa_timer_jam_sebenarnya', isset($lupa_timer['jam_sebenarnya']) ? $lupa_timer['jam_sebenarnya'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('jam_sebenarnya'); ?></span>ex : 17:30
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('lupa_timer_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<input type="reset" name="reset" class="btn btn-warning" value="Cancel"  />
				
			<?php if ($this->auth->has_permission('Lupa_Timer.Kepegawaian.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('lupa_timer_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('lupa_timer_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript">	  
$('.timeformat').timepicker({ 'timeFormat': 'H:i:s' });
</script>