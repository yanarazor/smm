<?php
	$this->load->library('convert');
	$classConvert = new Convert();
?>
<style>
 
@media print {
    body {
		font-weight:normal;
      	font-style:normal;
      	font-variant:normal;
		font-size : 9pt;
    }
	
	table {
		border-collapse: collapse;
	}
	table td {
		 
		padding: 4px;
	}
	@font-face {
		font-family: "Times New Roman", Times, serif;
		/*
		src: url('../font/DOTMATRI.eot');
		src: url('../font/DOTMATRI.eot?#iefix') format('embedded-opentype'),
			 url('../font/DOTMATRI.woff') format('woff'),
			 url('../font/DOTMATRI.ttf') format('truetype'),
			 url('../font/DOTMATRI.svg#proxima_nova_rgregular') format('svg');
			 */
		font-weight: normal;
		font-style: normal;

	}
	/* use this class to attach this font to any element i.e. <p class="fontsforweb_fontid_507">Text with this font applied</p> */
	.fontsforweb_fontid_507 {
		font-family: 'DOTMATRI' !important;
	}
	.btnprint{
		display: none;
	}
}
</style>
<br/>
<?php
	$this->load->library('convert');
	$convert = new convert();
  // Change the css classes to suit your needs
if( isset($data_pengujian) ) {
    $data_pengujian = (array)$data_pengujian;
}
$id = isset($data_pengujian['id']) ? $data_pengujian['id'] : '';
?>

 
 <div style="margin-left:0px;margin-top:-10px;"> 
 <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"id="formpengujian"'); ?>
    <table class="" border="1" width="94%">
		<tr>
			<td rowspan="4" width="100px" align="center" valign="middle">
				<img src="<?php echo base_url()."assets/images/client.png" ?>" width="70px"/>
				 
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center" valign="middle">
			FORMULIR 
			</td>
		</tr>
		<tr>
			<td width="250px">
			No. : P2SMTP-FR-TU-05
			</td>
			<td>
				Rev. : 02
			</td>
		</tr>
		<tr>
			<td>
			Tanggal : 24 Desember 2014
			</td>
			<td>
				Hal. 1 dari 1
			</td>
		</tr>
		<tr>
			<td colspan="3" align="center">
				PENERIMAAN BARANG
			</td>
			  
		</tr>
		 
		 
	</table>
	<table width="90%">
		<tr>
			<td align="right">
				Tangerang Selatan, <?php echo $classConvert->fmtDate(date("Y-m-d"),"dd month yyyy"); ?>
			</td>
		</tr>
		<tr>
			<td align="left">
				<table width="40%" border="1">
				  <tr>
					  <td align="left" height="30px">
						  No Kegiatan : <?php echo isset($permintaan_barang->kegiatan) ? $permintaan_barang->kegiatan : ""; ?>
					  </td>
				  </tr>
				  <tr>
					  <td align="left" height="30px">
						  No Order : <?php echo isset($permintaan_barang->nomor) ? $permintaan_barang->nomor : ""; ?>
					  </td>
				  </tr>
			  </table>
			</td>
		</tr>
		<tr>
			<td align="left">
				 <br>
				Kepada Yth. <br>
				Kepala BTU <br>
				Cq. Kasubbag Kepegawaian & umum
			</td>
		</tr>
		<tr>
			<td align="left">
				 <br>
				Telah diterima barang-barang sebagai berikut : 
			</td>
		</tr>
	</table>
	
	<div style="min-height:300px">
		<table border="1" width="96%">
		<tr>
			 <th width="40px"> No </th>
			 <th> NAMA BARANG </th>
			 <th> SPESIFIKASI </th>
			 <th> JUMLAH </th>
			 <th> Harga </th>
			 <th> Total </th>
			 <th> KETERANGAN </th>
		 </tr>
		<?php if (isset($data_detil) && is_array($data_detil) && count($data_detil)) : 
		  $index = 0;
		  foreach ($data_detil as $recorddetil) :
		   
		  ?> 
    	 <tr> 
			<td>
				<?php echo $index+1; ?>.
			</td>
			 
			<td width="200px" style="padding-right:20px;">
				 <?php echo $recorddetil->nama_barang; ?>
			</td>
			<td width="300px">
				<?php echo $recorddetil->spek_barang; ?>
			  </td>
			   
			  <td width="100px" align="center">
			  	<?php echo $recorddetil->jumlah_barang_ada; ?>
			  </td>
			   <td width="100px" align="right">
			  	<?php echo $convert->ToRpnosimbol($recorddetil->harga_barang); ?>
			  </td>
			   <td width="100px" align="right">
			   	<?php echo $convert->ToRpnosimbol($recorddetil->jumlah_all); ?>
			  </td>
			  <td width="200px">
					 
			  </td>
			    
		</tr>
       	<?php 
       		$index ++;
       		endforeach;
       		endif; 
       		
       		?>
    </table>
		 
	</div>
    
	 
	<br>
    <table border="0" width="96%" style="min-height:150px">
    	 
		<tr>
        	 <td width="60%" valign="top" align="left">
            	 Yang menyerahkan,
            	 <br>
            	 Bagian Gudang
            	 <br><br><br>
            	 <br><br><br> 
            	  
            	 
            	 ( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )
            	 <br>
            </td>
			 
            <td valign="top" align="center">
            	 Penerima,
            	 
            	 <br><br> <br>
            	<br><br><br>
            	 
            	 (<?php echo isset($permintaan_barang->display_name) ? $permintaan_barang->display_name : ""; ?>)
            	 <br>
            </td>
             
        </tr>
	</table>
   
	</form>
</div> 
