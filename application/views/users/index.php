
<div class="content-wrapper">
	<section class="content-header">
		<h1>Manage Users</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
			<li class="active">Users</li>
		</ol>
	</section>

	<section class="content">
		<?php
						//print_r();
					?>
		<div class="row">
			<div class="col-md-12 col-xs-12">
				<?php
					if($this->session->flashdata('success')){
				?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<?php echo $this->session->flashdata('success');?>	
					</div>
				<?php
					}
					if ($this->session->flashdata('error')){
					?>
					<div class="alert alert-error alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<?php echo $this->flashdata('error');?>
				</div>
					<?php
					}
				?>


				<div class="box">
					<div class="box-body">
						<table id="userTable" class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th>Username</th>
									<th>Email</th>
									<th>Name</th>
									<th>Category</th>
									<?php
										if($_SESSION['usercat'] <3) {
									?>
										<th>Action</th>
									<?php
										}
									?>
								</tr>
							</thead>
							<tbody>
								<?php if($user_data):
									foreach ($user_data as $k => $v): ?>
									<tr>
										<td><?php echo $v['user_info']['username'];?></td>
										<td><?php echo $v['user_info']['email'];?></td>
										<td><?php echo $v['user_info']['name'];?></td>
										<td><?php echo $v['user_info']['category'];?></td>
										<?php if($_SESSION['usercat'] <3): ?>
										<td>
											<a href="<?php echo base_url('edituser/'.$v['user_info']['userid']);?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
										<?php endif;
										 if($_SESSION['usercat'] ==1):?>
										 	<a href="<?php echo base_url('deleteuser/'.$v['user_info']['userid']);?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>

										 	<!-- Create the delete model -->
										 	<div class="modal fade" id="delete_users<?php echo $v['user_info']['userid'];?>" role="dialog">
										 		<div class="modal-dialog modal-sm">
										 			<div class="modal-content">
										 				<div class="modal-header">
										 					<button type="button" class="close" data-dismiss="modal" >&times</button>
										 					<h4 class="modal-title">Are you Sure </h4>
										 				</div>
										 				<div class="modal-body">
										 					<p>Want to delete <?php echo $v['user_info']['name'];?> </p>
										 				</div>
										 				<div class="modal-footer">
										 					<form action="<?php echo base_url('deleteuser/'.$v['user_info']['iserid']);?>" method="post">
										 						<button type="button" class="btn btn-default" data-dismiss ="modal">Close</button>
										 						<input type="submit" class="btn btn-danger" name="confirm" value="Delete">
										 					</form>
										 				</div>
										 			</div>
										 		</div>
										 	</div>
										<?php endif;?>
										</td>
									<?php //endif;?>
									</tr> 
								<?php endforeach;?>
							<?php endif;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>