<div class="row">
  <div class="col-md-7">
    <div class="box box-primary box-solid">
      <div class="box-header" style="padding:5px !important">
        <b>Seksi - Tanggal - Shift - Standar Waktu</b>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-5">
            <div class="form-group">
              <label for="">Tanggal</label>
              <input type="text" class="form-control LphTanggal lph_tdl_add"  name="tanggal" value="<?php echo $get[0]['tanggal'] ?>">
            </div>
            <div class="form-group">
              <label for="">Shift</label>
              <select class="select2" name=""  style="width:100%">
                <option value="<?php echo $get[0]['shift'] ?>"><?php echo $get[0]['shift'] ?> - <?php echo $get[0]['shift_description'] ?></option>
              </select>
            </div>
            <div class="form-group">
              <label for="">Kelompok</label>
              <input type="text" class="form-control"  name="" value="">
            </div>
          </div>
          <div class="col-md-7">
            <table class="table no-border" style="width:100%;margin:0">
              <tr>
                <td style="width:65%">Waktu Kerja</td>
                <td style="width:25%;">: <span class="lph_waktu_kerja">..</span> </td>
                <td style="float:right">Menit</td>
              </tr>
              <tr>
                <td>Breafing Awal Kerja</td>
                <td>: <span class="lph_w_brefing_awal">5</span> </td>
                <td style="float:right">Menit</td>
              </tr>
              <tr>
                <td>Persiapan Kerja</td>
                <td>: <span class="lph_w_persiapan">5</span> </td>
                <td style="float:right">Menit</td>
              </tr>
              <tr>
                <td>Cleaning Akhir Job</td>
                <td>: <span class="lph_w_cleaning">12</span> </td>
                <td style="float:right">Menit</td>
              </tr>
              <tr>
                <td>Breafing Akhir Kerja</td>
                <td>: <span class="lph_w_brefing_akhir">3</span> </td>
                <td style="float:right">Menit</td>
              </tr>
              <tr style="border-bottom:1px solid black !important">
                <td>Lain-Lain</td>
                <td>: <span class="lph_w_ll">5</span> </td>
                <td style="float:right">Menit</td>
              </tr>
              <tr >
                <td> <b>Standar Waktu Efektif Seksi</b> </td>
                <td>: <span class="lph_w_standar_efk">..</span> </td>
                <td style="float:right">Menit</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-5">
    <div class="box box-primary box-solid" style="height:305px">
      <div class="box-header" style="padding:5px !important">
        <b>Pengawas & Operator</b>
      </div>
      <div class="box-body" style="padding-top:60px">
        <div class="form-group">
          <label for="">Cari Pekerja</label>
          <select class="lphgetEmployee" name=""  style="width:100%">
            <option value="<?php echo $get[0]['no_induk'] ?>"><?php echo $get[0]['nama_operator'] ?> - <?php echo $get[0]['no_induk'] ?></option>
          </select>
        </div>
        <div class="form-group">
          <label for="">Cari Pengawas</label>
          <select class="lphgetEmployee" name=""  style="width:100%">

          </select>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row pt-2">
  <div class="col-md-6">
    <div class="box box-primary box-solid">
      <div class="box-header" style="padding:5px !important">
        <b>Pengurangan Waktu Efektif</b>
      </div>
      <div class="box-body">
        <div class="form-group">
          <form id="lph_form_pwe" action="index.html" method="post">
            <div class="row">
              <div class="col-sm-5">
                <label for="">Faktor</label>
                <input type="text" class="form-control lph_pwe_faktor" required name="" value="">
              </div>
              <div class="col-sm-7">
                <label for="">Menit</label>
                <div class="row">
                  <div class="col-sm-7">
                    <input type="text" class="form-control lph_pwe_waktu" required name="" value="">
                  </div>
                  <div class="col-sm-5">
                    <button type="submit" class="btn btn-primary" style="width:100%" name="button"> <i class="fa fa-download"></i> Tambah </button>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <div class="mt-4" style="overflow-y:scroll;height:164px;">
            <table class="table table-bordered" style="width:100%;">
              <thead class="bg-primary">
                <tr>
                  <td style="width:30%">Faktor</td>
                  <td>Menit</td>
                </tr>
              </thead>
              <tbody id="lph_pwe_area">

              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-primary box-solid" style="height:305px">
      <div class="box-header" style="padding:5px !important">
        <b>Operator Tanpa Target</b>
      </div>
      <div class="box-body" style="padding-top:37px">
        <div class="form-group">
          <label for="">Jenis</label>
          <select class="select2" name=""  style="width:100%">
            <option value="OTT">OTT</option>
            <option value="IK">IK</option>
          </select>
         </div>
         <div class="form-group">
           <label for="">Keterangan</label>
           <textarea name="name" class="form-control" rows="4" style="width:100%"></textarea>
         </div>
      </div>
    </div>
  </div>
