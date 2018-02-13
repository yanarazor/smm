<?php

$num_columns	= 8;
$can_delete	= $this->auth->has_permission('E_Realisasi.Realisasi.Delete');
$can_edit		= $this->auth->has_permission('E_Realisasi.Realisasi.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<form action="<?php $this->uri->uri_string() ?>" method="get" id="frmrekap" accept-charset="utf-8">
	 <table>
	 	<tr> 
			 
			<td>
				<b>Kegiatan</b>
			</td>
		</tr>
		<tr>
			 
                <td>
					<select name="kegiatan" id="kegiatan" class="chosen-select-deselect" style="width:100px">
						<option value="">-- Pilih  --</option>
						
						<?php if (isset($masterkegiatans) && is_array($masterkegiatans) && count($masterkegiatans)):?>
						<?php foreach($masterkegiatans as $rec):?>
							<option value="<?php echo $rec->kdkmpnen;?>-<?php echo $rec->kdskmpnen?>" <?php if(isset($kegiatan))  echo  ($rec->kdkmpnen==$kegiatan) ? "selected" : ""; ?>> <?php e(ucfirst($rec->kdkmpnen)); ?><?php e(ucfirst($rec->kdskmpnen)); ?> </option>
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
    <div class="tab-content" style="padding-bottom: 9px; border-bottom: 1px solid #ddd;" id="kontent">
		 content
   </div>
   
</div>
<script type="text/javascript">  
$(document).ready(function() {	 
	showdata("","","","");
});
function showdata(varkegiatan,varoutput){
		$('#kontent').html("<center>Load data...</center>");
		var post_data = "kegiatan="+varkegiatan+"&output="+varoutput;
		//alert("<?php echo base_url() ?>admin/realisasi/e_realisasi/getrkakl");
	$.ajax({
			url: "<?php echo base_url() ?>index.php/admin/realisasi/e_realisasi/getrkakl",
			type:"POST",
			data: post_data,
			dataType: "html",
			timeout:180000,
			success: function (result) {
				 
				$('#kontent').html(result);
		},
		error : function(error) {
			alert(error);
		} 
	});        
} 
$("#frmrekap").submit( function() {
	 
	var varkegiatan 	= $("#kegiatan").val();
	var varoutput 	= "";//$("#output").val();
	 
	showdata(varkegiatan,varoutput);
		return false;
	});
</script> 