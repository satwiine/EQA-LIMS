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
			<!-- <a href="createItem" class="btn btn-primary">Add Item </a> -->

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

<!-- Create Modal --> 
<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add Item</h4>
			</div>
			<form role="form" action="<?php echo base_url('saveItem');?>" method="post" id="createForm">
				<div class="modal-body">
					<div class="form-group">
						<label for="product_name">Item Name</label>
						<input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter Item Name" autocomplete="off">
					</div>

					<div class="form-group">
	                  <label for="product_expires">Does Product Expire?</label>
	                  <select class="form-control" id="product_expires" name="product_expires">
	                    <option value="">Select</option>
	                    <option value="0" selected="selected">No</option>
	                    <option value="1">Yes</option>
	                  </select>
	                </div>

	                <div class="form-group">
	                  <label for="product_group">Product Group</label>
	                  <select class="form-control" id="product_group" name="product_group">
	                    <option value="stock-item">Stock Item</option>
	                    <option value="non-stock-item">Non Stock Item</option>
	                  </select>
	                </div>
					
					<!-- Loop through attribute that are on primary level -->
		                <?php if($attributes): ?>
		                  <?php foreach ($attributes as $k => $v): ?>
		                    <div class="form-group">
		                      <label for="groups"><?php echo $v['attribute_data']['attribute_name'] ?></label>
		                      <select class="form-control" id="attributes_value_id" name="attributes_value_id" >
		                        <option value="">Select</option>
		                        <?php foreach ($v['attribute_value'] as $k2 => $v2): ?>
		                          <option value="<?php echo $v2['id'] ?>"><?php echo $v2['value_name']; ?></option>
		                        <?php endforeach ?>
		                      </select>
		                    </div>    
		                  <?php endforeach ?>
		                <?php endif; ?>

		                <!-- loop through category -->
		                <div class="form-group">
		                  <label for="category">Category</label>
		                  <select class="form-control select_group" id="category" name="category">
		                    <option value="">Select</option>
		                    <?php foreach ($category as $k => $v): ?>
		                      <option value="<?php echo $v['itemCatId'] ?>"><?php echo $v['ItemCatDescription']; ?></option>
		                    <?php endforeach ?>
		                  </select>
		                </div>

		              

		                <div class="form-group">
		                  <label for="availability">Is the Item Available</label>
		                  <select class="form-control" id="availability" name="availability">
		                    <option value="1">Yes</option>
		                    <option value="0">No</option>
		                  </select>
		                </div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save Changes</button>
				</div>
			</form>
		</div>
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


				//submit create form
		$('#createForm').unbind('submit').bind('submit',function(){
			var form =$(this);

			//var h=form.serialize();
			//remove text-danger
			$('.text-danger').remove();
			//alert(h);
			//return false;
			$.ajax({
				url:  form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success: function(response){
					manageTable.DataTable().ajax.reload();
					
					if(response.success === true){
						$('#messages').html(
						'<div class="alert alert-success alert-dismissible" role="alert" '+
						'<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>'+
						'<strong><span class="glyphicon-ok-sign"></span></strong>'+response.messages+
						'</div>');

						//hide modal
						$('#addModal').modal('hide');
						//reset the form
						$('#createForm .form-group').removeClass('has-error').removeClass('has-success');

					} else {
						if(response.messages instanceof Object){
							$.each(response.messages, function(index,value){
								var id=$('#'+index);

								id.closest('.form-group')
								.removeClass('has-error')
								.removeClass('has-success')
								.addClass(value.length >0 ?'has-success': 'has-error');

								id.after(value);
							});
						}
						else {

							$('#messages').html(
							'<div class="alert alert-warning alert-dismissible" role="alert" '+
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>'+
							'<strong><span class="glyphicon-exclamation"></span></strong>'+response.messages+
							'</div>');

						}
					}
				}
			});
			return false;
		});

				});
			</script>