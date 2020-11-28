<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<!-- [if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif] -->
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta name="author" content="" />
	<meta name="description" content="" />
	<meta name="theme-color" content="#3c8dbc">

	<?php
	if (isset($Header)) {
		$header = $Header;
	} else {
		if ($this->session->responsibility != '') {
			$header = ucwords(strtolower($this->session->responsibility)) . " - Quick ERP";
		} else {
			$header = 'Quick ERP';
		}
	}
	?>

	<title><?= $header ?></title>
	<link type="image/x-icon" rel="shortcut icon" href="<?= base_url('assets/img/logo.ico') ?>">
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap/4.0.0/card.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/select2/select2.min.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/Font-Awesome/3.2.0/css/font-awesome.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/Font-Awesome/4.3.0/css/font-awesome.min.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/Font-Awesome/4.3.0/css/font-awesome-animation.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/ionicons/css/ionicons.min.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/theme/css/AdminLTE.min.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/theme/css/skins/_all-skins.min.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/datatables-latest/datatables.min.css') ?>" />
	<!-- <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/dataTables/dataTables.bootstrap.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/dataTables/buttons.dataTables.min.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/dataTables/extensions/FixedColumns/css/dataTables.fixedColumns.min.css') ?>" /> -->
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/touchspin/jquery.bootstrap-touchspin.min.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/pace/center-atom-pace.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/jQueryUI/jquery-ui.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/uniform/themes/default/css/uniform.default.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/inputlimiter/jquery.inputlimiter.1.0.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/chosen/chosen.min.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/colorpicker/css/colorpicker.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/intro.js-2.9.3/introjs.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/dropzone/basic.min.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/dropzone/dropzone.min.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/tagsinput/jquery.tagsinput.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/daterangepicker-master/daterangepicker.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/datepicker/css/datepicker.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/datetimepicker/build/jquery.datetimepicker.min.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/timepicker/css/bootstrap-timepicker.min.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/switch/static/stylesheets/bootstrap-switch.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/validator/bootstrapValidator.min.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/validator/bootstrapValidator.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/qtip/jquery.qtip.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/iCheck/skins/all.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/redactor/css/redactor.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/fine-uploader/fine-uploader-new.min.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/multiselect/css/bootstrap-multiselect.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/mdtimepicker/mdtimepicker.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/animate.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/fullcalendar-1.6.2/fullcalendar/fullcalendar.css') ?>" />
	<link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/fullcalendar-1.6.2/fullcalendar/fullcalendar.print.css') ?>" />
	<script src="<?= base_url('assets/plugins/jquery-2.1.4.min.js') ?>" type="text/javascript"></script>
	<script src="<?= base_url('assets/plugins/jQueryUI/jquery-ui.min.js') ?>" type="text/javascript"></script>
	<script src="<?= base_url('assets/plugins/bootstrap/3.3.7/js/bootstrap.min.js') ?>"></script>
	<script src="<?= base_url('assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js') ?>" type="text/javascript"></script>

	<!-- Notification Services -->
	<script defer src="<?= base_url('assets/js/services/notifications.js') ?>"></script>
	<style>
		/* Custom css for notification */
		/* .notification-toggler {} */

		@keyframes notification-blink {
			0% {
				background-color: red;
			}

			50% {
				background-color: tomato;
			}

			100% {
				background-color: red;
			}
		}

		.notification-item {
			border-bottom: 1px solid #d1e3ff;
			padding-top: 0.5em;
			padding-bottom: 0.5em;
			transition: ease-in-out 0.3s;
		}

		.notification-item.unread {
			background-color: #e5efff;
		}

		.notification-item:hover {
			background-color: #d1e3ff;
		}

		.stretched-link::after {
			position: absolute;
			top: 0;
			right: 0;
			bottom: 0;
			left: 0;
			z-index: 1;
			pointer-events: auto;
			content: "";
			background-color: rgba(0, 0, 0, 0);
		}

		.notification-toggler.blink {
			animation: notification-blink 2s infinite;
		}
	</style>
</head>

