<style media="screen">
  h8{
    font-size: 2em;
    font-weight: bold;
  }

  .small-box .icon{
    display:inherit;
  }

  .badge{
    position: absolute;
    top: -10px;
    right: -10px;
    /* padding: 6px 10px; */
    border-radius: 50%;
    transform: scale(1.5);
    color: white;
    transition: 0.4s;
  }

  .badge-green{
    background-color: #00A65A;
  }

  .badge-red{
    background-color: #DD4B39;
  }

  .badge-red-strong{
    background-color: red;
  }

  .badge-orange{
    background-color: #F39C12;
  }

  .badge:hover{
    transform: scale(2);
  }

  .blinkanim{
    animation: blink_anim 1.5s linear infinite;
  }

  @keyframes blink_anim {
    0% {
      opacity: 1;
    }
    10% {
      opacity: 0;
    }
    100%{
      opacity: 1;
    }

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
                <span class="pull-right-container">
                  <span class="badge <?php echo ($count_inprocess > 0)? 'badge-red-strong blinkanim':'badge-orange' ?>"><?= $count_inprocess ?></span>
                </span>
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
                <span class="pull-right-container">
                  <span class="badge badge-green"><?= $count_approved?></span>
                </span>
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
                <span class="pull-right-container">
                  <span class="badge badge-red"><?= $count_rejected ?></span>
                </span>
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
