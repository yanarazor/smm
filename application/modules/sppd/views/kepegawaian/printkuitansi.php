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
		font-size : 12pt;
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

if (isset($sppd))
{
	$sppd = (array) $sppd;
}
$id = isset($sppd['id']) ? $sppd['id'] : ''; 
?>
 
<table style="width:100%" border="0" class="break">
	<tr>
		<td>
			<center>
			<span class="headjudul2">
			<br>
			<b>
			RINCIAN BIAYA PERJALANAN DINAS
			</b>
			 
			</span>
			</center>
			<br>
			<table border="0" width="100%">
				 
			  <tr>
				
				  <td width="200px">
					  Lampiran SPD Nomor
				  </td>
				  <td>
					  : <?php echo $sppd['nomor']; ?>
				  </td>
			  </tr>
			  <tr>
				  <td>
					  Tanggal
				  </td>
				  <td>
						: <?php 
							 e($convert->fmtDate($sppd['tgl_sp2d'],"dd month yyyy"));
						 ?>
			   </td>
		   </tr>
		   </table>
		</td>
	</tr>
</table>

<?php $jumlah = 0; ?>
<table border="1" width="100%">	 
  <tr>
	  <td width="20px">
		 No
	  </td>
	  <td>
		Perincian biaya
	  </td>
	  <td width="100px">
		 JUMLAH
	  </td>
	  <td width="200px">
		 KETERANGAN
	  </td>
  </tr>
  <tr>
	  <td>
		 1.
	  </td>
	  <td>
		Transport
	  </td>
	  <td>
		 Rp. <?php 
		 $transportreal = isset($sppd['real_transport']) ? (double)$sppd['real_transport'] : 0;
		
		 $jumlahtransport = (double)$sppd['transport'];
		 $transport = $transportreal + $jumlahtransport;
		 $jumlah = $jumlah + (double)$transport;
		  //echo $jumlah;
		 echo isset($transport) ? number_format((double)$transport) : '0'; ?>
	  </td>
	  <td>
		 <?php echo isset($sppd['ket_transport']) ? $sppd['ket_transport'] : ''; ?>
	  </td>
  </tr>
  <tr>
	  <td>
		 2.
	  </td>
	  <td>
		Uang Harian
	  </td>
	  <td>
		 Rp. <?php 
		 $jumlah = $jumlah + (double)$sppd['uang_harian'];
		 echo isset($sppd['uang_harian']) ? number_format((double)$sppd['uang_harian'], 0, '.', '.')  : '0'; ?>
	  </td>
	  <td>
		 <?php echo isset($sppd['ket_uang_harian']) ? $sppd['ket_uang_harian'] : ''; ?>
	  </td>
  </tr>
   <tr>
	  <td>
		 3.
	  </td>
	  <td>
		Biaya Penginapan
	  </td>
	  <td>
		 Rp. <?php 
		 $penginapanreal = isset($sppd['real_penginapan']) ? (double)$sppd['real_penginapan'] : 0;
		
		 
		 $jumlahpenginapan = (double)$sppd['biaya_penginapan'];
		 $penginapan = $penginapanreal + $jumlahpenginapan;
		 $jumlah = $jumlah + (double)$penginapan;
		 
		 echo isset($penginapan) ? number_format((double)$penginapan, 0, '.', '.') : '0'; ?>
	  </td>
	  <td>
		 <?php echo isset($sppd['ket_biaya_penginapan']) ? $sppd['ket_biaya_penginapan'] : ''; ?>
	  </td>
  </tr>
  <!--
  <tr>
	  <td>
		 4.
	  </td>
	  <td>
		representasi
	  </td>
	  <td>
		 Rp. <?php $jumlah = $jumlah + (double)$sppd['representasi'];
		 echo isset($sppd['representasi']) ? number_format((double)$sppd['representasi'], 0, '.', '.') : '0'; 
		 ?>
	  </td>
	  <td>
		 <?php echo isset($sppd['ket_representasi']) ? $sppd['ket_representasi'] : ''; ?>
	  </td>
  </tr>
  -->
  <tr>
	  <td>
		 4.
	  </td>
	  <td>
		<?php echo isset($sppd['ket_lain_lain']) ? $sppd['ket_lain_lain'] : ''; ?>
	  </td>
	  <td>
		 Rp. <?php 
		 $jumlah = $jumlah + (double)$sppd['lain_lain'];
		 echo isset($sppd['lain_lain']) ? number_format((double)$sppd['lain_lain'], 0, '.', '.') : '0'; 
		 ?>
	  </td>
	  <td>
		 
	  </td>
  </tr>
  <tr>
	  <td>
		 
	  </td>
	  <td>
		JUMLAH
	  </td>
	  <td>
		 Rp. <?php echo isset($jumlah) ? number_format($jumlah, 0, '.', '.') : '0'; ?>
	  </td>
	  <td>
	  </td>
  </tr>
  <tr>
  	<td	colspan="4" align="center">
  		Terbilang : <i><b>
  			<?php 
				echo ucfirst(TRIM($convert->Terbilang($jumlah)))." Rupiah";
			?>
			</i></b>
  	</td>
  </tr>
