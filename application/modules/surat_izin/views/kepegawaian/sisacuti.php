<?php
	$sisa = 12 - $jmlcuti - $jmlM;
?>
<div class="admin-box">
	<table class="table">
	   <tr> 
		  <th width="300px">
			Jumlah Cuti Tahun ini 		 
		 </th>
		 <td>
		 	<?php
		 	echo isset($tahunini) ? $tahunini : 0;
		 	?>
		 </td>
	   </tr>
	   <tr> 
		  <th>
			Cuti yang telah diambil
		 </th>
		 <td>
		 	<?php echo $jmlcuti; ?>
		 </td>
	   </tr>
	   <tr> 
		  <th>
			Tidak masuk tanpa keterangan
		 </th>
		 <td>
		 	<?php
		 	echo $jmlM;
		 	?>
		 </td>
	   </tr>
	   <tr> 
		  <th>
			Sisa Cuti tahun ini
		 </th>
		 <td>
		 	<?php
		 	$sisa = $tahunini - $jmlcuti;
		 	echo $sisa;
		 	?>
		 </td>
	   </tr>
   </table>   
</div>