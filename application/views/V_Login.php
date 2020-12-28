<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>QuickERP Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Enteprise Resource Planning System Login">
  <link rel="shortcut icon" href="<?= base_url('assets/plugins/cm/img/logo.ico'); ?>">
  <!-- The styles -->
  <link href="<?= base_url('assets/plugins/cm/css/bootstrap-cerulean.min.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/plugins/cm/css/charisma-app.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/plugins/Font-Awesome/4.3.0/css/font-awesome.min.css'); ?>" rel="stylesheet">

  <!-- GLOBAL SCRIPTS -->
  <script src="<?= base_url('assets/plugins/jquery-2.0.3.min.js'); ?>"></script>
  <script src="<?= base_url('assets/plugins/bootstrap/3.0.0/js/bootstrap.min.js'); ?>"></script>
  <script src="<?= base_url('assets/plugins/darkreader/darkreader.min.js'); ?>"></script>

  <style type="text/css">
    @media (max-width: 769px) {
      .hidden-sm {
        display: none;
      }
    }

    @media (max-width: 800px) {
      .login-box {
        max-width: 90% !important;
      }

      .is-mobile-full {
        padding-left: 0 !important;
        padding-right: 0 !important;
      }
    }

    .swal2-popup {
      font-size: 1.6rem !important;
    }
  </style>
  <noscript>
    Javascript dibutuhkan untuk menjalankan aplikasi ini, aktifkan terlebih dahulu javascript di pengaturan
  </noscript>
</head>

<?php
// user agent 
$browser = strtolower($this->agent->browser()); // string, uppercasefirst
$version = $this->agent->version(); // string of version
$platform = $this->agent->platform(); // string, uppercasefirst
$isMobile = $this->agent->is_mobile(); // bool
$isBrowser = $this->agent->is_browser(); // bool

function getBrowserSupport($browser, $isMobile, $version)
{
  $device = $isMobile ? 'mobile' : 'browser';

  $minimumVersionOfBrowser = array(
    'mobile' => [
      'chrome' => '42',
      'firefox' => '45',
      'safari' => '13',
      'chromium' => '42',
      'opera' => '50'
    ],
    'browser' => [
      'chrome' => '49',
      'firefox' => '45',
      'safari' => '13',
      'chromium' => '49',
      'opera' => '50'
    ]
  );

  return isset($minimumVersionOfBrowser[$device][$browser]) ? $minimumVersionOfBrowser[$device][$browser] < $version : false;
}

$is_browser_supported = getBrowserSupport($browser, $isMobile, $version);

// untuk slide show
$start = strtotime("2020-08-30");
$now = strtotime(date('Y-m-d'));
$diff = ($now - $start) / (60 * 60 * 24);
?>

