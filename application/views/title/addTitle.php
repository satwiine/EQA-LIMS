
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
      Adding New Title 
      
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">New Title/Cadre</li>
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
          <form role="form" action="<?php echo base_url('saveTitle') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="panel panel-info">
                	<div class="panel-heading">
                		<span style="margin: 0 auto; display: table;">EQA (PT) PROFICIENCY TESTING SCHEME: New Title</span>
                	</div>
                	<div class="row" style="padding-left: 15px;">
                		<div style="margin:auto; width: 30%; padding: 10px;">
                			<div class="form-group">
  												<label for="cadre">Cadre Description:</label>  
  												<input type="text" class="form-control" id="cadre" name="cadre" width="50%"  autocomplete="off"/>
  								
											</div>
											<div class="form-group">
  												<label for="cadre">Category:</label>  
  												<select class="form-control" id="cadre_category" name="cadre_category">
  													<option value="">Select</option>
  													<?php
  														foreach ($category as $c):
  																echo '<option value="'.$c['categoryId'].'">'.$c['CategoryName'].'</option>';
  														endforeach;
  													?>
  												</select>
  								
											</div>

				
												<div class="box-footer">
					                <button type="submit" class="btn btn-primary">Save Changes</button>
					                <a href="<?php echo base_url('manageCadre/') ?>" class="btn btn-danger">Back</a>
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