<body class="<?php echo $this->session->tema; ?>">
	<div id="loadingAjax"></div>

	<div class="wrapper">
		<input type="hidden" value="<?= base_url(); ?>" name="txtBaseUrl" id="txtBaseUrl" />
		<?php
		if (empty($UserMenu[0]['org_id'])) {
			$org_id = $UserResponsibility[0]['org_id'];
		} else {
			$org_id = $UserMenu[0]['org_id'];
		}
		?>
		<header class="main-header" style="box-shadow: 0 4px 9px -3px #367da6;">
			<input type="hidden" value="<?= $org_id ?>" name="txtOrgId" id="txtOrgId" />
			<a href="<?= site_url() ?>" class="logo">
				<span class="logo-mini"><b>Q</b>ERP</span>
				<span class="logo-lg"><b>Quick</b>ERP</span>
			</a>
			<nav class="navbar navbar-static-top" role="navigation">
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown notification">
							<a href="#" title="Notifikasi" id="notification-toggler" class="dropdown-toggle notification-toggler" data-toggle="dropdown" aria-expanded="fals">
								<i class="fa fa-bell"></i>
								<span id="notification-counter"></span>
							</a>
							<div class="dropdown-menu shadow" style="width: 500px; padding: 0;">
								<div class="row">
									<div class="col-md-12">
										<div class="card" style="border: none;">
											<div class="card-header <?php echo $this->session->tema; ?>" style="padding: 1em 0.7em; background: #3c8dbc; color: white;">
												<h4 class="bold" style="margin-top: 10px; font-weight: bold;">Notifikasi</h4>
											</div>
											<div class="card-body" style="padding: 0; max-height: 500px;">
												<div class="notification-wrapper slimscroll">
													<ul class="nav" id="notification-container" style="padding-left: 0;">
														<!-- Javascript -->
													</ul>
												</div>
											</div>
											<div class="card-footer">
												<div class="col-lg-12 text-center" style="padding: 0.5em;">
													<!-- TODO: make page of all notification -->
													<a href="<?= base_url('/notifications') ?>" style="display: block; font-weight: bold;">Lihat semua notifikasi</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</li>
						<li class="dropdown user user-menu">
							<a href="#" title="Akun" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<?php
								if ($_SERVER['SERVER_NAME'] == 'erp.quick.com' && @file_get_contents($this->session->path_photo)) {
									$lokasifoto = $this->session->path_photo;
								} else {
									$lokasifoto = base_url('assets/theme/img/user.png');
								}
								$path = $lokasifoto;
								$type = pathinfo($path, PATHINFO_EXTENSION);
								$dat = file_get_contents($path);
								$base64 = 'data:image/' . $type . ';base64,' . base64_encode($dat);
								?>
								<div style="background: url('<?= $base64 ?>') no-repeat ; background-size: cover; background-position: center center; " class="user-image"></div>
								<span class="hidden-xs"><?= $this->session->employee ?></span>
							</a>
							<ul class="dropdown-menu">
								<li class="user-header text-center">
									<div style="width: 90px;"></div>
									<div style="background: url('<?= $base64 ?>') no-repeat right center; background-size: contain; background-position: 50%; min-height: 120px;"></div>
									<p><?= $this->session->user . " - " . $this->session->employee ?></p>
								</li>
								<li class="user-footer">
									<div class="pull-left">
										<a href="<?= base_url('ChangePassword') ?>" class="btn btn-default btn-flat">Chg Password</a>
									</div>
									<div class="pull-left">
										<a href="#" class="btn btn-default btn-flat" data-toggle="tooltip" data-placement="top" title="Menu Dalam Tahap Pengembangan">Profile</a>
									</div>
									<div class="pull-left">
										<a href="<?= site_url('logout') ?>" class="btn btn-default btn-flat">Log out</a>
									</div>
								</li>
							</ul>
						</li>
						<?php
						$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
						if (isset($UserResponsibility)) {
							$responsibility_id = (empty($UserResponsibility[0]['user_group_menu_id'])) ? 0 : $UserResponsibility[0]['user_group_menu_id'];
						} else {
							$responsibility_id = $UserMenu[0]['user_group_menu_id'];
						}

						$responsibility_name = @$UserMenu[0]['user_group_menu_name'] ?: '';

						if ($actual_link != base_url()) {
						?>
							<li class="hidden-xs hidden-sm">
								<a href="<?= base_url("/Responsbility/" . $responsibility_id) ?>">
									<i class="icon-home"></i>
									<?= $responsibility_name ?>
								</a>
							</li>
							<li class="hidden-md hidden-lg">
								<a href="<?= site_url() ?>">
									<i class="icon-home"></i>
								</a>
							</li>
							<li class="hidden-xs hidden-sm">
								<a href="#" onclick="callModal('<?= site_url('ajax/ModalReport/' . $responsibility_id) ?>')">
									<i class="icon-table"></i>
									Report
								</a>
							</li>
							<li class="hidden-md hidden-lg">
								<a href="#" onclick="callModal('<?= site_url('ajax/ModalReport/' . $responsibility_id) ?>')">
									<i class="icon-table"></i>
								</a>
							</li>
						<?php } ?>
						<li class="hidden-xs hidden-sm">
							<a href="<?= site_url('logout') ?>">
								<i class="icon-signout"></i> Logout
							</a>
						</li>
						<li class="hidden-md hidden-lg">
							<a href="<?= site_url('logout') ?>">
								<i class="icon-signout"></i>
							</a>
						</li>
					</ul>
				</div>
			</nav>

			<!-- EXPERIMENTAL TOAST -->
			<!-- <div style="position: absolute; top: 4em; right: 1em; z-index: 999;">
				<?php //for ($i = 0; $i < 5; $i++) : 
				?>
					<div style="width: 400px; color: white; background: rgb(2,0,36); background: linear-gradient(81deg, rgba(2,0,36,1) 0%, rgba(6,93,158,1) 0%, rgba(45,122,198,1) 100%); padding: 1em; box-shadow: 2px 1px 6px 0px black; border-radius: 5px; margin-bottom: 1em;">
						<p style="font-weight: bold; font-size: 18px;">Pemutihan Data Pekerja</p>
						<h5 style="font-weight: 500; font-size: 16px;">T0103 telah mengajukan permintaan perubahan data</h5>
						<span style="font-size: 1.2rem;">Baru saja</span>
					</div>
				<?php //endfor; 
				?>
			</div> -->
			<!-- END EXPERIMENTAL TOAST -->
		</header>