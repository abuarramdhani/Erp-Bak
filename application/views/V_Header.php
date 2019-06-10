<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <?php
    	if(isset($Header))
    	{
    		echo '<title>'.$Header.'</title>';
    	}
    	else
    	{
    		echo '<title>Quick ERP</title>';
    	}
    ?>
	<link rel="shortcut icon" href="<?php echo base_url('assets/img/logo.ico');?>" type="image/x-icon">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<meta name="theme-color" content="#3c8dbc">
	
     <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
	
    
	<!-- GLOBAL STYLES -->
    <!-- <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css');?>" /> -->
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/4.0.0/card.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2/select2.min.css');?>" type="text/css" />
    <!-- FontAwesome 3.2.0 -->
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/Font-Awesome/3.2.0/css/font-awesome.css');?>" />
	<!-- FontAwesome 4.3.0 -->
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/Font-Awesome/4.3.0/css/font-awesome.min.css');?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/Font-Awesome/4.3.0/css/font-awesome-animation.css');?>" type="text/css" />
	<!-- Ionicons 2.0.0 -->
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/ionicons/css/ionicons.min.css');?>" type="text/css" />
    <!--END GLOBAL STYLES -->
	
	<!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/theme/css/AdminLTE.min.css');?>" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url('assets/theme/css/skins/_all-skins.min.css');?>" type="text/css" />
  
  	<!-- PAGE LEVEL STYLES FOR DATATABLES-->
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/dataTables/buttons.dataTables.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/dataTables/extensions/FixedColumns/css/dataTables.fixedColumns.min.css');?>" />
	<!-- PAGE LEVEL STYLES FOR FORM -->
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/touchspin/jquery.bootstrap-touchspin.min.css') ?>" />	
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/pace/center-atom-pace.css');?>" rel="stylesheet" />
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/jQueryUI/jquery-ui.css');?>" rel="stylesheet" />
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/uniform/themes/default/css/uniform.default.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/inputlimiter/jquery.inputlimiter.1.0.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/chosen/chosen.min.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/colorpicker/css/colorpicker.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/dropzone/basic.min.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/dropzone/dropzone.min.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/tagsinput/jquery.tagsinput.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/daterangepicker-master/daterangepicker.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/datepicker/css/datepicker.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/timepicker/css/bootstrap-timepicker.min.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/switch/static/stylesheets/bootstrap-switch.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/validator/bootstrapValidator.min.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/validator/bootstrapValidator.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/qtip/jquery.qtip.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/iCheck/skins/all.css');?>">

	<!-- PAGE LEVEL STYLES FOR TEXTAREA -->
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');?>" />

	<!-- Redactor -->
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/redactor/css/redactor.css');?>">

	<!-- Fine Uploader New/Modern CSS file -->
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/fine-uploader/fine-uploader-new.min.css');?>" />

	<!-- END PAGE LEVEL  STYLES -->

	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/multiselect/css/bootstrap-multiselect.css');?>" />

	<!-- GLOBAL SCRIPTS -->
    <script src="<?php echo base_url('assets/plugins/jquery-2.1.4.min.js');?>" type="text/javascript"></script>
    <!-- <script src="<?php echo base_url('assets/plugins/jQuery/jquery-3.2.1.min.js');?>"></script> -->
	<script src="<?php echo base_url('assets/plugins/jQueryUI/jquery-ui.min.js');?>" type="text/javascript"></script>
    <!-- <script src="<?php echo base_url('assets/plugins/bootstrap/3.3.6/js/bootstrap.min.js');?>" type="text/javascript"></script> -->
    <script src="<?php echo base_url('assets/plugins/bootstrap/3.3.7/js/bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js');?>" type="text/javascript"></script>
    <!-- END GLOBAL SCRIPTS -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/mdtimepicker/mdtimepicker.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/css/animate.css');?>" />
	
</head>
     <!-- END HEAD -->
     <!-- BEGIN BODY -->
