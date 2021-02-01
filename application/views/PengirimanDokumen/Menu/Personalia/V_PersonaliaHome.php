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
  .width-33{
      width: 33% !important;
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
                <div class="box-header with-border">
                    <h2><b>Hubungan Kerja <?= $lv?></b></h2>
                </div>
                <div class="box-body ">
                    <div class="col-lg-3 col-xs-6 width-33">
                        <div class="small-box bg-yellow">
                        <div class="inner">
                            <p>Data baru</p>
                            <h8 class="<?php echo ($pending > 0)? 'blinkanim':'' ?>"><?=number_format($pending,0,',','.') ?> Data</h8>
                        </div>
                        <div class="icon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                        <a href="<?= site_url('PengirimanDokumen/Personalia'.$lv.'/new') ?>" class="small-box-footer">Info Lengkap <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6 width-33">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <p>Disetujui</p>
                            <h8><?=number_format($approved,0,',','.') ?> Data</h8>
                        </div>
                        <div class="icon">
                            <i class="fa fa-check"></i>
                        </div>
                        <a href="<?= site_url('PengirimanDokumen/Personalia'.$lv.'/approved') ?>" class="small-box-footer">Info Lengkap <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6 width-33">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <p>Ditolak</p>
                            <h8><?=number_format($rejected,0,',','.') ?> Data</h8>
                        </div>
                        <div class="icon">
                            <i class="fa fa-close"></i>
                        </div>
                        <a href="<?= site_url('PengirimanDokumen/Personalia'.$lv.'/rejected') ?>" class="small-box-footer">Info Lengkap <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>