<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.12.4.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.dataTables.min.css');?>">

<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- content heade -->
  <section class="content-header">
    <h1>Upload Results</h1>

    <ol class="breadcrumb">
      <li><a href="#">
          <i class="fa fa-dashboard"></i>Home
        </a>
      </li>
      <li class="active"><a href="<?php echo base_url('Element');?>">Elements</a></li>
      <li class="active">
        Elemnets Value
      </li>
    </ol>
  </section>

  <!-- Main Content -->
  <section class="content">
    <!-- Small boxes -->
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
        
        <br><br>

        <div class="box">
          <!-- /.box header -->
          <div class="box-body">
            <?php echo $error;?>
            <table id="manageTable" class="table table-bordered table-hover table-striped">
            <thead>
              <tr>
                    <th>Eligible Sample ID</th>
                    <th>Lab Sample ID</th> 
                    <th>Patient ART Number</th>
                    <th>Gender</th> 
                    <th>Birth Date</th>
                    <th>Facility</th>
                    <th>TAT</th>
                    <th>Action</th>
                </tr>
            </thead>
          </table>

          

          </div>
        </div>
      </div>
    </div>
  </section>
</div>



<!-- js -->
<script type="text/javascript">
  var manageTable;
  var base_url="<?php echo base_url();?>";

  $(document).ready(function(){

    // initialise datatable
    manageTable =$('#manageTable').dataTable({
      dom: 'Bfrtip',
      buttons:['copy','csv','excel','print'],
      'ajax': base_url+'fetchDrUnAmplifiedUpload/',
      'order':[]
    });

  });

  
</script>

