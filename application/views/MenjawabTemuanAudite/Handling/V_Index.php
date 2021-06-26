<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="col-lg-11">
              <div class="text-right">
                <h2><b><?php echo $title ?></b></h2>
              </div>
            </div>
            <div class="col-lg-1">
              <div class="text-right hidden-md hidden-xs">
                <a class="btn btn-default btn-lg" onclick="handling_mta()">
                  <i class="fa fa-refresh fa-2x"></i><br>
                </a>
              </div>
            </div>
          </div>
        </div>
        <br>

        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <h4 class="col-lg-11"><i class="fa fa-tasks fa-lg "></i> <b>TEMUAN AUDITE <span style="font-family:Source Sans Pro,Helvetica Neue,Helvetica,Arial,sans-serif"><?php echo $area['seksi'] ?></span></b></h4>
                <a href="<?php echo base_url('MenjawabTemuanAudite/Handling/viewPoinPenyimpangan') ?>" style="float:right;border:2px solid white" class="btn btn-default" title="Custom Sarana and Penyimpangan">
                  <!-- <button type="button" class="btn btn-default"> -->
                    <i class="fa fa-plus "></i>
                  <!-- </button> -->
                </a>
              </div>
              <div class="box-body" style="background:#f0f0f0 !important">
                <div class="box-body" style="background:#ffffff !important;border-radius:7px;margin-bottom:10px">
                  <div class="row">
                    <h3><center><b>MENJAWAB TEMUAN OLEH AUDITE</b></center></h3><hr>
                    <input type="hidden" name="area" id="area_handling" value="<?php echo $area['seksi'] ?>">
                  </div>
                  <!-- <div class="row" style="margin-top:6px;margin-bottom:25px">
                    <div class="col-md-2"></div>
                    <div class="col-md-7">
                      <label for="">Select Seksi</label>
                      <select class="form-control select-handling" style="width:100%" name="" data-placeholder="Pilih Seksi">
                        <option value=""></option>
                      </select>
                    </div>
                    <div class="col-md-1">
                      <label for="" style="color:transparent">Ini Filter</label>
                      <button type="button" id="handlingMTA" onclick="handling_mta()" style="font-size:15px" class="btn btn-primary btn-sm btn-block" disabled><strong><i class="fa fa-search"></i></strong></button>
                    </div>
                    <div class="col-md-2"></div>
                  </div> -->
                  <div class="row" style="margin-top:10px">
                    <div class="col-md-12 area_hand">
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
const toastMTAM_ = (type, message) => {
  Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000
  }).fire({
    customClass: 'swal-font-small',
    type: type,
    title: message
  })
};

var area_handling = $('#area_handling').val();
setTimeout(function () {
  $.ajax({
    url: baseurl + 'MenjawabTemuanAudite/Handling/getAjax',
    type: 'POST',
    data: {
      area_handling: area_handling,
    },
    cache: false,
    beforeSend: function () {
      $('.area_hand').html(`<div class="area_handling"></div>`);
      $('.area_handling').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                  <img style="width: 12%;" src="${baseurl}/assets/img/gif/loading14.gif"><br>
                                  <span style="font-size:13px;font-weight:bold;margin-top:5px">Sedang Memuat Data...</span>
                              </div>`);
    },
    success: function(result) {
      if (result != 0) {
        $('.area_hand').html(`<div class="area_handling"></div>`);
        $('.area_handling').html(result);
        $('#top').text(`Daftar Temuan Audite Area ${area_handling}`);
        toastMTAM_('success', 'Success Load Data');
      }else if (result == 0) {
        $('.area_hand').html(`<div class="area_handling"></div>`);
        $('.area_handling').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                  <i class="fa fa-remove" style="color:#d60d00;font-size:45px;"></i><br>
                                  <h3 style="font-size:14px;font-weight:bold">Tidak ada data Temuan Audite Area ${area_handling}</h3>
                              </div>`);
        toastMTAM_('error', 'Data is Empty');
      }else {
        toastMTAM_('Warning', 'Terdapat Kesalahan Saat Mengambil Data');
      }
    },
    eror: function (XMLHttpRequest, textStatus, errorThrown) {
      console.log();
    }
  })
}, 150);
// console.log(area_handling);
</script>
