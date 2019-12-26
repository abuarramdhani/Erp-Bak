        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           RESPONSIBILITY
          </h1>
         
        </section>

        <!-- Main content -->
        <section class="content">

        <div class="row">
              <?php
              $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
              if($actual_link==base_url()){
              ?>

                <?php
                    foreach($UserResponsibility as $UserResponsibility_item){
                  ?>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa <?= $UserResponsibility_item['module_image']?>"></i></span>

                        <div class="info-box-content">
                              <span class="info-box-text"><a href="<?= site_url('Responsibility/'.$UserResponsibility_item['user_group_menu_id'])?>"><?= $UserResponsibility_item['user_group_menu_name']?></a></span>
                         </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>


                  <?php
                    }
                ?>
              <?php
              }else{
              ?>
                <ul class="sidebar-menu" >
                  <li class="header">MENU</li>
                </ul>
                <!-- -------------------- Menu Level 1 -------------------- -->
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
                    </li>
                  <?php
                    }
                  ?>

                </ul>
                <!-- -------------------- Menu Level 1 -------------------- -->
                    <?php } ?>
          </div>
   </section><!-- /.content -->

   <!-- notificatin when password is default 123456 -->
<?php if($this->session->pass_is_default): ?>
   <script src="<?= base_url('assets/plugins/sweetalert2.all.min.js');?>"></script>
   <script src="<?= base_url('assets/plugins/lottie/lottie-player.js');?>"></script>
   <script type="text/javascript">
	const host_address = '<?= base_url() ?>'
		swal.fire({
			title: 'Password kamu masih default ?',
			html: `<lottie-player src="${host_address}assets/plugins/lottie/lottie_unlocked.json"  background="transparent" speed="1"  style="width: 300px; height: 300px;" loop autoplay ></lottie-player>
			<br>
			<div>
				<span>Segera ubah password untuk mengamankan akun</span>
			</div>
			<br>
			<div>
				<a class="btn btn-warning" href="${host_address}ChangePassword">ubah password</a>
			</div>`,
			backdrop: `rgba(0,0,0,0.8)`,
			showCancelButton: false,
  			showConfirmButton: false
		})
   </script>
<?php endif ?>