<body  class="skin-blue-light sidebar-mini fixed"  >
	<div id="loadingAjax"></div>

     <!-- MAIN WRAPPER -->
    <div class="wrapper">
		<input type="hidden" value="<?php echo base_url(); ?>" name="txtBaseUrl" id="txtBaseUrl"/>
		<?php $org_id="";
			if(empty($UserMenu[0]['org_id'])){
				$org_id = $UserResponsibility[0]['org_id'];
			}else{
				$org_id = $UserMenu[0]['org_id'];
			}
		?>
		<header class="main-header" style="box-shadow: 0 4px 9px -3px #367da6;">
		<input type="hidden" value="<?=$org_id ?>" name="txtOrgId" id="txtOrgId"/>
			<!-- Logo -->

			<a href="<?php echo site_url();?>" class="logo">
		      <!-- mini logo for sidebar mini 50x50 pixels -->
		      <span class="logo-mini"><b>Q</b>ERP</span>
		      <!-- logo for regular state and mobile devices -->
		      <span class="logo-lg"><b>Quick</b>ERP</span>
		    </a>
			<!-- Header Navbar: style can be found in header.less -->
			  <!-- Sidebar toggle button-->
			<nav class="navbar navbar-static-top" role="navigation">
				<!-- Sidebar toggle button-->
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>
			  
			  
			  <div class="navbar-custom-menu">
				
				<ul class="nav navbar-nav">


                    <!--ALERTS SECTION -->
                    
                    <!-- END ALERTS SECTION -->

                    <li class="dropdown user user-menu">
			            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			            	<?php
							$file 			= 	"http://quick.com/aplikasi/photo/".$this->session->user.'.'.'jpg';
							$file_headers 	= 	@get_headers($file);
							if(!$file_headers || substr($file_headers[0], strpos($file_headers[0], 'Not Found'), 9) == 'Not Found'){
								$file 			= 	"http://quick.com/aplikasi/photo/".$this->session->user.'.'.'JPG';
								$file_headers 	= 	@get_headers($file);
								if(!$file_headers || substr($file_headers[0], strpos($file_headers[0], 'Not Found'), 9) == 'Not Found'){
									$ekstensi 	= 	'Not Found';
								}else{
									$ekstensi 	= 	'JPG';
								}
							}else{
								$ekstensi 	= 	"jpg";
							}

							if($ekstensi=='jpg' || $ekstensi=='JPG'){
							 $lokasifoto="http://quick.com/aplikasi/photo/".$this->session->user.".".$ekstensi;
							}else{
							 $lokasifoto=base_url('assets/theme/img/user.png');
							}
			              	?>
			              <img src="<?php echo $lokasifoto;?>" class="user-image" alt="User Image">
			              <span class="hidden-xs"><?php echo $this->session->employee;?></span>
			            </a>
			            <ul class="dropdown-menu">
			              <!-- User image -->
			              <li class="user-header">
			                <img src="<?php echo $lokasifoto;?>" class="img-circle" style="height: auto;" alt="User Image">

			                <p>
			                  <?php echo $this->session->user." - ".$this->session->employee;?>
			                </p>
			              </li>
			              <!-- Menu Body -->
			              <!-- Menu Footer-->
			              <li class="user-footer">
			                <div class="pull-left">
			                  <a href="<?php echo base_url('ChangePassword');?>" class="btn btn-default btn-flat">Chg Password</a>
			                </div>
			                <div class="pull-left">
			                  <a href="#" class="btn btn-default btn-flat"  data-toggle="tooltip" data-placement="top" title="Menu Dalam Tahap Pengembangan">Profile</a>
			                </div>
			                <div class="pull-left">
			                  <a href="<?php echo site_url('logout');?>" class="btn btn-default btn-flat">Log out</a>
			                </div>
			              </li>
			            </ul>
			          </li>

                    <!--ADMIN SETTINGS SECTIONS -->
					<?php	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
							if($actual_link!=base_url()){
					?>
					<li class="hidden-xs hidden-sm">
                        <a href="<?php echo site_url($this->session->module_link);?>">
                            <i class="icon-home"></i> <?= $this->session->responsibility ?>	
                        </a>
					</li>
					<li class="hidden-md hidden-lg">
						<a href="<?php echo site_url();?>">
							<i class="icon-home"></i>
						</a>
					</li>
					<?php 	if(isset($UserResponsibility)){
								$responsibility_id = (empty($UserResponsibility[0]['user_group_menu_id']))?0:$UserResponsibility[0]['user_group_menu_id'];
							}else{
								$responsibility_id = $UserMenu[0]['user_group_menu_id'];
							}
					?>
					<li class="hidden-xs hidden-sm">
                        <a href="#" onclick="callModal('<?php echo site_url('ajax/ModalReport/'.$responsibility_id)?>')">
                            <i class="icon-table"></i> Report
                        </a>
					</li>
					<li class="hidden-md hidden-lg">
                        <a href="#" onclick="callModal('<?php echo site_url('ajax/ModalReport/'.$responsibility_id)?>')">
                            <i class="icon-table"></i>
                        </a>
					</li>
						<?php } ?>
					<li class="hidden-xs hidden-sm">
                        <a href="<?php echo site_url('logout');?>">
                            <i class="icon-signout"></i> Logout
                        </a>
					</li>
					<li class="hidden-md hidden-lg">
                        <a href="<?php echo site_url('logout');?>">
                            <i class="icon-signout"></i>
                        </a>
					</li>
                    <!--END ADMIN SETTINGS -->
                </ul>
			  </div>
			</nav>
		 </header>

			<!-- Modal Start 
		<div class="container">
			<div class="col-lg-12 col-sm-12 col-xs-12">
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
						
						</div>
					</div>
				</div>
			</div>
		</div>Modal End -->
	