<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.12.4.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.dataTables.min.css');?>">
<!-- Content Wrapper  -->
<div class="content-wrapper">
  
  <!-- Content Header -->
  <section class="content-header">
    <h1>Recency Results Dispatch </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active">Dispatch</li>
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
      //print_r($_SESSION);
          if($_SESSION['id']==19 || $_SESSION['id']==1 || $_SESSION['id']==3){

            ?>
            <a href="#" class="btn btn-primary btn-sm">Add Tester</a>
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
                <th>#</th>
                <th>Batch</th>
                <th>Testercode</th>
                <th>Quarter</th>
                <th>Hub</th>
                <th>Testing Site</th>
                <th>District</th>
                <th>Division</th>
                <th>Location</th>
                <th>Date of Dispatch</th>
                <th>Date Tested</th>
                <th>Recieved at UVRI</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
          <div>
              <?php if($_SESSION['id']==19) {
                ?>
                <input type="checkbox" id="selectall" onClick="SelectAll(this)" />Select All | With Selected <a href="#" id="batchPrint">Print</a> </div>
                <?php
              }
              elseif($_SESSION['usercat']==2 || $_SESSION['usercat']==1){
                ?>
                  <input type="checkbox" id="selectall" onClick="SelectAll(this)" />Select All | With Selected <a href="#" id="batchReview">Review</a> </div>
                <?php
              }
              ?>
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
    'ajax': base_url+'fetchrecDispatch',
    "lengthMenu": [100, "All", 50, 25],
    'order':[]
  });



  $(document).on('click','#batchPrint',function(){
      var toPrint=getValUsingClass();
      //alert(toPrint);
      PrintBatch(toPrint);
    });

    $(document).on('click','#batchReview', function(){
      var toPreview = getValUsingClass();
      PreviewBatch(toPreview);
    });
  });


function getValUsingClass(){
    /* declare an checkbox array */
    var chkArray = [];
    
    /* look for all checkboes that have a class 'pchk' class attached to it and check if it was checked */
    $(".pchk:checked").each(function() {
      chkArray.push($(this).val());
    });

    return chkArray;
  }

function SelectAll(source){
    checkboxes = document.getElementsByName('samples[]');
    for(var i in checkboxes){
      checkboxes[i].checked=source.checked;
    }
  }

  function PrintBatch(t){
  window.open("http://10.3.0.25:8085/uvriptprinting/index.php?batch="+t);
  }

  function PreviewBatch(t){
    window.open("http://10.3.0.25:8085/uvriptprinting/preview.php?batch="+t);
  }
  
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