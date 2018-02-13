<style>
hr {
  margin: 5px 0;
  border-bottom: 1px solid #fefefe;
}
@media print {
    body {
		 font-family: 'Arial';
		 font-size: 12px;
		 font-style: normal;
		 font-variant: normal;
    }
    hr {
	  margin: 5px 0;
	  border-bottom: 1px solid #fefefe;
	}
    .headjudul {
		font-size : 34pt;
    }
    .headjudul1 {
		font-size : 17pt;
    }
    .headjudul2 {
		font-size : 14pt;
    }
    .headjudul3 {
		font-size : 22pt;
    }
	table {
		border-collapse: collapse;
		
	}
	table .tabel{
		font-size: 20pt;
	}
	table .tabel{
		font-size: 20pt;
	}
	td{
		padding:2px;
	}
	.checkboxOne {
		width: 40px;
		height: 40px;
		background-color: #e9ecee;
		color: #99a1a7;
		border: 1px solid #adb8c0;
	}
	@font-face {
		font-family: 'Arial';
	}
	/* use this class to attach this font to any element i.e. <p class="fontsforweb_fontid_507">Text with this font applied</p> */
	.btnprint{
		display: none;
	}
}
</style>
<?php

$num_columns	= 13;
$can_delete	= $this->auth->has_permission('Laporan_Ketidaksesuaian.Ketidaksesuaian.Delete');
$can_edit		= $this->auth->has_permission('Laporan_Ketidaksesuaian.Ketidaksesuaian.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
 
	<?php echo form_open($this->uri->uri_string()); ?>
		<center><b>Daftar Rekapitulasi Laporan Audit
</b></center>
		<table border="1" width="100%">
			<thead>
				<tr>
					 
					<th class="column-check" rowspan="2">No</th>
					 
					<th rowspan="2">Bidang</th>
					<th rowspan="2">Temuan Audit</th>
					 
					<th colspan="3">Keterangan</th> 
					<th colspan="2">Status</th>
					 
				</tr>
                <tr>
                	<th>Mayor</th>
                    <th>Minor</th>
                    <th>Observasi</th>
                    
                    <th>Open</th>
                    <th>Closed</th>
                </tr>
			</thead>
			 
			<tbody>
				<?php
				$i = 0;
				$jmlmayor = 0;
				$jmlminor = 0;
				$jmlobservasi = 0;
				$jmlopen = 0;
				$jmlclosed = 0;
				if ($has_records) :
					foreach ($records as $record) :
					$i++;
				?>
				<tr>
					 
					<td class="column-check"><?php echo $i; ?></td>
					<td><?php e($record->bidang) ?></td>
					<td>
					 
					<?php 
					echo strip_tags($record->deskripsi_ketidaksesuaian); ?></td>
					<td>
					
					<?php if($record->kategori=="1"){
								$jmlmayor = $jmlmayor +1;
								echo $record->kategori=="1" ? "<span class='label label-success'>Mayor</span>":"" ;
							}
					?>
					</td>
                    <td>
					<?php if($record->kategori=="2"){
								$jmlminor = $jmlminor +1;
								echo $record->kategori=="2" ? "<span class='label label-success'>Minor</span>":"" ;
							}
					?>
					</td> 
					<td>
						<?php if($record->kategori=="3"){
									$jmlobservasi = $jmlobservasi +1;
									echo $record->kategori=="3" ? "<span class='label label-success'>Observasi</span>":"" ;
								}
						?>
					</td> 
					<td>
					<?php if($record->status=="1"){
								$jmlopen = $jmlopen +1;
								echo $record->status=="1" ? "<span class='label label-success'>Open</span>":"" ;
							}
					?>
					</td>
                    <td>
					<?php if($record->status=="2"){
								$jmlclosed = $jmlclosed +1;
								echo $record->status=="2" ? "<span class='label label-success'>Close</span>":"" ;
							}
					?>
					</td> 
					 
				</tr>
				<?php
					
					endforeach;
				else:
				?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">No records found that match your selection.</td>
				</tr>
				<?php endif; ?>
				<tfoot>
				 
				<tr>
					<td>
						<?php //echo $i; ?>	
					</td>
					<td>
							
					</td>
					<td>
							
					</td>
					<td>
						<?php echo $jmlmayor; ?>
					</td>
					<td>
						<?php echo $jmlminor; ?>	
					</td>
					<td>
						<?php echo $jmlobservasi; ?>	
					</td>
					<td>
						<?php echo $jmlopen; ?>	
					</td>
					<td>
						<?php echo $jmlclosed; ?>	
					</td>
				</tr>
				 
			</tfoot>
			</tbody>
		</table>
	<?php echo form_close(); ?>
</div>