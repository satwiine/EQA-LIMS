<!DOCTYPE html>
<html>
<head>
  <title>Uganda Virus Research Institue - Import Distribution</title>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>


<!-- Content Wrapper  -->
<div class="content-wrapper">
	
	<!-- Content Header -->
	<section class="content-header">
		<h1>Import a Distribution File</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
			<li class="active">Distributions</li>
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
				<div class="box-body">
					<form action="<?php echo base_url();?>manage/importFile" method="post" enctype="multipart/form-data">
					    Upload excel file : 
					    <input type="file" name="uploadFile" value="" /><br><br>
					    <input type="submit" name="submit" value="Upload" />
					</form>
					

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
</html>