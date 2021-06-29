<style media="screen">
  .select2-selection__rendered{
    height: 80px;
    overflow-y: auto !important;
  }
</style>
<button type="button" class="btn btn-primary" name="button" onclick="lph_add_row_hasil_produksi()" style="position:fixed;bottom:9%;right: 3.8%;border-radius: 50%;z-index: 9999;height: 37px;"> <b class="fa fa-plus-square"></b> </button>

<form id="submit_form_lkh_add" action="index.html" method="post">
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
              <select class="lph_shift_dinamis_v2" name="shift"  style="width:100%">
                <option value="<?php echo $get[0]['shift'] ?> - <?php echo $get[0]['shift_description'] ?>"><?php echo $get[0]['shift'] ?> - <?php echo $get[0]['shift_description'] ?></option>
              </select>
            </div>
            <div class="form-group">
              <label for="">Kelompok</label>
              <input type="text" class="form-control" name="kelompok" value="">
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
                <td>: <span class="lph_w_standar_efk">..</span>
                  <input type="hidden" name="standar_waktu_efektif" value="">
                </td>
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
      <div class="box-body" style="padding-top:30px">
        <div class="form-group lph_operator" >
          <label for="">Cari Pekerja</label>
          <select class="lphgetEmployee_form" name="operator[]" required style="width:100%" multiple>
            <option value="<?php echo $get[0]['nama_operator'] ?> - <?php echo $get[0]['no_induk'] ?>" selected><?php echo $get[0]['nama_operator'] ?> - <?php echo $get[0]['no_induk'] ?></option>
          </select>
        </div>
        <div class="form-group">
          <label for="">Cari Pengawas</label>
          <select class="lphgetEmployee_form" name="pengawas" required style="width:100%">

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
          <!-- <form id="lph_form_pwe" action="index.html" method="post"> -->
            <div class="row">
              <div class="col-sm-5">
                <label for="">Faktor</label>
                <select class="lph_select2 lph_pwe_faktor" name="" style="width:100%">
                  <option value="">Pilih..</option>
                  <option value="5S">5S</option>
                  <option value="TUNGGU MAT">TUNGGU MAT</option>
                  <option value="TUNGGU KRJ">TUNGGU KRJ</option>
                  <option value="MATI LISTRIK">MATI LISTRIK</option>
                  <option value="AMBIL MAT">AMBIL MAT</option>
                  <option value="BRIEFING">BRIEFING</option>
                  <option value="MESIN RUSAK">MESIN RUSAK</option>
                  <option value="STOP-CALL-WAIT">STOP-CALL-WAIT</option>
                  <option value="CARI MAT">CARI MAT</option>
                  <option value="CARI AFVAL">CARI AFVAL</option>
                  <option value="HANDLING">HANDLING</option>
                </select>
              </div>
              <div class="col-sm-7">
                <label for="">Menit</label>
                <div class="row">
                  <div class="col-sm-7">
                    <input type="number" class="form-control lph_pwe_waktu" value="">
                  </div>
                  <div class="col-sm-5">
                    <button type="button" id="lph_form_pwe" class="btn btn-primary" style="width:100%" name="button"> <i class="fa fa-download"></i> Tambah </button>
                  </div>
                </div>
              </div>
            </div>
          <!-- </form> -->
          <div class="mt-4 mb-3" style="overflow-y:scroll;height:164px;border-bottom:1px solid #337ab7;">
            <table class="table table-bordered" style="width:100%;">
              <thead class="bg-primary">
                <tr>
                  <td style="width:50%">Faktor</td>
                  <td>Menit</td>
                  <td style="width:10%"> </td>
                </tr>
              </thead>
              <tbody id="lph_pwe_area">

              </tbody>
            </table>
          </div>
          <div class="row">
            <div class="col-md-6">
              <b>Total Waktu : <span class="total_waktu_pengurangan" style="color:#337ab7"></span> </b>
              <input type="hidden" name="total_waktu_pwe" value="">
            </div>
            <div class="col-md-6">
              <b>Persentase : <span class="persentase_waktu_pengurangan" style="color:#337ab7"></span> </b>
              <input type="hidden" name="persentase_waktu_pwe" value="">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-primary box-solid" style="height:335px">
      <div class="box-header" style="padding:5px !important">
        <b>Operator Tanpa Target</b>
      </div>
      <div class="box-body" style="padding-top:37px">
        <div class="form-group">
          <label for="">Jenis</label>
          <select class="lph_select2" name="ott_jenis"  style="width:100%">
            <option value="">Tidak Ada</option>
            <option value="OTT">OTT</option>
            <option value="IK">IK</option>
          </select>
         </div>
         <div class="form-group">
           <label for="">Keterangan</label>
           <textarea name="ott_keterangan" class="form-control" rows="6" style="width:100%"></textarea>
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
            <table class="table table-bordered tbl_lph_add_comp" style="width:2430px;text-align:center">
              <thead class="bg-primary">
                <tr>
                  <td style="width:30px">No</td>
                  <td style="width:200px">Kode Part</td>
                  <td style="width:270px">Nama Part</td>
                  <td style="width:200px">Alat Bantu</td>
                  <td style="width:130px">Kode Mesin</td>
                  <td style="width:100px">Wkt. Mesin</td>
                  <td style="width:200px">Kode Proses</td>
                  <td style="width:200px">Nama Proses</td>
                  <td style="width:100px">Target PPIC</td>
                  <td style="width:100px">Target <span class="lph_jenis_target"></span></td>
                  <!-- <td style="width:100px">T.100%</td> -->
                  <td style="width:100px">Aktual</td>
                  <td style="width:100px">%TASE</td>
                  <td style="width:100px">Hasil Baik</td>
                  <td style="width:100px">Repair Man</td>
                  <td style="width:100px">Repair Mat</td>
                  <td style="width:100px">Repair Mach</td>
                  <td style="width:100px">Scrap Man</td>
                  <td style="width:100px">Scrap Mat</td>
                  <td style="width:100px">Scrap Mach</td>
                  <td style="width:30px"></td>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($get as $key => $value): ?>
                  <tr>
                    <td><?php echo $key+1 ?></td>
                    <td>
                      <select class="lph_kodepart" name="kodepart[]" required style="width:182px">
                       <option value="<?php echo $value['kode_komponen'] ?>" selected><?php echo $value['kode_komponen'] ?></option>
                      </select>
                    </td>
                    <td><input type="text" class="form-control" name="namapart[]" readonly value="<?php echo $value['nama_komponen'] ?>"></td>
                    <td>
                      <select class="LphAlatBantu" name="alatbantu[]" style="width:200px">
                        <option value="" selected></option>
                      </select>
                    </td>
                    <td><input type="text" class="form-control"  name="kodemesin[]" value="<?php echo str_replace(' ','',$value['kode_mesin']) ?>"></td>
                    <td><input type="text" class="form-control"  name="waktumesin[]" value=""></td>
                    <td class="lph_kode_proses_trigger_khusus">
                      <select class="lph_select2 lph_kode_proses" name="kodeproses[]" style="width:182px">
                        <option value="" selected></option>
                      </select>
                    </td>
                    <td><input type="text" class="form-control"  name="namaproses[]" required value="<?php echo $value['proses'] ?>"></td>
                    <td><input type="number" class="form-control"  name="target_ppic[]" required value="<?php echo $value['plan'] ?>"></td>
                    <?php
                      if ($value['hari'] == ('Jumat' || 'Sabtu')) {
                        $target_harian = $value['target_js'];
                      }else {
                        $target_harian = $value['target_sk'];
                      }
                    ?>
                    <td>
                      <input type="text" class="form-control lph_target_harian" name="target_harian[]" required readonly value="<?php echo $target_harian ?>">
                      <input type="hidden" name="target_harian_sk[]" value="<?php echo $value['target_sk'] ?>">
                      <input type="hidden" name="target_harian_js[]" value="<?php echo $value['target_js'] ?>">
                      <input type="hidden" name="rko_id[]" value="<?php echo $value['id'] ?>">
                    </td>
                    <!-- <td><input type="text" class="form-control" name="target_seratus_persen[]" readonly value="<?php //echo $target_harian ?>"></td> -->
                    <td><input type="number" class="form-control lph_aktual" <?php echo is_numeric($target_harian) ? 'required' : '' ?> name="aktual[]" value=""></td>
                    <td><input type="text" class="form-control lph_persentase" name="persentase[]" value="" readonly></td>
                    <td><input type="number" class="form-control lph_hasil_baik" name="hasil_baik[]" value=""></td>
                    <td><input type="number" class="form-control" name="repair_man[]" value=""></td>
                    <td><input type="number" class="form-control" name="repair_mat[]" value=""></td>
                    <td><input type="number" class="form-control" name="repair_mach[]" value=""></td>
                    <td><input type="number" class="form-control" name="scrap_man[]" value=""></td>
                    <td><input type="number" class="form-control" name="scrap_mat[]" value=""></td>
                    <td><input type="number" class="form-control" name="scrap_mach[]" value=""></td>
                    <td><button class="btn btn-sm" onclick="min_elem_hasil_produksi(this)"><i class="fa fa-times"></i></button></td>
                  </tr>
                <?php endforeach; ?>

              </tbody>
            </table>
          </div>
          <table style="width:60%;margin-top:20px;margin-bottom: 20px;float:right">
            <tr>
              <td style="width:70px"> <b>Total</b> </td>
              <td>:</td>
              <td><center><input type="text" class="form-control lph_total" readonly style="width:80%" name="total" value=""></center> </td>
              <td style="width:70px"> <b>Kurang</b> </td>
              <td>:</td>
              <td><center><input type="text" class="form-control lph_kurang" readonly style="width:80%" name="kurang" value=""></center> </td>
            </tr>
          </table>
        </div>
      </div>

        </div>
      </div>
    </div>
    <div class="col-md-12">
      <center> <button type="submit" class="btn btn-primary mb-4 mt-2" name="button" style="width:20%;font-weight:bold"> <i class="fa fa-save"></i> Save</button> </center>
    </div>
  </div>
