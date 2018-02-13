<?php
	$this->load->library('convert');
	$convert = new convert();
?>
   <table class="table table-bordered" width="1500px" border="1">
			<thead>
				 
				<tr>
					<th width="20px" rowspan="2">No.</th>
					<th rowspan="2">Nama</th>
					<th rowspan="2">Golongan</th>
					
					<th rowspan="2">Izin</th>
					<th rowspan="2">Sakit</th>
					<th rowspan="2">Cuti Tahunan</th>
					<th rowspan="2">CUti Alasan Penting</th>
					<th rowspan="2">Cuti Bersalin</th>
					<th rowspan="2">Diklat</th>
					<th colspan="2">Tugas</th>
					<th rowspan="2">Tidak Masuk Tanpa Ket</th>
					<th rowspan="2">Jumlah Hari Kerja Efektif</th>
				</tr>
				<tr>
					<th>
						Transport Lokal
					</th>
					<th>
						Luar Kota
					</th>
				</tr>
				 
			</thead>
			 
			<tbody>
				<?php
				if (isset($recorduser) && is_array($recorduser) && count($recorduser)) :
					$no=1;
					$total = 0;
					//print_r($dataizin);
					foreach ($recorduser as $record) :
				?>
				<tr>
					<td>
						<?php echo $no; ?>.
					</td>
					<td>
						<?php echo $record->display_name; ?><br>
					</td>
					 <td>
					 	<?php echo $record->pangkat; ?><br>
					 </td>
					 <td>
					 	<?php echo isset($dataizin["izin_21_".$record->nip]) ? $dataizin["izin_21_".$record->nip] : ""; 
					 	//izin
					 	?>
					 </td>
					 <td>
					 	<?php echo isset($dataizin["izin_4_".$record->nip]) ? $dataizin["izin_4_".$record->nip] : ""; //sakit
					 	?>
					 </td>
					 <td>
					 	<?php echo isset($dataizin["izin_13_".$record->nip]) ? $dataizin["izin_13_".$record->nip] : ""; //cuti tahunan
					 	?>
					 </td>
					 <td>
					 	<?php echo isset($dataizin["izin_6_".$record->nip]) ? $dataizin["izin_6_".$record->nip] : ""; //cuti alasan penting
					 	?>
					 </td>
					 <td>
					 	<?php echo isset($dataizin["izin_7_".$record->nip]) ? $dataizin["izin_7_".$record->nip] : ""; //cuti cuti bersalin
					 	?>
					 </td>
					 <td>
					 	<?php echo isset($dataizin["izin_17_".$record->nip]) ? $dataizin["izin_17_".$record->nip] : ""; //diklat
					 	?>
					 </td>
					 <td>
					 	 
					 </td>
					 <td>
					 	<?php echo isset($dataizin["izin_15_".$record->nip]) ? $dataizin["izin_15_".$record->nip] : ""; //Dinas luar
					 	?>
					 </td>
					 <td>
					 	<?php echo isset($dataizin["izin_22_".$record->nip]) ? $dataizin["izin_22_".$record->nip] : ""; //tanpa keterangan
					 	?>
					 </td>
					<td>
					 	 
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