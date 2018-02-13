<?php
	$this->load->library('convert');
	$convert = new convert();
?>
   <table class="table table-bordered" width="1500px" border="1">
			<thead>
				 
				<tr>
					<th width="30px" rowspan="2">No.</th>
					<th rowspan="2">Nama</th>
					<th colspan="5">izin</th>
					<th rowspan="2">Total</th>
				</tr>
				<tr>
					<th>
						TH
					</th>
					<th>
						PC
					</th>
					
					<th>
						IZN
					</th>
					<th>
						SKT
					</th>
					<th>
						LT
					</th>
				</tr>
				
				 
			</thead>
			 
			<tbody>
				<?php
				if (isset($recorduser) && is_array($recorduser) && count($recorduser)) :
					$no=1;
					$total = 0;
					
					
					foreach ($recorduser as $record) :
					$totalperpegawai =0;
				?>
				<tr>
					<td>
						<?php echo $no; ?>.
					</td>
					<td>
						[<?php echo $record->nip; ?>] <?php echo $record->display_name; ?>
						
					</td>
					<td>
					   <?php 
					   $jml3 = isset($dataizin["3_".$record->nip]) ? $dataizin["3_".$record->nip] : 0;
					   $totalperpegawai = $totalperpegawai + (int)$jml3;
					   echo isset($dataizin["3_".$record->nip]) ? $dataizin["3_".$record->nip] : ""; ?>
					</td>
					<td>
					   <?php 
					   $jml2 = isset($dataizin["2_".$record->nip]) ? $dataizin["2_".$record->nip] : 0;
					   $totalperpegawai = $totalperpegawai + (int)$jml2;
						echo isset($dataizin["2_".$record->nip]) ? $dataizin["2_".$record->nip] : ""; ?>
					</td>
					<td>
					   <?php 
					   $jml21 = isset($dataizin["21_".$record->nip]) ? $dataizin["21_".$record->nip] : 0;
					   $totalperpegawai = $totalperpegawai + (int)$jml21;
					   echo isset($dataizin["21_".$record->nip]) ? $dataizin["21_".$record->nip] : ""; ?>
					</td>
					<td>
					   <?php 
					   $jml4 = isset($dataizin["4_".$record->nip]) ? $dataizin["4_".$record->nip] : 0;
					   $totalperpegawai = $totalperpegawai + (int)$jml4;
					   echo isset($dataizin["4_".$record->nip]) ? $dataizin["4_".$record->nip] : ""; ?>
					</td>
					<td>
					   <?php 
					   $jmlI = isset($dataizin["I_".$record->nip]) ? $dataizin["I_".$record->nip] : 0;
					   $totalperpegawai = $totalperpegawai + (int)$jmlI;
					   echo isset($dataizin["I_".$record->nip]) ? $dataizin["I_".$record->nip] : ""; ?>
					</td>
					<td>
						<?php echo $totalperpegawai; ?>
					</td>
				</tr>
				
				<?php
					$no++;
					endforeach;
				else:
				?>
				<tr>
					<td colspan="66">No records found that match your selection.</td>
				</tr>
				<?php endif; ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="66">
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