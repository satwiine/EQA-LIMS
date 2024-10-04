<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.dataTables.min.css');?>">

<div class="content-wrapper">
	<!-- Content Header -->
	<section class="content-header">
		<h1>Cycle Results</h1>

		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
				<li class="active"> Cycle Results </li>
		</ol>
	</section>
	<section class="content">
		<!-- Select category -->
				<div class="row">
					<div class="col-md-12 col-xs-12">

						<div id="messages">	</div>	
						
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

						<!-- get the stores and put them in a select -->
						<?php 
								$warehouse='<option value="">Select</option>';
								foreach($stores as $k => $v):
									$warehouse.='<option value="'.$v['id'].'">'.$v['name'].'</option>';						
								endforeach;
						?>
					<div class="box">
						<form role="form" action="<?php echo base_url('saveCycleResults');?>" method="post" class="form-horizontal" id="createForm">
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
										<label for="description" class="col-sm-5 control-label" style="text-align: left;">Cycle</label>
										<div class="col-sm-7">
											 <select class="form-control select_group" name="cyclename">
											 	<option value="">Select Cycle</option>
											 	<?php
											 			foreach($cycle as $c):
											 					echo '<option value="'.$c['id'].'">'.$c['quartername'].'</option>';
											 			endforeach;
											 	?>
											 </select>
                  </textarea>
										</div>
									</div>
								</div>
									<?php //print_r($cycle);?>
								<br><br>
								<table class="table table-bordered" id="product_info_table">
									<thead>
										<tr>
											<th style="width: 20%">Sample Number</th>
											<th style="width: 30%">Screening Result</th>
											<th style="width: 10%">Confirmatory Result</th>
											<th style="width: 10%">Tie Breaker</th>
											<th style="width: 10%">HIV Final Result</th>
											<th style="width: 10%">Syphilis Final Result</th>
											<th style="width: 10%"><button type="button" id="add_row" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button></th>
										</tr>
									</thead>
									
									<tbody>
										<tr id="row_1">
											<td>
													<input type="hidden" id="panel_1" name="panel[]" data-row-id="row_1" value="1" ><label>Panel - 1</label>
											</td>
											<td>
												<select class="form-control select_group product" data-row-id="row_1" id="scr_1" name="scr[]" style="width: 100%"  required="required">
													<option value=""></option>
													<?php foreach($sec_testresults as $k => $v):?>
														<option value="<?php echo $v['id'];?>"><?php echo $v['name'];?></option>
													<?php endforeach;?>
													<input type="hidden" name="scr_cat[]" id="scr_cat_1" value="1" >
													<input type="hidden" name="scr_sch[]" id="scr_sch_1" value="1" >
												</select>
											</td>
											<td>
												<select class="form-control select_group product" data-row-id="row_1" id="conf_1" name="conf[]" style="width: 100%" >
													<option value=""></option>
													<?php foreach($sec_testresults as $k => $v):?>
														<option value="<?php echo $v['id'];?>"><?php echo $v['name'];?></option>
													<?php endforeach;?>
												</select>
													<input type="hidden" name="conf_cat[]" id="conf_cat_1" value="2" >
													<input type="hidden" name="conf_sch[]" id="conf_sch_1" value="1" >
											</td>
											<td>
												<select class="form-control select_group product" data-row-id="row_1" id="tb_1" name="tb[]" style="width: 100%" >
													<option value=""></option>
													<?php foreach($sec_testresults as $k => $v):?>
														<option value="<?php echo $v['id'];?>"><?php echo $v['name'];?></option>
													<?php endforeach;?>
												</select>
													<input type="hidden" name="tb_cat[]" id="tb_cat_1" value="3" >
													<input type="hidden" name="tb_sch[]" id="tb_sch_1" value="1" >
											</td>
											<td>
												<select class="form-control select_group product" data-row-id="row_1" id="hivfr_1" name="hivfr[]" style="width: 100%"  required="required">
													<option value=""></option>
													<?php foreach($fr_testresults as $k => $v):?>
														<option value="<?php echo $v['id'];?>"><?php echo $v['name'];?></option>
													<?php endforeach;?>
														<input type="hidden" name="hfr_cat[]" id="hfr_cat_1" value="4" >
														<input type="hidden" name="hfr_sch[]" id="hfr_sch_1" value="1" >
												</select>
											</td>
											<td>
												<select class="form-control select_group product" data-row-id="row_1" id="sypfr_1" name="sypfr[]" style="width: 100%" required="required">
													<option value=""></option>
													<?php foreach($fr_testresults as $k => $v):?>
														<option value="<?php echo $v['id'];?>"><?php echo $v['name'];?></option>
													<?php endforeach;?>
												</select>
														<input type="hidden" name="sfr_cat[]" id="sfr_cat_1" value="4" >
														<input type="hidden" name="sfr_sch[]" id="sfr_sch_1" value="2" >
											</td>
											<td>
												<button type="button" class="btn btn-danger btn-sm" onclick="removeRow('1')" ><i class="fa fa-close"></i></button>
											</td>
										</tr>

									</tbody>
								</table>
							</div>

							<div class="box-footer">
								<button type="submit" class="btn btn-success">Add Results</button>
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
				url: base_url +'getTestResult',
				type:'post',
				dataType: 'json',
				success: function(response){
					var html='<tr id="row_'+row_id+'">'+
					'<td><input type="hidden" value="'+(row_id)+'" id="panel_'+row_id+'" name="panel[]" data-row-id="row_'+row_id+'" ><label>Panel - '+row_id+'</label>'+
					'</td>'+
					'<td><select class="form-control select_group product" data-row-id="'+row_id+'" id="scr_'+row_id+'" name="scr[]" style="width:100%"  required>'+
					'<option value=""></option>';

					$.each(response, function(index,value){
						if(value.section==1){
							html+= '<option value="'+value.id+'">'+value.name+'</option>';
						}
						
					});
					html +='</select></td><td><select class="form-control select_group product" data-row-id="'+row_id+'" id="conf_'+row_id+'" name="conf[]" style="width:100%" >'+
					'<option value=""></option>';
						$.each(response, function(index,value){
						if(value.section==1){
							html+= '<option value="'+value.id+'">'+value.name+'</option>';
						}
						
					});
					html +='</select></td><td><select class="form-control select_group product" data-row-id="'+row_id+'" id="tb_'+row_id+'" name="tb[]" style="width:100%" >'+
					'<option value=""></option>';
						$.each(response, function(index,value){
						if(value.section==1){
							html+= '<option value="'+value.id+'">'+value.name+'</option>';
						}
						
					});
					html +='</select></td>'+
					'<td><select class="form-control select_group product" data-row-id="'+row_id+'" id="hivfr_'+row_id+'" name="hivfr[]" style="width:100%" required >'+
					'<option value=""></option>';
						$.each(response, function(index,value){
						if(value.section==2 && value.scheme==1){
							html+= '<option value="'+value.id+'">'+value.name+'</option>';
						}
						
					});
					html +='</select></td>'+
					'<td><select class="form-control select_group product" data-row-id="'+row_id+'" id="sypfr_'+row_id+'" name="sypfr[]" style="width:100%" required >'+
					'<option value=""></option>';
						$.each(response, function(index,value){
						if(value.section==2 && value.scheme==1){
							html+= '<option value="'+value.id+'">'+value.name+'</option>';
						}
						
					});
					html +='</select></td> </td>'+
					
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

	function removeRow(tr_id)
  {
    $("#product_info_table tbody tr#row_"+tr_id).remove();
  }

	function getProductData(row_id){
			var prodct_id =$("#scr_"+row_id).val();
			//alert(prodct_id);
			if(prodct_id==""){
				$('#qty_'+row_id).val('');
				$('#exp_label_'+row_id).html('');
				$('#exp_dt_'+row_id).val('');
				$('#expires_'+row_id).val(0);
				$('#warehouse_'+row_id).val('');
			}
			else {
				$.ajax({
					url: base_url+'getItemDataById/'+prodct_id,
					type: 'post',
					data: {product_id : prodct_id},
					dataType: 'json',
					success: function(response){
						
						if(response.itemExpires==0){
							$('#exp_label_'+row_id).html('No');
							$('#exp_dt_'+row_id).val('');
							$('#expires_'+row_id).val(0);
							$('#exp_dt_'+row_id).prop('disabled',true);
						}
						else {
							$('#exp_label_'+row_id).html('<span style="text-align:center;color:green">Yes</span>');
							$('#exp_dt_'+row_id).val('');
							$('#expires_'+row_id).val(1);
							$('#exp_dt_'+row_id).prop('disabled',false);
							$('#exp_dt_'+row_id).attr('required', true);
						}
					}
				});
			} 
		}


		function getSCRData(row_id){
			var testres_id=$("#scr_"+row_id).val();


		}
		
</script>