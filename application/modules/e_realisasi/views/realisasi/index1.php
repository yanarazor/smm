<?php

$num_columns	= 8;
$can_delete	= $this->auth->has_permission('E_Realisasi.Realisasi.Delete');
$can_edit		= $this->auth->has_permission('E_Realisasi.Realisasi.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<form action="<?php $this->uri->uri_string() ?>" method="get" id="frmrekap" accept-charset="utf-8">
	 <table width="width:100%" border="0">
        	<tr> 
        		<td width="15%">
                	<b>Tahun</b>
                </td>
        		<td width="15%">
                	<b>MAK</b>
                </td>
            	<td width="50%">
                	<b>Sub Output</b>
                </td>
				 
            </tr>
            <tr>
            	<td>
                	<input type="text" name="tahun" id="tahun" value="" style="width:90%"/>
                </td>
                <td>
                	<input type="text" name="mak" id="mak" value="" style="width:90%"/>
                </td>
            	 <td>
                	<select name="output" id="output" class="chosen-select-deselect" style="width:100%">
						<option value="">-- Pilih  --</option>
						<?php if (isset($masteroutput) && is_array($masteroutput) && count($masteroutput)):?>
						<?php foreach($masteroutput as $rec):?>
							<option value="<?php echo $rec->kdgiat;?>" <?php if(isset($output))  echo  ($rec->kdoutput==$output) ? "selected" : ""; ?>> </option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
                </td>
                
                <td valign="top">
                	 <input type="submit" name="Act" class="btn btn-primary" value="Cari "  /> &nbsp;
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
function showdata(varmak,varoutput,tahun){
		$('#kontent').html("<center>Load data...</center>");
		var valkey 	= $("#key").val();
		//alert(valkey);
		var post_data = "varmak="+varmak+"&output="+varoutput+"&tahun="+tahun;
		//alert("<?php echo base_url() ?>admin/realisasi/e_realisasi/realisasisascon?"+post_data);
	$.ajax({
			url: "<?php echo base_url() ?>admin/realisasi/e_realisasi/realisasisascon",
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
	 
	var varmak 	= $("#mak").val();
	var varoutput 	= $("#output").val();
	var vartahun 	= $("#tahun").val(); 
	showdata(varmak,varoutput,vartahun);
		return false;
	});
</script> 