<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery.timepicker.css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.timepicker.js"></script>

<script src="<?php echo base_url(); ?>themes/admin/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>themes/admin/js/fullcalendar.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/admin/css/fullcalendar.css">
<?php

$num_columns	= 7;
$can_delete	= $this->auth->has_permission('Bukusaku.Logbook.Delete');
$can_edit		= $this->auth->has_permission('Bukusaku.Logbook.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<?php
	if($current_user->role_id == "1" or $current_user->role_id != "16" or $current_user->role_id != "12")
	{
	?>
	<div class="control-group">
		<div class='controls'>
			<select name="user" id="user" class="chosen-select-deselect" onchange="getinfo(this.value)" style="width:100%">
				<option value="">-- Pilih Pegawai  --</option>
				<?php if (isset($pegawais) && is_array($pegawais) && count($pegawais)):?>
				<?php foreach($pegawais as $rec):?>
					<option value="<?php echo $rec->no_absen?>" <?php if(isset($nip))  echo  ($rec->no_absen==$nip) ? "selected" : ""; ?>> <?php e(ucfirst($rec->nama)); ?></option>
					<?php endforeach;?>
				<?php endif;?>
			</select>
		</div>
	</div>
	<?php } ?>
    <div class="calendar-section">
        <div id="calendar" style="width:85%;height:55% !important"></div>

    </div>    
    
             
</div>
<div id="calendarModal" class="modal fade">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
            <h4 id="modalTitle" class="modal-title"></h4>
        </div>
        <div id="modalBody" class="modal-body"> </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
$(window).load(function(){ 

  $('#calendar').fullCalendar({
    header: {
        left: 'prev,next today',
        center: 'title',
        right: ''
    },
    selectable : true,
    dayNamesShort: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'kamis', 'Jumat', 'Sabtu'],
    editable: true,
    eventRender: function(event, element, view) {
    if (event.allDay === 'true') {
     event.allDay = true;
    } else {
     event.allDay = false;
    }
   }, 
   
    events:"<?php echo base_url();?>admin/logbook/bukusaku/getevent?nip=<?php e($nip); ?>",
    eventClick: function(calEvent, jsEvent, view) {
     	//alert(calEvent.id);
		//alert(calEvent.start.format('y-M-D'));
		var title = "Detil";
		//alert(currentBtn.attr("href"));
		$.ajax({
		  url: "<?php echo base_url();?>admin/logbook/bukusaku/lihatdetil?kode="+calEvent.id,
		  type: 'post',
		  beforeSend: function (xhr) {
			
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
	},
	dayClick: function(date, jsEvent, view) {
		var tanggal = date.date();
		var bulan = date.month() + 1;
		var tahun = date.year();
        var title = "Tambah Aktifitas";
		$.ajax({
		  url: "<?php echo base_url();?>admin/logbook/bukusaku/create?tanggal="+tahun+"-"+bulan+"-"+tanggal,
		  type: 'post',
		  beforeSend: function (xhr) {
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

    },
    
	}); 
})
</script>
<style type="text/css">
#calendar .fc-day-number {
    text-decoration: underline;
    width: 15px;
    height: 16px;
    text-align: right;
}
#calendar .fc-day {
    cursor: pointer;
    width: 30px !important;
    height: 30px !important;
    
}

#calendar .fc-day-number:hover {
    cursor: pointer;
}


#calendar .my-cell-overlay-day-corner {
    position: absolute;
    top: 0;
    right: 0;
    width: 19px;
    height: 16px;
    cursor: pointer;
}
 
</style>
<script type="text/javascript">
	$("#user").change(function(){
		if($(this).val()){
			window.location = "?nip="+$(this).val();
		}
		else window.location = "?";
	});
</script>	
<link href="<?php echo base_url(); ?>assets/css/chosen/chosen.css" rel="stylesheet" type="text/css" />
<script language='JavaScript' type='text/javascript' src='<?php echo base_url(); ?>assets/js/chosen/chosen.jquery.js'></script>
<script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>