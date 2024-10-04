
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>var $j = jQuery.noConflict(true);</script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">




<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      New DTS Cycle
      
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">DTS Cycles</li>
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
          <form role="form" action="<?php echo base_url('savenewcycle'); ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>

               <div class="panel-body">
                    <div class="row"> 
                      <div class="col-xs-6">
                        <div class="panel panel-default">
                          <div class="panel-heading">DTS Cycle Information</div>
                          <div class="panel-body">
                            <div class="col-xs-12">
                              <table class="table table-condensed" width="90%">
                                <tr>
                                  <th width="45%">Cycle Name</th> 
                                  <td>
                                    <input type="text" name="cyclename" class="form-control">
                                  </td>
                                </tr>
                                <tr>
                                  <th width="45%">Start Date</th> 
                                  <td>
                                    <input type="date" name="startdate" class="form-control">
                                  </td>
                                </tr>
                                 <tr>
                                  <th width="45%">End Date</th> 
                                  <td>
                                    <input type="date" name="enddate" class="form-control">
                                  </td>
                                </tr>
                                <tr>
                                  <th>Quarter</th>
                                  <td><input type="number" name="quarter" class="form-control" min="1" max="4"></td>
                                </tr>
                                <tr>
                                  <th>Cop Year</th>
                                  <td>
                                    <select name="copyear" id="copyear" class="form-control">
                                      <option value="">Select</option>
                                      <?php
                                       foreach ($copyears as $cy):
                                        ?>
                                        <option value="<?php echo $cy['id'];?>"><?php echo $cy['Description'];?></option>
                                        <?php 
                                       endforeach;
                                      ?>
                                    </select>
                                  </td>
                                </tr>
                                
                                <tr>
                                  <th>Description: </th>
                                  <td>  <input type="text" name="cycledescription" class="form-control"></td>
                                </tr>
                                <tr>
                                  <th>Panel Label: </th>
                                  <td>  <input type="text" name="panellabel" class="form-control"> </td>
                                </tr>
                                
                              </table>
                              <div id="err_existing_form" style="padding:15px; margin-bottom: 10px;">
                                
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    
                    </div>
                    
                    

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="submit" class="btn btn-primary" value="Save">
                <a href="<?php echo base_url('dashboard/') ?>" class="btn btn-danger">Back</a>
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

<script type="text/javascript">
  $(document).ready(function() {
    $(".select_group").select2();
    $("#description").wysihtml5();

    $("#mainProductNav").addClass('active');
    $("#addProductNav").addClass('active');
    
    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' + 
        'onclick="alert(\'Call your custom code here.\')">' +
        '<i class="glyphicon glyphicon-tag"></i>' +
        '</button>'; 
    $("#product_image").fileinput({
        overwriteInitial: true,
        maxFileSize: 1500,
        showClose: false,
        showCaption: false,
        browseLabel: '',
        removeLabel: '',
        browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        removeTitle: 'Cancel or reset changes',
        elErrorContainer: '#kv-avatar-errors-1',
        msgErrorClass: 'alert alert-block alert-danger',
        // defaultPreviewContent: '<img src="/uploads/default_avatar_male.jpg" alt="Your Avatar">',
        layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
        allowedFileExtensions: ["jpg", "png", "gif"]
    });

  });
</script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>