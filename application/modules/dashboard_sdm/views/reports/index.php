 
	<br><br><br><br>
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="col-xs-4">
						<!-- Centered text -->
						<div class="stat-panel text-center">
							<div class="stat-row">
								<!-- Dark gray background, small padding, extra small text, semibold text -->
								<div class="stat-cell bg-dark-orange padding-sm text-xs text-semibold">
									<i class="fa fa-user"></i>&nbsp;&nbsp;Izin
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, without horizontal padding -->
								<div class="stat-cell bordered no-border-t no-padding-hr">
								<!-- <div class="pie-chart" data-percent="43" id="easy-pie-chart-1">-->
									<div class="pie-chart"  id="easy-pie-chart-1"> 
											<div class="pie-chart-label">
											<a href="<?php echo base_url().'index.php/admin/kepegawaian/surat_izin/list_bystatus/simple?status='; ?>" class='fancy'>
												Belum Diproses : <?php if(isset($countblmproses)) e($countblmproses); ?> Data <br>
											</a>
											<a href="<?php echo base_url().'index.php/admin/kepegawaian/surat_izin/list_bystatus/simple?status=notnull'; ?>" class='fancy'>
												Sudah Diproses : <?php if(isset($countproses)) e($countproses); ?> Data 
											</a>
											</div>
											
										 
									</div>
								</div>
							</div> <!-- /.stat-row -->
						</div> <!-- /.stat-panel -->
					</div>
					<div class="col-xs-4">
						<div class="stat-panel text-center">
							<div class="stat-row">
								<!-- Dark gray background, small padding, extra small text, semibold text -->
								<div class="stat-cell bg-dark-orange padding-sm text-xs text-semibold">
									<i class="fa fa-check"></i>&nbsp;&nbsp; Lupa Timer
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, without horizontal padding -->
								<div class="stat-cell bordered no-border-t no-padding-hr">
								<!-- <div class="pie-chart" data-percent="93" id="easy-pie-chart-2">-->
									<div class="pie-chart" id="easy-pie-chart-2">
										<div class="pie-chart-label">
											<a href="<?php echo base_url().'index.php/admin/kepegawaian/lupa_timer/list_bystatus/simple?status='; ?>" class='fancy'>
												Belum Diproses : <?php if(isset($countblmprosestimers)) e($countblmprosestimers); ?> Data <br>
											</a>
											<a href="<?php echo base_url().'index.php/admin/kepegawaian/lupa_timer/list_bystatus/simple?status=notnull'; ?>" class='fancy'>
												Sudah Diproses : <?php if(isset($countproseslupatimers)) e($countproseslupatimers); ?> Data 
											</a>
									</div>
									
								</div>
								</div>
							</div> <!-- /.stat-row -->
						</div> <!-- /.stat-panel -->
					</div>
					<div class="col-xs-4">
						<div class="stat-panel text-center">
							<div class="stat-row">
								<!-- Dark gray background, small padding, extra small text, semibold text -->
								<div class="stat-cell  bg-dark-orange padding-sm text-xs text-semibold">
									<i class="fa fa-user"></i>&nbsp;&nbsp;IPK
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, without horizontal padding -->
								<div class="stat-cell bordered no-border-t no-padding-hr">
									<div class="pie-chart" id="easy-pie-chart-3">
									<!-- <div class="pie-chart" data-percent="75" id="easy-pie-chart-3">-->
										<div class="pie-chart-label">
											<a href="<?php echo base_url().'admin/krs/transkip/viewmhs'; ?>">
												<?php echo (Double)$ips; ?>
											</a>
										</div>
									<canvas height="90" width="90"></canvas></div>
								</div>
							</div> <!-- /.stat-row -->
						</div> <!-- /.stat-panel -->
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="row">

					<div class="col-sm-4 col-md-12">
						<div class="stat-panel">
							<div class="stat-row">
								<!-- Purple background, small padding -->
								<div class="stat-cell bg-pa-orange padding-sm">
									<!-- Extra small text -->
									<div class="text-xs" style="margin-bottom: 5px;">NILAI MAHASISWA</div>
									<div class="stats-sparklines" id="stats-sparklines-3" style="width: 100%"><canvas width="313" height="45" style="display: inline-block; width: 313px; height: 45px; vertical-align: top;"></canvas></div>
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, horizontally centered text -->
								<div class="stat-counters bordered no-border-t text-center">
									<!-- Small padding, without horizontal padding -->
									<div class="stat-cell col-xs-4 padding-sm no-padding-hr">
										<!-- Big text -->
										<span class="text-bg"><strong>
										<?php 
											echo $jumlahadanilai;
										?>
										</strong></span><br>
										<!-- Extra small text -->
										<span class="text-xs text-muted">SUDAH DI NILAI</span>
									</div>
									<!-- Small padding, without horizontal padding -->
									<div class="stat-cell col-xs-4 padding-sm no-padding-hr">
										<!-- Big text -->
										<span class="text-bg"><strong>
										<?php
										echo $jmlbelumadanilai;
										?>
										</strong></span><br>
										<!-- Extra small text -->
										<span class="text-xs text-muted">BELUM DI NILAI</span>
									</div>
									<!-- Small padding, without horizontal padding -->
									<div class="stat-cell col-xs-4 padding-sm no-padding-hr">
										<!-- Big text -->
										<span class="text-bg"><strong>
										<?php
										echo $jumlahjadwal;
										?>
										</strong></span><br>
										<!-- Extra small text -->
										<span class="text-xs text-muted">JADWAL</span>
									</div>
								</div> <!-- /.stat-counters -->
							</div> <!-- /.stat-row -->
						</div> <!-- /.stat-panel -->
					</div>
				</div>
			</div>
		</div>

		 
		<div class="row">
			<div class="col-md-7">
				<div class="panel panel-dark-gray panel-light-green">
					<div class="panel-heading">
						<span class="panel-title"><i class="panel-title-icon fa fa-power-off"></i>Aktifitas Terakhir</span>
						<div class="panel-heading-controls">
							<ul class="pagination pagination-xs">
								
							</ul> <!-- / .pagination -->
						</div> <!-- / .panel-heading-controls -->
					</div> <!-- / .panel-heading -->
					<table class="table">
						<thead>
							<tr>
								<th>#</th>
								<th>Username</th>
								<th>Full Name</th>
								 
								<th>Time</th>
							</tr>
						</thead>
						<tbody class="valign-middle">
							 
							<?php 
								if(isset($activities) && is_array($activities) && count($activities)):
								$i=1;
								foreach ($activities as $activity) : ?>
									<tr>
										<td>
											<?php echo $i; ?>
										</td>
										<td>
											<strong><?php echo ucwords($activity->display_name); ?></strong>
										</td>
										<td>
											<strong><?php echo ucwords($activity->display_name); ?></strong>
										</td>
										<td><?php echo $activity->activity; ?>
                                        <br />On<?php echo date('M j, Y g:i A', strtotime($activity->created_on)); ?>
                                        </td> 
										  
									</tr>
								<?php 
								$i++;
								endforeach; 
								endif;?>
						</tbody>
					</table>
				</div> <!-- / .panel -->
			</div>

			<div class="col-md-5">
				<!-- Javascript -->
				<script>
					init.push(function () {
						$('.widget-tasks .panel-body').pixelTasks().sortable({
							axis: "y",
							handle: ".task-sort-icon",
							stop: function( event, ui ) {
								// IE doesn't register the blur when sorting
								// so trigger focusout handlers to remove .ui-state-focus
								ui.item.children( ".task-sort-icon" ).triggerHandler( "focusout" );
							}
						});
						$('#clear-completed-tasks').click(function () {
							$('.widget-tasks .panel-body').pixelTasks('clearCompletedTasks');
						});
					});
				</script>
				<!-- / Javascript -->

				<div class="panel widget-tasks panel-dark-gray">
					<div class="panel-heading">
						<span class="panel-title"><i class="panel-title-icon fa fa-tasks"></i>Mata Kuliah Semester ini</span>
						<div class="panel-heading-controls">
							<a href="<?php echo base_url().'admin/krs/datakrs/lihatmatakuliahyangdiambil/simple'; ?>" class='fancy'>
								
							<button class="btn btn-xs btn-primary btn-outline dark" id="clear-completed-tasks">
							<i class="fa fa-trash text-success"></i>
									Semua
								
							</button>
							</a>
						</div>
					</div> <!-- / .panel-heading -->
					<!-- Without vertical padding -->
					<div class="panel-body no-padding-vr ui-sortable">
