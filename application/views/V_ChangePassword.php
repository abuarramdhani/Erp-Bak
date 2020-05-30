<!DOCTYPE html>
<html lang="en">
<head>

<style>
.swal2-modal.swal2-popup{
	width: 30%;
	height: 60%;
	font-size: 15px;
}
</style>
    <!--
        ===
        This comment should NOT be removed.

        Charisma v2.0.0

        Copyright 2012-2014 Muhammad Usman
        Licensed under the Apache License v2.0
        http://www.apache.org/licenses/LICENSE-2.0

        http://usman.it
        http://twitter.com/halalit_usman
        ===
    -->
    <meta charset="utf-8">
    <title>Change Password - Quick ERP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">
    <meta name="author" content="Muhammad Usman">
	<link rel="shortcut icon" href="<?php echo base_url('assets/plugins/cm/img/logo.ico');?>">
    <!-- The styles -->
    <link id="bs-css" href="<?php echo base_url('assets/plugins/cm/css/bootstrap-cerulean.min.css');?>" rel="stylesheet">

    <link href="<?php echo base_url('assets/plugins/cm/css/charisma-app.css');?>" rel="stylesheet">
    
    <!-- GLOBAL SCRIPTS -->
    <script src="<?php echo base_url('assets/plugins/jquery-2.0.3.min.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap/3.0.0/js/bootstrap.min.js');?>"></script>
	<script src="<?php echo base_url('assets/js/HtmlFunction.js');?>"></script>
	<script src="<?= base_url('assets/plugins/sweetalert2.all.js');?>"></script>
    <!--<script src="<?php echo base_url('assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js');?>"></script>
	
	<script src="<?php echo base_url('assets/js/formsInit.js');?>"></script>
	
    <!-- END GLOBAL SCRIPTS -->
    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->
    
	<script type="text/javascript">
	$(document).ready(function(){
	 $('#pengguna').focus(); 
	});
	</script>
</head>

<body>
<div class="ch-container">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
						<div class="box-header with-border">&nbspChange Password</div>
						<div class="box-body">
							<?php 
						foreach ($UserData as $UserData_item): 
						?>
							<form method="post" id="form-buying-type" action="<?php echo site_url('ChangePassword')?>" class="form-horizontal">
							<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
							
							<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" id="hdnDate" />
							<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" id="hdnUser" />
							<div class="panel-heading text-left">
							</div>
						<?php if($error){ ?>
							<script src="<?= base_url('assets/plugins/sweetalert2.all.js');?>"></script>
							<script>
								swal.fire({
									title: 'Peringatan',
									text: '<?= $error ?>',
									type: 'warning',
									customClass: 'swalWidth',
									allowOutsideClick: false
								})
							</script>
						<?php }else { echo ""; } ?>
							<div class="panel-body">
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">NIK</label>
											<div class="col-lg-4">
												<input type="text" placeholder="Username" name="txtUsername" value="<?php echo $UserData_item['user_name'] ?>" class="form-control toupper" readonly/>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Password</label>
											<div class="col-lg-4">
												<input type="password" placeholder="Password Now" name="txtPasswordNow" id="txtPasswordNow" class="form-control" value="<?= $password ?>" readonly/>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">New Password</label>
											<div class="col-lg-4">
												<input type="password" placeholder="New Password" name="txtPassword" value="" id="txtPassword" class="form-control" />
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Re-Enter Password</label>
											<div id="divPassCheck" class="col-lg-4">
												<input type="password" onkeyup="checkPass();" placeholder="Repeat Password" name="txtPasswordCheck" value="" id="txtPasswordCheck" class="form-control" />
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Employee</label>
											<div class="col-lg-4">
												<select class="form-control employee-data" name="slcEmployee" data-placeholder="All Employee" style="width:100%;" disabled>
													<option value="<?php echo $UserData_item['employee_id'] ?>"><?php echo $UserData_item['employee_name'] ?></option>
												</select>
											</div>
									</div>
							</div>
							<div class="panel-footer">
								<div class="row text-right">
									<a href="<?= base_url('')?>" class="btn btn-primary btn-lg btn-rect">Back</a>
									&nbsp;&nbsp;
									<button type="submit" id="btnUser" class="btn btn-primary btn-lg btn-rect">Save Changes</button>
								</div>
							</div>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
		<?php endforeach ?>
	</div>
</div>
</body>
</html>