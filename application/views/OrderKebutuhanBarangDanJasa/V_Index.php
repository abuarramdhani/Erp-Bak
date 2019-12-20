<section id="content">
	<div class="inner" style="background: url('<?php echo base_url('assets/img/3.jpg');?>');background-size: cover;">

		<!-- Content Header (Page header) -->
		<section class="content-header">

			<div class="row">
				<div class="col-lg-6">
					<br />
					<h1>Order Kebutuhan Barang dan Jasa</h1>
				</div>
			</div>
			
			<div class="row">

				<div class="col-md-4 col-sm-6 col-xs-12">
					<?php 
						if ($this->session->responsibility_id == 2665) {
							$classNormal = 'btnNormalOrderOKBPengelola';
						}else {
							$classNormal = 'btnNormalOrderOKB';
						}

						$normalBelum = count($normal);
						$totalNormal = count($normalOrder);
						$normalSelesai = $totalNormal - $normalBelum;
						if ($normalSelesai == 0 && $totalNormal == 0) {
							$persenNormal = '100';
						}else {
							$persenNormal = $normalSelesai / $totalNormal * 100;
						}
					?>
					<div class="info-box bg-green <?= $classNormal;?>">
						<span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>

						<div class="info-box-content">
							<span class="info-box-number"><?php echo count($normal); ?></span>
							<span class="info-box-text">Order Normal</span>

							<div class="progress">
								<div class="progress-bar" style="width: <?php echo round($persenNormal) ?>%"></div>
							</div>
							<span class="progress-description">
							<?php echo round($persenNormal).'% dari  '.$totalNormal;?> Order telah diapprove</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->

				<div class="col-md-4 col-sm-6 col-xs-12">
					<?php 
						if ($this->session->responsibility_id == 2665) {
							$classSusulan = 'btnSusulanOrderOKBPengelola';
						}else {
							$classSusulan = 'btnSusulanOrderOKB';
						}

						$susulanBelum = count($susulan);
						$totalSusulan = count($susulanOrder);
						$susulanSelesai = $totalSusulan - $susulanBelum;
						if ($susulanSelesai == 0 && $totalSusulan == 0) {
							$persenSusulan = '100';
						}else {
							$persenSusulan = $susulanSelesai / $totalSusulan * 100;
						}
					?>
					<div class="info-box bg-yellow <?= $classSusulan;?>">
						<span class="info-box-icon"><i style="transform: rotate(270deg) scaleX(-1);" class="fa fa-mail-reply-all  fa-flip-horizontal"></i></span>

						<div class="info-box-content">
							<span class="info-box-number"><?php echo count($susulan); ?></span>
							<span class="info-box-text">Order Susulan</span>

							<div class="progress">
								<div class="progress-bar" style="width: <?php echo round($persenSusulan) ?>%"></div>
							</div>
							<span class="progress-description">
							<?php echo round($persenSusulan).'% dari  '.$totalSusulan;?> Order telah diapprove</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>				
				<!-- /.col -->

				<div class="col-md-4 col-sm-6 col-xs-12">
					<?php 
						if ($this->session->responsibility_id == 2665) {
							$classUrgent = 'btnUrgentOrderOKBPengelola';
						}else {
							$classUrgent = 'btnUrgentOrderOKB';
						}

						$urgentBelum = count($urgent);
						$totalUrgent = count($urgentOrder);
						$urgentSelesai = $totalUrgent - $urgentBelum;
						if ($urgentSelesai == 0 && $totalUrgent == 0) {
							$persenUrgent = '100';
						}else {
							$persenUrgent = $urgentSelesai / $totalUrgent * 100;
						}
					?>
					<div class="info-box bg-red <?= $classUrgent;?>">
						<span class="info-box-icon"><i class="fa fa-warning"></i></span>

						<div class="info-box-content">
							<span class="info-box-number"><?php echo count($urgent); ?></span>
							<span class="info-box-text">Order Urgent</span>

							<div class="progress">
								<div class="progress-bar" style="width: <?php echo round($persenUrgent) ?>%"></div>
							</div>
							<span class="progress-description">
							<?php echo round($persenUrgent).'% dari  '.$totalUrgent;?> Order telah diapprove</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->
				
			</div>

		</section>
		<hr />

		<div class="row">
			<div class="col-lg-12">

				<div class="col-lg-12 text-right reup">
					<h4><small>You are logged in as : <b><?php echo $this->session->user;?></b></small></h4>
				</div>

				<center>
					<img src="<?php echo base_url('assets/img/logo.png');?>" style="max-width:20%;" />
				</center>
				<br /><br />

				<center>
					<?php 
						$load = microtime();
						echo '<p style="font: normal 15px courier">Halaman ini dimuat dalam ';
						echo round($load, 3);
						echo ' detik';
					?>
				</center>

			</div>
		</div>

	</div>
</section>