</table>
<br>
<table border="0" width="100%">
				 
				<tr>
					<td>
						
					</td>
					 <td width="100px">
					 </td>
					<td>
						Tangerang Selatan,
						<?php 
							e($convert->fmtDate($sppd['tgl_sp2d'],"dd month yyyy"));
					 	?>
					</td>
					 
				</tr>
				<tr>
					<td>
						Telah dibayar sejumlah <br>
						Rp. <?php echo isset($jumlah) ? number_format($jumlah, 0, '.', '.') : '0'; ?>
					</td>
					 <td width="100px">
					 </td>
					<td>
					 Telah Menerima jumlah uang sebesar <br>
						Rp. <?php echo isset($jumlah) ? number_format($jumlah, 0, '.', '.') : '0'; ?>
					</td>
				</tr>
				<tr>
					<td width="50%">
						
					</td>
					 <td width="100px">
					 </td>
					<td>
					 
					</td>
				</tr>
				<tr>
					<td>
						Bendahara Pengeluaran
						<br>
						<br>
						<br>
						<br>
						<br>
					</td>
					<td>
					 </td>
					<td valign="top">
					Yang menerima
					 
					</td>
					
				</tr>
				<tr>
					<td>
						<b><?php echo isset($bendaharas->nama) ? $bendaharas->nama : ""; ?><br>
						NIP. <?php echo isset($bendaharas->nip) ? $bendaharas->nip : ""; ?>
						</b>
					</td>
					<td>
					 </td>
					<td>
						<b>
						<?php echo $sppd['namapegawai']; ?>
						<br>
						NIP. <?php echo $sppd['nippegawai']; ?>   
						</b>
						
					</td>
				</tr>
				
			</table>	
<hr>
<center>
	<b>PERHITUNGAN SPD RAMPUNG</b>
</center>
<br>
<table border="0" width="100%">
	<tr>
		<td width="200px">
			Ditetapkan sejumlah
		</td>
		<td>
			: Rp. <?php echo isset($jumlah) ? number_format($jumlah, 0, '.', '.') : '0'; ?>
		</td>
	</tr>
	<tr>
		<td>
			Yang telah dibayar semula
		</td>
		<td>
			: Rp. <?php echo isset($jumlah) ? number_format($jumlah, 0, '.', '.') : '0'; ?>
		</td>
	</tr>
	<tr>
		<td>
			Sisa kurang/lebih
		</td>
		<td>
			: Rp.0
		</td>
	</tr>
</table>
<table border="0" width="100%">
			  
				<tr>
					<td width="50%">
						 
						<br>
						<br>
						<br>
						<br>
						<br>
					</td>
					 <td width="100px">
					 </td>
					<td valign="top">
					Pejabat Pembuat Komitmen,<br>
					 
					</td>
					
				</tr>
				<tr>
					<td>
						 
					</td>
					<td>
					 </td>
					<td>
						
						<?php echo isset($ppks->nama_pejabat) ? $ppks->nama_pejabat : ""; ?> <br>
						
						<?php echo isset($ppks->nip) ? "NIP. ".$ppks->nip : ""; ?>
						
					</td>
				</tr>
				 
			</table>	
			 
	 
 
 <table style="width:100%" border="0" class="break">
	<tr>
		<td>
			<center>
			<span class="headjudul2">
			<br>
			<b>
			DAFTAR PENGELUARAN RIIL
			</b>
			 
			</span>
			</center>
			<br>
			 
		</td>
	</tr>
