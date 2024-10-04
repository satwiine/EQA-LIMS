<!--script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script-->
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
<?php
	$out='["Level","Returned","Good TAT","Bad TAT"],';

	 for($i=0;$i<count($responseByFacility);$i++){
		
	 	$out.='["'.$responseByFacility[$i]['levelname'].'",'.round((($responseByFacility[$i]['Returns']/$responseByFacility[$i]['distributed'])*100),2).','.(($responseByFacility[$i]['GoodTAT']/$responseByFacility[$i]['distributed'])*100).','.(($responseByFacility[$i]['badtat']/$responseByFacility[$i]['distributed'])*100).'],';
	 }
	   $out = substr($out, 0,strlen($out)-1);

	// print_r($regionDispatch);
	//exit();
?>
<!-- Content Wrapper -->
<div class="content-wrapper">
	<!-- Content Header -->
	<section class="content-header">
		<h1>Dashboard</h1>

			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
				<li class="active">Dashboard</li>
			</ol>
	</section>

	<!-- Main Content -->
	<section class="content">
		<!-- small boxes stat box -->
		<?php //if($is_admin==true):?>

			<div class="row">
				<div class="col-lg-3 col-xs-6">
					<!-- small boxe for items -->
					<div class="small-box bg-purple">
						<div class="inner">
							<h3> <?php echo $registeredTesters;?></h3>

							<h4><b>Registered Testers</b></h4>
						</div>
						<div class="icon">
							<i class="fa fa-user-md"></i>
						</div>
						<a href="<?php echo base_url('Items/');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-xs-6">
					<!-- small boxe for items -->
					<div class="small-box bg-teal">
						<div class="inner">
							<h3> <?php echo $registeredFacility;?></h3>

							<h4><b>Registered Facilities</b></h4>
						</div>
						<div class="icon">
							<i class="fa fa-th"></i>
						</div>
						<a href="<?php echo base_url('Requests/');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->

				<div class="col-lg-3 col-xs-6">
					<!-- small boxe for items -->
					<div class="small-box bg-olive-active">
						<div class="inner">
							<h3> <?php echo $targetedTesters;?></h3>

							<h4><b>Targeted Testers</b></h4>
						</div>
						<div class="icon">
							<i class="fa fa-bullseye"></i>
						</div>
						<a href="<?php echo base_url('Requests/');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-xs-6">
					<!-- small boxe for items -->
					<div class="small-box bg-green">
						<div class="inner">
							<h3> <?php echo $returnedTesters;?></h3>

							<h4><b>Responsive Testers</b></h4>
						</div>
						<div class="icon">
							<i class="fa fa-flag-checkered"></i>
						</div>
						<a href="<?php echo base_url('Requests/');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
			</div>

			<div class="position-relative">
					<div class="position-absolute top-0 start-0">
							<div class="panel panel-info col-md-12"> 
									<div class="panel-header" style=" text-align: center;">
										<h1>External Quality Assurance Response</h1>
									</div>
									<div class="panel-body" id="chart_div" style=" height: 550px;">			
									</div>
							</div>
					</div>
					<div class="col-md-12">
							<div class="panel col-md-3" style="display: none;"> 
									<div class="panel-header" >
										<h3> Facilities By Level</h3>
									</div>
									<div class="card-body">
											<div class="row">
												<ul class="list-group" style="font-size: 10px;">
													<?php
														foreach($facilitySummary as $fs):
															echo '<li class="list-group-item">',$fs['LevelName'],'<span class="badge bg-secondary">',$fs['sites'],'</span></li>';
														endforeach;
													 ?>
												</ul>
											</div>		
									</div>
								</div>

								<div  class="panel col-md-3" style="display:none;">
										<div class="panel-header">
											<h3>EQA Distribution Summary</h3>
										</div>
										<div class="card-body">
											<ul class="list-group" style="font-size: 10px;">
												<?php
													for($i=0;$i<count($responseByFacility);$i++){
														echo '<li class="list-group-item">',$responseByFacility[$i]['levelname'],'<span class="badge bg-secondary">',$responseByFacility[$i]['distributed'],'</span></li>';
													}
												?>
											</ul>
										</div>
								</div>

								<div  class="panel col-md-3" style="display:none;">
										<div class="panel-header">
											<h3>User Entries</h3>
										</div>
										<div class="card-body">
											<ul class="list-group" style="font-size: 10px;">
												<?php
													for($i=0;$i<count($entries);$i++){
														echo '<li class="list-group-item">',$entries[$i]['fname']," ",$entries[$i]['lname'] ,'<span class="badge bg-secondary">',$entries[$i]['entered'],'</span></li>';
													}
												?>
											</ul>
										</div>
								</div>
					</div>
			
			<div class="panel panel-info col-md-3"  style="display:none;"> 
					<div class="panel-header" >
						<h4> Tester Summary By Cadre</h4>
					</div>
					<div class="panel-body">
						<div class="row">
							<ul class="list-group">
							<?php 
								foreach($testerSummary as $ts):
									echo '<li class="list-group-item">',$ts['CategoryName'],'<span class="badge bg-secondary">',$ts['testers'],'</span></li>';
								endforeach;
							?>
							</ul>
						</div>
					</div>
				</div>
			<?php //print_r($_SESSION); ?>
	</section>
</div>
<!--script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script-->
<script type="text/javascript" src="<?php echo base_url('assets/js/charts/loader.js');?>"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#dashboardMainMenu').addClass('active');
	});

	google.charts.load('current', {packages: ['corechart', 'bar']});
	google.charts.setOnLoadCallback(drawMultSeries);

	function drawMultSeries() {
      var data = google.visualization.arrayToDataTable([
        <?php echo $out;?>
      ]);

      var options = {
        chartArea: {width: '70%'},
        hAxis: {
          title: 'By Facility'
        },
        vAxis: {
          title: 'Level'
        },
        legend: { position: 'top', maxLines: 3 },
        bar: { groupWidth: '75%' },
        isStacked: true

      };

      var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
</script>