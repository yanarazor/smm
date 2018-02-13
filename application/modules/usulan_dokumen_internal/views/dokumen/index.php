<?php

$num_columns	= 12;
$can_delete	= $this->auth->has_permission('Usulan_Dokumen_Internal.Dokumen.Delete');
$can_edit		= $this->auth->has_permission('Usulan_Dokumen_Internal.Dokumen.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
<br>
	<ul class="nav nav-tabs">
		
		<li<?php echo $filter_type == 'all' ? ' class="active"' : ''; ?>><?php echo anchor(base_url()."index.php/admin/dokumen/usulan_dokumen_internal", "Usulan"); ?></li>
		<?php if($this->auth->has_permission('Usulan_Dokumen_Internal.Dokumen.pengecekan')){ ?>
		<li<?php echo $filter_type == 'periksa' ? ' class="active"' : ''; ?>><?php echo anchor(base_url()."index.php/admin/dokumen/usulan_dokumen_internal/list_periksa", "Periksa"); ?></li>
		<?php } ?>
		<?php if($this->auth->has_permission('Usulan_Dokumen_Internal.Dokumen.pengesahan')){ ?>
		<li<?php echo $filter_type == 'pengesahan' ? ' class="active"' : ''; ?>><?php echo anchor(base_url()."index.php/admin/dokumen/usulan_dokumen_internal/list_pengesahan", "Pengesahan"); ?></li>
		 <?php } ?>
		 
	</ul>
		 <form action="<?php $this->uri->uri_string() ?>" method="get" accept-charset="utf-8">
	 <table>
        	<tr> 
            	<td>
                	<b>Judul</b>
                </td>
				 
                <td>
                	<b>Jenis</b>
                </td>
                
            </tr>
            <tr>
            	<td>
                	 <input id='keyword' type='text' name='keyword' maxlength="20" value="<?php echo set_value('keyword', isset($keyword) ? $keyword : ''); ?>" />
                </td>
                
                 <td>
					<select name="jenis_dokumen" id="jenis_dokumen" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($jenis_docs) && is_array($jenis_docs) && count($jenis_docs)):?>
						<?php foreach($jenis_docs as $jenis_doc):?>
							<option value="<?php echo $jenis_doc->id?>" <?php if(isset($jenis_dokumen))  echo  ($jenis_doc->id==$jenis_dokumen) ? "selected" : ""; ?>> <?php e(ucfirst($jenis_doc->jenis)); ?></option>
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
						
						<th>Judul</th>
						<th>Nomor</th>  
						<th>Jenis Dokumen</th>
						<th>Status Periksa</th>
						 
						<th>Status Sah</th>
						
						<th>File</th>
					</tr>
				</thead>
				<?php if ($has_records) : ?>
				<tfoot>
					<?php if ($can_delete) : ?>
					<tr>
						<td colspan="<?php echo $num_columns; ?>">
							<?php echo lang('bf_with_selected'); ?>
							<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('usulan_dokumen_internal_delete_confirm'))); ?>')" />
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
						<td><?php echo anchor(SITE_AREA . '/dokumen/usulan_dokumen_internal/'.$action."/" . $record->id, '<span class="icon-pencil"></span>' .  $record->judul); ?></td>
					<?php else : ?>
						<td><?php e($record->judul); ?></td>
					<?php endif; ?>
						<td><?php e($record->nomor) ?></td>
						<td><?php e($record->jenis) ?></td>
						<td>
						<?php if($record->status_periksa!=""){
								echo $record->status_periksa=="1" ? "<span class='label label-success'>Ya</span>":"<span class='label label-warning'>Tidak</span>" ;
							}
						?>
							 
						</td>
						<td>
						<?php if($record->status_sah!=""){
								echo $record->status_sah=="1" ? "<span class='label label-success'>Ya</span>":"<span class='label label-warning'>Tidak</span>" ;
							}
						?>
						 
						</td>
						 <td> 
							<?php 
								$fotothum = "";
								$fotoasli = "";
								if(isset($record->filename)) :
									$foto = unserialize($record->filename);
									$fotothum = base_url()."assets/images/attach.gif";
									$fotoasli = base_url().$this->settings_lib->item('site.urluploaded').$foto['file_name'];
								 
								endif;
							?>
							 
								<a href="<?php echo $fotoasli; ?>" target="_blank" class="fancy">
									<img alt="" src="<?php echo $fotothum; ?>">
								</a>
							 
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
	 
					
 
</div>
<script type="text/javascript">	  
$(document).ready(function(){
	 $(".fancy").fancybox({
		'width'  : 1000,           // set the width
		'height' : 800,           // set the height
		//'type'   : 'iframe',       // tell the script to create an iframe
		'scrolling'   : 'no',
		'overlayShow':true,
		'hideOnContentClick':true,
		'type':'iframe'
})
});
	  
</script>