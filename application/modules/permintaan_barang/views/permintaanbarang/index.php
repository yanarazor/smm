<?php

$num_columns	= 10;
$can_delete	= $this->auth->has_permission('Permintaan_Barang.Permintaanbarang.Delete');
$can_edit		= $this->auth->has_permission('Permintaan_Barang.Permintaanbarang.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<form action="<?php $this->uri->uri_string() ?>" method="get" accept-charset="utf-8">
	 <table>
        	<tr> 
            	<td>
                	<b>Nomor</b>
                </td> 
                <td>
                	<b>user</b>
                </td>  
                <td>
                	<b>Tahun</b>
                </td>  
                <td>
                	<b>Kegiatan</b>
                </td>  
                 <td>
                	<b>Status</b>
                </td> 
            </tr> 
            <tr>
            	<td>
                	<input id='keyword' type='text' name='keyword' maxlength="20" value="<?php echo set_value('keyword', isset($keyword) ? $keyword : ''); ?>" />
                </td>
                
				<td valign="top">
					<select name="pg" id="pg" class="chosen-select-deselect">
						<option value="">-- Pegawai  --</option>
						<?php if (isset($users) && is_array($users) && count($users)):?>
						<?php foreach($users as $rec):?>
							<option value="<?php echo $rec->id?>" <?php if(isset($pg))  echo  ($rec->id==$pg) ? "selected" : ""; ?>> <?php e(ucfirst($rec->display_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
                </td>
                <td>
					<input id='tahun' type='text' name='tahun' style="width:60px" value="<?php echo set_value('tahun', isset($tahun) ? $tahun : ''); ?>" />
                </td>
                <td>
					<select name="kg" id="kg">
						<option value="">-- Pilih  --</option>
						<?php if (isset($kegiatans) && is_array($kegiatans) && count($kegiatans)):?>
						<?php foreach($kegiatans as $rec):?>
							<option value="<?php echo $rec->kode?>" <?php if(isset($kg))  echo  ($rec->kode==$kg) ? "selected" : ""; ?>> <?php e(ucfirst($rec->judul)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
                </td>
                <td>
                	<select name="status" id="status" >
						<option value="">-- Pilih  --</option>
						<?php if (isset($status_permintaans) && is_array($status_permintaans) && count($status_permintaans)):?>
						<?php foreach($status_permintaans as $rec):?>
							<option value="<?php echo $rec->id?>" <?php if(isset($status))  echo  ($rec->id==$status) ? "selected" : ""; ?>> <?php e(ucfirst($rec->nama_status)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
                	 
				</td>
                <td valign="top">
                	 <input type="submit" name="Act" class="btn btn-primary" value="Cari "  />
               	</td> 
            
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
					
					<th>Nomor</th>
					<th>User</th>
					<th>Tanggal Permintaan</th>
					<th>Anggaran</th>
					<th>Kegiatan</th>
					<th>Tanggal Permintaan <br> Selesai</th>
					<!--
					<th>Status PPK/PJ Kegiatan</th>
					<th>Status Kasubag KPU</th>
					-->
					<th>Status Permintaan</th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						<?php echo lang('bf_with_selected'); ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('permintaan_barang_delete_confirm'))); ?>')" />
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
					<td><?php echo anchor(SITE_AREA . '/permintaanbarang/permintaan_barang/edit/' . $record->id, '<span class="icon-pencil"></span>' .  $record->nomor); ?></td>
				<?php else : ?>
					<td><?php e($record->nomor); ?></td>
				<?php endif; ?>
					<td><?php e($record->display_name) ?></td>
					<td><?php e($record->tanggal_permintaan) ?></td>
					<td><?php e($record->anggaran) ?></td>
					<td><?php e($record->kegiatan) ?></td>
					<td><?php e($record->tanggal_selesai) ?></td>
					<!--
					<td>
						<?php
							echo $record->status_atasan =="" ? "<span class='label label-warning'>Menunggu Persetujuan</span>":"" ; 
							echo $record->status_atasan =="1" ? "<span class='label label-success'>Ya</span>":"" ;
							echo $record->status_atasan =="2" ? "<span class='label label-warning'>Tidak</span>":"" ;
						?> 
					</td>
					<td>
						<?php
							echo $record->status_kabag=="" ? "<span class='label label-warning'>Menunggu Persetujuan</span>":"" ; 
							 echo $record->status_kabag=="1" ? "<span class='label label-success'>Ya</span>":"" ;
							 echo $record->status_kabag=="2" ? "<span class='label label-warning'>Tidak</span>":"" ;
						?> 
					</td>
					-->
					<td>
						<a href="<?php echo base_url();?>admin/permintaanbarang/permintaan_barang/timeline/<?php echo $record->id; ?>" class="fancybox">
						 
						
						<?php 
						if($record->nama_status == "Pengadaan")
							echo $record->nama_status == "Pengadaan" ? "<span class='label label-info'>Pengadaan</span>":"" ; 
						else if($record->nama_status == "Selesai")
							echo $record->nama_status == "Selesai" ? "<span class='label label-success'>Selesai</span>":"" ; 
						else if($record->nama_status == "Persediaan")
							echo $record->nama_status == "Persediaan" ? "<span class='label label-danger'>Persediaan</span>":"" ; 
						else
							echo "<span class='label label-warning'>".$record->nama_status."</span>"; 
						?>
						 
						</a>
						<?php
							echo isset($record->catatan_atasan) ? "<br>".$record->catatan_atasan : ""; 
							echo isset($record->catatan_kpu) ? "<br>".$record->catatan_kpu : ""; 
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
<script type="text/javascript">	  
$(document).ready(function(){
	 $(".fancybox").fancybox({
		'width'  : 1000,           // set the width
		'height' : 800,           // set the height
		'type'   : 'iframe',       // tell the script to create an iframe
		 
		'overlayShow':true,
		'hideOnContentClick':true,
		'type':'iframe'
})
});
	  
</script>
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