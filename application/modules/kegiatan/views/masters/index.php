<?php

$num_columns	= 6;
$can_delete	= $this->auth->has_permission('Kegiatan.Masters.Delete');
$can_edit		= $this->auth->has_permission('Kegiatan.Masters.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	 <form action="<?php $this->uri->uri_string() ?>" method="get" accept-charset="utf-8">
	 <table>
        	<tr> 
            	<td>
                	<b>Tahun</b>
                </td> 
                <td>
                	<b>Judul</b>
                </td> 
                <td> &nbsp;&nbsp;
                	<b>Penanggung Jawab</b>
                </td> 
            </tr> 
            <tr>
            	<td>
                	<input id='tahun' type='text' name='tahun' maxlength="20" value="<?php echo isset($tahun) ? $tahun : ''; ?>" />
                </td>
                <td>
                	<input id='judul' type='text' name='judul' maxlength="20" value="<?php echo isset($judul) ? $judul : ''; ?>" />
                </td>
				<td valign="top"> &nbsp;&nbsp;
                	 <select name="pj" id="pj" class="chosen-select-deselect" style="width:400px">
						<option value="">-- Pilih  --</option>
						<?php if (isset($users) && is_array($users) && count($users)):?>
						<?php foreach($users as $rec):?>
							<option value="<?php echo $rec->id?>" <?php if(isset($pj))  echo  ($rec->id==$pj) ? "selected" : ""; ?>> <?php e(ucfirst($rec->display_name)); ?></option>
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
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th>Tahun</th>
					<th>Dipa</th>
					<th>Kode</th>
					<th>Judul</th>
					<th>PJ</th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						<?php echo lang('bf_with_selected'); ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('kegiatan_delete_confirm'))); ?>')" />
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
					<td><?php echo anchor(SITE_AREA . '/masters/kegiatan/edit/' . $record->id, '<span class="icon-pencil"></span>' .  $record->tahun); ?></td>
				<?php else : ?>
					<td><?php e($record->tahun); ?></td>
				<?php endif; ?>
					<td><?php e($record->dipa) ?></td>
					<td><?php e($record->kode) ?></td>
					<td><?php e($record->judul) ?></td>
					<td><?php e($record->penanggung_jawab) ?></td>
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

<link href="<?php echo base_url(); ?>assets/css/chosen/chosen.css" rel="stylesheet" type="text/css" />
<script language='JavaScript' type='text/javascript' src='<?php echo base_url(); ?>assets/js/chosen/chosen.jquery.js'></script>
<script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>