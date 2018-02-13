<?php
	$this->load->library('convert');
	$convert = new convert();
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
				if (isset($rekappermak) && is_array($rekappermak) && count($rekappermak)) :
					foreach ($rekappermak as $record) :
				?>
				<tr>
					<td><?php e($record->kdakun); ?> | <?php e($record->nmakun) ?></td>
					<td>
						<?php 
							$totalpagu = $totalpagu + $record->pagu;
							echo $convert->ToRpnosimbol($record->pagu); 
						?>
					</td>
					<td><?php 
						$realisasi = 0;
						if(isset($datarealisasi[$record->kdakun."".$record->kdkmpnen."".$record->kdskmpnen])){
							$realisasi = $datarealisasi[$record->kdakun."".$record->kdkmpnen."".$record->kdskmpnen];
							echo $convert->ToRpnosimbol($datarealisasi[$record->kdakun."".$record->kdkmpnen."".$record->kdskmpnen]); 
							$totalrealisasi = $totalrealisasi + $realisasi;
						}else{
							echo 0;
						}
						?>
					</td>
					<td><?php 
						
						if(isset($datarealisasikuitansi[$record->kdakun."".$record->kdkmpnen."".$record->kdskmpnen])){
							$realisasikui = $datarealisasikuitansi[$record->kdakun."".$record->kdkmpnen."".$record->kdskmpnen];
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
					endforeach;
				else:
				?>
				<tr>
					<td colspan="4">Data Tidak ditemukan.</td>
				</tr>
				<?php endif; ?>
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