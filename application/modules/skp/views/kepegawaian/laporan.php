
<?php

$validation_errors = validation_errors();

if ($validation_errors) :
?>
<div class="alert alert-block alert-error fade in">
	<a class="close" data-dismiss="alert">&times;</a>
	<h4 class="alert-heading">Please fix the following errors:</h4>
	<?php echo $validation_errors; ?>
</div>
<?php
endif;

if (isset($skp))
{
	$skp = (array) $skp;
}
$id = isset($skp['id']) ? $skp['id'] : '';

?>
<div class="admin-box">
	

	<div class="messages">
    </div>
	<?php echo form_open($this->uri->uri_string(), 'id = "frm"'); ?>
		<fieldset>
			<br>
			<div class="control <?php echo form_error('tahun') ? 'error' : ''; ?> span12">
				<?php echo form_label('Tahun : '.$tahun, 'skp_tahun', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='nip' type='hidden' name='nip' maxlength="30" value="<?php echo set_value('nip', isset($skp['nip']) ? $skp['nip'] : $nip); ?>" />
					<input id='tahun' type='hidden' name='tahun' maxlength="4" value="<?php echo set_value('tahun', isset($skp['tahun']) ? $skp['tahun'] : $tahun); ?>" />
					<span class='help-inline'><?php echo form_error('tahun'); ?></span>

				</div>
			</div>
			<div class="control-group <?php echo form_error('tahun') ? 'error' : ''; ?> span5">
				<?php echo form_label('Nama', 'skp_tahun', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo $nama; ?>
				</div>
			</div>
			<div class="control-group <?php echo form_error('tahun') ? 'error' : ''; ?> span6" >
				<?php echo form_label('Atasan', 'skp_tahun', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo $namaatasan; ?>
				</div>
			</div>
		</fieldset>

			  
		<fieldset>
			<br>
			   <table class="divbarang table table-striped" border="1">
			   		<tr>
			   			<th width="10px"> No </th>
			   			<th width="40%"> Kegiatan </th>
			   			<th> Target | Satuan </th>
			   			<th width="40px"> Waktu </th>
			   			<th> Capaian </th>
			   			<th> Pemantauan </th>
			   			<th width="10%"> Jumlah Jam </th>
			   		</tr>
				   <?php if (isset($records) && is_array($records) && count($records)) : 
					$index = 0;
					foreach ($records as $recorddetil) :
					//print_r($recorddetil);
					//echo $recorddetil->nip;
					?> 
					 
						<tr> 
							<td>
								<?php echo $index+1; ?>.
							</td>
							<td width="30px" height="40px">
								<input id='id_<?=$index?>' type='hidden' name='id[]' value="<?php echo $recorddetil->id; ?>" maxlength="100"/>
								<?php echo $recorddetil->kegiatan; ?>
							</td>
							<td width="250px">
								<?php echo $recorddetil->target; ?> 
								<?php echo $recorddetil->satuan; ?>
							</td>
							  <td width="20px">
								 <?php echo $recorddetil->waktu; ?>
							  </td>
							  <td width="250px">
								<?php echo $recorddetil->capaian; ?>
							  	<?php echo $recorddetil->satuan; ?>
							  </td>
							  <td width="200px">
								 <?php echo $recorddetil->pemantauan; ?>
							  </td>
							<td>
							<?php echo $recorddetil->jumlah_jam != "" ? $recorddetil->jumlah_jam : "0"; ?> Jam
							</td>
						</tr>
					 
					<?php
					$index++;
					endforeach;
					endif;
					?>
			   </table>
			
			 
		</fieldset>
    <?php echo form_close(); ?>
</div>
<script>  	

	var index = 0;
	$(document).ready(function() {	
	   $( "#btnaddbarang" ).click(function() {
	   		index = index + 1;
	   		
			var nilai = index;
			var json_url = "<?php echo base_url() ?>admin/kepegawaian/skp/additem/";
			$.ajax({    type: "POST",
			   url: json_url,
			   data: "index="+nilai,
			   success: function(data){ 
				   $('.divbarang').append(data);
			   }});
			return false; 
			   
	   });
	 
	});	
	 
 	
    $("#btnsave").click(function(){
        submitdata();
        return false; 
    }); 
    $("#btncancel").click(function(){
        $("#modal-global").modal("hide");
    });
    $("#frma").submit(function(){
        submitdata();
        return false; 
    }); 
    function submitdata(){
        var json_url = "<?php echo base_url() ?>admin/kepegawaian/skp/saveskp";
         $.ajax({    
            type: "POST",
            url: json_url,
            data: $("#frm").serialize(),
            dataType: "json",
            success: function(data){ 
                if(data.success){
                    swal("Pemberitahuan!", data.msg, "success");
                }
                else {
                    $(".messages").empty().append(data.msg);
                }
            }});
        return false; 
    }
</script>
<script type="text/javascript">
 
$('body').on('click','.delete',function () { 
	var kode =$(this).attr("kode");
	swal({
		title: "Anda Yakin?",
		text: "Hapus baris ini!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: 'btn-danger',
		confirmButtonText: 'Ya, Delete!',
		cancelButtonText: "Tidak, Batalkan!",
		closeOnConfirm: false,
		closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
			var post_data = "kode="+kode;
			//alert("<?php echo base_url() ?>admin/masters/data_ptp/deletedata"+post_data)
			$.ajax({
					url: "<?php echo base_url() ?>admin/kepegawaian/skp/deletedata",
					type:"POST",
					data: post_data,
					dataType: "html",
					timeout:180000,
					success: function (result) {
						swal("Deleted!", result, "success");
						//location.reload();
				},
				error : function(error) {
					alert(error);
				} 
			});        
			
		} else {
			swal("Batal", "", "error");
		}
	});
});

</script>