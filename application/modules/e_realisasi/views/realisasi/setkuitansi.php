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
					<th>#</th>
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
						$rekappermak = $this->rkakl_model->viewrkakl($kdkmpnen,$kdskmpnen,$output,$kdsoutput,$kdakun);
				?>
					<?php
				 	if($urskmpnen != $rec->urskmpnen){
				 	?>
				 		 
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
				 		$kdakun = "";
					  if (isset($rekappermak) && is_array($rekappermak) && count($rekappermak)) :
						  foreach ($rekappermak as $record) :
					  ?>
					  <?php
					 if($kdakun != $record->kdakun){
					 	$kdakun = $record->kdakun;
					 ?>
					 	<tr>
						  <td colspan="5" class="label-warning">
						  <span >
						  	<?php e($record->kdakun); ?> | 
						  	<?php e($record->nmakun); ?>
						  	
						  	</span>
						  </td>
						</tr>
				 		
				 	<?php } ?>
					  <tr>
						  	<td></td>
							<td><?php echo $record->noitem; ?>. <?php echo $record->nmitem; ?></td>
							<td>
							<?php echo $record->volkeg;
							echo " X  ";
							echo $convert->ToRpnosimbol((Double)$record->hargasat); ?></td>
						   <td><?php echo $convert->ToRpnosimbol((Double)$record->jumlah); ?></td>
						   <td>
						   	<a href="#" class="sendtorkkl" kdkmpnen="<?php echo $record->kdkmpnen; ?>" kdskmpnen="<?php echo $record->kdskmpnen; ?>" kdoutput="<?php echo $record->kdoutput; ?>" kdsoutput="<?php echo $record->kdsoutput; ?>" kdakun="<?php echo $record->kdakun; ?>" nokwt="<?php echo $nokwt; ?>" noitem="<?php echo $record->noitem; ?>"> 
							  <span class='label label-info'>Tambahkan</span>
						   </a>
						   </td>
					  </tr>
					  <?php
					  	$no++;
						  endforeach;
					  else:
					  ?>
					  <tr>
						  <td colspan="5">Data Tidak ditemukan.</td>
					  </tr>
					  <?php endif; ?>
				<?php endforeach;?>
			<?php endif;?>
			
				
			</tbody>
			 
		</table>
 
<script type="text/javascript">   
$(".sendtorkkl").click(function(){
  var kdkmpnen = $(this).attr('kdkmpnen');
  var kdskmpnen = $(this).attr('kdskmpnen');
  var kdakun = $(this).attr('kdakun');
  var kdoutput = $(this).attr('kdoutput');
  var kdsoutput = $(this).attr('kdsoutput');
  var nokwt = $(this).attr('nokwt');
  var noitem = $(this).attr('noitem');
  
  var post_data = "nokwt="+nokwt+"&kdkmpnen="+kdkmpnen+"&kdskmpnen="+kdskmpnen+"&kdakun="+kdakun+"&kdoutput="+kdoutput+"&kdsoutput="+kdsoutput+"&noitem="+noitem;
	//alert("<?php echo base_url() ?>admin/realisasi/e_realisasi/savetokuitansirkakl?"+post_data);
	$.ajax({
			url: "<?php echo base_url() ?>admin/realisasi/e_realisasi/savetokuitansirkakl",
			type:"POST",
			data: post_data,
			dataType: "html",
			timeout:180000,
			success: function (result) {
				 alert(result);
				 parent.jQuery.fancybox.close();
				 parent.location.reload(true); 
		},
		error : function(error) {
			alert(error);
		} 
	});        
  return false;
});
  
</script> 