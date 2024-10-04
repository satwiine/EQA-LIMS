<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.12.4.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.dataTables.min.css');?>">

<!-- Content Wrapper -->
<div class="content-wrapper">
	<!-- content heade -->
	<section class="content-header">
		<h1>Manage Elements</h1>

		<ol class="breadcrumb">
			<li><a href="#">
					<i class="fa fa-dashboard"></i>Home
				</a>
			</li>
			<li class="active"><a href="<?php echo base_url('Element');?>">Elements</a></li>
			<li class="active">
				Elemnets Value
			</li>
		</ol>
	</section>

	<!-- Main Content -->
	<section class="content">
		<!-- Small boxes -->
		<div class="row">
			<div class="col-md-12 col-xs-12">
				
				<div class="box">
					<div class="box-body">
						<h4>Elements Name: <?php echo $element_data['attribute_name'];?> </h4>
					</div>
				</div>

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
				<button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add Value</button>
				<br><br>

				<div class="box">
					<!-- /.box header -->
					<div class="box-body">
						<table id="manageTable" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Elements value</th>
									<?php /*deteremine user to show it */?>
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

<!-- create modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4>Add Element Values</h4>
			</div>

			<form role="form" method="post" id="createForm" action="<?php echo base_url('createElementValue');?>">
				<div class="modal-body">
					<div class="form-group">
						<label for="elements_value">Elements Value</label>
						<input type="text" name="elements_value" id="elements_value" class="form-control" placeholder="Enter Element Value" autocomplete="off">
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="parent_id" id="parent_id" value="<?php echo $element_data['id'];?>">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save Changes</button>
				</div>
			</form>
		</div>
	</div>
</div>


<!--  edit modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4>Edit Elements Value</h4>
			</div>

			<form role="form" method="post" id="updateForm" action="<?php echo base_url('updateElementValue');?>">
				<div class="modal-body">
					<div id="messages"></div>
					<div class="form-group">
						<label for="edit_elements_value">Elements Value</label>
						<input type="text" name="edit_elements_value" id="edit_elements_value" class="form-control" placeholder="Enter Element Value" autocomplete="off">
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="parent_id" id="parent_id" value="<?php echo $element_data['id'];?>">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save Changes</button>
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
				<h4>Remove Elements Value</h4>
			</div>

			<form role="form" method="post" id="removeForm" action="<?php echo base_url('removeElementValue');?>">
				<div class="modal-body">
					<p>Do you REally want to remove</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-danger">Delete</button>
				</div>
			</form>			
		</div>
	</div>
</div>


<!-- js -->
<script type="text/javascript">
	var manageTable;
	var base_url="<?php echo base_url();?>";

	$(document).ready(function(){

		// initialise datatable
		manageTable =$('#manageTable').dataTable({
			dom: 'Bfrtip',
			buttons:['copy','csv','excel','print'],
			'ajax': base_url+'fetchElementValueData/'+<?php echo $element_data['id'];?>,
			'order':[]
		});

		// submit the create form
		$('#createForm').unbind('submit').on('submit',function(){
			var form=$(this);
			
			//remove the danger text
			$('.text-danger').remove();

			$.ajax({
				url: form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response){
					manageTable.DataTable().ajax.reload();


					// detrmine wnat to show based on the outcome of form submission 
					if(response.success === true){
						//show sucess message
						$('#messages').html(
							'<div class="alert alert-success alert-dismissible" role="alert" '+
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>'+
							'<strong><span class="glyphicon-ok-sign"></span></strong>'+response.messages+
							'</div>');

						//hide modal
						$('#addModal').modal('hide');

						//reset the form
						$('#createForm')[0].reset();
						$('#createForm .form-group').removeClass('has-error').removeClass('has-success');
					}
					else {
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
		$.ajax({
			url: base_url+'fetchElementValueById/'+id,
			type: 'post',
			dataType:'json',
			success:function(response){

				console.log(response);

				$('#edit_elements_value_name').val(response.value);

				// submit the edit form
				$('#updateForm').unbind('submit').bind('submit',function(){
					var form=$(this);

					//remove the text-danger
					$('.text-danger').remove();

					$.ajax({
						url: form.attr('action')+'/'+id,
						type: form.attr('method'),
						data: form.serialize(),
						dataType: 'json',
						success: function(response){
							manageTable.DataTable().ajax.reload();

							if(response.success===true){
								$('#messages').html(
								'<div class="alert alert-success alert-dismissible" role="alert" '+
								'<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>'+
								'<strong><span class="glyphicon-ok-sign"></span></strong>'+response.messages+
								'</div>');

								//hide modal
								$('#editModal').modal('hide');								
								$('#updateForm .form-group').removeClass('has-error').removeClass('has-success');
							}
							else {
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

	
</script>

