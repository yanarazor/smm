<div class="alert alert-block alert-warning fade in ">
			  <a class="close" data-dismiss="alert">&times;</a>
			   Jumlah :  <?php echo isset($totalchecklist) ? $totalchecklist : ''; ?>
			</div> 
			
				<table class="table table-striped">
					<thead>
						<tr>
							 
						 
							<th>Deskripsi</th>
							<th>Klausul Iso</th>
							<th>Bukti Obyektif</th>
							<th>Kesesuaian</th>
							
							<th>#</th>
						</tr>
					</thead>
					 
					<tbody>
						<?php
						$bidang = "";
						if (isset($checklists) && is_array($checklists) && count($checklists)) :
							foreach ($checklists as $record) :
						?>
						<?php
							if($record->bidang!=$bidang){
						?>
							<tr> 
								<th colspan="6"><?php e($record->bidang) ?></th>
							</tr>
						<?php }?>
								<tr> 
									 
									 
									<td><?php echo $record->deskripsi; ?></td>
									<td><?php e($record->klausul_iso) ?></td>
									<td><?php e($record->bukti_obyektif) ?></td>
									<td>
									<?php if($record->kesesuaian!=""){
											echo $record->kesesuaian=="1" ? "<span class='label label-success'>Sesuai</span>":"" ;
										}
										if($record->kesesuaian!=""){
											echo $record->kesesuaian=="0" ? "<span class='label label-warning'>Tidak</span>":"" ;
										}
									?>
									</td>
									
									 
									<td>
									<div class="dropdown">
											<a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#">
												Aksi<b class="caret"></b></a>
											<ul class="dropdown-menu">
												 
												<li><a href="<?php echo base_url()."index.php/admin/ptpp/daftar_ptpp/create/"; ?><?php echo $record->id;  ?>" class="notpay" kode="<?php e($record->id); ?>">Buat PTPP</a></li>
												<li><a href="<?php echo base_url()."index.php/admin/ptpp/daftar_ptpp"; ?>/?checklist=<?php echo $record->id;  ?>" class="pay" kode="<?php e($record->id); ?>">Lihat PTPP</a></li> 
												<li><a href="<?php echo base_url()."index.php/admin/audit/daftar_periksa_audit/edit/".$record->id; ?>" class="editchecklist" kode="<?php e($record->id); ?>">Edit</a></li> 
												<li><a href="#" class="delete" kode="<?php e($record->id); ?>">Delete</a></li> 
											</ul>
										</div>	
									</td>
									</tr>
							<?php
						
							$bidang = $record->bidang;
							endforeach;
						else:
						?>
						<tr>
							<td colspan="10">No records found that match your selection.</td>
						</tr>
						<?php endif; ?>
					</tbody>
				</table>