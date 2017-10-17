<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

 <!-- BEGIN HEAD -->
<head>
    <meta charset="UTF-8" />
    <title>Quick ERP</title>
	<link rel="shortcut icon" href="<?php echo base_url('assets/img/logo.ico');?>" type="image/x-icon">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
     <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
	
    
	<!-- GLOBAL STYLES -->
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css');?>" />
    <!-- <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css');?>" /> -->

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
	<!-- Fine Uploader New/Modern CSS file -->
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/fine-uploader/fine-uploader-new.min.css');?>" />

	<!-- END PAGE LEVEL  STYLES -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css');?>" />

	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/multiselect/css/bootstrap-multiselect.css');?>" />

	<!-- GLOBAL SCRIPTS -->
    <script src="<?php echo base_url('assets/plugins/jquery-2.1.4.min.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/plugins/jQueryUI/jquery-ui.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap/3.3.6/js/bootstrap.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js');?>" type="text/javascript"></script>
    <!-- END GLOBAL SCRIPTS -->
	
</head>
     <!-- END HEAD -->
     <!-- BEGIN BODY -->
<body  class="skin-blue-light sidebar-mini"  >
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
		
		
		<header class="main-header">
		<input type="hidden" value="<?=$org_id ?>" name="txtOrgId" id="txtOrgId"/>
			<!-- Logo -->
			<a href="<?php echo site_url();?>" class="logo">
                    <!--<img src="<?php echo base_url('assets/img/header3.png');?>"   class="imgheader" alt="" />-->
					 <span class="logo-lg" ><i class="fa fa-building-o" aria-hidden="true"></i> <b>QUICK ERP</b></span>
			</a>
			<!-- Header Navbar: style can be found in header.less -->
			  <!-- Sidebar toggle button-->
			<nav class="navbar navbar-static-top" role="navigation">
			  
			  
			  <div class="navbar-custom-menu">
				
				<ul class="nav navbar-nav">


                    <!--ALERTS SECTION -->
                    
                    <!-- END ALERTS SECTION -->

                    <!--ADMIN SETTINGS SECTIONS -->
					<?php	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
							if($actual_link!=base_url()){
					?>
					<li>
                        <a href="<?php echo site_url($this->session->module_link);?>">
                            <i class="icon-home"></i> <?= $this->session->responsibility ?>	
                        </a>
					</li>
					<?php 	if(isset($UserResponsibility)){
								$responsibility_id = (empty($UserResponsibility[0]['user_group_menu_id']))?0:$UserResponsibility[0]['user_group_menu_id'];
							}else{
								$responsibility_id = $UserMenu[0]['user_group_menu_id'];
							}
					?>
					<li>
                        <a href="#" onclick="callModal('<?php echo site_url('ajax/ModalReport/'.$responsibility_id)?>')">
                            <i class="icon-table"></i> Report
                        </a>
					</li>
						<?php } ?>
					<li>
                        <a href="<?php echo site_url('logout');?>">
                            <i class="icon-signout"></i> Logout
                        </a>
					</li>
                    <!--END ADMIN SETTINGS -->
                </ul>
			  </div>
			</nav>
		 </header>

			<!-- Modal Start -->
		<div class="col-lg-12">
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
					
					</div>
				</div>
			</div>
		</div>
		<!-- Modal End -->
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	