<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.12.4.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.dataTables.min.css');?>">

<!-- Content Wrapper  -->
<div class="content-wrapper">
	
	<!-- Content Header -->
	<section class="content-header">
		<h1>Manage Reciepts</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
			<li class="active">Reciepts</li>
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

			<!-- <button class="btn btn-primary" data-toggle="modal" data-target="addMOdal">Recieve Items</button> -->

			<div class="box">
				<div class="box-body">
					<table id="manageTable" class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<th>Reciept Date</th>
								<th>Recieved From</th>
								<th>Total Line Items </th>
								<th>Description</th>
								<?php //todo Determine role of user ?>
								<th>Action</th>
								<?php //end determination ?>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- delete reciept -->


<script type="text/javascript">
	var manageTable;
	var base_url = "<?php echo base_url(); ?>";

	$(document).ready(function(){

		//initialise the dataTable
		manageTable =$('#manageTable').dataTable({
			'ajax':base_url+'fetchReciepts',
			'order':[]
		});
	});
	
</script>