
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
      <li class="active">HIV/Syphilis</li>
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
          <form role="form" action="<?php echo base_url('saveDts') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="panel panel-info">
                	<div class="panel-heading">
                		<span style="margin: 0 auto; display: table;">EQA (PT) PROFICIENCY TESTING SCHEM: HIV & SYPHILIS</span>
                	</div>
                	<div class="row" style="padding-left: 15px;">
                		<div class="col-xs-6">
                			<div class="form-group">
  								<label for="testercode">Tester Code</label>
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
                									<td><span id="sp_facLecvel" class="form-control"></span> </td>
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
                									<td> <span id="location" class="form-control"></span> </td>
                								</tr>
                								<tr>
                									<th>Division/Sub-County: </th>
                									<td> <span id="division" class="form-control"></span> </td>
                								</tr>
                								<tr>
                									<th>Delivery Mode: </th>
                									<td> <span id="delimode" class="form-control"></span> </td>
                								</tr>
                								<tr>
                									<th>District: </th>
                									<td> <span id="district" class="form-control"></span> </td>
                								</tr>
                								<tr>
                									<th>Region: </th>
                									<td> <span id="region" class="form-control"></span> </td>
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
            						<?php //print_r($activeqtr);?>
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

                														if($a['isActive']==1){
                															echo '<option value="'.$a['id'].'" selected>'.$a['quartername'].'</option>';
                														}
                														else {
                														echo '<option value="'.$a['id'].'">'.$a['quartername'].'</option>';
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
                									<th>Sample Quality</th>
                									<td>
                										<div class="form-check form-check-inline">
														  <input class="form-check-input" type="radio" name="sqty" id="sqty1" value="1" checked="checked">
														  <label class="form-check-label" for="sqty1">Good (Complete Panel)</label>
														</div>
														<div class="form-check form-check-inline">
														  <input class="form-check-input" type="radio" name="sqty" id="sqty" value="0">
														  <label class="form-check-label" for="sqty">Unsuitable (specify)</label>
														</div>
														<input type="hidden" name="sqty_specify" id="sqty_specify" class="form-control">
                									</td>
                								</tr>

                							</table>

                						</div>

                						<div> <input type="hidden" name="enteredby" value="<?php echo $_SESSION['id'];?>"></div>
                					</div>
                				</div>
            				</div>
                		</div>
                			<fieldset>
												  <legend>Select Bio-Marker Tested:</legend>

												  <div>
												    <input type="radio" id="hiv" name="biomakers" value="hiv"  />
												    <label for="hiv">HIV Only</label>
												 
												    <input type="radio" id="hivsyp" name="biomakers" value="hivsyph" checked />
												    <label for="hivsyph">Hiv and Syphilis</label>
												 
												    <input type="radio" id="syph" name="biomakers" value="syph" />
												    <label for="syph">Syphilis Only</label>
												  </div>
											</fieldset>
                		<div class="row">
                			<div class="col-xs-12">
                				<div class="panel panel-default">
                					<div class="panel-heading">
                						Test Kits Used in the Algorithm
                					</div>
                					<div class="panel-body">
                						<table class="table table-condensed table-bordered">
	                							<tr>
		                								<th></th>
		                								<th colspan="3"><span style="display: table; margin: 0 auto;">HIV</span></th>
		                								<th>Syphilis</th>
		                								<th><i>If you Didn't test, give reason(s) for Specific  </th>
	                							</tr>
                							<tr>
                								<td width="10%"></td>
                								<td>Test1 (Screening) <input type="hidden" name="hivscrcatid" id="hivscrcatid" value="1"></td>
                								<td>Test2 (Confirmatory) <input type="hidden" name="hivconfcatid" id="hivconfcatid" value="2"></td>
                								<td>Test3 (Tie Breaker) <input type="hidden" name="hivtbcatid" id="hivtbcatid" value="3"></td>
                								<td>Test1(Screening) <input type="hidden" name="syphscrcatid" id="syphscrcatid" value="1"></td>
                								<td width="20%">Reason for not Testing HIV</td>
                							
                							</tr>
                							<tr>
                								<td>Test Name</td>
                								<td>
                									<select name="hivscreening" id="hivscreening" class="form-control">
						  											<option value="">Select</option>
									  									<?php
									  									  foreach($hivtests as $f):
									  									  	 echo '<option value="'.$f['id'].'">'.$f['name'].'</option>';
									  									  endforeach; 
									  									?>
						  										</select>
                								</td>
                								<td>
                									<select name="hivconfirmatory" id="hivconfirmatory" class="form-control">
									  									<option value="">Select</option>
									  									<?php
									  									  foreach($hivtests as $f):
									  									  	 echo '<option value="'.$f['id'].'">'.$f['name'].'</option>';
									  									  endforeach; 
									  									?>
									  							</select>
                								</td>
                								<td>
                									<select name="hivtiebreaker" id="hivtiebreaker" class="form-control">
									  									<option value="">Select</option>
									  									<?php
									  									  foreach($hivtests as $f):
									  									  	 echo '<option value="'.$f['id'].'">'.$f['name'].'</option>';
									  									  endforeach; 
									  									?>
									  							</select>
                								</td>
                								<td>
                									<input type="text" name="syphscreening" id="syphscreening" class="form-control">
                								</td>
                								<td>
                									<!--div class="form-group"-->
																		<select class="form-control" id="hivnottested" name="hivnottested[]" multiple>						    
																			<?php
																			foreach($reasons as $r):
																				echo '<option value="'.$r['id'].'" >'.$r['reason'].'</option>';
																			endforeach; 
																			?>									
																		</select>	
																	<!--/div-->
                								</td>
                								
                							</tr>
                							<tr>
                								<td> Lot #</td>
                								<td><input type="text" name="hivscreeninglot" id="hivscreeninglot" class="form-control"></td>
                								<td><input type="text" name="hivconfirmatorylot" id="hivconfirmatorylot" class="form-control"></td>
                								<td><input type="text" name="hivtiebreakerlot" id="hivtiebreakerlot" class="form-control"></td>
                								<td><input type="text" name="syphscreeninglot" id="syphscreeninglot" class="form-control"></td>
                								<td> Reason for not Testing SYPHILIS </td>
                							</tr>
                							<tr>
                								<td>Expiry Date</td>
                								<td><input type="date" name="hivscreeningexpdate" id="hivscreeningexpdate" class="form-control"></td>
                								<td><input type="date" name="hivconfirmatoryexpdate" id="hivconfirmatoryexpdate" class="form-control"></td>
                								<td><input type="date" name="hivtiebreakerexppdate" id="hivtiebreakerexppdate" class="form-control"></td>
                								<td><input type="date" name="syphscreeningexpdate" id="syphscreeningexpdate" class="form-control"></td>
                								<td>
                										<select class="form-control" id="syphnottested" name="syphnottested[]" multiple style="width:10%;" >						    
																			<?php
																				foreach($reasons as $r):
																					echo '<option value="'.$r['id'].'" >'.$r['reason'].'</option>';
																				endforeach; 
																			?>											
																		</select>	
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
                					<table class="table table-condensed table-bordered">
                						<tr>
                							<td></td>
                							<td colspan="4">
                								<span>HIV</span>
                							</td>
                							<td>SYPHILIS</td>
                							<td>Comments</td>
                						</tr>
                						<tr>
                							<th>SampleID</th>
                							<th>Test 1 Screening</th>
                							<th>Test 2 Confirmatory</th>
                							<th>Test 3 Tie Breaker</th>
                							<th>FINAL RESULTS</th>
                							<th>FINAL RESULTS</th>
                							<td></td>
                						</tr>
                						<tr>
                							<td>

                								<?php  
                								foreach($activeqtr as $a):
                									if($a['isActive']==1){
                										echo $a['quartername'];
                									}
                								endforeach;
                								?>
                						-1</td>
                							<td>
                								<input type="hidden" name="p1scrcatid" value="1">
                								<input type="hidden" name="p1spanid" value="1">
                								<select name="hivpanel1scr" id="hivpanel1scr" class="form-control">
                									<option value="">Select</option>
                									<?php echo $section1_result;?>
                								</select>
                							</td>
                							<td>
                								<input type="hidden" name="p1confcatid" value="2">
                								<select name="hivpanel1conf" id="hivpanel1conf" class="form-control">
                									<option value="">Select</option>
                									<?php echo $section1_result;?>
                								</select>
                							</td>
                							<td>
                								<input type="hidden" name="p1tbcatid" value="3">
                								<select name="hivpanel1tb" id="hivpanel1tb" class="form-control">
                									<option value="">Select</option>
                									<?php echo $section1_result;?>
                								</select>
                							</td>
                							<td>
                								<input type="hidden" name="p1frcatid" value="4">
                								<select name="hivpanel1fr" id="hivpanel1fr" class="form-control">
                									<option value="">Select</option>
                									<?php echo $section2_result;?>
                								</select>
                							</td>
                							<td>
                								<input type="hidden" name="p1syfrcatid" value="4">
                								<select name="syphpanel1fr" id="syphpanel1fr" class="form-control">
                									<option value="">Select</option>
                									<?php echo $section2_result;?>
                								</select>
                							</td>
                							<td>
                								<input type="text" class="form-control" id="panel1_comment" name="panel1_comment">
                							</td>
                						</tr>
                						<tr>
                							<td><?php 
                							foreach($activeqtr as $a):
                									if($a['isActive']==1){
                										echo $a['quartername'];
                									}
                								endforeach;?>-2</td>
                							<td>
                								<input type="hidden" name="p2scrcatid" value="1">
                								<input type="hidden" name="p2spanid" value="2">
                								<select name="hivpanel2scr" id="hivpanel2scr" class="form-control">
                									<option value="">Select</option>
                									<?php echo $section1_result;?>
                								</select>
                							</td>
                							<td>
                								<input type="hidden" name="p2confcatid" value="2">
                								<select name="hivpanel2conf" id="hivpanel2conf" class="form-control">
                									<option value="">Select</option>
                									<?php echo $section1_result;?>
                								</select>
                							</td>
                							<td>
                								<input type="hidden" name="p2tbatid" value="3">
                								<select name="hivpanel2tb" id="hivpanel2tb" class="form-control">
                									<option value="">Select</option>
                									<?php echo $section1_result;?>
                								</select>
                							</td>
                							<td>
                								<input type="hidden" name="p2frcatid" value="4">
                								<select name="hivpanel2fr" id="hivpanel2fr" class="form-control">
                									<option value="">Select</option>
                									<?php echo $section2_result;?>
                								</select>
                							</td>
                							<td>
                								<input type="hidden" name="p2sypfrcatid" value="4">
                								<select name="syphpanel2fr" id="syphpanel2fr" class="form-control">
                									<option value="">Select</option>
                									<?php echo $section2_result;?>
                								</select>
                							</td>
                							<td>
                								<input type="text" class="form-control" id="panel2_comment" name="panel2_comment">
                							</td>
                						</tr>
                						<tr>
                							<td><?php 
                								foreach($activeqtr as $a):
                									if($a['isActive']==1){
                										echo $a['quartername'];
                									}
                								endforeach;

                							?>-3</td>
                							<td>
                								<input type="hidden" name="p3scrcatid" value="1">
                								<input type="hidden" name="p3spanid" value="3">
                								<select name="hivpanel3scr" id="hivpanel3scr" class="form-control">
                									<option value="">Select</option>
                									<?php echo $section1_result;?>
                								</select>
                							</td>
                							<td>
                								<input type="hidden" name="p3confcatid" value="2">
                								<select name="hivpanel3conf" id="hivpanel3conf" class="form-control">
                									<option value="">Select</option>
                									<?php echo $section1_result;?>
                								</select>
                							</td>
                							<td>
                								<input type="hidden" name="p3tbcatid" value="3">
                								<select name="hivpanel3tb" id="hivpanel3tb" class="form-control">
                									<option value="">Select</option>
                									<?php echo $section1_result;?>
                								</select>
                							</td>
                							<td>
                								<input type="hidden" name="p3frcatid" value="4">
                								<select name="hivpanel3fr" id="hivpanel3fr" class="form-control">
                									<option value="">Select</option>
                									<?php echo $section2_result;?>
                								</select>
                							</td>
                							<td>
                								<input type="hidden" name="p3syfrcatid" value="4">
                								<select name="syphpanel3fr" id="syphpanel3fr" class="form-control">
                									<option value="">Select</option>
                									<?php echo $section2_result;?>
                								</select>
                							</td>
                							<td>
                								<input type="text" class="form-control" id="panel3_comment" name="panel3_comment">
                							</td>
                						</tr>
                						<tr>
                							<td><?php 
                								foreach($activeqtr as $a):
                									if($a['isActive']==1){
                										echo $a['quartername'];
                									}
                								endforeach;

                							?>-4</td>
                							<td>
                								<input type="hidden" name="p4scrcatid" value="1">
                								<input type="hidden" name="p4spanid" value="4">
                								<select name="hivpanel4scr" id="hivpanel4scr" class="form-control">
                									<option value="">Select</option>
                									<?php echo $section1_result;?>
                								</select>
                							</td>
                							<td>
                								<input type="hidden" name="p4confcatid" value="2">
                								<select name="hivpanel4conf" id="hivpanel4conf" class="form-control">
                									<option value="">Select</option>
                									<?php echo $section1_result;?>
                								</select>
                							</td>
                							<td>
                								<input type="hidden" name="p4tbcatid" value="3">
                								<select name="hivpanel4tb" id="hivpanel4tb" class="form-control">
                									<option value="">Select</option>
                									<?php echo $section1_result;?>
                								</select>
                							</td>
                							<td>
                								<input type="hidden" name="p4frcatid" value="4">
                								<select name="hivpanel4fr" id="hivpanel4fr" class="form-control">
                									<option value="">Select</option>
                									<?php echo $section2_result;?>
                								</select>
                							</td>
                							<td>
                								<input type="hidden" name="p4syfrcatid" value="4">
                								<select name="syphpanel4fr" id="syphpanel4fr" class="form-control">
                									<option value="">Select</option>
                									<?php echo $section2_result;?>
                								</select>
                							</td>
                							<td>
                								<input type="text" class="form-control" id="panel4_comment" name="panel4_comment">
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
                						<td><input type="date" name="daterxatuvri" class="form-control" id="daterxatuvri"></td>
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
              <div class="row">
              	
              	<!-- control inputs from the sample-->
              	<input type="hidden" name="testercode2" id="testercode2" value="<?php echo $sample['testercode']; ?>">
              	<input type="hidden" name="form_serial2" id="form_serial2" value="<?php echo $sample['formserial']; ?>">
              	<input type="hidden" name="sitecode2" id="sitecode2" value="<?php echo $sample['sitecode'];?>">
              	<input type="hidden" name="cycleid2" id="cycleid2" value="<?php echo $sample['cycleid'];?>">
              	<input type="hidden" name="dod2" id="dod2" value="<?php echo $sample['dodi'];?>">
              	<input type="hidden" name="dsr2" id="dsr2" value="<?php echo $sample['dsr'];?>">
              	<input type="hidden" name="dtsr2" id="dtsr2" value="<?php echo $sample['dtsr'];?>">
              	<input type="hidden" name="dtst2" id="dtst2" value="<?php echo $sample['dtst'];?>">
              	<input type="hidden" name="department2" id="department2" value="<?php echo $sample['dept'];?>">
              	<input type="hidden" name="" id="" value="<?php //echo $sample[''];?>">
              	<input type="hidden" name="" id="" value="<?php  //echo $sample[''];?>">
              	<input type="hidden" name="" id="" value="<?php // echo $sample[''];?>">
              	<input type="hidden" name="" id="" value="<?php // echo $sample[''];?>">
              	<input type="hidden" name="" id="" value="<?php // echo $sample[''];?>">
              	<input type="hidden" name="" id="" value="<?php // echo $sample[''];?>">
              	<input type="hidden" name="" id="" value="<?php // echo $sample[''];?>">
              </div>
            </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    <?php print_r($hivtestkit);?>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--  <script type="text/javascript" src="<?php //echo base_url('/assets/js/jquery-1.12.4.js');?>"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script> -->

<script type="text/javascript">
	


</script>
<script type="text/javascript">

function comparevs(s1,s2){
		if(s1==s2){
			return 1;
		}
		else 
		{
			return 0;
		}


	}

var base_url ="<?php echo base_url();?>";
  $(document).ready(function() {       
			$('#hivnottested').multiselect({		
				nonSelectedText: 'Select Reason'				
			});

			$('#syphnottested').multiselect({		
				nonSelectedText: 'Select Reason'				
			});

		$('#testercode').on('change',function(){
				var code=$(this).val();
			 	if(comparevs($('#testercode').val(),$('#testercode2').val())==0){
			 		$('#testercode').css("background-color", "red");
			 	}
			 	else
			 	{
			 		$('#testercode').css("background-color", "white");
			 	}

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
										
									
									}	
								});
							
							}
		});

		///form serial
		$('#form_serial').on('change',function(){
			if(comparevs($('#form_serial').val(),$('#form_serial2').val())==0){
			 		$('#form_serial').css("background-color", "red");
			 	}
			 	else
			 	{
			 		$('#form_serial').css("background-color", "white");
			 	}
		});

		
		///Facility
		$('#sitecode').on('change',function(){
			if(comparevs($('#sitecode').val(),$('#sitecode2').val())==0){
			 		$('#sitecode').css("background-color", "red");
			 	}
			 	else
			 	{
			 		$('#sitecode').css("background-color", "white");
			 	}
		});

		
		///Department
		$('#department').on('change',function(){
			if(comparevs($('#department').val(),$('#department2').val())==0){
			 		$('#department').css("background-color", "red");
			 	}
			 	else
			 	{
			 		$('#department').css("background-color", "white");
			 	}
		});

		///CYCLE
		$('#batchnum').on('change',function(){
			if(comparevs($('#batchnum').val(),$('#batchnum2').val())==0){
			 		$('#batchnum').css("background-color", "red");
			 	}
			 	else
			 	{
			 		$('#batchnum').css("background-color", "white");
			 	}
		});

		///DOD
		$('#dod').on('change',function(){
			if(comparevs($('#dod').val(),$('#dod2').val())==0){
			 		$('#dod').css("background-color", "red");
			 	}
			 	else
			 	{
			 		$('#dod').css("background-color", "white");
			 	}
		});
});

</script>
