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
                	<b>Tahun</b>
                </td>
            </tr>
            <tr>
            	  
                 <td>
					<input id='tahun' type='text' name='tahun' style="width:100px" value="<?php echo set_value('tahun', isset($tahun) ? $tahun : ''); ?>" />
					
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
function showdata(vartahun){
		$('#kontent').html("<center>Load data...</center>");
		var post_data = "tahun="+vartahun;
		//alert(post_data);
	$.ajax({
			url: "<?php echo base_url() ?>index.php/admin/realisasi/e_realisasi/getrealisasiperbulan",
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
	 
	var vartahun 	= $("#tahun").val();
	 
	showdata(vartahun);
		return false;
	});
</script> 