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

if (isset($usulan_perubahan_dokumen))
{
	$usulan_perubahan_dokumen = (array) $usulan_perubahan_dokumen;
}
$id = isset($usulan_perubahan_dokumen['id']) ? $usulan_perubahan_dokumen['id'] : '';

?>
<div class="admin-box">
	<h3>Usulan Perubahan Dokumen</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('pengusul') ? 'error' : ''; ?>">
				<?php echo form_label('Pengusul'. lang('bf_form_label_required'), 'usulan_perubahan_dokumen_pengusul', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='usulan_perubahan_dokumen_pengusul' type='text' name='usulan_perubahan_dokumen_pengusul' maxlength="10" value="<?php echo set_value('usulan_perubahan_dokumen_pengusul', isset($usulan_perubahan_dokumen['pengusul']) ? $usulan_perubahan_dokumen['pengusul'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('pengusul'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('tanggal_permintaan') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Permintaan', 'usulan_perubahan_dokumen_tanggal_permintaan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='usulan_perubahan_dokumen_tanggal_permintaan' type='text' name='usulan_perubahan_dokumen_tanggal_permintaan'  value="<?php echo set_value('usulan_perubahan_dokumen_tanggal_permintaan', isset($usulan_perubahan_dokumen['tanggal_permintaan']) ? $usulan_perubahan_dokumen['tanggal_permintaan'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal_permintaan'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('kode_dokumen') ? 'error' : ''; ?>">
				<?php echo form_label('Dokumen'. lang('bf_form_label_required'), 'usulan_perubahan_dokumen_kode_dokumen', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='usulan_perubahan_dokumen_kode_dokumen' type='text' name='usulan_perubahan_dokumen_kode_dokumen' maxlength="10" value="<?php echo set_value('usulan_perubahan_dokumen_kode_dokumen', isset($usulan_perubahan_dokumen['kode_dokumen']) ? $usulan_perubahan_dokumen['kode_dokumen'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('kode_dokumen'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('judul') ? 'error' : ''; ?>">
				<?php echo form_label('Judul Dokumen', 'usulan_perubahan_dokumen_judul', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='usulan_perubahan_dokumen_judul' type='text' name='usulan_perubahan_dokumen_judul' maxlength="255" value="<?php echo set_value('usulan_perubahan_dokumen_judul', isset($usulan_perubahan_dokumen['judul']) ? $usulan_perubahan_dokumen['judul'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('judul'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('nomor') ? 'error' : ''; ?>">
				<?php echo form_label('Nomor', 'usulan_perubahan_dokumen_nomor', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='usulan_perubahan_dokumen_nomor' type='text' name='usulan_perubahan_dokumen_nomor' maxlength="50" value="<?php echo set_value('usulan_perubahan_dokumen_nomor', isset($usulan_perubahan_dokumen['nomor']) ? $usulan_perubahan_dokumen['nomor'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nomor'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('revisi') ? 'error' : ''; ?>">
				<?php echo form_label('Revisi', 'usulan_perubahan_dokumen_revisi', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='usulan_perubahan_dokumen_revisi' type='text' name='usulan_perubahan_dokumen_revisi' maxlength="10" value="<?php echo set_value('usulan_perubahan_dokumen_revisi', isset($usulan_perubahan_dokumen['revisi']) ? $usulan_perubahan_dokumen['revisi'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('revisi'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('bagian_diubah') ? 'error' : ''; ?>">
				<?php echo form_label('Bagian Yang Diubah', 'usulan_perubahan_dokumen_bagian_diubah', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'usulan_perubahan_dokumen_bagian_diubah', 'id' => 'usulan_perubahan_dokumen_bagian_diubah', 'rows' => '5', 'cols' => '80', 'value' => set_value('usulan_perubahan_dokumen_bagian_diubah', isset($usulan_perubahan_dokumen['bagian_diubah']) ? $usulan_perubahan_dokumen['bagian_diubah'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('bagian_diubah'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('manfaat_perubahan') ? 'error' : ''; ?>">
				<?php echo form_label('Manfaat Perubahan', 'usulan_perubahan_dokumen_manfaat_perubahan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'usulan_perubahan_dokumen_manfaat_perubahan', 'id' => 'usulan_perubahan_dokumen_manfaat_perubahan', 'rows' => '5', 'cols' => '80', 'value' => set_value('usulan_perubahan_dokumen_manfaat_perubahan', isset($usulan_perubahan_dokumen['manfaat_perubahan']) ? $usulan_perubahan_dokumen['manfaat_perubahan'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('manfaat_perubahan'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('catatan_pemeriksa') ? 'error' : ''; ?>">
				<?php echo form_label('Catatan Pemeriksa', 'usulan_perubahan_dokumen_catatan_pemeriksa', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'usulan_perubahan_dokumen_catatan_pemeriksa', 'id' => 'usulan_perubahan_dokumen_catatan_pemeriksa', 'rows' => '5', 'cols' => '80', 'value' => set_value('usulan_perubahan_dokumen_catatan_pemeriksa', isset($usulan_perubahan_dokumen['catatan_pemeriksa']) ? $usulan_perubahan_dokumen['catatan_pemeriksa'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('catatan_pemeriksa'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('tanggal_diusulkan') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Diusulkan', 'usulan_perubahan_dokumen_tanggal_diusulkan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='usulan_perubahan_dokumen_tanggal_diusulkan' type='text' name='usulan_perubahan_dokumen_tanggal_diusulkan'  value="<?php echo set_value('usulan_perubahan_dokumen_tanggal_diusulkan', isset($usulan_perubahan_dokumen['tanggal_diusulkan']) ? $usulan_perubahan_dokumen['tanggal_diusulkan'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal_diusulkan'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('pemeriksa') ? 'error' : ''; ?>">
				<?php echo form_label('Pemeriksa', 'usulan_perubahan_dokumen_pemeriksa', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='usulan_perubahan_dokumen_pemeriksa' type='text' name='usulan_perubahan_dokumen_pemeriksa' maxlength="10" value="<?php echo set_value('usulan_perubahan_dokumen_pemeriksa', isset($usulan_perubahan_dokumen['pemeriksa']) ? $usulan_perubahan_dokumen['pemeriksa'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('pemeriksa'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('tanggal_diperiksa') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Diperiksa', 'usulan_perubahan_dokumen_tanggal_diperiksa', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='usulan_perubahan_dokumen_tanggal_diperiksa' type='text' name='usulan_perubahan_dokumen_tanggal_diperiksa'  value="<?php echo set_value('usulan_perubahan_dokumen_tanggal_diperiksa', isset($usulan_perubahan_dokumen['tanggal_diperiksa']) ? $usulan_perubahan_dokumen['tanggal_diperiksa'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal_diperiksa'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('penyetuju') ? 'error' : ''; ?>">
				<?php echo form_label('Penyetuju', 'usulan_perubahan_dokumen_penyetuju', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='usulan_perubahan_dokumen_penyetuju' type='text' name='usulan_perubahan_dokumen_penyetuju' maxlength="10" value="<?php echo set_value('usulan_perubahan_dokumen_penyetuju', isset($usulan_perubahan_dokumen['penyetuju']) ? $usulan_perubahan_dokumen['penyetuju'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('penyetuju'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('tanggal_persetujuan') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Persetujuan', 'usulan_perubahan_dokumen_tanggal_persetujuan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='usulan_perubahan_dokumen_tanggal_persetujuan' type='text' name='usulan_perubahan_dokumen_tanggal_persetujuan'  value="<?php echo set_value('usulan_perubahan_dokumen_tanggal_persetujuan', isset($usulan_perubahan_dokumen['tanggal_persetujuan']) ? $usulan_perubahan_dokumen['tanggal_persetujuan'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal_persetujuan'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('filename') ? 'error' : ''; ?>">
				<?php echo form_label('File', 'usulan_perubahan_dokumen_filename', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='usulan_perubahan_dokumen_filename' type='text' name='usulan_perubahan_dokumen_filename'  value="<?php echo set_value('usulan_perubahan_dokumen_filename', isset($usulan_perubahan_dokumen['filename']) ? $usulan_perubahan_dokumen['filename'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('filename'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('usulan_perubahan_dokumen_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/dokumen/usulan_perubahan_dokumen', lang('usulan_perubahan_dokumen_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Usulan_Perubahan_Dokumen.Dokumen.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('usulan_perubahan_dokumen_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('usulan_perubahan_dokumen_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>