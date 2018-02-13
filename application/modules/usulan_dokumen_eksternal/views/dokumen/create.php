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

if (isset($usulan_dokumen_eksternal))
{
	$usulan_dokumen_eksternal = (array) $usulan_dokumen_eksternal;
}
$id = isset($usulan_dokumen_eksternal['id']) ? $usulan_dokumen_eksternal['id'] : '';

?>
<div class="admin-box">
	 
	<?php echo form_open_multipart($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('judul') ? 'error' : ''; ?>">
				<?php echo form_label('Judul'. lang('bf_form_label_required'), 'usulan_dokumen_eksternal_judul', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='usulan_dokumen_eksternal_judul' type='text' name='usulan_dokumen_eksternal_judul' maxlength="255" value="<?php echo set_value('usulan_dokumen_eksternal_judul', isset($usulan_dokumen_eksternal['judul']) ? $usulan_dokumen_eksternal['judul'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('judul'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('nomor') ? 'error' : ''; ?>">
				<?php echo form_label('Nomor', 'usulan_dokumen_eksternal_nomor', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='usulan_dokumen_eksternal_nomor' type='text' name='usulan_dokumen_eksternal_nomor' maxlength="100" value="<?php echo set_value('usulan_dokumen_eksternal_nomor', isset($usulan_dokumen_eksternal['nomor']) ? $usulan_dokumen_eksternal['nomor'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nomor'); ?></span>
				</div>
			</div>
 
 			<div class="control-group <?php echo form_error('usulan_dokumen_eksternal_filename') ? 'error' : ''; ?>">
				<?php echo form_label('Berkas', 'usulan_dokumen_eksternal_filename', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<div id="foto">
						<?php 
						$namafile = "";
						 
						if(isset($usulan_dokumen_eksternal) && isset($usulan_dokumen_eksternal['filename'])  && !empty($usulan_dokumen_eksternal['filename'])) :
								 $file = unserialize($usulan_dokumen_eksternal['filename']);
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
					<span class='help-inline'><?php echo form_error('usulan_dokumen_eksternal_filename'); ?></span>
				</div>
			</div>
			 
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('usulan_dokumen_eksternal_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/dokumen/usulan_dokumen_eksternal', lang('usulan_dokumen_eksternal_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>