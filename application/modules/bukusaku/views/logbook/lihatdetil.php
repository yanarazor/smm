<?php

$num_columns	= 7;
$can_delete	= $this->auth->has_permission('Bukusaku.Logbook.Delete');
$can_edit		= $this->auth->has_permission('Bukusaku.Logbook.Edit');
$has_records	= isset($records) && is_array($records) && count($records);
?>
<div class="admin-box">
	<div class="messages">
    </div>
	<?php echo form_open($this->uri->uri_string(), 'id = "frm" class="form-horizontal"'); ?>
		<fieldset>
			<div class="control-group <?php echo form_error('tanggal') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal', 'bukusaku_tanggal', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo $records->tanggal; ?>
					<span class='help-inline'><?php echo form_error('tanggal'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('jam') ? 'error' : ''; ?>">
				<?php echo form_label('Dari Jam', 'bukusaku_jam', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo $records->jam; ?>
					<span class='help-inline'><?php echo form_error('jam'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('jam') ? 'error' : ''; ?>">
				<?php echo form_label('Sampai Jam', 'bukusaku_jam', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo $records->sampai_jam; ?>
					<span class='help-inline'><?php echo form_error('sampai_jam'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('pk') ? 'error' : ''; ?>">
				<?php echo form_label('Butir SKP', 'pk', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo $records->kegiatan_skp; ?>
					<span class='help-inline'><?php echo form_error('pk'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('kegiatan') ? 'error' : ''; ?>">
				<?php echo form_label('Kegiatan', 'bukusaku_kegiatan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo $records->kegiatan; ?>
					<span class='help-inline'><?php echo form_error('kegiatan'); ?></span>
				</div>
			</div>

			 <div class="form-actions">
			 	<a href='#' misi="<?php echo $records->id; ?>" kode="<?php echo $records->id; ?>" class='delete btn-large btn-danger'>
				<i class='fa fa-trash fa-stack-1x fa-inverse'></i>Hapus Kegiatan
				</a>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>
 
<script type="text/javascript">
 $(".delete").click(function(){
  var kode =$(this).attr("kode");
  var valmisi =$(this).attr("misi");
  swal({
    title: "Anda Yakin?",
    text: "Hapus kegiatan ini",
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
      //alert("<?php echo base_url() ?>admin/perencanaan/perencanaan_kecamatan/deletedatainfra"+post_data)
      $.ajax({
          url: "<?php echo base_url() ?>admin/logbook/bukusaku/deletebukusaku",
          type:"POST",
          data: post_data,
          dataType: "html",
          timeout:180000,
          success: function (result) {
             //$(".delete").closest( 'tr').remove();
             $('#calendar').fullCalendar( 'refetchEvents' );
             swal("Deleted!", result, "success");
             $("#modal-global").modal("hide");

             
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