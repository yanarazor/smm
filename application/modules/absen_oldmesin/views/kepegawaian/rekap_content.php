<?php
	$this->load->library('convert');
	$convert = new convert();
?>
   <table class="table table-bordered" width="1500px" border="1">
			<thead>
				 
				<tr>
					<th width="50px" rowspan="2">No.</th>
					<th rowspan="2">Nama</th>
					 
					<?php
						$jmlhari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); // 31
						$jmlhari = $jmlhari +1;
						for($i=1;$i<$jmlhari;$i++){
							$tgl = $i;
							if($i < 10){
								$tgl = "0".$i;
							}
								$mydate = $tahun.'-'.$bulan.'-'.$tgl;
								$hari = date('l', strtotime($mydate));
							?>
							  <th colspan="2" <?php if($hari == "Saturday" or $hari == "Sunday") { ?> style="background-color: red;" <?php } ?>>
								  <?php e($i) ?><br>
								  <?php 
								  	//echo $mydate;
									echo $hari;
								  ?>
							  </th>
						  <?php
						}
					?>
					<th rowspan="2">Total</th>
				</tr>
				<tr>
					<?php
						for($i=1;$i<$jmlhari;$i++){
							?>
							  <th>
								  M
							  </th>
							  <th>
								  P
							  </th>
						  <?php
						}
					?>
				</tr>
			</thead>
			 
			<tbody>
				<?php
				if (isset($recorduser) && is_array($recorduser) && count($recorduser)) :
					$no=1;
					$total = 0;
					$totalblmbayar =0;
					$potonganpulang = 0;
					$jmlpotonganpulang = 0;
					$jmlpotongan = 0;
					$jmlmenit = 0;
					foreach ($recorduser as $record) :
				?>
				<tr>
					<td>
						<?php echo $no; ?>
					</td>
					<td>
						<?php echo $record->display_name; ?><br>
						<?php echo $record->nip; ?>
					</td>
					 <?php
					 	$kekurangan = 0;
						 for($i=1;$i<$jmlhari;$i++){
						 	
						 	if($i<10)
						 		$numtgl = "0".$i;
						 	else
						 		$numtgl = $i;

						 	$tgl = $i;
						 	if($i < 10){
								$tgl = "0".$i;
							}
								$mydate = $tahun.'-'.$bulan.'-'.$tgl;
								$hari 	= date('l', strtotime($mydate));
								$today 	= date("Y-m-d");
								$today_time = strtotime($today);
								$expire_time = strtotime($mydate);
								
							?>
							   
							   <td <?php if($hari == "Saturday" or $hari == "Sunday") { ?> style="background-color: red;" <?php } ?> <?php if(isset($dataharilibur[$tahun."-".$bulan."-".$numtgl])) { ?> style="background-color: yellow;" <?php } ?>>
								  <?php
								  if(isset($dataabsen['M_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip])){
									   echo $dataabsen['M_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip];
								   }else{
								   		if(!isset($dataharilibur[$tahun."-".$bulan."-".$numtgl]) and ($hari != "Saturday" and $hari != "Sunday")) {
								   			if ($expire_time < $today_time)
									   			echo "M";
								   		}
								   }
								// glading tima
								if(!isset($dataizin['izin_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]) and isset($dataabsen['P_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]))
								  {
								  	// jika ada jam masuk dan jam pulang dan tidak ada izin
								  		echo "<br>";
								  		echo isset($dataabsen['G_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]) ? "[".$dataabsen['G_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]."]" : "-";
								  				
								  }
								  
								   
								  ?>
							   </td>
							   <td <?php if($hari == "Saturday" or $hari == "Sunday") { ?> style="background-color: red;" <?php } ?> <?php if(isset($dataharilibur[$tahun."-".$bulan."-".$numtgl])) { ?> title="<?php echo $dataharilibur[$tahun."-".$bulan."-".$numtgl]; ?>" style="background-color: yellow;" <?php } ?>>
								  <?php
								  // jam pulang
								  if(isset($dataabsen['P_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip])){
									   echo $dataabsen['P_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip];
									   
									   // glading time
									 if(!isset($dataizin['izinp_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]) and isset($dataabsen['P_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]))
									   {
										 	//jika ada jam masuk dan jam pulang dan tidak ada izin
											echo "<br>";
											$kurang = isset($dataabsen['GP_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]) ? $dataabsen['GP_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip] : 0;
											$kekurangan = (int)$kekurangan + $kurang;
											$menitlebih = isset($dataabsen['ML_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]) ? $dataabsen['ML_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip] : 0;
											
											//echo isset($dataabsen['GP_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]) ? "[".$dataabsen['GP_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]."]" : "-";
											echo "[".$kekurangan."]";
											echo "/";	
											
											echo "[".$menitlebih."]";
											if($kekurangan > $menitlebih){
									   			$kekurangan = ($kekurangan - $menitlebih);
									   		}else{
									   			$kekurangan = 0;
									   		}
											$minutes = $kekurangan;
									   		
									   		if((int)$minutes > 0)
											{
												$potongan = 0;
												//$pulangcepat['PPC_'.$record->tanggal."_".$record->nik] = $minutes;
							
												if($minutes < 31 and $minutes > 9)
													$potongan = 0.5;
												if($minutes>=31 and $minutes <=60)
													$potongan = 1;
												if($minutes>=61 and $minutes <=90)
													$potongan = 1.5;
												if($minutes>=91)
													$potongan = 2;
							
												//echo  $potongan."<br>";
												$pulangcepat['PP_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip] = $potongan;
												$pulangcepat['PM_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip] = $minutes;						
											}
						
									   }								  
								   }else{
								   		if(!isset($dataharilibur[$tahun."-".$bulan."-".$numtgl]) and ($hari != "Saturday" and $hari != "Sunday")) {
								   			if ($expire_time < $today_time)
								   				echo "M";
								   		}
								   }
								   
								   if($hari == "Friday"){
										$kekurangan = 0;
								   }

								  ?>
							   </td>
						   <?php
						 }
					 ?>
					 <td>
					 </td>
				</tr>
				<tr>
					<td>
						 
					</td>
					<td align="right">
						Jml Potongan
					</td>
					 <?php
					 	
						 for($i=1;$i<$jmlhari;$i++){
						 	if($i<10)
						 		$numtgl = "0".$i;
						 	else
						 		$numtgl = $i;
						 	$tgl = $i;
						 	if($i < 10){
								$tgl = "0".$i;
							}
						 	$mydate = $tahun.'-'.$bulan.'-'.$tgl;
							$hari = date('l', strtotime($mydate));
							
							$today = date("Y-m-d");

							$today_time = strtotime($today);
							$expire_time = strtotime($mydate);	 
							 ?>
							   <td>
								  <?php
								  if(isset($datangterlambat1['PT_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip])){
									   echo $datangterlambat1['PT_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip];
									   $jmlpotongan = $jmlpotongan + (double)$datangterlambat1['PT_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip];
								   		//echo $jmlpotongan." potongan";
								   }
								   else{
								   		if(!isset($dataabsen['M_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]) and !isset($dataharilibur[$tahun."-".$bulan."-".$numtgl])){
											if ($expire_time < $today_time and ($hari != "Saturday" and $hari != "Sunday"))
											{
												$potongan = 2;
												if(!isset($dataabsen['M_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]) and !isset($dataabsen['P_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]))
													$potongan = 2.5;
												
												echo $potongan;	
												$jmlpotongan = $jmlpotongan + $potongan;
											}
										 }else{
								   			echo 0;
								   		}
								   }
								  ?>
							   </td>
							   <td align="center">
								  <?php
								  
								   		if(isset($pulangcepat['PP_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip])){
											echo $pulangcepat['PP_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip];
											$potonganpulang = (double)$pulangcepat['PP_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip];
										}else{
											 if(!isset($dataabsen['P_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]) and !isset($dataharilibur[$tahun."-".$bulan."-".$numtgl])){
												  if ($expire_time < $today_time and ($hari != "Saturday" and $hari != "Sunday"))
												  {
												  		$potongan = 2;
														if(!isset($dataabsen['M_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]) and !isset($dataabsen['P_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]))
															$potongan = 2.5;
													
												  		echo $potongan;
														$jmlpotongan = $jmlpotongan + $potongan;
													}
											  }else{
												   echo 0;
											  }
										 
										}
								   	if($hari == "Friday"){
								   		$jmlpotonganpulang = $jmlpotonganpulang + $potonganpulang;
										$potonganpulang = 0;
								   	}
								  ?>
							   </td>
						   <?php
						 }
					 ?>
					 <td>
					 <?php 
					 	$jmlperorang = $jmlpotonganpulang + $jmlpotongan;
					 	echo $jmlperorang; 
					 	//echo "M ".$jmlpotongan;
					 //	echo "<br>";
					 	//echo "P ".$jmlpotonganpulang;
					 	$jmlpotongan = 0;
					 	$jmlpotonganpulang = 0;
					 ?>
					 </td>
				</tr>
				<tr>
					<td align="right">
						 
					</td>
					<td align="right">
						 Jml Menit Terlambat
					</td>
					 <?php
						 for($i=1;$i<$jmlhari;$i++){
						 	if($i<10)
						 		$numtgl = "0".$i;
						 	else
						 		$numtgl = $i;
						 		
						 		$tgl = $i;
								if($i < 10){
									$tgl = "0".$i;
								}
							
						 		$mydate = $tahun.'-'.$bulan.'-'.$tgl;
								$hari = date('l', strtotime($mydate));
								
								$today = date("Y-m-d");

								$today_time = strtotime($today);
								$expire_time = strtotime($mydate);
							 ?>
							   <td>
								  <?php
								  if(isset($datangterlambat1['DT_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip])){
									   echo $datangterlambat1['DT_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip];
									   $jmlmenit = $jmlmenit + (double)$datangterlambat1['DT_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip];
								   }else{
								   		if(!isset($dataabsen['M_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]) and !isset($dataharilibur[$tahun."-".$bulan."-".$numtgl])){
											if ($expire_time < $today_time and ($hari != "Saturday" and $hari != "Sunday"))
											{
												$menitpotongan = 225;
												echo $menitpotongan;	
											}
										 }else{
								   			echo 0;
								   		}
								   }
								  ?>
							   </td>
							  <td align="center">
								  <?php
								  if(isset($pulangcepat['PM_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip])){
									   echo $pulangcepat['PM_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip];
									   $jmlmenit = $jmlmenit + (double)$pulangcepat['PM_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip];
								   }else{
								   		 if(!isset($dataabsen['P_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]) and !isset($dataharilibur[$tahun."-".$bulan."-".$numtgl])){
											  if ($expire_time < $today_time and ($hari != "Saturday" and $hari != "Sunday"))
											  {
													$menitpotongan = 225;
											echo $menitpotongan;	
												}
										  }else{
											   echo 0;
										  }
								   }
								  ?>
							   </td>
						   <?php
						 }
					 ?>
					 <td>
					 <?php 
					 	echo $jmlmenit; 
					 	$jmlmenit = 0;
					 ?>
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
<?php if ($this->auth->has_permission('Absen.Kepegawaian.Download')) : ?>
	<a href="<?php echo base_url() ?>index.php/admin/kepegawaian/absen/create_rekap?nip=<?=$nip?>&nama=<?=$nama?>&bulan=<?=$bulan?>&tahun=<?=$tahun?>" class="btn btn-primary"> Download Rekap </a>
<?php endif; ?>
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