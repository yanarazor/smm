<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery.timepicker.css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.timepicker.js"></script>

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

if (isset($sppd))
{
	$sppd = (array) $sppd;
}
$id = isset($sppd['id']) ? $sppd['id'] : '';

?>
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('sppd_pejabat') ? 'error' : ''; ?>">
				<?php echo form_label('Pejabat Berwenang Memberi Perintah'. lang('bf_form_label_required'), 'sppd_pejabat', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="sppd_pejabat" id="sppd_pejabat" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($ppps) && is_array($ppps) && count($ppps)):?>
						<?php foreach($ppps as $rec):?>
							<option value="<?php echo $rec->id?>" <?php if(isset($sppd['jenis_dokumen']))  echo  ($rec->id==$sppd['jenis_dokumen']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->nama)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('sppd_pejabat'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('sppd_pegawai') ? 'error' : ''; ?>">
				<?php echo form_label('Pegawai'. lang('bf_form_label_required'), 'sppd_pegawai', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="sppd_pegawai" id="sppd_pegawai" class="chosen-select-deselect" onchange="getinfo(this.value)">
						<option value="">-- Pilih  --</option>
						<?php if (isset($users) && is_array($users) && count($users)):?>
						<?php foreach($users as $rec):?>
							<option value="<?php echo $rec->id?>" <?php if(isset($sppd['pegawai']))  echo  ($rec->id==$sppd['pegawai']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->display_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('sppd_pegawai'); ?></span>
				</div>
			</div>
			<div id="infopangkat">
				
			</div>
			<div class="control-group <?php echo form_error('maksud') ? 'error' : ''; ?>">
				<?php echo form_label('Maksud Perjalanan Dinas', 'sppd_maksud', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='sppd_maksud' type='text' name='sppd_maksud' maxlength="255" value="<?php echo set_value('sppd_maksud', isset($sppd['maksud']) ? $sppd['maksud'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('maksud'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('angkutan') ? 'error' : ''; ?>">
				<?php echo form_label('Anggaran', 'sppd_anggaran', array('class' => 'control-label') ); ?>
				<div class='controls' aria-labelled-by='surat_izin_status_atasan_label'>
					<label class='radio' for='sppd_anggaran_option1'>
						<input id='sppd_anggaran_option1' name='sppd_anggaran' onclick="changeanggaran(this);"  type='radio' class='' value='Tematik' <?php if(isset($sppd['anggaran']) and $sppd['anggaran']=="Tematik") echo "checked"; ?> />
						Tematik
					</label>
					<br>
					<label class='radio' for='sppd_anggaran_option2'>
						<input id='sppd_anggaran_option2' name='sppd_anggaran' onclick="changeanggaran(this);"  type='radio' class='' value='PNBP' <?php if(isset($sppd['anggaran']) and $sppd['anggaran']=="PNBP") echo "checked"; ?> />
						PNBP
					</label>
					<br>
					<label class='radio' for='sppd_anggaran_option3'>
						<input id='sppd_anggaran_option3' name='sppd_anggaran' onclick="changeanggaran(this);"  type='radio' class='' value='Rutin' <?php if(isset($sppd['anggaran']) and $sppd['anggaran']=="Rutin") echo "checked"; ?> />
						Rutin
					</label>
					<br>
					<label class='radio' for='sppd_anggaran_option4'>
						<input id='sppd_anggaran_option4' name='sppd_anggaran' onclick="changeanggaran(this);"  type='radio' class='' value='Instansi Lain' <?php if(isset($sppd['anggaran']) and $sppd['anggaran']=="Instansi Lain") echo "checked"; ?> />
						Instansi Lain
					</label>
					<span class='help-inline'><?php echo form_error('angkutan'); ?></span>
				</div>
			</div>
			 <div class="control-group <?php echo form_error('sppd_no_keg') ? 'error' : ''; ?>">
				<?php echo form_label('Kegiatan'. lang('bf_form_label_required'), 'sppd_pejabat', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="sppd_no_keg" id="idsppd_no_keg" class="validate[required] text-input" style="width:700px">
						<option value="">-- Pilih  --</option>
						<?php if (isset($kegiatans) && is_array($kegiatans) && count($kegiatans)):?>
						<?php foreach($kegiatans as $rec):?>
							<option value="<?php echo $rec->kode?>" <?php if(isset($sppd['no_keg']))  echo  ($rec->kode==$sppd['no_keg']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->judul)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('sppd_no_keg'); ?></span>
				</div>
			</div>
			<!--
			<div class="control-group <?php echo form_error('no_keg') ? 'error' : ''; ?>">
				<?php echo form_label('No Kegiatan', 'sppd_no_keg', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='sppd_no_keg' type='text' name='sppd_no_keg' maxlength="10" value="<?php echo set_value('sppd_no_keg', isset($sppd['no_keg']) ? $sppd['no_keg'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('no_keg'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('judul') ? 'error' : ''; ?>">
				<?php echo form_label('Judul Kegiatan', 'sppd_judul', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='sppd_judul' type='text' name='sppd_judul' maxlength="255" value="<?php echo set_value('sppd_judul', isset($sppd['judul']) ? $sppd['judul'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('judul'); ?></span>
				</div>
			</div>
			 -->
			<div class="control-group <?php echo form_error('angkutan') ? 'error' : ''; ?>">
				<?php echo form_label('Alat Angkutan yang dipergunakan', 'sppd_angkutan', array('class' => 'control-label') ); ?>
				<div class='controls' aria-labelled-by='surat_izin_status_atasan_label'>
					<label class='radio' for='sppd_angkutan_option1'>
						<input id='sppd_angkutan_option1' name='sppd_angkutan' type='radio' class='' value='Dinas' <?php if(isset($sppd['angkutan']) and $sppd['angkutan']=="Dinas") echo "checked"; ?> />
						Dinas
					</label>
					<br>
					<label class='radio' for='sppd_angkutan_option2'>
						<input id='sppd_angkutan_option2' name='sppd_angkutan' type='radio' class='' value='Umum' <?php if(isset($sppd['angkutan']) and $sppd['angkutan']=="Umum") echo "checked"; ?> />
						Umum
					</label>
					<span class='help-inline'><?php echo form_error('angkutan'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('tempat_berangkat') ? 'error' : ''; ?>">
				<?php echo form_label('Tempat Berangkat', 'sppd_tempat_berangkat', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='sppd_tempat_berangkat' placeholder="Rumah/kantor" type='text' name='sppd_tempat_berangkat' maxlength="50" value="<?php echo set_value('sppd_tempat_berangkat', isset($sppd['tempat_berangkat']) ? $sppd['tempat_berangkat'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tempat_berangkat'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('instansi_tujuan') ? 'error' : ''; ?>">
				<?php echo form_label('Instansi Tujuan', 'sppd_instansi_tujuan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='sppd_instansi_tujuan' type='text' name='sppd_instansi_tujuan' maxlength="255" value="<?php echo set_value('sppd_instansi_tujuan', isset($sppd['instansi_tujuan']) ? $sppd['instansi_tujuan'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('instansi_tujuan'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('provinsi') ? 'error' : ''; ?>">
				<?php echo form_label('Provinsi'. lang('bf_form_label_required'), 'sppd_pejabat', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="provinsi" id="provinsi" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($propinsis) && is_array($propinsis) && count($propinsis)):?>
						<?php foreach($propinsis as $rec):?>
							<option value="<?php echo $rec->id?>" <?php if(isset($sppd['provinsi']))  echo  ($rec->id==$sppd['provinsi']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->prov)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('provinsi'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('tanggal_berangkat') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Berangkat', 'sppd_tanggal_berangkat', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='sppd_tanggal_berangkat'  type='text' name='sppd_tanggal_berangkat'  value="<?php echo set_value('sppd_tanggal_berangkat', isset($sppd['tanggal_berangkat']) ? $sppd['tanggal_berangkat'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal_berangkat'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('tanggal_kembali') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Kembali', 'tanggal_kembali', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='tanggal_kembali'  type='text' name='tanggal_kembali'  value="<?php echo set_value('tanggal_kembali', isset($sppd['tanggal_kembali']) ? $sppd['tanggal_kembali'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal_kembali'); ?></span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="title">Selama</label>
				<div class="input-prepend input-append">
					<input type="text" class="numericOnly" name='lama' id="lama" class="span4" value="<?php echo set_value('lama', isset($sppd['lama']) ? $sppd['lama'] : ''); ?>" />
					<span class="add-on">Hari</span>
					
				</div>
			</div>

			<div class="control-group <?php echo form_error('jam_berangkat') ? 'error' : ''; ?>">
				<?php echo form_label('Jam Berangkat', 'sppd_jam_berangkat', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='sppd_jam_berangkat' placeholder="hh:mm" class="timeformat" type='text' name='sppd_jam_berangkat'  value="<?php echo set_value('sppd_jam_berangkat', isset($sppd['jam_berangkat']) ? $sppd['jam_berangkat'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('jam_berangkat'); ?></span>
				</div>
			</div>
			<!--
			<div class="control-group <?php echo form_error('pengemudi') ? 'error' : ''; ?>">
				<?php echo form_label('Nama Pengemudi/Nomor Kendaraan', 'sppd_pengemudi', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='sppd_pengemudi' type='text' name='sppd_pengemudi' maxlength="20" value="<?php echo set_value('sppd_pengemudi', isset($sppd['pengemudi']) ? $sppd['pengemudi'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('pengemudi'); ?></span>
				</div>
			</div>
			 -->
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="Simpan"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/kepegawaian/sppd', lang('sppd_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>
<link href="<?php echo base_url(); ?>assets/css/chosen/chosen.css" rel="stylesheet" type="text/css" />
<script language='JavaScript' type='text/javascript' src='<?php echo base_url(); ?>assets/js/chosen/chosen.jquery.js'></script>
<script type="text/javascript">
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
  </script>
<script type="text/javascript">	  
	function changeanggaran(anggaran) {
		
		var currentValue = anggaran.value;
		 
		$("#idsppd_no_keg").empty().append("<option>loading...</option>");
		 var json_url = "<?php echo base_url(); ?>admin/masters/kegiatan/getkegiatan?kegiatan=" + encodeURIComponent(currentValue);
		 $.getJSON(json_url,function(data){
			 $("#idsppd_no_keg").empty(); 
			 if(data==""){
				 $("#idsppd_no_keg").append("<option value=\"\">-- Pilih --</option>");
			 }
			 else{
			 	
				 $("#idsppd_no_keg").append("<option value=\"\">-- Pilih --</option>");
				 for(i=0; i<data.id.length; i++){
					 $("#idsppd_no_keg").append("<option value=\"" + data.id[i]  + "\">" + data.judul[i] +"</option>");
				 }
			 }
		 
		 });
		 return false;
	}
	function getinfo(kode){
		var id_pegawai = kode; 
		var json_url = "<?php echo base_url() ?>index.php/admin/settings/users/getinfouser/?id_pegawai="+id_pegawai;
		var post_data = "id_pegawai="+id_pegawai;
		$.ajax({
			url: json_url,
			type:"get",
			data: post_data,
			dataType: "html",
			timeout:180000,
			success: function (result) {
				$('#infopangkat').html(result);
			},
			error : function(error) {
				alert(error);
			} 
		});        
	} 
	
</script>
<script type="text/javascript">	  
$('.timeformat').timepicker({ 'timeFormat': 'H:i:s' });
</script>