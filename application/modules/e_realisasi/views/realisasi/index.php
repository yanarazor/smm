<?php
	$this->load->library('convert');
	$convert = new convert();
	$mainmenu = $this->uri->segment(2);
	$menu = $this->uri->segment(3);
	$submenu = $this->uri->segment(4);
?>
<script src="<?php echo base_url(); ?>themes/admin/plugins/highchart/highcharts.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
 <div class="row-fluid">
 		
        <!-- Left col -->
        <div class="box span6">
          <!-- MAP & BOX PANE -->
          <div class="box box-success">
            <div class="box-header">
				<h2><i class="icon-list"></i><span class="break"></span>Pagu Anggaran (AKUN)</h2>
			</div>
            <!-- /.box-header -->
            <div class="box-content">
              	<div class="chart-responsive">
                    <div id="piechartanggaran" style="height:250px"></div>
                    <?php
                    $jumlahpagu = 0;
                    $jumlahrealisasi = 0;
                    ?>
		            <table class="table table-bordered" width="1500px" border="1">
					<thead>
		   
						<tr>
							<th>Akun</th>
							<th>Pagu</th>
							<th>Realisasi</th>
							<th>Persentase</th>
						</tr>
		   
					</thead>
	   
					<tbody>
						<tr>
							<td>Belanja Pegawai</td>
							<td align="right"><?php echo number_format($jmlmak51); 
							$jumlahpagu = $jumlahpagu  + $jmlmak51;
							?></td>
							<td align="right"><?php echo number_format($realmak51); 
							$jumlahrealisasi = $jumlahrealisasi  + $realmak51;
							?></td>
							<td align="center">
							<?php
								$persentase = $realmak51/$jmlmak51*100;
				  				echo round($persentase,2)."%";
				  			?></td>
						</tr>
						<tr>
							<td>Belanja Barang</td>
							<td align="right">
							<?php echo number_format($jmlmak52); 
							$jumlahpagu = $jumlahpagu  + $jmlmak52;
							?></td>
							<td align="right">
								<?php echo number_format($realmak52); 
									$jumlahrealisasi = $jumlahrealisasi  + $realmak52;
								?>
							</td>
							<td align="center">
							<?php
								$persentase = $realmak52/$jmlmak52*100;
				  				echo round($persentase,2)."%";
				  			?>
				  			</td>
						</tr>
						<tr>
							<td>Belanja Modal</td>
							<td align="right"><?php echo number_format($jmlmak53); 
							$jumlahpagu = $jumlahpagu  + $jmlmak53;
							?></td>
							<td align="right"><?php echo number_format($realmak53); 
							$jumlahrealisasi = $jumlahrealisasi  + $realmak53;
							?></td>
							<td align="center">
							<?php
								$persentase = $realmak53/$jmlmak53*100;
				  				echo round($persentase,2)."%";
				  			?>
				  			</td>
						</tr>
					 </tbody>
					  <tfoot>
						  <tr>
							<td>Jumlah</td>
							<td align="right"><?php echo number_format($jumlahpagu); ?></td>
							<td align="right"><?php echo number_format($jumlahrealisasi); ?></td>
							<td align="center">
							<?php
								$persentase = $jumlahrealisasi/$jumlahpagu*100;
				  				echo round($persentase,2)."%";
				  			?>
				  			</td>
						</tr>
					  </tfoot>
				  </table>
            	</div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="box span6">
          <!-- MAP & BOX PANE -->
          <div class="box box-success">
         <div class="box-header">
				<h2><i class="icon-list"></i><span class="break"></span>Realisasi Perbulan (Sumber: SAS)</h2>
			</div>
            <!-- /.box-header -->
            <div class="box-content" id="container" style="height:450px">
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
</div>
<div class="row">
<div class="col-md-12">
	<div class='box box-primary'>
	<div class="box-header with-border">
              <h3 class="box-title">Kegiatan</h3>
            </div>
    <div class="box-body">
	<table class="table table-bordered" width="1500px" border="1">
	  <thead>
		   
		  <tr>
			  <th>No</th>
			  <th>Kegiatan</th>
			  <th>Pagu</th>
			  <th>Realisasi</th>
			  <th>Persentase</th>
		  </tr>
		   
	  </thead>
	   
	  <tbody>
	  <?php
		$totalpagu = 0;
		
		$totalall = 0;
		$no = 1;
		for ($i = 1; $i <= 12; $i++) {
			$$i = 0;
		}
		$totalrealisasi = 0;
	  ?>
	  			<?php if (isset($masterkegiatan) && is_array($masterkegiatan) && count($masterkegiatan)):?>
				<?php foreach($masterkegiatan as $rec): 
				
				?>
					<tr>
				  	<td>
				  		<?php echo $no; ?>.
				  	</td>
				  	<td>
				  		<?php e($rec->kdgiat) ?>.<?php e($rec->kdoutput) ?>.<?php e($rec->kdsoutput) ?>.<?php e($rec->kdkmpnen) ?>.<?php e($rec->kdskmpnen) ?>| 
				  		<?php //e($rec->nmoutput) ?>
				  		
				  		<?php e($rec->urkmpnen) ?> | 
				  		<?php e($rec->urskmpnen) ?>
				  	</td>
				  	<td align="right">
				  		<?php
				  		$pagu = 0;
				  		if(isset($datapagu[$rec->kdgiat."-".$rec->kdoutput."-".$rec->kdsoutput."-".$rec->kdkmpnen."-".$rec->kdskmpnen])){
							   $pagu = (Double)$datapagu[$rec->kdgiat."-".$rec->kdoutput."-".$rec->kdsoutput."-".$rec->kdkmpnen."-".$rec->kdskmpnen];
							   $totalpagu = $totalpagu + $pagu;
						   } 
						   echo $convert->ToRpnosimbol($pagu); 
						?>
						
				  	</td>
				  	<td align="right">
				  		<?php
				  		$realisasi = 0;
				  		if(isset($datarealisasikegiatan[$rec->kdgiat."-".$rec->kdoutput."-".$rec->kdsoutput."-".$rec->kdkmpnen."-".$rec->kdskmpnen])){
							   $realisasi = (Double)$datarealisasikegiatan[$rec->kdgiat."-".$rec->kdoutput."-".$rec->kdsoutput."-".$rec->kdkmpnen."-".$rec->kdskmpnen];
							   $totalrealisasi = $totalrealisasi + $realisasi;
						   } 
						   echo $convert->ToRpnosimbol($realisasi); 
						?>
						
				  	</td>
				  	<td align="right">
				  		<?php
				  		if($realisasi >0 and $pagu > 0 )
				  		$persentase = $realisasi/$pagu*100;
				  		echo round($persentase,2)."%";
						?>
						
				  	</td>
				  </tr>
				<?php $no++;
				endforeach; ?>
				<?php endif; ?>
				  
			   
	  </tbody>
	  <tfoot>
		  <tr>
			<td>
			</td>
			<td>
				Total
			</td>
			<td align="right">
				<?php echo number_format($totalpagu); ?>
			</td>
			<td align="right">
				<?php echo number_format($totalrealisasi); ?>
			</td>
			<td align="right">
				  		<?php
				  		$persentase = $totalrealisasi/$totalpagu*100;
				  		echo round($persentase,2)."%";
						?>
						
				  	</td>
		  </tr>
	  </tfoot>
  </table>
	</div>
