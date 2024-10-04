<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.dataTables.min.css');?>">

<div class="content-wrapper">
	<!-- Content Header -->
	<section class="content-header">
		<h1>Review Request</h1>

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
						 

					<div class="box">
							<div class="box-body">
								<h3>Inventory Request </h3>
								<div class="col-md-6">
									<table>
										<tr>
											<th>Requested By</th>
											<td><?php  echo $request['requester']; ?></td>
										</tr>
										<tr>
											<th>Approving </th>
											<td><?php  echo $request['approver']; ?></td>
										</tr>
										<tr>
											<th>Request Date</th>
											<td><?php  echo $request['requestdate']; ?></td>
										</tr>
									</table>
								</div>								

								<br><br>
								<table class="table table-bordered" id="request_table">
									<thead>
										<tr>
											<th style="width: 30%">Item</th>
											<!-- <th style="width: 10%">Qty Available</th> -->
											<th style="width: 10%">Qty Requested</th>											
											
										</tr>
									</thead>

									<tbody>
										<?php
										foreach($requestdetail as $rd):
											?>
											<tr>
												<td><?php echo $rd['itemDescription'];?></td>
												<td><?php echo $rd['requestedquantity'];?></td>
												
											</tr>
											<?php
										endforeach;
										?>

									</tbody>
								</table>
							</div>

							<div class="box-footer">
								<button type="submit" class="btn btn-success">Request Items</button>
								<a href="<?php echo base_url('');?>" class="btn btn-danger">Back</a>
							</div>
					

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