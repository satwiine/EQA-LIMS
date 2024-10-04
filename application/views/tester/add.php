
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



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Adding New Tester 
      
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">New Tester</li>
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
          <form role="form" action="<?php echo base_url('saveTester') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="panel panel-info">
                	<div class="panel-heading">
                		<span style="margin: 0 auto; display: table;">EQA (PT) PROFICIENCY TESTING SCHEME: New Tester</span>
                	</div>
                	<div class="row" style="padding-left: 15px;">
                		<div style="margin:auto; width: 30%; padding: 10px;">
                			<div class="form-group">
  												<label for="testercode">Tester Code:</label>  
  												<input type="text" class="form-control" id="testercode" name="testercode" width="50%" value="<?php echo $opencode['testercode'];?>" autocomplete="off"/>
  								
											</div>
											<div class="form-group">
  												<label for="testername">Tester Name:</label>  
  												<input type="text" class="form-control" id="testername" name="testername" width="50%" placeholder="Enter Tester Name" autocomplete="off"/>
  								
											</div>

											<div class="form-group">
  												<label for="cadre">Cadre:</label>  
  												<select class="form-control" id="cadre" name="cadre">
  													<option value="">Select</option>
  													<?php
  														foreach ($cadre as $c):
  																echo '<option value="'.$c['id'].'">'.$c['name'].'</option>';
  														endforeach;
  													?>
  												</select>
  								
											</div>

											<div class="form-group">
  												<label for="contacts">Tester Contacts:</label>  
  												<input type="text" class="form-control" id="contacts" name="contacts" width="50%" placeholder="Enter Tester Contacts" autocomplete="off"/>
  								
											</div>

											<div class="form-group">
  												<label for="facility">Facility:</label>  
  												<select class="form-control" name="facility" id="facility">
  													<option value="">Select</option>
  													<?php
  															foreach($facility as $f):
  																	echo '<option value="'.$f['sitecode'].'">'.$f['Sitename'].' - ('.$f['DistrictName'].')</option>';
  															endforeach;
  													?>
  												</select>
  								
											</div>

											<div class="form-group">
  												<label for="dept">Dapartment:</label>  
  												<select class="form-control" name="dept" id="dept">
  													<option value="">Select</option>
  													<?php
  															foreach($dept as $d):
  																	echo '<option value="'.$d['id'].'">'.$d['departmentname'].'</option>';
  															endforeach;
  													?>
  												</select>
  								
											</div>
												<div class="box-footer">
					                <button type="submit" class="btn btn-primary">Save Changes</button>
					                <a href="<?php echo base_url('manageTester/') ?>" class="btn btn-danger">Back</a>
					              </div>
	                	</div>		                	
                	</div>
                </div>    
              </div>
              <!-- /.box-body -->

              
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
	$('#hivnottested').multiselect({		
		nonSelectedText: 'Select Reason'				
	});

	$('#syphnottested').multiselect({		
		nonSelectedText: 'Select Reason'				
	});

$('#form_serial').on('change',function(){
	var batch 			=$('#batchnum').val();
	var site 				=$('#sitecode').val();
	var formserial 	= $(this).val();
	var testercode	= $('#testercode').val();


	//check for duplicate, if not return dod for facility

	if($.trim(formserial)==''){
		$("#form_serial").css("background-color", "red");
	}
	else {
		$("#form_serial").css("background-color", "white");
		$.ajax({
			type: "post",
			url: base_url+'/getDoD/'+testercode+'/'+formserial+'/'+site+'/'+batch,
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

//get dsr and copare with dod
$('#dsr').on('change',function(){
	var dod = $('#dod').val();
	var dsr = $(this).val();
	var d 	= new Date();

	if(Date.parse(dsr)<Date.parse(dod)){
    $("#dod").css("background-color", "red");
		$("#dsr").css("background-color", "red");
	}
	else {
		$("#dod").css("background-color", "white");
		$("#dsr").css("background-color", "white");
	}

	if(Date.parse(d)<Date.parse(dsr)){
    //$("#dod").css("background-color", "red");
		$("#dsr").css("background-color", "red");
	}
	else {
		//$("#dod").css("background-color", "white");
		$("#dsr").css("background-color", "white");
	}

});

$('#dtsr').on('change',function(){
	var dtsr 	= $(this).val();
	var dsr = $('#dsr').val();
	var d 		=	new Date();

	if(Date.parse(d)<Date.parse(dtsr)){
    //$("#dod").css("background-color", "red");
		$("#dtsr").css("background-color", "red");
	}
	else {
		//$("#dod").css("background-color", "white");
		$("#dtsr").css("background-color", "white");
	}
	 
	 if(Date.parse(dtsr)<Date.parse(dsr)){
		$("#dtsr").css("background-color", "red");
	}
	else {
		$("#dtsr").css("background-color", "white");
	}

});

//date tested
$('#dtst').on('change',function(){
	var dtst 	= $(this).val();
	var dtsr = $('#dtsr').val();
	var d 		=	new Date();

	if(Date.parse(d)<Date.parse(dtst)){
		$("#dtst").css("background-color", "red");
	}
	else {
		$("#dtst").css("background-color", "white");
	}


	if(Date.parse(dtst)<Date.parse(dtsr)){
		$("#dtst").css("background-color", "red");
	}
	else {
		$("#dtst").css("background-color", "white");
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
							$('#spanTesterName1').html('');
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
								$('#spanTesterName1').html(mydata.TesterName);
								
							
							}	
						});
					
					}
});

$('#dtst').on('change',function(){
	$('#testingDate').val($(this).val());
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