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

if (isset($dokumen_eksternal))
{
	$dokumen_eksternal = (array) $dokumen_eksternal;
}
$id = isset($dokumen_eksternal['id']) ? $dokumen_eksternal['id'] : '';

?>
<div class="admin-box">
 
	<?php echo form_open_multipart($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>
			<div class="control-group <?php echo form_error('judul') ? 'error' : ''; ?>">
				<?php echo form_label('Judul'. lang('bf_form_label_required'), 'dokumen_eksternal_judul', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='dokumen_eksternal_judul' type='text' name='dokumen_eksternal_judul' maxlength="255" value="<?php echo set_value('dokumen_eksternal_judul', isset($dokumen_eksternal['judul']) ? $dokumen_eksternal['judul'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('judul'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('nomor') ? 'error' : ''; ?>">
				<?php echo form_label('Nomor'. lang('bf_form_label_required'), 'dokumen_eksternal_nomor', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='dokumen_eksternal_nomor' type='text' name='dokumen_eksternal_nomor' maxlength="255" value="<?php echo set_value('dokumen_eksternal_nomor', isset($dokumen_eksternal['nomor']) ? $dokumen_eksternal['nomor'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nomor'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('tanggal_berlaku') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Berlaku', 'dokumen_eksternal_tanggal_berlaku', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='dokumen_eksternal_tanggal_berlaku' type='text' name='dokumen_eksternal_tanggal_berlaku'  value="<?php echo set_value('dokumen_eksternal_tanggal_berlaku', isset($dokumen_eksternal['tanggal_berlaku']) ? $dokumen_eksternal['tanggal_berlaku'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal_berlaku'); ?></span>
				</div>
			</div>
<!--
			<div class="control-group <?php echo form_error('distribusi') ? 'error' : ''; ?>">
				<?php echo form_label('Distribusi', 'dokumen_eksternal_distribusi', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'dokumen_eksternal_distribusi', 'id' => 'dokumen_eksternal_distribusi', 'rows' => '5', 'cols' => '80', 'value' => set_value('dokumen_eksternal_distribusi', isset($dokumen_eksternal['distribusi']) ? $dokumen_eksternal['distribusi'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('distribusi'); ?></span>
				</div>
			</div>
			-->
			<div class="control-group <?php echo form_error('dokumen_eksternal_pengusul') ? 'error' : ''; ?>">
				<?php echo form_label('Diusulkan Oleh', 'dokumen_eksternal_pengusul', array('class' => 'control-label') ); ?>
				<div class='controls'>
                	<select name="dokumen_eksternal_pengusul" id="dokumen_eksternal_pengusul" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($users) && is_array($users) && count($users)):?>
						<?php foreach($users as $user):?>
							<option value="<?php echo $user->id?>" <?php if(isset($dokumen_eksternal['pengusul']))  echo  ($user->id==$dokumen_eksternal['pengusul']) ? "selected" : ""; ?>> <?php e(ucfirst($user->display_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('dokumen_eksternal_pengusul'); ?></span>
				</div>
			</div>


			<div class="control-group <?php echo form_error('dokumen_eksternal_pemeriksa') ? 'error' : ''; ?>">
				<?php echo form_label('Diperiksa Oleh', 'dokumen_eksternal_pemeriksa', array('class' => 'control-label') ); ?>
				<div class='controls'>
                	<select name="dokumen_eksternal_pemeriksa" id="dokumen_eksternal_pemeriksa" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($users) && is_array($users) && count($users)):?>
						<?php foreach($users as $user):?>
							<option value="<?php echo $user->id?>" <?php if(isset($dokumen_eksternal['pemeriksa']))  echo  ($user->id==$dokumen_eksternal['pemeriksa']) ? "selected" : ""; ?>> <?php e(ucfirst($user->display_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('dokumen_eksternal_pemeriksa'); ?></span>
				</div>
			</div>
			<!--
			<div class="control-group <?php echo form_error('dokumen_eksternal_pengesah') ? 'error' : ''; ?>">
				<?php echo form_label('Disahkan Oleh', 'dokumen_eksternal_pengesah', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="dokumen_eksternal_pengesah" id="dokumen_eksternal_pengesah" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($users) && is_array($users) && count($users)):?>
						<?php foreach($users as $user):?>
							<option value="<?php echo $user->id?>" <?php if(isset($dokumen_eksternal['pengesah']))  echo  ($user->id==$dokumen_eksternal['pengesah']) ? "selected" : ""; ?>> <?php e(ucfirst($user->display_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
                    <span class='help-inline'><?php echo form_error('dokumen_eksternal_pengesah'); ?></span>
				</div>
			</div>
			-->
			<div class="control-group <?php echo form_error('status_active') ? 'error' : ''; ?>">
				<?php echo form_label('Status', '', array('class' => 'control-label', 'id' => 'dokumen_eksternal_status_active_label') ); ?>
				<div class='controls' aria-labelled-by='dokumen_eksternal_status_active_label'>
					<label class='radio' for='dokumen_eksternal_status_active_option1'>
						<input id='dokumen_eksternal_status_active_option1' name='dokumen_eksternal_status_active' type='radio' class='' value='1' <?php if(isset($dokumen_eksternal['status_active']))  echo  ($dokumen_eksternal['status_active']=="1") ? "checked" : ""; ?> />
						Aktif
					</label>
					<label class='radio' for='dokumen_eksternal_status_active_option2'>
						<input id='dokumen_eksternal_status_active_option2' name='dokumen_eksternal_status_active' type='radio' class='' value='0' <?php if(isset($dokumen_eksternal['status_active']))  echo  ($dokumen_eksternal['status_active']=="0") ? "checked" : ""; ?> />
						Kadaluarsa
					</label>
					<span class='help-inline'><?php echo form_error('status_active'); ?></span>
				</div>
			</div>

			 <div class="control-group <?php echo form_error('dokumen_eksternal_filename') ? 'error' : ''; ?>">
				<?php echo form_label('File', 'dokumen_eksternal_filename', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<div id="foto">
						<?php 
						$namafile = "";
						 
						if(isset($dokumen_eksternal) && isset($dokumen_eksternal['filename'])  && !empty($dokumen_eksternal['filename'])) :
								 $file = unserialize($dokumen_eksternal['filename']);
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
					<span class="help-block">Max size: 80MB</span> 
					<span class='help-inline'><?php echo form_error('dokumen_eksternal_filename'); ?></span>
				</div>
			</div>
			 

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('dokumen_eksternal_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/dokumen/dokumen_eksternal', lang('dokumen_eksternal_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Dokumen_Eksternal.Dokumen.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('dokumen_eksternal_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('dokumen_eksternal_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>