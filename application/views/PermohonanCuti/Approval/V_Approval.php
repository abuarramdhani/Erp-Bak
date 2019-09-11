<style media="screen">
  h8{
    font-size: 2em;
    font-weight: bold;
  }

  .small-box .icon{
    display:inherit;
  }

  @media screen and (max-width: 767px) {
    .personal{
      display:none;
    }
  }
</style>
<section class="content">
  <div class="panel-body">
    <div class="row">
      <div class="box box-primary box-solid">
        <div style="height: 5em" class="box-header with-border">
          <h2 align="center"><strong><?=$Menu ?></strong></h2>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body personal bg-info">
          <div class="row">
            <div class="col-lg-12">
              <div class="row">
                <div class="col-lg-1 col-md-2 col-sm-2 col-xs-3">
                  <text>Nama 			  </text><br>
                  <text>No Induk	  </text><br>
                  <text>Seksi 		  </text><br>
                  <text>Unit			  </text><br>
                  <text>Departemen  </text>
                </div>
                <div class="ccol-lg-11 col-md-10 col-sm-10 col-xs-9">
                  <?php foreach ($Info as $key): ?>
                    <text>: <?=$key['nama']?></text> <br>
                    <text>: <?=$key['noind']?> </text><br>
                    <text>: <?=$key['seksi']?> </text><br>
                    <text>: <?=$key['unit']?> </text><br>
                    <text>: <?=$key['dept']?> </text>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="box box-primary box-solid">
          <div class="box-header with-border">
             <h4>Menu Approval <?=$user ?></h4>
          </div>
          <div class="box-body ">
						<div class="col-lg-3 col-xs-6">
							<div class="small-box bg-yellow">
								<div class="inner">
									<p>Cuti Belum</p>
									<h8>Diproses</h8>
								</div>
								<div class="icon">
									<i class="fa fa-clock-o"></i>
								</div>
								<a href="<?= site_url('PermohonanCuti/Approval/Inprocess') ?>" class="small-box-footer">Info Lengkap <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
						<div class="col-lg-3 col-xs-6">
							<div class="small-box bg-green">
								<div class="inner">
									<p>Cuti</p>
									<h8>Disetujui</h8>
								</div>
								<div class="icon">
									<i class="fa fa-check"></i>
								</div>
								<a href="<?= site_url('PermohonanCuti/Approval/Approved') ?>" class="small-box-footer">Info Lengkap <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
						<div class="col-lg-3 col-xs-6">
							<div class="small-box bg-red">
								<div class="inner">
									<p>Cuti</p>
									<h8>Ditolak</h8>
								</div>
								<div class="icon">
									<i class="fa fa-close"></i>
								</div>
								<a href="<?= site_url('PermohonanCuti/Approval/Rejected') ?>" class="small-box-footer">Info Lengkap <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
          <!-- <?php if(strstr($this->session->kodesie, '4090101')){  ?>
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-primary">
                <div class="inner">
                  <p>Cuti</p>
                  <h8>Dibatalkan</h8>
                </div>
                <div class="icon">
                  <i class="fa fa-ban"></i>
                </div>
                <a href="<?= site_url('PermohonanCuti/Approval/Canceled') ?>" class="small-box-footer">Info Lengkap <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          <?php } ?> -->
      </div>
    </div>
  </div>
</section>
