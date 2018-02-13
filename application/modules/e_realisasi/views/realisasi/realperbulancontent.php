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
			  <th>1</th>
			  <th>2</th>
			  <th>3</th>
			  <th>4</th>
			  <th>5</th>
			  <th>6</th>
			  <th>7</th>
			  <th>8</th>
			  <th>9</th>
			  <th>10</th>
			  <th>11</th>
			  <th>12</th>
			  <th>Jumlah</th>
		  </tr>
		   
	  </thead>
	   
	  <tbody>
	  <?php
		$totalpagu = 0;
		
		$totalall = 0;
		$no = 1;
		for ($i = 1; $i <= 12; $i++) {
			$$i = 0;
		}
	  ?>
	  			<?php if (isset($masterkegiatan) && is_array($masterkegiatan) && count($masterkegiatan)):?>
				<?php foreach($masterkegiatan as $rec): 
				$totalrealisasi = 0;
				?>
					<tr>
				  	<td>
				  		<?php echo $no; ?>.
				  	</td>
				  	<td>
				  		<?php e($rec->kdgiat) ?>.<?php e($rec->kdoutput) ?>.<?php e($rec->kdsoutput) ?>.<?php e($rec->kdkmpnen) ?>.<?php e($rec->kdskmpnen) ?>| 
				  		<?php //e($rec->nmoutput) ?>
				  		
				  		<?php e($rec->urkmpnen) ?> | 
				  		<?php e($rec->urskmpnen) ?>
				  	</td>
				  	<td align="right">
				  		<?php
				  		$pagu = 0;
				  		if(isset($datapagu[$rec->kdgiat."-".$rec->kdoutput."-".$rec->kdsoutput."-".$rec->kdkmpnen."-".$rec->kdskmpnen])){
							   $pagu = (Double)$datapagu[$rec->kdgiat."-".$rec->kdoutput."-".$rec->kdsoutput."-".$rec->kdkmpnen."-".$rec->kdskmpnen];
							   $totalpagu = $totalpagu + $pagu;
						   } 
						   echo $convert->ToRpnosimbol($pagu); 
						?>
				  	</td>
				  	<?php for ($i = 1; $i <= 12; $i++) { ?>
					   <td align="right">
						 <?php
						   $realisasi = 0;
						   if(isset($datarealisasi[$rec->kdgiat."-".$rec->kdoutput."-".$rec->kdsoutput."-".$rec->kdkmpnen."-".$rec->kdskmpnen."-".$tahun."-".$i])){
							   $realisasi = (Double)$datarealisasi[$rec->kdgiat."-".$rec->kdoutput."-".$rec->kdsoutput."-".$rec->kdkmpnen."-".$rec->kdskmpnen."-".$tahun."-".$i];
							   $totalrealisasi = $totalrealisasi + $realisasi;
						   } 
						   $$i = $$i + $realisasi;
						   echo $convert->ToRpnosimbol($realisasi); 
						   ?>
					   </td>
					<?php } ?>
					<td align="right">
				  		<?php
				  			$totalall = $totalall + $totalrealisasi;
						   echo $convert->ToRpnosimbol($totalrealisasi); 
						?>
				  	</td>
				  </tr>
				<?php $no++;
				endforeach; ?>
				<?php endif; ?>
				  
			   
	  </tbody>
	  <tfoot>
		  <tr>
			<td>
			</td>
			<td>
				Total
			</td>
			<td align="right">
				<?php echo number_format($totalpagu); ?>
			</td align="right">
			<?php for ($i = 1; $i <= 12; $i++) { ?>
					<td align="right">
						<?php echo number_format($$i); ?>
					</td>
				<?php } ?>
			<td align="right">
				<?php echo number_format($totalall); ;?>
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