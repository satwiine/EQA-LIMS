<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.12.4.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.dataTables.min.css');?>">

<!-- Content Wrapper  -->
<div class="content-wrapper">
	
	<!-- Content Header -->
	<section class="content-header">
		<h1>Manage Reporting</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
			<li class="active">Reports</li>
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

			
			<div class="box">
				<div class="box-body" style="padding-top: 2%;">
					<?php 
							///Super Admin
							if($_SESSION['usercat']==1){
								?>
									<table id="manageTable" class="table table-bordered table-hover table-striped">
											<tr>
												<td> Select Report Type</td>
												<td>
													<div class="form-check">
														<input type="radio" name="reporttype" id="reporttype1" value="1" class="form-check-input"> <label class="form-check-label" for="reporttype1">  HIV PT Response</label>
													</div>
													<div class="form-check">
														<input type="radio" name="reporttype" id="reporttype2" value="12" class="form-check-input"> <label class="form-check-label" for="reporttype2"> EQA PTDistribution Records</label>
													</div>
													<div class="form-check">
															<input type="radio" name="reporttype" id="reporttype3" value="3" class="form-check-input"> <label class="form-check-label" for="reporttype3"> Syphilis PT Response</label>
													</div>
													<div class="form-check">
														<input type="radio" name="reporttype" id="reporttype4" value="4" class="form-check-input"> <label class="form-check-label" for="reporttype4">  HIV Recency PTResponse</label>
													</div>
												</td>
											</tr>
											<tr>
												<th>Selection Criteria</th>
												<td>
													<div class="form-check">
														<input type="radio" name="criteria" id="criteria1" value="1" class="form-check-input"> <label class="form-check-label" for="criteria1"> Overall National</label>
													</div>
													<div class="form-check">
														<input type="radio" name="criteria" id="criteria2" value="2" class="form-check-input selreg"> <label class="form-check-label" for="criteria2"> Region</label>
														<div class="displayNone" id="reg" style="display:none;">
			  													<select name="region" class="form-control" id="region" style="width:15%;">
			  														<option value="">Select Region</option>
																			<?php
																				foreach($regions as $rd):
																					echo '<option value"'.$rd['facilityregion'].'">'.$rd['facilityregion'].'</option>';
																				endforeach;
																			?>
																</select>
			  												</div>
													</div>
													<div class="form-check">
														<input type="radio" name="criteria" id="criteria3" value="3" class="form-check-input seldist" > <label class="form-check-label" for="criteria3"> District</label>
														<div class="displayNone" id="Dist" style="display:none;">
			  													<select name="district" class="form-control" id="district" style="width:15%;">
			  														<option value="">Select District</option>
																			<?php
																				foreach($districts as $d):
																					echo '<option value"'.$d['facilitydistrict'].'">'.$d['facilitydistrict'].'</option>';
																				endforeach;
																			?>
																</select>
			  												</div>
													</div>
													<div class="form-check">
														<input type="radio" name="criteria" id="criteria4" value="4" class="form-check-input selfac"> <label class="form-check-label" for="criteria4"> Facility</label>
														<div class="displayNone" id="fac" style="display:none;">
			  													<select name="facility" class="form-control" id="facility" style="width:15%;">
			  														<option value="">Select Facility</option>
																			<?php
																				foreach($sites as $s):
																					echo '<option value"'.$s['sitename'].'">'.$s['sitename'].'</option>';
																				endforeach;
																			?>
																</select>
			  											</div>
													</div>
													<div class="form-check">
														<input type="radio" name="criteria" id="criteria5" value="5" class="form-check-input"> <label class="form-check-label" for="criteria5"> Facility Level</label>
														<div class="displayNone" id="lev" style="display:none;">
			  													<select name="level" class="form-control" id="level" style="width:15%;">
			  														<option value="">Select Level</option>
																			<?php
																				foreach($levels as $fl):
																					echo '<option value"'.$fl['facilitylevel'].'">'.$fl['facilitylevel'].'</option>';
																				endforeach;
																			?>
																</select>
			  											</div>
													</div>
													<div class="form-check">
														<input type="radio" name="criteria" id="criteria6" value="6" class="form-check-input"> <label class="form-check-label" for="criteria6"> Cadre </label>
														<div class="displayNone" id="cad" style="display:none;">
			  													<select name="cadre" class="form-control" id="cadre" style="width:15%;">
			  														<option value="">Select Cadre</option>
																			<?php
																				foreach($cadres as $cr):
																					echo '<option value"'.$cr['cadre'].'">'.$cr['cadre'].'</option>';
																				endforeach;
																			?>
																</select>
			  											</div>
													</div>

												</td>
											</tr>
											<tr rowspan="2">
												<th>Period</th>
												<td>
													<input type="radio" name="period" id="preiod1" value="1" class="form-check-input"> <label class="form-check-label" for="preiod1"> Quarter Range</label>
													<div class="form-check">
														
														<div class="displayNone col-xs-1" id="startp" style="display:none;">
			  													<select name="startperiod" class="form-control" id="startperiod" style="width:100%;">
			  														<option value="">Select Quarter</option>
																			<?php
																				foreach($cycles as $c):
																					echo '<option value"'.$c['cycleid'].'">'.$c['cyclename'].'</option>';
																				endforeach;
																			?>
																</select>
														</div>
														<div class="displayNone col-xs-1" id="endp" style="display:none;">
																<select name="endperiod" class="form-control" id="endperiod" style="width:100%;" c>
			  														<option value="">Select Quarter</option>
																			<?php
																				foreach($cycles as $c):
																					echo '<option value"'.$c['cycleid'].'">'.$c['cyclename'].'</option>';
																				endforeach;
																			?>
																</select>

			  											</div>
													</div>
													
												</td>
											</tr>
											<tr>
												<td></td>
												<td>
													<input type="radio" name="period" id="preiod2" value="2" class="form-check-input"> <label class="form-check-label" for="preiod2"> Quarterly</label>
													<div class="form-check">
														
														<div class="displayNone col-xs-1" id="qtr" style="display:none;">
																<select name="qtr" class="form-control" id="qtr" style="width:100%;" c>
			  														<option value="">Select Quarter</option>
																			<?php
																				foreach($cycles as $c):
																					echo '<option value"'.$c['cycleid'].'">'.$c['cyclename'].'</option>';
																				endforeach;
																			?>
																</select>

			  											</div>
													</div>
												</td>
											</tr>
									</table>
								<?php
							}
								?>
				</div>
			</div>
			<?php // print_r($regions);?>
		</div>
	</div>
</section>

<!-- delete reciept -->


<script type="text/javascript">
	//var manageTable;
	//var base_url = "<?php echo base_url(); ?>";

	$(document).ready(function(){

		$('.selreg').change(function(){
					var opt=$("input[name='region']:checked").val();
					
					if(opt==2){
						$('#reg').css("display","block");
					}
					else{
						$('#fa').addClass("displayNone");
					}

					if(opt==3){
						$('#reg').removeClass("displayNone");
					}
					else{
						$('#reg').addClass("displayNone");
					}

					if(opt==4){
						$('#dist').removeClass("displayNone");
					}
					else{
						$('#dist').addClass("displayNone");
					}
				});
	});
	
</script>