<style>
hr {
  margin: 5px 0;
  border-bottom: 1px solid #fefefe;
}
@media print {
    body {
		 font-family: 'Arial';
		 font-size: 12px;
		 font-style: normal;
		 font-variant: normal;
    }
    hr {
	  margin: 5px 0;
	  border-bottom: 1px solid #fefefe;
	}
    .headjudul {
		font-size : 34pt;
    }
    .headjudul1 {
		font-size : 17pt;
    }
    .headjudul2 {
		font-size : 14pt;
    }
    .headjudul3 {
		font-size : 22pt;
    }
	table {
		border-collapse: collapse;
		
	}
	table .tabel{
		font-size: 20pt;
	}
	table .tabel{
		font-size: 20pt;
	}
	td{
		padding:2px;
	}
	.checkboxOne {
		width: 40px;
		height: 40px;
		background-color: #e9ecee;
		color: #99a1a7;
		border: 1px solid #adb8c0;
	}
	@font-face {
		font-family: 'Arial';
	}
	/* use this class to attach this font to any element i.e. <p class="fontsforweb_fontid_507">Text with this font applied</p> */
	.btnprint{
		display: none;
	}
}
</style>
<?php
$this->load->library('convert');
$convert = new convert();
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
<table style="width:1020px" border="0">
	<tr>
		<td width="50%">
			LEMBAGA ILMU PENGETAHUAN INDONESIA <br>
			PUSAT PENELITIAN SISTEM MUTU DAN TEKNOLOGI PENGUJIAN <br>
			<i>Kompleks PUSPIPTEK Gedung (417) Setu Tangerang <br>
			Telp. 021-75871130,Fax. 021-75871137 </i><br>
			<hr>
			<center>
			<b>SURAT PERJALANAN DINAS <br>
			DIWILAYAH JABODETABEK <br>
			</b>
			</center>
			<table border="1" width="100%">
				<tr>
					<td>
					1.
					</td>
					<td>
						Pejabat Berwenang memberi perintah
					</td>
					<td>
						<?php echo $sppd_jabodetabek['nama']; ?>
					</td>
				</tr>
				<tr>
					<td>
					2.
					</td>
					<td>
						Nama Pegawai yang diperintahkan
					</td>
					<td>
						<?php echo $sppd_jabodetabek['display_name']; ?>
					</td>
				</tr>
				<tr>
					<td>
					3.
					</td>
					<td>
						a. Pangkat dan Golongan
					</td>
					<td>
						  <?php echo $sppd_jabodetabek['sppd_pangkat']; ?>/ <?php echo $sppd_jabodetabek['sppd_golongan']; ?>
					</td>
				</tr>
				<tr>
					<td>
		 
					</td>
					<td>
						b. Jabatan
					</td>
					<td>
						  <?php echo $sppd_jabodetabek['sppd_jabatan']; ?>  
					</td>
				</tr>
				<tr>
					<td>
					 4. 
					</td>
					<td>
						Maksud Perjalanan Dinas
					</td>
					<td>
						  <?php echo $sppd_jabodetabek['maksud']; ?>
					</td>
				</tr>
				<tr>
					<td>
					 5.  
					</td>
					<td>
						Anggaran yang dipergunakan <br>
						
					</td>
					<td valign="top">
						<?php if(isset($sppd_jabodetabek['anggaran']) and $sppd_jabodetabek['anggaran']=="Tematik"){ ?>
							<b>Tematik, No keg : <?php echo $sppd_jabodetabek['no_keg']; ?> </b> <br>
							PNBP, No keg : <br>
							Rutin, No keg : <br>
						<?php } ?>
						<?php if(isset($sppd_jabodetabek['anggaran']) and $sppd_jabodetabek['anggaran']=="PNBP"){ ?>
							Tematik, No keg :  <br>
							<b>PNBP, No keg : <?php echo $sppd_jabodetabek['no_keg']; ?> <br> </b>
							Rutin, No keg :  <br>
						<?php } ?>
						
						<?php if(isset($sppd_jabodetabek['anggaran']) and $sppd_jabodetabek['anggaran']=="Rutin"){ ?>
							Tematik, No keg :   <br>
							PNBP, No keg : <br></b>
							<b>Rutin, No keg : <?php echo $sppd_jabodetabek['no_keg']; ?> <br> </b>
						<?php } ?>
						<?php if(isset($sppd_jabodetabek['anggaran']) and $sppd_jabodetabek['anggaran']=="Instansi Lain"){ ?>
							Tematik, No keg :  <br>
							PNBP, No keg : </br>
							 Rutin, No keg : <br>
						<?php } ?>
						<?php if(isset($sppd_jabodetabek['anggaran']) and $sppd_jabodetabek['anggaran']=="Instansi Lain"){ ?>
							 
							<b>Instansi Lain </b> <br>
						<?php } ?> 
					</td>
				</tr>
				<tr>
					<td>
					 6. 
					</td>
					<td>
						Angkutan yang dipergunakan
					</td>
					<td>
						 
						<?php if(isset($sppd_jabodetabek['angkutan']) and $sppd_jabodetabek['angkutan']=="Dinas"){ 
						echo $sppd_jabodetabek['nippegawai'] == "196909151989011002" ? "Dinas": "<b>Umum</b>";
						?>
						<?php } else { 
						echo $sppd_jabodetabek['nippegawai'] == "196909151989011002" ? "Dinas": "Umum";
						?>
						<?php } ?>
						
					</td>
				</tr>
				
				<tr>
					<td>
					 7.  
					</td>
					<td>
						Tempat Berangkat
					</td>
					<td>
						 <?php echo $sppd_jabodetabek['tempat_berangkat']; ?>
					</td>
				</tr>
				
				<tr>
					<td>
					 8.  
					</td>
					<td>
						Tempat Tujuan
					</td>
					<td>
						 <?php echo $sppd_jabodetabek['instansi_tujuan']; ?>
					</td>
				</tr>
				<tr>
					<td>
					 9.  
					</td>
					<td>
						a. Hari/ Tgl Berangkat <br><br>
						b. Jam keberangkatan
					</td>
					<td>
						  <?php echo $sppd_jabodetabek['hari']; ?>,					  
						  <?php 
							if($sppd_jabodetabek['tanggal_berangkat'] != '' and $sppd_jabodetabek['tanggal_berangkat'] != "0000-00-00")
							{
							  e($convert->fmtDate($sppd_jabodetabek['tanggal_berangkat'],"dd month yyyy"));
							}
							if($sppd_jabodetabek['sampai_tanggal'] != '' and $sppd_jabodetabek['sampai_tanggal'] != "0000-00-00")
							{
							  echo "<br> s.d.".$convert->fmtDate($sppd_jabodetabek['sampai_tanggal'],"dd month yyyy");
							}
						  ?> 
						  <br>
						 <?php echo $sppd_jabodetabek['jam_berangkat']; ?> 
			 
					</td>
				</tr>
				<!--
				<tr>
					<td>
					 10.  
					</td>
					<td>
						Nama Pengemudi / Nomor Kendaraan
					</td>
					<td>
						<?php echo $sppd_jabodetabek['pengemudi']; ?> 
					</td>
				</tr>
				-->
				<tr>
					<td>
					 10.  
					</td>
					<td valign="top">
						Nama Pengikut
					</td>
					<td>
			   			<?php if (isset($data_pengikut) && is_array($data_pengikut) && count($data_pengikut)) : 
						  $no = 1;
						  foreach ($data_pengikut as $recorddetil) :

						  ?> 
							 <?php echo $no.". ".$recorddetil->display_name; ?><br>
						  <?php
						  $no++;
						  endforeach;
						  endif;
						  ?>
					</td>
				</tr>
			</table>
			<table border="0" width="100%">
				<tr>
					<td>
						Dikeluarkan di : Tangerang Selatan
					</td>
					<td colspan="2">
					</td>
					
				</tr>
				<tr>
					<td>
						Pada Tanggal : 
						<?php 
							e($convert->fmtDate(date("Y-m-d"),"dd month yyyy"));
					 	?>
					</td>
					<td colspan="2">
					</td>
					
				</tr>
				<tr>
					<td colspan="2">
						Mengetahui
					</td>
					 
					<td>
					 Pemberi Tugas
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Kepala Bagian Tata Usaha 
						<br>
						<br>
						<br>
						<br>
						<br>
					</td>
					<td valign="top">
					Atasan Langsung <br>
					 
					</td>
					
				</tr>
				<tr>
					<td colspan="2">
						(Ade Khaerudin Taufiq S.Pd. M.Si) <br>
						NIP. 19610416 198303 1 003
					</td>
					<td>
						(&nbsp;
						<?php echo $sppd_jabodetabek['nama_pejabat']; ?> 
						&nbsp;) <br>
						NIP.<?php echo $sppd_jabodetabek['nippejabat']; ?>   
						
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<b><i>Salinan SPPD ini HARUS disampaikan kepada :</i> </b><br>
						1. Subag KPU (Untuk Data Kehadiran/ Kendaraan)
					</td>
				</tr>
			</table>	
		</td>
		 
		<td>
			LEMBAGA ILMU PENGETAHUAN INDONESIA <br>
			PUSAT PENELITIAN SISTEM MUTU DAN TEKNOLOGI PENGUJIAN <br>
			<i>Kompleks PUSPIPTEK Gedung (417) Setu Tangerang <br>
			Telp. 021-75871130,Fax. 021-75871137 </i><br>
			<hr>
			<center>
			<b>SURAT PERJALANAN DINAS <br>
			DIWILAYAH JABODETABEK <br>
			</b>
			</center>
			<table border="1" width="100%">
				<tr>
					<td>
					1.
					</td>
					<td>
						Pejabat Berwenang memberi perintah
					</td>
					<td>
						<?php echo $sppd_jabodetabek['nama']; ?>
					</td>
				</tr>
				<tr>
					<td>
					2.
					</td>
					<td>
						Nama Pegawai yang diperintahkan
					</td>
					<td>
						<?php echo $sppd_jabodetabek['display_name']; ?>
					</td>
				</tr>
				<tr>
					<td>
					3.
					</td>
					<td>
						a. Pangkat dan Golongan
					</td>
					<td>
						  <?php echo $sppd_jabodetabek['sppd_pangkat']; ?>/ <?php echo $sppd_jabodetabek['sppd_golongan']; ?>
					</td>
				</tr>
				<tr>
					<td>
		 
					</td>
					<td>
						b. Jabatan
					</td>
					<td>
						  <?php echo $sppd_jabodetabek['sppd_jabatan']; ?>  
					</td>
				</tr>
				<tr>
					<td>
					 4. 
					</td>
					<td>
						Maksud Perjalanan Dinas
					</td>
					<td>
						  <?php echo $sppd_jabodetabek['maksud']; ?>
					</td>
				</tr>
				<tr>
					<td>
					 5.  
					</td>
					<td>
						Anggaran yang dipergunakan <br>
						
					</td>
					<td valign="top">
						<?php if(isset($sppd_jabodetabek['anggaran']) and $sppd_jabodetabek['anggaran']=="Tematik"){ ?>
							<b>Tematik, No keg : <?php echo $sppd_jabodetabek['no_keg']; ?> </b> <br>
							PNBP, No keg : <br>
							Rutin, No keg : <br>
						<?php } ?>
						<?php if(isset($sppd_jabodetabek['anggaran']) and $sppd_jabodetabek['anggaran']=="PNBP"){ ?>
							Tematik, No keg :  <br>
							<b>PNBP, No keg : <?php echo $sppd_jabodetabek['no_keg']; ?> <br> </b>
							Rutin, No keg :  <br>
						<?php } ?>
						
						<?php if(isset($sppd_jabodetabek['anggaran']) and $sppd_jabodetabek['anggaran']=="Rutin"){ ?>
							Tematik, No keg :   <br>
							PNBP, No keg : <br></b>
							<b>Rutin, No keg : <?php echo $sppd_jabodetabek['no_keg']; ?> <br> </b>
						<?php } ?>
						<?php if(isset($sppd_jabodetabek['anggaran']) and $sppd_jabodetabek['anggaran']=="Instansi Lain"){ ?>
							Tematik, No keg :  <br>
							PNBP, No keg : </br>
							 Rutin, No keg : <br>
						<?php } ?>
						<?php if(isset($sppd_jabodetabek['anggaran']) and $sppd_jabodetabek['anggaran']=="Instansi Lain"){ ?>
							 
							<b>Instansi Lain </b> <br>
						<?php }?> 
					</td>
				</tr>
				<tr>
					<td>
					 6. 
					</td>
					<td>
						Angkutan yang dipergunakan
					</td>
					<td>
						 
						<?php if(isset($sppd_jabodetabek['angkutan']) and $sppd_jabodetabek['angkutan']=="Dinas"){ 
						echo $sppd_jabodetabek['nippegawai'] == "196909151989011002" ? "Dinas": "<b>Umum</b>";
						?>
						<?php } else { 
						echo $sppd_jabodetabek['nippegawai'] == "196909151989011002" ? "Dinas": "Umum";
						?>
						<?php } ?>
						
					</td>
				</tr>
				<tr>
					<td>
					 7.  
					</td>
					<td>
						Tempat Berangkat
					</td>
					<td>
						 <?php echo $sppd_jabodetabek['tempat_berangkat']; ?>
					</td>
				</tr>
				<tr>
					<td>
					 8.  
					</td>
					<td>
						Tempat Tujuan
					</td>
					<td>
						 <?php echo $sppd_jabodetabek['instansi_tujuan']; ?>
					</td>
				</tr>
				<tr>
					<td>
					 9.  
					</td>
					<td>
						a. Hari/ Tgl Berangkat <br><br>
						b. Jam keberangkatan
					</td>
					<td>
						  <?php echo $sppd_jabodetabek['hari']; ?>,					  
						  <?php 
							if($sppd_jabodetabek['tanggal_berangkat'] != '' and $sppd_jabodetabek['tanggal_berangkat'] != "0000-00-00")
							{
							  e($convert->fmtDate($sppd_jabodetabek['tanggal_berangkat'],"dd month yyyy"));
							}
							if($sppd_jabodetabek['sampai_tanggal'] != '' and $sppd_jabodetabek['sampai_tanggal'] != "0000-00-00")
							{
							  echo "<br> s.d.".$convert->fmtDate($sppd_jabodetabek['sampai_tanggal'],"dd month yyyy");
							}
						  ?> 
						  <br>
						 <?php echo $sppd_jabodetabek['jam_berangkat']; ?> 
			 
					</td>
				</tr>
				<!--
				<tr>
					<td>
					 10.  
					</td>
					<td>
						Nama Pengemudi / Nomor Kendaraan
					</td>
					<td>
						 <?php echo $sppd_jabodetabek['pengemudi']; ?>
					</td>
				</tr>
				-->
				<tr>
					<td>
					 10.  
					</td>
					<td valign="top">
						Nama Pengikut
					</td>
					<td>
			   			<?php if (isset($data_pengikut) && is_array($data_pengikut) && count($data_pengikut)) : 
						  $no = 1;
						  foreach ($data_pengikut as $recorddetil) :

						  ?> 
							 <?php echo $no.". ".$recorddetil->display_name; ?><br>
						  <?php
						  $no++;
						  endforeach;
						  endif;
						  ?>
					</td>
				 
				</tr>
			</table>
			<table border="0" width="100%">
				<tr>
					<td>
						Dikeluarkan di : Tangerang Selatan
					</td>
					<td colspan="2">
					</td>
					
				</tr>
				<tr>
					<td>
						Pada Tanggal : 
						<?php 
							e($convert->fmtDate(date("Y-m-d"),"dd month yyyy"));
					 	?>
					</td>
					<td colspan="2">
					</td>
					
				</tr>
				<tr>
					<td colspan="2">
						Mengetahui
					</td>
					 
					<td>
					 Pemberi Tugas
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Kepala Bagian Tata Usaha 
						<br>
						<br>
						<br>
						<br>
						<br>
					</td>
					<td valign="top">
					Atasan Langsung
					</td>
					
				</tr>
				<tr>
					<td colspan="2">
						(Ade Khaerudin Taufiq S.Pd. M.Si) <br>
						NIP. 19610416 198303 1 003
					</td>
					<td>
						(&nbsp;
						<?php echo $sppd_jabodetabek['nama_pejabat']; ?> 
						&nbsp;) <br>
						NIP.<?php echo $sppd_jabodetabek['nippejabat']; ?>   
						
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<b><i>Salinan SPPD ini HARUS disampaikan kepada :</i> </b><br>
						1. Subag Keuangan (Untuk alokasi biaya)
					</td>
				</tr>
			</table>
		</td>
	</tr>	
</table>

  