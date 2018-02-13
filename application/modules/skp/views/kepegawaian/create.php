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
				<?php echo form_label('Tahun', 'skp_tahun', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='nip' type='hidden' name='nip' maxlength="30" value="<?php echo set_value('nip', isset($skp['nip']) ? $skp['nip'] : $nip); ?>" />
					<input id='tahun' type='text' name='tahun' maxlength="4" value="<?php echo set_value('tahun', isset($skp['tahun']) ? $skp['tahun'] : $tahun); ?>" />
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
 			<input id="txtarry" name="txtarry" type="hidden" value="0"/>
			  <a href="#" class="btn btn-small btn-success pull-right" id="btnaddbarang">
				   <i class="icon-plus"></i> Tambah Kegiatan
			   </a>

		</fieldset>

			  
		<fieldset>
			<br>
			   <table class="divbarang table table-striped" border="1">
			   		<tr>
			   			<th rowspan="2"> No </th>
			   			<th rowspan="2" width="40%"> Kegiatan Tugas Jabatan </th>
			   			<th width="10px" rowspan="2"> AK </th>
			   			<th colspan="5"> Target</th>
			   		</tr>
			   		<tr>
			   			<th> Kuantitas </th>
			   			<th> Output </th>
			   			<th> Kual/Mutu </th>
			   			<th> Waktu </th>
			   			<th> Biaya</th>
			   			
			   		</tr>
				   <?php
					  echo $this->load->view('kepegawaian/dinamicedit',array("index"=>'0',"records"=>$records));
				   ?>
			   </table>
			
			<div class="form-actions">
				<input type="submit" name="save" id="btnsave" class="btn btn-primary" value="Simpan SKP"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/kepegawaian/skp', lang('skp_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
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
	 
$(".delete").live('click', function(event) {
	if (confirm("Hapus baris ini?")) {
       $(this).parent().parent().remove();
       return false;
    }
	return false;
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