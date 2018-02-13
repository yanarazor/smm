<?php
	$this->load->library('convert');
	$convert = new convert();
$num_columns	= 8;
$can_delete	= $this->auth->has_permission('Kegiatan.Masters.Delete');
$can_edit		= $this->auth->has_permission('Kegiatan.Masters.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	 <form action="<?php $this->uri->uri_string() ?>" method="get" accept-charset="utf-8">
	 <table>
        	 
            <tr>
            	 
				<td valign="top">  
                	<select name="kegiatan" id="kegiatan" class="chosen-select-deselect" style="width:100%">
						<option value="">-- Pilih  --</option>
						<?php if (isset($masterkegiatans) && is_array($masterkegiatans) && count($masterkegiatans)):?>
						<?php foreach($masterkegiatans as $rec):?>
							<option value="<?php echo $rec->kdkmpnen;?>-<?php echo $rec->kdskmpnen?>" <?php if(isset($kegiatan))  echo  ($rec->kdkmpnen==$kegiatan) ? "selected" : ""; ?>> <?php e(ucfirst($rec->kdkmpnen)); ?><?php e(ucfirst($rec->kdskmpnen)); ?> <?php e(ucfirst($rec->urskmpnen)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
                </td>
                <td valign="middle">
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
					<th> No Kuitansi </th>
					<th>Tanggal</th>
					<th>Kegiatan</th>
					<th>Akun</th>
					<th>Rupiah</th>
					<th>Uraian</th>
					<th>Status</th>
					<th>SPBY</th>
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
					<?php if ($can_delete) : ?>
					<td class="column-check"><input type="checkbox" name="checked[]" value="" /></td>
					<?php endif;?>
				 	<td><?php e($record->nokwt); ?></td>
				 	<td><?php e($record->tglkwt); ?></td>
					<td><?php e($record->kdkmpnen); e($record->kdskmpnen); ?></td>
				 
					<td><?php e($record->kdakun) ?></td>
					<td align="right"><?php  echo $convert->ToRpnosimbol((Double)$record->rupiah); ?></td>
					<td><?php e($record->uraian) ?></td>
					<td align="center">
					<?php if($record->kdakunrkakl == ""){
					?>
					 
						 <a href="<?php echo base_url(); ?>index.php/admin/realisasi/e_realisasi/setkuitansi?kdkmpnen=<?php echo $record->kdkmpnen; ?>&kdskmpnen=<?php echo $record->kdskmpnen; ?>&kdoutput=<?php echo $record->kdoutput; ?>&kdsoutput=<?php echo $record->kdsoutput; ?>&kdakun=<?php echo $record->kdakun; ?>&nokwt=<?php echo $record->nokwt; ?>" class="fancybox"> 
						 	<span class='label label-warning'>Set RKAKL</span>
						 </a>
						
					<?php
					} ?>
					<?php if($record->kdakunrkakl != ""){
					?>
					 
						 <a href="#" class="deletekwt" kdkmpnen="<?php echo $record->kdkmpnen; ?>" nokwt="<?php echo $record->nokwt; ?>"> 
						 	<span class='label label-info'>Delete</span>
						 </a>
						
					<?php
					} ?>
					</td>
					<td align="center">
					 
					 
						 <a href="<?php echo base_url(); ?>index.php/admin/realisasi/e_realisasi/buatspby?notran=<?php echo $record->notran;?>&nokwt=<?php echo $record->nokwt; ?>" target="_blank"> 
						 	<span class='label label-warning'>Buat SPBY</span>
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
<script type="text/javascript">   
$(".deletekwt").click(function(){
	if (!confirm("Anda yakin?")) {
        return false;
    }
  var nokwt = $(this).attr('nokwt');
  var post_data = "nokwt="+nokwt;
	//alert("<?php echo base_url() ?>admin/realisasi/e_realisasi/delkuitansirkakl?"+post_data);
	$.ajax({
			url: "<?php echo base_url() ?>index.php/admin/realisasi/e_realisasi/delkuitansirkakl",
			type:"POST",
			data: post_data,
			dataType: "html",
			timeout:180000,
			success: function (result) {
				 alert(result);
				 parent.jQuery.fancybox.close();
				 parent.location.reload(true); 
		},
		error : function(error) {
			alert(error);
		} 
	});        
  return false;
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