<div class="admin-box"> 
			  <div class="alert alert-block alert-warning fade in ">
				<a class="close" data-dismiss="alert">&times;</a>
				 1. Silahkan Pilih File <br>
				 2. Tunggu Sampai Muncul Peringatan(warning) "Upload Selesai" <br>
			  </div>
			  <!--
			  <div class="span4">
				  <form method="post" action="#" enctype="multipart/form-data" name="frminput" id="frminput">
					  <input type="file" name="file_upload" id="file_upload" /> 
				  </form>
			   </div>
			   -->
			   <div class="span12">
				   <form method="post" action="<?php echo base_url();?>admin/kepegawaian/absen/upload/" class="form-horizontal" enctype="multipart/form-data" name="frminput" id="frminput">
				   <fieldset>

					   <div class="control-group <?php echo form_error('Filedata') ? 'error' : ''; ?>">
						   <?php echo form_label('File'. lang('bf_form_label_required'), 'absen_harian_kode_pegawai', array('class' => 'control-label') ); ?>
						   <div class='controls'>
								<input type="file" name="Filedata" id="Filedata" /> 
						   </div>
					   </div>
 
					   <div class="form-actions">
						   <input type="submit" name="save" class="btn btn-primary" value="Upload"  />
						   <?php echo lang('bf_or'); ?>
						   <?php echo anchor(SITE_AREA .'/kepegawaian/absen', "Cancel", 'class="btn btn-warning"'); ?>
				
					   </div>
				   </fieldset>
			   <?php echo form_close(); ?>
	
			   </div>	 
						 
		  
	  </div>

<script type="text/javascript">	
$(document).ready(function() {
	 
	$(".mini-delete").live("click", function(){
                conf = confirm("Do you realy want to delete this image?");
                
				if (!conf)
                    return false;

                var id = $(this).attr('data-id');
                target = $(this);
				var aksi = "delimage_gallery";
				if(target.attr("aksi")!="")
					aksi = target.attr("aksi");
                var dataPost = "id="+target.attr("data-id");
				 
                $.ajax({
                    type:"post",
                    data:dataPost,
                    dataType:"html",
                    url:"index.php/admin/content/gallery/"+aksi,
                    success: function(msg){
                        json = jQuery.parseJSON(msg);
                        if (json.status == "TRUE") {
                            target.parent().parent().hide("slow");
                        }
                        else {
                            alert(json.message);
                        }
                    },
                    error: function(msg){
                        alert(msg+'Request Errors. Please try again.');
                    }
                });
            });

 	var iddesa ='1';
	 $('#file_upload').uploadify({
		
                'buttonImage' : null,
                'swf'      : '<?php echo base_url(); ?>assets/js/uploadify/uploadify.swf',
                'uploader' : '<?php echo base_url(); ?>index.php/admin/kepegawaian_front/absen/import_data?session_id=1&user_id=1&provinsi=1',
                'auto'      : true,
                'multi'     : true,
                'fileSizeLimit' : '400MB',
		        'fileTypeExts'	: '*.txt;*.csv;*.dll;*.xlsx;*.xls;',
				 
				'scriptData' : {'user_id' : '1'},
        		'onUploadError' : function(file, errorCode, errorMsg, errorString,response) {
        			//alert("<?php echo base_url(); ?>index.php/admin/kepegawaian_front/absen/import_data?session_id=1&user_id=1&provinsi=1");
                   	alert('The file ' + file.name + ' ini could not be uploaded: ' + errorString);
                },
                'onUploadSuccess' : function(file, msg, response) {
					//alert($("#id_desac").val());
					alert(msg);
                    json = jQuery.parseJSON(msg);
					
                //    $("#gallery-image").append('<div class="get-photo" style="z-index: 690;"><div class="buttons" style="z-index: 680;"><a class="mini-delete" href="javascript:void(0);" aksi="" data-id="'+json.id+'">Delete</a><div class="clear" style="z-index: 670;"></div></div><a href="'+json.imageUrl+'"><img width="175" height="110" alt="" src="'+json.imageUrl+'"/></a></div>');
    			},
    			'method'   : 'POST',
                'uploadLimit' : 10
                // Your options here
            }); 
		 
});
</script>