</div>
<div class="row pt-2">
  <div class="col-md-12">
    <div class="box box-primary box-solid">
      <div class="box-header" style="padding:5px !important">
        <b>Hasil Produksi</b>
      </div>
      <div class="box-body">
        <div class="row">
        <div class="col-md-12">
          <div class="mt-4" style="overflow-y:scroll;">
            <table class="table table-bordered" style="width:2300px;text-align:center">
              <thead class="bg-primary">
                <tr>
                  <td style="width:30px">No</td>
                  <td style="width:200px">Kode Part</td>
                  <td style="width:270px">Nama Part</td>
                  <td style="width:200px">Alat Bantu</td>
                  <td style="width:130px">Kode Mesin</td>
                  <td style="width:200px">Kode Proses</td>
                  <td style="width:200px">Nama Proses</td>
                  <td style="width:100px">Target PE</td>
                  <td style="width:100px">Target <span class="lph_jenis_target"></span></td>
                  <td style="width:100px">T.100%</td>
                  <td style="width:100px">Aktual</td>
                  <td style="width:100px">%TASE</td>
                  <td style="width:100px">Hasil Baik</td>
                  <td style="width:100px">Repair Man</td>
                  <td style="width:100px">Repair Mat</td>
                  <td style="width:100px">Repair Mach</td>
                  <td style="width:100px">Scrap Man</td>
                  <td style="width:100px">Scrap Mat</td>
                  <td style="width:100px">Scrap Mach</td>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($get as $key => $value): ?>
                  <tr>
                    <td><?php echo $key+1 ?></td>
                    <td><input type="text" class="form-control"  name="kodepart[]" value="<?php echo $value['kode_komponen'] ?>"></td>
                    <td><input type="text" class="form-control"  name="namapart[]" value="<?php echo $value['nama_komponen'] ?>"></td>
                    <td>
                      <select class="select2" name="alatbantu[]" style="width:100%"></select>
                    </td>
                    <td><input type="text" class="form-control"  name="kodemesin[]" value="<?php echo $value['kode_mesin'] ?>"></td>
                    <td>
                      <select class="select2" name="kodeproses[]" style="width:100%"></select>
                    </td>
                    <td><input type="text" class="form-control"  name="namaproses[]" value="<?php echo $value['proses'] ?>"></td>
                    <td><input type="text" class="form-control"  name="targetpe[]" value=""></td>
                    <?php
                      if ($value['hari'] == ('Jumat' || 'Sabtu')) {
                        $target_harian = $value['target_js'];
                      }else {
                        $target_harian = $value['target_sk'];
                      }
                    ?>
                    <td><input type="text" class="form-control"  name="target_harian[]" value="<?php echo $target_harian ?>"></td>
                    <td><input type="text" class="form-control"  name="" value=""></td>
                    <td><input type="text" class="form-control"  name="" value=""></td>
                    <td><input type="text" class="form-control"  name="" value=""></td>
                    <td><input type="text" class="form-control"  name="" value=""></td>
                    <td><input type="text" class="form-control"  name="" value=""></td>
                    <td><input type="text" class="form-control"  name="" value=""></td>
                    <td><input type="text" class="form-control"  name="" value=""></td>
                    <td><input type="text" class="form-control"  name="" value=""></td>
                    <td><input type="text" class="form-control"  name="" value=""></td>
                    <td><input type="text" class="form-control"  name="" value=""></td>
                  </tr>
                <?php endforeach; ?>

              </tbody>
            </table>
          </div>
          <table style="width:60%;margin-top:20px;margin-bottom: 20px;float:right">
            <tr>
              <td style="width:70px"> <b>Total</b> </td>
              <td>:</td>
              <td><center><input type="text" class="form-control" readonly style="width:80%" name="" value=""></center> </td>
              <td style="width:70px"> <b>Kurang</b> </td>
              <td>:</td>
              <td><center><input type="text" class="form-control" readonly style="width:80%" name="" value=""></center> </td>
            </tr>
          </table>
        </div>
      </div>

        </div>
      </div>
    </div>
    <div class="col-md-12">
      <center> <button type="button" class="btn btn-primary mb-4 mt-2" name="button" style="width:20%;font-weight:bold"> <i class="fa fa-save"></i> Save</button> </center>
    </div>
  </div>

<script type="text/javascript">

  function set_set() {
    return new Promise((resolve, reject) =>{
      $('.select2').select2();
      resolve(1)
    })
  }

  function set_waktu_kerja() {
    return new Promise((resolve, reject) =>{
      let t = $('.lph_tdl_add').val().split('-');
      let d = new Date(`${t[2]}-${t[1]}-${t[0]}`);
      var weekday = new Array(7);
      weekday[0] = "Sunday";
      weekday[1] = "Monday";
      weekday[2] = "Tuesday";
      weekday[3] = "Wednesday";
      weekday[4] = "Thursday";
      weekday[5] = "Friday";
      weekday[6] = "Saturday";
      var n = weekday[d.getDay()];
      let menit, standar
      if (n == 'Friday' || n == 'Saturday') {
        menit = 360;
        standar = 330;
        $('.lph_jenis_target').text('J-S');
      }else {
        menit = 420;
        standar = 390;
        $('.lph_jenis_target').text('S-K');
      }
      $('.lph_waktu_kerja').text(menit);
      $('.lph_w_standar_efk').text(standar);
      resolve(1)
    })
  }

  async function run() {
    let set = await set_set();
    let set_wk = await set_waktu_kerja();
  }

  $(function() {
    run();
  })

  $('.lphgetEmployee').select2({
    minimumInputLength: 2,
    placeholder: "Employee",
    ajax: {
      url: baseurl + "PengirimanBarangInternal/Input/employee",
      dataType: "JSON",
      type: "POST",
      data: function(params) {
        return {
          term: params.term
        };
      },
      processResults: function(data) {
        return {
          results: $.map(data, function(obj) {
            return {
              id: obj.employee_code,
              text: `${obj.employee_name} - ${obj.employee_code}`
            }
          })
        }
      }
    }
  })
</script>
