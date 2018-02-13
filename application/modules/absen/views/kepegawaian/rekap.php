<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery.timepicker.css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.timepicker.js"></script>
<?php

$num_columns	= 8;
$can_delete	= $this->auth->has_permission('Absen.Kepegawaian.Delete');
$can_edit		= $this->auth->has_permission('Absen.Kepegawaian.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<form action="<?php $this->uri->uri_string() ?>" method="get" id="frmrekap" accept-charset="utf-8">
	 <table>
        	<tr> 
            	<td>
                	<b>NIP</b>
                </td>
				<td>
                	<b>Nama</b>
                </td>
                <td>
                	<b>Bulan</b>
                </td>
                 <td>
                	<b>Tahun</b>
                </td>
                 <td>
                	<b>Role</b>
                </td>
            </tr>
            <tr>
            	<td>
                	 <input id='nip' type='text' name='nip' maxlength="20" value="<?php echo set_value('nip', isset($nip) ? $nip : ''); ?>" />
                </td>
                <td>
					<input id='nama' type='text' name='nama' maxlength="100" value="<?php echo set_value('nama', isset($nama) ? $nama : ''); ?>" />
					 
                </td>
                 <td>
					<select name="bulan" id="bulan"  style="width:150px" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>						 
						<option value="01" <?php if(isset($bulan))  echo  ($bulan=="01") ? "selected" : ""; ?>> Januari </option>
						<option value="02" <?php if(isset($bulan))  echo  ($bulan=="02") ? "selected" : ""; ?>> Februari </option>
						<option value="03" <?php if(isset($bulan))  echo  ($bulan=="03") ? "selected" : ""; ?>> Maret </option>
						<option value="04" <?php if(isset($bulan))  echo  ($bulan=="04") ? "selected" : ""; ?>> April </option>
						<option value="05" <?php if(isset($bulan))  echo  ($bulan=="05") ? "selected" : ""; ?>> Mei </option>
						<option value="06" <?php if(isset($bulan))  echo  ($bulan=="06") ? "selected" : ""; ?>> Juni </option>
						<option value="07" <?php if(isset($bulan))  echo  ($bulan=="07") ? "selected" : ""; ?>> Juli </option>
						<option value="08" <?php if(isset($bulan))  echo  ($bulan=="08") ? "selected" : ""; ?>> Agustus </option>
						<option value="09" <?php if(isset($bulan))  echo  ($bulan=="09") ? "selected" : ""; ?>> September </option>
						<option value="10" <?php if(isset($bulan))  echo  ($bulan=="10") ? "selected" : ""; ?>> Oktober </option>
						<option value="11" <?php if(isset($bulan))  echo  ($bulan=="11") ? "selected" : ""; ?>> November </option>
						<option value="12" <?php if(isset($bulan))  echo  ($bulan=="12") ? "selected" : ""; ?>> Desember </option>
						
					</select>
					 
                </td>
                 
                 <td>
					<input id='tahun' type='text' name='tahun' style="width:100px" value="<?php echo set_value('tahun', isset($tahun) ? $tahun : ''); ?>" />
					
                </td>
                <td>
                	<select name="role" id="role">
						<option value="">-- Pilih  --</option>
						<?php if (isset($roles) && is_array($roles) && count($roles)):?>
						<?php foreach($roles as $rec):?>
							<option value="<?php echo $rec->role_id;?>-<?php echo $rec->role_name;?>" <?php if(isset($role))  echo  ($rec->role_id==$role) ? "selected" : ""; ?>><?php echo $rec->role_name;?></option>
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
	showdata("","","","","");
});
function showdata(varnip,varnama,varbulan,vartahun,varrole){
		$('#kontent').html("<center>Load data...</center>");
		var post_data = "nip="+varnip+"&nama="+varnama+"&bulan="+varbulan+"&tahun="+vartahun+"&role="+varrole;
		//alert("<?php echo base_url() ?>admin/kepegawaian/absen/rekap_content"+post_data);
	$.ajax({
			url: "<?php echo base_url() ?>index.php/admin/kepegawaian/absen/rekap_content",
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
	 
	var varbulan 	= $("#bulan").val();
	var vartahun 	= $("#tahun").val();
	var varnip 		= $("#nip").val();
	var varnama 	= $("#nama").val();
	var varrole 	= $("#role").val();
	showdata(varnip,varnama,varbulan,vartahun,varrole);
		return false;
	});
</script> 