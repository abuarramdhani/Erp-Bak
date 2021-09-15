<div class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <!-- <div class="col-lg-11">
              <h2 class="text-right"><b>Custom</b></h2>
            </div>
            <div class="col-lg-1">
              <div class="text-right hidden-md hidden-xs">
                <a class="btn btn-default btn-lg" href="<?php echo base_url('SettingKalibrasi') ?>">
                  <i class="fa fa-home fa-2x"></i><br>
                </a>
              </div>
            </div> -->
          </div>
        </div>
        <br>

        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 style="text-align:center"><b>KALIBRASI ABU SHEET METAL</b></h3>
              </div>
              <!-- <div class="box-body" style="background:#f0f0f0 !important"> -->
                <div class="box-body">
                  <div class="row" style="margin-top:30px">
                    <div class="row" style="margin-top:5px">
                      <div class="form-group">
                      <div class="col-lg-12">
                        <h4 class="col-lg-3"><b>Daftar Kalibrasi Inactive</b></h4>
                      </div>
                      </div>
                    </div>
                    <div class="row" style="margin-top:10px">
                      <div class="col-lg-12">
                        <div class="col-lg-12 area_kalibrasi_inactive"></div>
                      </div>
                    </div>
                </div>
              <!-- </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
setTimeout(function () {
  $.ajax({
    url: baseurl + 'SettingKalibrasi/Inactive/getKalibrasiInactive',
    type: 'POST',
    data:{},
    cache:false,
    beforeSend: function () {
      $('.area_kalibrasi_inactive').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                  <img style="width: 12%;" src="${baseurl}assets/img/gif/loading14.gif"><br>
                                  <span style="font-size:13px;font-weight:bold;margin-top:5px">Data sedang dimuat...</span>
                              </div>`);
    },
    success: function (result) {
        $('.area_kalibrasi_inactive').html(result);
    },
    eror: function (XMLHttpRequest, textStatus, errorThrown) {
      console.log();
    }
  })
}, 150);
</script>