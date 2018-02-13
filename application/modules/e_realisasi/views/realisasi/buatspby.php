<style>
 

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
		font-size : 13pt;
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
    .spansmall {
		font-size : 5pt;
    }
	 
	table {
		border-collapse: collapse;
		
	}
	td {
		padding:5px;
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
	$this->load->model('e_realisasi/rkakl_model', null, true);
?>

<table class="table table-bordered" width="100%" border="1">
	<tr>
		<td>
			<div class="headjudul">
			<center><b>LEMBAGA ILMU PENGETAHUAN INDONESIA<BR>
			<U>PUSAT PENELITIAN SISTEM MUTU DAN TEKNOLOGI PENGUJIAN <BR>
			SURAT PERINTAH BAYAR </U>
			</b>
			<br>
			</div>
			<center>
			<table>
				<tr>
					<td>
						Tanggal : <?php echo $convert->fmtDate($kuitansidetil->tglkwt,"dd-mm-yyyy")?> 
					</td>
					<td>
						Nomor : <?php echo $kuitansidetil->nokwt; ?>
					</td>
				</tr>
			</table>
			</center>
			<br>
			<br>
		</td>
	</tr>
	<tr>
		<td>
			Saya yang bertanda tangan di bawah ini selaku Pejabat Pembuat Komitmen memerintahkan Bendahara Pengeluaran agar melakukan pembayaran sejumlah : 
			<br>
			Rp. <?php echo number_format((double)$kuitansidetil->rupiah); ?>,-
		</td>
	</tr>
	<tr>
		<td>
			(***
			<?php 
				echo ucfirst(TRIM($convert->Terbilang((double)$kuitansidetil->rupiah)))." Rupiah";
			?>
			***)
			<br>
			<br>
		</td>
	</tr>
	<tr>
		<td>
			<table border="0" class="tablemiddle"> 
				<tr>
					<td width="200px">	Kepada
					</td>
					<td> :
					</td>
					<td>
						<?php echo $kuitansidetil->nmtrim; ?> 
					</td>
				</tr>
				<tr>
					<td>Untuk Pembayaran
					</td>
					<td> :
					</td>
					<td>
						<?php echo $kuitansidetil->uraian; ?> 
					</td>
				</tr>
				<tr>
					<td>Atas dasar :
					</td>
					<td>
					</td>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>1. Kuitansi/bukti pembelian
					</td>
					<td> :
					</td>
					<td>
						<?php echo (double)$kuitansidetil->nokwt; ?> 
					</td>
				</tr>
				<tr>
					<td>2. Nota/bukti penerimaan barang/jasa/<br>(bukti lainnya)
					</td>
					<td> :
					</td>
					<td>
						-
					</td>
				</tr>
				<tr>
					<td>Dibebankan pada :
					</td>
					<td>
					</td>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>Kegiatan,output, MAK
					</td>
					<td> :
					</td>
					<td>
						<?php echo $kuitansidetil->kdgiat; ?>, 
						<?php echo $kuitansidetil->kdoutput; ?> 
					</td>
				</tr>
				<tr>
					<td>Kode
					</td>
					<td> :
					</td>
					<td>
						<?php echo $kuitansidetil->kdakun; ?> 
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		 <td>
		 	<table width="100%" border="0"> 
		 		<tr>
		 			<td align="right" colspan="3">
		 				Jakarta, <?php echo $convert->fmtDate($kuitansidetil->tanggaltransaksi,"dd-mm-yyyy")?> 
		 			</td>
		 		</tr>
				<tr>
					<td width="35%" valign="top">	
					Setuju/lunas dibayar, tanggal <?php echo $convert->fmtDate($kuitansidetil->tanggaltransaksi,"dd-mm-yyyy")?> 
					<br>
					Bendahara Pengeluaran
					<br>
					<br><br><br><br><br><br><br>
					
					Rahmawati, A. Md
					<br>
					198805142010122001
					
					<br>
					<br>
					<span class="spansmall">sn : r_spby</span>
					</td>
					<td width="35%" valign="top">	
					Diterima tanggal <?php echo $convert->fmtDate($kuitansidetil->tanggaltransaksi,"dd-mm-yyyy")?> 
					<br>
					Penerima Uang/ Uang Muka Kerja
					<br>
					<br><br><br><br><br><br><br>
					<br>
					<?php echo $kuitansidetil->nmtrim; ?> 
					</td>
					<td valign="top">
					a.n. Kuasa Pengguna Anggaran 
					<br>
					Pejabat Pembuat Komitmen
					<br>
					<br><br><br><br><br><br><br>
					<br>
					<?php
					if(trim($kuitansidetil->kdoutput) == "994"){
						echo "Ade Khaerudin Taufiq, M.Si";
					}else{
						echo "Asep Rahmat Hidayat, S.T., M.Si";
					}
					?>
					<br>
					
					<?php
					if(trim($kuitansidetil->kdoutput) == "994"){
						echo "196104161983031003";
					}else{
						echo "197409042002121004";
					}
					?> 
					</td>
				</tr>
				 
			</table>
		 </td>
	 </tr>
</table>
 