<table class="table">
						 <thead>
									  <tr>
										  <th>Mata Kuliah</th>
										  <th>Sks</th>
										  <th>Dosen</th>
										  <th>Semester</th>
										  <th>Nilai Angka</th>
										  <th>Nilai Huruf</th>
										  <th>Status</th> 
									  </tr>
								  </thead>
						<tbody class="valign-middle">
							 <?php
									  if (isset($recordmks) && is_array($recordmks) && count($recordmks)) :
										  foreach ($recordmks as $record) :
									  ?>
									  <tr>
										  <td><?php e($record->kode_mk." - ".$record->nama_mata_kuliah); ?></td>
										  <td><?php e($record->sks) ?></td>
					 
										  <td><?php e($record->nama_dosen) ?></td>
										  <td><?php e($record->semester) ?></td>
					 
										  <td><?php e($record->nilai_angka) ?></td>
										  <td><?php e($record->nilai_huruf) ?></td>
										  <td><?php e($record->status) ?></td>
					 
									  </tr>
									  <?php
										  endforeach;
									  else:
									  ?>
									  <tr>
										  <td colspan="8">No records found that match your selection.</td>
									  </tr>
									  <?php endif; ?>
									   
						</tbody>
</table>


					</div> <!-- / .panel-body -->
				</div> <!-- / .panel -->
			</div>
<!-- /13. $RECENT_TASKS -->

		</div>
	</div> <!-- / #content-wrapper -->
	<div id="main-menu-bg"></div>
</div> <!-- / #main-wrapper -->
 <script type="text/javascript">  
$(document).ready(function() {
$(".fancy").fancybox({
			'overlayShow'	: true,
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic', 
			'onClosed'           : function(){},
			'autoSize' : false,
			'minheight':'500',
			'type':'iframe',
			'width':'400',
			'height':'600'
			 
		}); 
		
});
 
 
</script> 