</div>
</div>
	
</div>
<div class="row">
<div class="col-md-12">
	<div class='box box-primary'>
		<div class="box-header with-border">
			Realisasi Perakun
			<a class="btn btn-success pull-right refreshdata" title="Refresh data" href="#"><i class="fa fa-refresh"></i> Refresh</a>
		</div>
		<div class="box-body" id="kontent">
			   Load...
		 </div>
	</div>
</div>
</div>
<script src="<?php echo base_url(); ?>themes/admin/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script type="text/javascript">  
$(".refreshdata").click(function(){
  $('#kontent').html("<center>Load data...</center>");
		var valkey 	= $("#key").val();
		//alert(valkey);
		var post_data = "varmak="+varmak+"&output="+varoutput+"&tahun="+tahun;
		//alert("<?php echo base_url() ?>admin/realisasi/e_realisasi/realisasisascon?"+post_data);
	$.ajax({
			url: "<?php echo base_url() ?>index.php/admin/realisasi/e_realisasi/realisasisascon",
			type:"POST",
			data: post_data,
			dataType: "html",
			timeout:180000,
			success: function (result) {
				 
				$('#kontent').html(result);
		},
		error : function(error) {
			alert(error);
		} 
	});        
});
	showdata("","","","");
function showdata(varmak,varoutput,tahun){
		$('#kontent').html("<center>Load data...</center>");
		var valkey 	= $("#key").val();
		//alert(valkey);
		var post_data = "varmak="+varmak+"&output="+varoutput+"&tahun="+tahun;
		//alert("<?php echo base_url() ?>admin/realisasi/e_realisasi/realisasisascon?"+post_data);
	$.ajax({
			url: "<?php echo base_url() ?>index.php/admin/realisasi/e_realisasi/realisasisascon",
			type:"POST",
			data: post_data,
			dataType: "html",
			timeout:180000,
			success: function (result) {
				 
				$('#kontent').html(result);
		},
		error : function(error) {
			alert(error);
		} 
	});        
} 
 
</script> 
<script type="text/javascript">                 
    Highcharts.setOptions({
     colors: ['#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263',      '#6AF9C4']
    });
// Build the chart
Highcharts.chart('piechartanggaran', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Pagu',
        data: [
            { name: 'Belanja Pegawai', y: <?php echo $jmlmak51; ?> },
            { name: 'Belanja Barang', y: <?php echo $jmlmak52; ?> },
            { name: 'Belanja Modal', y: <?php echo $jmlmak53; ?> }
        ]
    }]
});

// perbulan
Highcharts.chart('container', {
    chart: {
        type: 'line'
    },
    title: {
        text: ''
    },
     
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
        title: {
            text: 'Realisasi (Rp)'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: false
            },
            enableMouseTracking: true
        }
    },
    
    series: [{
        name: 'Realisasi',
        data: <?php echo $datarealisasiperbulan; ?>
    }]
});

</script>
