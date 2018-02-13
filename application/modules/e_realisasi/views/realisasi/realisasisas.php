<?php
	$this->load->library('convert');
	$convert = new convert();
	$this->load->model('e_realisasi/rkakl_model', null, true);
	$this->load->model('e_realisasi/kmpnen_model', null, true);
?>
<style>
 
@media print {
	.break { page-break-before: always; }
    body {
		font-weight:normal;
      	font-style:normal;
      	font-variant:normal;
		font-size : 9pt;
		line-height:20px;
    }
	.break { page-break-after: always; }
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
	 
   table {
	 border-collapse: collapse;
   }
   	.detil table {
           border-collapse: collapse;
           width:99%;
        }
        table .detil 
        {
            font-family: Arial;
		    font-weight:normal;
            font-style:normal;
            font-variant:normal;
		    font-size : 9pt;
            border: 1px solid #030303;
            padding: 4px;
            text-align: left;
        }
        th,td .detil {
          border: 1px solid #030303;
          padding: 4px;
           
        }
        .detil td,th {
          border: 1px solid #030303;
          padding: 4px;
           
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
   <table class="table table-bordered detil" width="100%" border="1">
			<thead>
				 
				<tr>
					<th>MAK</th>
					<th>Pagu</th>
					<th>Realisasi <br>Aplikasi SAS</th>
					<th>Realisasi <br>Kuitansi Real</th>
					<th>LS</th>
					<th>Realisasi Real <br>
					(Realkuitansi + LS)</th>
					<th>Sisa <br>
					Pagu - Realisasi Real
						<div class="pull-right">
							<a class="btn btn-danger btnprint" target="_blank" href="<?php echo base_url(); ?>admin/realisasi/e_realisasi/realisasisas/print/?output=<?php echo $output; ?>&key=<?php echo $key; ?>&varmak=<?php echo $varmak; ?>"><i class="fa fa-print"></i> Cetak</a>
						</div>
					</th>
				</tr>
				 
			</thead>
			 
			<tbody>
			<tr>
				<td>
					Total
				</td>
				<td>
					<div id="divtotalpagu"></div>
				</td>
				<td>
					<div id="divtotalrealisasi"></div>
				</td>
				<td>
					<div id="divtotalrealisasikui"></div>
				</td>
				<td>
					<div id="divtotalrealisasils"></div>
				</td>
				<td>
					<div id="divtotalrealisasireal"></div>
				</td>
				<td>
					<div id="divtotalrealisasisisa"></div>
				</td>
			</tr>
			<?php
				$totalpagu = 0;
				$totalrealisasi = 0;
				$totalrealisasikui = 0;
				$totalrealisasireal = 0;
				$urskmpnen = "";
				$komponen = "";
				
				$paguperoutput = 0;
				$realisasiperoutput = 0;
				$realisasikuiperoutput = 0;
				$realisasilsperoutput = 0;
				$realisasirealperoutput = 0;
				$totalrealisasils = 0;
				
				$kdgiat = "";
				$nmoutput = "";
				$soutput = "";
				$no = 1;
				//print_r($masterkegiatans);
			?>
			<?php if (isset($masterkegiatans) && is_array($masterkegiatans) && count($masterkegiatans)):?>
				<?php foreach($masterkegiatans as $rec):
					$kdoutput = $rec->kdoutput;
					$tahun = $rec->thang;
					//echo $tahun;
					$kdsoutput = $rec->kdsoutput;
					$recordkomponen = $this->kmpnen_model->getkomponen($tahun,$kdgiat,$kdoutput,$kdsoutput);
					//print_r($recordkomponen);
					
				?>
				
				<?php 
				$kdskmpnen = "";
				if (isset($recordkomponen) && is_array($recordkomponen) && count($recordkomponen)):?>
				<?php foreach($recordkomponen as $reckomponen):
					$kdkmpnen = $reckomponen->kdkmpnen;
					$urkmpnen = $reckomponen->urkmpnen;	
				?>
					<tr>
					   <td colspan="7" class="label-success">
					   <span>
						 <?php 
						 	if($kdgiat != $rec->kdgiat){
						 		 
						 		$kdgiat = $rec->kdgiat;
						 	}
						 	if($nmoutput != $rec->nmoutput){
						 		echo $rec->kdgiat.".".$rec->kdoutput." ".$rec->nmoutput."<br>"; 
						 		$nmoutput = $rec->nmoutput;
						 	}
						 	if($soutput != $rec->ursoutput){
						 		echo $rec->kdgiat.".".$rec->kdoutput.".".$rec->kdsoutput." ".$rec->ursoutput."<br>"; 
						 		$soutput = $rec->ursoutput;
						 	}
						 	
							echo $reckomponen->kdkmpnen.". ".$reckomponen->urkmpnen."<br>";
						 ?>
						 </span>
					   </td>
					 </tr>
				<?php
				$rekappermak = $this->rkakl_model->rekappermak($tahun,$kdgiat,$kdoutput,$kdsoutput,$kdkmpnen,$kdskmpnen,$varmak);
				//print_r($rekappermak);
				if (isset($rekappermak) && is_array($rekappermak) && count($rekappermak)) :
						  foreach ($rekappermak as $record) :
					  ?>
					  <tr>
						  <td> 
						  <?php e($record->kdakun); ?> | <?php e($record->nmakun) ?>
						  </td>
						  <td align="right">
							  <?php 
							  	$sisa = 0;
								  $totalpagu = $totalpagu + $record->pagu;
								  $paguperoutput = $paguperoutput + $record->pagu;
								  echo $convert->ToRpnosimbol($record->pagu); 
							  ?>
							  
						  </td>
						  <td align="right"><?php 
						  	//echo "(".$record->kdskmpnen.")<br>";
							  $realisasi = 0;
							 
							  
							  if(isset($datarealisasi[$kdgiat."".$record->kdoutput."".$record->kdsoutput."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdakun])){
								  $realisasi = (Double)$datarealisasi[$kdgiat."".$record->kdoutput."".$record->kdsoutput."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdakun];
								  $realisasiperoutput = $realisasiperoutput + (Double)$datarealisasi[$kdgiat."".$record->kdoutput."".$record->kdsoutput."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdakun]; 
								  echo $convert->ToRpnosimbol((Double)$datarealisasi[$kdgiat."".$record->kdoutput."".$record->kdsoutput."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdakun]); 
								  $totalrealisasi = $totalrealisasi + $realisasi;
							  }
							  
							  // kuitansi
							  $realisasikui = 0;
							  if(isset($datarealisasikuitansi[$kdgiat."".$record->kdoutput."".$record->kdsoutput."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdakun])){
								  $realisasikui = (Double)$datarealisasikuitansi[$kdgiat."".$record->kdoutput."".$record->kdsoutput."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdakun];
								   
							  }
							  //echo "<br>".$kdgiat."".$record->kdoutput."".$record->kdsoutput."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdakun;
							  ?>
						  </td>
						  <td <?php if($realisasikui > $realisasi) { ?> class="label-warning" <?php } ?> align="right">
						   
						  <?php 
						 
						  	//echo " SO ".$record->kdsoutput;
							//echo "GT".$kdgiat." KDO ".$record->kdoutput." SO ".$record->kdsoutput." K ".$record->kdkmpnen." sk ".$record->kdskmpnen." akun :".$record->kdakun;
							  if(isset($datarealisasikuitansi[$kdgiat."".$record->kdoutput."".$record->kdsoutput."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdakun])){
								  //$realisasikui = (Double)$datarealisasikuitansi[$record->kdakun."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdoutput];
								  $realisasikuiperoutput = $realisasikuiperoutput + $realisasikui; 
								  echo $convert->ToRpnosimbol($realisasikui); 
								  $totalrealisasikui = $totalrealisasikui + $realisasikui;
							  }else{
							  	
								  	echo 0;
							  }
							  ?>
						  </td>
						  <td align="right">
							<?php 
							$realisasils = 0;
							 if(isset($datarealisasils[$kdgiat."".$record->kdoutput."".$record->kdsoutput."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdakun])){
								  $realisasils = (Double)$datarealisasils[$kdgiat."".$record->kdoutput."".$record->kdsoutput."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdakun];
								  $realisasilsperoutput = $realisasilsperoutput + (Double)$datarealisasils[$kdgiat."".$record->kdoutput."".$record->kdsoutput."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdakun]; 
								  echo $convert->ToRpnosimbol((Double)$datarealisasils[$kdgiat."".$record->kdoutput."".$record->kdsoutput."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdakun]); 
								  $totalrealisasils = $totalrealisasils + $realisasils;
							  }
							   else{
							  	
								  	echo 0;
							  }
							  ?>
 							   
						  </td>
						  <td align="right">
						  <?php 
								$realisasireal = 0;
								$realisasireal = $realisasikui + $realisasils;
							 	$realisasirealperoutput = $realisasirealperoutput + $realisasireal; 
								echo $convert->ToRpnosimbol($realisasireal); 
								$totalrealisasireal = $totalrealisasireal + $realisasireal;
							  ?>
						  </td>
						  
						  
						  <td <?php if($record->pagu > ($realisasireal) ) { echo 'style="background-color: Yellow;"'; }?> align="right">
							  <?php 
								  $sisa = $record->pagu - $realisasireal;
								  echo $convert->ToRpnosimbol($sisa); 
							  ?>
						  </td>
					  </tr>
					  <?php
					  	$no++;
						  endforeach;
					 else:
					  ?>
					  <tr>
						  <td colspan="4">Data Tidak ditemukan.</td>
					  </tr>
					  <?php
					  endif; ?>
				<?php endforeach; ?>
				<?php endif; ?>
					<?php
				 	if($urkmpnen != $reckomponen->urkmpnen or $kdkmpnen != $reckomponen->kdkmpnen){
				 	?>
				 		<?php if($no > 1) { ?>
				 		<tr>
				 			<td align="right">
						  		<b>Jumlah</b>
						  	</td>
						  <td align="right">
						  	<?php 
						  		
						  		echo $convert->ToRpnosimbol($paguperoutput); 
						  		
						  	?>
						  </td>
						  <td align="right">
						  	<?php 
						  		
						  		echo $convert->ToRpnosimbol($realisasiperoutput); 
						  		
						  	?>
						  </td>
						   <td <?php if($realisasikuiperoutput > $realisasiperoutput) { ?> style="background-color: red;" <?php } ?> align="right">
						  	<?php 
						  		
						  		echo $convert->ToRpnosimbol($realisasikuiperoutput); 
						  		
						  	?>
						  </td>
						   <td align="right">
						  	<?php 
						  		
						  		echo $convert->ToRpnosimbol($realisasilsperoutput); 
						  		
						  	?>
						  </td>
						   <td align="right">
						  	<?php 
						  		
						  		echo $convert->ToRpnosimbol($realisasirealperoutput); 
						  		
						  	?>
						  </td>
						  
						   <td align="right" <?php if($paguperoutput > ($paguperoutput - $realisasiperoutput) ) { echo 'style="background-color: Yellow;"'; }?>>
						  	<?php 
						  		$sisajumlah = $paguperoutput - $realisasirealperoutput;
						  		echo $convert->ToRpnosimbol($sisajumlah); 
						  		$realisasikuiperoutput = 0;
						  		$paguperoutput = 0;
						  		$realisasiperoutput = 0;
						  		$realisasilsperoutput = 0;
						  		$realisasirealperoutput = 0;
						  	?>
						  </td>
						</tr>
						<?php } ?>
				 		<tr>
						  <td colspan="7" class="label-success">
						  <span >
						  	<?php 
						  		echo $rec->kdgiat.".".$rec->kdoutput." ".$rec->nmoutput."<br>"; 
						  		echo $rec->kdkmpnen.". ".$rec->urkmpnen."<br>"; 
						  		echo $rec->kdkmpnen.". ".$rec->urkmpnen; 
						  		$urskmpnen = $rec->urskmpnen;
						  		$komponen = $kdkmpnen;
						  	?>
						  	</span>
						  </td>
						</tr>
				 	<?php
				 	}
					endforeach;?>
			<?php endif;?>
			
				 
				 		<?php if($no > 1) { ?>
				 		<tr>
				 			<td align="right">
						  		<b>Jumlah</b>
						  	</td>
						  <td align="right">
						  	<?php 
						  		
						  		echo $convert->ToRpnosimbol($paguperoutput); 
						  		
						  	?>
						  </td>
						  <td align="right">
						  	<?php 
						  		
						  		echo $convert->ToRpnosimbol($realisasiperoutput); 
						  		
						  	?>
						  </td>
						   <td <?php if($realisasikuiperoutput > $realisasiperoutput) { ?> style="background-color: red;" <?php } ?> align="right">
						  	<?php 
						  		
						  		echo $convert->ToRpnosimbol($realisasikuiperoutput); 
						  		
						  	?>
						  </td>
						   <td align="right">
						  	<?php 
						  		
						  		echo $convert->ToRpnosimbol($realisasilsperoutput); 
						  		
						  	?>
						  </td>
						   <td align="right">
						  	<?php 
						  		
						  		echo $convert->ToRpnosimbol($realisasirealperoutput); 
						  		
						  	?>
						  </td>
						   <td align="right" <?php if($paguperoutput > ($paguperoutput - $realisasiperoutput) ) { echo 'style="background-color: Yellow;"'; }?>>
						  	<?php 
						  		$sisajumlah = $paguperoutput - $realisasirealperoutput;
						  		echo $convert->ToRpnosimbol($sisajumlah); 
						  		
						  		$realisasikuiperoutput = 0;
						  		$paguperoutput = 0;
						  		$realisasiperoutput = 0;
						  		$realisasilsperoutput = 0;
						  		$realisasirealperoutput = 0;
						  	?>
						  </td>
						</tr>
						<?php } ?>
					
			</tbody>
			<tfoot>
				<tr>
					<td>
					</td>
					<td align="right">
						<?php
						echo $convert->ToRpnosimbol($totalpagu); 
						?>
					</td>
					<td align="right">
						<?php
						$persentasisas = 0;
						echo $convert->ToRpnosimbol($totalrealisasi); 
						if($totalrealisasi != 0 and $totalpagu != 0)
						$persentasisas = $totalrealisasi /$totalpagu*100;
						
						echo " (".round($persentasisas,2)."%)";
						?>
					</td>
					<td align="right">
						<?php
						$persentasikui = 0;
						echo $convert->ToRpnosimbol($totalrealisasikui); 
						if($totalrealisasikui != 0 and $totalpagu != 0)
						$persentasikui = $totalrealisasikui /$totalpagu*100;
						echo " (".round($persentasikui,2)."%)";
						?>
					</td>
					<td align="right">
						<?php
						$persentasils = 0;
						echo $convert->ToRpnosimbol($totalrealisasils); 
						if($totalrealisasils != 0 and $totalpagu != 0)
						$persentasils = $totalrealisasils /$totalpagu*100;
						echo " (".round($persentasils,2)."%)";
						?>
					</td>
					<td align="right">
						<?php
						$persentasiall = 0;
						echo $convert->ToRpnosimbol($totalrealisasireal); 
						if($totalrealisasireal != 0 and $totalpagu != 0)
						$persentasiall = ($totalrealisasireal) /$totalpagu*100;
						echo " (".round($persentasiall,2)."%)";
						?>
					</td>
					<td align="right">
						<?php
						$totalsisa = $totalpagu - $totalrealisasireal;
						echo $convert->ToRpnosimbol($totalsisa); 
						?>
					</td>
					
				</tr>
			</tfoot>
		</table>
 
<script type="text/javascript">   
 
	 $("#divtotalpagu").html("<?php echo $convert->ToRpnosimbol($totalpagu); ?>");
	 $("#divtotalrealisasi").html("<?php echo $convert->ToRpnosimbol($totalrealisasi); echo " (".round($persentasisas,2)."%)"; ?>");
	 $("#divtotalrealisasikui").html("<?php echo $convert->ToRpnosimbol($totalrealisasikui); echo " (".round($persentasikui,2)."%)"; ?>");
	 $("#divtotalrealisasils").html("<?php echo $convert->ToRpnosimbol($totalrealisasils); echo " (".round($persentasils,2)."%)"; ?>");
	 $("#divtotalrealisasireal").html("<?php echo $convert->ToRpnosimbol($totalrealisasireal); echo " (".round($persentasiall,2)."%)"; ?>");
		 
</script> 