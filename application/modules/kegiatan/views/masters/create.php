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

if (isset($kegiatan))
{
	$kegiatan = (array) $kegiatan;
}
$id = isset($kegiatan['id']) ? $kegiatan['id'] : '';

?>
<div class="admin-box" style="min-height:450px">
	<h3>Kegiatan</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('tahun') ? 'error' : ''; ?>">
				<?php echo form_label('Tahun'. lang('bf_form_label_required'), 'kegiatan_tahun', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='kegiatan_tahun' type='text' name='kegiatan_tahun' maxlength="4" value="<?php echo set_value('kegiatan_tahun', isset($kegiatan['tahun']) ? $kegiatan['tahun'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tahun'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('dipa') ? 'error' : ''; ?>">
				<?php echo form_label('Dipa'. lang('bf_form_label_required'), 'kegiatan_dipa', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='kegiatan_dipa' type='text' name='kegiatan_dipa' maxlength="10" value="<?php echo set_value('kegiatan_dipa', isset($kegiatan['dipa']) ? $kegiatan['dipa'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('dipa'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('kode') ? 'error' : ''; ?>">
				<?php echo form_label('Kode', 'kegiatan_kode', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='kegiatan_kode' type='text' name='kegiatan_kode' maxlength="20" value="<?php echo set_value('kegiatan_kode', isset($kegiatan['kode']) ? $kegiatan['kode'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('kode'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('judul') ? 'error' : ''; ?>">
				<?php echo form_label('Judul', 'kegiatan_judul', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='kegiatan_judul' type='text' class="span11" name='kegiatan_judul' maxlength="255" value="<?php echo set_value('kegiatan_judul', isset($kegiatan['judul']) ? $kegiatan['judul'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('judul'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('pj') ? 'error' : ''; ?>">
				<?php echo form_label('Penanggung Jawab'. lang('bf_form_label_required'), 'pj', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="pj" id="pj" class="chosen-select-deselect" style="width:400px">
						<option value="">-- Pilih  --</option>
						<?php if (isset($users) && is_array($users) && count($users)):?>
						<?php foreach($users as $rec):?>
							<option value="<?php echo $rec->id?>" <?php if(isset($kegiatan['pj']))  echo  ($rec->id==$kegiatan['pj']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->display_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('pj'); ?></span>
				</div>
			</div>
		
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('kegiatan_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/masters/kegiatan', lang('kegiatan_cancel'), 'class="btn btn-warning"'); ?>
				
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