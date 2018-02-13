<style>
hr {
  margin: 5px 0;
  border-bottom: 1px solid #fefefe;
}
.table td{
	height : 40px;
	padding : 5px;
	margin-bottom : 5px;
}
.tablesmal td{
	height : 20px;
	padding : 1px;
}
td{
		padding:7px;
	}
@media print {
    body {
		 font-family: 'Arial';
		 font-size: 12px;
		 font-style: normal;
		 font-variant: normal;
    }
    .break { page-break-before: always; }
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
		font-size : 9pt;
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
		padding:10px;
	}
	.tablemiddle td{
		padding : 3px;
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
			 
<table style="width:100%" border="1">
	<tr>
		<td align="center" width="100px">
			<img src="<?php echo base_url(); ?>assets/images/client.png" width="50px">
			<br>
			 
		</td>
		<td align="center" width="50%">
			<h2>FORMULIR </h2><hr>
			<h4>Laporan Perjalanan Dinas</h4>
		</td>
		<td>
			<table>
				<tr>
					<td width="94%">
						 
					</td>		
					<td rowspan="4">
						<!-- 
						<img src="<?php echo base_url(); ?>assets/images/2017-06-05-PHOTO-00000006.jpg" width="50px" height="100px">
						-->
					</td>
				</tr>
				<tr>
					<td>
						 
					</td>		
				</tr>
				<tr>
					<td>
						 
					</td>		
				</tr>
				<tr>
					<td>
						 
					</td>		
				</tr>
			</table>
			
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<table border="0" width="100%" class="break">
				<tr>
					<td width="30%" valign="top" class="transparan">
						 Nama
					</td>
					<td width="5px"> : </td>
					<td>
						<?php echo $sppd_jabodetabek['namapegawai']; ?>/<?php echo $sppd_jabodetabek['nippegawai']; ?>
					</td>
				</tr>
	 			<tr>
					<td>
						Keltian/Subbid/Subbag
					</td>
					<td> : </td>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						 Penanggung Jawab Kegiatan (Pemberi Tugas)
					</td>
					<td> : </td>
					<td>
						<?php echo (isset($penanggungjawabs->nama) and $penanggungjawabs->nama!= "") ? $penanggungjawabs->nama : ""; ?>
					</td>
				</tr>
				<tr>
					<td>
						 Judul Kegiatan
					</td>
					<td> : </td>
					<td>
						<?php echo $sppd_jabodetabek['judul_kegiatan']; ?>
					</td>
				</tr>
				<tr>
					<td>
						 Instansi yang dituju
					</td>
					<td> : </td>
					<td>
						<?php echo $sppd_jabodetabek['instansi_tujuan']; ?>
					</td>
				</tr>
				<tr>
					<td>
						 Tujuan Kunjungan
					</td>
					<td> : </td>
					<td>
						<?php echo $sppd_jabodetabek['maksud']; ?>
					</td>
				</tr>
				<tr>
					<td>
						 Tanggal
					</td>
					<td> : </td>
					<td>
						<?php echo $convert->fmtDate($sppd_jabodetabek['tanggal_berangkat'],"dd month yyyy"); ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			Hasil Perjalanan Dinas : 
			<br>
			<?php echo html_entity_decode($sppd_jabodetabek['laporan_perjalanan_text']); ?>

			<br>
			<br>
			*) <i>Jika diperlukan halaman ini bisa di tambah </i><br>
			**) <i>Peserta Seminar/sosialisasi/pelatihan harus menyerahkan copy sertifikat kepada subbag kepegawaian untuk arsip </i>
		</td>
	</tr>	
	<tr>
		<td colspan="3">
			<table width="100%">
				<tr>
					<td width="50%" valign="top">
						Mengetahui <br>
						Penanggung Jawab Kegiatan
						<br>
						<br>
						<br>
						<br>
						
						(<?php echo (isset($penanggungjawabs->nama) and $penanggungjawabs->nama!= "") ? $penanggungjawabs->nama : ""; ?>)
						<br>
						NIP. <?php echo isset($penanggungjawabs->nip) ? $penanggungjawabs->nip : ""; ?>
					</td>
					<td valign="top">
						Tangerang Selatan, <?php e($convert->fmtDate(date("Y-m-d"),"dd month yyyy")); ?>
						<br>
						Pelaksana Perjalanan
						<br>
						<br>
						<br>
						<br>
						(<?php echo $sppd_jabodetabek['namapegawai']; ?>)
						<br>
						NIP. <?php echo $sppd_jabodetabek['nippegawai']; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>	
</table>

  