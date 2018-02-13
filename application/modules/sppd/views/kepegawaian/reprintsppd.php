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

@media print {
    body {
		 font-family: 'Arial';
		 font-size: 12px;
		 font-style: normal;
		 font-variant: normal;
		 
    }
    .transparan{
    	color:transparent;
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
	.tablemiddle td{
		padding : 3px;
	}
	.checkboxOne {
		width: 40px;
		height: 40px;
		background-color: transparent;
		color: transparent;
		border: 1px solid transparent;
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

if (isset($sppd))
{
	$sppd = (array) $sppd;
}
$id = isset($sppd['id']) ? $sppd['id'] : ''; 
?>
<table style="width:100%" border="0">
	<tr>
		<td>
			<table width="100%">
				<tr>
					<td width="50%" valign="top">
						<b>LEMBAGA ILMU PENGETAHUAN INDONESIA</b>
					</td>
					<td>
						<table border="0">
						   <tr>
							   <td width="100px">
							   	Lembar ke
							   </td>
							   <td width="10px">
							   :
							   </td>
							   <td>
							   .....................................................................
							   </td>
						   </tr>
						   <tr>
							   <td>
							   	Kode No.
							   </td>
							   <td>
							   :
							   </td>
							   <td>
							   .....................................................................
							   </td>
						   </tr>
						    <tr>
							   <td>
							   	Nomor
							   </td>
							   <td>
							   :
							   </td>
							   <td>
							   .....................................................................
							   </td>
						   </tr>
						</table>
					</td>
				</tr>
			</table>
			<br><br>
			<center><b>SURAT PERJALANAN DINAS (SPD)</b></center>
			<table border="1" width="100%" class="table">
				<tr>
					<td>
					1.
					</td>
					<td>
						Pejabat Pembuat Komitmen
					</td>
					<td>
						<?php echo $sppd['nama_pejabat']; ?>
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
						<?php echo $sppd['display_name']; ?>
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
						  <?php echo $datadetil['pangkat']; ?> <?php echo $datadetil['golongan']; ?>
					</td>
				</tr>
				<tr>
					<td>
		 
					</td>
					<td>
						b. Jabatan/Instansi
					</td>
					<td>
						  <?php echo $datadetil['jabatan']; ?>  
					</td>
				</tr>
				<tr>
					<td>
		 
					</td>
					<td>
						c. Tingkat biaya perjalanan dinas
					</td>
					<td>
						  
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
						  <?php echo $sppd['maksud']; ?>
					</td>
				</tr>
				<tr>
					<td>
					 5. 
					</td>
					<td>
						Angkutan yang dipergunakan
					</td>
					<td>
						 
						 
						<?php if(isset($sppd['angkutan']) and $sppd['angkutan']=="Dinas")
						{ 
						?>
							<b>Umum </b>						
						<?php } else { ?>
							Umum
						<?php } ?>
						 
					</td>
				</tr>
				<tr>
					<td valign="top">
					 6.  
					</td>
					<td>
						a. Tempat Berangkat
						<br>
						b. Tempat Tujuan
					</td>
					<td>
						 a. Tangerang Selatan 
						 <br>
						  b. <?php echo $sppd['prov']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top">
					 7.  
					</td>
					<td  valign="top">
						a. Lamanya perjalan dinas
						<br>
						b. Tanggal Berangkat
						<br>
						c. Tanggal harus kembali/tiba di tempat baru *)
					</td>
					<td valign="top">
						a.  <?php echo $sppd['lama'] != "" ? $sppd['lama']." Hari" : ""; ?>
						 <br>
						  <?php 
						  if($sppd['tanggal_berangkat'] != '' and $sppd['tanggal_berangkat'] != "0000-00-00")
						  {
						  	echo "b. ".$convert->fmtDate($sppd['tanggal_berangkat'],"dd month yyyy");
						  }
						  ?>
						  <br>
						  <?php 
						  if($sppd['tanggal_kembali'] != '' and $sppd['tanggal_kembali'] != "0000-00-00")
						  {
						  	echo "c. ".$convert->fmtDate($sppd['tanggal_kembali'],"dd month yyyy");
						  }
						  ?>
					</td>
				</tr>
				
				 
				<tr>
					<td valign="top">
					 8.  
					</td>
					<td>
						<table class="tablesmal">
							<tr>
								<td> Pengikut: </td>
								<td> Nama </td>
							</tr>
							<?php if (isset($data_pengikut) && is_array($data_pengikut) && count($data_pengikut)) : 
							  $no = 1;
							  foreach ($data_pengikut as $recorddetil) :

							  ?> 
							  	<tr>
							  		<td>
							  			<?php echo $no; ?>.
							  		</td>
							  		<td>
								 		<?php echo $no.". ".$recorddetil->display_name; ?>
								 	</td>
								 </tr>
							  <?php
							  $no++;
							  endforeach;
							  else:
							  ?>
							  	<tr>
							  		<td>
							  			1.
							  		</td>
							  		<td>
								 	</td>
								 </tr>
								 <tr>
							  		<td>
							  			2.
							  		</td>
							  		<td>
								 	</td>
								 </tr>
								 <tr>
							  		<td>
							  			3.
							  		</td>
							  		<td>
								 	</td>
								 </tr>
								 <tr>
							  		<td>
							  			4.
							  		</td>
							  		<td>
								 	</td>
								 </tr>
								 <tr>
							  		<td>
							  			5.
							  		</td>
							  		<td>
								 	</td>
								 </tr>
							  <?php
							  endif;
							  ?>
						</table>
					</td>
					<td valign="top">
						<table class="tablesmal" width="100%">
							<tr>
							<td width="50%"> Tanggal Lahir</td>
							<td> keterangan</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top">
					 9.  
					</td>
					<td valign="top">
						Pembebanan Anggaran<br>
						a. Instansi <br>
						b. Akun
					</td>
					<td valign="top">
						 <br>
						 a. Pusat Penelitian Sistem Mutu dan Teknologi Pengujian <br>
						 b. 
					</td>
				</tr>
				
				
				<tr>
					<td>
					 10.  
					</td>
					<td>
						Keterangan lain-lain
					</td>
					<td>
						 
					</td>
				</tr>
			</table>
			<table width="100%">
			<tr>
			<td valign="top" width="70%">
				*) Coret yang tidak perlu
			</td>
			<td>
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
						Pada Tanggal &nbsp;: 
						<?php 
							e($convert->fmtDate(date("Y-m-d"),"dd month yyyy"));
					 	?>
					</td>
					<td colspan="2">
					</td>
					
				</tr>
				 
				<tr>
					<td colspan="2">
						Pejabat Pembuat Komitmen
						<br>
						<br>
						<br>
						<br>
						<br>
					</td>
					<td valign="top">
					 
					</td>
					
				</tr>
				<tr>
					 
					<td>
						(&nbsp;
						<?php echo $sppd['nama_pejabat']; ?> 
						&nbsp;) <br>
						NIP.<?php echo $sppd['nippejabat']; ?>   
						
					</td>
				</tr>
				 
			</table>	
			</td>
			</tr>
			</table>
		</td>
		 
		
	</tr>	
</table>
<table border="0" width="100%" class="break">
	<tr>
		<td width="51%" valign="top" class="transparan">
			I.<!--Pejabat yang berwenang menerbitkan SPPD, pegawai yang <br>melakukan perjalanan dinas, para pejabat yang <br>mengesahkan tanggal berangkat/tiba, serta bendaharawan bertanggung jawab
			berdasarkan peraturan-peraturan Keuangan Negara apabila terdapat pihak yang menderita rugi adalah akibat, kesalahan, kelalaian, dan kealpaannya.
			-->
		</td>
		<td>
			<table width="100%" class="transparan">	
				<tr>
					<td width="150px">
						Berangkat dari <br>
						(Tempat Kedudukan)
					</td>
					<td width="5px">
						:
					</td>
					<td>
						Tangerang Selatan
					</td>
				</tr>
				<tr>
					<td>
						Pada tanggal 
					</td>
					<td>
						:
					</td>
					<td>
						<?php 
							e($convert->fmtDate($sppd['tanggal_berangkat'],"dd month yyyy"));
					 	?>
					</td>
				</tr>
				<tr>
					<td>
						Ke
					</td>
					<td>
						:
					</td>
					<td>
						<?php echo $sppd['prov']; ?>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						Kepala <b>Pejabat Pembuat Komitmen</b>
						<br><br><br><br><br><br>
						(&nbsp;
						<?php echo $sppd['nama_pejabat']; ?> 
						&nbsp;) <br>
						NIP.<?php echo $sppd['nippejabat']; ?>  
					</td>
					 
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%">	
				<tr>
					<td rowspan="3" valign="top" width="20px" class="transparan">
						II.
					</td>
					<td width="150px" valign="top" class="transparan">
						Tiba di
					</td>
					<td width="5px" class="transparan">
						:
					</td>
					<td>
						 <?php echo $sppd['tibadi_II']  != "0" ? $sppd['tibadi_II'] : ""; ?> 
					</td>
				</tr>
				<tr>
					<td class="transparan">
						Pada tanggal 
					</td>
					<td class="transparan">
						:
					</td>
					<td>
						
						 <?php 
						 	e($convert->fmtDate($sppd['tiba_tanggal_II'],"dd month yyyy"));
						 //echo $sppd['tiba_tanggal_II']; 
						 ?> 
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<span class="transparan">Kepala</span> <?php echo $sppd['tiba_kepala_II']  != "0" ? $sppd['tiba_kepala_II'] : ""; ?> 
						<br><br><br><br><br><br>
						<?php echo $sppd['tiba_nama_II']  != "0" ? $sppd['tiba_nama_II'] : ""; ?> 
						 <br>
						<span class="transparan">NIP.</span>
						<?php echo $sppd['tiba_nip_II']  != "0" ? $sppd['tiba_nip_II'] : ""; ?> 
					</td>
					 
				</tr>
			</table>
		</td>
		<td>
			<table width="100%">	
				<tr>
					<td width="150px" class="transparan">
						Berangkat dari
						<br>
						
					</td>
					<td width="5px" class="transparan">
						:
					</td>
					<td>
						<?php echo $sppd['berangkatdi_II']  != "0" ? $sppd['berangkatdi_II'] : ""; ?> 
					</td>
				</tr>
				<tr>
					<td class="transparan">
						Pada tanggal 
					</td>
					<td class="transparan">
						:
					</td>
					<td>
						  <?php 
						 	e($convert->fmtDate($sppd['berangkat_tanggal_II'],"dd month yyyy"));
						 //echo $sppd['tiba_tanggal_II']; 
						 ?> 
					</td>
				</tr>
				<tr>
					<td class="transparan">
						Ke
					</td>
					<td class="transparan">
						:
					</td>
					<td>
						 
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<span class="transparan">Kepala</span> 
						<?php echo $sppd['berangkat_kepala_II']  != "0" ? $sppd['berangkat_kepala_II'] : ""; ?> 
						<br><br><br><br><br><br>
						&nbsp;&nbsp;
						<?php echo $sppd['berangkat_nama_II']  != "0" ? $sppd['berangkat_nama_II'] : ""; ?> 
						<br>
						<span class="transparan">NIP.</span><?php echo $sppd['berangkat_nip_II']  != "0" ? $sppd['berangkat_nip_II'] : ""; ?> 
					</td>
					 
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%">	
				<tr>
					<td rowspan="3" valign="top" width="20px" class="transparan">
						III.
					</td>
					<td width="150px" valign="top" class="transparan">
						Tiba di
					</td>
					<td width="5px" class="transparan">
						:
					</td>
					<td>
						<?php echo $sppd['tibadi_III']  != "0" ? $sppd['tibadi_III'] : ""; ?> 
					</td>
				</tr>
				<tr>
					<td class="transparan">
						Pada tanggal 
					</td>
					<td class="transparan">
						:
					</td>
					<td>
						 <?php 
						 e($convert->fmtDate($sppd['tiba_tanggal_III'],"dd month yyyy"));
						 //echo $sppd['tiba_tanggal_III']; 
						 ?> 
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<span class="transparan">Kepala</span> <?php echo $sppd['tiba_kepala_III']  != "0" ? $sppd['tiba_kepala_III'] : ""; ?> 
						<br><br><br><br><br><br>
						<?php echo $sppd['tiba_nama_III']  != "0" ? $sppd['tiba_nama_III'] : ""; ?> 
						 <br>
						<span class="transparan">NIP.</span> <?php echo $sppd['tiba_nip_III']  != "0" ? $sppd['tiba_nip_III'] : ""; ?> 
					</td>
					
				</tr>
			</table>
		</td>
		<td>
			<table width="100%">	
				<tr>
					<td width="150px" class="transparan">
						Berangkat dari
						<br>
						
					</td>
					<td width="5px" class="transparan">
						:
					</td>
					<td>
						<?php echo $sppd['berangkatdi_III']  != "0" ? $sppd['berangkatdi_III'] : ""; ?>
					</td>
				</tr>
				<tr>
					<td class="transparan">
						Pada tanggal 
					</td>
					<td class="transparan">
						:
					</td>
					<td>
						  <?php 
						 	e($convert->fmtDate($sppd['berangkat_tanggal_III'],"dd month yyyy"));
						 //echo $sppd['tiba_tanggal_II']; 
						 ?> 
					</td>
				</tr>
				<tr>
					<td class="transparan">
						Ke
					</td>
					<td class="transparan">
						:
					</td>
					<td>
						 
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<span class="transparan">Kepala</span> <?php echo $sppd['berangkat_kepala_III']  != "0" ? $sppd['berangkat_kepala_III'] : ""; ?>
						<br><br><br><br><br><br>
						&nbsp;&nbsp;<?php echo $sppd['berangkat_nama_III']  != "0" ? $sppd['berangkat_nama_III'] : ""; ?>
						<br>
						<span class="transparan">NIP.</span><?php echo $sppd['berangkat_nip_III']  != "0" ? $sppd['berangkat_nip_III'] : ""; ?>
					</td>
					 
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%">	
				<tr>
					<td rowspan="3" valign="top" width="20px" class="transparan">
						IV.
					</td>
					<td width="150px" valign="top" class="transparan">
						Tiba di
					</td>
					<td width="5px" class="transparan">
						:
					</td>
					<td>
						 <?php echo $sppd['tibadi_IV']  != "0" ? $sppd['tibadi_IV'] : ""; ?>
					</td>
				</tr>
				<tr>
					<td class="transparan">
						Pada tanggal 
					</td>
					<td class="transparan">
						:
					</td>
					<td>
						 <?php 
						 e($convert->fmtDate($sppd['tiba_tanggal_IV'],"dd month yyyy"));
						 //echo $sppd['tiba_tanggal_III']; 
						 ?> 
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<span class="transparan">Kepala</span> <?php echo $sppd['tiba_kepala_IV']  != "0" ? $sppd['tiba_kepala_IV'] : ""; ?>
						<br><br><br><br><br><br>
						<?php echo $sppd['tiba_nama_IV']  != "0" ? $sppd['tiba_nama_IV'] : ""; ?>
						 <br>
						<span class="transparan">NIP.</span> <?php echo $sppd['tiba_nip_IV']  != "0" ? $sppd['tiba_nip_IV'] : ""; ?>
					</td>
					 
				</tr>
			</table>
		</td>
		<td>
			<table width="100%">	
				<tr>
					<td width="150px" class="transparan">
						Berangkat dari
						<br>
						
					</td>
					<td width="5px" class="transparan">
						:
					</td>
					<td>
						<?php echo $sppd['berangkatdi_IV']  != "0" ? $sppd['berangkatdi_IV'] : ""; ?>
					</td>
				</tr>
				<tr>
					<td class="transparan">
						Pada tanggal 
					</td>
					<td class="transparan">
						:
					</td>
					<td>
						  <?php 
						 	e($convert->fmtDate($sppd['berangkat_tanggal_IV'],"dd month yyyy"));
						 //echo $sppd['tiba_tanggal_II']; 
						 ?> 
					</td>
				</tr>
				<tr>
					<td class="transparan">
						Ke
					</td>
					<td class="transparan">
						:
					</td>
					<td>
						 
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<span class="transparan">Kepala</span> <?php echo $sppd['berangkat_kepala_IV']  != "0" ? $sppd['berangkat_kepala_IV'] : ""; ?>
						<br><br><br><br><br><br>
						&nbsp;&nbsp;<?php echo $sppd['berangkat_nama_IV']  != "0" ? $sppd['berangkat_nama_IV'] : ""; ?>
						<br>
						<span class="transparan">NIP.</span><?php echo $sppd['berangkat_nip_IV']  != "0" ? $sppd['berangkat_nip_IV'] : ""; ?>
					</td>
					 
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%">	
				<tr>
					<td rowspan="3" valign="top" width="20px" class="transparan">
						V.
					</td>
					<td width="150px" valign="top" class="transparan">
						Tiba di
					</td>
					<td width="5px" class="transparan">
						:
					</td>
					<td>
						<?php echo $sppd['tibadi_V']  != "0" ? $sppd['tibadi_V'] : ""; ?>
					</td>
				</tr>
				<tr>
					<td class="transparan">
						Pada tanggal 
					</td>
					<td class="transparan">
						:
					</td>
					<td>
						 <?php 
						 e($convert->fmtDate($sppd['tiba_tanggal_V'],"dd month yyyy"));
						 //echo $sppd['tiba_tanggal_III']; 
						 ?> 
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<span class="transparan">Kepala</span> <?php echo $sppd['tiba_kepala_V']  != "0" ? $sppd['tiba_kepala_V'] : ""; ?>
						<br><br><br><br><br><br>
						<?php echo $sppd['tiba_nama_V']  != "0" ? $sppd['tiba_nama_V'] : ""; ?>
						 <br>
						<span class="transparan">NIP.</span> <?php echo $sppd['tiba_nip_V']  != "0" ? $sppd['tiba_nip_V'] : ""; ?>
					</td>
					 
				</tr>
			</table>
		</td>
		<td class="transparan">
			Telah diperiksa dengan keterangan bahwa perjalanan tersebut 
						atas perhatiannya dan semata-mata untuk kepentingan jabatan 
						serta dilaksanakan dalam waktu yang sesingkat-singkatnya.
					
			<br><br>
			<b>Pejabat Pembuat Komitmen</b>
						
			<br><br><br><br><br><br>
			(&nbsp;
			 <?php echo $sppd['nama_pejabat']; ?> 
			 &nbsp;) <br>
			 NIP.<?php echo $sppd['nippejabat']; ?>  
		</td>
	</tr>
	<tr>
		<td colspan="2" class="transparan">
			<table width="100%">
				<tr>
					<td rowspan="3" valign="top" width="20px">
						VI.
					</td>
					<td>
						Catatan Lain-lain
					</td>
					
				</tr>
			</table>
			
			
		</tr>
	</tr>
	<tr>
		<td colspan="2" class="transparan">
			<table width="100%">
				<tr>
					<td rowspan="3" valign="top" width="20px">
						VII.
					</td>
					<td>
						PERHATIAN :
			PPK yang menerbitkan SPD, Pegawai yang melakukan perjalanan dinas, para pejabat yang mengesahkan tanggal berangkat/tiba, serta bendahara pengeluaran bertanggung jawab berdasarkan peraturan-peraturan keuangan negara
			apabila negara rugi akibat kesalahan, kelalaian, dan kealpaannya
					</td>
					
				</tr>
			</table>
			
			
		</tr>
	</tr>
</table>