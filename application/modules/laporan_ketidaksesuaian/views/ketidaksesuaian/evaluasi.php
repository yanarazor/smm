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

if (isset($laporan_ketidaksesuaian))
{
	$laporan_ketidaksesuaian = (array) $laporan_ketidaksesuaian;
}
$id = isset($laporan_ketidaksesuaian['id']) ? $laporan_ketidaksesuaian['id'] : '';

?>
<div class="admin-box">
	 
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>
<!--
			<div class="control-group <?php echo form_error('laporan_ketidaksesuaian_nomor') ? 'error' : ''; ?>">
				<?php echo form_label('Nomor'. lang('bf_form_label_required'), 'laporan_ketidaksesuaian_nomor', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='laporan_ketidaksesuaian_nomor' type='text' name='laporan_ketidaksesuaian_nomor' maxlength="30" value="<?php echo set_value('laporan_ketidaksesuaian_nomor', isset($laporan_ketidaksesuaian['nomor']) ? $laporan_ketidaksesuaian['nomor'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('laporan_ketidaksesuaian_nomor'); ?></span>
				</div>
			</div>
-->
		
			<div class="control-group <?php echo form_error('laporan_ketidaksesuaian_kegiatan') ? 'error' : ''; ?>">
				<?php echo form_label('Kegiatan'. lang('bf_form_label_required'), 'laporan_ketidaksesuaian_kegiatan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='pengaju' type='hidden' name='pengaju' maxlength="30" value="<?php echo set_value('pengaju', isset($laporan_ketidaksesuaian['pengaju']) ? $laporan_ketidaksesuaian['pengaju'] : ''); ?>" />
					
					<input id='laporan_ketidaksesuaian_kegiatan' type='text' name='laporan_ketidaksesuaian_kegiatan' maxlength="50" value="<?php echo set_value('laporan_ketidaksesuaian_kegiatan', isset($laporan_ketidaksesuaian['kegiatan']) ? $laporan_ketidaksesuaian['kegiatan'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('laporan_ketidaksesuaian_kegiatan'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('laporan_ketidaksesuaian_penanggung_jawab') ? 'error' : ''; ?>">
				<?php echo form_label('Penanggung Jawab'. lang('bf_form_label_required'), 'laporan_ketidaksesuaian_penanggung_jawab', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="laporan_ketidaksesuaian_penanggung_jawab" id="laporan_ketidaksesuaian_penanggung_jawab" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($users) && is_array($users) && count($users)):?>
						<?php foreach($users as $user):?>
							<option value="<?php echo $user->id?>" <?php if(isset($laporan_ketidaksesuaian['penanggung_jawab']))  echo  ($user->id==$laporan_ketidaksesuaian['penanggung_jawab']) ? "selected" : ""; ?>> <?php e(ucfirst($user->display_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('laporan_ketidaksesuaian_penanggung_jawab'); ?></span>
				</div>
			</div> 
			<div class="control-group <?php echo form_error('tanggal_penemuan') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Penemuan', 'laporan_ketidaksesuaian_tanggal_penemuan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='laporan_ketidaksesuaian_tanggal_penemuan' type='text' name='laporan_ketidaksesuaian_tanggal_penemuan'  value="<?php echo set_value('laporan_ketidaksesuaian_tanggal_penemuan', isset($laporan_ketidaksesuaian['tanggal_penemuan']) ? $laporan_ketidaksesuaian['tanggal_penemuan'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal_penemuan'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('bidang_bagian') ? 'error' : ''; ?>">
				<?php echo form_label('Bidang', 'laporan_ketidaksesuaian_bidang_bagian', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="laporan_ketidaksesuaian_bidang_bagian" id="laporan_ketidaksesuaian_bidang_bagian" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($bidangs) && is_array($bidangs) && count($bidangs)):?>
						<?php foreach($bidangs as $bidang):?>
							<option value="<?php echo $bidang->id?>" <?php if(isset($laporan_ketidaksesuaian['bidang_bagian']))  echo  ($bidang->id==$laporan_ketidaksesuaian['bidang_bagian']) ? "selected" : ""; ?>> <?php e(ucfirst($bidang->bidang)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<!--<input id='laporan_ketidaksesuaian_bidang_bagian' type='text' name='laporan_ketidaksesuaian_bidang_bagian' maxlength="20" value="<?php echo set_value('laporan_ketidaksesuaian_bidang_bagian', isset($laporan_ketidaksesuaian['bidang_bagian']) ? $laporan_ketidaksesuaian['bidang_bagian'] : ''); ?>" />
					-->
					<span class='help-inline'><?php echo form_error('bidang_bagian'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('ketidaksesuaian') ? 'error' : ''; ?>">
				<?php echo form_label('Ketidaksesuaian', 'laporan_ketidaksesuaian_ketidaksesuaian', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'laporan_ketidaksesuaian_ketidaksesuaian', 'id' => 'laporan_ketidaksesuaian_ketidaksesuaian','style'=>'width:600px', 'rows' => '5', 'cols' => '80', 'value' => set_value('laporan_ketidaksesuaian_ketidaksesuaian', isset($laporan_ketidaksesuaian['ketidaksesuaian']) ? $laporan_ketidaksesuaian['ketidaksesuaian'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('ketidaksesuaian'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('seharusnya') ? 'error' : ''; ?>">
				<?php echo form_label('Seharusnya', 'laporan_ketidaksesuaian_seharusnya', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'laporan_ketidaksesuaian_seharusnya', 'id' => 'laporan_ketidaksesuaian_seharusnya','style'=>'width:600px', 'rows' => '5', 'cols' => '80', 'value' => set_value('laporan_ketidaksesuaian_seharusnya', isset($laporan_ketidaksesuaian['seharusnya']) ? $laporan_ketidaksesuaian['seharusnya'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('seharusnya'); ?></span>
				</div>
			</div>
			</fieldset>
            
            	<fieldset>
			<legend>Verifikasi WM</legend>
				<div class="control-group <?php echo form_error('laporan_ketidaksesuaian_status_evaluasi_swm') ? 'error' : ''; ?>">
					<?php echo form_label('Status &nbsp;', '', array('class' => 'control-label', 'id' => 'laporan_ketidaksesuaian_status_evaluasi_swm_label') ); ?>
					<div class='controls'> 
						<label class='radio' for='laporan_ketidaksesuaian_status_evaluasi_swm_option1'>
							<input id='laporan_ketidaksesuaian_status_evaluasi_swm_option1' name='laporan_ketidaksesuaian_status_evaluasi_swm' type='radio' value='1' <?php if(isset($laporan_ketidaksesuaian['status_evaluasi_swm'])){ echo $laporan_ketidaksesuaian['status_evaluasi_swm']=="1" ? "checked" : ""; } ?> <?php echo set_radio('laporan_ketidaksesuaian_status_evaluasi_swm', '1'); ?> />
							Setuju (Kirim ke Penggung Jawab)
						</label>
						</br>
						<label class='radio' for='laporan_ketidaksesuaian_status_evaluasi_swm_option2'>
							<input id='laporan_ketidaksesuaian_status_evaluasi_swm_option2' name='laporan_ketidaksesuaian_status_evaluasi_swm' type='radio' value='0' <?php if(isset($laporan_ketidaksesuaian['status_evaluasi_swm'])){ echo $laporan_ketidaksesuaian['status_evaluasi_swm']=="0" ? "checked" : ""; }  ?> <?php echo set_radio('laporan_ketidaksesuaian_status_evaluasi_swm', '0'); ?> />
							Tidak Setuju
						</label>
							
							
						<span class='help-inline'><?php echo form_error('laporan_ketidaksesuaian_status_evaluasi_swm'); ?></span>
					</div>
				</div>
			
			 </fieldset>
			<fieldset>
			<legend>Persetujuan</legend>    
			 
			<div class="control-group <?php echo form_error('tgl_persetujuan_kabid') ? 'error' : ''; ?>">
				<?php echo form_label('Tgl Persetujuan Kabid', 'laporan_ketidaksesuaian_tgl_persetujuan_kabid', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='laporan_ketidaksesuaian_tgl_persetujuan_kabid' type='text' name='laporan_ketidaksesuaian_tgl_persetujuan_kabid'  value="<?php echo set_value('laporan_ketidaksesuaian_tgl_persetujuan_kabid', isset($laporan_ketidaksesuaian['tgl_persetujuan_kabid']) ? $laporan_ketidaksesuaian['tgl_persetujuan_kabid'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tgl_persetujuan_kabid'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('laporan_ketidaksesuaian_keputusan') ? 'error' : ''; ?>">
				<?php echo form_label('Keputusan &nbsp;', 'laporan_ketidaksesuaian_keputusan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					 
						<?php if (isset($tindakans) && is_array($tindakans) && count($tindakans)):?>
						<?php foreach($tindakans as $tindakan):?>
                        	<label class='radio'>
							<input id='laporan_ketidaksesuaian_status_evaluasi_swm_option1' name='laporan_ketidaksesuaian_keputusan' type='radio' value='1' <?php if(isset($laporan_ketidaksesuaian['keputusan'])){ echo $laporan_ketidaksesuaian['keputusan']==$tindakan->id ? "checked" : ""; } ?> <?php echo set_radio('laporan_ketidaksesuaian_keputusan', '1'); ?> />
							<?php echo $tindakan->tindakan; ?>
						</label>
						</br>
						<?php endforeach;?>
						<?php endif;?>
					 
					<span class='help-inline'><?php echo form_error('laporan_ketidaksesuaian_penanggung_jawab'); ?></span>
				</div>
			</div> 
			<div class="control-group <?php echo form_error('keterangan') ? 'error' : ''; ?>">
				<?php echo form_label('Keterangan', 'laporan_ketidaksesuaian_keterangan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'laporan_ketidaksesuaian_keterangan', 'id' => 'laporan_ketidaksesuaian_keterangan','style'=>'width:600px', 'rows' => '5', 'cols' => '80', 'value' => set_value('laporan_ketidaksesuaian_keterangan', isset($laporan_ketidaksesuaian['keterangan']) ? $laporan_ketidaksesuaian['keterangan'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('keterangan'); ?></span>
				</div>
			</div>
			 
			<div class="control-group <?php echo form_error('batas_waktu_penyelesaian') ? 'error' : ''; ?>">
				<?php echo form_label('Batas Waktu Penyelesaian', 'batas_waktu_penyelesaian', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='laporan_ketidaksesuaian_batas_waktu_penyelesaian' type='text' name='laporan_ketidaksesuaian_batas_waktu_penyelesaian'  value="<?php echo set_value('laporan_ketidaksesuaian_batas_waktu_penyelesaian', isset($laporan_ketidaksesuaian['batas_waktu_penyelesaian']) ? $laporan_ketidaksesuaian['batas_waktu_penyelesaian'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('batas_waktu_penyelesaian'); ?></span>
				</div>
			</div>
			 </fieldset>
			<fieldset>
			<legend>Status Akhir</legend>    
			 <div class="control-group <?php echo form_error('status_close') ? 'error' : ''; ?>">
					<?php echo form_label('Status Close&nbsp;', '', array('class' => 'control-label', 'id' => 'laporan_ketidaksesuaian_status_evaluasi_swm_label') ); ?>
					<div class='controls'> 
						<label class='radio' for='status_close'>
						<input type='checkbox' id='status_close' name='status_close' value='1' <?php echo (isset($laporan_ketidaksesuaian['status_close']) && $laporan_ketidaksesuaian['status_close'] == 1) ? 'checked="checked"' : set_checkbox('status_close', 1); ?>>
						<span class='help-inline'>Checklist Jika Sudah Close</span>
	
						</label>
						 

					</div>
				</div>
			<!--
			<div class="control-group <?php echo form_error('tgl_close') ? 'error' : ''; ?>">
				<?php echo form_label('Tgl Close', 'laporan_ketidaksesuaian_tgl_close', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='laporan_ketidaksesuaian_tgl_close' type='text' name='laporan_ketidaksesuaian_tgl_close'  value="<?php echo set_value('laporan_ketidaksesuaian_tgl_close', isset($laporan_ketidaksesuaian['tgl_close']) ? $laporan_ketidaksesuaian['tgl_close'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tgl_close'); ?></span>
				</div>
			</div>
			  -->
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('laporan_ketidaksesuaian_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/ketidaksesuaian/laporan_ketidaksesuaian', lang('laporan_ketidaksesuaian_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Laporan_Ketidaksesuaian.Ketidaksesuaian.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('laporan_ketidaksesuaian_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('laporan_ketidaksesuaian_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript">	  
$(document).ready(function() {	  
	 $('#laporan_ketidaksesuaian_ketidaksesuaian').wysiwyg();
	 $('#laporan_ketidaksesuaian_seharusnya').wysiwyg(); 
	 $('#laporan_ketidaksesuaian_keterangan').wysiwyg(); 
	 
});

</script>