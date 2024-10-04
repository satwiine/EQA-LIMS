
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>var $j = jQuery.noConflict(true);</script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"> -->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

<style type="text/css">
	/*
		overridding padding for panel panel-heading to reduce paading
	*/

	.panel .panel-heading 
	{
    padding-top: 10px;
    padding-bottom: 10px;
	}
</style>
<?php 
echo '<datalist id="code-list">';
	foreach($tester as $t):
			echo '<option>'.$t['tcode'].'</option>';
	endforeach;
echo '</datalist>';

$section1_result="";
$section2_result="";
foreach($testresult as $tr):
	if($tr['section']==1){
		$section1_result.='<option value="'.$tr['id'].'">'.$tr['name'].'</option>';
	}
endforeach;
foreach($testresult as $tr):
	if($tr['section']==2){
		$section2_result.='<option value="'.$tr['id'].'">'.$tr['name'].'</option>';
	}
endforeach;
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Add New EQA PT Form
      
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Recency</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif($this->session->flashdata('error')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>


        <div class="box">
         
          <!-- /.box-header -->
          <form role="form" action="<?php echo base_url('saveRecency') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="panel panel-info">
                	<div class="panel-heading">
                		<span style="margin: 0 auto; display: table;">HIV RAPID TEST FOR RECENT INFECTION PROFICIENCY TESTING SCHEME</span>
                	</div>
                	<div class="row" style="padding-left: 15px;">
                		<div class="col-xs-6">
                			<div class="form-group">
                				<label for="testercode">Tester Code:</label> &nbsp;&nbsp; <span id="spanTesterName1" style="font-weight: bolder;"></span>
  								
  								<input type="text" class="form-control" id="testercode" name="testercode" placeholder="Enter Tester Code" list="code-list" autocomplete="off"/>
							</div>
	                	</div>
	                	<div class="col-xs-6">
	                		<div class="form-group">
      							<label for="form_serial">Form Serial</label>
      							<input type="text" class="form-control" id="form_serial" name="form_serial" placeholder="Form Serial" autocomplete="off"/>
    						</div>
    						
                		</div>
                	</div>
                	<div class="panel-body">
                		<div class="row"> 
                			<div class="col-xs-6">
                				<div class="panel panel-default">
                					<div class="panel-heading">Facility Information</div>
                					<div class="panel-body">
                						<div class="col-xs-12">
                							<table class="table table-condensed" width="90%">
                								<tr>
                									<th width="45%">Facility Name</th> 
                									<td>
						  								<select name="sitecode" id="sitecode" class="form-control">
						  									<option value="">Select</option>
						  									<?php
						  									  foreach($facility as $f):
						  									  	 echo '<option value="'.$f['sitecode'].'">'.$f['Sitename'].' ('.$f['DistrictName'].')</option>';
						  									  endforeach; 
						  									?>
						  								</select>
													</td>
                								</tr>
                								<tr>
                									<th>Facility Level</th>
                									<td><span id="sp_facLecvel"></span> </td>
                								</tr>
                								<tr>
                									<th>Department</th>
                									<td>
                										<select name="department" id="department" class="form-control">
						  									<option value="">Select</option>
						  									<?php
						  									  foreach($department as $d):
						  									  	 echo '<option value="'.$d['id'].'">'.$d['departmentname'].'</option>';
						  									  endforeach; 
						  									?>
						  								</select>
                									</td>
                								</tr>
                								<tr>
                									<th>Location/Street Name: </th>
                									<td> <span id="location"></span> </td>
                								</tr>
                								<tr>
                									<th>Division/Sub-County: </th>
                									<td> <span id="division"></span> </td>
                								</tr>
                								<tr>
                									<th>Delivery Mode: </th>
                									<td> <span id="delimode"></span> </td>
                								</tr>
                								<tr>
                									<th>District: </th>
                									<td> <span id="district"></span> </td>
                								</tr>
                								<tr>
                									<th>Region: </th>
                									<td> <span id="region"></span> </td>
                								</tr>
                							</table>
                							<div id="err_existing_form" style="padding:15px; margin-bottom: 10px;">
                								
                							</div>
                						</div>
                					</div>
                				</div>
                			</div>
            				<div class="col-xs-6">
            					<div class="panel panel-default">
                					<div class="panel-heading">Sample Management Information</div>
                					<div class="panel-body">
                						<div>
                							<table class="table table-condensed" width="90%">
                								<tr>
                									<th> Batch#</th>
                									<td>
                										<select name="batchnum" id="batchnum" class="form-control">
                											<option value="">Select</option>
                											<?php 
                													foreach($activeqtr as $a):
                														if($a['isactive']==1){
                															echo '<option value="'.$a['batchnum'].'" selected>'.$a['batchnum'].'</option>';
                														}
                														else {
                														echo '<option value="'.$a['batchnum'].'">'.$a['batchnum'].'</option>';
                												}
                													endforeach;
                											?>
                										</select>
                									
                									</td>
                								</tr>
                								<tr>
                									<th>Date of Dispatch</th>
                									<td>
                										<input type="date" name="dod" id="dod" class="form-control">
                									</td>
                								</tr>
                								<tr>
                									<th>Date Recieved:(at site)</th>
                									<td>
                										<input type="date" name="dsr" id="dsr" class="form-control">
                									</td>
                								</tr>
                								<tr>
                									<th>Recieved By: (Name)</th>
                									<td>
                										<input type="text" name="rxby" id="rxby" class="form-control">
                									</td>
                								</tr>
                								<tr>
                									<th>Date/Time Reconstituted:</th>
                									<td>
                										<input type="date" name="dtsr" id="dtsr" class="form-control">
                									</td>
                								</tr>
                								<tr>
                									<th>Date/Time Tested:</th>
                									<td>
                										<input type="date" name="dtst" id="dtst" class="form-control">
                									</td>
                								</tr>
                								<tr>
                									<th>Date Recieved at UVRI</th>
                									<td><input type="date" name="daterxatuvri" class="form-control" id="daterxatuvri" max="<?php echo date('Y-m-d');?>"></td>
                								</tr>
                								<tr>
                									<th>Sample Quality</th>
                									<td>
                										<div class="form-check form-check-inline">
														  <input class="form-check-input" type="radio" name="sqty" id="sqty1" value="1" checked>
														  <label class="form-check-label" for="sqty1">Good (Complete Panel)</label>
														</div>
														<div class="form-check form-check-inline">
														  <input class="form-check-input" type="radio" name="sqty" id="sqty2" value="0">
														  <label class="form-check-label" for="sqty2">Unsuitable (specify)</label>
														</div>
														<input type="hidden" name="sqty_specify" id="sqty_specify" class="form-control">
                									</td>
                								</tr>

                							</table>

                						</div>
                					</div>
                				</div>
            				</div>
                		</div>

                		<div class="row">
                			<div class="col-xs-12">
                				<div class="panel panel-default">
                					<div class="panel-heading">
                						Test Kits Used in the Algorithm
                					</div>
                					<div class="panel-body">
			                						<table class="table table-condensed table-bordered">
			                							
			                							<tr>
			                								
			                								<th>Test Name</th>
			                								<th>Kit Lot Number</th>
			                								<th>Expiry Date</th>
			                								<th>Reason for not Testin</th>
			                							</tr>
			                							<tr>
			                								<td>
			                									<select name="recencykitname" id="recencykitname" class="form-control">
									  									<option value="">Select</option>
									  									<?php
									  									  foreach($hivtests as $f):
									  									  	 echo '<option value="'.$f['id'].'">'.$f['name'].'</option>';
									  									  endforeach; 
									  									?>
									  								</select>
			                								</td>
			                								
			                								
			                								<td>
			                									<input type="text" name="recencylotnumber" id="recencylotnumber" class="form-control">
			                								</td>
			                								<td>
			                									<input type="date" name="recencykitexpdate" id="recencykitexpdate" class="form-control">
			                								</td>
			                								<td rowspan="3">
			                									<div class="form-group">
																					<select id="recencynottested" name="recencynottested[]" multiple class="form-control">						    
																						<?php
																						foreach($reasons as $r):
																							echo '<option value="'.$r['id'].'" >'.$r['reason'].'</option>';
																						endforeach; 
																						?>									
																					</select>	
																				</div>
			                								</td>
			                								
			                							</tr>
			                							
			                						</table>
			                					</div>
			                				</div>
			                			</div>
			                		</div>

			                		<div class="row">
			                			<div class="panel panel-default">
			                				<div class="panel-heading">
			                					<span>Results</span>
			                				</div>
			                				<div class="panel-body">
			                					<table class="table table-condensed table-bordered" style="font-size: 12px;">
									<tr style="background-color: #ccc;">
										<td rowspan="2">Sample ID</td>
										<td colspan="3">(Visual Results, Mark if line is Present)</td>
										<td rowspan="2">Recency Interpretation</td>
									</tr>
									<tr style="background-color: #ccc;">
										<td>Control (C) Line </td>
										<td>Verification (V) Line </td>
										<td >Long Term (LT) Line </td>
									</tr>

									<tr>
										<th>QC Long Term</th>
										<td style="text-align: center; vertical-align: middle;">
											<input type="hidden" name="qc_lt_panel" value="10">
											<input type="hidden" name="qc_lt_ctrline" value="100">
											<input type="checkbox" name="qc_lt_clineval" value="1" checked disabled>
										</td>
										<td style="text-align: center; vertical-align: middle;">
											<input type="hidden" name="qc_ltvline" value="200">
											<input type="checkbox" name="qc_ltvlineval" value="1" checked disabled>
										</td>
										<td style="text-align: center; vertical-align: middle;">
											<input type="hidden" name="qc_lt_ltline" value="300">
											<input type="checkbox" name="qc_lt_ltlineval" value="1" checked disabled>
										</td>
										<td style="text-align: center; vertical-align: middle;">
											<input type="hidden" name="qc_lt_frline" value="400">
											<select name="qc_lt_frval" id="qc_lt_frval" class="form-control input-sm" readonly>
											<option value="" >Select</option>
												<?php 
													foreach($testresult as $tr):
														if($tr['id']==9){
															echo '<option value="'.$tr['id'].'" selected>'.$tr['name'].'</option>';

														}
														echo '<option value="'.$tr['id'].'">'.$tr['name'].'</option>';
													endforeach;
												?>
										</select>
										</td>
									</tr>

									<tr>
										<th>QC Recent</th>
										<td style="text-align: center; vertical-align: middle;">
											<input type="hidden" name="qc_rc_panel" value="20">
											<input type="hidden" name="qc_rc_ctrline" value="100">
											<input type="checkbox" name="qc_rc_clineval" value="1" checked disabled>
										</td>
										<td style="text-align: center; vertical-align: middle;">
											<input type="hidden" name="qc_rcvline" value="200">
											<input type="checkbox" name="qc_rcvlineval" value="1" checked disabled>
										</td>
										<td style="text-align: center; vertical-align: middle;">
											<input type="hidden" name="qc_rc_ltline" value="300">
											<input type="checkbox" name="qc_rc_ltlineval" value="1" readonly>
										</td>
										<td style="text-align: center; vertical-align: middle;">
											<input type="hidden" name="qc_rc_frline" value="400">
											<select name="qc_rc_frval" id="qc_rc_frval" class="form-control input-sm" readonly>
											<option value="" >Select</option>
												<?php 
													foreach($testresult as $tr):
														if($tr['id']==10){
															echo '<option value="'.$tr['id'].'" selected>'.$tr['name'].'</option>';
														}
														echo '<option value="'.$tr['id'].'">'.$tr['name'].'</option>';
													endforeach;
												?>
										</select>
										</td>
									</tr>
									<tr>
										<th>QC Negative</th>
										<td style="text-align: center; vertical-align: middle;">
											<input type="hidden" name="qc_ng_panel" value="30">
											<input type="hidden" name="qc_ng_ctrline" value="100">
											<input type="checkbox" name="qc_ng_clineval" value="1" checked disabled>
										</td>
										<td style="text-align: center; vertical-align: middle;">
											<input type="hidden" name="qc_ngvline" value="200">
											<input type="checkbox" name="qc_ngvlineval" value="1" readonly>
										</td>
										<td style="text-align: center; vertical-align: middle;">
											<input type="hidden" name="qc_ng_ltline" value="300">
											<input type="checkbox" name="qc_ng_ltlineval" value="1" readonly>
										</td>
										<td>
											<input type="hidden" name="qc_ng_frline" value="400">
											<select name="qc_ng_frval" id="qc_ng_frval" class="form-control input-sm" readonly>
												<option value="" >Select</option>
												<?php 
													foreach($testresult as $tr):
														if($tr['id']==11){
															echo '<option value="'.$tr['id'].'" selected>'.$tr['name'].'</option>';
														}
														echo '<option value="'.$tr['id'].'">'.$tr['name'].'</option>';
													endforeach;
												?>
											</select>
										</td>
									</tr>

									<tr>
										<th>PT-1</th>
										<td style="text-align: center; vertical-align: middle;">
											<input type="hidden" name="p1_panel" value="40">
											<input type="hidden" name="p1_ctrline" value="100">
											<input type="checkbox" name="p1_clineval" value="1" checked>
										</td>
										<td style="text-align: center; vertical-align: middle;">
											<input type="hidden" name="p1_vline" value="200">
											<input type="checkbox" name="p1_vlineval" value="1" checked>
										</td>
										<td style="text-align: center; vertical-align: middle;">
											<input type="hidden" name="p1_ltline" value="300">
											<input type="checkbox" name="p1_ltlineval" value="1" checked>
										</td>
										<td>
											<input type="hidden" name="p1_frline" value="400">
											<select name="p1_frval" id="p1_frval" class="form-control input-sm">
											<option value="" >Select</option>
												<?php 
													foreach($testresult as $tr):
														echo '<option value="'.$tr['id'].'">'.$tr['name'].'</option>';
													endforeach;
												?>
										</select>
										</td>
									</tr>
									<tr>
										<th>PT-2</th>
										<td style="text-align: center; vertical-align: middle;">
											<input type="hidden" name="p2_panel" value="50">
											<input type="hidden" name="p2_ctrline" value="100">
											<input type="checkbox" name="p2_clineval" value="1" checked>
										</td>
										<td style="text-align: center; vertical-align: middle;">
											<input type="hidden" name="p2_vline" value="200">
											<input type="checkbox" name="p2_vlineval" value="1" checked>
										</td>
										<td style="text-align: center; vertical-align: middle;">
											<input type="hidden" name="p2_ltline" value="300">
											<input type="checkbox" name="p2_ltlineval" value="1" checked>
										</td>
										<td>
											<input type="hidden" name="p2_frline" value="400">
											<select name="p2_frval" id="p2_frval" class="form-control input-sm">
											<option value="" >Select</option>
												<?php 
													foreach($testresult as $tr):
														echo '<option value="'.$tr['id'].'">'.$tr['name'].'</option>';
													endforeach;
												?>
										</select>
										</td>
									</tr>

									<tr>
										<th>PT-3</th>
										<td style="text-align: center; vertical-align: middle;">
											<input type="hidden" name="p3_panel" value="60">
											<input type="hidden" name="p3_ctrline" value="100">
											<input type="checkbox" name="p3_clineval" value="1" checked>
										</td>
										<td style="text-align: center; vertical-align: middle;">
											<input type="hidden" name="p3_vline" value="200">
											<input type="checkbox" name="p3_vlineval" value="1" checked>
										</td>
										<td style="text-align: center; vertical-align: middle;">
											<input type="hidden" name="p3_ltline" value="300">
											<input type="checkbox" name="p3_ltlineval" value="1" checked>
										</td>
										<td>
											<input type="hidden" name="p3_frline" value="400">
											<select name="p3_frval" id="p3_frval" class="form-control input-sm">
											<option value="" >Select</option>
												<?php 
													foreach($testresult as $tr):
														echo '<option value="'.$tr['id'].'">'.$tr['name'].'</option>';
													endforeach;
												?>
										</select>
										</td>
									</tr>
									<tr>
										<th>PT-4</th>
										<td style="text-align: center; vertical-align: middle;">
											<input type="hidden" name="p4_panel" value="70">
											<input type="hidden" name="p4_ctrline" value="100">
											<input type="checkbox" name="p4_clineval" value="1" checked>
										</td>
										<td style="text-align: center; vertical-align: middle;">
											<input type="hidden" name="p4_vline" value="200">
											<input type="checkbox" name="p4_vlineval" value="1" checked>
										</td>
										<td style="text-align: center; vertical-align: middle;">
											<input type="hidden" name="p4_ltline" value="300">
											<input type="checkbox" name="p4_ltlineval" value="1" checked>
										</td>
										<td>
											<input type="hidden" name="p4_frline" value="400">
											<select name="p4_frval" id="p4_frval" class="form-control input-sm">
											<option value="" >Select</option>
												<?php 
													foreach($testresult as $tr):
														echo '<option value="'.$tr['id'].'">'.$tr['name'].'</option>';
													endforeach;
												?>
										</select>
										</td>
									</tr>
									
								</table>
                				</div>
                			</div>
                			<div>
                				<table class="table table-condensed table-bordered">
                					<tr>
                						<th width="12%">Testing Staff</th>
                						<td width="12%"><span id="spanTesterName"></span></td>
                						<th width="6%">Tel</th>
                						<td width="18%"> <span id="spanTesterContact"></span> </td>
                						<th width="8%">Cadre</th>
                						<td width="16%"><span id="spanTesterCadre"></span></td>
                						<th width="12%">Date</th>
                						<td width="12%"><input type="date" name="testingDate" id="testingDate" class="form-control"></td>
                					</tr>
                					<tr>
                						<th>Site Supervisor</th>
                						<td><input type="text" name="supervisor" id="supervisor" class="form-control"> </td>
                						<th>Tel</th>
                						<td> <input type="text" name="supervcontact" id="supervcontact" class="form-control"> </td>
                						<th>Cadre</th>
                						<td colspan> 
                								<select name="supervCadre" id="supervCadre" class="form-control">
                									<option value="">Select</option>
                									<?php 
                										foreach($cadre as $c){
                											echo '<option value="'.$c['id'].'" >'.$c['name'].'</option>';
                										}
                									?>
                									
                								</select>
                						</td>
                						<th>UVRI Reciept Date</th>
                						<td><input type="date" name="daterxatuvri1" class="form-control" id="daterxatuvri1" readonly></td>
                					</tr>
                				</table>
                			</div>
                		</div>
                	</div>
                </div>     
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?php echo base_url('Controller_Products/') ?>" class="btn btn-danger">Back</a>
              </div>
            </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--  <script type="text/javascript" src="<?php //echo base_url('/assets/js/jquery-1.12.4.js');?>"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script> -->

<script type="text/javascript">
	var base_url ="<?php echo base_url();?>";
  $(document).ready(function() {       
	$('#recencynottested').multiselect({		
		nonSelectedText: 'Select Reason'				
	});

	// $('#syphnottested').multiselect({		
	// 	nonSelectedText: 'Select Reason'				 
	// });


$('#form_serial').on('change',function(){
	var batch 			=$('#batchnum').val();
	var site 				=$('#sitecode').val();
	var formserial 	= $(this).val();
	var testercode	= $('#testercode').val();
	//alert (testercode);

//check for duplicate, if not return dod for facility
	if($.trim(formserial)==''){
		$("#form_serial").css("background-color", "red");
	}
	else {
		$("#form_serial").css("background-color", "white");
		$.ajax({
			type: "post",
			url: base_url+'getRecencyDoD/'+batch+'/'+testercode+'/'+formserial+'/'+site,
			success: function(x){
				myDOD=JSON.parse(x);

				//action time
				if(myDOD.dupform==true){
					$("#form_serial").css("background-color", "red");
					$("#testercode").css("background-color", "red");
				}
				else{
					$("#form_serial").css("background-color", "white");
					$("#testercode").css("background-color", "white");
					$('#dod').val(myDOD.dod);
				}
			}

		});
	}

});
	$('#testercode').on('change',function(){
	var code=$(this).val();
//alert(code);
	if(code.trim()==''){
							$('#sitecode').val('');
							$('#sp_facLecvel').html('');
							$('#department').val('');
 							$('#location').html('');
 							$('#division').html('');
							$('#delimode').html('');
							$('#district').html('');
							$('#region').html('');

							$('#spanTesterName').html('');
							$('#spanTesterCadre').html('');
							$('#spanTesterContact').html('');
						return;
					}
					else{
						////use ajax to get tester details 
						//var datastring='v=getSiteData&testercode='+code;
						$.ajax({
							type: "post",
							url: base_url+'/testerDetail/'+code,
							//dataType:"json",
							success: function(g){
								mydata=JSON.parse(g);
								//alert(g);
								
								if(mydata.status==0)
								{
									$("#testercode").css("background-color", "red");
									$('#spanTesterName1').html(mydata.TesterName +' is In-Active');
									return false;
								}
								else 
								{
									$("#testercode").css("background-color", "white");
									$('#sitecode').val(mydata.sitecode);
									$('#sp_facLecvel').html(mydata.LevelName);
									$('#department').val(mydata.Dept);
									$('#location').html(mydata.location);
									$('#delimode').html(mydata.deliverymode);
									$('#district').html(mydata.districtname);
									$('#region').html(mydata.RegionName);
									$('#division').html(mydata.division);
									$('#spanTesterName').html(mydata.TesterName);
									$('#spanTesterCadre').html(mydata.Title);
									$('#spanTesterContact').html(mydata.contacts);
									$('#spanTesterName1').html(mydata.TesterName);
								}
							
							}	
						});
					
					}
});

	$('#dtst').on('change',function(){
	$('#testingDate').val($(this).val());
});

	$('#daterxatuvri').on('change', function(){
		$('#daterxatuvri1').val($(this).val());
	});
});
</script>
<!-- <script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script> -->