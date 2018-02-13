<div id="loading-all" class="modal fade bs-modal-lg">Loadin...</div>
<!-- Modal -->
    <div data-backdrop="static" data-keyboard="false" class="modal fade bs-modal-lg" id="modal-global" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Detail</h4>
				</div>
				<div class="modal-body" id="modal-body">
				Loading content...
				</div>
			</div>
		</div>
    </div>
	<footer class="container-fluid footer">
		<p class="pull-right">
			Executed in {elapsed_time} seconds, using {memory_usage}.
			
		</p>
	</footer>

	<div id="debug"><!-- Stores the Profiler Results --></div>

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  
	<?php echo Assets::js(); ?>
<script type="text/javascript">
$('body').on('click','.show-modal',function (event) { 
	$('.perhatian').fadeOut(300, function(){});
	  event.preventDefault();
	  var currentBtn = $(this);
	  var title = currentBtn.attr("tooltip");
	  //alert(currentBtn.attr("href"));
	  $.ajax({
	  url: currentBtn.attr("href"),
	  type: 'post',
	  beforeSend: function (xhr) {
		  $("#loading-all").show();
	  },
	  success: function (content, status, xhr) {
		  var json = null;
		  var is_json = true;
		  try {
		  	json = $.parseJSON(content);
		  } catch (err) {
		  	is_json = false;
		  }
		  if (is_json == false) {
		  	$("#modal-body").html(content);
		  	$("#myModalLabel").html(title);
		  	$("#modal-global").modal('show');
		  	$("#loading-all").hide();
		  } else {
		  	alert("Error");
		  }
	  }
	  }).fail(function (data, status) {
	  if (status == "error") {
		  alert("Error");
	  } else if (status == "timeout") {
		  alert("Error");
	  } else if (status == "parsererror") {
		  alert("Error");
	  }
	  });
  });

$('body').on('click','.show-modalframe',function (event) { 
	$('.perhatian').fadeOut(300, function(){});
	  event.preventDefault();
	  $(this).addClass( "danger" );
	  var currentBtn = $(this);
	  var title = currentBtn.attr("tooltip");
	  //alert(currentBtn.attr("href"));
	   	$("#modal-body").html("content");
		$("#myModalLabel").html(title);
		$("#modal-globalframe").modal('show');
		$("#loading-all").hide();
		$("#framedata").attr("src", currentBtn.attr("href"));
  });
 
  
</script>
</body>
</html>