</table> 
<table border="0" width="100%">
	   <tr>
		   <td colspan="3">
			   Yang bertanda tangan dibawah ini	:
		   </td>
	   </tr>
	   <tr>
		   <td>
		   Nama
		   </td>
		   <td width="10px">
			   :
		   </td>
		   <td>
			   <?php echo $sppd['namapegawai']; ?>
			   
		   </td>
	   </tr>
	   <tr>
		   <td>
			   NIP
		   </td>
		   <td>
			   :
		   </td>
		   <td>
				<?php echo $sppd['nippegawai']; ?>
		   </td>
	   </tr>
		
	   <tr>
		   <td>
			Jabatan
		   </td>
		   <td>
			   :
		   </td>
		   <td>
		   <?php echo $sppd['jabatan']; ?>  
						  <?php echo $sppd['jabatan_ft']; ?>   
		   </td>
	   </tr>
	   <tr>
		   <td colspan="3">
			   Berdasarkan Surat Perjalanan Dinas(SPD) Nomor : <?php echo $sppd['nomor']; ?> tanggal <?php 
							 e($convert->fmtDate($sppd['tgl_sp2d'],"dd month yyyy"));
						 ?>, dengan ini kami menyatakan dengan sesungguhnya  bahwa :
		   </td>
	   </tr>
	   <tr>
		   <td colspan="3">
			   1. Biaya transpor pegawai dan/atau biaya penginapan dibawah ini yang tidak dapat diperoleh bukti-bukti pengeluarannya, meliputi  :
		   </td>
	   </tr>
	   <tr>
	   <?php
	   	$noreal = 1;
	   ?>
	   	<td colspan="3">
	   		<table border="1" width="100%">	 
			 <tr>
				 <td width="20px">
					No
				 </td>
				 <td>
				   Perincian biaya
				 </td>
				 <td width="100px">
					JUMLAH
				 </td>
			 </tr>
			 <?php
			 	$jumlahreal = 0;
			 ?>
			 <?php if($sppd['real_transport'] != 0){ ?>
			 
			 <tr>
				 <td>
					<?php echo $noreal; 
					$noreal++;
					?>.
				 </td>
				 <td>
				    <?php echo isset($sppd['ket_real_transport']) ? $sppd['ket_real_transport'] : ""; ?>
				 </td>
				 <td width="100px" align="right">
					<?php
						$jumlahreal = $jumlahreal + (double)$sppd['real_transport'];
						echo isset($sppd['real_transport']) ? number_format((double)$sppd['real_transport'], 0, '.', '.')  : '0';
					?>
				 </td>
			 </tr>
			  <?php } ?>
			 <?php if($sppd['real_penginapan'] != 0){ ?>
			  <tr>
				 <td>
					<?php echo $noreal; ?>.
				 </td>
				 <td>
				    <?php echo isset($sppd['ket_real_penginapan']) ? $sppd['ket_real_penginapan'] : ""; ?>
				 </td>
				 <td width="100px" align="right">
					<?php
						$jumlahreal = $jumlahreal + (double)$sppd['real_penginapan'];
						echo isset($sppd['real_penginapan']) ? number_format((double)$sppd['real_penginapan'], 0, '.', '.')  : '0';
					?>
				 </td>
			 </tr>
			 <?php } ?>
			 <tr>
				 <td>
					
				 </td>
				 <td>
				    Jumlah
				 </td>
				 <td width="100px" align="right">
					<?php
						echo number_format((double)$jumlahreal, 0, '.', '.');
					?>
				 </td>
			 </tr>
			 </table>
	   	</td>
	   </tr>
	   <tr>
		   <td colspan="3">
			   2. Jumlah uang tersebut pada 1 diatas benar-benar dikeluarkan untuk pelaksanaan perjalanan dinas dimaksud dan apabila dikemudian hari terdapat kelebihan atas pembayaran, 
			   kami bersedia untuk menyetorkan  kelebihan tersebut ke Kas Negara.
			   <br>
			   Demikian pernyataan ini kami buat dengan sebenarnya, untuk dipergunakan  sebagaimana mestinya.
		   </td>
	   </tr>
   </table>
