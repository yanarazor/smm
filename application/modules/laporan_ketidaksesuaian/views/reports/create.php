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
	<h3>Laporan Ketidaksesuaian</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('nomor') ? 'error' : ''; ?>">
				<?php echo form_label('Nomor'. lang('bf_form_label_required'), 'laporan_ketidaksesuaian_nomor', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='laporan_ketidaksesuaian_nomor' type='text' name='laporan_ketidaksesuaian_nomor' maxlength="30" value="<?php echo set_value('laporan_ketidaksesuaian_nomor', isset($laporan_ketidaksesuaian['nomor']) ? $laporan_ketidaksesuaian['nomor'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nomor'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('kegiatan') ? 'error' : ''; ?>">
				<?php echo form_label('Kegiatan'. lang('bf_form_label_required'), 'laporan_ketidaksesuaian_kegiatan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='laporan_ketidaksesuaian_kegiatan' type='text' name='laporan_ketidaksesuaian_kegiatan' maxlength="50" value="<?php echo set_value('laporan_ketidaksesuaian_kegiatan', isset($laporan_ketidaksesuaian['kegiatan']) ? $laporan_ketidaksesuaian['kegiatan'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('kegiatan'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('penanggung_jawab') ? 'error' : ''; ?>">
				<?php echo form_label('Penanggung Jawab', 'laporan_ketidaksesuaian_penanggung_jawab', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='laporan_ketidaksesuaian_penanggung_jawab' type='text' name='laporan_ketidaksesuaian_penanggung_jawab' maxlength="10" value="<?php echo set_value('laporan_ketidaksesuaian_penanggung_jawab', isset($laporan_ketidaksesuaian['penanggung_jawab']) ? $laporan_ketidaksesuaian['penanggung_jawab'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('penanggung_jawab'); ?></span>
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
					<input id='laporan_ketidaksesuaian_bidang_bagian' type='text' name='laporan_ketidaksesuaian_bidang_bagian' maxlength="20" value="<?php echo set_value('laporan_ketidaksesuaian_bidang_bagian', isset($laporan_ketidaksesuaian['bidang_bagian']) ? $laporan_ketidaksesuaian['bidang_bagian'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('bidang_bagian'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('ketidaksesuaian') ? 'error' : ''; ?>">
				<?php echo form_label('Ketidaksesuaian', 'laporan_ketidaksesuaian_ketidaksesuaian', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'laporan_ketidaksesuaian_ketidaksesuaian', 'id' => 'laporan_ketidaksesuaian_ketidaksesuaian', 'rows' => '5', 'cols' => '80', 'value' => set_value('laporan_ketidaksesuaian_ketidaksesuaian', isset($laporan_ketidaksesuaian['ketidaksesuaian']) ? $laporan_ketidaksesuaian['ketidaksesuaian'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('ketidaksesuaian'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('seharusnya') ? 'error' : ''; ?>">
				<?php echo form_label('Seharusnya', 'laporan_ketidaksesuaian_seharusnya', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'laporan_ketidaksesuaian_seharusnya', 'id' => 'laporan_ketidaksesuaian_seharusnya', 'rows' => '5', 'cols' => '80', 'value' => set_value('laporan_ketidaksesuaian_seharusnya', isset($laporan_ketidaksesuaian['seharusnya']) ? $laporan_ketidaksesuaian['seharusnya'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('seharusnya'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('status_evaluasi_swm') ? 'error' : ''; ?>">
				<?php echo form_label('Status SWM', '', array('class' => 'control-label', 'id' => 'laporan_ketidaksesuaian_status_evaluasi_swm_label') ); ?>
				<div class='controls' aria-labelled-by='laporan_ketidaksesuaian_status_evaluasi_swm_label'>
					<label class='radio' for='laporan_ketidaksesuaian_status_evaluasi_swm_option1'>
						<input id='laporan_ketidaksesuaian_status_evaluasi_swm_option1' name='laporan_ketidaksesuaian_status_evaluasi_swm' type='radio' class='' value='option1' <?php echo set_radio('laporan_ketidaksesuaian_status_evaluasi_swm', 'option1', TRUE); ?> />
						Radio option 1
					</label>
					<label class='radio' for='laporan_ketidaksesuaian_status_evaluasi_swm_option2'>
						<input id='laporan_ketidaksesuaian_status_evaluasi_swm_option2' name='laporan_ketidaksesuaian_status_evaluasi_swm' type='radio' class='' value='option2' <?php echo set_radio('laporan_ketidaksesuaian_status_evaluasi_swm', 'option2'); ?> />
						Radio option 2
					</label>
					<span class='help-inline'><?php echo form_error('status_evaluasi_swm'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('tgl_persetujuan_swm') ? 'error' : ''; ?>">
				<?php echo form_label('Tgl Persetujuan SWM', 'laporan_ketidaksesuaian_tgl_persetujuan_swm', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='laporan_ketidaksesuaian_tgl_persetujuan_swm' type='text' name='laporan_ketidaksesuaian_tgl_persetujuan_swm'  value="<?php echo set_value('laporan_ketidaksesuaian_tgl_persetujuan_swm', isset($laporan_ketidaksesuaian['tgl_persetujuan_swm']) ? $laporan_ketidaksesuaian['tgl_persetujuan_swm'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tgl_persetujuan_swm'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('tgl_persetujuan_kabid') ? 'error' : ''; ?>">
				<?php echo form_label('Tgl Persetujuan Kabid', 'laporan_ketidaksesuaian_tgl_persetujuan_kabid', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='laporan_ketidaksesuaian_tgl_persetujuan_kabid' type='text' name='laporan_ketidaksesuaian_tgl_persetujuan_kabid'  value="<?php echo set_value('laporan_ketidaksesuaian_tgl_persetujuan_kabid', isset($laporan_ketidaksesuaian['tgl_persetujuan_kabid']) ? $laporan_ketidaksesuaian['tgl_persetujuan_kabid'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tgl_persetujuan_kabid'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('keterangan') ? 'error' : ''; ?>">
				<?php echo form_label('Keterangan', 'laporan_ketidaksesuaian_keterangan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'laporan_ketidaksesuaian_keterangan', 'id' => 'laporan_ketidaksesuaian_keterangan', 'rows' => '5', 'cols' => '80', 'value' => set_value('laporan_ketidaksesuaian_keterangan', isset($laporan_ketidaksesuaian['keterangan']) ? $laporan_ketidaksesuaian['keterangan'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('keterangan'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('tgl_close') ? 'error' : ''; ?>">
				<?php echo form_label('Tgl Close', 'laporan_ketidaksesuaian_tgl_close', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='laporan_ketidaksesuaian_tgl_close' type='text' name='laporan_ketidaksesuaian_tgl_close'  value="<?php echo set_value('laporan_ketidaksesuaian_tgl_close', isset($laporan_ketidaksesuaian['tgl_close']) ? $laporan_ketidaksesuaian['tgl_close'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tgl_close'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('laporan_ketidaksesuaian_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/reports/laporan_ketidaksesuaian', lang('laporan_ketidaksesuaian_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>