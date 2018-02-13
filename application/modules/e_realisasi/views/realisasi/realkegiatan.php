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
				<b>Output</b>
			</td>
			<td>
				<b></b>
			</td>
		</tr>
		<tr>
			 <td>
				<select name="output" id="output" class="chosen-select-deselect" style="width:500px">
					<option value="">-- Pilih  --</option>
					<?php if (isset($masteroutput) && is_array($masteroutput) && count($masteroutput)):?>
					<?php foreach($masteroutput as $rec):?>
						<option value="<?php echo $rec->kdgiat;?>-<?php echo $rec->kdoutput;?>-<?php echo $rec->kdsoutput?>" <?php if(isset($output))  echo  ($rec->kdoutput==$output) ? "selected" : ""; ?>> <?php e(ucfirst($rec->ursoutput)); ?> [<?php echo $rec->kdgiat;?>-<?php echo $rec->kdoutput;?>-<?php echo $rec->kdsoutput?>]</option>
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
		//alert("<?php echo base_url() ?>admin/realisasi/e_realisasi/realisasiperkegiatan");
	$.ajax({
			url: "<?php echo base_url() ?>admin/realisasi/e_realisasi/realisasiperkegiatan",
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
	var varoutput 	= $("#output").val();
	 
	showdata(varkegiatan,varoutput);
		return false;
	});
</script> 