<?php

$num_columns	= 7;
$can_delete	= $this->auth->has_permission('Jadwal_Audit.Audit.Delete');
$can_edit		= $this->auth->has_permission('Jadwal_Audit.Audit.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<h3>Jadwal Audit</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th>Audit</th>
					<th>Bidang</th>
					<th>PM</th>
					<th>Klausul</th>
					<th>Tanggal</th>
                    <th>Auditor</th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						<?php echo lang('bf_with_selected'); ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('jadwal_audit_delete_confirm'))); ?>')" />
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
					<td><?php echo anchor(SITE_AREA . '/audit/jadwal_audit/edit/' . $record->id, '<span class="icon-pencil"></span>' .  $record->judul); ?></td>
				<?php else : ?>
					<td><?php e($record->judul); ?></td>
				<?php endif; ?>
					<td><?php e($record->bidang) ?></td>
					<td><?php e($record->pm) ?></td>
					<td><?php e($record->klausul) ?></td>
					<td><?php e($record->tanggal) ?></td>
                    <td><?php e($record->kepala) ?>
                    <br/><?php e($record->anggota_auditor) ?></td>
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