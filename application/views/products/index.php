<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.12.4.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.dataTables.min.css');?>">

<!-- Content Wrapper  -->
<div class="content-wrapper">
	
	<!-- Content Header -->
	<section class="content-header">
		<h1>Manage Products</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
			<li class="active">Products</li>
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

			<button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add Product</button>

			<div class="box">
				<div class="box-body">
					<table id="manageTable" class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<th>Product</th>
								<th>Category</th>
								<th>Expires</th>
								<th>Item Group</th>
								<th>Unt of Measure</th>
								<th>Quatity</th>
								<?php //todo Determine role of user ?>
								<th>Action</th>
								<?php //end determination ?>
							</tr>
						</thead>
					</table>
				</div>
			</div>





<!-- remove modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4>Remove Warehouse</h4>
			</div>

			<form role="form" action="<?php echo base_url('removeWarehouse');?>" method="post" id="removeForm">
				<div class="modal-body">
					<p>Do you Really want to remove?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger">Delete Item</button>
				</div>
			</form>
		</div>
	</div>
</div>

			<script type="text/javascript">
				document.title='Add Product';
				var manageTable;
				var base_url ="<?php echo base_url();?>";

				$(document).ready(function(){
				// initiate the datatable
				manageTable = $('#manageTable').dataTable({
					dom: 'Bfrtip',
					buttons: ['copy','csv','excel','print'],
					'ajax':base_url+'fetchItems',
					'order':[]
				});

				});
			</script>