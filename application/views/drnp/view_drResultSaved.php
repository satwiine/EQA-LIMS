<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.12.4.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.dataTables.min.css');?>">

<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- content heade -->
  <section class="content-header">
    <h1>Manage Elements</h1>

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
        
        <div class="box">
          <div class="box-body">
            <h5>Get Result File </h5>
          </div>
        </div>

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
           

			

			<pre>
				<?php
				 print_r($feedback);
				?>
				 
			</pre>
			<p><?php echo anchor('manage/getDRjsonResult', 'Upload Another File!'); ?></p>

          </div>
        </div>
      </div>
    </div>
  </section>
</div>



<!-- js -->


