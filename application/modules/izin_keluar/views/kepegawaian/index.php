<?php

$num_columns	= 6;
$can_delete	= $this->auth->has_permission('Izin_Keluar.Kepegawaian.Delete');
$can_edit		= $this->auth->has_permission('Izin_Keluar.Kepegawaian.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<h3>Izin Keluar</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th>Tanggal</th>
					<th>Dari Jam</th>
					<th>Sampai Jam</th>
					<th>Keterangan</th>
					<th>User</th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						<?php echo lang('bf_with_selected'); ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('izin_keluar_delete_confirm'))); ?>')" />
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
					<td><?php echo anchor(SITE_AREA . '/kepegawaian/izin_keluar/edit/' . $record->id, '<span class="icon-pencil"></span>' .  $record->tanggal); ?></td>
				<?php else : ?>
					<td><?php e($record->tanggal); ?></td>
				<?php endif; ?>
					<td><?php e($record->dari_jam) ?></td>
					<td><?php e($record->sampai_jam) ?></td>
					<td><?php e($record->keterangan) ?></td>
					<td><?php e($record->usr_id) ?></td>
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