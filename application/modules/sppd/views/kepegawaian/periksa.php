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
					<input id='sppd_tanggal_berangkat' class="datepicker"  type='text' name='sppd_tanggal_berangkat'  value="<?php echo set_value('sppd_tanggal_berangkat', isset($sppd['tanggal_berangkat']) ? $sppd['tanggal_berangkat'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal_berangkat'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('tanggal_kembali') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Kembali', 'tanggal_kembali', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='tanggal_kembali'  type='text' class="datepicker" name='tanggal_kembali'  value="<?php echo set_value('tanggal_kembali', isset($sppd['tanggal_kembali']) ? $sppd['tanggal_kembali'] : ''); ?>" />
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
			</fieldset>
			 
				<fieldset>
				<legend>Persetujuan</legend>
				<div class="control-group <?php echo form_error('status_atasan') ? 'error' : ''; ?>">
					<?php echo form_label('Status Atasan', '', array('class' => 'control-label', 'id' => 'surat_izin_status_atasan_label') ); ?>
					<div class='controls' aria-labelled-by='surat_izin_status_atasan_label'>
						<label class='radio' for='surat_izin_status_atasan_option1'>
							<input id='surat_izin_status_atasan_option1' name='status_atasan' type='radio' class='' value='1' <?php if(isset($sppd['status_atasan']) and $sppd['status_atasan']=="1") echo "checked"; ?> />
							Setuju
						</label>
						<br>
						<label class='radio' for='surat_izin_status_atasan_option2'>
							<input id='surat_izin_status_atasan_option2' name='status_atasan' type='radio' class='' value='2' <?php if(isset($sppd['status_atasan']) and $sppd['status_atasan']=="2") echo "checked"; ?> />
							Tidak Setuju
						</label>
						<span class='help-inline'><?php echo form_error('status_atasan'); ?></span>
					</div>
				</div>
				<div class="control-group <?php echo form_error('alasan_ditolak') ? 'error' : ''; ?>">
					<?php echo form_label('Alasan (Jika Ditolak)', 'alasan_ditolak', array('class' => 'control-label') ); ?>
					<div class='controls'> 
						<?php echo form_textarea( array( 'name' => 'alasan_ditolak', 'id' => 'alasan_ditolak', 'rows' => '5', 'cols' => '80', 'value' => set_value('alasan_ditolak', isset($sppd['alasan_ditolak']) ? $sppd['alasan_ditolak'] : '') ) ); ?>
						<span class='help-inline'><?php echo form_error('alasan_ditolak'); ?></span>
					</div>
				</div>
				<!--
				<div class="control-group <?php echo form_error('status_pj') ? 'error' : ''; ?>">
					<?php echo form_label('Status Pertanggung Jawaban', '', array('class' => 'control-label', 'id' => 'status_pj_label') ); ?>
					<div class='controls' aria-labelled-by='status_pj_label'>
						<label class='radio' for='status_pj_option1'>
							<input id='status_pj_option1' name='status_pj' type='radio' class='' value='1' <?php if(isset($sppd['status_pj']) and $sppd['status_pj']=="1") echo "checked"; ?> />
							Sudah
						</label>
						<br>
						<label class='radio' for='surat_izin_status_atasan_option2'>
							<input id='status_pj_option2' name='status_pj' type='radio' class='' value='2' <?php if(isset($sppd['status_pj']) and $sppd['status_pj']=="0") echo "checked"; ?> />
							Belum
						</label>
						<span class='help-inline'><?php echo form_error('status_atasan'); ?></span>
					</div>
				</div>
				-->
			<?php if ($this->auth->has_permission('Sppd.Kepegawaian.Lapspj')) : ?>
				<fieldset>
					<legend> Laporan SPJ </legend>
						<table border="0">
							<tr>
								<td>
									Transport
								</td>
								<td>
									<div class="input-prepend input-append ">
										
										<input type="text" class="numericOnly form-control hitungtransport span3" name='transport_jml' id="transport_jml" value="<?php echo set_value('transport_jml', isset($sppd['transport_jml']) ? $sppd['transport_jml'] : ''); ?>" />
										<span class="add-on">X</span>
									</div>
									
								</td>
								 
								<td>
									<div class="input-prepend input-append">
										<span class="add-on">1 X Rp</span>
										<input type="text" class="numericOnly form-control hitungtransport span8" name='transport_satu' id="transport_satu" value="<?php echo set_value('transport_satu', isset($sppd['transport_satu']) ? $sppd['transport_satu'] : ''); ?>" />
									</div>
									
								</td>
								<td>
									<div class="input-prepend input-append">
										<span class="add-on">Jumlah</span>
										<input type="text" class="numericOnly form-control span8" name='transport' id="transport" value="<?php echo set_value('transport', isset($sppd['transport']) ? $sppd['transport'] : ''); ?>" />
									</div>
									
								</td>
								<td>
									<input id='ket_transport' type='text' class="form-control" name='ket_transport' class="span10" placeholder="keterangan" value="<?php echo set_value('ket_transport', isset($sppd['ket_transport']) ? $sppd['ket_transport'] : ''); ?>" />
								</td>
							</tr>

							<tr>
								<td>
									Harian
								</td>
								<td>
									<div class="input-prepend input-append ">
										
										<input type="text" class="numericOnly form-control hitungharian span3" name='harian_jml' id="harian_jml" value="<?php echo set_value('harian_jml', isset($sppd['harian_jml']) ? $sppd['harian_jml'] : ''); ?>" />
										<span class="add-on">X</span>
									</div>
									
								</td>
								 
								<td>
									<div class="input-prepend input-append">
										<span class="add-on">1 X Rp</span>
										<input type="text" class="numericOnly form-control hitungharian span8" name='harian_satu' id="harian_satu" value="<?php echo set_value('harian_satu', isset($sppd['harian_satu']) ? $sppd['harian_satu'] : ''); ?>" />
									</div>
									
								</td>
								<td>
									<div class="input-prepend input-append">
										<span class="add-on">Jumlah</span>
										<input type="text" class="form-control span8" name='uang_harian' id="uang_harian" class=" span8" value="<?php echo set_value('uang_harian', isset($sppd['uang_harian']) ? $sppd['uang_harian'] : ''); ?>" />
									</div>
									
								</td>
								<td>
									<input id='ket_uang_harian' type='text' class="form-control" name='ket_uang_harian' placeholder="Keterangan" class="span10" value="<?php echo set_value('ket_uang_harian', isset($sppd['ket_uang_harian']) ? $sppd['ket_uang_harian'] : ''); ?>" />
								</td>
							</tr>

							<tr>
								<td>
									Penginapan
								</td>
								<td>
									<div class="input-prepend input-append ">
										
										<input type="text" class="numericOnly form-control hitungpenginapan span3" name='penginapan_jml' id="penginapan_jml" value="<?php echo set_value('penginapan_jml', isset($sppd['penginapan_jml']) ? $sppd['penginapan_jml'] : ''); ?>" />
										<span class="add-on">X</span>
									</div>
									
								</td>
								 
								<td>
									<div class="input-prepend input-append">
										<span class="add-on">1 X Rp</span>
										<input type="text" class="numericOnly form-control hitungpenginapan span8" name='penginapan_satu' id="penginapan_satu" value="<?php echo set_value('penginapan_satu', isset($sppd['penginapan_satu']) ? $sppd['penginapan_satu'] : ''); ?>" />
									</div>
									
								</td>
								<td>
									<div class="input-prepend input-append">
										<span class="add-on">Jumlah</span>
										<input type="text" class="form-control span8" name='biaya_penginapan' id="biaya_penginapan" class=" span8" value="<?php echo set_value('biaya_penginapan', isset($sppd['biaya_penginapan']) ? $sppd['biaya_penginapan'] : ''); ?>" />
									</div>
									
								</td>
								<td>
									<input id='ket_biaya_penginapan' type='text' class="form-control" name='ket_biaya_penginapan' class="span10" placeholder="Keterangan" value="<?php echo set_value('ket_biaya_penginapan', isset($sppd['ket_biaya_penginapan']) ? $sppd['ket_biaya_penginapan'] : ''); ?>" />
								</td>
							</tr>
							<tr>
								<td>
									Lain-lain
								</td>
								 
								<td align="left">
									<div class="input-prepend input-append">
										<span class="add-on">Jumlah</span>
										<input type="text" class="form-control span8" name='lain_lain' id="lain_lain" class=" span8" value="<?php echo set_value('lain_lain', isset($sppd['lain_lain']) ? $sppd['lain_lain'] : ''); ?>" />
									</div>
									
								</td>
								<td colspan="3">
									<div class="input-prepend input-append">
									<input id='ket_lain_lain' type='text' class="form-control" name='ket_lain_lain' class="span12" placeholder="Keterangan" value="<?php echo set_value('ket_lain_lain', isset($sppd['ket_lain_lain']) ? $sppd['ket_lain_lain'] : ''); ?>" />
									</div>
								</td>
							</tr>
						</table>
						 
 
					</fieldset>
				<fieldset>
					<legend> Pengeluaran Riil </legend>
						<table border="0">
							<tr>
								<td>
									Transport
								</td>
								<td>
									<div class="input-prepend input-append ">
										<span class="add-on">Rp</span>
										<input type="text" class="numericOnly form-control" name='real_transport' id="real_transport" value="<?php echo set_value('real_transport', isset($sppd['real_transport']) ? $sppd['real_transport'] : ''); ?>" />
									</div>
									
								</td>
								<td>
									Keterangan
								</td>
								<td>
									<div class="input-prepend input-append">
										<input id='ket_real_transport' type='text' class="form-control" name='ket_real_transport' class="span10" value="<?php echo set_value('ket_real_transport', isset($sppd['ket_real_transport']) ? $sppd['ket_real_transport'] : ''); ?>" />
									</div>
									
								</td>
							</tr>
							<tr>
								<td>
									Biaya Penginapan
								</td>
								<td>
									<div class="input-prepend input-append">
										<span class="add-on">Rp</span>
										<input type="text" class="form-control" name='real_penginapan' id="real_penginapan" class="span4" value="<?php echo set_value('real_penginapan', isset($sppd['real_penginapan']) ? $sppd['real_penginapan'] : ''); ?>" />
									</div>
									
								</td>
								<td>
									Keterangan
								</td>
								<td>
									<div class="input-prepend input-append">
										<input id='ket_real_penginapan' type='text' class="form-control" name='ket_real_penginapan' class="" value="<?php echo set_value('ket_real_penginapan', isset($sppd['ket_real_penginapan']) ? $sppd['ket_real_penginapan'] : ''); ?>" />
									</div>
									
								</td>
							</tr>
							<tr>
								<td>
									Checklist Jika Laporan SPJ sudah selesai
								</td>
								<td>
									<input type="checkbox" id="status_pj" value="1" <?php echo $sppd['status_pj'] == "1" ? "checked" : "" ?> name="status_pj"> 
									<label for="status_spj">
										
									</label>
									
								</td>
								<td>
									
								</td>
								<td>
									
									
								</td>
							</tr>
							<tr>
								<td>
									Tanggal SP2D
								</td>
								<td>
									<div class="input-prepend input-append ">
										<input id='tgl_sp2d' type='text' name='tgl_sp2d' class="form-control datepicker" value="<?php echo set_value('tgl_sp2d', isset($sppd['tgl_sp2d']) ? $sppd['tgl_sp2d'] : ''); ?>" />
									</div>
								</td>
								<td>
									
								</td>
								<td>
									
									
								</td>
							</tr>
						</table>
						 
					 
						  
			<?php endif; ?>	
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="Save"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/kepegawaian/sppd/listsppd', lang('sppd_cancel'), 'class="btn btn-warning"'); ?>
				or
				<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/sppd/printkuitansi/') ?><?php if(isset($id)) echo "/".$id; ?>" target="_blank">
					<div class="btn btn-primary full-right" id="submit_reset"><i class="fa fa-print"></i> SPD Rampung</div>
				</a>
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

