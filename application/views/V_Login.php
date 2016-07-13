<!DOCTYPE html>
<html lang="en">
<head>
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
    <title>QuickERP Login</title>
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
    <!--<script src="<?php echo base_url('assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js');?>"></script>
	
	<script src="<?php echo base_url('assets/js/formsInit.js');?>"></script>
	<script src="<?php echo base_url('assets/js/HtmlFunction.js');?>"></script>
	
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
    <div class="row">
        
    <div class="row">
        <div class="col-md-12 center login-header">
            
        </div>
        <!--/span-->
    </div><!--/row-->

    <div class="row">
        <div class="well col-md-5 center login-box">
            <div class="row left" style="padding:1%;margin-left:-5%;">
				<div class="col-md-12">
					<div style="float:left;">
					<img src="<?php echo base_url('assets/plugins/cm/img/logo4.png');?>" style="max-width:500px;" />
					
					</div>
				</div>
			</div>
			<?php
			if($this->session->gagal){
			?>
			<div class="alert alert-danger text-left">
               <?php echo $error;?>
            </div>
			<?php
			}else{
			?>
			<div class="alert alert-info text-left">
               Please enter your username and password to login
            </div>
			<?php
			}
			?>
            <form class="form-horizontal" action="<?php echo site_url('login');?>" method="post">
                <fieldset>
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
                        <input type="text" name="username" id="username" class="form-control toupper" placeholder="Username" autofocus>
                    </div>
                    <div class="clearfix"></div><br>

                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="clearfix"></div>

                    
                    <p class="center col-md-5">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </p>
                </fieldset>
            </form>
        </div>
        <!--/span-->
    </div><!--/row-->
</div><!--/fluid-row-->

</div><!--/.fluid-container-->


</body>
</html>
