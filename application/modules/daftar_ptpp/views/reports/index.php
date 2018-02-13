<?php

$num_columns	= 19;
$can_delete	= $this->auth->has_permission('Daftar_ptpp.Reports.Delete');
$can_edit		= $this->auth->has_permission('Daftar_ptpp.Reports.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<h3>daftar ptpp</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th>Ditujukan Kepada</th>
					<th>Diajukan Oleh</th>
					<th>No PTPP</th>
					<th>Tanggal</th>
					<th>Referensi</th>
					<th>Kategori</th>
					<th>Deskripsi Ketidaksesuaian</th>
					<th>Tgl Pengusulan</th>
					<th>Tanggal Tanda Tangan Auditi</th>
					<th>Hasil Investigasi</th>
					<th>Tgl Tanda Tangan Hasil</th>
					<th>Tindakan Koreksi</th>
					<th>Tindakan Korektif</th>
					<th>Tgl Penyelesaian</th>
					<th>Disetujui Oleh</th>
					<th>Tgl Disetujui</th>
					<th>Tinjauan Tindakan Perbaikan</th>
					<th>Kesimpulan</th>
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
					<td><?php echo anchor(SITE_AREA . '/reports/daftar_ptpp/edit/' . $record->id, '<span class="icon-pencil"></span>' .  $record->ditujukan_kepada); ?></td>
				<?php else : ?>
					<td><?php e($record->ditujukan_kepada); ?></td>
				<?php endif; ?>
					<td><?php e($record->diajukan_oleh) ?></td>
					<td><?php e($record->no_ptpp) ?></td>
					<td><?php e($record->tgl_ptpp) ?></td>
					<td><?php e($record->referensi) ?></td>
					<td><?php e($record->kategori) ?></td>
					<td><?php e($record->deskripsi_ketidaksesuaian) ?></td>
					<td><?php e($record->tanggal_pengusulan) ?></td>
					<td><?php e($record->tanggal_tandatangan_auditi) ?></td>
					<td><?php e($record->hasil_investigasi) ?></td>
					<td><?php e($record->tgl_tandatangan_hasil) ?></td>
					<td><?php e($record->tindakan_koreksi) ?></td>
					<td><?php e($record->tindakan_korektif) ?></td>
					<td><?php e($record->tgl_penyelesaian) ?></td>
					<td><?php e($record->disetujui_oleh) ?></td>
					<td><?php e($record->tanggal_disetujui) ?></td>
					<td><?php e($record->tinjauan_tindakan_perbaikan) ?></td>
					<td><?php e($record->kesimpulan) ?></td>
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