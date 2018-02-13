<?php

$num_columns	= 9;
$can_delete	= $this->auth->has_permission('Lupa_Timer.Kepegawaian.Delete');
$can_edit		= $this->auth->has_permission('Lupa_Timer.Kepegawaian.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	 <br>
	<ul class="nav nav-tabs">
		
		<li<?php echo $filter_type == 'all' ? ' class="active"' : ''; ?>><?php echo anchor(base_url()."index.php/admin/kepegawaian/lupa_timer", "Usulan"); ?></li>
		<?php if($this->auth->has_permission('Lupa_Timer.Kepegawaian.Periksa')){ ?>
		<li<?php echo $filter_type == 'periksa' ? ' class="active"' : ''; ?>><?php echo anchor(base_url()."index.php/admin/kepegawaian/lupa_timer/list_periksa", "Periksa"); ?></li>
		<?php } ?>
		 
	</ul> 
	 <form action="<?php $this->uri->uri_string() ?>" method="get" accept-charset="utf-8">
	 <table>
        	<tr> 
            	<td>
                	<b>Kata Kunci</b>
                </td> 
                <td>
                	<b>Status</b>
                </td> 
            </tr> 
            <tr>
            	<td>
                	<input id='keyword' type='text' name='keyword' maxlength="20" value="<?php echo set_value('keyword', isset($keyword) ? $keyword : ''); ?>" />
                </td>
				<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                	<label class='radio' for='1'>
						<input id='status1' name='status' type='radio' value='1' <?php echo $status=="1" ? "checked" : "" ?> />
						Oke
					</label>
					</br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class='radio' for='2'>
						<input id='status2' name='status' type='radio' value='2' <?php echo $status=="2" ? "checked" : "" ?> />
						Tidak
					</label>
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
					
					<th>User</th>
					<th>Tanggal Absen</th>
					<th>Absen</th>
					<th>Jam Sebernarnya</th>
					 
					<th>Status</th>
					 
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						<?php echo lang('bf_with_selected'); ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('lupa_timer_delete_confirm'))); ?>')" />
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
					<td><?php echo anchor(SITE_AREA . '/kepegawaian/lupa_timer/edit/' . $record->id, '<span class="icon-pencil"></span>' .  $record->user_pengusul); ?></td>
				<?php else : ?>
					<td><?php e($record->user_pengusul); ?></td>
				<?php endif; ?>
					<td><?php e($record->tanggal_absen) ?></td>
					<td><?php e($record->absen) ?></td>
					<td><?php e($record->jam_sebenarnya) ?></td>
					 
					<td>
						<?php 
							 echo $record->status_atasan=="1" ? "<span class='label label-success'>Ya</span>":"" ;
							 echo $record->status_atasan=="2" ? "<span class='label label-warning'>Tidak Setuju</span>":"" ;
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
			</tbody>
		</table>
	<?php echo form_close(); ?>
	 <?php echo $this->pagination->create_links(); ?>
</div>