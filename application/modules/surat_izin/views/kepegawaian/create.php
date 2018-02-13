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

if (isset($surat_izin))
{
	$surat_izin = (array) $surat_izin;
}
$id = isset($surat_izin['id']) ? $surat_izin['id'] : '';

?>
<div class="admin-box">
	 
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>
<!--
			<div class="control-group <?php echo form_error('user') ? 'error' : ''; ?>">
				<?php echo form_label('User', 'surat_izin_user', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='surat_izin_user' type='text' name='surat_izin_user' maxlength="10" value="<?php echo set_value('surat_izin_user', isset($surat_izin['user']) ? $surat_izin['user'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('user'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('nip') ? 'error' : ''; ?>">
				<?php echo form_label('Nip', 'surat_izin_nip', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='surat_izin_nip' type='text' name='surat_izin_nip' maxlength="20" value="<?php echo set_value('surat_izin_nip', isset($surat_izin['nip']) ? $surat_izin['nip'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nip'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('izin') ? 'error' : ''; ?>">
				<?php echo form_label('izin', 'surat_izin_izin', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='surat_izin_izin' type='text' name='surat_izin_izin' maxlength="2" value="<?php echo set_value('surat_izin_izin', isset($surat_izin['izin']) ? $surat_izin['izin'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('izin'); ?></span>
				</div>
			</div>
	-->
			<div class="control-group <?php echo form_error('izin') ? 'error' : ''; ?>">
				<?php echo form_label('Izin', '', array('class' => 'control-label', 'id' => 'surat_izin_izin_label') ); ?>
				<div class='controls' aria-labelled-by='surat_izin_status_atasan_label'>
					<?php if (isset($masterizins) && is_array($masterizins) && count($masterizins)):?>
					 <?php foreach($masterizins as $masterizin):?>
					 	<label class='radio' for='surat_izin_status_atasan_option1'>
							<input id='izin_option_<?php echo $masterizin->id?>' name='izin' type='radio' class='' value='<?php echo $masterizin->id?>' <?php if(isset($surat_izin['izin']) and $surat_izin['izin']==$masterizin->id) echo "checked"; ?> /> 
							<?php echo $masterizin->nama_izin;?>
						</label>
						<br>
						 <?php endforeach;?>
					 <?php endif;?>
					 
					<!--
					<label class='radio' for='surat_izin_status_atasan_option1'>
						<input id='izin_option1' name='izin' type='radio' class='' value='1' <?php if(isset($surat_izin['izin']) and $surat_izin['izin']=="1") echo "selected"; ?> />
						Tidak Masuk Kerja
					</label>
					<br>
					<label class='radio' for='surat_izin_status_atasan_option2'>
						<input id='izin_option2' name='izin' type='radio' class='' value='2' <?php if(isset($surat_izin['izin']) and $surat_izin['izin']=="2") echo "selected"; ?> />
						Izin Pulang Sebelum Waktunya
					</label>
					<br>
					<label class='radio' for='surat_izin_status_atasan_option2'>
						<input id='izin_option3' name='izin' type='radio' class='' value='3' <?php if(isset($surat_izin['izin']) and $surat_izin['izin']=="3") echo "selected"; ?> />
						Pemberitahuan Terlambat Masuk kerja
					</label>
					-->
					<span class='help-inline'><?php echo form_error('izin'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('surat_izin_lama') ? 'error' : ''; ?>">
				<?php echo form_label('Selama'. lang('bf_form_label_required'), 'surat_izin_lama', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='surat_izin_lama' type='text' name='surat_izin_lama' maxlength="20" value="<?php echo set_value('surat_izin_lama', isset($surat_izin['lama']) ? $surat_izin['lama'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('surat_izin_lama'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('surat_izin_satuan') ? 'error' : ''; ?>">
				<?php echo form_label('Satuan'. lang('bf_form_label_required'), 'surat_izin_satuan', array('class' => 'control-label') ); ?>
				<div class='controls' aria-labelled-by='surat_izin_status_atasan_label'>
					<label class='radio' for='surat_izin_satuan1'>
						<input id='surat_izin_satuan1' name='surat_izin_satuan' type='radio' class='' value='Hari' <?php if(isset($surat_izin['satuan']) and $surat_izin['satuan']=="hari") echo "selected"; ?> />
						Hari
					</label>
					<br>
					<label class='radio' for='surat_izin_satuan2'>
						<input id='surat_izin_satuan2' name='surat_izin_satuan' type='radio' class='' value='Jam' <?php if(isset($surat_izin['satuan']) and $surat_izin['satuan']=="Jam") echo "selected"; ?> />
						Jam
					</label>
					<br>
					<label class='radio' for='surat_izin_satuan3'>
						<input id='surat_izin_satuan3' name='surat_izin_satuan' type='radio' class='' value='Menit' <?php if(isset($surat_izin['satuan']) and $surat_izin['satuan']=="Menit") echo "selected"; ?> />
						Menit
					</label>
					<span class='help-inline'><?php echo form_error('izin'); ?></span>
				</div>
				 
			</div>

			<div class="control-group <?php echo form_error('hari') ? 'error' : ''; ?>">
				<?php echo form_label('Hari', 'surat_izin_hari', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='surat_izin_hari' type='text' name='surat_izin_hari' maxlength="30" value="<?php echo set_value('surat_izin_hari', isset($surat_izin['hari']) ? $surat_izin['hari'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('hari'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('surat_izin_tanggal') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Mulai'. lang('bf_form_label_required'), 'surat_izin_tanggal', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='surat_izin_tanggal' type='text' name='surat_izin_tanggal'  value="<?php echo set_value('surat_izin_tanggal', isset($surat_izin['tanggal']) ? $surat_izin['tanggal'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('surat_izin_tanggal'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('surat_izin_tanggal_selesai') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Selesai'. lang('bf_form_label_required'), 'surat_izin_tanggal_selesai', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='surat_izin_tanggal_selesai' type='text' name='surat_izin_tanggal_selesai'  value="<?php echo set_value('surat_izin_tanggal_selesai', isset($surat_izin['tanggal_selese']) ? $surat_izin['tanggal_selese'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('surat_izin_tanggal_selesai'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('surat_izin_alasan') ? 'error' : ''; ?>">
				<?php echo form_label('Alasan'. lang('bf_form_label_required'), 'surat_izin_alasan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'surat_izin_alasan', 'id' => 'surat_izin_alasan', 'rows' => '5', 'cols' => '80', 'value' => set_value('surat_izin_alasan', isset($surat_izin['alasan']) ? $surat_izin['alasan'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('surat_izin_alasan'); ?></span>
				</div>
			</div>
			</fieldset>
			<?php if(isset($surat_izin['status_atasan'])): ?>
				<fieldset>
				<legend>Persetujuan</legend>
				<div class="control-group <?php echo form_error('status_atasan') ? 'error' : ''; ?>">
					<?php echo form_label('Status Atasan', '', array('class' => 'control-label', 'id' => 'surat_izin_status_atasan_label') ); ?>
					<div class='controls' aria-labelled-by='surat_izin_status_atasan_label'>
						<label class='radio' for='surat_izin_status_atasan_option1'>
							<input id='surat_izin_status_atasan_option1' name='surat_izin_status_atasan' type='radio' class='' value='1' <?php echo set_radio('surat_izin_status_atasan', '1', TRUE); ?> />
							Setuju
						</label>
						<br>
						<label class='radio' for='surat_izin_status_atasan_option2'>
							<input id='surat_izin_status_atasan_option2' name='surat_izin_status_atasan' type='radio' class='' value='2' <?php echo set_radio('surat_izin_status_atasan', '2'); ?> />
							Tidak Setuju
						</label>
						<span class='help-inline'><?php echo form_error('status_atasan'); ?></span>
					</div>
				</div>
			<!--
				<div class="control-group <?php echo form_error('tanggal_dibuat') ? 'error' : ''; ?>">
					<?php echo form_label('Tanggal Dibuat', 'surat_izin_tanggal_dibuat', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<input id='surat_izin_tanggal_dibuat' type='text' name='surat_izin_tanggal_dibuat'  value="<?php echo set_value('surat_izin_tanggal_dibuat', isset($surat_izin['tanggal_dibuat']) ? $surat_izin['tanggal_dibuat'] : ''); ?>" />
						<span class='help-inline'><?php echo form_error('tanggal_dibuat'); ?></span>
					</div>
				</div>
			-->
			<?php endif; ?>
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('surat_izin_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/kepegawaian/surat_izin', lang('surat_izin_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>