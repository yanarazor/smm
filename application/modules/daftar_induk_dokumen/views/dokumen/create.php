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

if (isset($daftar_induk_dokumen))
{
	$daftar_induk_dokumen = (array) $daftar_induk_dokumen;
}
$id = isset($daftar_induk_dokumen['id']) ? $daftar_induk_dokumen['id'] : '';

?>
<div class="admin-box">
	 
	<?php echo form_open_multipart($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('daftar_induk_dokumen_judul') ? 'error' : ''; ?>">
				<?php echo form_label('judul'. lang('bf_form_label_required'), 'daftar_induk_dokumen_judul', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='daftar_induk_dokumen_judul' type='text' name='daftar_induk_dokumen_judul' maxlength="100" value="<?php echo set_value('daftar_induk_dokumen_judul', isset($daftar_induk_dokumen['judul']) ? $daftar_induk_dokumen['judul'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('daftar_induk_dokumen_judul'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('daftar_induk_dokumen_nomor') ? 'error' : ''; ?>">
				<?php echo form_label('Nomor'. lang('bf_form_label_required'), 'daftar_induk_dokumen_nomor', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='daftar_induk_dokumen_nomor' type='text' name='daftar_induk_dokumen_nomor' maxlength="50" value="<?php echo set_value('daftar_induk_dokumen_nomor', isset($daftar_induk_dokumen['nomor']) ? $daftar_induk_dokumen['nomor'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('daftar_induk_dokumen_nomor'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('revisi') ? 'error' : ''; ?>">
				<?php echo form_label('Revisi', 'daftar_induk_dokumen_revisi', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='daftar_induk_dokumen_revisi' type='text' name='daftar_induk_dokumen_revisi' maxlength="10" value="<?php echo set_value('daftar_induk_dokumen_revisi', isset($daftar_induk_dokumen['revisi']) ? $daftar_induk_dokumen['revisi'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('revisi'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('daftar_induk_dokumen_bidang') ? 'error' : ''; ?>">
				<?php echo form_label('Bidang'. lang('bf_form_label_required'), 'daftar_induk_dokumen_bidang', array('class' => 'control-label') ); ?>
				<div class='controls'>
                	<select name="daftar_induk_dokumen_bidang" id="daftar_induk_dokumen_bidang" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($bidangs) && is_array($bidangs) && count($bidangs)):?>
						<?php foreach($bidangs as $bidang):?>
							<option value="<?php echo $bidang->id?>" <?php if(isset($daftar_induk_dokumen['bidang']))  echo  ($bidang->id==$daftar_induk_dokumen['bidang']) ? "selected" : ""; ?>> <?php e(ucfirst($bidang->bidang)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('daftar_induk_dokumen_bidang'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('daftar_induk_dokumen_tanggal_berlaku') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Berlaku'. lang('bf_form_label_required'), 'daftar_induk_dokumen_tanggal_berlaku', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='daftar_induk_dokumen_tanggal_berlaku' type='text' name='daftar_induk_dokumen_tanggal_berlaku'  value="<?php echo set_value('daftar_induk_dokumen_tanggal_berlaku', isset($daftar_induk_dokumen['tanggal_berlaku']) ? $daftar_induk_dokumen['tanggal_berlaku'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('daftar_induk_dokumen_tanggal_berlaku'); ?></span>
				</div>
			</div>
<!--
			<div class="control-group <?php echo form_error('distribusi') ? 'error' : ''; ?>">
				<?php echo form_label('Distribusi Lokasi Pemakaian', 'daftar_induk_dokumen_distribusi', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='daftar_induk_dokumen_distribusi' type='text' name='daftar_induk_dokumen_distribusi' maxlength="100" value="<?php echo set_value('daftar_induk_dokumen_distribusi', isset($daftar_induk_dokumen['distribusi']) ? $daftar_induk_dokumen['distribusi'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('distribusi'); ?></span>
				</div>
			</div>
-->
			<div class="control-group <?php echo form_error('tanggal_dibuat') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Dibuat', 'daftar_induk_dokumen_tanggal_dibuat', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='daftar_induk_dokumen_tanggal_dibuat' type='text' name='daftar_induk_dokumen_tanggal_dibuat'  value="<?php echo set_value('daftar_induk_dokumen_tanggal_dibuat', isset($daftar_induk_dokumen['tanggal_dibuat']) ? $daftar_induk_dokumen['tanggal_dibuat'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal_dibuat'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('tanggal_diperiksa') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Diperiksa', 'daftar_induk_dokumen_tanggal_diperiksa', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='daftar_induk_dokumen_tanggal_diperiksa' type='text' name='daftar_induk_dokumen_tanggal_diperiksa'  value="<?php echo set_value('daftar_induk_dokumen_tanggal_diperiksa', isset($daftar_induk_dokumen['tanggal_diperiksa']) ? $daftar_induk_dokumen['tanggal_diperiksa'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal_diperiksa'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('tanggal_disetujui') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Disetujui', 'daftar_induk_dokumen_tanggal_disetujui', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='daftar_induk_dokumen_tanggal_disetujui' type='text' name='daftar_induk_dokumen_tanggal_disetujui'  value="<?php echo set_value('daftar_induk_dokumen_tanggal_disetujui', isset($daftar_induk_dokumen['tanggal_disetujui']) ? $daftar_induk_dokumen['tanggal_disetujui'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal_disetujui'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('daftar_induk_dokumen_pembuat') ? 'error' : ''; ?>">
				<?php echo form_label('DIbuat Oleh', 'daftar_induk_dokumen_pembuat', array('class' => 'control-label') ); ?>
				<div class='controls'>
                	<select name="daftar_induk_dokumen_pembuat" id="daftar_induk_dokumen_pembuat" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($users) && is_array($users) && count($users)):?>
						<?php foreach($users as $user):?>
							<option value="<?php echo $user->id?>" <?php if(isset($daftar_induk_dokumen['pembuat']))  echo  ($user->id==$daftar_induk_dokumen['pembuat']) ? "selected" : ""; ?>> <?php e(ucfirst($user->display_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('daftar_induk_dokumen_pembuat'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('daftar_induk_dokumen_pemeriksa') ? 'error' : ''; ?>">
				<?php echo form_label('Diperiksa Oleh', 'daftar_induk_dokumen_pemeriksa', array('class' => 'control-label') ); ?>
				<div class='controls'>
                	<select name="daftar_induk_dokumen_pemeriksa" id="daftar_induk_dokumen_pemeriksa" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($users) && is_array($users) && count($users)):?>
						<?php foreach($users as $user):?>
							<option value="<?php echo $user->id?>" <?php if(isset($daftar_induk_dokumen['pemeriksa']))  echo  ($user->id==$daftar_induk_dokumen['pemeriksa']) ? "selected" : ""; ?>> <?php e(ucfirst($user->display_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('daftar_induk_dokumen_pemeriksa'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('pengesah') ? 'error' : ''; ?>">
				<?php echo form_label('Disahkan Oleh', 'daftar_induk_dokumen_pengesah', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="daftar_induk_dokumen_pengesah" id="daftar_induk_dokumen_pengesah" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($users) && is_array($users) && count($users)):?>
						<?php foreach($users as $user):?>
							<option value="<?php echo $user->id?>" <?php if(isset($daftar_induk_dokumen['pengesah']))  echo  ($user->id==$daftar_induk_dokumen['pengesah']) ? "selected" : ""; ?>> <?php e(ucfirst($user->display_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
                    <span class='help-inline'><?php echo form_error('pengesah'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('daftar_induk_dokumen_jenis_dokumen') ? 'error' : ''; ?>">
				<?php echo form_label('Jenis Dokumen', 'daftar_induk_dokumen_jenis_dokumen', array('class' => 'control-label') ); ?>
				<div class='controls'>
                	<select name="daftar_induk_dokumen_jenis_dokumen" id="daftar_induk_dokumen_jenis_dokumen" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($jenis_docs) && is_array($jenis_docs) && count($jenis_docs)):?>
						<?php foreach($jenis_docs as $jenis_doc):?>
							<option value="<?php echo $jenis_doc->id?>" <?php if(isset($daftar_induk_dokumen['jenis_dokumen']))  echo  ($jenis_doc->id==$daftar_induk_dokumen['jenis_dokumen']) ? "selected" : ""; ?>> <?php e(ucfirst($jenis_doc->jenis)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('daftar_induk_dokumen_jenis_dokumen'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('keterangan') ? 'error' : ''; ?>">
				<?php echo form_label('Keterangan', 'daftar_induk_dokumen_keterangan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'daftar_induk_dokumen_keterangan', 'id' => 'daftar_induk_dokumen_keterangan','style'=>'width:600px', 'rows' => '5', 'cols' => '80', 'value' => set_value('daftar_induk_dokumen_keterangan', isset($daftar_induk_dokumen['keterangan']) ? $daftar_induk_dokumen['keterangan'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('keterangan'); ?></span>
				</div>
			</div>
 			 <div class="control-group <?php echo form_error('daftar_induk_dokumen_filename') ? 'error' : ''; ?>">
				<?php echo form_label('File', 'daftar_induk_dokumen_filename', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<div id="foto">
						<?php 
						$namafile = "";
						 
						if(isset($daftar_induk_dokumen) && isset($daftar_induk_dokumen['filename'])  && !empty($daftar_induk_dokumen['filename'])) :
								 $file = unserialize($daftar_induk_dokumen['filename']);
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
					<span class='help-inline'><?php echo form_error('daftar_induk_dokumen_filename'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('status_active') ? 'error' : ''; ?>">
				<?php echo form_label('Status', '', array('class' => 'control-label', 'id' => 'daftar_induk_dokumen_status_active_label') ); ?>
				<div class='controls' aria-labelled-by='daftar_induk_dokumen_status_active_label'>
					<label class='radio' for='daftar_induk_dokumen_status_active_option1'>
						<input id='daftar_induk_dokumen_status_active_option1' name='daftar_induk_dokumen_status_active' type='radio' class='' value='1' <?php echo set_radio('daftar_induk_dokumen_status_active', '1', TRUE); ?> />
						Aktif
					</label>
					<label class='radio' for='daftar_induk_dokumen_status_active_option2'>
						<input id='daftar_induk_dokumen_status_active_option2' name='daftar_induk_dokumen_status_active' type='radio' class='' value='0' <?php echo set_radio('daftar_induk_dokumen_status_active', '0'); ?> />
						Kadaluarsa
					</label>
					<span class='help-inline'><?php echo form_error('status_active'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('daftar_induk_dokumen_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/dokumen/daftar_induk_dokumen', lang('daftar_induk_dokumen_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript">	  

$(document).ready(function() {	  
	 $('#daftar_induk_dokumen_keterangan').wysiwyg();
});
	
	 
</script>