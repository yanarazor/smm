<?php

$num_columns	= 13;
$can_delete	= $this->auth->has_permission('Laporan_Ketidaksesuaian.Ketidaksesuaian.Delete');
$can_edit		= $this->auth->has_permission('Laporan_Ketidaksesuaian.Ketidaksesuaian.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	 
    <form action="<?php $this->uri->uri_string() ?>" method="get" accept-charset="utf-8">
	 <table>
        	<tr>
				<td>
                	Status
                </td>
                <td>:
                </td>
                <td>
                	<select name="status" id="status" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($statuss) && is_array($statuss) && count($statuss)):?>
						<?php foreach($statuss as $status):?>
							<option value="<?php echo $status->id?>" <?php if(isset($status_ptpp))  echo  ($status->id==$status_ptpp) ? "selected" : ""; ?>> <?php e(ucfirst($status->status)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
               	</td> 
            	 
                <td valign="top">
                	 
               	</td> 
            </tr>
            <tr>
				<td>
                	Bidang
                </td>
                <td>:
                </td>
                <td>
                	<select name="bidang" id="bidang" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($bidangs) && is_array($bidangs) && count($bidangs)):?>
						<?php foreach($bidangs as $bidang):?>
							<option value="<?php echo $bidang->id?>" <?php if(isset($id_bidang))  echo  ($bidang->id==$id_bidang) ? "selected" : ""; ?>> <?php e(ucfirst($bidang->bidang)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
               	</td> 
            	 
                <td valign="top">
                	 
               	</td> 
            </tr>
            <tr>
				<td>
                	Audit
                </td>
                <td>:
                </td>
                <td>
                	<select name="ai" id="ai" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($audit_internals) && is_array($audit_internals) && count($audit_internals)):?>
						<?php foreach($audit_internals as $audit_internal):?>
							<option value="<?php echo $audit_internal->id?>" <?php if(isset($ai))  echo  ($audit_internal->id==$ai) ? "selected" : ""; ?>> <?php e(ucfirst($audit_internal->judul)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
               	</td> 
            	 
                <td valign="top">
                	 <input type="submit" name="Act" class="btn btn-primary" value="Cari "  />
               	</td> 
            </tr>
            
        </table>
    <?php echo form_close(); ?>
   <div class="alert alert-block alert-warning fade in ">
      <a class="close" data-dismiss="alert">&times;</a>
       Jumlah :  <?php echo isset($total) ? $total : ''; ?>
    </div>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
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
	 <?php echo $this->pagination->create_links(); ?>
</div>