</form>
<script type="text/javascript">

function itungitung() {
  //pwe
  let pengurangan_waktu_efektif = 0;
  $('.menit_pwe').each((index, item) => {
    pengurangan_waktu_efektif += Number($(item).val());
  });
  let total_pwe = pengurangan_waktu_efektif;
  pengurangan_waktu_efektif = (pengurangan_waktu_efektif/Number($('.lph_w_standar_efk').text()))*100;

  // persentase pwe dan total print
  $('.total_waktu_pengurangan').text(total_pwe);
  $('input[name="total_waktu_pwe"]').val(total_pwe);
  $('.persentase_waktu_pengurangan').text(`${(Number(pengurangan_waktu_efektif)).toFixed(2)}%`);
  $('input[name="persentase_waktu_pwe"]').val(`${(Number(pengurangan_waktu_efektif)).toFixed(2)}%`)
  //total
  let total = 0;
  $('.lph_persentase').each((index, item)=>{
    total += Number($(item).val().replace('%',''));
    total_master =(Number(total)+Number(pengurangan_waktu_efektif));
    $('.lph_total').val(`${total_master.toFixed(2)}%`);
    $('.lph_kurang').val(`${(100-Number(total_master)).toFixed(2)}%`);
  });
}

function lph_kodepart(e) {
  let ambil_desc = $(e).select2('data')[0].text.split(' ~ ');
  if (ambil_desc != '') {
    $(e).parent().parent('tr').find('input[name="namapart[]"]').val(ambil_desc[1]);
  }

  $(e).parent().parent('tr').find('input[name="namaproses[]"]').val('');
  $(e).parent().parent('tr').find('input[name="target_harian_js[]"]').val('');
  $(e).parent().parent('tr').find('input[name="target_harian_sk[]"]').val('');
  $(e).parent().parent('tr').find('.lph_target_harian').val('');
  $(e).parent().parent('tr').find('.lph_kode_proses').html('<option value="" selected></option>').trigger('change');

  if (ambil_desc[0] != '') {
    $.ajax({
      url: baseurl + 'LaporanProduksiHarian/action/get_pe',
      type: 'POST',
      data : {
        kode_komponen : ambil_desc[0]
      },
      dataType: "JSON",
      beforeSend: function() {
        toastLPHLoading('Sedang Mengambil Target PE...');
      },
      success: function(result) {
        if (result != 500) {
          toastLPH('success', 'Silahkan memilih kode proses');
          $(e).parent().parent('tr').find('.lph_kode_proses').html(result);
        }else {
          toastLPH('warning', `Komponen ${ambil_desc[0]} tidak memiliki target PE (SK/JS)`);
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        swaLPHLarge('error', 'Terjadi kesalahan');
       console.error();
      }
    })
  }

}

function lph_aktual(e) {
  let target = $(e).parent().parent('tr').find('.lph_target_harian').val();
  let aktual = $(e).val();
  console.log(Number.isInteger(Number(target)), 'tipe number');
  if (aktual != '') {
    if (target == '' || !Number.isInteger(Number(target))) {
      swaLPHLarge('info',`Target ${$('.lph_jenis_target').text()} tidak boleh kosong`);
      $(e).parent().parent('tr').find('.lph_persentase').val('');
      $(e).parent().parent('tr').find('.lph_hasil_baik').val('');
      $(e).val('');
      $(e).attr('required', false);
    }else {
      let persentase = ((Number(aktual)/Number(target))*100).toFixed(2)+'%';
      $(e).parent().parent('tr').find('.lph_persentase').val(persentase);
      $(e).parent().parent('tr').find('.lph_hasil_baik').val(aktual);
    }
  }else {
    $(e).parent().parent('tr').find('.lph_persentase').val('');
    $(e).parent().parent('tr').find('.lph_hasil_baik').val('');
  }
  itungitung();
}

function fun_lphkodeproses(e) {
  let val = $(e).val().split(' ~ ');

  let ambil_kode_part = $('.lph_kodepart');
  let kode_proses = $('.lph_kode_proses');
  let my_index = Number($(e).parent().parent('tr').find('td:first').text()) - 1;
  let kodepart_elemen = $(e).parent().parent('tr').find('.lph_kodepart').val();
  let nama_proses_elemen = val[1];
  let cek = 0;

  ambil_kode_part.each((i,v)=>{
    if (i != my_index) {
      let a5ag27 = $(kode_proses[i]).val().split(' ~ ')[1];
      let h83h = $(v).val();
      if (nama_proses_elemen == a5ag27 && kodepart_elemen == h83h) {
        cek = 1;
      }
    }
  });

  if (cek) {
    Swal.fire({
      allowOutsideClick: true,
      type: 'warning',
      showConfirmButton: 'Ok!',
      html: `Kode part <b>${kodepart_elemen}</b> dengan proses <b>${nama_proses_elemen}</b> telah ada!`,
    }).then(function(isConfirm) {
      if (isConfirm) {
        console.log('done');
        $(e).parent().parent('tr').find('.lph_kodepart').val('').trigger('change');
        $(e).parent().parent('tr').find('input[name="namapart[]"]').val('');
      }
      cek = 0;
    })
  }

  console.log(val, 'ini data PE');
  $(e).parent().parent('tr').find('input[name="namaproses[]"]').val(val[1]);
  $(e).parent().parent('tr').find('input[name="target_harian_js[]"]').val(val[3]);
  $(e).parent().parent('tr').find('input[name="target_harian_sk[]"]').val(val[2]);
  if ($('.lph_jenis_target').text() == 'J-S') {
    $(e).parent().parent('tr').find('.lph_target_harian').val(val[3]);
  }else {
    $(e).parent().parent('tr').find('.lph_target_harian').val(val[2]);
  }


}

function lph_add_row_hasil_produksi() {
  let no = Number($('.tbl_lph_add_comp tbody tr').length)+1;
  $('.tbl_lph_add_comp tbody').append(`<tr>
                                        <td>${no}</td>
                                        <td>
                                          <select class="lph_kodepart" name="kodepart[]" required style="width:182px">
                                           <option value="" selected></option>
                                          </select>
                                        </td>
                                        <td><input type="text" class="form-control" readonly name="namapart[]" value=""></td>
                                        <td>
                                          <select class="LphAlatBantu" name="alatbantu[]" style="width:200px">
                                           <option value="" selected></option>
                                          </select>
                                        </td>
                                        <td><input type="text" class="form-control" required name="kodemesin[]" value=""></td>
                                        <td><input type="text" class="form-control" name="waktumesin[]" value=""></td>
                                        <td>
                                          <select class="lph_select2 lph_kode_proses" name="kodeproses[]" style="width:182px">
                                            <option value="" selected></option>
                                          </select>
                                        </td>
                                        <td><input type="text" class="form-control" required name="namaproses[]" value=""></td>
                                        <td><input type="number" class="form-control" required name="target_ppic[]" value=""></td>
                                        <td>
                                         <input type="text" class="form-control lph_target_harian" name="target_harian[]" required readonly value="">
                                         <input type="hidden" name="target_harian_sk[]" value="">
                                         <input type="hidden" name="target_harian_js[]" value="">
                                         <input type="hidden" name="rko_id[]" value="">
                                        </td>
                                        <td><input type="number" class="form-control lph_aktual" required name="aktual[]" value=""></td>
                                        <td><input type="text" class="form-control lph_persentase" name="persentase[]" value="" readonly></td>
                                        <td><input type="number" class="form-control lph_hasil_baik" name="hasil_baik[]" value=""></td>
                                        <td><input type="number" class="form-control" name="repair_man[]" value=""></td>
                                        <td><input type="number" class="form-control" name="repair_mat[]" value=""></td>
                                        <td><input type="number" class="form-control" name="repair_mach[]" value=""></td>
                                        <td><input type="number" class="form-control" name="scrap_man[]" value=""></td>
                                        <td><input type="number" class="form-control" name="scrap_mat[]" value=""></td>
                                        <td><input type="number" class="form-control" name="scrap_mach[]" value=""></td>
                                        <td><button class="btn btn-sm" onclick="min_elem_hasil_produksi(this)"><i class="fa fa-times"></i></button></td>
                                      </tr>`);
    $(".LphAlatBantu").select2({
      minimumInputLength: 3,
      maximumSelectionLength: 3,
      ajax: {
        url: baseurl + 'LaporanProduksiHarian/action/AlatBantu/',
        dataType: 'json',
        type: "POST",
        data: function(params) {
          var queryParameters = {
            ab: params.term,
            alatBantu: $('#txtAlatBantu').val()
          }
          return queryParameters;
        },
        processResults: function(alatBantu) {
          return {
            results: $.map(alatBantu, function(obj) {
              return {
                id: obj.fs_nm_tool + ' - '+obj.fs_no_tool,
                text: obj.fs_nm_tool + ' - '+obj.fs_no_tool
              };
            })
          };
        }
      }
    });

    $('.lph_select2').select2({
      tags: true,
      // allowClear:true,
    });
    $(".lph_kodepart").select2({
      minimumInputLength: 3,
      // maximumSelectionLength: 1,
      ajax: {
        url: baseurl + 'LaporanProduksiHarian/action/kodePart/',
        dataType: 'json',
        type: "GET",
        data: function(params) {
          var queryParameters = {
            variable: params.term,
            kode: $('.lph_kodepart').val(),
            type_product: ''
          }
          return queryParameters;
        },
        processResults: function(kode) {
          return {
            results: $.map(kode, function(obj) {
              if (kode !== null) {
                return {
                  id: obj.SEGMENT1,
                  text: obj.SEGMENT1 +' ~ '+ obj.DESCRIPTION
                };
              } else {
                $('.namaPart').val('');
              }
            })
          };
        }
      }
    });

    $(".lph_kodepart").on('change', function() {
      lph_kodepart(this);
    })

    $('.lph_aktual').on('input', function() {
      lph_aktual(this)
    })

    $('.lph_kode_proses').on('change', function() {
      fun_lphkodeproses(this);
    })

  }

  // batas ++++++++++++++++++++++++++++++ batas ++++++++++++++++++++
  $('.lph_kode_proses').on('change', function() {
    fun_lphkodeproses(this);
  })

  $(".lph_kodepart").on('change', function() {
    lph_kodepart(this);
  })

  $('.lph_aktual').on('input', function() {
    lph_aktual(this)
  })

  function min_elem_pwe(th) {
    $(th).parent().parent('tr').remove();
    itungitung();
  }

  function min_elem_hasil_produksi(th) {
    $(th).parent().parent('tr').remove();
    itungitung();
  }

  $('#lph_form_pwe').on('click', function(e) {
    // e.preventDefault();
    if ($('.lph_pwe_faktor').val() != '' && $('.lph_pwe_waktu').val() != '') {
      $('#lph_pwe_area').append(`<tr>
                                  <td><input type="text" class="form-control" name="faktor_pwe[]" value="${$('.lph_pwe_faktor').val()}: ${$('.lph_pwe_waktu').val()}"></td>
                                  <td><input type="number" class="form-control menit_pwe" name="menit_pwe[]" value="${$('.lph_pwe_waktu').val()}"></td>
                                  <td> <button class="btn btn-sm" onclick="min_elem_pwe(this)"><i class="fa fa-times"></i></button></td>
                                </tr>`);
      itungitung();
      $('.menit_pwe').on('input', function() {
        itungitung();
      })
      $('.lph_pwe_faktor').val('');
      $('.lph_pwe_waktu').val('');
    }else {
      swaLPHLarge('warning', 'Form input faktor dan menit tidak boleh kosong !');
    }

  })

  // di non aktifkan karena di chrome user versi lama tidak jalan
  // function set_set() {
  //   return new Promise((resolve, reject) =>{
  //     resolve(1)
  //   })
  // }
  //
  // function set_waktu_kerja() {
  //   return new Promise((resolve, reject) =>{
  //     resolve(1)
  //   })
  // }
  //
  // async function run() {
  //   let set = await set_set();
  //   let set_wk = await set_waktu_kerja();
  // }

  $(function() {
    // run();
    $('.lph_select2').select2({
      tags: true,
    });
    $('.lph_shift_dinamis_v2').select2();
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
    $('input[name="standar_waktu_efektif"]').val(standar)

    $(".LphAlatBantu").select2({
      minimumInputLength: 3,
      maximumSelectionLength: 3,
      ajax: {
        url: baseurl + 'LaporanProduksiHarian/action/AlatBantu/',
        dataType: 'json',
        type: "POST",
        data: function(params) {
          var queryParameters = {
            ab: params.term,
            alatBantu: $('#txtAlatBantu').val()
          }
          return queryParameters;
        },
        processResults: function(alatBantu) {
          return {
            results: $.map(alatBantu, function(obj) {
              return {
                id: obj.fs_nm_tool + ' - '+obj.fs_no_tool,
                text: obj.fs_nm_tool + ' - '+obj.fs_no_tool
              };
            })
          };
        }
      }
    });
    $(".LphTanggal").daterangepicker({
      singleDatePicker: true,
      timePicker: false,
      autoclose: true,
      locale: {
        format: "DD-MM-YYYY",
      },
    });

    $(".lph_kodepart").select2({
      minimumInputLength: 3,
      // maximumSelectionLength: 1,
      ajax: {
        url: baseurl + 'LaporanProduksiHarian/action/kodePart/',
        dataType: 'json',
        type: "GET",
        data: function(params) {
          var queryParameters = {
            variable: params.term,
            kode: $('.lph_kodepart').val(),
            type_product: ''
          }
          return queryParameters;
        },
        processResults: function(kode) {
          return {
            results: $.map(kode, function(obj) {
              if (kode !== null) {
                return {
                  id: obj.SEGMENT1,
                  text: obj.SEGMENT1 +' ~ '+ obj.DESCRIPTION
                };
              } else {
                $('.namaPart').val('');
              }
            })
          };
        }
      }
    });
  })

  $('.lph_tdl_add').on('change', function() {
    let t = $(this).val().split('-');
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

    $.ajax({
      url: baseurl + 'LaporanProduksiHarian/action/getShift',
      type: 'POST',
      dataType: 'JSON',
      data: {
        tanggal : $(this).val(),
      },
      cache:false,
      beforeSend: function() {
        toastLPHLoading('Sedang Mengambil Shift...');
        $('.lph_shift_dinamis_v2').val('').trigger('change');
      },
      success: function(result) {
        // console.log(result);
        if (result != 0) {
          toastLPH('success', 'Selesai.');
          $('.lph_shift_dinamis_v2').html(result);
        }else {
          toastLPH('warning', 'koneksi terputus, coba lagi nanti');
          $('.lph_shift_dinamis_v2').html('');
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
      swaLPHLarge('error', textStatus)
       console.error();
      }
    })
  })

  $('.lphgetEmployee_form').select2({
    minimumInputLength: 3,
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
              id: `${obj.employee_name} - ${obj.employee_code}`,
              text: `${obj.employee_name} - ${obj.employee_code}`
            }
          })
        }
      }
    }
  })

  $('.lph_kode_proses_trigger_khusus').on('click', function() {
    let ambil_kode_part = $(this).parent('tr').find('.lph_kodepart').val();
    let elemen = $(this)[0];
    let selected = $(elemen).find('.lph_kode_proses').select2('data')[0].text;
    console.log(selected);
    if (selected == '') {
      $.ajax({
        url: baseurl + 'LaporanProduksiHarian/action/get_pe',
        type: 'POST',
        data : {
          kode_komponen : ambil_kode_part
        },
        dataType: "JSON",
        beforeSend: function() {
          toastLPHLoading('Sedang Mengambil Target PE...');
        },
        success: function(result) {
          if (result != 500) {
            toastLPH('success', 'Silahkan memilih kode proses');
            $(elemen).find('.lph_kode_proses').html(result).trigger('click');
          }else {
            toastLPH('warning', `Komponen ${ambil_kode_part} tidak memiliki target PE (SK/JS)`);
          }
          $(elemen).off('click')
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          swaLPHLarge('error', 'Terjadi kesalahan');
         console.error();
        }
      })
    }

    // alert(`kode part saya ${ambil_kode_part}`)
  })

  //input form
  $('#submit_form_lkh_add').on('submit', function(e) {
    e.preventDefault();
    let form_data  = new FormData($(this)[0]);
    $.ajax({
      url: baseurl + 'LaporanProduksiHarian/action/insert',
      type: 'POST',
      data : form_data,
      contentType: false,
      cache: false,
      // async:false,
      processData: false,
      dataType: "JSON",
      beforeSend: function() {
        swaLPHLoading('Sedang memproses data...');
      },
      success: function(result) {
        swaLPHLarge(result.type, result.message);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        swaLPHLarge('error', 'Terjadi kesalahan');
       console.error();
      }
    }).then(function(result) {
        setTimeout(function () {
          if (result.type == 'success') {
            lph_empty_form();
          }
        }, 347);
    })
  });

</script>
