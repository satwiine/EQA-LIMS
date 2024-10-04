<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Integrated EQA System</title>

	<meta content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css');?>">

	<!-- Fontawesome -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

	<!-- Ionicons -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

	<!-- Theme Style -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css');?>">

	<!-- iCheck  -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/iCheck/square/blue.css');?>">


</head>
<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<a href=""><b>UVRI Integrated EQA System</b></a>
		</div>
		<!-- .login-logo -->
		<div class="login-box-body">
			<p class="login-box-msg"> Log in to start your Session</p>
			<?php //echo password_hash('testing', PASSWORD_DEFAULT);?>

			<form action="<?php echo base_url('auth/login');?>" method="post">
				<div class="form-group has-feedback">
					<input type="text" name="username" id="username" placeholder="Username" autocomplete="off" class="form-control" required>
					<span class="glyphicon glyphicon-user form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<input type="password" name="password" id="password" placeholder="Password" autocomplete="off" class="form-control" required>
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				<div class="row">
					<div class="col-xs-8">
						<!-- <div class="checkbox icheck">
							<label>
								<input type="checkbox">Remember Me
							</label>
						</div> -->
					</div>
					<!-- /.col -->
					<div class="col-xs-4">
						<button type="submit" class="btn btn-success btn-block btn-flat">Log In</button>
					</div>
				</div>
			</form>
		</div>
		<!-- /.login-box-body -->
	</div>
	<!-- /.login-box -->

<!-- Jquery -->
<script src="<?php echo base_url('assets/plugins/jQuery/jquery-2.2.3.min.js');?>"></script>

<!-- Bootstrap -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>

<!-- iCheck -->
<script type="text/javascript" src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js');?>"></script>

<script>
	$(function(){
		$('input').iCheck({
			checkboxClass: 'icheckbox_square-blue',
			radioClass: 'iradio_square_blue',
			increaseAres: '20%'
		});
	});
</script>
</body>
</html>