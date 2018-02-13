<?php

$num_columns	= 8;
$can_delete	= $this->auth->has_permission('Skp.Kepegawaian.Delete');
$can_edit		= $this->auth->has_permission('Skp.Kepegawaian.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
<div class="alert alert-block alert-warning fade in">
		<a class="close" data-dismiss="alert">&times;</a>
		<h4 class="alert-heading">Silahkaan Klik pada menu "Tambah" dikanan atas untuk membuat/merubah SKP, atau Klik pada kolom tahun untuk melihat detil dari SKP</h4>
	</div>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					 
					<th width="100px">Tahun</th>
					<th>Pegawai</th>
					 
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					 <td colspan="2"></td>
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
					 
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/kepegawaian/skp/edit/' . $record->tahun."/".$record->nip, '<span class="icon-pencil"></span>' .  $record->tahun); ?></td>
				<?php else : ?>
					<td><?php e($record->tahun); ?></td>
				<?php endif; ?>
					<td><?php e($record->nama) ?></td>
					 
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