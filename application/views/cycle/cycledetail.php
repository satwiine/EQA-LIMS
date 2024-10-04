<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.12.4.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.dataTables.min.css');?>">
<style type="text/css">
	.al-center{
		text-align: center;
	}
</style>
<!-- Content Wrapper  -->
<div class="content-wrapper">
	
	<!-- Content Header -->
	<section class="content-header">
		<h1>DTS Cycle Details</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
			<li class="active">Cycle Details</li>
		</ol>
	</section>

	<!-- Main Content -->
	<section class="content">
		<!-- Small Boxes (Stat Box)  -->
		<div class="row">
			<div class="col-md-12 col-xs-12">
				<div id="messages"></div>

				<?php if($this->session->flashdata('success')):?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<?php echo $this->session->flashdata('success');?>
					</div>
					<?php elseif ($this->session->flashdata('error')):?>
					<div class="alert alert-error alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<?php echo $this->session->flashdata('error');?>
					</div>	
				<?php endif;?>

			

			<div class="box">
				<div class="box-body">
					<div> Cycle Information</div>
					
					<div class="col-md-6">
						<table id="manageTable" class="table table-bordered table-hover table-striped" width="50%">
						
							<tr>
								<th>Quarter Description:</th>
								<td><?php echo $cycledata['quartername']; ?></td>
							</tr>
							<tr>
								<th>Start Date:</th>
								<td><?php echo $cycledata['startdate']; ?></td>
							</tr>
							<tr>
								<th>End Date:</th>
								<td><?php echo $cycledata['enddate']; ?></td>
							</tr>
							<tr>
								<th>Cycle Name:</th>
								<td><?php echo $cycledata['name']; ?></td>
							</tr>
							<tr>
								<th>Targeted Testers :</th>
								<td><?php echo $targeted['targeted']; ?></td>
							</tr>
					</table>
					</div>

					<div class="col-md-8">
						<div> Cycle Summary</div>
						<table class="table table-bordered table-hover table-striped table-bordered">
							<thead>
								<tr style="background-color:#32383e; color:#fff">
									<th  class="al-center">Responsive</th><th  class="al-center">Passed</th><th  class="al-center">Failed</th><th class="al-center">Ungraded</th><th  class="al-center">Pending</th>
								</tr>
							</thead>
							<tr>
								<td><?php echo $targeted['responded']; ?></td>
								<td><?php echo $targeted['passed']; ?></td><td><?php echo $targeted['failed']; ?></td><td><?php echo $targeted['ungraded']; ?></td><td><?php echo $targeted['pending']; ?></td>
							</tr>
						</table>
					</div>

					<div class="col-md-8">
						<div>  Expected Results </div>
						<table class="table table-bordered table-hover table-striped table-bordered">
							<thead>
								<tr style="background-color:#32383e; color:#fff">
									<th>Sample #</th><th>Screening</th><th>Confirmatory</th><th>Tie Breaker</th><th>HIV Final Result </th><th>Syphilis Final Result</th>
								</tr>
								
							</thead>
							<?php
									foreach($expected_res as $er):
										echo '<tr><td> Panel - '.$er['panelid'].'</td><td>'.$er['screening'].'</td><td>'.$er['Confirmatory'].'</td><td>'.$er['TieBreaker'].'</td><td>'.$er['HIV_Final'].'</td><td>'.$er['SY_Final'].'</td></tr>';
									endforeach;
							?>
						</table>
					</div>

					<div class="col-md-8" style="display: none;">
						<div> Targeted Cadre Summary </div>
						
							<div class="card col-md-2" >
								1
							</div>
							<div class="card col-md-2" >
								2
							</div>
							<div class="card col-md-2" >
								3
							</div>
							<div class="card col-md-2" >
								4
							</div>
							<div class="card col-md-2" >
								5
							</div>
							<div class="card col-md-2" >
								6
							</div>
					</div>

					<div class="col-md-8" style="display: none;">
						<div>  Targeted Region Summary </div>
						<table class="table table-bordered table-hover table-striped table-bordered">
							<thead>
								<tr style="background-color:#32383e; color:#fff">
									<th>Region</th><th>Targeted</th><th>Responded</th><th>Passed</th><th>Failed</th><th>Un-Graded </th>
								</tr>
								
							</thead>
							<tr>
								<td>Lab #</td><td>Non Lab#</td><td>Lab#</td><td>Non Lab</td><td>Lab</td><td></td>
							</tr>
						</table>
					</div>

						
					<?php // print_r($expected_res);?>
				</div>
			</div>
		</div>
	</div>
</section>
</div>






<!-- Js -->
<script type="text/javascript">
	var manageTable;
	var base_url ="<?php echo base_url();?>";
	var cycle ="<?php echo $cycle;?>";
	var site ="<?php echo $site;?>";

	$(document).ready(function(){
		// initiate the datatable
		// manageTable = $('#manageTable').dataTable({
		// 	dom: 'Bfrtip',
		// 	buttons: ['copy','csv','excel','print'],
		// 	'ajax':base_url+'fetchDistroDetail/'+cycle+'/'+site,
		// 	'order':[]
		// });

		
	});





</script>

