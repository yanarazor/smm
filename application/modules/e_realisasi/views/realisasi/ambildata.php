<div class="admin-box"> 
			  <div class="alert alert-block alert-warning fade in ">
				<a class="close" data-dismiss="alert">&times;</a>
				 1. Pastikan komputer Aplikasi SAS sudah nyala<br>
				 2. Tunggu Sampai Muncul Peringatan(warning) "Selesai" <br>
			  </div>
			   
			    
			    <center>
				   <form method="post" action="#" class="form-horizontal" name="frminput" id="frminput">
				   <fieldset>
 
 						<div id="kontent"></div>
					    
						   <input type="submit" name="save" id="generate" class="btn-large btn-primary" value="Ambil Data"  />
					    
				   </fieldset>
			   <?php echo form_close(); ?>
			  </center>
			  <br>
			<div class="alert alert-block alert-danger fade in ">
				<a class="close" data-dismiss="alert">&times;</a>
				Upami aya revisi, Klik tombol anu dihandap
			</div>
			 <center>
				   <form method="post" action="#" class="form-horizontal" name="frminput" id="frminputrevisi">
				   <fieldset>
 
 						<div id="kontentrevisi"></div>
					    
						   <input type="submit" name="save" id="generate" class="btn-large btn-primary" value="Revisi"  />
					    
				   </fieldset>
			   <?php echo form_close(); ?>
			  </center>
	  </div>

<script type="text/javascript">	
$(document).ready(function() {
	 $("#frminput").submit( function() {
	 	 
		$('#kontent').html("<center>Generating data...</center>");
		var post_data = "";
		//alert("<?php echo base_url() ?>admin/realisasi/e_realisasi/generatedata");
		  $.ajax({
				  url: "<?php echo base_url() ?>admin/realisasi/e_realisasi/generatedatatransaksi",
				  type:"POST",
				  data: post_data,
				  dataType: "html",
				  timeout:180000,
				  success: function (result) {
				 		//alert(result);
				 	swal("Pemberitahuan!", result, "success");
					$('#kontent').html(result);
			  },
			  error : function(error) {
				  alert(error);
			  } 
		  });        
		return false;
	}); 
	
	 $("#frminputrevisi").submit( function() {
	 	 
		$('#kontentrevisi').html("<center>Generating data...</center>");
		var post_data = "";
		//alert("<?php echo base_url() ?>admin/realisasi/e_realisasi/generatedatarevisi");
		  $.ajax({
				  url: "<?php echo base_url() ?>admin/realisasi/e_realisasi/generatepagu",
				  type:"POST",
				  data: post_data,
				  dataType: "html",
				  timeout:180000,
				  success: function (result) {
				 	swal("Pemberitahuan!", result, "success");
					$('#kontentrevisi').html(result);
			  },
			  error : function(error) {
				  alert(error);
			  } 
		  });        
		return false;
	}); 
});
</script>