	 
	<!-- end: stats number -->
	<div class="row-fluid">
					<div class="box span4">
						<div class="box-header">
							<h2><i class="icon-list"></i><span class="break"></span>Daftar Induk Dokumen</h2>
						</div>
						<div class="box-content">
							<h3>Jenis Dokumen</h3>
							<ul class="dashboard-list">
                            	<?php
								$has_recordsrecordByJenis	= isset($recorddoc) && is_array($recorddoc) && count($recorddoc);
								?>
								 
										<?php
										if ($has_recordsrecordByJenis) :
										$i=1;
											foreach ($recorddoc as $record) :
										?>
                                        	<lo>
                                                <?php e($i); ?>.
                                                <a href="#" class="detil" kode="<?php e($record->jenis); ?>">
                                                	<?php e($record->jenis); ?>
                                                 </a>(<?php e($record->jumlah) ?>)<br>
                                                                            
                                            </lo>
										 
										<?php
											$i++;
											endforeach;
										 endif;
										?> 
							</ul>
							<hr>
							<h3>Status Dokumen</h3>
							<ul class="dashboard-list">
                            	 
										<?php
										if (isset($recorddokbystatus) && is_array($recorddokbystatus) && count($recorddokbystatus)) :
										$i=1;
											foreach ($recorddokbystatus as $record) :
										?>
                                        	<lo>
                                                <?php e($i); ?>.
                                                <a href="#" class="detil" kode="<?php e($record->status_active); ?>">
                                                	<?php if($record->status_active=="0") echo "Kadaluarsa"; elseif($record->status_active=="1") echo "Active"; ?>
                                                 </a>(<?php e($record->jumlah) ?>)<br>
                                                                            
                                            </lo>
										 
										<?php
											$i++;
											endforeach;
										 endif;
										?> 
							</ul>
							<hr>
							<h3>Dokumen Eksternal</h3>
							<ul class="dashboard-list">
                            	 <lo>
										 
										<a href="#" class="detil" kode="#">
											Jumlah
										 </a>(<?php e($recorddoceks) ?>)<br>
																	
									</lo>
							</ul>
						</div>
					</div>
					<!-- end: most sales products -->
					
					<div class="box span4">
						<div class="box-header">
							<h2><i class="icon-list"></i><span class="break"></span>Dokumen Berdasarkan Bidang</h2>
						</div>
						<div class="box-content">
							<ul class="dashboard-list">
								<?php
								$has_recorddocbybidang	= isset($recorddocbybidang) && is_array($recorddocbybidang) && count($recorddocbybidang);
								?>
								 
								<?php
                                if ($has_recorddocbybidang) :
									$i=1;
                                    foreach ($recorddocbybidang as $record) :
                                ?>
                                    <lo>
                                        <?php e($i); ?>.
                                        <a href="#" class="detil" kode="<?php e($record->id); ?>">
                                            <?php if($record->namabidang!="") e($record->namabidang); else echo "-";?>
                                         </a> 
                                        (<?php e($record->jumlah) ?>)<br>
                                                                    
                                    </lo>
                                 
                                <?php
									$i++;
                                    endforeach;
                                 endif;
                                ?> 
							</ul>
						</div>
					</div>
					
					<div class="box span4">
						<div class="box-header">
							<h2><i class="icon-list"></i><span class="break"></span>Usulan Dokumen</h2>
						</div>
						<div class="box-content">
							<h3>Usulan Dokumen Internal </h3>
							<ul class="dashboard-list"> 
                                    <lo>
                                         
                                        <a href="#" class="detil">
											Total Usulan
                                         </a> 
                                        (<?php e($totalUsulan) ?>)<br>
                                                                    
                                    </lo>
									 <lo>
                                         
                                        <a href="#" class="detil">
                                            Status Periksa
                                         </a> 
                                        (<?php e($record_usulan_periksa) ?>)<br>
                                                                    
                                    </lo>
									<lo> 
                                        <a href="#" class="detil">
                                            Status Pengesahan
                                         </a> 
                                        (<?php e($record_usulan_sah) ?>)<br>
                                                                    
                                    </lo>  
							</ul>
							<h3>Usulan Dokumen Eksternal</h3>
							<ul class="dashboard-list"> 
                                    <lo> 
                                        <a href="#" class="detil">
											Total Usulan
                                         </a> 
                                        (<?php e($totalUsulanEks) ?>)<br>
                                                                    
                                    </lo>
									 
									<lo> 
                                        <a href="#" class="detil">
                                            Status Pengesahan
                                         </a> 
                                        (<?php e($TotalStatusSahEks) ?>)<br>
                                                                    
                                    </lo>  
							</ul>
						</div>
					</div>
	</div>
	<div class="row-fluid">
					 
	 
	<!-- end: most viewed products -->
	<div class="box span4">
		<div class="box-header">
			<h2><i class="icon-list"></i><span class="break"></span>PTPP</h2>
		</div>
		<div class="box-content">
			<h3>Kategori Temuan</h3>
			<ul class="dashboard-list">
            	 
				 
						<?php
						if (isset($RecordByJenisPTPP) && is_array($RecordByJenisPTPP) && count($RecordByJenisPTPP)) :
						$i=1;
							foreach ($RecordByJenisPTPP as $record) :
						?>
                        	<lo>
                                <?php e($i); ?>.
                                <a href="#" class="detil" kode="<?php e($record->kat); ?>">
                                	<?php e($record->kat); ?>
                                 </a>(<?php e($record->jumlah) ?>)<br>
                                                            
                            </lo>
						 
						<?php
							$i++;
							endforeach;
						 endif;
						?> 
			</ul>
			<hr>
			<h3>Status Temuan</h3>
				<ul class="dashboard-list"> 
							<?php
							if (isset($RecordByStatus) && is_array($RecordByStatus) && count($RecordByStatus)) :
							$i=1;
								foreach ($RecordByStatus as $record) :
							?>
								<lo>
									<?php e($i); ?>.
									<a href="#" class="detil" kode="<?php e($record->stat); ?>">
										<?php e($record->stat); ?>
									 </a>(<?php e($record->jumlah) ?>)<br>
																
								</lo>
							 
							<?php
								$i++;
								endforeach;
							 endif;
							?> 
				</ul>
			<hr>
			<h3>Status Temuan Perbidang</h3>
			<ul class="dashboard-list">
            	 
				 
						<?php
						if (isset($RecordByStatusnBidang) && is_array($RecordByStatusnBidang) && count($RecordByStatusnBidang)) :
						$i=1;
						$bidang = "";
							foreach ($RecordByStatusnBidang as $record) :
							if($record->bidang != $bidang)
								echo $i.". <b>".$record->bidang."</b><br>";
						?>
                        	<lo>
                                <a href="#" class="detil" kode="<?php e($record->stat); ?>">
                                 
                                	<?php e($record->stat); ?>
                                 </a>(<?php e($record->jumlah) ?>)<br>
                                                            
                            </lo>
						 
						<?php
							$bidang = $record->bidang;
							$i++;
							endforeach;
						 endif;
						?> 
			</ul>
			<hr>
		</div>
	</div>
	 
</div>