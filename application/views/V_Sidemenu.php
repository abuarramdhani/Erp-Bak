<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<div class="user-panel" style="height:70px;">
            <div class="pull-left image">
              <img src="<?php echo base_url('assets/theme/img/user.png');?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p><?php echo $this->session->user;?></p>
              <a href="<?php echo base_url('ChangePassword');?>">Change Password</a>
			  <br />
			  <small>Online &nbsp;&nbsp;<i class="fa fa-circle text-success"></i> </small>
			  <!--
			  <i class="fa fa-circle text-success"></i>
			  -->
			</div>
		</div>
		<div>	 
			<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				//echo $actual_link."<br />".base_url('index')."<br />".current_url();
				if($actual_link==base_url()){
			?>
				<ul class="sidebar-menu" >
					<li class="header">RESPONSIBILITY</li>
				</ul>
				<ul class="sidebar-menu">
					<?php
						foreach($UserResponsibility as $UserResponsibility_item){
					?>
					<li class="treeview"><a href="<?= site_url('Responsibility/'.$UserResponsibility_item['user_group_menu_id'])?>"><?= $UserResponsibility_item['user_group_menu_name']?>
					</a></li>
			<?php
						}
			?>
				</ul>
			<?php
				}else{
			?>

				<ul class="sidebar-menu" >
					<li class="header">MENU</li>
				</ul>
				<!-----------------------Menu Utama------------------->
				
				<ul class="sidebar-menu">
					<?php
						foreach($UserMenu as $UserMenu_item){
							if($UserMenu_item['menu_link']==""){
								$link = "#";
							}else{
								$link= site_url($UserMenu_item['menu_link']);
							}
							if($UserMenu_item['menu_title']==$Menu){
								$menu_class = "treeview active";
							}else{
								$menu_class = "treeview";
							}
					?>
						<li class="<?=$menu_class?>">
							<a href="<?= $link?>">
							<?php	
								if($UserMenu_item['menu_link']==""){
									echo $UserMenu_item['menu_title'];
							?>
									<span class="pull-right"></span><i class="fa fa-angle-left pull-right"></i>
							<?php
								}else{
									echo $UserMenu_item['menu_title'];
								}
							?>
							</a>
								<!-----------------------Sub Menu Level 1------------------->
								<?php	
									if($UserMenu_item['menu_link']==""){
								?>
								<ul class="treeview-menu">
									<?php
										foreach($UserSubMenuOne as $UserSubMenuOne_item){
											if($UserMenu_item['menu_id']==$UserSubMenuOne_item['root_id']){
												if($UserSubMenuOne_item['menu_link']==""){
													$link_sub1 = "#";
												}else{
													$link_sub1 = site_url($UserSubMenuOne_item['menu_link']);
												}
												if($UserSubMenuOne_item['menu_title']==$SubMenuOne){
													$sub_menu_class_one = "active";
												}else{
													$sub_menu_class_one = "";
												}
									?>
										<li class="<?= $sub_menu_class_one?>"><a href="<?= $link_sub1?>">
										<?php	
											if($UserSubMenuOne_item['menu_link']==""){
												echo $UserSubMenuOne_item['menu_title'];
										?>
												<span class="pull-right"></span><i class="fa fa-angle-left pull-right"></i>
										<?php
											}else{
												echo $UserSubMenuOne_item['menu_title'];
											}
										?>
										<!-----------------------Sub Menu Level 2------------------->
										<?php	
											if($UserSubMenuOne_item['menu_link']==""){
										?>
										<ul class="treeview-menu">
											<?php
												foreach($UserSubMenuTwo as $UserSubMenuTwo_item){
													if($UserSubMenuOne_item['menu_id']==$UserSubMenuTwo_item['root_id']){
														if($UserSubMenuTwo_item['menu_link']==""){
															$link_sub2 = "#";
														}else{
															$link_sub2 = site_url($UserSubMenuTwo_item['menu_link']);
														}
														if($UserSubMenuTwo_item['menu_title']==$SubMenuTwo){
															$sub_menu_class_two = "active";
														}else{
															$sub_menu_class_two = "";
														}
											?>
												<li class="<?= $sub_menu_class_two?>"><a href="<?= $link_sub2?>"><?=$UserSubMenuTwo_item['menu_title']?>
												</a></li>
											<?php
													}
												}
											?>
								
										</ul>
										<?php
											}
										?>
										<!-----------------------Sub Menu Level 2------------------->
										</a></li>
									<?php
											}
										}
									?>
						
								</ul>
								<?php
									}
								?>
								<!-----------------------Sub Menu Level 1------------------->
						</li>
					<?php
						}
					?>
					
				</ul>
				<!-----------------------Menu Utama------------------->
						<?php } ?>
		</div>
	</section>
	<!-- /.sidebar -->
</aside>