<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.dataTables.min.css');?>">

<!-- Content wrapper -->
<div class="content-wrapper">
	<!-- Content Header -->
	<section class="content-header">
		<h1>Add New User</h1>

		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i>Home</li>
				<li class="active">User</li>
		</ol>
	</section>
	<section class="content">
		<!-- Select category -->
		<div class="box box-default">
			<div class="box-header with-border">
				
			</div>

			<div class="box-body">
				<div class="row">
					<div class="col-md-12 col-xs-12">
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

						<form role="form" action="<?php echo base_url('saveUSer');?>" method="post">
							<div class="box-body">
								<?php echo validation_errors();?>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="category">Category</label>
											<select class="form-control" id="category" name="category">
												<option value="">Select Category</option>
												<?php //TODO get categoris 
													foreach($usercategory as $c):
														echo '<option value="'.$c['catid'].'">'.$c['catDescription'].'</option>';
													endforeach;
												?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="fname">First Name</label>
											<input type="text" name="fname" id="fname" class="form-control" placeholder="fname" autocomplete="off">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="lname">Last Name</label>
											<input type="text" name="lname" id="lname" class="form-control" placeholder="lname" autocomplete="off">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="email">Email</label>
											<input type="email" name="email" id="email" class="form-control" placeholder="email" autocomplete="off">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="username">Username</label>
											<input type="text" name="username" id="username" class="form-control" placeholder="username" autocomplete="off">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="telephone">Contact Phone</label>
											<input type="text" name="telephone" id="telephone" class="form-control" placeholder="telephone" autocomplete="off">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="password">Password</label>
											<input type="password" name="password" id="password" class="form-control"  autocomplete="off">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="cpassword">Confirm Password</label>
											<input type="password" name="cpassword" id="cpassword" class="form-control"  autocomplete="off">
										</div>
									</div>
								</div>
							</div>

							<div class="box-footer">
								<button type="button" class="btn btn-primary"> Save & Close</button>
								<a href="<?php echo base_url('Members');?>" class="btn btn-warning">Back</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>