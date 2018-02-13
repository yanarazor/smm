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
	 
	<?php echo form_open_multipart($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset> 
			
			<div class="control-group <?php echo form_error('kode_dokumen') ? 'error' : ''; ?>">
				<?php echo form_label('Dokumen'. lang('bf_form_label_required'), 'usulan_perubahan_dokumen_kode_dokumen', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="usulan_perubahan_dokumen_kode_dokumen" id="usulan_perubahan_dokumen_kode_dokumen" class="chosen-select-deselect" style="width:400px" onchange="getinfo(this.value)">
						<option value="">-- Pilih  --</option>
						<?php if (isset($indukdokumens) && is_array($indukdokumens) && count($indukdokumens)):?>
						<?php foreach($indukdokumens as $indukdokumen):?>
							<option value="<?php echo $indukdokumen->id?>" <?php if(isset($usulan_perubahan_dokumen['kode_dokumen']))  echo  ($indukdokumen->id==$usulan_perubahan_dokumen['kode_dokumen']) ? "selected" : ""; ?>> <?php e(ucfirst($indukdokumen->judul)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<input id='usulan_perubahan_dokumen_judul' type='hidden' name='usulan_perubahan_dokumen_judul' readonly maxlength="255" value="<?php echo set_value('usulan_perubahan_dokumen_judul', isset($usulan_perubahan_dokumen['judul']) ? $usulan_perubahan_dokumen['judul'] : ''); ?>" />
					
					<span class='help-inline'><?php echo form_error('kode_dokumen'); ?></span>
				</div>
			</div>

			 
			<div class="control-group <?php echo form_error('nomor') ? 'error' : ''; ?>">
				<?php echo form_label('Nomor', 'usulan_perubahan_dokumen_nomor', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='usulan_perubahan_dokumen_nomor' type='text' name='usulan_perubahan_dokumen_nomor' readonly maxlength="50" value="<?php echo set_value('usulan_perubahan_dokumen_nomor', isset($usulan_perubahan_dokumen['nomor']) ? $usulan_perubahan_dokumen['nomor'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('nomor'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('revisi') ? 'error' : ''; ?>">
				<?php echo form_label('Revisi', 'usulan_perubahan_dokumen_revisi', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='usulan_perubahan_dokumen_revisi' type='text' name='usulan_perubahan_dokumen_revisi' readonly maxlength="10" value="<?php echo set_value('usulan_perubahan_dokumen_revisi', isset($usulan_perubahan_dokumen['revisi']) ? $usulan_perubahan_dokumen['revisi'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('revisi'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('bagian_diubah') ? 'error' : ''; ?>">
				<?php echo form_label('Bagian Yang Diubah', 'usulan_perubahan_dokumen_bagian_diubah', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'usulan_perubahan_dokumen_bagian_diubah', 'id' => 'usulan_perubahan_dokumen_bagian_diubah','style'=>'width:600px', 'rows' => '5', 'cols' => '80', 'value' => set_value('usulan_perubahan_dokumen_bagian_diubah', isset($usulan_perubahan_dokumen['bagian_diubah']) ? $usulan_perubahan_dokumen['bagian_diubah'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('bagian_diubah'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('manfaat_perubahan') ? 'error' : ''; ?>">
				<?php echo form_label('Manfaat Perubahan', 'usulan_perubahan_dokumen_manfaat_perubahan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'usulan_perubahan_dokumen_manfaat_perubahan', 'id' => 'usulan_perubahan_dokumen_manfaat_perubahan','style'=>'width:600px', 'rows' => '5', 'cols' => '80', 'value' => set_value('usulan_perubahan_dokumen_manfaat_perubahan', isset($usulan_perubahan_dokumen['manfaat_perubahan']) ? $usulan_perubahan_dokumen['manfaat_perubahan'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('manfaat_perubahan'); ?></span>
				</div>
			</div>
            <div class="control-group <?php echo form_error('usulan_perubahan_dokumen_filename') ? 'error' : ''; ?>">
					<?php echo form_label('File', 'usulan_perubahan_dokumen_filename', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<div id="foto">
							<?php 
							$namafile = "";
							 
							if(isset($usulan_perubahan_dokumen) && isset($usulan_perubahan_dokumen['filename'])  && !empty($usulan_perubahan_dokumen['filename'])) :
									 $file = unserialize($usulan_perubahan_dokumen['filename']);
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
						<span class='help-inline'><?php echo form_error('usulan_perubahan_dokumen_filename'); ?></span>
					</div>
				</div>   
			<?php if(isset($usulan_perubahan_dokumen['status_periksa']) and $usulan_perubahan_dokumen['status_periksa']!= "") 
			{ ?>
				<div class="control-group <?php echo form_error('catatan_pemeriksa') ? 'error' : ''; ?>">
					<?php echo form_label('Catatan Pemeriksa', 'usulan_perubahan_dokumen_catatan_pemeriksa', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<?php echo form_textarea( array( 'name' => 'usulan_perubahan_dokumen_catatan_pemeriksa', 'id' => 'usulan_perubahan_dokumen_catatan_pemeriksa','style'=>'width:600px', 'rows' => '5', 'cols' => '80', 'value' => set_value('usulan_perubahan_dokumen_catatan_pemeriksa', isset($usulan_perubahan_dokumen['catatan_pemeriksa']) ? $usulan_perubahan_dokumen['catatan_pemeriksa'] : '') ) ); ?>
						<span class='help-inline'><?php echo form_error('catatan_pemeriksa'); ?></span>
					</div>
				</div>
				
			<?php } ?>
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('usulan_perubahan_dokumen_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/dokumen/usulan_perubahan_dokumen', lang('usulan_perubahan_dokumen_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>
<link href="<?php echo base_url(); ?>assets/css/chosen/chosen.css" rel="stylesheet" type="text/css" />
<script language='JavaScript' type='text/javascript' src='<?php echo base_url(); ?>assets/js/chosen/chosen.jquery.js'></script>
<script type="text/javascript">	  

function getinfo(kode){
	var data_pengujian_id_pengujian = kode; 
	var json_url = "<?php echo base_url() ?>index.php/admin/dokumen/daftar_induk_dokumen/getinfo/?id_dokumen="+data_pengujian_id_pengujian;
	$.getJSON(json_url,function(data){
	 
		$("#usulan_perubahan_dokumen_judul").val(data.judul);
		$("#usulan_perubahan_dokumen_revisi").val(data.revisi);
		$("#usulan_perubahan_dokumen_nomor").val(data.nomor); 
		$("#pengajuawal").val(data.pembuat); 
	});
	
} 
var config = {
	'.chosen-select'           : {},
	'.chosen-select-deselect'  : {allow_single_deselect:true},
	'.chosen-select-no-single' : {disable_search_threshold:10},
	'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
	'.chosen-select-width'     : {width:"95%"}
}
for (var selector in config) {
	$(selector).chosen(config[selector]);
}
for (var selector in config) {
  $(selector).chosen(config[selector]);
}
$(document).ready(function() {	  
	 $('#usulan_perubahan_dokumen_catatan_pemeriksa').wysiwyg();
	 $('#usulan_perubahan_dokumen_manfaat_perubahan').wysiwyg();
	 $('#usulan_perubahan_dokumen_bagian_diubah').wysiwyg();
});

</script>
 