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
			if ($responsibility_id == 2669 || $responsibility_id == 2592 || $responsibility_id == 2593) {
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
								$link = 'ALK/Pusat/ListLembur';
							}elseif ($responsibility_id == 2593) {
								$link = 'ALA/Pusat/ListLembur';
							}elseif($responsibility_id == 2669){
								$link = 'SPL/Pusat/ListLembur';
							}

							 ?>
							<div class="col-lg-4 col-sm-6 col-xs-12">
								<div class="col-lg-8 col-lg-offset-2">
									<a href="<?php echo site_url($link).'?stat=Baru' ?>" class="box box-warning box-solid box-spl">
										<div class="box-header with-border text-center">
											SPL BARU
										</div>
										<div class="box-body text-center" style="font-size: 25pt">
											<?php 
												$nilai = '0';
												foreach ($rekap_spl as $rkp) {
													if ($rkp['status'] == '0') {
														$nilai = $rkp['jumlah'];
													}
												} 
												echo $nilai;
											?>
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
											<?php 
												$nilai = '0';
												foreach ($rekap_spl as $rkp) {
													if ($rkp['status'] == '3') {
														$nilai = $rkp['jumlah'];
													}
												} 
												echo $nilai;
											?>
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
											<?php 
												$nilai = 0;
												foreach ($rekap_spl as $rkp) {
													$nilai += $rkp['jumlah'];
												} 
												echo $nilai;
											?>
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
				            } ?>
							
						
									    
                    
				</div>
			</div>
				<?php 
			}
			?>
			
			
		</div>
</section>