<body id="body">
  <div class="ch-container">
    <?php if ($is_browser_supported) : ?>
      <div class="main">
        <div class="row">
          <div class="col-md-12 center login-header"></div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="row hidden-sm" style="height: 100%">
              <div class="col-sm-9 col-sm-offset-3" style="height: 100%;padding-left: 0;">
                <div class="carousel slide" data-ride="carousel" data-interval="6000">
                  <div class="carousel-inner">
                    <?php
                    $gambarData = array(
                      1 => array(
                        '1.fakta.jpg',
                        '2.manipulasi.jpg',
                        '3.prosedur.jpg',
                        '4.completion.jpg'
                      ),
                      2 => array(
                        '5.stockopname.jpg',
                        '6.Segera-tindak-lanjut.jpg',
                        '7.scw.jpg'
                      )
                    );

                    $loopData = array();
                    if (in_array($diff % 7, array(1, 2, 3))) {
                      $loopData = $gambarData[1];
                    } elseif (in_array($diff % 7, array(4, 5, 6, 0))) {
                      $loopData = $gambarData[2];
                    } else {
                      foreach ($gambarData as $val) {
                        foreach ($val as $val2) {
                          $loopData[] = $val2;
                        }
                      }
                    }

                    foreach ($loopData as $nomor => $value) {
                      if ($nomor == 0) {
                        $active = "active";
                      } else {
                        $active = "";
                      }
                    ?>
                      <div class="item <?php echo $active ?>">
                        <img src="<?php echo base_url('assets/poster/AwarenessData/' . $value) ?>" style="width: 100%;height: auto" alt="<?php echo $value ?>">
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-md-6">
            <div class="well login-box" style="margin: 0 auto;">
              <div class="row left" style="padding: 1%; margin-left:-5%;">
                <div class="col-md-12">
                  <div style="float:left;">
                    <img src="<?= base_url('assets/plugins/cm/img/logo4.png'); ?>" style="max-width: 100%;" />
                  </div>
                </div>
              </div>
              <?php if ($this->session->gagal) : ?>
                <div class="alert alert-danger text-left">
                  <?php echo $error; ?>
                </div>
              <?php else : ?>
                <div class="alert alert-info text-left center">
                  Silahkan masukan username dan password Anda untuk masuk ke Sistem
                </div>
              <?php endif ?>
              <form class="form-horizontal" action="<?= site_url('login'); ?>" method="POST">
                <fieldset>
                  <div class="input-group input-group-lg">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
                    <input type="text" name="username" id="username" class="form-control toupper" placeholder="Username" autofocus>
                  </div>
                  <div class="clearfix"></div><br>

                  <div class="input-group input-group-lg">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                  </div>
                  <div class="clearfix"></div>

                  <div class="row">
                    <div class="col-lg-4">
                      <a class="btn btn-success" data-toggle="modal" data-target="#myRequest">Permintaan Akses</a>
                    </div>
                    <div class="col-lg-4">
                      <a class="btn btn-default" data-toggle="modal" data-target="#myModal">Lupa Password ?</a>
                    </div>
                    <div class="col-lg-4">
                      <button type="submit" class="btn btn-primary">Masuk</button>
                    </div>
                  </div>
                </fieldset>
              </form>
            </div>
          </div>
          <div class="col-md-3">
            <div class="row hidden-sm" style="height: 100%">
              <div class="col-sm-9" style="height: 100%;padding-right: 0;">
                <div class="carousel slide" data-ride="carousel" data-interval="7000">
                  <div class="carousel-inner">
                    <?php
                    $gambarCovid = array(
                      1 => array(
                        '1.Jagajarak.jpg',
                        '2.Maskerbaikbenar.jpg',
                        '3.Gantimasker.jpg',
                        '4.Dontspeak.jpg',
                        '5.LewatAirborne.jpg'
                      ),
                      2 => array(
                        '6.CuciTangan.jpg',
                        '7.6lngkah.jpg',
                        '8.KontakFisik.jpg',
                        '9.NyedakKeplak.jpg',
                        '10.Makan.jpg'
                      ),
                      3 => array(
                        '11.Smoker.jpg',
                        '12.Akuada.jpg',
                        '13.4jalan.jpg',
                        '14.Staywithme.jpg'
                      ),
                      4 => array(
                        '15.DontGobaby.jpg',
                        '16.Janganpegang.jpg',
                        '17.Openthedor.jpg',
                        '18.Breath.jpg'
                      )
                    );

                    $loopCovid = array();
                    if (in_array($diff % 14, array(1, 2, 3))) {
                      $loopCovid = $gambarCovid[1];
                    } elseif (in_array($diff % 14, array(4, 5, 6, 7))) {
                      $loopCovid = $gambarCovid[2];
                    } elseif (in_array($diff % 14, array(8, 9, 10))) {
                      $loopCovid = $gambarCovid[3];
                    } elseif (in_array($diff % 14, array(11, 12, 13, 0))) {
                      $loopCovid = $gambarCovid[4];
                    } else {
                      foreach ($gambarCovid as $val) {
                        foreach ($val as $val2) {
                          $loopCovid[] = $val2;
                        }
                      }
                    }

                    $nomor = 0;
                    foreach ($loopCovid as $nomor => $value) {
                      if ($nomor == 0) {
                        $active = "active";
                      } else {
                        $active = "";
                      }
                    ?>
                      <div class="item <?php echo $active ?>">
                        <img src="<?php echo base_url('assets/poster/Covid/' . $value) ?>" style="width: 100%;height: auto" alt="<?php echo $value ?>">
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Forgot Password Modal -->
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title text-center" id="myModalLabel">
                Anda Lupa Password ?
              </h4>
            </div>
            <div class="modal-body">
              Jika Anda lupa password, silahkan membuat ticket / order permintaan melalui <a target="blank" href='http://ictsupport.quick.com/ticket/upload/'>ICT Support Center (Klik Disini)</a> atau akses url berikut : <a target="_blank" href="http://ictsupport.quick.com/ticket/upload/">http://ictsupport.quick.com/ticket/upload/.</a>
              <br>atau menghubungi ICT di<br>
              VOIP Internal Ext : 12300 ekstensi 3
              <br>atau<br>
              melalui Whatsapp ke 08112545922.
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Privileges Request Modal -->
      <div class="modal fade" id="myRequest" tabindex="-1" role="dialog" aria-labelledby="myRequestLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title text-center" id="myRequestLabel">
                Anda menginginkan Akses ke Sistem ERP?
              </h4>
            </div>
            <div class="modal-body">
              Jika Anda ingin mendapatkan Akses ke Quick ERP System, silahkan membuat ticket / order permintaan melalui <a target="blank" href='http://ictsupport.quick.com/ticket/upload/'>ICT Support Center (Klik Disini)</a> atau akses url berikut : <a target="_blank" href="http://ictsupport.quick.com/ticket/upload/">http://ictsupport.quick.com/ticket/upload/.</a>
              <br>atau menghubungi ICT di<br>
              VOIP Internal Ext : 12300 ekstensi 3
              <br>atau<br>
              melalui Whatsapp ke 08112545922.
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <script type="text/javascript">
        $(document).ready(function() {
          $('#pengguna').focus();
        });
      </script>
    <?php else : ?>
      <div class="text-center">
        <h3>Aplikasi Browser (<?= $browser ?> Versi <?= $version ?>) Anda <b>tidak memenuhi Spesifikasi Standar Minimum Akses</b> QuickERP.</h3>
        <h3>Silahkan gunakan Aplikasi Browser berikut : </h3>
        <h3>- Google Chrome Versi 49 ke Atas</h3>
        <h3>- Chromium Versi 50 ke Atas</h3>
        <h3>- Mozilla Firefox Versi 45 ke Atas</h3>
        <h3>atau </h3>
        <h3>Silahkan <b>menghubungi Bag. Hardware ICT</b> untuk dilakukan installasi / update Browser</h3>
        <h3><b>di VoIP 12300 Ext. 5 atau Telkomsel MyGroup 628112545922</b></h3>
        <h3>--- QuickERP ---</h3>
        <span>Platform : <?= $platform ?></span>
      </div>
    <?php endif ?>
  </div>
</body>

</html>