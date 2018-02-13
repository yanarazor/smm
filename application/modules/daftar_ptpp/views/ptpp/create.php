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

if (isset($daftar_ptpp))
{
	$daftar_ptpp = (array) $daftar_ptpp;
}
$id = isset($daftar_ptpp['id']) ? $daftar_ptpp['id'] : '';

?>
<div class="admin-box">
	 
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>
			<div class="control-group <?php echo form_error('kode_audit') ? 'error' : ''; ?>">
				<?php echo form_label('Audit Internat'. lang('bf_form_label_required'), 'kode_audit', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="kode_audit" id="kode_audit" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($audits) && is_array($audits) && count($audits)):?>
						<?php foreach($audits as $bidang):?>
							<option value="<?php echo $bidang->id?>" <?php if(isset($daftar_ptpp['kode_audit']))  echo  ($bidang->id==$daftar_ptpp['kode_audit']) ? "selected" : ""; ?>> <?php e(ucfirst($bidang->judul)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					
					<span class='help-inline'><?php echo form_error('daftar_ptpp_ditujukan_kepada'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('daftar_ptpp_ditujukan_kepada') ? 'error' : ''; ?>">
				<?php echo form_label('Ditujukan Kepada'. lang('bf_form_label_required'), 'daftar_ptpp_ditujukan_kepada', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="daftar_ptpp_ditujukan_kepada" id="daftar_ptpp_ditujukan_kepada" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($bidangs) && is_array($bidangs) && count($bidangs)):?>
						<?php foreach($bidangs as $bidang):?>
							<option value="<?php echo $bidang->id?>" <?php if(isset($daftar_ptpp['ditujukan_kepada']))  echo  ($bidang->id==$daftar_ptpp['ditujukan_kepada']) ? "selected" : ""; ?>> <?php e(ucfirst($bidang->bidang)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					 
					<!--
					<input id='bidang' type='text' name='bidang' maxlength="50" value="<?php echo set_value('bidang', isset($daftar_ptpp['d_bidang']) ? $daftar_ptpp['d_bidang'] : ''); ?>" />
					-->
					<span class='help-inline'><?php echo form_error('daftar_ptpp_ditujukan_kepada'); ?></span>
				</div>
			</div>
<!--
			<div class="control-group <?php echo form_error('daftar_ptpp_diajukan_oleh') ? 'error' : ''; ?>">
				<?php echo form_label('Diajukan Oleh'. lang('bf_form_label_required'), 'daftar_ptpp_diajukan_oleh', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="daftar_ptpp_diajukan_oleh" id="daftar_ptpp_diajukan_oleh" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($users) && is_array($users) && count($users)):?>
						<?php foreach($users as $user):?>
							<option value="<?php echo $user->id?>" <?php if(isset($daftar_ptpp['diajukan_oleh']))  echo  ($user->id==$daftar_ptpp['diajukan_oleh']) ? "selected" : ""; ?> <?php if(isset($user_active))  echo  ($user->id==$user_active) ? "selected" : ""; ?>> <?php e(ucfirst($user->display_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('daftar_ptpp_diajukan_oleh'); ?></span>
				</div>
			</div>
-->
			<div class="control-group <?php echo form_error('no_ptpp') ? 'error' : ''; ?>">
				<?php echo form_label('No PKTP', 'daftar_ptpp_no_ptpp', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='daftar_ptpp_no_ptpp' type='text' name='daftar_ptpp_no_ptpp' maxlength="50" value="<?php echo set_value('daftar_ptpp_no_ptpp', isset($daftar_ptpp['no_ptpp']) ? $daftar_ptpp['no_ptpp'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('no_ptpp'); ?></span>
				</div>
			</div>
<!--
			<div class="control-group <?php echo form_error('tgl_ptpp') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal', 'daftar_ptpp_tgl_ptpp', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='daftar_ptpp_tgl_ptpp' type='text' name='daftar_ptpp_tgl_ptpp' class="date" value="<?php echo set_value('daftar_ptpp_tgl_ptpp', isset($daftar_ptpp['tgl_ptpp']) ? $daftar_ptpp['tgl_ptpp'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tgl_ptpp'); ?></span>
				</div>
			</div>
-->
			<div class="control-group <?php echo form_error('referensi') ? 'error' : ''; ?>">
				<?php echo form_label('Referensi', 'daftar_ptpp_referensi', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='daftar_ptpp_referensi' type='text' name='daftar_ptpp_referensi' maxlength="100" value="<?php echo set_value('daftar_ptpp_referensi', isset($daftar_ptpp['referensi']) ? $daftar_ptpp['referensi'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('referensi'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('kategori') ? 'error' : ''; ?>">
				<?php echo form_label('Kategori', 'daftar_ptpp_kategori', array('class' => 'control-label') ); ?>
				<div class='controls'>
                	<select name="daftar_ptpp_kategori" id="daftar_ptpp_kategori" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($kategoris) && is_array($kategoris) && count($kategoris)):?>
						<?php foreach($kategoris as $record):?>
							<option value="<?php echo $record->id?>" <?php if(isset($daftar_ptpp['kategori']))  echo  ($record->id==$daftar_ptpp['kategori']) ? "selected" : ""; ?>> <?php e(ucfirst($record->kategori)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'>Hanya Untuk Audit Internal</span>
					<span class='help-inline'><?php echo form_error('kategori'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('deskripsi_ketidaksesuaian') ? 'error' : ''; ?>">
				<?php echo form_label('Deskripsi Ketidaksesuaian', 'daftar_ptpp_deskripsi_ketidaksesuaian', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'daftar_ptpp_deskripsi_ketidaksesuaian', 'id' => 'daftar_ptpp_deskripsi_ketidaksesuaian', 'rows' => '5','style'=>'width:600px', 'cols' => '80', 'value' => set_value('daftar_ptpp_deskripsi_ketidaksesuaian', isset($daftar_ptpp['deskripsi_ketidaksesuaian']) ? $daftar_ptpp['deskripsi_ketidaksesuaian'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('deskripsi_ketidaksesuaian'); ?></span>
				</div>
			</div>
<!--
			<div class="control-group <?php echo form_error('tanggal_pengusulan') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Pengusulan', 'daftar_ptpp_tanggal_pengusulan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='daftar_ptpp_tanggal_pengusulan' type='text' name='daftar_ptpp_tanggal_pengusulan'  value="<?php echo set_value('daftar_ptpp_tanggal_pengusulan', isset($daftar_ptpp['tanggal_pengusulan']) ? $daftar_ptpp['tanggal_pengusulan'] : date("Y-m-d")); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal_pengusulan'); ?></span>
				</div>
			</div>
			-->
			<?php if(isset($daftar_ptpp['tindakan_koreksi']) and trim($daftar_ptpp['tindakan_koreksi'] != "")) { ?>
				<div class="control-group <?php echo form_error('tanggal_tandatangan_auditi') ? 'error' : ''; ?>">
					<?php echo form_label('Tanggal Tanda Tangan Auditi', 'daftar_ptpp_tanggal_tandatangan_auditi', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<input id='daftar_ptpp_tanggal_tandatangan_auditi' type='text' name='daftar_ptpp_tanggal_tandatangan_auditi'  value="<?php echo set_value('daftar_ptpp_tanggal_tandatangan_auditi', isset($daftar_ptpp['tanggal_tandatangan_auditi']) ? $daftar_ptpp['tanggal_tandatangan_auditi'] : ''); ?>" />
						<span class='help-inline'><?php echo form_error('tanggal_tandatangan_auditi'); ?></span>
					</div>
				</div>

				<div class="control-group <?php echo form_error('hasil_investigasi') ? 'error' : ''; ?>">
					<?php echo form_label('Hasil Investigasi', 'daftar_ptpp_hasil_investigasi', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<?php echo form_textarea( array( 'name' => 'daftar_ptpp_hasil_investigasi', 'id' => 'daftar_ptpp_hasil_investigasi', 'rows' => '5','style'=>'width:600px', 'cols' => '80', 'value' => set_value('daftar_ptpp_hasil_investigasi', isset($daftar_ptpp['hasil_investigasi']) ? $daftar_ptpp['hasil_investigasi'] : '') ) ); ?>
						<span class='help-inline'><?php echo form_error('hasil_investigasi'); ?></span>
					</div>
				</div>

				<div class="control-group <?php echo form_error('tgl_tandatangan_hasil') ? 'error' : ''; ?>">
					<?php echo form_label('Tgl Tanda Tangan Hasil', 'daftar_ptpp_tgl_tandatangan_hasil', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<input id='daftar_ptpp_tgl_tandatangan_hasil' type='text' name='daftar_ptpp_tgl_tandatangan_hasil'  value="<?php echo set_value('daftar_ptpp_tgl_tandatangan_hasil', isset($daftar_ptpp['tgl_tandatangan_hasil']) ? $daftar_ptpp['tgl_tandatangan_hasil'] : ''); ?>" />
						<span class='help-inline'><?php echo form_error('tgl_tandatangan_hasil'); ?></span>
					</div>
				</div>

				<div class="control-group <?php echo form_error('tindakan_koreksi') ? 'error' : ''; ?>">
					<?php echo form_label('Tindakan Koreksi', 'daftar_ptpp_tindakan_koreksi', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<?php echo form_textarea( array( 'name' => 'daftar_ptpp_tindakan_koreksi', 'id' => 'daftar_ptpp_tindakan_koreksi','style'=>'width:600px', 'rows' => '5', 'cols' => '80', 'value' => set_value('daftar_ptpp_tindakan_koreksi', isset($daftar_ptpp['tindakan_koreksi']) ? $daftar_ptpp['tindakan_koreksi'] : '') ) ); ?>
						<span class='help-inline'><?php echo form_error('tindakan_koreksi'); ?></span>
					</div>
				</div>

				<div class="control-group <?php echo form_error('tindakan_korektif') ? 'error' : ''; ?>">
					<?php echo form_label('Tindakan Korektif', 'daftar_ptpp_tindakan_korektif', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<?php echo form_textarea( array( 'name' => 'daftar_ptpp_tindakan_korektif', 'id' => 'daftar_ptpp_tindakan_korektif','style'=>'width:600px', 'rows' => '5', 'cols' => '80', 'value' => set_value('daftar_ptpp_tindakan_korektif', isset($daftar_ptpp['tindakan_korektif']) ? $daftar_ptpp['tindakan_korektif'] : '') ) ); ?>
						<span class='help-inline'><?php echo form_error('tindakan_korektif'); ?></span>
					</div>
				</div>

				<div class="control-group <?php echo form_error('tgl_penyelesaian') ? 'error' : ''; ?>">
					<?php echo form_label('Tgl Penyelesaian', 'daftar_ptpp_tgl_penyelesaian', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<input id='daftar_ptpp_tgl_penyelesaian' type='text' name='daftar_ptpp_tgl_penyelesaian'  value="<?php echo set_value('daftar_ptpp_tgl_penyelesaian', isset($daftar_ptpp['tgl_penyelesaian']) ? $daftar_ptpp['tgl_penyelesaian'] : ''); ?>" />
						<span class='help-inline'><?php echo form_error('tgl_penyelesaian'); ?></span>
					</div>
				</div>

				<div class="control-group <?php echo form_error('disetujui_oleh') ? 'error' : ''; ?>">
					<?php echo form_label('Disetujui Oleh', 'daftar_ptpp_disetujui_oleh', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<input id='daftar_ptpp_disetujui_oleh' type='text' name='daftar_ptpp_disetujui_oleh' maxlength="50" value="<?php echo set_value('daftar_ptpp_disetujui_oleh', isset($daftar_ptpp['disetujui_oleh']) ? $daftar_ptpp['disetujui_oleh'] : ''); ?>" />
						<span class='help-inline'><?php echo form_error('disetujui_oleh'); ?></span>
					</div>
				</div>

				<div class="control-group <?php echo form_error('tanggal_disetujui') ? 'error' : ''; ?>">
					<?php echo form_label('Tgl Disetujui', 'daftar_ptpp_tanggal_disetujui', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<input id='daftar_ptpp_tanggal_disetujui' type='text' name='daftar_ptpp_tanggal_disetujui'  value="<?php echo set_value('daftar_ptpp_tanggal_disetujui', isset($daftar_ptpp['tanggal_disetujui']) ? $daftar_ptpp['tanggal_disetujui'] : ''); ?>" />
						<span class='help-inline'><?php echo form_error('tanggal_disetujui'); ?></span>
					</div>
				</div>

				<div class="control-group <?php echo form_error('tinjauan_tindakan_perbaikan') ? 'error' : ''; ?>">
					<?php echo form_label('Tinjauan Tindakan Perbaikan', 'daftar_ptpp_tinjauan_tindakan_perbaikan', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<?php echo form_textarea( array( 'name' => 'daftar_ptpp_tinjauan_tindakan_perbaikan', 'id' => 'daftar_ptpp_tinjauan_tindakan_perbaikan', 'rows' => '5','style'=>'width:600px', 'cols' => '80', 'value' => set_value('daftar_ptpp_tinjauan_tindakan_perbaikan', isset($daftar_ptpp['tinjauan_tindakan_perbaikan']) ? $daftar_ptpp['tinjauan_tindakan_perbaikan'] : '') ) ); ?>
						<span class='help-inline'><?php echo form_error('tinjauan_tindakan_perbaikan'); ?></span>
					</div>
				</div>
				<div class="control-group <?php echo form_error('daftar_ptpp_status') ? 'error' : ''; ?>">
					<?php echo form_label('Status', 'daftar_ptpp_status', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<select name="daftar_ptpp_status" id="daftar_ptpp_status" class="chosen-select-deselect">
							<option value="">-- Pilih  --</option>
							<?php if (isset($statuss) && is_array($statuss) && count($statuss)):?>
							<?php foreach($statuss as $status):?>
								<option value="<?php echo $status->id?>" <?php if(isset($daftar_ptpp['status']))  echo  ($status->id==$daftar_ptpp['status']) ? "selected" : ""; ?>> <?php e(ucfirst($status->status)); ?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
						<span class='help-inline'><?php echo form_error('daftar_ptpp_status'); ?></span>
					</div>
				</div>
				
				<div class="control-group <?php echo form_error('kesimpulan') ? 'error' : ''; ?>">
					<?php echo form_label('Kesimpulan', 'daftar_ptpp_kesimpulan', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<?php echo form_textarea( array( 'name' => 'daftar_ptpp_kesimpulan', 'id' => 'daftar_ptpp_kesimpulan', 'rows' => '5', 'cols' => '80','style'=>'width:600px', 'value' => set_value('daftar_ptpp_kesimpulan', isset($daftar_ptpp['kesimpulan']) ? $daftar_ptpp['kesimpulan'] : '') ) ); ?>
						<span class='help-inline'><?php echo form_error('kesimpulan'); ?></span>
					</div>
				</div>
			<?php } ?>
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="Simpan"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/ptpp/daftar_ptpp', lang('daftar_ptpp_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript">	  
$(document).ready(function() {	  
	 $('#daftar_ptpp_deskripsi_ketidaksesuaian').wysiwyg();
	 $('#daftar_ptpp_hasil_investigasi').wysiwyg();
	 $('#daftar_ptpp_tindakan_koreksi').wysiwyg();
	 $('#daftar_ptpp_tindakan_korektif').wysiwyg();
	 $('#daftar_ptpp_tinjauan_tindakan_perbaikan').wysiwyg();
	 $('#daftar_ptpp_kesimpulan').wysiwyg();
});  
function getbidang(kode){
 
	var kodeuser = kode; 
	var json_url = "<?php echo base_url() ?>index.php/admin/settings/users/getdatadetil/?id_user="+kodeuser;
 
	$.getJSON(json_url,function(data){
		$("#bidang").val(data.id_bidang);
	});
	
}
/*
	$("#daftar_ptpp_ditujukan_kepada").change(function(){
		 
			var post_data = "id="+$("#daftar_ptpp_ditujukan_kepada").val();
			$.ajax({
				url: "<?php echo base_url() ?>index.php/admin/audit/daftar_periksa_audit/delete_checklist_ajax?"+post_data,
				type:"get",
				data: post_data,
				dataType: "html",
				timeout:180000,
				success: function (result) {
					loadchecklist();
					 
			},
			error : function(error) {
				alert(error);
			} 
			});        
			return false;
			 
		});
 */
</script>