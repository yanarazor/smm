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

if (isset($sppd_jabodetabek))
{
	$sppd_jabodetabek = (array) $sppd_jabodetabek;
}
$id = isset($sppd_jabodetabek['id']) ? $sppd_jabodetabek['id'] : '';

?>
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('sppd_jabodetabek_pejabat') ? 'error' : ''; ?>">
				<?php echo form_label('Pejabat Berwenang Memberi Perintah'. lang('bf_form_label_required'), 'sppd_jabodetabek_pejabat', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="sppd_jabodetabek_pejabat" id="sppd_jabodetabek_pejabat" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($ppps) && is_array($ppps) && count($ppps)):?>
						<?php foreach($ppps as $rec):?>
							<option value="<?php echo $rec->id?>" <?php if(isset($sppd_jabodetabek['pejabat']))  echo  ($rec->id==$sppd_jabodetabek['pejabat']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->nama)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('sppd_jabodetabek_pejabat'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('sppd_jabodetabek_pegawai') ? 'error' : ''; ?>">
				<?php echo form_label('Pegawai'. lang('bf_form_label_required'), 'sppd_jabodetabek_pegawai', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="sppd_jabodetabek_pegawai" id="sppd_jabodetabek_pegawai" class="chosen-select-deselect" onchange="getinfo(this.value)">
						<option value="">-- Pilih  --</option>
						<?php if (isset($pegawais) && is_array($pegawais) && count($pegawais)):?>
						<?php foreach($pegawais as $rec):?>
							<option value="<?php echo $rec->nip?>" <?php if(isset($sppd_jabodetabek['pegawai']))  echo  ($rec->nip == $sppd_jabodetabek['pegawai']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->nama)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('sppd_jabodetabek_pegawai'); ?></span>
				</div>
			</div>
			<div id="infopangkat">
				 
				  <div class="control-group <?php echo form_error('pangkat') ? 'error' : ''; ?>">
					  <?php echo form_label('Pangkat', 'nip', array('class' => 'control-label') ); ?>
					  <div class='controls'>
						  <?php echo $sppd_jabodetabek['sppd_pangkat']; ?>
						  <input type="hidden" name="pangkat" value="<?php echo $sppd_jabodetabek['sppd_pangkat']; ?>">
						  <span class='help-inline'><?php echo form_error('pangkat'); ?></span>
					  </div>
				  </div>
				  <div class="control-group <?php echo form_error('golongan') ? 'error' : ''; ?>">
					  <?php echo form_label('Golongan', 'nip', array('class' => 'control-label') ); ?>
					  <div class='controls'>
						  <?php echo $sppd_jabodetabek['sppd_golongan']; ?>
						  <input type="hidden" name="golongan" value="<?php echo $sppd_jabodetabek['sppd_golongan']; ?>">
						  <span class='help-inline'><?php echo form_error('golongan'); ?></span>
					  </div>
				  </div>
				  <div class="control-group <?php echo form_error('jabatan') ? 'error' : ''; ?>">
					  <?php echo form_label('Jabatan', 'jabatan', array('class' => 'control-label') ); ?>
					  <div class='controls'>
						  <?php echo $sppd_jabodetabek['sppd_jabatan']; ?>
						  <input type="hidden" name="jabatan" value="<?php echo $sppd_jabodetabek['sppd_jabatan']; ?>">
						  <span class='help-inline'><?php echo form_error('jabatan'); ?></span>
					  </div>
				  </div>
	 
			</div>
			<div class="control-group <?php echo form_error('maksud') ? 'error' : ''; ?>">
				<?php echo form_label('Maksud Perjalanan Dinas', 'sppd_jabodetabek_maksud', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='sppd_jabodetabek_maksud' type='text' name='sppd_jabodetabek_maksud' maxlength="255" value="<?php echo set_value('sppd_jabodetabek_maksud', isset($sppd_jabodetabek['maksud']) ? $sppd_jabodetabek['maksud'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('maksud'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('angkutan') ? 'error' : ''; ?>">
				<?php echo form_label('Anggaran', 'sppd_jabodetabek_anggaran', array('class' => 'control-label') ); ?>
				<div class='controls' aria-labelled-by='surat_izin_status_atasan_label'>
					<label class='radio' for='sppd_jabodetabek_anggaran_option1'>
						<input id='sppd_jabodetabek_anggaran_option1' name='sppd_jabodetabek_anggaran' type='radio' class='' value='Tematik' <?php if(isset($sppd_jabodetabek['anggaran']) and $sppd_jabodetabek['anggaran']=="Tematik") echo "checked"; ?> />
						Tematik
						
					</label>
					<br>
					<label class='radio' for='sppd_jabodetabek_anggaran_option2'>
						<input id='sppd_jabodetabek_anggaran_option2' name='sppd_jabodetabek_anggaran' type='radio' class='' value='PNBP' <?php if(isset($sppd_jabodetabek['anggaran']) and $sppd_jabodetabek['anggaran']=="PNBP") echo "checked"; ?> />
						PNBP
					</label>
					<br>
					<label class='radio' for='sppd_jabodetabek_anggaran_option3'>
						<input id='sppd_jabodetabek_anggaran_option3' name='sppd_jabodetabek_anggaran' type='radio' class='' value='Rutin' <?php if(isset($sppd_jabodetabek['anggaran']) and $sppd_jabodetabek['anggaran']=="Rutin") echo "checked"; ?> />
						Rutin
					</label>
					<br>
					<label class='radio' for='sppd_jabodetabek_anggaran_option4'>
						<input id='sppd_jabodetabek_anggaran_option4' name='sppd_jabodetabek_anggaran' type='radio' class='' value='Instansi Lain' <?php if(isset($sppd_jabodetabek['anggaran']) and $sppd_jabodetabek['anggaran']=="Instansi Lain") echo "checked"; ?> />
						Instansi Lain
					</label>
					<span class='help-inline'><?php echo form_error('angkutan'); ?></span>
				</div>
			</div>
			 
			<div class="control-group <?php echo form_error('sppd_jabodetabek_no_keg') ? 'error' : ''; ?>">
				<?php echo form_label('Kegiatan'. lang('bf_form_label_required'), 'sppd_jabodetabek_pejabat', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="sppd_jabodetabek_no_keg" id="sppd_jabodetabek_no_keg" class="chosen-select-deselect" style="width:700px">
						<option value="">-- Pilih  --</option>
						<?php if (isset($kegiatans) && is_array($kegiatans) && count($kegiatans)):?>
						<?php foreach($kegiatans as $rec):?>
							<option value="<?php echo $rec->kode?>" <?php if(isset($sppd_jabodetabek['no_keg']))  echo  ($rec->kode==$sppd_jabodetabek['no_keg']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->judul)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('sppd_jabodetabek_no_keg'); ?></span>
				</div>
			</div>
			 
			
			<!--
			<div class="control-group <?php echo form_error('judul') ? 'error' : ''; ?>">
				<?php echo form_label('Judul Kegiatan', 'sppd_jabodetabek_judul', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='sppd_jabodetabek_judul' type='text' name='sppd_jabodetabek_judul' maxlength="255" value="<?php echo set_value('sppd_jabodetabek_judul', isset($sppd_jabodetabek['judul']) ? $sppd_jabodetabek['judul'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('judul'); ?></span>
				</div>
			</div>
			 -->
			<div class="control-group <?php echo form_error('angkutan') ? 'error' : ''; ?>">
				<?php echo form_label('Alat Angkutan yang dipergunakan', 'sppd_jabodetabek_angkutan', array('class' => 'control-label') ); ?>
				<div class='controls' aria-labelled-by='surat_izin_status_atasan_label'>
					<label class='radio' for='sppd_jabodetabek_angkutan_option1'>
						<input id='sppd_jabodetabek_angkutan_option1' name='sppd_jabodetabek_angkutan' type='radio' class='' value='Dinas' <?php if(isset($sppd_jabodetabek['angkutan']) and $sppd_jabodetabek['angkutan']=="Dinas") echo "checked"; ?> />
						Dinas
					</label>
					<br>
					<label class='radio' for='sppd_jabodetabek_angkutan_option2'>
						<input id='sppd_jabodetabek_angkutan_option2' name='sppd_jabodetabek_angkutan' type='radio' class='' value='Umum' <?php if(isset($sppd_jabodetabek['angkutan']) and $sppd_jabodetabek['angkutan']=="Umum") echo "checked"; ?> />
						Umum
					</label>
					<span class='help-inline'><?php echo form_error('angkutan'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('tempat_berangkat') ? 'error' : ''; ?>">
				<?php echo form_label('Tempat Berangkat', 'sppd_jabodetabek_tempat_berangkat', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='sppd_jabodetabek_tempat_berangkat' placeholder="Rumah/kantor" type='text' name='sppd_jabodetabek_tempat_berangkat' maxlength="50" value="<?php echo set_value('sppd_jabodetabek_tempat_berangkat', isset($sppd_jabodetabek['tempat_berangkat']) ? $sppd_jabodetabek['tempat_berangkat'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tempat_berangkat'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('instansi_tujuan') ? 'error' : ''; ?>">
				<?php echo form_label('Instansi Tujuan', 'sppd_jabodetabek_instansi_tujuan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='sppd_jabodetabek_instansi_tujuan' type='text' name='sppd_jabodetabek_instansi_tujuan' maxlength="255" value="<?php echo set_value('sppd_jabodetabek_instansi_tujuan', isset($sppd_jabodetabek['instansi_tujuan']) ? $sppd_jabodetabek['instansi_tujuan'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('instansi_tujuan'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('tanggal_berangkat') ? 'error' : ''; ?> col-sm-6">
				<?php echo form_label('Dari/sampai Tanggal', 'sppd_jabodetabek_tanggal_berangkat', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='sppd_jabodetabek_tanggal_berangkat'  type='text' name='sppd_jabodetabek_tanggal_berangkat'  value="<?php echo set_value('sppd_jabodetabek_tanggal_berangkat', isset($sppd_jabodetabek['tanggal_berangkat']) ? $sppd_jabodetabek['tanggal_berangkat'] : ''); ?>" class="datepicker" />
					s.d.
					<input id='sampai_tanggal'  type='text' name='sampai_tanggal'  value="<?php echo set_value('sampai_tanggal', isset($sppd_jabodetabek['sampai_tanggal']) ? $sppd_jabodetabek['sampai_tanggal'] : ''); ?>" class="datepicker" />
					<span class='help-inline'><?php echo form_error('tanggal_berangkat'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('jam_berangkat') ? 'error' : ''; ?>">
				<?php echo form_label('Jam Berangkat', 'sppd_jabodetabek_jam_berangkat', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='sppd_jabodetabek_jam_berangkat' class="timeformat" placeholder="hh:mm" type='text' name='sppd_jabodetabek_jam_berangkat'  value="<?php echo set_value('sppd_jabodetabek_jam_berangkat', isset($sppd_jabodetabek['jam_berangkat']) ? $sppd_jabodetabek['jam_berangkat'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('jam_berangkat'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('pengemudi') ? 'error' : ''; ?>">
				<?php echo form_label('Nama Pengemudi/Nomor Kendaraan', 'sppd_jabodetabek_pengemudi', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='sppd_jabodetabek_pengemudi' type='text' name='sppd_jabodetabek_pengemudi' maxlength="20" value="<?php echo set_value('sppd_jabodetabek_pengemudi', isset($sppd_jabodetabek['pengemudi']) ? $sppd_jabodetabek['pengemudi'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('pengemudi'); ?></span>
				</div>
			</div>
			<div class="control-group divpengikut">
		   <?php 
				
			   echo $this->load->view('kepegawaian/dinamicedit',array('data_pengikut'=>$data_pengikut,"kode"=>'1'));
			?> 
			</div>
			 
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="Edit"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/kepegawaian/sppd_jabodetabek', lang('sppd_jabodetabek_cancel'), 'class="btn btn-warning"'); ?>
				
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
 

	function getinfo(kode){
		var id_pegawai = kode; 
		//alert( "<?php echo base_url() ?>admin/masters/pegawai/getinfo/?id_pegawai="+id_pegawai);
		var json_url = "<?php echo base_url() ?>admin/masters/pegawai/getinfo/?id_pegawai="+id_pegawai;
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
$(document).ready(function() {	  
 
  $( ".btnaddpengikut" ).click(function() {
	   
		  var json_url = "<?php echo base_url() ?>index.php/admin/kepegawaian/sppd_jabodetabek/getpeserta/";
		  
		  $.ajax({    type: "POST",
		  url:json_url,
		  data: "",
		  success: function(data){
			   
			  $('.divpengikut').append(data);
		  }});
		  
			  
  });
 });
</script>
<script type="text/javascript">	  
$('.timeformat').timepicker({ 'timeFormat': 'H:i:s' });
</script>