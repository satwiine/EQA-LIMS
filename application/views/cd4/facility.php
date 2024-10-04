<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.12.4.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.dataTables.min.css');?>">

<!-- Content Wrapper  -->
<div class="content-wrapper">
	
	<!-- Content Header -->
	<section class="content-header">
		<h1>Manage Facility</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
			<li class="active">Facilities</li>
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

			<button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add CD4 Facility</button>

			<div class="box">
				<div class="box-body">
					<table id="manageTable" class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<th>Facility Code</th>
								<th>Facility Name</th>		
								<th>Facility Level</th>			
								<th>District</th>					
								<th>Action</th>
								
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
</div>

<!-- Create Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add Test</h4>
			</div>
			<form role="form" action="<?php echo base_url('createcd4Test');?>" method="post" id="createForm">
				<div class="modal-body">
					<div class="form-group">
						<label for="test_name">Test Name</label>
						<input type="text" class="form-control" id="test_name" name="test_name" placeholder="Enter Test name" autocomplete="off">
					</div>
					<div class="form-group">
						<label for="test_category">Category</label>
						<select class="form-control" id="test_category" name="test_category">
							<option value="Absolute">Absolute</option>
							<option value="Percent">Percent</option>
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

<!-- Edit Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Edit Test</h4>
			</div>
			<form role="form" action="<?php echo base_url('editcd4Test');?>" method="post" id="updateForm">
				<div class="modal-body">
					<div class="form-group">
						<label for="test_name">Test Name</label>
						<input type="text" class="form-control" id="edit_test_name" name="edit_test_name" placeholder="Enter CD4 Test name" autocomplete="off">
					</div>
					<div class="form-group">
						<label for="edit_test_category">Category</label>
						<select class="form-control" id="edit_test_category" name="edit_test_category">
							<option value="Absolute">Absolute</option>
							<option value="Percent">Percent</option>
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
				<h4>Remove Facility</h4>
			</div>

			<form role="form" action="<?php echo base_url('removeCd4Test');?>" method="post" id="removeForm">
				<div class="modal-body">
					<p>Do you Really want to remove?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger">Delete Test</button>
				</div>
			</form>
		</div>
	</div>
</div>


<!-- Js -->
<script type="text/javascript">
	var manageTable;
	var base_url ="<?php echo base_url();?>";

	$(document).ready(function(){
		// initiate the datatable
		manageTable = $('#manageTable').dataTable({
			dom: 'Bfrtip',
			buttons: ['copy','csv','excel','print'],
			'ajax':base_url+'getCD4Sites',
			'order':[]
		});

		//submit create form
		$('#createForm').unbind('submit').bind('submit',function(){
			var form =$(this);

			//remove text-danger
			$('.text-danger').remove();

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
								.addClass(value.length >0 ?'has-error': 'has-success');

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


	//edit function
	function editFunc(id){
		//var base_url="<?php echo base_url();?>";
		$.ajax({
			url: base_url+'/getElementDataById/'+id,
			type: 'post',
			dataType:'json',
			success:function(response){

				$('#edit_element_name').val(response.attribute_name);
				$('#edit_element_status').val(response.isactive);

				//submit the edit form
				$('#updateForm').unbind('submit').bind('submit',function(){
					var form =$(this);
					//remove the text-danger
					$('.text-danger').remove();

					$.ajax({
						url:  form.attr('action')+'/'+id,
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
								$('#editModal').modal('hide');
								//reset the form
								$('#updateForm .form-group').removeClass('has-error').removeClass('has-success');

							} else {
								if(response.messages instanceof Object){
									$.each(response.messages, function(index,value){
										var id=$('#'+index);

										id.closest('.form-group')
										.removeClass('has-error')
										.removeClass('has-success')
										.addClass(value.length >0 ?'has-error': 'has-success');

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
			}
		});
	}


	//Remove function
	function removeFunc(id){
		if(id){
			$('#removeForm').on('submit',function(){
				var form = $(this);

				//remove the text-danger
				$('.text-danger').remove();

				$.ajax({
					url: form.attr('action'),
					type: form.attr('method'),
					data: {element_id:id},
					dataType:'json',
					success: function(response){
						manageTable.DataTable().ajax.reload();

						if(response.success === true){
							$('#messages').html(
							'<div class="alert alert-success alert-dismissible" role="alert" '+
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>'+
							'<strong><span class="glyphicon-ok-sign"></span></strong>'+response.messages+
							'</div>');

							//hide modal
							$('#removeModal').modal('hide');
						}
						else {
							$('#messages').html(
							'<div class="alert alert-warning alert-dismissible" role="alert" '+
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>'+
							'<strong><span class="glyphicon-exclamation"></span></strong>'+response.messages+
							'</div>');
						}
					}
				});
				return false;
			});
		}
	}
</script>