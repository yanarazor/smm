<?php
	$this->load->library('convert');
	$convert = new convert();
	$this->load->model('e_realisasi/rkakl_model', null, true);
?>
   <table class="table table-bordered" width="1500px" border="1">
			<thead>
				 
				<tr>
					<th>MAK</th>
					<th>Pagu</th>
					<th>Realisasi SAS</th>
					<th>Realisasi Kuitansi</th>
					<th>Sisa</th>
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
				$no = 1;
			?>
			<?php if (isset($masterkegiatans) && is_array($masterkegiatans) && count($masterkegiatans)):?>
				<?php foreach($masterkegiatans as $rec):
					$kdkmpnen = $rec->kdkmpnen;
					$kdskmpnen = $rec->kdskmpnen;
					$output = $rec->kdoutput;
					//die($output);
						$rekappermak = $this->rkakl_model->getrekappermak($kdkmpnen,$kdskmpnen,$output);
				?>
					<?php
				 	if($urskmpnen != $rec->urskmpnen){
				 	?>
				 		<?php if($no > 1) { ?>
				 		<tr>
				 			<td>
						  		<b>Jumlah</b>
						  	</td>
						  <td>
						  	<?php 
						  		
						  		echo $convert->ToRpnosimbol($paguperoutput); 
						  		
						  	?>
						  </td>
						  <td>
						  	<?php 
						  		
						  		echo $convert->ToRpnosimbol($realisasiperoutput); 
						  		
						  	?>
						  </td>
						   <td <?php if($realisasikuiperoutput > $realisasiperoutput) { ?> style="background-color: red;" <?php } ?>>
						  	<?php 
						  		
						  		echo $convert->ToRpnosimbol($realisasikuiperoutput); 
						  		
						  	?>
						  </td>
						   <td>
						  	<?php 
						  		$sisajumlah = $paguperoutput - $realisasiperoutput;
						  		echo $convert->ToRpnosimbol($sisajumlah); 
						  		
						  		$realisasikuiperoutput = 0;
						  		$paguperoutput = 0;
						  		$realisasiperoutput = 0;
						  	?>
						  </td>
						</tr>
						<?php } ?>
				 		<tr>
						  <td colspan="5" class="label-success">
						  <span >
						  	<?php 
						  		
						  		echo $rec->kdkmpnen.". ". $rec->kdskmpnen." - ".$rec->kdoutput."<br>"; 
						  		echo $rec->kdskmpnen.". ".$rec->urskmpnen; 
						  		$urskmpnen = $rec->urskmpnen;
						  	?>
						  	</span>
						  </td>
						</tr>
				 	<?php
				 	}
					  if (isset($rekappermak) && is_array($rekappermak) && count($rekappermak)) :
						  foreach ($rekappermak as $record) :
					  ?>
					  <tr>
						  <td><?php e($record->kdakun); ?> | <?php e($record->nmakun) ?></td>
						  <td>
							  <?php 
								  $totalpagu = $totalpagu + $record->pagu;
								  $paguperoutput = $paguperoutput + $record->pagu;
								  echo $convert->ToRpnosimbol($record->pagu); 
							  ?>
						  </td>
						  <td><?php 
						  	//echo $record->kdakun."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdoutput."<br>";
							  $realisasi = 0;
							  if(isset($datarealisasi[$record->kdakun."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdoutput])){
								  $realisasi = (Double)$datarealisasi[$record->kdakun."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdoutput];
								  $realisasiperoutput = $realisasiperoutput + (Double)$datarealisasi[$record->kdakun."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdoutput]; 
								  echo $convert->ToRpnosimbol((Double)$datarealisasi[$record->kdakun."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdoutput]); 
								  $totalrealisasi = $totalrealisasi + $realisasi;
							  }else{
							  	//echo $record->kdakun."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdsoutput."<br>";
							  	  if(isset($datarealisasispm[$record->kdakun."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdoutput])){
									  $realisasi = $datarealisasispm[$record->kdakun."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdoutput];
									  $realisasiperoutput = $realisasiperoutput + $datarealisasispm[$record->kdakun."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdoutput]; 
									  echo $convert->ToRpnosimbol((Double)$datarealisasispm[$record->kdakun."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdoutput]); 
									 echo " SPM";
									  $totalrealisasi = $totalrealisasi + $realisasi;
								  }else
								  echo 0;
							  }
							  
							  // kuitansi
							  $realisasikui = 0;
							  if(isset($datarealisasikuitansi[$record->kdakun."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdoutput])){
								  $realisasikui = (Double)$datarealisasikuitansi[$record->kdakun."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdoutput];
								   
							  }
							  
							  ?>
						  </td>
						  <td <?php if($realisasikui > $realisasi) { ?> class="label-warning" <?php } ?>>
						  <?php 
						
							  if(isset($datarealisasikuitansi[$record->kdakun."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdoutput])){
								  //$realisasikui = (Double)$datarealisasikuitansi[$record->kdakun."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdoutput];
								  $realisasikuiperoutput = $realisasikuiperoutput + $realisasikui; 
								  echo $convert->ToRpnosimbol($realisasikui); 
								  $totalrealisasikui = $totalrealisasikui + $realisasikui;
							  }else{
							  	
								  	echo 0;
							  }
							  ?>
						  </td>
						  <td <?php if($record->pagu < $realisasi ) { echo 'style="background-color: red;"'; }?>>
							  <?php 
								  $sisa = $record->pagu - $realisasi;
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
					  <?php endif; ?>
				<?php endforeach;?>
			<?php endif;?>
			
				
			</tbody>
			<tfoot>
				<tr>
					<td>
					</td>
					<td>
						<?php
						echo $convert->ToRpnosimbol($totalpagu); 
						?>
					</td>
					<td>
						<?php
						echo $convert->ToRpnosimbol($totalrealisasi); 
						?>
					</td>
					<td>
						<?php
						echo $convert->ToRpnosimbol($totalrealisasikui); 
						?>
					</td>
					<td>
						<?php
						$totalsisa = $totalpagu - $totalrealisasi;
						echo $convert->ToRpnosimbol($totalsisa); 
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