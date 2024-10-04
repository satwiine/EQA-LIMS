<?php
	$itemcat='';
	$itemexp='';
	$attr='';
	$avail='';
	
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>var $j = jQuery.noConflict(true);</script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Add New Products
      
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Products</li>
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
          <form role="form" action="<?php base_url('saveItem') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors();  ?>

                <div class="form-group">

                  <label for="product_image">Image</label>
                  <div class="kv-avatar">
                      <div class="file-loading">
                          <input id="product_image" name="product_image" type="file">
                      </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="product_name">Item name</label>
                 <select class="form-control" id="edit_item_name" name="edit_item_name" onautocomplete="off">
							<option value="">Select</option>
							<?php
								foreach($items as $i):
									if($i['itemid']==$id){
										echo '<option value="'.$i['itemid'].'" selected="selected">'.$i['itemDescription'].'</option>';
										$itemcat=$i['itemCategory'];
										$itemexp=$i['itemExpires'];
										$attr = $i['attribute_value_id'];
										$avail = $i['availability'];
									}
									else {
										echo '<option value="'.$i['itemid'].'">'.$i['itemDescription'].'</option>';
									}
								endforeach;
							?>
						</select>
                </div>

                <div class="form-group">
                	<label for="edit_product_expires">Product Expires?</label>
                	<select class="form-control" id="edit_product_expires" name="edit_product_expires">
                		<option value="">Select</option>
                		<?php
                			if($itemexp==0){
                				echo 	'<option value="0" selected="selected">No</option>
	                    				<option value="1">Yes</option>';
                			}
                			else {
                				echo 	'<option value="1" selected="selected">Yes</option>
	                    				<option value="0">No</option>';
                			}
                		?>
                	</select>
                </div>
                

               

                <div class="form-group">
                  <label for="category">Category</label>
                  <select class="form-control select_group" id="edit_category" name="edit_category" >
                  	<option value="">Select</option>

                    <?php 
                    	foreach ($category as $v): 
	                    	if($v['itemCatId']==$itemcat){
	                    		echo '<option value="'. $v['itemCatId'].'" selected="selected">'.$v['ItemCatDescription'].'</option>';
	                    	}
	                    	else {
	                    		echo '<option value="'. $v['itemCatId'].'">'.$v['ItemCatDescription'].'</option>';
	                    	}
                     	endforeach 
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="category">Unit of Measure</label>
                  <select class="form-control select_group" id="edit_uom" name="edit_uom" >
                  	<option value="">Select</option>

                    <?php 
                    	foreach ($attributes as $a): 
	                    	if($a['id']==$attr){
	                    		echo '<option value="'. $a['id'].'" selected="selected">'.$a['value_name'].'</option>';
	                    	}
	                    	else {
	                    		echo '<option value="'. $a['id'].'">'.$a['value_name'].'</option>';
	                    	}
                     	endforeach 
                    ?>
                  </select>
                </div>
                

                <div class="form-group">
                  <label for="store">Availability</label>
                  <select class="form-control" id="availability" name="availability">
                  	<?php 
                  		if($avail==1){
                  			echo ' <option value="1" selected="selected">Yes</option>
                    <option value="2">No</option>';
                  		}
                  		else {
                  			echo ' <option value="1">Yes</option>
                    <option value="2" selected="selected">No</option>';
                  		}
                  		?>
                   
                  </select>
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?php echo base_url('Controller_Products/') ?>" class="btn btn-danger">Back</a>
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



<!-- End Edit Mdal -->