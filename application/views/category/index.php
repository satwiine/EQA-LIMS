<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.12.4.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.dataTables.min.css');?>">

<!-- Content Wrapper  -->
<div class="content-wrapper">
	
	<!-- Content Header -->
	<section class="content-header">
		<h1>Manage Item Category</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
			<li class="active">Category</li>
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

			<!-- TODO: Determine if the user is allowed to add a ctegory and show the add button -->
			<button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add Category</button>
			<br> <br>
			<!-- end the check -->

			<div class="box">
				<!-- / .box-header -->
				<div class="box-body">
					
					<table id="manageTable" class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<th>
									Category
								</th>
								<th>
									Status
								</th>
								<!-- TODO: ditermine if user can edit,delete,or update -->
								<th>
									Action
								</th>
							</tr>
						</thead>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
			</div>
			<!-- / .col-md-12 -->
		</div>
		<!-- / .row -->
	</section>
	<!-- / .content -->
</div>
<!-- / . content-wrapper -->


<!-- TODO: Ditermine if user is allowed to create a category and enable/disable the modal -->
<div class="modal fade" tabindex="1" role="dialog" id="addModal">

	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add Category</h4>
			</div>

			<form role="form" action="<?php echo base_url('CreateCategory');?>" method="post" id="createForm">
				<div class="modal-body">
					<div class="form-group">
						<label for="category_name">Category Name</label>
						<input type="text" name="category_name" id="category_name" placeholder="Enter Category Name" class="form-control" autocomplete="off">
					</div>
					<div class="form-group">
						<label for="active">Status</label>
						<select class="form-control" id="active" name="active">
							
							<option value="">Select</option> 
							<?php
								$d=$status;
								foreach ($d as $k) :
									echo '<option value="'.$k['status_id'].'">'.$k['status_description'].'</option>';
								endforeach;
							?>
						</select>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- TODO:end the test -->

<!-- TODO Check if the User can edit -->
<div class="modal fade" tabindex="1" role="dialog" id="editModal" >
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Edit Category</h4>
			</div>
			<form role="form" action="<?php echo base_url('UpdateCategory');?>" method="post" id="updateForm">
				<div class="modal-body">
					<div id="messages"></div>

					<div class="form-group">
						<label for="edit_category_name">Category Name</label>
						<input type="text" name="edit_category_name" id="edit_category_name" class="form-control" placeholder="Enter Category Name" autocomplete="off">
					</div>
					<div class="form-group">
						<label for="edit_category_status">Status</label>
						<select class="form-control" name="edit_category_status" id="edit_category_status">
							<option value="1"> Active </option>
							<option value="2">In-Active</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- 
Determine if user has right to remove and show modal -->
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4>Remove Category</h4>
			</div>

			<form role="form" action="<?php echo base_url('removeCategory');?>" method="post" id="removeForm">
				<div class="modal-body">
					<p>Do you Really want to remove?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger">Delete Element</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	var manageTable;
	var base_url ="<?php echo base_url();?>";

	$(document).ready(function(){

	//initailize the data table
	manageTable =$('#manageTable').DataTable({
		dom: 'Bfrtip',
		buttons:['copy','csv','excel','print'],
		'ajax': base_url+'fetchCategoryData',
		'order':[]
	});

	///create form submission
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

	//
	// edit function
		function editFunc(id)
		{ 
		  $.ajax({
		    url: base_url+'fetchCategoryDataById/'+id,
		    type: 'post',
		    dataType: 'json',
		    success:function(response) {
		    	//alert(response.status_id);
		      $("#edit_category_name").val(response.ItemCatDescription);
		      $("#edit_category_status").val(response.status_id);

		      // submit the edit from 
		      $("#updateForm").unbind('submit').bind('submit', function() {
		        var form = $(this);

		        // remove the text-danger
		        $(".text-danger").remove();

		        $.ajax({
		          url: form.attr('action') + '/' + id,
		          type: form.attr('method'),
		          data: form.serialize(), // /converting the form data into array and sending it to server
		          dataType: 'json',
		          success:function(response) {
		          	alert(response);
		          	return false;
		            manageTable.DataTable().ajax.reload();

		            if(response.success === true) {
		              $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
		                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
		                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
		              '</div>');


		              // hide the modal
		              $("#editModal").modal('hide');
		              // reset the form 
		              $("#updateForm .form-group").removeClass('has-error').removeClass('has-success');

		            } else {

		              if(response.messages instanceof Object) {
		                $.each(response.messages, function(index, value) {
		                  var id = $("#"+index);

		                  id.closest('.form-group')
		                  .removeClass('has-error')
		                  .removeClass('has-success')
		                  .addClass(value.length > 0 ? 'has-error' : 'has-success');
		                  
		                  id.after(value);

		                });
		              } else {
		                $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
		                  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
		                  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
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
					url: form.attr('action')+ '/' + id,
					type: form.attr('method'),
					data: {element_id:id},
					dataType:'json',
					success: function(response){
						alert(response.success);
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

<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.dataTables.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/dataTables.buttons.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/buttons.flash.min.js');?>"></script>

<script type="text/javascript" src="<?php echo base_url('assets/js/jszip.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/pdfmake.min.js');?> "></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/vfs_fonts.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/buttons.html5.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/buttons.print.min.js');?>"></script>
<!-- jQuery Knob Chart -->
  <script src="<?php echo base_url('assets/bower_components/jquery-knob/dist/jquery.knob.min.js') ?>"></script>
  <!-- daterangepicker -->
  <script src="<?php echo base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js') ?>"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script src="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') ?>"></script>
  <!-- Slimscroll -->
  <script src="<?php echo base_url('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') ?>"></script>
  <!-- FastClick -->
  <script src="<?php echo base_url('assets/bower_components/fastclick/lib/fastclick.js') ?>"></script>
  <!-- Select2 -->
  <script src="<?php echo base_url('assets/bower_components/select2/dist/js/select2.full.min.js') ?>"></script>
  <!-- AdminLTE App -->  
  <script src="<?php echo base_url('assets/dist/js/adminlte.min.js') ?>"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="<?php echo base_url('assets/dist/js/pages/dashboard.js') ?>"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?php echo base_url('assets/dist/js/demo.js') ?>"></script>
  <script src="<?php echo base_url('assets/plugins/fileinput/fileinput.min.js') ?>"></script>

  <!-- icheck -->
  <script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js') ?>"></script>