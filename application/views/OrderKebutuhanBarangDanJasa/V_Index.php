<section id="content">
	<div class="inner" style="background: url('<?= base_url('assets/img/3.jpg') ?>');background-size: cover;">

		<!-- Content Header (Page header) -->
		<section class="content-header">

			<div class="row">
				<div class="col-lg-6">
					<br />
					<h1>Order Kebutuhan Barang dan Jasa</h1>
				</div>
			</div>

			<div class="row">
				<a class="col-md-4 col-sm-6 col-xs-12" href="<?= $RegulerOrder->URL ?>">
					<div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>
            <div class="info-box-content">
              <span class="info-box-number"><?= $RegulerOrder->Unapproved; ?></span>
              <span class="info-box-text">Order Reguler</span>
              <div class="progress">
                <div class="progress-bar" style="<?= "width: $RegulerOrder->Percentage%" ?>"></div>
              </div>
              <span class="progress-description">
              <?= "$RegulerOrder->Percentage% dari $RegulerOrder->Total Order telah diapprove"?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </a>
        <!-- /.col -->

				<a class="col-md-4 col-sm-6 col-xs-12" href="<?= $EmergencyOrder->URL ?>">
          <div class="info-box bg-yellow">
						<span class="info-box-icon"><i style="transform: rotate(270deg) scaleX(-1);" class="fa fa-mail-reply-all  fa-flip-horizontal"></i></span>
						<div class="info-box-content">
							<span class="info-box-number"><?= $EmergencyOrder->Unapproved; ?></span>
							<span class="info-box-text">Order Emergency</span>

							<div class="progress">
								<div class="progress-bar" style="<?= "width: $EmergencyOrder->Percentage%" ?>"></div>
							</div>
							<span class="progress-description">
              <?= "$EmergencyOrder->Percentage% dari $EmergencyOrder->Total Order telah diapprove"?></span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</a>
				<!-- /.col -->

				<a class="col-md-4 col-sm-6 col-xs-12" href="<?= $UrgentOrder->URL ?>">
					<div class="info-box bg-red">
						<span class="info-box-icon"><i class="fa fa-warning"></i></span>
						<div class="info-box-content">
							<span class="info-box-number"><?= $UrgentOrder->Unapproved; ?></span>
							<span class="info-box-text">Order Urgent</span>
							<div class="progress">
								<div class="progress-bar" style="<?= "width: $UrgentOrder->Percentage%" ?>"></div>
							</div>
							<span class="progress-description">
              <?= "$UrgentOrder->Percentage% dari $UrgentOrder->Total Order telah diapprove"?></span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</a>
				<!-- /.col -->
			</div>
      <!-- /.row -->

    </section>

		<div class="row">
			<div class="col-lg-12">

				<div class="col-lg-12 text-right reup">
					<h4><small>You are logged in as : <b><?= $this->session->user ?></b></small></h4>
				</div>

				<center>
					<img src="<?= base_url('assets/img/logo.png') ?>" style="max-width:20%;" />
				</center>
				<br /><br />

				<center>
					<?php $load = round(microtime(), 3) ?>
          <?= "<p style='font: normal 15px courier'>Halaman ini dimuat dalam $load" ?>
				</center>

			</div>
		</div>

	</div>
</section>