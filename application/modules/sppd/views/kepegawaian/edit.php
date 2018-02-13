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
							<option value="<?php echo $rec->id?>" <?php if(isset($sppd['pejabat']))  echo  ($rec->id==$sppd['pejabat']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->nama)); ?></option>
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
				 
				  <div class="control-group <?php echo form_error('pangkat') ? 'error' : ''; ?>">
					  <?php echo form_label('Pangkat', 'nip', array('class' => 'control-label') ); ?>
					  <div class='controls'>
						  <?php echo $datadetil['pangkat']; ?>
						  <span class='help-inline'><?php echo form_error('pangkat'); ?></span>
					  </div>
				  </div>
				  <div class="control-group <?php echo form_error('golongan') ? 'error' : ''; ?>">
					  <?php echo form_label('Golongan', 'nip', array('class' => 'control-label') ); ?>
					  <div class='controls'>
						  <?php echo $datadetil['golongan']; ?>
						  <span class='help-inline'><?php echo form_error('golongan'); ?></span>
					  </div>
				  </div>
				  <div class="control-group <?php echo form_error('jabatan') ? 'error' : ''; ?>">
					  <?php echo form_label('Jabatan', 'jabatan', array('class' => 'control-label') ); ?>
					  <div class='controls'>
						  <?php echo $datadetil['jabatan']; ?>
						  <span class='help-inline'><?php echo form_error('jabatan'); ?></span>
					  </div>
				  </div>
	 
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
						<input id='sppd_anggaran_option1' name='sppd_anggaran' type='radio' onclick="changeanggaran(this);" class='' value='Tematik' <?php if(isset($sppd['anggaran']) and $sppd['anggaran']=="Tematik") echo "checked"; ?> />
						Tematik
						
					</label>
					<br>
					<label class='radio' for='sppd_anggaran_option2'>
						<input id='sppd_anggaran_option2' name='sppd_anggaran' type='radio' onclick="changeanggaran(this);" class='' value='PNBP' <?php if(isset($sppd['anggaran']) and $sppd['anggaran']=="PNBP") echo "checked"; ?> />
						PNBP
					</label>
					<br>
					<label class='radio' for='sppd_anggaran_option3'>
						<input id='sppd_anggaran_option3' name='sppd_anggaran' type='radio' onclick="changeanggaran(this);" class='' value='Rutin' <?php if(isset($sppd['anggaran']) and $sppd['anggaran']=="Rutin") echo "checked"; ?> />
						Rutin
					</label>
					<br>
					<label class='radio' for='sppd_anggaran_option4'>
						<input id='sppd_anggaran_option4' name='sppd_anggaran' type='radio' onclick="changeanggaran(this);" class='' value='Instansi Lain' <?php if(isset($sppd['anggaran']) and $sppd['anggaran']=="Instansi Lain") echo "checked"; ?> />
						Instansi Lain
					</label>
					<span class='help-inline'><?php echo form_error('angkutan'); ?></span>
				</div>
			</div>
			 
			<div class="control-group <?php echo form_error('sppd_no_keg') ? 'error' : ''; ?>">
				<?php echo form_label('Kegiatan'. lang('bf_form_label_required'), 'sppd_pejabat', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="sppd_no_keg" id="idsppd_no_keg" style="width:700px">
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
					<span class='help-inline'><?php echo form_error('sppd_pejabat'); ?></span>
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
				<div class="input-prepend input-append">
					<input id='sppd_jam_berangkat' placeholder="hh:mm" class="timeformat" type='text' name='sppd_jam_berangkat'  value="<?php echo set_value('sppd_jam_berangkat', isset($sppd['jam_berangkat']) ? $sppd['jam_berangkat'] : ''); ?>" />
					<span class="add-on">hh:ii:ss</span>
				</div>
			</div>
			<table>
				<tr>
					<td width="50%">
						<fieldset>
						<legend>II</legend
						   <div class="control-group">
							   <label class="control-label" for="title">Tiba di</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='tibadi_II' id="tibadi_II" value="<?php echo set_value('tibadi_II', $sppd['tibadi_II'] != "0" ? $sppd['tibadi_II'] : ''); ?>" />
							   </div>
						   </div>
						   <div class="control-group">
							   <label class="control-label" for="title">Pada tanggal</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='tiba_tanggal_II' id="tiba_tanggal_II" value="<?php echo set_value('tiba_tanggal_II', $sppd['tiba_tanggal_II'] != "0000-00-00" ? $sppd['tiba_tanggal_II'] : ''); ?>" />
							   </div>
						   </div>
						    <div class="control-group">
							   <label class="control-label" for="title">Kepala</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='tiba_kepala_II' id="tiba_kepala_II" value="<?php echo set_value('tiba_kepala_II', $sppd['tiba_kepala_II'] != "0" ? $sppd['tiba_kepala_II'] : ''); ?>" />
							   </div>
						   </div>
							<div class="control-group">
							   <label class="control-label" for="title">Nama Pejabat</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='tiba_nama_II' id="tiba_nama_II" value="<?php echo set_value('tiba_nama_II', $sppd['tiba_nama_II'] != "0" ? $sppd['tiba_nama_II'] : ''); ?>" />
							   </div>
						   </div>
						   <div class="control-group">
							   <label class="control-label" for="title">NIP</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='tiba_nip_II' id="tiba_nip_II" value="<?php echo set_value('tiba_nip_II', $sppd['tiba_nip_II'] != "0" ? $sppd['tiba_nip_II'] : ''); ?>" />
							   </div>
						   </div>
						</fieldset>
					</td>
					<td>
						<fieldset>
						<legend>II</legend
						   <div class="control-group">
							   <label class="control-label" for="title">berangkat dari</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='berangkatdi_II' id="berangkatdi_II" value="<?php echo set_value('berangkatdi_II', $sppd['berangkatdi_II'] != "0" ? $sppd['berangkatdi_II'] : ''); ?>" />
							   </div>
						   </div>
						   <div class="control-group">
							   <label class="control-label" for="title">Pada tanggal</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='berangkat_tanggal_II' id="berangkat_tanggal_II" value="<?php echo set_value('berangkat_tanggal_II', $sppd['berangkat_tanggal_II'] != "0000-00-00" ? $sppd['berangkat_tanggal_II'] : ''); ?>" />
							   </div>
						   </div>
						    <div class="control-group">
							   <label class="control-label" for="title">Kepala</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='berangkat_kepala_II' id="berangkat_kepala_II" value="<?php echo set_value('berangkat_kepala_II', $sppd['berangkat_kepala_II'] != "0" ? $sppd['berangkat_kepala_II'] : ''); ?>" />
							   </div>
						   </div>
							<div class="control-group">
							   <label class="control-label" for="title">Nama Pejabat</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='berangkat_nama_II' id="berangkat_nama_II" value="<?php echo set_value('berangkat_nama_II',  $sppd['berangkat_nama_II'] != "0" ? $sppd['berangkat_nama_II'] : ''); ?>" />
							   </div>
						   </div>
						   <div class="control-group">
							   <label class="control-label" for="title">NIP</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='berangkat_nip_II' id="berangkat_nip_II" value="<?php echo set_value('berangkat_nip_II',  $sppd['berangkat_nip_II'] != "0" ? $sppd['berangkat_nip_II'] : ''); ?>" />
							   </div>
						   </div>
						</fieldset>
					</td>
					
				</tr>
				<tr>
					<td width="50%">
						<fieldset>
						<legend>III</legend
						   <div class="control-group">
							   <label class="control-label" for="title">Tiba di</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='tibadi_III' id="tibadi_III" value="<?php echo set_value('tibadi_III',  $sppd['tibadi_III'] != "0" ? $sppd['tibadi_III'] : ''); ?>" />
							   </div>
						   </div>
						   <div class="control-group">
							   <label class="control-label" for="title">Pada tanggal</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='tiba_tanggal_III' id="tiba_tanggal_III" value="<?php echo set_value('tiba_tanggal_III',  $sppd['tiba_tanggal_III'] != "0000-00-00" ? $sppd['tiba_tanggal_III'] : ''); ?>" />
							   </div>
						   </div>
						    <div class="control-group">
							   <label class="control-label" for="title">Kepala</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='tiba_kepala_III' id="tiba_kepala_III" value="<?php echo set_value('tiba_kepala_III', $sppd['tiba_kepala_III'] != "0" ? $sppd['tiba_kepala_III'] : ''); ?>" />
							   </div>
						   </div>
							<div class="control-group">
							   <label class="control-label" for="title">Nama Pejabat</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='tiba_nama_III' id="tiba_nama_III" value="<?php echo set_value('tiba_nama_III', $sppd['tiba_nama_III'] != "0" ? $sppd['tiba_nama_III'] : ''); ?>" />
							   </div>
						   </div>
						   <div class="control-group">
							   <label class="control-label" for="title">NIP</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='tiba_nip_III' id="tiba_nip_III" value="<?php echo set_value('tiba_nip_III', $sppd['tiba_nip_III'] != "0" ? $sppd['tiba_nip_III'] : ''); ?>" />
							   </div>
						   </div>
						</fieldset>
					</td>
					<td>
						<fieldset>
						<legend>III</legend
						   <div class="control-group">
							   <label class="control-label" for="title">berangkat dari</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='berangkatdi_III' id="berangkatdi_III" value="<?php echo set_value('berangkatdi_III', $sppd['berangkatdi_III'] != "0" ? $sppd['berangkatdi_III'] : ''); ?>" />
							   </div>
						   </div>
						   <div class="control-group">
							   <label class="control-label" for="title">Pada tanggal</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='berangkat_tanggal_III' id="berangkat_tanggal_III" value="<?php echo set_value('berangkat_tanggal_III', $sppd['berangkat_tanggal_III'] != "0000-00-00" ? $sppd['berangkat_tanggal_III'] : ''); ?>" />
							   </div>
						   </div>
						    <div class="control-group">
							   <label class="control-label" for="title">Kepala</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='berangkat_kepala_III' id="berangkat_kepala_III" value="<?php echo set_value('berangkat_kepala_III', $sppd['berangkat_kepala_III'] != "0" ? $sppd['berangkat_kepala_III'] : ''); ?>" />
							   </div>
						   </div>
							<div class="control-group">
							   <label class="control-label" for="title">Nama Pejabat</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='berangkat_nama_III' id="berangkat_nama_III" value="<?php echo set_value('berangkat_nama_III', $sppd['berangkat_nama_III'] != "0" ? $sppd['berangkat_nama_III'] : ''); ?>" />
							   </div>
						   </div>
						   <div class="control-group">
							   <label class="control-label" for="title">NIP</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='berangkat_nip_III' id="berangkat_nip_III" value="<?php echo set_value('berangkat_nip_III', $sppd['berangkat_nip_III'] != "0" ? $sppd['berangkat_nip_III'] : ''); ?>" />
							   </div>
						   </div>
						</fieldset>
					</td>
					
				</tr>
				<tr>
					<td width="50%">
						<fieldset>
						<legend>IV</legend
						   <div class="control-group">
							   <label class="control-label" for="title">Tiba di</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='tibadi_IV' id="tibadi_IV" value="<?php echo set_value('tibadi_IV', $sppd['tibadi_IV'] != "0" ? $sppd['tibadi_IV'] : ''); ?>" />
							   </div>
						   </div>
						   <div class="control-group">
							   <label class="control-label" for="title">Pada tanggal</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='tiba_tanggal_IV' id="tiba_tanggal_IV" value="<?php echo set_value('tiba_tanggal_IV', $sppd['tiba_tanggal_IV'] != "0000-00-00" ? $sppd['tiba_tanggal_IV'] : ''); ?>" />
							   </div>
						   </div>
						    <div class="control-group">
							   <label class="control-label" for="title">Kepala</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='tiba_kepala_IV' id="tiba_kepala_IV" value="<?php echo set_value('tiba_kepala_IV', $sppd['tiba_kepala_IV'] != "0" ? $sppd['tiba_kepala_IV'] : ''); ?>" />
							   </div>
						   </div>
							<div class="control-group">
							   <label class="control-label" for="title">Nama Pejabat</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='tiba_nama_IV' id="tiba_nama_IV" value="<?php echo set_value('tiba_nama_IV', $sppd['tiba_nama_IV'] != "0" ? $sppd['tiba_nama_IV'] : ''); ?>" />
							   </div>
						   </div>
						   <div class="control-group">
							   <label class="control-label" for="title">NIP</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='tiba_nip_IV' id="tiba_nip_IV" value="<?php echo set_value('tiba_nip_IV', $sppd['tiba_nip_IV'] != "0" ? $sppd['tiba_nip_IV'] : ''); ?>" />
							   </div>
						   </div>
						</fieldset>
					</td>
					<td>
						<fieldset>
						<legend>IV</legend
						   <div class="control-group">
							   <label class="control-label" for="title">berangkat dari</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='berangkatdi_IV' id="berangkatdi_IV" value="<?php echo set_value('berangkatdi_IV', $sppd['berangkatdi_IV'] != "0" ? $sppd['berangkatdi_IV'] : ''); ?>" />
							   </div>
						   </div>
						   <div class="control-group">
							   <label class="control-label" for="title">Pada tanggal</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='berangkat_tanggal_IV' id="berangkat_tanggal_IV" value="<?php echo set_value('berangkat_tanggal_IV', $sppd['berangkat_tanggal_IV'] != "0000-00-00" ? $sppd['berangkat_tanggal_IV'] : ''); ?>" />
							   </div>
						   </div>
						    <div class="control-group">
							   <label class="control-label" for="title">Kepala</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='berangkat_kepala_IV' id="berangkat_kepala_IV" value="<?php echo set_value('berangkat_kepala_IV', $sppd['berangkat_kepala_IV'] != "0" ? $sppd['berangkat_kepala_IV'] : ''); ?>" />
							   </div>
						   </div>
							<div class="control-group">
							   <label class="control-label" for="title">Nama Pejabat</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='berangkat_nama_IV' id="berangkat_nama_IV" value="<?php echo set_value('berangkat_nama_IV', $sppd['berangkat_nama_IV'] != "0" ? $sppd['berangkat_nama_IV'] : ''); ?>" />
							   </div>
						   </div>
						   <div class="control-group">
							   <label class="control-label" for="title">NIP</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='berangkat_nip_IV' id="berangkat_nip_IV" value="<?php echo set_value('berangkat_nip_IV', $sppd['berangkat_nip_IV'] != "0" ? $sppd['berangkat_nip_IV'] : ''); ?>" />
							   </div>
						   </div>
						</fieldset>
					</td>
					
				</tr>
				<tr>
					<td width="50%">
						<fieldset>
						<legend>V</legend
						   <div class="control-group">
							   <label class="control-label" for="title">Tiba di</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='tibadi_V' id="tibadi_V" value="<?php echo set_value('tibadi_V', $sppd['tibadi_V'] != "0" ? $sppd['tibadi_V'] : ''); ?>" />
							   </div>
						   </div>
						   <div class="control-group">
							   <label class="control-label" for="title">Pada tanggal</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='tiba_tanggal_V' id="tiba_tanggal_V" value="<?php echo set_value('tiba_tanggal_V', $sppd['tiba_tanggal_V'] != "0000-00-00" ? $sppd['tiba_tanggal_V'] : ''); ?>" />
							   </div>
						   </div>
						    <div class="control-group">
							   <label class="control-label" for="title">Kepala</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='tiba_kepala_V' id="tiba_kepala_V" value="<?php echo set_value('tiba_kepala_V', $sppd['tiba_kepala_V'] != "0" ? $sppd['tiba_kepala_V'] : ''); ?>" />
							   </div>
						   </div>
							<div class="control-group">
							   <label class="control-label" for="title">Nama Pejabat</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='tiba_nama_V' id="tiba_nama_V" value="<?php echo set_value('tiba_nama_V', $sppd['tiba_nama_V'] != "0" ? $sppd['tiba_nama_V'] : ''); ?>" />
							   </div>
						   </div>
						   <div class="control-group">
							   <label class="control-label" for="title">NIP</label>
							   <div class="input-prepend input-append">
								   <input type="text" name='tiba_nip_V' id="tiba_nip_V" value="<?php echo set_value('tiba_nip_V', $sppd['tiba_nip_V'] != "0" ? $sppd['tiba_nip_V'] : ''); ?>" />
							   </div>
						   </div>
						</fieldset>
					</td>
					<td>
						 
					</td>
					
				</tr>
			</table>
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

</script>
<script type="text/javascript">	  
$('.timeformat').timepicker({ 'timeFormat': 'H:i:s' });
	$(".numericOnly").keypress(function (e) {
		if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
	});

</script>
