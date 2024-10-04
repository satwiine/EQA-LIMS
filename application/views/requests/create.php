<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.dataTables.min.css');?>">

<div class="content-wrapper">
	<!-- Content Header -->
	<section class="content-header">
		<h1>Request Items</h1>

		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
				<li class="active"> Item Request</li>
		</ol>
	</section>
	<section class="content">
		<!-- Select category -->
				<div class="row">
					<div class="col-md-12 col-xs-12">

						<div id="messages"> 	</div>	
						
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
						<form role="form" action="<?php echo base_url('requestItem');?>" method="post" class="form-horizontal" >
							<div class="box-body">

								<?php echo validation_errors();?>

								<div class="form-group">
									<label for="recieptdate" class="col-sm-12 control-label">Today: <?php echo date('d-m-Y');?></label>

								</div>
								<div class="form-group">
									<label for="recieptdate" class="col-sm-12 control-label">Time: <?php echo date('h:i a');?></label>
								</div>

								<div class="col-md-7 col-xs-12 pull pull-left">
									
									<div class="form-group">
										<label for="rxfrom" class="col-sm-5 control-label" style="text-align: left;">Request Date </label>
										<div class="col-sm-7">
											<input type="date" name="requestdate" id="requestdate" class="form-control" value="<?php echo date('Y-m-d');?>" max="<?php echo date('Y-m-d');?>">
										</div>
									</div>
									<div class="form-group">
										<label for="rxfrom" class="col-sm-5 control-label" style="text-align: left;">Requested By </label>
										<div class="col-sm-7">
											<select class="form-control" name="requestedby" id="requestedby">
												<?php
														foreach($requester as $r):
															echo '<option value="'.$r['userid'].'">'.$r['fname'].' '.$r['lname'].'</option>';
														endforeach;
												?>
											</select>
											
										</div>
									</div>
									<div class="form-group">
										<label for="rxfrom" class="col-sm-5 control-label" style="text-align: left;">Select Approver </label>
										<div class="col-sm-7">
											<select class="form-control" name="approver" id="approver" required>
												<option value="">Select</option>
												<?php 
													foreach($approver as $k):
															echo '<option value="'.$k['userid'].'">'.$k['fname'].' '.$k['lname'].'</option>';
													endforeach;
												?>
											</select>
										</div>
									</div>

									
								</div>

								<br><br>
								<table class="table table-bordered" id="product_info_table">
									<thead>
										<tr>
											<th style="width: 30%">Item</th>
											<th style="width: 10%">Qty Available</th>
											<th style="width: 10%">Qty Requested</th>											
											<th style="width: 10%"><button type="button" id="add_row" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button></th>
										</tr>
									</thead>

									<tbody>
										<tr id="row_1">
											<td>
												<select class="form-control select_group product" data-row-id="row_1" id="product_1" name="product[]" style="width: 100%" onchange="getProductData(1)" required="required">
													<option value=""></option>
													<?php foreach($products as $k => $v):?>
														<option value="<?php echo $v['itemid'];?>"><?php echo $v['itemDescription'];?></option>
													<?php endforeach;?>
												</select>
											</td>
											<td>
												<label id="available_label_1"></label>
											</td>
											
											<td>
												<input type="number" name="qty_requested[]" id="qty_requested_1" class="form-control">
											</td>
											
											<td>
												<button type="button" class="btn btn-danger btn-sm" onclick="removeRow('1')"><i class="fa fa-close"></i></button>
											</td>
										</tr>

									</tbody>
								</table>
							</div>

							<div class="box-footer">
								<button type="submit" class="btn btn-success">Request Items</button>
								<a href="<?php echo base_url('');?>" class="btn btn-danger">Back</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
	</div>

<!-- jQuery 3 -->
  <script src="<?php echo base_url('assets/bower_components/jquery/dist/jquery.min.js') ?>"></script>
  
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button);

    $(document).ready(function(){

    });
  </script>
  <!-- Bootstrap 3.3.7 -->
  <script src="<?php echo base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
 
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

  <!-- DataTables -->
<script src="<?php echo base_url('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>"></script>

<script type="text/javascript">
	var base_url ="<?php echo base_url();?>";
	$(document).ready(function(){
		$('.select_group').select2();

		// add new row
		$('#add_row').unbind('click').bind('click',function(){
			//declare working variables
			var table = $('#product_info_table');
			var count_table_tbody_tr = $('#product_info_table tbody tr').length;
			var row_id = count_table_tbody_tr+1;
 			$.ajax({
				url: base_url +'getActiveItems',
				type:'post',
				dataType: 'json',
				success: function(response){
					var html='<tr id="row_'+row_id+'">'+
					'<td><select class="form-control select_group product" data-row-id="'+row_id+'" id="product_'+row_id+'" name="product[]" style="width:100%" onChange="getProductData('+row_id+')">'+
					'<option value=""></option>';

					$.each(response, function(index,value){
						html+= '<option value="'+value.itemid+'">'+value.itemDescription+'</option>';
					});
					html +='</select>'+
					'</td>'+
					'<td><label id="available_label_'+row_id+'"></label> </td>'+
					'<td><input type="number" name="qty_requested[]" id="qty_requested_'+row_id+'" class="form-control"> </td>'+
					'<td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(\''+row_id+'\')" ><i class="fa fa-close"></i></button></td>'+
					'</tr>';
					if(count_table_tbody_tr>=1){
						$('#product_info_table tbody tr:last').after(html);
					}
					else {
						$('#product_info_table tbody').html(html);
					}
					$('.product').select2();
				}
			});
			return false;
		});

		
	});


	function getProductData(row_id){
			var prodct_id =$("#product_"+row_id).val();
			//alert(prodct_id);
			if(prodct_id==""){
				//$('#qty_'+row_id).val('');
				$('#available_label_'+row_id).html('');
			}
			else {
				$.ajax({
					url: base_url+'getItemDataById/'+prodct_id,
					type: 'post',
					data: {product_id : prodct_id},
					dataType: 'json',
					success: function(response){
						$('#available_label_'+row_id).html(response.available_to_request +'/'+ response.quantity);
					}
				});
			} 
		}

		
</script>