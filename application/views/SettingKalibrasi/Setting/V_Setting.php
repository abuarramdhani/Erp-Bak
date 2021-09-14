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
                      <div class="col-lg-2"></div>
                      <div class="col-lg-8">
                      <h4><b>Tambah Data Kalibrasi</b></h4>
                      
                      <table style="width:100%">
                      <tr>
                        <td style="width:23%;padding-top:15px"><b>No. Alat Ukur</b></td>
                        <td style="width:3%;padding-top:15px"><b>:</b></td>
                        <td style="width:74%;padding-top:15px"><input type="text" id="add_no_alat_ukur" class="form-control" placeholder="No.Alat Ukur" required></td>
                      </tr>
                      <tr>
                        <td style="width:23%;padding-top:15px"><b>Jenis Alat Ukur</b></td>
                        <td style="width:3%;padding-top:15px"><b>:</b></td>
                        <td style="width:74%;padding-top:15px"><input type="text" id="add_jenis_alat_ukur" class="form-control" placeholder="Jenis Alat Ukur" required ></td>
                      </tr>
                      <tr>
                        <td style="width:23%;padding-top:15px"><b>Last Calibration</b></td>
                        <td style="width:3%;padding-top:15px"><b>:</b></td>
                        <td style="width:74%;padding-top:15px"><input type="date" id="add_last_calibration" class="form-control" required></td>
                      </tr>
                      <tr>
                        <td style="width:23%;padding-top:15px"><b>Next Calibration</b></td>
                        <td style="width:3%;padding-top:15px"><b>:</b></td>
                        <td style="width:74%;padding-top:15px"><input type="date" id="add_next_calibration" class="form-control" required></td>
                      </tr>
                      <tr>
                        <td style="width:23%;padding-top:15px"><b>Lead Time</b></td>
                        <td style="width:3%;padding-top:15px"><b>:</b></td>
                        <td style="width:74%;padding-top:15px"><input type="number" id="add_lead_time" class="form-control" value="12"></td>
                      </tr>
                      <tr>
                        <td style="width:23%;padding-top:15px"><b>Status</b></td>
                        <td style="width:3%;padding-top:15px"><b>:</b></td>
                        <td style="width:74%;padding-top:15px"><select class="form-control select-2-status" name="add_status">
                            <option value="ACTIVE">ACTIVE</option>
                            <option value="INACTIVE">INACTIVE</option>
                        </select>
                        </td>
                      </tr>
                      </table>

                      <div class="row" style="margin-top:18px">
                      <div class="col-lg-5"></div>
                      <div class="col-lg-2">
                        <div class="text-right">
                          <button type="submit" class="btn btn-success" style="" onclick="kirimAdd()" ><i class="fa fa-plus"></i>  Add</button>
                        </div>
                      </div>
                      <div class="col-lg-5"></div>
                      </div>                      
               
                    </div>

                    
                    <div class="row" style="margin-top:5px">
                      <hr>
                      <div class="form-group">
                      <div class="col-lg-12">
                        <h4 class="col-lg-3"><b>Daftar Kalibrasi</b></h4>
                      </div>
                      </div>
                    </div>
                    <div class="row" style="margin-top:10px">                      
                      <div class="col-lg-12">
                        <div class="col-lg-12 area_kalibrasi"></div>
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
    url: baseurl + 'SettingKalibrasi/Setting/getKalibrasi',
    type: 'POST',
    data:{},
    cache:false,
    beforeSend: function () {
      $('.area_kalibrasi').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                  <img style="width: 12%;" src="${baseurl}assets/img/gif/loading14.gif"><br>
                                  <span style="font-size:13px;font-weight:bold;margin-top:5px">Data sedang dimuat...</span>
                              </div>`);
    },
    success: function (result) {      
        $('.area_kalibrasi').html(result);     
    },
    eror: function (XMLHttpRequest, textStatus, errorThrown) {
      console.log();
    }
  })
}, 150);

function kirimAdd() {
    var id = $('[name="add_id"]').val();
    var no_alat_ukur = $('#add_no_alat_ukur').val();
    var jenis_alat_ukur = $('#add_jenis_alat_ukur').val();
    var last_calibration = $('#add_last_calibration').val();
    var next_calibration = $('#add_next_calibration').val();
    var lead_time = $('#add_lead_time').val();
    var status = $('select[name="add_status"]').val();
    $.ajax({
        url: baseurl + 'SettingKalibrasi/Setting/tambahKalibrasi',
        type: 'POST',
        data:{
            id: id,
            no_alat_ukur: no_alat_ukur,
            jenis_alat_ukur: jenis_alat_ukur,
            last_calibration: last_calibration,
            next_calibration: next_calibration,
            lead_time: lead_time,
            status: status
        },
        cache: false,
        success: function (result) {
            if (result == 0) {
              alert('No Alat Ukur sudah terdaftar! Silahkan ganti dengan No Alat Ukur lain.');
            }else{
            setTimeout(() => {
                Kalibrasi = $.ajax({
                    url: baseurl + 'SettingKalibrasi/Setting/getKalibrasi',
                    type: 'POST',
                    data:{},
                    cache:false,
                    beforeSend: function () {
                        $('.area_kalibrasi').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                                    <img style="width: 12%;" src="${baseurl}assets/img/gif/loading14.gif"><br>
                                                    <span style="font-size:13px;font-weight:bold;margin-top:5px">Data sedang dimuat...</span>
                                                </div>`);
                      },
                      success: function (result) {                             
                          $('.area_kalibrasi').html(result);
                          toastSK_('success', 'Data Berhasil Ditambahkan') ;                        
                      },
                      eror: function (XMLHttpRequest, textStatus, errorThrown) {
                        console.log();
                      }
                })
            }, 450);
          }
        }
    })    
}
</script>