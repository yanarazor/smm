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

if (isset($usulan_dokumen_internal))
{
	$usulan_dokumen_internal = (array) $usulan_dokumen_internal;
}
$id = isset($usulan_dokumen_internal['id']) ? $usulan_dokumen_internal['id'] : '';

?>
<div class="admin-box">
	 
	<?php echo form_open_multipart($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('usulan_dokumen_internal_judul') ? 'error' : ''; ?>">
				<?php echo form_label('Judul'. lang('bf_form_label_required'), 'usulan_dokumen_internal_judul', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='usulan_dokumen_internal_judul' type='text' name='usulan_dokumen_internal_judul' maxlength="100" value="<?php echo set_value('usulan_dokumen_internal_judul', isset($usulan_dokumen_internal['judul']) ? $usulan_dokumen_internal['judul'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('usulan_dokumen_internal_judul'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('usulan_dokumen_internal_nomor') ? 'error' : ''; ?>">
				<?php echo form_label('Nomor', 'usulan_dokumen_internal_nomor', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='usulan_dokumen_internal_nomor' type='text' name='usulan_dokumen_internal_nomor' maxlength="50" value="<?php echo set_value('usulan_dokumen_internal_nomor', isset($usulan_dokumen_internal['nomor']) ? $usulan_dokumen_internal['nomor'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('usulan_dokumen_internal_nomor'); ?></span>
				</div>
			</div>
			 <div class="control-group <?php echo form_error('jenis_dokumen') ? 'error' : ''; ?>">
				<?php echo form_label('Jenis Dokumen', 'usulan_dokumen_internal_jenis_dokumen', array('class' => 'control-label') ); ?>
				<div class='controls'>
                	<select name="usulan_dokumen_internal_jenis_dokumen" id="usulan_dokumen_internal_jenis_dokumen" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($jenis_docs) && is_array($jenis_docs) && count($jenis_docs)):?>
						<?php foreach($jenis_docs as $jenis_doc):?>
							<option value="<?php echo $jenis_doc->id?>" <?php if(isset($usulan_dokumen_internal['jenis_dokumen']))  echo  ($jenis_doc->id==$usulan_dokumen_internal['jenis_dokumen']) ? "selected" : ""; ?>> <?php e(ucfirst($jenis_doc->jenis)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('jenis_dokumen'); ?></span>
				</div>
			</div>  
			<div class="control-group <?php echo form_error('usulan_dokumen_internal_bidang') ? 'error' : ''; ?>">
				<?php echo form_label('Bidang'. lang('bf_form_label_required'), 'usulan_dokumen_internal_bidang', array('class' => 'control-label') ); ?>
				<div class='controls'>
                	<select name="usulan_dokumen_internal_bidang" id="usulan_dokumen_internal_bidang" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($bidangs) && is_array($bidangs) && count($bidangs)):?>
						<?php foreach($bidangs as $bidang):?>
							<option value="<?php echo $bidang->id?>" <?php if(isset($usulan_dokumen_internal['id_bidang']))  echo  ($bidang->id==$usulan_dokumen_internal['id_bidang']) ? "selected" : ""; ?>> <?php e(ucfirst($bidang->bidang)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('usulan_dokumen_internal_bidang'); ?></span>
				</div>
			</div>
 			<div class="control-group <?php echo form_error('usulan_dokumen_internal_filename') ? 'error' : ''; ?>">
				<?php echo form_label('File', 'usulan_dokumen_internal_filename', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<div id="foto">
						<?php 
						$namafile = "";
						 
						if(isset($usulan_dokumen_internal) && isset($usulan_dokumen_internal['filename'])  && !empty($usulan_dokumen_internal['filename'])) :
								 $file = unserialize($usulan_dokumen_internal['filename']);
								$namafile = $file['file_name'];
							endif;
						?>
						<div class="get-photo" style="z-index: 690;"> 
							<a href="<?php echo base_url().$this->settings_lib->item('site.urluploaded').$namafile; ?>" target="_blank">
								 <?php echo $namafile; ?>
							</a>
						</div>
					</div>
					<input type="file" class="span6" name="file_upload" id="file_upload" /> 
					<span class="help-block">Max size: 2MB</span> 
					<span class='help-inline'><?php echo form_error('usulan_dokumen_internal_filename'); ?></span>
				</div>
			</div> 
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('usulan_dokumen_internal_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/dokumen/usulan_dokumen_internal', lang('usulan_dokumen_internal_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript">	  

$(document).ready(function() {	  
	 $('#usulan_dokumen_internal_catatan_periksa').wysiwyg();
	 $('#usulan_dokumen_internal_catatan_pengesah').wysiwyg();
});
</script>