</script>
<script type="text/javascript">	  
$('.timeformat').timepicker({ 'timeFormat': 'H:i:s' });
	$(".numericOnly").keypress(function (e) {
		if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
	});

</script>
<script type="text/javascript">	  
$(".hitungtransport").change(function(){
	var valtransport 	= $("#transport").val();
	var valtransport_jml 	= $("#transport_jml").val();
	var valtransport_satu 	= $("#transport_satu").val();
	if(transport_satu=="")
		transport_satu = 0;
	if(valtransport_jml =="")
		valtransport_jml = 0;
	if(valtransport_satu =="")
		valtransport_satu = 0;
	//alert("masuk");
	var jmltransport = parseFloat(valtransport_jml) * parseFloat(valtransport_satu);
	$("#transport").val(jmltransport);	
});
$(".hitungharian").change(function(){
	var valuang_harian 	= $("#uang_harian").val();
	var valharian_jml 	= $("#harian_jml").val();
	var valharian_satu 	= $("#harian_satu").val();
	
	if(valharian_satu=="")
		valharian_satu = 0;
	if(valharian_jml =="")
		valharian_jml = 0;
		
	//alert("masuk");
	var jmltransport = parseFloat(valharian_jml) * parseFloat(valharian_satu);
	$("#uang_harian").val(jmltransport);	
});
$(".hitungpenginapan").change(function(){
	var valbiaya_penginapan 	= $("#biaya_penginapan").val();
	var valpenginapan_jml 	= $("#penginapan_jml").val();
	var valpenginapan_satu 	= $("#penginapan_satu").val();
	
	if(valpenginapan_jml=="")
		valpenginapan_jml = 0;
	if(valpenginapan_satu =="")
		valpenginapan_satu = 0;
		
	//alert("masuk");
	var jumlah = parseFloat(valpenginapan_jml) * parseFloat(valpenginapan_satu);
	$("#biaya_penginapan").val(jumlah);	
});
$(".hitungrepresentasi").change(function(){
	var valrepresentasi 	= $("#representasi").val();
	var valrepresentasi_jml 	= $("#representasi_jml").val();
	var valrepresentasi_satu 	= $("#representasi_satu").val();
	
	if(valrepresentasi_jml=="")
		valrepresentasi_jml = 0;
	if(valrepresentasi_satu =="")
		valrepresentasi_satu = 0;
		
	//alert("masuk");
	var jumlah = parseFloat(valrepresentasi_jml) * parseFloat(valrepresentasi_satu);
	$("#representasi").val(jumlah);	
});

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
</script>
