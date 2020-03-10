<section id="content">
	<div class="inner">
	<style type="text/css">
		.box-spl{
			display: block;
		}
		.box-spl:hover {
			transform: scale(1.5);
			--webkit--transform: scale(1.5);
		}
		.modal-content {
			border-radius: 6px !important;
		}
	</style>
		
			<!-- Content Header (Page header) -->
			<section class="content-header">
					<div class="row">
						<div class="col-lg-6">
							<br />
							<h1>Surat Perintah Lembur </h1>
						</div>
					</div>
			</section>
			<br><br>
			<?php 
			if ($responsibility_id == 2587 || $responsibility_id == 2592 || $responsibility_id == 2593) {
				?>
			<div class="row">
				<div class="col-lg-10 col-lg-offset-1">
					<div class="box box-solid box-success">
						<div class="box-header text-center">
							<?php 
							$bulan = array(
								'01' => 'JANUARI',
								'02' => 'FEBRUARI',
								'03' => 'MARET',
								'04' => 'APRIL',
								'05' => 'MEI',
								'06' => 'JUNI',
								'07' => 'JULI',
								'08' => 'AGUSTUS',
								'09' => 'SEPTEMBER',
								'10' => 'OKTOBER',
								'11' => 'NOVEMBER',
								'12' => 'DESEMBER'
							) ;
							?>
							SPL BULAN <?php echo $bulan[date('m')].' '.date('Y'); ?>
						</div>
						<div class="box-body">
							<?php 
							$link = '';
							if ($responsibility_id == 2592) {
								$link = 'ALK/ListLembur';
							}elseif ($responsibility_id == 2593) {
								$link = 'ALA/ListLembur';
							}elseif($responsibility_id == 2587){
								$link = 'SPL/ListLembur';
							}

							 ?>
							<div class="col-lg-4 col-sm-6 col-xs-12">
								<div class="col-lg-8 col-lg-offset-2">
									<a href="<?php echo site_url($link).'?stat=Baru' ?>" class="box box-warning box-solid box-spl">
										<div class="box-header with-border text-center">
											SPL BARU
										</div>
										<div class="box-body text-center" style="font-size: 25pt">
											<?= $baru ?>
										</div>
									</a>
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="col-lg-8 col-lg-offset-2">
									<a href="<?php echo site_url($link).'?stat=Tolak' ?>" class="box box-danger box-solid box-spl">
										<div class="box-header with-border text-center">
											SPL DITOLAK
										</div>
										<div class="box-body text-center" style="font-size: 25pt">
											<?= $reject ?>
										</div>
									</a>
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="col-lg-8 col-lg-offset-2">
									<a href="<?php echo site_url($link).'?stat=Total' ?>" class="box box-primary box-solid box-spl">
										<div class="box-header with-border text-center">
											SPL TOTAL
										</div>
										<div class="box-body text-center" style="font-size: 25pt">
											<?= $total ?>
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 text-center">
					<?php 
					if ($responsibility_id == 2592) { 
						if ($this->session->spl_validasi_kasie == FALSE) { ?>
						<center>
							<div class="modal show" tabindex="-1" role="dialog">
							  <div class="modal-dialog modal-dialog-centered" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <h3 class="modal-title">Anda Login Sebagai :</h3>
							      </div>
							      <div class="modal-body">
							        <h1><?php echo $this->session->user ?> - <?php echo $this->session->employee ?></h1>
							      </div>
							      <div class="modal-footer">
							      	<h5 class="modal-title" style="color: red">Pastikan Alat Fingerprint Terhubung ke Komputer</h5><br>
							      	<?php 
							      	$user_agent 	= $_SERVER['HTTP_USER_AGENT'];
							      	$os_platform    =   "Unknown OS Platform";

									$os_array       =   array(
										'/windows nt 10/i'     	=>  'Windows 10',
										'/windows nt 6.3/i'     =>  'Windows 8.1',
										'/windows nt 6.2/i'     =>  'Windows 8',
										'/windows nt 6.1/i'     =>  'Windows 7',
										'/windows nt 6.0/i'     =>  'Windows Vista',
										'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
										'/windows nt 5.1/i'     =>  'Windows XP',
										'/windows xp/i'         =>  'Windows XP',
										'/windows nt 5.0/i'     =>  'Windows 2000',
										'/windows me/i'         =>  'Windows ME',
										'/win98/i'              =>  'Windows 98',
										'/win95/i'              =>  'Windows 95',
										'/win16/i'              =>  'Windows 3.11',
										'/macintosh|mac os x/i' =>  'Mac OS X',
										'/mac_powerpc/i'        =>  'Mac OS 9',
										'/linux/i'              =>  'Linux',
										'/ubuntu/i'             =>  'Ubuntu',
										'/iphone/i'             =>  'iPhone',
										'/ipod/i'               =>  'iPod',
										'/ipad/i'               =>  'iPad',
										'/android/i'            =>  'Android',
										'/blackberry/i'         =>  'BlackBerry',
										'/webos/i'              =>  'Mobile'
									);
									
									foreach ($os_array as $regex => $value) {
										if (preg_match($regex, $user_agent)) {
											$os_platform    =   $value;
										}
									}   
									if (preg_match('/windows/i', $os_platform)) { ?>
										<div class="row">
											<div class="col-lg-12">
										<?php foreach ($jari as $key) { ?>
											<div class="col-lg-4" style="padding-bottom: 30px">
												<a href="finspot:FingerspotVer;<?php echo base64_encode(base_url().'ALK/Approve/fp_proces_val?userid='.$this->session->userid.'&res_id='.$this->session->responsibility_id.'&finger_id='.$key['kd_finger']); ?>" id="spl_proses_approve" class="btn btn-primary"><i class="fa fa-check-square"></i> <?php echo $key['jari'] ?></a>
											</div>
							      	<?php } ?>
							      			</div>
										</div>
									<?php }else{
										echo "SPL Kasie hanya dapat digunakan di Windows";
									}
									?>							        
							      </div>
							    </div>
							  </div>
							</div>
						</center>
					<?php }
						}elseif ($responsibility_id == 2593) {
							if ($this->session->spl_validasi_asska == FALSE) { ?>
						<center>
						<div class="modal show" tabindex="-1" role="dialog">
							  <div class="modal-dialog modal-dialog-centered" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <h3 class="modal-title">Anda Login Sebagai :</h3>
							      </div>
							      <div class="modal-body">
							        <h1><?php echo $this->session->user ?> - <?php echo $this->session->employee ?></h1>
							      </div>
							      <div class="modal-footer">
							      	<h5 class="modal-title" style="color: red">Pastikan Alat Fingerprint Terhubung ke Komputer</h5><br>
							      	<?php 
							      	$user_agent 	= $_SERVER['HTTP_USER_AGENT'];
							      	$os_platform    =   "Unknown OS Platform";

									$os_array       =   array(
										'/windows nt 10/i'     	=>  'Windows 10',
										'/windows nt 6.3/i'     =>  'Windows 8.1',
										'/windows nt 6.2/i'     =>  'Windows 8',
										'/windows nt 6.1/i'     =>  'Windows 7',
										'/windows nt 6.0/i'     =>  'Windows Vista',
										'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
										'/windows nt 5.1/i'     =>  'Windows XP',
										'/windows xp/i'         =>  'Windows XP',
										'/windows nt 5.0/i'     =>  'Windows 2000',
										'/windows me/i'         =>  'Windows ME',
										'/win98/i'              =>  'Windows 98',
										'/win95/i'              =>  'Windows 95',
										'/win16/i'              =>  'Windows 3.11',
										'/macintosh|mac os x/i' =>  'Mac OS X',
										'/mac_powerpc/i'        =>  'Mac OS 9',
										'/linux/i'              =>  'Linux',
										'/ubuntu/i'             =>  'Ubuntu',
										'/iphone/i'             =>  'iPhone',
										'/ipod/i'               =>  'iPod',
										'/ipad/i'               =>  'iPad',
										'/android/i'            =>  'Android',
										'/blackberry/i'         =>  'BlackBerry',
										'/webos/i'              =>  'Mobile'
									);

									foreach ($os_array as $regex => $value) {
										if (preg_match($regex, $user_agent)) {
											$os_platform    =   $value;
										}
									}   
									if (preg_match('/windows/i', $os_platform)) { ?>
										<div class="row">
											<div class="col-lg-12">
										<?php foreach ($jari as $key) { ?>
											<div class="col-lg-4" style="padding-bottom: 30px">
							      				<a href="finspot:FingerspotVer;<?php echo base64_encode(base_url().'ALK/Approve/fp_proces_val?userid='.$this->session->userid.'&res_id='.$this->session->responsibility_id.'&finger_id='.$key['kd_finger']); ?>" id="spl_proses_approve" class="btn btn-primary"><i class="fa fa-check-square"></i> <?php echo $key['jari'] ?></a>
							      			</div>
							      	<?php } ?>
							      			</div>
										</div>
									<?php }else{
										echo "SPL Asska hanya dapat digunakan di Windows";
									}
							      	 ?>							        
							      </div>
							    </div>
							  </div>
							</div>
						</center>
					<?php }
						}else{
							if ($this->session->spl_validasi_operator == FALSE) { ?>
						<center>
							<div class="modal show" tabindex="-1" role="dialog">
							  <div class="modal-dialog modal-dialog-centered" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <h3 class="modal-title">Anda Login Sebagai :</h3>
							      </div>
							      <div class="modal-body">
							        <h1><?php echo $this->session->user ?> - <?php echo $this->session->employee ?></h1>
							      </div>
							      <div class="modal-footer">
							      	<h5 class="modal-title" style="color: red">Pastikan Alat Fingerprint Terhubung ke Komputer</h5><br>
							      	<?php 
							      	$user_agent 	= $_SERVER['HTTP_USER_AGENT'];
							      	$os_platform    =   "Unknown OS Platform";

									$os_array       =   array(
										'/windows nt 10/i'     	=>  'Windows 10',
										'/windows nt 6.3/i'     =>  'Windows 8.1',
										'/windows nt 6.2/i'     =>  'Windows 8',
										'/windows nt 6.1/i'     =>  'Windows 7',
										'/windows nt 6.0/i'     =>  'Windows Vista',
										'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
										'/windows nt 5.1/i'     =>  'Windows XP',
										'/windows xp/i'         =>  'Windows XP',
										'/windows nt 5.0/i'     =>  'Windows 2000',
										'/windows me/i'         =>  'Windows ME',
										'/win98/i'              =>  'Windows 98',
										'/win95/i'              =>  'Windows 95',
										'/win16/i'              =>  'Windows 3.11',
										'/macintosh|mac os x/i' =>  'Mac OS X',
										'/mac_powerpc/i'        =>  'Mac OS 9',
										'/linux/i'              =>  'Linux',
										'/ubuntu/i'             =>  'Ubuntu',
										'/iphone/i'             =>  'iPhone',
										'/ipod/i'               =>  'iPod',
										'/ipad/i'               =>  'iPad',
										'/android/i'            =>  'Android',
										'/blackberry/i'         =>  'BlackBerry',
										'/webos/i'              =>  'Mobile'
									);

									foreach ($os_array as $regex => $value) {
										if (preg_match($regex, $user_agent)) {
											$os_platform    =   $value;
										}
									}   
									if (preg_match('/windows/i', $os_platform)) { ?>
										<div class="row">
											<div class="col-lg-12">
										<?php foreach ($jari as $key) { ?>
											<div class="col-lg-4" style="padding-bottom: 30px">
							      				<a href="finspot:FingerspotVer;<?php echo base64_encode(base_url().'ALK/Approve/fp_proces_val?userid='.$this->session->userid.'&res_id='.$this->session->responsibility_id.'&finger_id='.$key['kd_finger']); ?>" id="spl_proses_approve" class="btn btn-primary"><i class="fa fa-check-square"></i> <?php echo $key['jari'] ?></a>
							      			</div>
							      	<?php } ?>
							      			</div>
										</div>
									<?php }else{
										echo "SPL Operator hanya dapat digunakan di Windows";
									}
							      	 ?>							        
							      </div>
							    </div>
							  </div>
							</div>
						</center>
					<?php }
						} ?>
							
						<?php 
							if ($responsibility_id == 2592) { 
								if ($this->session->spl_validasi_kasie == TRUE) {
				                    foreach($UserMenu as $UserMenu_item){
				                ?>
				                    <div class="col-md-4 col-sm-6 col-xs-12">
				                      <div class="info-box">
				                        <span class="info-box-icon bg-aqua"><i class="fa fa-list"></i></span>

				                        <div class="info-box-content">
				                              <span class="info-box-text"><a href="<?= site_url($UserMenu_item['menu_link'])?>"><?= $UserMenu_item['menu_title']?></a></span>
				                         </div>
				                        <!-- /.info-box-content -->
				                      </div>
				                      <!-- /.info-box -->
				                    </div>
				                <?php
				                    }
				                }
							}elseif ($responsibility_id == 2593) {
								if ($this->session->spl_validasi_asska == TRUE) { 
				                    foreach($UserMenu as $UserMenu_item){
				                ?>
				                    <div class="col-md-4 col-sm-6 col-xs-12">
				                      <div class="info-box">
				                        <span class="info-box-icon bg-aqua"><i class="fa fa-list"></i></span>

				                        <div class="info-box-content">
				                              <span class="info-box-text"><a href="<?= site_url($UserMenu_item['menu_link'])?>"><?= $UserMenu_item['menu_title']?></a></span>
				                         </div>
				                        <!-- /.info-box-content -->
				                      </div>
				                      <!-- /.info-box -->
				                    </div>
				                <?php
				                    }
				                }
							}else{
								foreach($UserMenu as $UserMenu_item){
								?>
				                    <div class="col-md-4 col-sm-6 col-xs-12">
				                      <div class="info-box">
				                        <span class="info-box-icon bg-aqua">
				                        	<i class="fa fa-list"></i>
				                        </span>
				                        <div class="info-box-content">
				                              <span class="info-box-text"><a href="<?= site_url($UserMenu_item['menu_link'])?>"><?= $UserMenu_item['menu_title']?></a></span>
				                         </div>
				                        <!-- /.info-box-content -->
				                      </div>
				                      <!-- /.info-box -->
				                    </div>
				                <?php
				            	}
							} ?>
							
						<?php if ($this->session->spl_validasi_log){
							?>
							<center>
								<div class="modal show" tabindex="-1" role="dialog">
								  <div class="modal-dialog modal-dialog-centered" role="document">
								    <div class="modal-content">
								      <div class="modal-header">
								      </div>
								      <div class="modal-body">
								        <p><?php echo $this->session->spl_validasi_log ?></p>
								      </div>
								      <div class="modal-footer">
								        <script type="text/javascript">
								        	window.setTimeout(function(e){
								        		window.location.reload();
								        	},5000);
								        	
								        </script>
								      </div>
								    </div>
								  </div>
								</div>
							</center>
						<?php $this->session->unset_userdata('spl_validasi_log');
							} ?>
									    
                    
				</div>
			</div>
				<?php 
			}
			?>
			
			
		</div>
		
	
	<script>
		// need some idea
		window.onfocus = function() {
		  console.log('Got focus');
		  //window.location.reload();
		}


		var timeoutInMiliseconds = 120000;
		var timeoutId; 
		  
		function startTimer() { 
		    // window.setTimeout returns an Id that can be used to start and stop a timer
		    timeoutId = window.setTimeout(doInactive, timeoutInMiliseconds)
		}
		  
		function doInactive() {
		    // does whatever you need it to actually do - probably signs them out or stops polling the server for info
		    window.location.reload();
		}

		function resetTimer() { 
		    window.clearTimeout(timeoutId)
		    startTimer();
		}
		 
		function setupTimers () {
		    document.addEventListener("mousemove", resetTimer(), false);
		    document.addEventListener("mousedown", resetTimer(), false);
		    document.addEventListener("keypress", resetTimer(), false);
		    document.addEventListener("touchmove", resetTimer(), false);
		     
		    startTimer();
		}
		 
		document.addEventListener("DOMContentLoaded",function(e){
			setupTimers();
		});

	</script>
	
</section>
