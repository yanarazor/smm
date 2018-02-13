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
 
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
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
			<!--
			<div class="control-group <?php echo form_error('pengusul') ? 'error' : ''; ?>">
				<?php echo form_label('Pengusul', 'usulan_dokumen_eksternal_pengusul', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo isset($usulan_dokumen_eksternal['pengusul']) ? $usulan_dokumen_eksternal['pengusul'] : '' ?>
                </div>
			</div>
 			-->
			<div class="control-group <?php echo form_error('usulan_dokumen_eksternal_status') ? 'error' : ''; ?>">
				<?php echo form_label('Status', '', array('class' => 'control-label', 'id' => 'usulan_dokumen_eksternal_status_label') ); ?>
				<div class='controls' aria-labelled-by='usulan_dokumen_eksternal_status_label'>
                	<label class='radio' for='usulan_dokumen_eksternal_status_option1'>
						<input id='usulan_dokumen_eksternal_status_option1' name='usulan_dokumen_eksternal_status' type='radio' value='1' <?php echo $usulan_dokumen_eksternal['status']=="1" ? "checked" : "" ?> <?php echo set_radio('usulan_dokumen_eksternal_status', '1'); ?> />
						Ya
					</label>
					</br>
					<label class='radio' for='usulan_dokumen_eksternal_status_option2'>
						<input id='usulan_dokumen_eksternal_status_option2' name='usulan_dokumen_eksternal_status' type='radio' value='0' <?php echo $usulan_dokumen_eksternal['status']=="0" ? "checked" : "" ?> <?php echo set_radio('usulan_dokumen_eksternal_status', '0'); ?> />
						Tidak
					</label>
                   
					<span class='help-inline'><?php echo form_error('usulan_dokumen_eksternal_status'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('catatan') ? 'error' : ''; ?>">
				<?php echo form_label('Catatan', 'usulan_dokumen_eksternal_catatan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'usulan_dokumen_eksternal_catatan', 'id' => 'usulan_dokumen_eksternal_catatan','style'=>'width:600px', 'rows' => '5', 'cols' => '80', 'value' => set_value('usulan_dokumen_eksternal_catatan', isset($usulan_dokumen_eksternal['catatan']) ? $usulan_dokumen_eksternal['catatan'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('catatan'); ?></span>
				</div>
			</div>
  
			<div class="control-group <?php echo form_error('daftar_induk_dokumen_filename') ? 'error' : ''; ?>">
				<?php echo form_label('File', 'daftar_induk_dokumen_filename', array('class' => 'control-label') ); ?>
				<div class='controls'>
					 
						<?php 
						$namafile = "";
						 
						if(isset($usulan_dokumen_eksternal) && isset($usulan_dokumen_eksternal['filename'])  && !empty($usulan_dokumen_eksternal['filename'])) :
								 $file = unserialize($usulan_dokumen_eksternal['filename']);
								$namafile = $file['file_name'];
							endif;
						?>
                     
                        <a href="<?php echo base_url().$this->settings_lib->item('site.urluploaded').$namafile; ?>" target="_blank" class="fancy">
                             <?php echo $namafile; ?>
                        </a>
					 
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('usulan_dokumen_eksternal_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/dokumen/usulan_dokumen_eksternal', lang('usulan_dokumen_eksternal_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Usulan_Dokumen_Eksternal.Dokumen.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('usulan_dokumen_eksternal_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('usulan_dokumen_eksternal_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript">	  

$(document).ready(function() {	  
	 $('#usulan_dokumen_eksternal_catatan').wysiwyg();
	
});
	
	 
</script>