<?php
	$this->load->library('convert');
	$convert = new convert();
	$this->load->model('e_realisasi/rkakl_model', null, true);
?>
   <table class="table table-bordered" width="1500px" border="1">
			<thead>
				 
				<tr>
					<th>No</th>
					<th>Kegiatan</th>
					<th>Pagu</th>
					<th>Realisasi <br>Aplikasi SAS</th>
					<th>Realisasi <br>Kuitansi Real</th>
					<th>LS</th>
					<th>Realisasi Real</th>
					<th>Sisa <br>
					Pagu - (Realkuitansi + LS)</th>
				</tr>
				 
			</thead>
			 
			<tbody>
			<?php
				$totalpagu = 0;
				$totalrealisasi = 0;
				$totalrealisasikui = 0;
				$urskmpnen = "";
				
				$paguperoutput = 0;
				$realisasiperoutput = 0;
				$realisasikuiperoutput = 0;
				$realisasilsperoutput = 0;
				$totalrealisasils = 0;
				
				$no = 1;
			?>
			<?php if (isset($masterkegiatans) && is_array($masterkegiatans) && count($masterkegiatans)):?>
				<?php foreach($masterkegiatans as $rec):
					$kdkmpnen = $rec->kdkmpnen;
					$kdskmpnen = $rec->kdskmpnen;
				?>
				 		<tr>
				 		<td>
							 <?php echo $no; ?>.
						  </td>
						  <td>
							  <span>
								   <?php
									echo "<b>".$rec->ursoutput."</b><br>"; 
									echo $rec->kdkmpnen.".". $rec->kdskmpnen.".".$rec->kdoutput.".".$rec->kdsoutput.". ". $rec->urkmpnen."<br>"; 
										if($rec->urskmpnen != "tanpa sub komponen")
										   echo $rec->urskmpnen; 
									   	$urskmpnen = $rec->urskmpnen;
								   ?>
								</span>
						  </td>
						  <td align="right">
						  	<?php

							  $pagu = 0;
							  if(isset($datapagu[$rec->kdkmpnen."".$rec->kdskmpnen."".$rec->kdoutput])){
								  $pagu = (Double)$datapagu[$rec->kdkmpnen."".$rec->kdskmpnen."".$rec->kdoutput];
								  $totalpagu = $totalpagu + (Double)$pagu; 
							  } 
							  echo $convert->ToRpnosimbol($pagu); 
							  ?>
							  
						  </td>
						  <td align="right">
						  	<?php
							  $realisasi = 0;
							  if(isset($datarealisasi[$rec->kdkmpnen."".$rec->kdskmpnen."".$rec->kdoutput])){
								  $realisasi = (Double)$datarealisasi[$rec->kdkmpnen."".$rec->kdskmpnen."".$rec->kdoutput];
								  $realisasiperoutput = $realisasiperoutput + (Double)$datarealisasi[$rec->kdkmpnen."".$rec->kdskmpnen."".$rec->kdoutput]; 
								  $totalrealisasi = $totalrealisasi + $realisasi;
							  } 
							  echo $convert->ToRpnosimbol($realisasi); 
							  ?>
						  </td>
						  <td align="right">
						  	<?php
						  	 // kuitansi
							  $realisasikui = 0;
							  if(isset($datarealisasikuitansi[$rec->kdkmpnen."".$rec->kdskmpnen."".$rec->kdoutput])){
								  $realisasikui = (Double)$datarealisasikuitansi[$rec->kdkmpnen."".$rec->kdskmpnen."".$rec->kdoutput];
									$totalrealisasikui= $totalrealisasikui +  $realisasikui;
							  }
							  echo $convert->ToRpnosimbol($realisasikui); 
							  ?>
						  </td>
						  <td align="right">
						  	<?php
						  	 // kuitansi
							  $realisasils = 0;
							  if(isset($datarealisasils[$rec->kdkmpnen."".$rec->kdskmpnen."".$rec->kdoutput])){
								  $realisasils = (Double)$datarealisasils[$rec->kdkmpnen."".$rec->kdskmpnen."".$rec->kdoutput];
								  $totalrealisasils= $totalrealisasils +  $realisasils;
							  }
							  echo $convert->ToRpnosimbol($realisasils); 
							  ?>
						  </td>
						  <td align="right">
						  	<?php
								$real = $realisasikui + $realisasils;  
							  	echo $convert->ToRpnosimbol($real); 
							?>
						  </td>
						  <td align="right">
						  	<?php
								$sisa = $pagu - ($realisasikui + $realisasils);  
							  	echo $convert->ToRpnosimbol($sisa); 
							?>
						  </td>
						  
						</tr>
				 	<?php
				 		$no++;
					   endforeach;?>
			<?php endif;?>
			
				 
				 		 
					
			</tbody>
			<tfoot>
				<tr>
					<td>
					</td>
					<td>
					</td>
					<td align="right">
						<?php
						echo $convert->ToRpnosimbol($totalpagu); 
						
						?>
					</td>
					<td align="right">
						<?php
						echo $convert->ToRpnosimbol($totalrealisasi); 
						$persentasisas = $totalrealisasi /$totalpagu*100;
						echo " (".round($persentasisas,2)."%)";
						?>
					</td>
					<td align="right">
						<?php
						echo $convert->ToRpnosimbol($totalrealisasikui); 
						$persentasikui = $totalrealisasikui /$totalpagu*100;
						echo " (".round($persentasikui,2)."%)";
						?>
					</td>
					<td align="right">
						<?php
						echo $convert->ToRpnosimbol($totalrealisasils); 
						$persentasils = $totalrealisasils /$totalpagu*100;
						echo " (".round($persentasils,2)."%)";
						?>
					</td>
					<td align="right">
						<?php
						$totalreal = $totalrealisasikui + $totalrealisasils;
						echo $convert->ToRpnosimbol($totalreal); 
						
						$persentasiall = ($totalreal) /$totalpagu*100;
						echo  "<br>(".round($persentasiall,2)."%)";
						?>
					</td>
					<td align="right">
						<?php
						$totalsisa = $totalpagu - $totalreal;
						echo $convert->ToRpnosimbol($totalsisa); 
						
						$persentasiall = $totalreal/$totalpagu*100;
						
						?>
					</td>
				</tr>
			</tfoot>
		</table>
 
<script type="text/javascript">   
  $(".fancy").fancybox({
		  'overlayShow'	: true,
		  'transitionIn'	: 'elastic',
		  'transitionOut'	: 'elastic', 
		  'onClosed'           : function(){},
		  'type':'iframe',
		  'width':'300',
		  'height':'400'
	  });  
</script> 