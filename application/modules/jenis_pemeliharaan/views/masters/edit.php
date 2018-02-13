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

if (isset($jenis_pemeliharaan))
{
	$jenis_pemeliharaan = (array) $jenis_pemeliharaan;
}
$id = isset($jenis_pemeliharaan['id']) ? $jenis_pemeliharaan['id'] : '';

?>
<div class="admin-box">
	<h3>Jenis Pemeliharaan</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('jenis') ? 'error' : ''; ?>">
				<?php echo form_label('Jenis'. lang('bf_form_label_required'), 'jenis_pemeliharaan_jenis', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='jenis_pemeliharaan_jenis' type='text' name='jenis_pemeliharaan_jenis' maxlength="50" value="<?php echo set_value('jenis_pemeliharaan_jenis', isset($jenis_pemeliharaan['jenis']) ? $jenis_pemeliharaan['jenis'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('jenis'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('petugas') ? 'error' : ''; ?>">
				<?php echo form_label('Petugas'. lang('bf_form_label_required'), 'jenis_pemeliharaan_petugas', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="jenis_pemeliharaan_petugas" id="jenis_pemeliharaan_petugas" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($users) && is_array($users) && count($users)):?>
						<?php foreach($users as $user):?>
							<option value="<?php echo $user->id?>" <?php if(isset($jenis_pemeliharaan['petugas']))  echo  ($user->id==$jenis_pemeliharaan['petugas']) ? "selected" : ""; ?>> <?php e(ucfirst($user->display_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('petugas'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('petugas') ? 'error' : ''; ?>">
				<?php echo form_label('PPK'. lang('bf_form_label_required'), 'jenis_pemeliharaan_petugas', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="verifikasi2" id="verifikasi2" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($users) && is_array($users) && count($users)):?>
						<?php foreach($users as $user):?>
							<option value="<?php echo $user->id?>" <?php if(isset($jenis_pemeliharaan['verifikasi2']))  echo  ($user->id==$jenis_pemeliharaan['verifikasi2']) ? "selected" : ""; ?>> <?php e(ucfirst($user->display_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('petugas'); ?></span>
				</div>
			</div>
			
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('jenis_pemeliharaan_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/masters/jenis_pemeliharaan', lang('jenis_pemeliharaan_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Jenis_Pemeliharaan.Masters.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('jenis_pemeliharaan_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('jenis_pemeliharaan_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>
<link href="<?php echo base_url(); ?>assets/css/chosen/chosen.css" rel="stylesheet" type="text/css" />
<script language='JavaScript' type='text/javascript' src='<?php echo base_url(); ?>assets/js/chosen/chosen.jquery.js'></script>
<script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>