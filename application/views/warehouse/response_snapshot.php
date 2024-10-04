<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.12.4.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.dataTables.min.css');?>">

<!-- Content Wrapper  -->
<div class="content-wrapper">
  
  <!-- Content Header -->
  <section class="content-header">
    <h1>Manage Testers </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active">Testers</li>
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

      <?php 
          if($_SESSION['usercat']==1 || $_SESSION['usercat']==6 || $_SESSION['usercat']==3){
            ?>
            <a href="<?php echo base_url('addTester');?>" class="btn btn-primary btn-sm">Add Tester</a>
            <?php
          }
      ?>
      <br> <br>
      <!-- end the check -->

      <div class="box">
        <!-- / .box-header -->
        <div class="box-body">
          
          <table id="manageTable" class="table table-bordered table-hover table-striped">
            <thead>
              <tr>
                <th>Testercode</th>
                <th>Tester Name</th>
                <th>Contact</th>
                <th>Cadre</th>
                <th>Cadre Category</th>
                <th>Site Code</th>
                <th>Faciliity</th>
                <th>Facility Level</th>
                <th>Owner </th>
                <th>Department</th>
                <th>District</th>
                <th>Region</th>
                <th>CycleID</th>
                <th>Cycle Year</th>
                <th>Description</th>
                <th>Cycle Name</th>
                <th>Dispatch Date</th>
                <th>Reciept Date</th>
                <th>Recieved By</th>
                <th>Reconstitution Date</th>
                <th>Test Date</th>
                <th>UVRI Reciept Date</th>
                <th>Form Serial</th>
                <th>Approved By</th>
                <th>Approval Date</th>
                <th>Score</th>
                <th>Status</th>
                <th>Supervisor Name</th>
                <th>Delivered by</th>
                <th>Comments</th>
                <!-- TODO: ditermine if user can edit,delete,or update -->
                
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




<script type="text/javascript">
  var manageTable;
  var base_url ="<?php echo base_url();?>";

  $(document).ready(function(){

  //initailize the data table
  manageTable =$('#manageTable').DataTable({
    dom: 'Bfrtip',
    buttons:['copy','csv','excel','print'],
    'ajax': base_url+'fetchresponsesnapshot',
    'order':[]
  });

});

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