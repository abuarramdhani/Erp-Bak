<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="col-lg-12">
              <div class="text-right">
                <h1><b><?php echo $title ?></b></h1>
              </div>
            </div>
            <!-- <div class="col-lg-1">
              <div class="text-right hidden-md hidden-xs">
                <a class="btn btn-default btn-lg" href="<?php //echo site_url('RekapTemuanAudite/Handling'); ?>">
                  <i class="icon-wrench icon-2x"></i><br>
                </a>
              </div>
            </div> -->
          </div>
        </div>
        <br>

        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <h4><i class="fa fa-pencil"></i> <b>REKAP TEMUAN AUDITE</b></h4>
              </div>
              <div class="box-body" style="background:#f0f0f0 !important">
                <div class="box-body" style="background:#ffffff !important;border-radius:8px;margin-bottom:10px">
                  <div class="row">
                    <h3><center><b>REKAP TEMUAN AUDITE</b></center></h3>
                    <hr>
                  </div>
                  <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-7">
                      <label>Select Seksi</label>
                      <select class="form-control select-handling" style="width:100%" name="" data-placeholder="Pilih Seksi">
                        <option value=""></option>
                      </select>
                    </div>
                    <div class="col-lg-1">
                      <label style="color:transparent">For Filter</label>
                      <button type="button" id="handlingRTA" onclick="handling_rta();presentase_rta()" style="font-size:15px" class="btn btn-primary btn-sm btn-block" disabled><strong><i class="fa fa-search"></i></strong></button>
                    </div>
                    <div class="col-lg-2"></div>
                  </div>
                  <div class="row" style="margin-top:12px">
                    <hr>
                  </div>
                  <div class="row" style="margin-top:-10px">
                    <div class="col-lg-12 presentase_rta">
                    </div>
                  </div>
                  <div class="row">
                    <hr>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 rta_handling_area">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
  setTimeout(function () {
    $.ajax({
      url: baseurl + 'RekapTemuanAudite/Handling/getGeneralPresentase',
      type: 'POST',
      data:{},
      beforeSend: function () {
        $('.presentase_rta').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                    <img style="width: 12%;" src="${baseurl}/assets/img/gif/loading14.gif">
                                </div>`);
      },
      success: function (result) {
        if (result != 0) {
          $('.presentase_rta').html(result);
          $('#presentase_all_co').text(`Presentase Open Close seluruh data temuan audite`);
          $('#presentase_all_pp').text(`Presentase Poin Penyimpangan Seluruh data temuan audite`);
        }else if (result == 0) {
          $('.presentase_rta').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                    <i class="fa fa-remove" style="color:#d60d00;font-size:45px;"></i><br>
                                    <h3 style="font-size:14px;font-weight:bold">Tidak ada data Temuan Audite</h3>
                                </div>`);
        }
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        console.log();
      }
    })
  }, 150);
</script>
