<?php

$validation_errors = validation_errors();

if ($validation_errors) :
?>
<div class="alert alert-block alert-error fade in">
	<a class="close" data-dismiss="alert">&times;</a>
	<h4 class="alert-heading">Please fix the following errors:</h4>
	<?php echo $validation_errors; ?>
</div>
<?php
endif;

if (isset($audit_internal))
{
	$audit_internal = (array) $audit_internal;
}
$id = isset($audit_internal['id']) ? $audit_internal['id'] : '';

?>
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('audit_internal_judul') ? 'error' : ''; ?>">
				<?php echo form_label('Judul'. lang('bf_form_label_required'), 'audit_internal_judul', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='audit_internal_judul' type='text' name='audit_internal_judul' maxlength="100" value="<?php echo set_value('audit_internal_judul', isset($audit_internal['judul']) ? $audit_internal['judul'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('audit_internal_judul'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('audit_internal_dari_tanggal') ? 'error' : ''; ?>">
				<?php echo form_label('Dari Tanggal'. lang('bf_form_label_required'), 'audit_internal_dari_tanggal', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='audit_internal_dari_tanggal' type='text' name='audit_internal_dari_tanggal'  value="<?php echo set_value('audit_internal_dari_tanggal', isset($audit_internal['dari_tanggal']) ? $audit_internal['dari_tanggal'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('audit_internal_dari_tanggal'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('audit_internal_sampai_tanggal') ? 'error' : ''; ?>">
				<?php echo form_label('Sampai Tanggal'. lang('bf_form_label_required'), 'audit_internal_sampai_tanggal', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='audit_internal_sampai_tanggal' type='text' name='audit_internal_sampai_tanggal'  value="<?php echo set_value('audit_internal_sampai_tanggal', isset($audit_internal['sampai_tanggal']) ? $audit_internal['sampai_tanggal'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('audit_internal_sampai_tanggal'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('audit_internal_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/audit/audit_internal', lang('audit_internal_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Audit_Internal.Audit.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('audit_internal_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('audit_internal_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
	<ul class="nav nav-tabs">
		<li class="active" >
			<a href="#main-jadwal" data-toggle="tab">Jadwal Audit</a>
		</li>
		<li class="">
			<a href="#main-checklist" data-toggle="tab">Daftar Periksa Audit</a>
		</li>
		 
	</ul>
	<div class="tab-content" style="padding-bottom: 9px; border-bottom: 1px solid #ddd;">
		<!-- Start of Main Settings Tab Pane -->
		
		<div class="tab-pane active" id="main-jadwal">
			 <br>
			  <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
				<table class="table table-striped" >
				<thead>
					<tr>
						 
						<th width="10px">No</th>
						<th>Bidang</th>
						<th>PM/PR/IK</th>
						<th>Klausul</th>
						<th>Tanggal</th>
						<th>Auditor Kepala</th>
						<th>Auditor</th>
					</tr>
				</thead>
				 
					<tbody>
						<?php
						$i=0;
						if (isset($recordbidangs) && is_array($recordbidangs) && count($recordbidangs)) :
							foreach ($recordbidangs as $record) :
							$i++;
						?>
						<tr>
						  
							<td><?php e($i); ?>.</td>
							<td>
								<input type='hidden' name='id_bidang[]'  value="<?php echo $record->id; ?>" />
								<input type='hidden' name='id_audit[]'  value="<?php echo $id; ?>" />
								<input type='hidden' name='email_kabid[]'  value="<?php echo $record->email; ?>" />
								<?php e($record->bidang); ?>
							</td>
							<td><input  type='text' name='jadwal_audit_pm[]'  value="<?php echo isset($jsonjadwal['pm-'.$record->id]) ? $jsonjadwal['pm-'.$record->id] : ""; ?>" />
							</td>
							<td><input type='text' name='jadwal_audit_klausul[]'  value="<?php echo isset($jsonjadwal['klausul-'.$record->id]) ? $jsonjadwal['klausul-'.$record->id] : ""; ?>" />
							</td>
							<td><input class="date" type='text' name='jadwal_audit_tanggal[]'  value="<?php echo isset($jsonjadwal['tanggal-'.$record->id]) ? $jsonjadwal['tanggal-'.$record->id] : ""; ?>" /></td>
							<td>
								<select name="jadwal_audit_auditor_kepala[]" class="chosen-select-deselect">
									<option value="">-- Pilih  --</option>
									<?php if (isset($users) && is_array($users) && count($users)):?>
									<?php foreach($users as $user):?>
										<option value="<?php echo $user->id?>" <?php if(isset($jsonjadwal['auditor_kepala-'.$record->id]))  echo  ($user->id==$jsonjadwal['auditor_kepala-'.$record->id]) ? "selected" : ""; ?>> <?php e(ucfirst($user->display_name)); ?></option>
										<?php endforeach;?>
									<?php endif;?>
								</select>
							</td>
							<td>
								<select name="jadwal_audit_auditor[]" class="chosen-select-deselect">
									<option value="">-- Pilih  --</option>
									<?php if (isset($users) && is_array($users) && count($users)):?>
									<?php foreach($users as $user):?>
										<option value="<?php echo $user->id?>" <?php if(isset($jsonjadwal['auditor-'.$record->id]))  echo  ($user->id==$jsonjadwal['auditor-'.$record->id]) ? "selected" : ""; ?>> <?php e(ucfirst($user->display_name)); ?></option>
										<?php endforeach;?>
									<?php endif;?>
								</select>
							</td>
						 
							 
						</tr>
						<?php
							endforeach;
						else:
						?>
						<tr>
							<td colspan="5">No records found that match your selection.</td>
						</tr>
						<?php endif; ?>
					</tbody>
				</table>
				<br>
					<input type="submit" name="savejadwal" class="btn btn-primary" value="Save Jadwal"  />
					 
				 <?php echo form_close(); ?>  
			 

		</div>
		 
		<div class="tab-pane" id="main-checklist">
			<a href="#" id="addchecklist" class="btn btn-small">
					<i class="icon-plus" ></i> Daftar Periksa
			</a> 
			<div id="divchecklist" style="height:800px"></div>
		</div>
	</div>	
</div>

<script type="text/javascript">
function loadchecklist(){
	var json_url = "<?php echo base_url()."index.php/admin/audit/audit_internal/listchecklist/".$id; ?>";
	//alert(json_url);
	$('#divchecklist').load(json_url);
}
function loadjadwal(){
	var json_url = "<?php echo base_url()."index.php/admin/audit/jadwal_audit/listjadwal/".$id; ?>";
	$('#divjadwal').load(json_url);
}
$(document).ready(function() { 	 
	loadchecklist(); 
	//loadjadwal(); 

		 
		$(".delete").live("click", function(){
		 	var post_data = "id="+$(this).attr("kode");
			//alert("<?php echo base_url() ?>index.php/admin/audit/daftar_periksa_audit/delete_checklist_ajax?"+post_data);
			 conf = confirm("Anda yakin?"); 
				if (!conf)
                    return false;
			$.ajax({
				url: "<?php echo base_url() ?>index.php/admin/audit/daftar_periksa_audit/delete_checklist_ajax?"+post_data,
				type:"get",
				data: post_data,
				dataType: "html",
				timeout:180000,
				success: function (result) {
					loadchecklist();
					 
			},
			error : function(error) {
				alert(error);
			} 
			});        
			return false;
		}); 
		$("#addchecklist").fancybox({
			'overlayShow'	: true,
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic', 
			'onClosed'           : function(){loadchecklist()},
			'type':'iframe',
			'width':'400',
			'height':'400',
			'href':'<?php echo base_url() ?>index.php/admin/audit/daftar_periksa_audit/addchecklist/<?php echo $id; ?>',
			 'afterShow': function() { 
					 
			  }
		}); 
		$("#editchecklist").fancybox({
			'overlayShow'	: true,
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic', 
			'onClosed'           : function(){loadchecklist()},
			'type':'iframe',
			'width':'400',
			'height':'400',
			'href':'<?php echo base_url() ?>index.php/admin/audit/daftar_periksa_audit/addchecklist/<?php echo $id; ?>',
			 'afterShow': function() { 
					 
			  }
		}); 
		$("#addjadwal").fancybox({
			'overlayShow'	: true,
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic', 
			'onClosed'           : function(){loadchecklist()},
			'type':'iframe',
			'width':700,
			'height':500,
			 
			'href':'<?php echo base_url() ?>index.php/admin/audit/jadwal_audit/addjadwal/<?php echo $id; ?>',
			 'afterShow': function() { 
					 
			  }
		}); 
		 
		 
	 
}); 
 $('.date').datepicker({ dateFormat: 'yy-mm-dd'});
</script> 