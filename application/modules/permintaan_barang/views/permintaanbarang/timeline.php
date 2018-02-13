<?php
	$this->load->library('convert');
	$convert = new convert();
?>
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

if (isset($permintaan_barang))
{
	$permintaan_barang = (array) $permintaan_barang;
}
$id = isset($permintaan_barang['id']) ? $permintaan_barang['id'] : '';

?>
<div class="admin-box">
  	<div class="timeline">
		   <dl>
			   <dt><?php echo set_value('permintaan_barang_tanggal_permintaan', isset($permintaan_barang['tanggal_permintaan']) ? $convert->fmtDate($permintaan_barang['tanggal_permintaan'],"dd-mm-yyyy") : ''); ?></dt>
			   <?php
			   $tipe = "right";
				if (isset($logpermintaan) && is_array($logpermintaan) && count($logpermintaan)) :
					foreach ($logpermintaan as $record) :
				?>
				
			   <dd class="pos-<?php echo $tipe; ?> clearfix">
				   <div class="circ"></div>
				   <div class="time"><?php echo $convert->fmtDateTime($record->jam,"dd month yyyy"); ?></div>
				   <div class="events">
					    
					   <div class="events-body">
						   <h4 class="events-heading"><?php echo $record->aksi; ?> (<?php echo $record->display_name; ?>)</h4>
						   
						   <?php if($record->nomor_detil != "") { ?>
						   <p>
						   Nama Barang : <?php echo $record->nama_barang; ?> </p>
						  <p> Spek : <?php echo $record->spek_barang; ?></p>
							<p>Nomor : <?php echo $record->nomor; ?> - <?php echo $record->nomor_detil; ?></p>
						   <?php } ?>
						   <p><?php echo $record->keterangan; ?></p>
					   </div>
				   </div>
			   </dd>
			   <?php
			   	if($tipe == "right")
					$tipe = "left";
				else
					$tipe = "right";
				   endforeach;
			   endif;
			   ?>
			   <!--
			   <dd class="pos-left clearfix">
				   <div class="circ"></div>
				   <div class="time">Apr 10</div>
				   <div class="events">
					   <div class="pull-left">
						   <img class="events-object img-rounded" src="img/photo-2.jpg">
					   </div>
					   <div class="events-body">
						   <h4 class="events-heading">Bootflat</h4>
						   <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica.</p>
					   </div>
				   </div>
			   </dd>
			   <dt>Mar 2014</dt>
			   <dd class="pos-right clearfix">
				   <div class="circ"></div>
				   <div class="time">Mar 15</div>
				   <div class="events">
					   <div class="pull-left">
						   <img class="events-object img-rounded" src="img/photo-3.jpg">
					   </div>
					   <div class="events-body">
						   <h4 class="events-heading">Flat UI</h4>
						   <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica.</p>
					   </div>
				   </div>
			   </dd>
			   <dd class="pos-left clearfix">
				   <div class="circ"></div>
				   <div class="time">Mar 8</div>
				   <div class="events">
					   <div class="pull-left">
						   <img class="events-object img-rounded" src="img/photo-4.jpg">
					   </div>
					   <div class="events-body">
						   <h4 class="events-heading">UI design</h4>
						   <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica.</p>
					   </div>
				   </div>
			   </dd>
			   -->

		   </dl>
	   </div>
</div>