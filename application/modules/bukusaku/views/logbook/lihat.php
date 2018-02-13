<?php

$num_columns	= 7;
$can_delete	= $this->auth->has_permission('Bukusaku.Logbook.Delete');
$can_edit		= $this->auth->has_permission('Bukusaku.Logbook.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					 
					<th>Tanggal/Jam</th>
					<th>Kegiatan</th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						 
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
					<td><?php e($record->tanggal) ?>
					<br>
					<?php e($record->jam) ?>-<?php e($record->sampai_jam) ?></td>
					<td><?php e($record->kegiatan) ?></td>
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