
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

if (isset($bukusaku))
{
	$bukusaku = (array) $bukusaku;
}
$id = isset($bukusaku['id']) ? $bukusaku['id'] : '';

?>
<div class="admin-box">
	<div class="messages">
    </div>
	<?php echo form_open($this->uri->uri_string(), 'id = "frm" class="form-horizontal"'); ?>
		<fieldset>
			<div class="control-group <?php echo form_error('tanggal') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal', 'bukusaku_tanggal', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='bukusaku_tanggal' class="datepicker" type='text' name='bukusaku_tanggal'  value="<?php echo set_value('bukusaku_tanggal', isset($bukusaku['tanggal']) ? $bukusaku['tanggal'] : $tanggal); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('jam') ? 'error' : ''; ?>">
				<?php echo form_label('Dari Jam', 'bukusaku_jam', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='bukusaku_jam' class="timeformat"  type='text' name='bukusaku_jam'  value="<?php echo set_value('bukusaku_jam', isset($bukusaku['jam']) ? $bukusaku['jam'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('jam'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('jam') ? 'error' : ''; ?>">
				<?php echo form_label('Sampai Jam', 'bukusaku_jam', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='sampai_jam' class="timeformat"  type='text' name='sampai_jam'  value="<?php echo set_value('bukusaku_jam', isset($bukusaku['sampai_jam']) ? $bukusaku['sampai_jam'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('sampai_jam'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('pk') ? 'error' : ''; ?>">
				<?php echo form_label('SKP', 'pk', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select class="validate[required] text-input" name="pk" id="pk" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($kegiatans) && is_array($kegiatans) && count($kegiatans)):?>
						<?php foreach($kegiatans as $rec):?>
							<option value="<?php echo $rec->id?>" <?php if(isset($permintaan_barang['pk']))  echo  ($rec->kode==$permintaan_barang['pk']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->kegiatan)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('pk'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('kegiatan') ? 'error' : ''; ?>">
				<?php echo form_label('Kegiatan', 'bukusaku_kegiatan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'bukusaku_kegiatan', 'id' => 'bukusaku_kegiatan', 'rows' => '5', 'cols' => '80', 'value' => set_value('bukusaku_kegiatan', isset($bukusaku['kegiatan']) ? $bukusaku['kegiatan'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('kegiatan'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" id="btnsave" value="Simpan"  />
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript">	  
$('.timeformat').timepicker({ 'timeFormat': 'H:i:s' });
$('#bukusaku_tanggal').datepicker({ dateFormat: 'yy-mm-dd'});

</script>
<script>
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
        var json_url = "<?php echo base_url() ?>admin/logbook/bukusaku/savedatalog";
         $.ajax({    
            type: "POST",
            url: json_url,
            data: $("#frm").serialize(),
            dataType: "json",
            success: function(data){ 
                if(data.success){
                    
                    
                    $("#modal-global").modal("hide");
                    $('#calendar').fullCalendar( 'refetchEvents' );
                    swal("Pemberitahuan!", data.msg, "success");
                }
                else {
                    $(".messages").empty().append(data.msg);
                }
            }});
        return false; 
    }
</script>