<link rel="stylesheet" href="<?php echo base_url(); ?>themes/admin/css/dropzone/dropzone.min.css">
<script src="<?php echo base_url(); ?>themes/admin/js/dropzone/dropzone.min.js"></script>
<script src="<?php echo base_url(); ?>themes/admin/js/sweetalert.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/admin/css/sweetalert.css">
<div class="alert alert-block alert-warning fade in">
	<a class="close" data-dismiss="alert">&times;</a>
	<h4 class="alert-heading">Perhatian :</h4>
	Silahkan upload surat dokter atau sampaikan ke subbagian kepegawaian dan umum
</div>
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

if (isset($surat_izin))
{
	$surat_izin = (array) $surat_izin;
}
	$id = isset($surat_izin['id']) ? $surat_izin['id'] : '';
?>
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal" id="frmsakit"'); ?>
		<fieldset>
			<div class="control-group <?php echo form_error('surat_izin_lama') ? 'error' : ''; ?>">
				<?php echo form_label('Selama'. lang('bf_form_label_required'), 'surat_izin_lama', array('class' => 'control-label') ); ?>
				<div class="input-prepend input-append">
					<input id='surat_izin_lama' type='text' name='surat_izin_lama' maxlength="20" value="<?php echo set_value('surat_izin_lama', isset($surat_izin['lama']) ? $surat_izin['lama'] : ''); ?>" />
					 <span class="add-on">Hari</span>
					<span class='help-inline'><?php echo form_error('surat_izin_lama'); ?></span>
				</div>
			</div>
 
			<div class="control-group <?php echo form_error('surat_izin_tanggal') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Mulai'. lang('bf_form_label_required'), 'surat_izin_tanggal', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='surat_izin_tanggal' type='text' name='surat_izin_tanggal'  value="<?php echo set_value('surat_izin_tanggal', isset($surat_izin['tanggal']) ? $surat_izin['tanggal'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('surat_izin_tanggal'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('surat_izin_tanggal_selesai') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal Selesai'. lang('bf_form_label_required'), 'surat_izin_tanggal_selesai', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='surat_izin_tanggal_selesai' type='text' name='surat_izin_tanggal_selesai'  value="<?php echo set_value('surat_izin_tanggal_selesai', isset($surat_izin['tanggal_selesai']) ? $surat_izin['tanggal_selesai'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('surat_izin_tanggal_selesai'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('surat_izin_alasan') ? 'error' : ''; ?>">
				<?php echo form_label('Keterangan'. lang('bf_form_label_required'), 'surat_izin_alasan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'surat_izin_alasan', 'id' => 'surat_izin_alasan', 'rows' => '5', 'cols' => '80', 'value' => set_value('surat_izin_alasan', isset($surat_izin['alasan']) ? $surat_izin['alasan'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('surat_izin_alasan'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('tanggal_dibuat') ? 'error' : ''; ?>">
				<?php echo form_label('Surat Dokter'. lang('bf_form_label_required'), 'surat_izin_alasan', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<div class="dropzone well well-sm foto_upload">
					
              			</div>
              			<input id='lampiran' type='hidden' name='lampiran'  value="<?php echo set_value('lampiran', isset($surat_izin['lampiran']) ? $surat_izin['lampiran'] : ''); ?>" />
              		</div>
				</div>
			 
			</fieldset>
			<?php if(isset($surat_izin['status_atasan'])): ?>
				<fieldset>
				<legend>Persetujuan</legend>
				<div class="control-group <?php echo form_error('status_atasan') ? 'error' : ''; ?>">
					<?php echo form_label('Status Atasan', '', array('class' => 'control-label', 'id' => 'surat_izin_status_atasan_label') ); ?>
					<div class='controls' aria-labelled-by='surat_izin_status_atasan_label'>
						<label class='radio' for='surat_izin_status_atasan_option1'>
							<input id='surat_izin_status_atasan_option1' name='surat_izin_status_atasan' type='radio' class='' value='1' <?php echo set_radio('surat_izin_status_atasan', '1', TRUE); ?> />
							Setuju
						</label>
						<br>
						<label class='radio' for='surat_izin_status_atasan_option2'>
							<input id='surat_izin_status_atasan_option2' name='surat_izin_status_atasan' type='radio' class='' value='2' <?php echo set_radio('surat_izin_status_atasan', '2'); ?> />
							Tidak Setuju
						</label>
						<span class='help-inline'><?php echo form_error('status_atasan'); ?></span>
					</div>
				</div>

			<?php endif; ?>
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('surat_izin_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<input type="reset" name="reset" class="btn btn-warning" value="Cancel"  />
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript">
$( "#frmsakit" ).submit(function( event ) {
	var cnv = $('#lampiran').val();
    if (!$.trim(cnv)) {
        alert('silahkan lampirkan surat dokter!');
        return false;
    } else { return true; }
});
Dropzone.autoDiscover = true;
var foto_upload = new Dropzone(".dropzone",{
	 autoProcessQueue: true,
	 url: "<?php echo base_url() ?>admin/kepegawaian/surat_izin/saveberkas",
	 maxFilesize: 20,
	 parallelUploads : 1,
	 maxFiles:1,
	 method:"post",
	 acceptedFiles:"application/pdf,.jpg,.jpeg,.png",
	 paramName:"userfile",
	 dictDefaultMessage:"<img src='<?php echo base_url(); ?>assets/images/dropico.png' width='50px'/><br>Drop Photo",
	 dictInvalidFileType:"Type file ini tidak dizinkan",
	 addRemoveLinks:true, 
	 init: function () {
           this.on("success", function (file,response) {
               var data_n=JSON.parse(response);
               if(data_n.namafile != ""){
           			swal("Upload berhasil", "Warning");
           		}
               $("#lampiran").val(data_n.namafile).select();
           });
       }
     });
	foto_upload.on("sending",function(a,b,c){
        a.token=Math.random();
        c.append('token_foto',a.token);
        c.append('id',"<?php echo $id; ?>");
        //console.log('mengirim');           
	});

</script>