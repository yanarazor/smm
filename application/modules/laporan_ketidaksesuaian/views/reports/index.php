<?php

$num_columns	= 13;
$can_delete	= $this->auth->has_permission('Laporan_Ketidaksesuaian.Reports.Delete');
$can_edit		= $this->auth->has_permission('Laporan_Ketidaksesuaian.Reports.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<h3>Laporan Ketidaksesuaian</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th>Nomor</th>
					<th>Kegiatan</th>
					<th>Penanggung Jawab</th>
					<th>Tanggal Penemuan</th>
					<th>Bidang</th>
					<th>Ketidaksesuaian</th>
					<th>Seharusnya</th>
					<th>Status SWM</th>
					<th>Tgl Persetujuan SWM</th>
					<th>Tgl Persetujuan Kabid</th>
					<th>Keterangan</th>
					<th>Tgl Close</th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						<?php echo lang('bf_with_selected'); ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('laporan_ketidaksesuaian_delete_confirm'))); ?>')" />
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
					<td><?php echo anchor(SITE_AREA . '/reports/laporan_ketidaksesuaian/edit/' . $record->id, '<span class="icon-pencil"></span>' .  $record->nomor); ?></td>
				<?php else : ?>
					<td><?php e($record->nomor); ?></td>
				<?php endif; ?>
					<td><?php e($record->kegiatan) ?></td>
					<td><?php e($record->penanggung_jawab) ?></td>
					<td><?php e($record->tanggal_penemuan) ?></td>
					<td><?php e($record->bidang_bagian) ?></td>
					<td><?php e($record->ketidaksesuaian) ?></td>
					<td><?php e($record->seharusnya) ?></td>
					<td><?php e($record->status_evaluasi_swm) ?></td>
					<td><?php e($record->tgl_persetujuan_swm) ?></td>
					<td><?php e($record->tgl_persetujuan_kabid) ?></td>
					<td><?php e($record->keterangan) ?></td>
					<td><?php e($record->tgl_close) ?></td>
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