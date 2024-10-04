<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.12.4.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.dataTables.min.css');?>">

<!-- Content Wrapper  -->
<div class="content-wrapper">
	
	<!-- Content Header -->
	<section class="content-header">
		<h1>Laboratory Sample Processing</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
			<li class="active">Process Sample</li>
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
				<?php endif;

				//make a prefix to add on labno

			    function RandomString()
			    {
			        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			        $randstring = '';
			        for ($i = 0; $i < 3; $i++) {
			            $randstring .= $characters[rand(0, strlen($characters))];
			        }
			        return $randstring;
			    }

			     $randomstring =RandomString();
			     $labno = $randomstring . uniqid();
				?>


			<div class="box">
				<div class="box-body">
					<form method="post" action="<?php echo base_url('processLabResult');?>">
						<table class="table table-bordered table-striped">
							<tr>
								<th colspan="6" style="padding-top:40px"> Specimen Identification Parameters</th>
							</tr>
							<tr>
								<th>Lab Specimen Identifier</th><td><?php echo $sampledetail['sampleid'];?></td>
								<th>National Specimen Identifier</th><td><?php echo $sampledetail['specimenuuid'];?></td>
								<th>Specimen Number</th><td><?php echo $sampledetail['specimen_no'];?></td>
							</tr>
							<tr>
								<th colspan="6" style="padding-top:40px"> Patient Details </th>
							</tr>
							<tr>
								<th>Patient Name</th><td><?php echo $sampledetail['surname'];?></td>
								<th>Gender</th><td><?php echo $sampledetail['gender'];?></td>
								<th>Age</th><td><?php echo $sampledetail['age'];?></td>
							</tr>
							<tr>
								<td colspan="6" style="padding-top:40px">Laboratory Request Parameters</td>
							</tr>
							<tr>
								<th>Test Requested</th><td><?php echo $sampledetail['disease_code'];?></td>
								<th>Requested From</th><td><?php echo $sampledetail['name_of_collection_point'];?></td>
								<th>Request Date</th><td><?php echo $sampledetail['request_date'];?></td>
							</tr>

							<tr>
								<td colspan="6" style="padding-top:40px">Other Request Information</td>
							</tr>
							<tr>
								<th>Patient Nationality</th><td><?php echo $sampledetail['nationality'];?></td>
								<th>Sample Type</th><td><?php echo $sampledetail['sample_type'];?></td>
								<th>District</th><td><?php echo $sampledetail['district'];?></td>
							</tr>
						</table>

						<input type="hidden" name="uuid" value="<?php echo $sampledetail['sampleid'];?>">
						<input type="hidden" name="labno" value="<?php echo $labno;?>">

						<button type="submit" value="accession" class="btn btn-success btn-sm">Accession Sample</button>
					</form>
					<?php
							//print_r($sampledetail);
					?>
				</div>
			</div>
		</div>
	</div>
</section>
</div>






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