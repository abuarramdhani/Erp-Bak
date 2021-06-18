<div class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="col-lg-11">
              <h2 class="text-right"><b>Poin Penyimpangan</b></h2>
            </div>
            <div class="col-lg-1">
              <div class="text-right hidden-md hidden-xs">
                <a class="btn btn-default btn-lg" href="<?php echo base_url('MenjawabTemuanAudite/Handling') ?>">
                  <i class="fa fa-home fa-2x"></i><br>
                </a>
              </div>
            </div>
          </div>
        </div>
        <br>

        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 style="text-align:center"><b>POIN PENYIMPANGAN</b></h3>
              </div>
              <!-- <div class="box-body" style="background:#f0f0f0 !important"> -->
                <div class="box-body">
                  <div class="row" style="margin-top:30px">
                    <form class="form-horizontal" autocomplete="off" enctype="multipart/form-data" action="<?php echo site_url('MenjawabTemuanAudite/Handling/insertPoinPenyimpangan') ?>" method="post">
                      <div class="col-lg-2"></div>
                      <!-- <div class="col-lg-2">
                        <label style="vertical-align:-webkit-baseline-middle">Poin Penyimpangan : </label>
                      </div> -->
                      <div class="col-lg-8">
                        <table style="width:100%">
                          <tr>
                            <td style="vertical-align:baseline;width:20%"><label>Poin Penyimpangan</label></td>
                            <td style="vertical-align:baseline;width:7%"><b>:</b></td>
                            <td style="vertical-align:baseline;width:73%"><input type="text" name="poin_penyimpangan" class="form-control" required></td>
                          </tr>
                        </table>
                      </div>
                      <div class="col-lg-2"></div>
                    </div>
                    <div class="row" style="margin-top:10px">
                      <div class="col-lg-6"></div>
                      <div class="col-lg-3">
                        <div class="text-right">
                          <button type="submit" class="btn btn-success" style="margin-right:-15px"><i class="fa fa-plus"></i>  Add</button>
                        </div>
                      </div>
                      <div class="col-lg-1">
                        <div class="text-right">
                          <a href="<?php echo base_url('MenjawabTemuanAudite/Handling') ?>" class="btn btn-danger" style="margin-left:-10px"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                      </div>
                      <div class="col-lg-2"></div>
                    </form>
                    </div>
                    <div class="row" style="margin-top:5px">
                      <hr>
                      <div class="form-group">
                      <div class="col-lg-12">
                            <div class="col-lg-1" style="margin-right:-40px">
                              <a class="btn btn-primary" style="margin-top:2.5px" onclick="poin_penyimpangan_handling()">
                                <i class="fa fa-refresh"></i><br>
                              </a>
                            </div>
                            <h4 class="col-lg-3"><b>Daftar Poin Penyimpangan</b></h4>
                        </div>
                      </div>
                    </div>
                    <div class="row" style="margin-top:10px">
                      <div class="col-lg-12 area_poin_penyimpangan"></div>
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
    url: baseurl + 'MenjawabTemuanAudite/Handling/getPoinPenyimpangan',
    type: 'POST',
    data: {
    },
    cache: false,
    beforeSend: function () {
      $('.area_poin_penyimpangan').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                  <img style="width: 12%;" src="${baseurl}/assets/img/gif/loading14.gif"><br>
                                  <span style="font-size:13px;font-weight:bold;margin-top:5px">Sedang Memuat Data...</span>
                              </div>`);
    },
    success: function(result) {
      if (result != 0) {
        $('.area_poin_penyimpangan').html(result);
      }else if (result == 0) {
        $('.area_poin_penyimpangan').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                  <i class="fa fa-remove" style="color:#d60d00;font-size:45px;"></i><br>
                                  <h3 style="font-size:14px;font-weight:bold">Tidak ada data Poin Penyimpangan</h3>
                              </div>`);
      }else {

      }
    },
    eror: function (XMLHttpRequest, textStatus, errorThrown) {
      console.log();
    }
  })
}, 150);
</script>
