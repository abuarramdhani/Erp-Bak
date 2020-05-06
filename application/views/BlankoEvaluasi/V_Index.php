<style>
.flex {
  display: flex;
}

.flex.center {
  justify-content: center;
}

.flex.space-between {
  justify-content: space-between;
}

.m-2 {
  margin: 2em;
}

.pl-2 {
  padding-left: 2em;
}

.pr-2 {
  padding-right: 2em;
}

.p-2 {
  padding: 1em 2em;
}

.mb-1 {
  margin-bottom: 1em;
}
</style>
<section style="position: relative;">
  <div class="inner" style="background: url('<?php echo base_url('assets/img/3.jpg');?>'); background-size: cover;">
    <section class="content-header">
      <div class="row">
        <div class="col-lg-12">
          <br />
          <h1>Dashboard Blanko Evaluasi</h1>
        </div>
      </div>
    </section>
    <hr />
    <section>
      <div class="row m-2">
        <div class="col-lg-4"></div>
        <div class="col-lg-4 flex center">
          <div style="
						border-radius: 50%;
						border: 2px solid #e8e8e8;
						background-color: #ffffff;
						width: 150px;
						height: 150px;
						display: flex;
						justify-content: center;
						align-items: center;
					">
            <img style="width: 70px; height: 70px;" src="<?= base_url('assets/img/AndroidImages/document.png') ?>" alt="">
          </div>
        </div>
        <div class="col-lg-4"></div>
      </div>
      <div class="row">
        <div class="col-lg-12 mb-1 flex center">
          <a class="btn btn-primary flex space-between p-2" style="width: 400px; " href="<?= base_url('BlankoEvaluasi/NonStaff') ?>">
            <span>Non-Staff & Outsourcing</span>
            <i class="fa fa-arrow-right"></i>
          </a>
        </div>
        <div class="col-lg-12 mb-1 flex center">
          <a class="btn btn-primary flex space-between p-2" style="width: 400px; " href="<?= base_url('BlankoEvaluasi/Staff') ?>">
            <span>Staff</span>
            <i class="fa fa-arrow-right"></i>
          </a>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
          <p>
            Aplikasi ini digunakan untuk mencetak blanko <b>Evaluasi Penilaian Perpanjangan Status Hubungan Kerja Outsourcing/Kontrak Non-staf
          </p>
        </div>
        <div class="col-lg-3"></div>
      </div>
    </section>
    <div class="row">
      <div class="col-lg-12">
        <div class="col-lg-12 text-right reup">
          <h4><small>You are logged in as : <?php echo $this->session->user;?></small></h4>
        </div>
        <?php 
					$started = microtime();
					$second = round($started, 3);
					echo "<p style='font: normal 15px courier'>Halaman ini dimuat dalam {$second} detik";
				?>
      </div>
    </div>
  </div>
</section>