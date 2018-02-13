<?php

$num_columns	= 19;
$can_delete	= $this->auth->has_permission('Daftar_ptpp.Ptpp.Delete');
$can_edit		= $this->auth->has_permission('Daftar_ptpp.Ptpp.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<br>
	<ul class="nav nav-tabs">
	
		<li<?php echo $filter_type == 'all' ? ' class="active"' : ''; ?>><?php echo anchor(base_url()."index.php/admin/ptpp/daftar_ptpp", "Usulan"); ?></li>
		<?php if($this->auth->has_permission('Daftar_ptpp.Ptpp.pengecekan')){ ?>
		<li<?php echo $filter_type == 'periksa' ? ' class="active"' : ''; ?>><?php echo anchor(base_url()."index.php/admin/ptpp/daftar_ptpp/list_periksa", "Periksa"); ?></li>
		<?php } ?>
		<?php if($this->auth->has_permission('Daftar_ptpp.Ptpp.pengesahan')){ ?>
		<li<?php echo $filter_type == 'penyelesaian' ? ' class="active"' : ''; ?>><?php echo anchor(base_url()."index.php/admin/ptpp/daftar_ptpp/list_penyelesaian", "Penyelesaian"); ?></li>
		 <?php } ?>
		 
	</ul>
	<form action="<?php $this->uri->uri_string() ?>" method="get" accept-charset="utf-8">
	 <table>
        	<tr>
        		<td>
                	<b>Audit</b>
                </td>
				<td>
                	<b>Status</b>
                </td>
               <td>
                	<b>Pemilik Proses</b>
                </td>
            </tr>
            <tr>
				 <td>
                	<select name="audit" id="audit" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($audits) && is_array($audits) && count($audits)):?>
						<?php foreach($audits as $record):?>
							<option value="<?php echo $record->id?>" <?php if(isset($audit))  echo  ($record->id == $audit) ? "selected" : ""; ?>> <?php e(ucfirst($record->judul)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
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
                	<select name="bid" id="bid" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($bidangs) && is_array($bidangs) && count($bidangs)):?>
						<?php foreach($bidangs as $bidang):?>
							<option value="<?php echo $bidang->id?>" <?php if(isset($bid))  echo  ($bidang->id==$bid) ? "selected" : ""; ?>> <?php e(ucfirst($bidang->bidang)); ?></option>
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
       Jumlah :  <?php echo isset($total) ? $total : ''; ?>
       
		<br>
    </div>
	<?php echo form_open($this->uri->uri_string()); ?>
		
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th>Ditujukan Kepada</th>
					<th>Bidang</th>
					<th width="120px">#</th>
					<!--
					<th>Diajukan Oleh</th>
					<th>No PTPP</th>
					 
					<th>Referensi</th>
					
					<th>Kategori</th>
					-->
					<th width="30%">Deskripsi Ketidaksesuaian / Hasil Investigasi</th>
				 
					<th width="30%">Koreksi / Tindakan Perbaikan</th>
					<th>Status Verifikasi</th>
					<th>Status</th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						<?php echo lang('bf_with_selected'); ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('daftar_ptpp_delete_confirm'))); ?>')" />
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
					<td><?php echo anchor(SITE_AREA . '/ptpp/daftar_ptpp/'.$action."/" .$record->id, '<span class="icon-pencil"></span>' .  $record->user_tujuan); ?></td>
				<?php else : ?>
					<td><?php e($record->user_tujuan); ?></td>
				<?php endif; ?>
					<td><?php e($record->bidang) ?></td>
					<!--
					<td><?php e($record->user_pembuat) ?></td>
					<td><?php e($record->no_ptpp) ?></td>
					 
					<td><?php e($record->referensi) ?></td>
					
					<td><?php e($record->kat) ?></td>
					-->
					<td>
						No : <?php e($record->no_ptpp) ?> <br>
						Tanggal : <?php e($record->tanggal_pengusulan) ?> <br>
						Pembuat : <?php e($record->user_pembuat) ?> 
						<br>
						<?php e($record->kat) ?>
						</td>
					<td>
					<b><u>Deskripsi Ketidaksesuaian </u> : </b><?php echo strip_tags($record->deskripsi_ketidaksesuaian); ?>
					<br>
					<b><u>Hasil Investigasi </u>: </b> <?php echo strip_tags($record->hasil_investigasi); ?></td>
					 
					<td>
					<b><u>Koreksi </u> : </b> <?php echo strip_tags($record->tindakan_koreksi); ?>
					<br>
					
					<b><u>Tindakan Perbaikan </u> : </b><?php echo strip_tags($record->tindakan_korektif); ?></td>
					<td>
					<?php if($record->status_persetujuan!=""){
								echo $record->status_persetujuan=="1" ? "<span class='label label-success'>Setuju</span>":"<span class='label label-warning'>Tidak Setuju</span>" ;
							}
					?>
					</td>
					<td><?php e($record->status_ptpp) ?></td>
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
	 <?php echo $this->pagination->create_links(); ?>
</div>