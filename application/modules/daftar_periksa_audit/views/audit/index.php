<?php

$num_columns	= 10;
$can_delete	= $this->auth->has_permission('Daftar_Periksa_Audit.Audit.Delete');
$can_edit		= $this->auth->has_permission('Daftar_Periksa_Audit.Audit.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<form action="<?php $this->uri->uri_string() ?>" method="get" accept-charset="utf-8">
	 <table>
        	<tr>
				<td>
                	Audit Internal
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
							<option value="<?php echo $bidang->id?>" <?php if(isset($bidang))  echo  ($bidang->id==$id_bidang) ? "selected" : ""; ?>> <?php e(ucfirst($bidang->bidang)); ?></option>
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
					<?php if ($can_delete && $has_records) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th>Audit</th>
					<th  width="30%">Klausul Iso
					/Deskripsi</th>
					<th width="40%">Bukti Obyektif/Kesesuaian</th>
					<th >Bidang/
					Tanggal/Auditor</th>
					<th>#</th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						<?php echo lang('bf_with_selected'); ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('daftar_periksa_audit_delete_confirm'))); ?>')" />
					</td>
				</tr>
				<?php endif; ?>
			</tfoot>
			<?php endif; ?>
			<tbody>
				<?php
				if ($has_records) :
					foreach ($records as $record) :
				?>
				<tr>
					<?php if ($can_delete) : ?>
					<td class="column-check"><input type="checkbox" name="checked[]" value="<?php echo $record->id; ?>" /></td>
					<?php endif;?>
					
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/audit/daftar_periksa_audit/edit/' . $record->id, '<span class="icon-pencil"></span>' .  $record->judul); ?></td>
				<?php else : ?>
					<td><?php e($record->judul); ?></td>
				<?php endif; ?>
					<td>
						<b><u>Klausul ISO </u></b> :
						<?php echo $record->klausul_iso; ?>
						<br>
						<b><u>Deskripsi </u></b> :
						<?php echo $record->deskripsi; ?>
					<td>
					<b><u>Bukti Objektif</u></b> : <?php echo $record->bukti_obyektif; ?> <br>
					<b><u>Kesesuaian </u><b> : 
					<?php if($record->kesesuaian!=""){
							echo $record->kesesuaian=="1" ? "<span class='label label-success'>Sesuai</span>":"<span class='label label-warning'>Tidak</span>" ;
						}
					?>
					</td>
					<td>
						<b><u>Bidang </u></b> :
						<?php e($record->bidang) ?>
					<br>
					<b><u>Tanggal </u></b> :
						<?php e($record->tanggal) ?><br>
					
					<b><u>Auditor </u></b> :
						<?php e($record->user_pembuat) ?>
					
							
					</td>
                    <td>
					<div class="dropdown">
							<a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#">
								PKTP<b class="caret"></b></a>
							<ul class="dropdown-menu">
								 
								<li><a href="<?php echo base_url()."index.php/admin/ptpp/daftar_ptpp/create/"; ?><?php e($record->id); ?>" class="notpay" kode="<?php e($record->id); ?>">Buat PKTP</a></li>
								<!--
								<li><a href="<?php echo base_url()."index.php/admin/ptpp/daftar_ptpp/checklist/"; ?><?php e($record->id); ?>" class="pay" kode="<?php e($record->id); ?>">Lihat PTPP</a></li> 
								-->
							</ul>
						</div>	
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
	<?php echo form_close(); ?>
</div>