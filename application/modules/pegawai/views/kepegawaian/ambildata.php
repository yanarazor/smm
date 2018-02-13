<!-- sweet alert -->
<script src="<?php echo base_url(); ?>themes/admin/js/sweetalert.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/admin/css/sweetalert.css">
<div class="admin-box"> 
			  <div class="alert alert-block alert-warning fade in ">
				<a class="close" data-dismiss="alert">&times;</a>
				 1. Silahkan klik tombol Ambildata di bawah untuk update data pegawai dari server BOSDM<br>
				 2. Tunggu Sampai Muncul informasi status update data <br>
				 
			  </div>
			   
			    
			    <center>
			    <div id="divinfo"></div>
			    <br>
				   <form method="post" action="#" class="form-horizontal" name="frminput" id="frminput">
				   <fieldset>
						   <input type="submit" name="save" id="generate" class="btn-large btn-primary" value="Ambil Data"  />
					    
				   </fieldset>
			   <?php echo form_close(); ?>
			  </center>
			 
	  </div>

<script type="text/javascript">	
$(document).ready(function() {
	 $("#frminput").submit( function() {
	 	 
		$('#kontent').html("<center>Generating data...</center>");
		var post_data = "";
		//alert("<?php echo base_url() ?>admin/realisasi/e_realisasi/realisasisas");
		  $.ajax({
				  url: "<?php echo base_url() ?>admin/kepegawaian/pegawai/generatedatasdm",
				  type:"POST",
				  data: post_data,
				  dataType: "html",
				  timeout:180000,
				  success: function (result) {
				 	
					$('#divinfo').html(result);
					swal(result, "Perhatian");
			  },
			  error : function(error) {
				  alert(error);
			  } 
		  });        
		return false;
	}); 
	
});
</script>