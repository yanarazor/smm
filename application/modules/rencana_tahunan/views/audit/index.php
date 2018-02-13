<?php

$num_columns	= 14;
$can_delete	= $this->auth->has_permission('Rencana_Tahunan.Audit.Delete');
$can_edit		= $this->auth->has_permission('Rencana_Tahunan.Audit.Edit');
$has_records	= isset($recordbidangs) && is_array($recordbidangs) && count($recordbidangs);

?>
<div class="admin-box">
	 
	<div class="warning alert-block alert-warning fade in">
		 
	</div>
	<form action="<?php $this->uri->uri_string() ?>" method="get" id="frmCari" accept-charset="utf-8">
		<table>
			<tr>
				<td>
					Tahun : 
				</td>
				<td>
					<input id='year' type='text' name='year' maxlength="4" value="<?php echo set_value('year', isset($year) ? $year : ''); ?>" />
				</td>
				<td valign="top">
                	 <input type="submit" name="Act" class="btn btn-primary" value="Cari "  />
               	</td> 
			</tr>
		<table>
		<br>
		<table class="table table-striped">
			<thead>
				<tr>
					 
					<th>No</th>
					<th>Bidang</th>
					<th>Januari</th>
					<th>Februari</th>
					<th>Maret</th>
					<th>April</th>
					<th>Mei</th>
					<th>Juni</th>
					<th>Juli</th>
					<th>Agustus</th>
					<th>September</th>
					<th>Oktober</th>
					<th>November</th>
					<th>Desember</th>
				</tr>
			</thead>
			 
			<tbody>
				<?php
				$i=0;
				if ($has_records) :
					foreach ($recordbidangs as $record) :
					$i++;
				?>
				<tr>
				  
					<td><?php e($i); ?>.</td>
					<td><?php e($record->bidang); ?></td>
				 
					<td>
						 <input type="checkbox"  class="editrow" kode="<?php echo $record->id;?>"<?php if(isset($jsonjadwal["1-".$record->id])) echo "checked"; ?> name="bulan[<?php echo $record->id;?>]" value="1"/>
					</td>
					<td>
						 <input type="checkbox"  class="editrow" kode="<?php echo $record->id;?>"<?php if(isset($jsonjadwal["2-".$record->id])) echo "checked"; ?> name="bulan[<?php echo $record->id;?>]" value="2"/>
					</td>
					<td>
						 <input type="checkbox"  class="editrow" kode="<?php echo $record->id;?>"<?php if(isset($jsonjadwal["3-".$record->id])) echo "checked"; ?> name="bulan[<?php echo $record->id;?>]" value="3"/>
					</td>
					<td>
						 <input type="checkbox"  class="editrow" kode="<?php echo $record->id;?>"<?php if(isset($jsonjadwal["4-".$record->id])) echo "checked"; ?> name="bulan[<?php echo $record->id;?>]" value="4"/>
					</td>
					<td>
						 <input type="checkbox"  class="editrow" kode="<?php echo $record->id;?>"<?php if(isset($jsonjadwal["5-".$record->id])) echo "checked"; ?> name="bulan[<?php echo $record->id;?>]" value="5"/>
					</td>
					<td>
						 <input type="checkbox"  class="editrow" kode="<?php echo $record->id;?>"<?php if(isset($jsonjadwal["6-".$record->id])) echo "checked"; ?> name="bulan[<?php echo $record->id;?>]" value="6"/>
					</td>
					<td>
						 <input type="checkbox"  class="editrow" kode="<?php echo $record->id;?>"<?php if(isset($jsonjadwal["7-".$record->id])) echo "checked"; ?> name="bulan[<?php echo $record->id;?>]" value="7"/>
					</td>
					<td>
						 <input type="checkbox"  class="editrow" kode="<?php echo $record->id;?>"<?php if(isset($jsonjadwal["8-".$record->id])) echo "checked"; ?> name="bulan[<?php echo $record->id;?>]" value="8"/>
					</td>
					<td>
						 <input type="checkbox"  class="editrow" kode="<?php echo $record->id;?>"<?php if(isset($jsonjadwal["9-".$record->id])) echo "checked"; ?> name="bulan[<?php echo $record->id;?>]" value="9"/>
					</td>
					<td>
						 <input type="checkbox"  class="editrow" kode="<?php echo $record->id;?>"<?php if(isset($jsonjadwal["10-".$record->id])) echo "checked"; ?> name="bulan[<?php echo $record->id;?>]" value="10"/>
					</td>
					<td>
						 <input type="checkbox"  class="editrow" kode="<?php echo $record->id;?>"<?php if(isset($jsonjadwal["11-".$record->id])) echo "checked"; ?> name="bulan[<?php echo $record->id;?>]" value="11"/>
					</td>
					<td>
						 <input type="checkbox"  class="editrow" kode="<?php echo $record->id;?>"<?php if(isset($jsonjadwal["12-".$record->id])) echo "checked"; ?> name="bulan[<?php echo $record->id;?>]" value="12"/>
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
			</tbody>
		</table>
		<br>
		<?php echo anchor(SITE_AREA .'/audit/rencana_tahunan/kirimnotifikasi', "Kirim Notifikasi", 'class="btn btn-warning"'); ?>
	<?php echo form_close(); ?>	
</div>
<script type="text/javascript">
$(document).ready(function() {
	 $( ".warning" ).fadeOut( "slow" );
		$(".editrow").live("change", function(){
				 if($(this).is(":checked")) {
					  var post_data = "bidang="+$(this).attr("kode")+"&bulan="+$(this).val()+"&year="+$("#year").val();
						//alert("<?php echo base_url() ?>index.php/admin/audit/rencana_tahunan/addjadwal?"+post_data);
						$.ajax({
								url: "<?php echo base_url() ?>index.php/admin/audit/rencana_tahunan/addjadwal",
								type:"get",
								data: post_data,
								dataType: "html",
								timeout:180000,
								success: function (result) {
									$( ".warning" ).fadeIn( "slow" );
									$(".warning").html(result);
							},
							error : function(error) {
								alert(error);
							} 
						});
					  return;
				 }else{
					var post_data = "bidang="+$(this).attr("kode")+"&bulan="+$(this).val()+"&year="+$("#year").val();
						//alert("<?php echo base_url() ?>index.php/admin/audit/rencana_tahunan/addjadwal?"+post_data);
						$.ajax({
								url: "<?php echo base_url() ?>index.php/admin/audit/rencana_tahunan/deljadwal",
								type:"get",
								data: post_data,
								dataType: "html",
								timeout:180000,
								success: function (result) { 
									$( ".warning" ).fadeIn( "slow" );
									$(".warning").html(result);
									
							},
							error : function(error) {
								alert(error);
							} 
						});
					  return;
				 }
				
		  }); 
	 
});
</script>