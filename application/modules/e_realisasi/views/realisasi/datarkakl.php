<?php
	$this->load->library('convert');
	$convert = new convert();
	$this->load->model('e_realisasi/rkakl_model', null, true);
?>
   <table class="table table-bordered" width="1500px" border="1">
			<thead>
				 
				<tr>
					<th>MAK</th>
					<th>Item</th>
					<th></th>
					<th>Pagu</th>
					<th>Realisasi</th>
					<th>Sisa</th>
				</tr>
				 
			</thead>
			 
			<tbody>
			<?php
				$totalpagu = 0;
				$totalrealisasi = 0;
				$totalrealisasikui = 0;
				$urskmpnen = "";
				$output = "";
				$nmoutput = "";
				$soutput = "";
				$paguperoutput = 0;
				$realisasiperoutput = 0;
				$realisasikuiperoutput = 0;
				$no = 1;
				$kdgiat = "";
			?>
			<?php if (isset($masterkegiatans) && is_array($masterkegiatans) && count($masterkegiatans)):?>
				<?php foreach($masterkegiatans as $rec):
					$kdkmpnen = $rec->kdkmpnen;
					$kdskmpnen = $rec->kdskmpnen;
					//$output = $rec->kdoutput;
					//echo $tahun;
						$rekappermak = $this->rkakl_model->showrkakl($tahun,$rec->kdoutput,$rec->kdsoutput,$kdkmpnen,$kdskmpnen);
						 
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
						 	
							echo $rec->kdkmpnen.". ".$rec->urkmpnen."<br>";
						 ?>
						 </span>
					   </td>
					 </tr>
					  
				 	<?php
				 	
				 		$kdakun = "";
					  if (isset($rekappermak) && is_array($rekappermak) && count($rekappermak)) :
						  foreach ($rekappermak as $record) :
					  ?>
					  <?php
					 if($kdakun != $record->kdakun){
					 	$kdakun = $record->kdakun;
					 ?>
					 	<tr>
						  <td colspan="6" class="label-warning">
						  <span>
						  	<?php e($record->kdakun); ?> | 
						  	<?php e($record->nmakun); ?>
						  	
						  	</span>
						  </td>
						</tr>
				 		
				 	<?php } ?>
					  <tr>
						  	<td></td>
							<td><?php echo $record->noitem; ?>. <?php echo $record->nmitem; ?></td>
							<td align="right">
							<?php echo $record->volkeg;
							echo " X  ";
							echo $convert->ToRpnosimbol((Double)$record->hargasat); ?></td>
						   <td align="right">
						   	<?php 
						   		$pagu = (Double)$record->jumlah;
						   		echo $convert->ToRpnosimbol((Double)$pagu); 
						   		$totalpagu = $totalpagu + $pagu;
						   	?>
						   </td>
						   <td align="right"><?php 
						  		 $real = (Double)$record->realisasipagu;
						   		echo $convert->ToRpnosimbol((Double)$real); 
						   		$totalrealisasi = $totalrealisasi + $real;
						   		?>
						   		</td>
						   	 <td align="right"><?php 
						  		 $sisa = $pagu - $real;
						   		echo $convert->ToRpnosimbol((Double)$sisa); 
						   		?>
						   		</td>
					  </tr>
					  <?php
					  	$no++;
						  endforeach;
					  else:
					  ?>
					  <tr>
						  <td colspan="6">Data Tidak ditemukan.</td>
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
						//echo $convert->ToRpnosimbol($totalpagu); 
						?>
					</td>
					<td>
						<?php
						//echo $convert->ToRpnosimbol($totalrealisasi); 
						?>
					</td>
					
					 <td align="right">
						<?php
						echo $convert->ToRpnosimbol($totalpagu); 
						?>
					</td>
					
					 <td align="right">
						<?php
						echo $convert->ToRpnosimbol($totalrealisasi); 
						?>
					</td>
					 <td align="right">
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