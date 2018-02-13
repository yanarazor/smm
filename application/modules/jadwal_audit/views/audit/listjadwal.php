<?php

$num_columns	= 7;
$can_delete	= $this->auth->has_permission('Jadwal_Audit.Audit.Delete');
$can_edit		= $this->auth->has_permission('Jadwal_Audit.Audit.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	 
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Bidang</th>
					<th>PM/PR/IK</th>
					<th>Klausul</th>
					<th>Tanggal</th>
                    <th>Auditor</th>
				</tr>
			</thead>
			 
			<tbody>
				<?php
				if ($has_records) :
					foreach ($records as $record) :
				?>
				<tr>
					 
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