<table border="0" width="100%">
				 
				<tr>
					<td colspan="3" align="right">
						
					</td>
					 
				</tr>
				
				<tr>
					<td width="50%">
						
					</td>
					 <td width="100px">
					 </td>
					<td>
					 
					</td>
				</tr>
				<tr>
					<td>
						Mengetahui/menyetujui <br>
						Pejabat Pembuat Komitmen
						<br>
						<br>
						<br>
						<br>
						<br>
						
						
					</td>
					<td>
					 </td>
					<td valign="top">
					Tangerang Selatan,
						<?php 
							e($convert->fmtDate($sppd['tgl_sp2d'],"dd month yyyy"));
					 	?>
					 	<br>
					Pelaksana SPD
					 
					</td>
					
				</tr>
				<tr>
					<td>
						<?php echo isset($ppks->nama_pejabat) ? $ppks->nama_pejabat : ""; ?> <br>
						
						<?php echo isset($ppks->nip) ? "NIP. ".$ppks->nip : ""; ?>
					</td>
					<td>
					 </td>
					<td>
						<?php echo $sppd['namapegawai']; ?>
						<br>
						NIP. <?php echo $sppd['nippegawai']; ?>   
						
					</td>
				</tr>
				
			</table>	
   
<table style="width:100%" class="break">
	<tr>
		<td align="left" width="60%">
			<b>
			Lembaga Ilmu Pengetahuan Indonesia <br>
			Pusat Penelitian Sistem Mutu dan Teknologi Pengujian - LIPI
			</b>
		</td>
		<td>
		</td>
	</tr>
	<tr>
		<td>
		</td>
		<td>
			<br>
			<table border="0">
			 <tr>
				 <td width="250px">
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
				  <?php echo $sppd['nomor']; ?>
				 </td>
			 </tr>
		  </table>
		</td>
	</tr>
</table>
<br>
<center>K W I T A N S I </center>
<br>
<table>
	<tr>
		<td>
			Sudah diterima dari
		</td>
		<td>
			:
		</td>
		<td>
			Bendahara Pengeluaran Pusat Penelitian Sistem Mutu dan Teknologi Pengujian - LIPI
		</td>
	</tr>
	<tr>
		<td>
			Uang Sebesar
		</td>
		<td>
			:
		</td>
		<td>
			Rp. <?php echo isset($jumlah) ? number_format($jumlah, 0, '.', '.') : '0'; ?>
		</td>
	</tr>
	<tr>
		<td>
			Untuk pembayaran
		</td>
		<td>
			:
		</td>
		<td>
			Biaya Perjalanan Dinas dari Tangerang Selatan Ke <?php echo $sppd['prov']; ?>
		</td>
	</tr>
	<tr>
		<td>
			Berdasarkan SPD
		</td>
		<td>
			:
		</td>
		<td>
			Pejabat Pembuat Komitmen Pusat Penelitian Sistem Mutu dan Teknologi Pengujian - LIPI
		</td>
	</tr>
	<tr>
		<td>
			Nomor SPD
		</td>
		<td>
			:
		</td>
		<td>
			<?php echo $sppd['nomor']; ?>
		</td>
	</tr>
	<tr>
		<td>
			Tanggal
		</td>
		<td>
			:
		</td>
		<td>
			<?php echo $convert->fmtDate($sppd['tgl_sp2d'],"dd month yyyy"); ?>
		</td>
	</tr>
</table>
<table style="width:100%">
<tr>
	<td width="70%">
		 
	</td>
	<td>
	 </td>
	<td valign="top">
	Tangerang Selatan, <?php echo $convert->fmtDate($sppd['tgl_sp2d'],"dd month yyyy"); ?> <br>
	Yang menerima
	 <br><br><br><br>
	</td>
	
</tr>
<tr>
	<td>
		 
	</td>
	<td>
	 </td>
	<td>
		<?php echo $sppd['namapegawai']; ?>
		<br>
		NIP. <?php echo $sppd['nippegawai']; ?>   
		
	</td>
</tr>
</table>