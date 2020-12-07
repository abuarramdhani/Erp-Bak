<?php
// php logic or variable here

// find user photo 
if ($_SERVER['SERVER_NAME'] == 'erp.quick.com' && @file_get_contents($this->session->path_photo)) {
	$path_photo = $this->session->path_photo;
} else {
	$path_photo = base_url('assets/theme/img/user.png');
}
$extension = pathinfo($path_photo, PATHINFO_EXTENSION);
$raw_photo = file_get_contents($path_photo);
$base64OfPhoto = 'data:image/' . $extension . ';base64,' . base64_encode($raw_photo);

// actual url
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

?>

<aside class="main-sidebar">
	<section class="sidebar">
		<div class="user-panel" style="height:100px;">
			<div class="pull-left image">
				<div style="background: url('<?= $base64OfPhoto ?>') no-repeat; background-size: cover; background-position: center center; width: 50px;height: 65px;" class="img-circle"></div>
			</div>
			<div class="pull-left info">
				<p><?php echo $this->session->user; ?></p>
				<p>
					<h6><strong><?php echo $this->session->employee; ?></strong></h6>
				</p>
				<?php if ($this->session->user != "KHSERP") : ?>
					<a href="<?php echo base_url('ChangePassword'); ?>">Change Password</a>
				<?php endif ?>
				<br />
				<small>Online &nbsp;&nbsp;<i class="fa fa-circle text-success"></i> </small>
			</div>
		</div>
		<div>
			<ul class="sidebar-menu hidden-md hidden-lg">
				<li class="treeview" style="color: grey;">
					<a href="<?php echo site_url($this->session->module_link); ?>"><i class="fa fa-dashboard"> Dashboard</i></a>
				</li>
			</ul>
			<?php
			if ($actual_link == base_url()) {
			?>
				<ul class="sidebar-menu">
					<li class="header">RESPONSIBILITY</li>
				</ul>
				<ul class="sidebar-menu">
					<?php
						foreach($UserResponsibility as $UserResponsibility_item){
					?>
						<li class="treeview" data-nama="<?= $UserResponsibility_item['user_group_menu_name']?>">
							<a href="<?= site_url('Responsibility/'.$UserResponsibility_item['user_group_menu_id'])?>"><i class="fa <?= $UserResponsibility_item['module_image']?>"></i>
							<span style="text-transform: uppercase;"><?= $UserResponsibility_item['user_group_menu_name']?></span>
							</a>
						</li>
					<?php endforeach ?>
				</ul>
			<?php
			} else {
			?>
				<ul class="sidebar-menu">
					<li class="header">MENU</li>
				</ul>
				<!-- -------------------- Menu Level 1 -------------------- -->
				<ul class="sidebar-menu">
					<?php
					foreach ($UserMenu as $UserMenu_item) {
						if ($UserMenu_item['menu_link'] == "") {
							$link = "#";
						} else {
							$link = site_url($UserMenu_item['menu_link']);
						}
						if ($UserMenu_item['menu_title'] == $Menu) {
							$menu_class = "treeview active";
						} else {
							$menu_class = "treeview";
						}
					?>
						<li class="<?= $menu_class ?>">
							<a class="logmenu1" href="<?= $link ?>">
								<?php
								if ($UserMenu_item['menu_link'] == "") {
									echo $UserMenu_item['menu_title'];
								?>
									<span class="pull-right"></span><i class="fa fa-angle-left pull-right"></i>
								<?php
								} else {
									echo $UserMenu_item['menu_title'];
								}
								?>
							</a>
							<!-- -------------------- Menu Level 2 -------------------- -->
							<?php
							if ($UserMenu_item['menu_link'] == "") {
							?>
								<ul class="treeview-menu">
									<?php
									foreach ($UserSubMenuOne as $UserSubMenuOne_item) {
										if ($UserMenu_item['group_menu_list_id'] == $UserSubMenuOne_item['root_id']) {
											if ($UserSubMenuOne_item['menu_link'] == "") {
												$link_sub1 = "#";
											} else {
												$link_sub1 = site_url($UserSubMenuOne_item['menu_link']);
											}
											if ($UserSubMenuOne_item['menu_title'] == $SubMenuOne) {
												$sub_menu_class_one = "active";
											} else {
												$sub_menu_class_one = "";
											}
									?>
											<li class="<?= $sub_menu_class_one ?>"><a class="logmenu2" href="<?= $link_sub1 ?>">
													<?php
													if ($UserSubMenuOne_item['menu_link'] == "") {
														echo $UserSubMenuOne_item['menu_title'];
													?>
														<span class="pull-right"></span><i class="fa fa-angle-left pull-right"></i>
													<?php
													} else {
														echo $UserSubMenuOne_item['menu_title'];
													}
													?>
													<!-- -------------------- Menu Level 3 -------------------- -->
													<?php
													if ($UserSubMenuOne_item['menu_link'] == "") {
													?>
														<ul class="treeview-menu">
															<?php
															foreach ($UserSubMenuTwo as $UserSubMenuTwo_item) {
																if ($UserSubMenuOne_item['group_menu_list_id'] == $UserSubMenuTwo_item['root_id']) {
																	if ($UserSubMenuTwo_item['menu_link'] == "") {
																		$link_sub2 = "#";
																	} else {
																		$link_sub2 = site_url($UserSubMenuTwo_item['menu_link']);
																	}
																	if ($UserSubMenuTwo_item['menu_title'] == $SubMenuTwo) {
																		$sub_menu_class_two = "active";
																	} else {
																		$sub_menu_class_two = "";
																	}
															?>
																	<li class="<?= $sub_menu_class_two ?>"><a class="logmenu3" href="<?= $link_sub2 ?>"><?= $UserSubMenuTwo_item['menu_title'] ?>
																		</a></li>
															<?php
																}
															}
															?>

														</ul>
													<?php
													}
													?>
													<!-- ---------------------- Menu Level 3 ---------------------- -->
												</a></li>
									<?php
										}
									}
									?>

								</ul>
							<?php
							}
							?>
							<!-- -------------------- Menu Level 2 -------------------- -->
						</li>
					<?php
					}
					?>

				</ul>
				<!-- -------------------- Menu Level 1 -------------------- -->
			<?php } ?>
		</div>
	</section>
</aside>
<div class="content-wrapper">
	<div id="data_content">

		<div class="col-lg-12 col-sm-12 col-xs-12">
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">

					</div>
				</div>
			</div>
		</div>