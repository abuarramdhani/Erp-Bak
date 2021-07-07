const toastLPH = (type, message) => {
  Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  }).fire({
    customClass: 'swal-font-small',
    type: type,
    title: message
  })
}

const toastLPHLoading = (pesan) => {
  Swal.fire({
    toast: true,
    position: 'top-end',
    onBeforeOpen: () => {
       Swal.showLoading();
       $('.swal2-loading').children('button').css({'width': '20px', 'height': '20px'})
     },
    text: pesan
  })
}
const swaLPHLarge = (type, a) =>{
  Swal.fire({
    allowOutsideClick: true,
    type: type,
    showConfirmButton: 'Ok!',
    html: a,
    // onBeforeOpen: () => {
    // Swal.showLoading()
    // }
  })
}
const swaLPHLoading = (a) =>{
  Swal.fire({
    allowOutsideClick: false,
    // type: type,
    // cancelButtonText: 'Ok!',
    html: `<div style="font-weight:400">${a}</div>`,
    onBeforeOpen: () => {
      Swal.showLoading()
    }
  })
}

$('.lph_search').on('submit', function(e) {
  e.preventDefault()
  $.ajax({
    url: baseurl + 'LaporanProduksiHarian/action/getDataRKH',
    type: 'POST',
    // dataType: 'JSON',
    data: {
      range_date: $('.tanggal_lph_99').val(),
      shift: $('.lph_pilih_shift_97').val()
    },
    cache:false,
    beforeSend: function() {
      $('.area-getlph-2021').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                    <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                    <span style="font-size:14px;font-weight:bold">Sedang memuat form input...</span>
                                </div>`);
    },
    success: function(result) {
      $('.area-getlph-2021').html(result)
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swaLPHLarge('error', textStatus)
     console.error();
    }
  })
})

function lph_empty_form() {
  $.ajax({
    url: baseurl + 'LaporanProduksiHarian/action/getEmptyRKH',
    type: 'POST',
    // dataType: 'JSON',
    data: {
    },
    cache:false,
    beforeSend: function() {
      $('.area-lph-2021').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                    <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                    <span style="font-size:14px;font-weight:bold">Sedang memuat form input...</span>
                                </div>`);
    },
    success: function(result) {
      $('.area-lph-2021').html(result)
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swaLPHLarge('error', textStatus)
     console.error();
    }
  })
}

$(document).ready(function () {
  $('.tbl_lph_mon_mesin').dataTable()
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
  $(".LphTanggal").daterangepicker({
    singleDatePicker: true,
    timePicker: false,
    autoclose: true,
    locale: {
      format: "DD-MM-YYYY",
    },
  });
  $(".tanggal_lph_99").daterangepicker(
  {
    showDropdowns: true,
    autoApply: true,
    locale: {
      format: "DD-MM-YYYY",
      separator: " - ",
      applyLabel: "OK",
      cancelLabel: "Batal",
      fromLabel: "Dari",
      toLabel: "Hingga",
      customRangeLabel: "Custom",
      weekLabel: "W",
      daysOfWeek: ["Mg", "Sn", "Sl", "Rb", "Km", "Jm", "Sa"],
      monthNames: [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus ",
        "September",
        "Oktober",
        "November",
        "Desember",
      ],
      firstDay: 1,
    },
  });

if ($('.area-lph-2021').html() != undefined) {
 lph_empty_form();
}

});

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
  }else {
    menit = 420;
    standar = 390;
  }
  $('.lph_waktu_kerja').text(menit);
  $('.lph_w_standar_efk').text(standar);
})

$("#lph_search_rkh").on('submit', function (e) {
  e.preventDefault();
  let tanggal = $('.lph_search_tanggal').val();
  let shift = $('.lph_shift_dinamis').val();
  let no_induk = $('.lph_search_pekerja').val();
  $.ajax({
    url: baseurl + 'LaporanProduksiHarian/action/getRKH',
    type: 'POST',
    // dataType: 'JSON',
    data: {
      tanggal : tanggal,
      shift : shift,
      no_induk : no_induk
    },
    cache:false,
    beforeSend: function() {
      $('.area-lph-2021').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                <span style="font-size:14px;font-weight:bold">Sedang memuat data...</span>
                            </div>`);
    },
    success: function(result) {
      if (result != 'gada' && result != 'uda_ada') {
        toastLPH('success', 'Selesai.')
        $('.area-lph-2021').html(result)
      }else if (result == 'gada') {
        $('.area-lph-2021').html(`<center style="font-weight:bold;margin-bottom:13px;"><i class="fa fa-warning"></i> Data tidak ditemukan</center>`);
      }else if (result == 'uda_ada') {
        $('.area-lph-2021').html(`<center style="margin-bottom:13px;"><i class="fa fa-warning"></i> No induk <b>${no_induk}</b> dengan tanggal <b>${tanggal}</b> dan shift <b>${shift}</b> telah ada di database</center>`);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swaLPHLarge('error', textStatus)
     console.error();
    }
  })
})

$("#lph_search_rkh_mesin").on('submit', function (e) {
  e.preventDefault();
  let tanggal = $('.tanggal_lph_99').val();
  let shift = $('.lph_pilih_shift_97').val();
  $.ajax({
    url: baseurl + 'LaporanProduksiHarian/actiontwo/monPemakaianJamMesin',
    type: 'POST',
    // dataType: 'JSON',
    data: {
      tanggal : tanggal,
      shift : shift,
    },
    cache:false,
    beforeSend: function() {
      $('.area-pemakaian-jam-mesin').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                <span style="font-size:14px;font-weight:bold">Sedang memuat data...</span>
                            </div>`);
    },
    success: function(result) {
      if (result != 'gada' && result != 'uda_ada') {
        toastLPH('success', 'Selesai.')
        $('.area-pemakaian-jam-mesin').html(result)
      }else if (result == 'gada') {
        $('.area-pemakaian-jam-mesin').html(`<center style="font-weight:bold;margin-bottom:13px;"><i class="fa fa-warning"></i> Data tidak ditemukan</center>`);
      }else if (result == 'uda_ada') {
        $('.area-pemakaian-jam-mesin').html(`<center style="margin-bottom:13px;"><i class="fa fa-warning"></i> No induk <b>${no_induk}</b> dengan tanggal <b>${tanggal}</b> dan shift <b>${shift}</b> telah ada di database</center>`);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swaLPHLarge('error', textStatus)
     console.error();
    }
  })
})

function lph_filter_shift(th) {
  $.ajax({
    url: baseurl + 'LaporanProduksiHarian/action/getShift',
    type: 'POST',
    dataType: 'JSON',
    data: {
      tanggal : $(th).val(),
    },
    cache:false,
    beforeSend: function() {
      $('.lph_shift_dinamis').val('').trigger('change');
      toastLPHLoading('Sedang Mengambil Shift...');
    },
    success: function(result) {
      // console.log(result);
      if (result != 0) {
        toastLPH('success', 'Selesai.');
        $('.lph_shift_dinamis').html(result);
      }else {
        toastLPH('warning', 'koneksi terputus, coba lagi nanti');
        $('.lph_shift_dinamis').html('');
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swaLPHLarge('error', textStatus)
     console.error();
    }
  })
}

$(".tanggal_lph_99").on('change', function() {
  let val = $(this).val().split(' - ');
  if (val[0] != val[1]) {
    $('.lph_cetak_rkh').attr('disabled', true);
  }else {
    $('.lph_cetak_rkh').attr('disabled', false);
  }
})

const lphgetmon = () => {
  $.ajax({
    url: baseurl + 'LaporanProduksiHarian/action/getmon',
    type: 'POST',
    // dataType: 'JSON',
    data: {
      range_date : $('.tanggal_lph_99').val(),
      shift : $('.lph_pilih_shift').val(),
    },
    cache:false,
    beforeSend: function() {
      // swalLoadingCKMB('Sedang Memproses Data...');
      $('.area-lph-monitoring').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                <span style="font-size:14px;font-weight:bold">Sedang memuat data...</span>
                            </div>`);
    },
    success: function(result) {
      $('.area-lph-monitoring').html(result);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swaLPHLarge('error', textStatus)
     console.error();
    }
  })

}

$('#form_lph_add_mesin').on('submit', function(e) {
  e.preventDefault()
  swaLPHLarge('info', 'Wait fitur blm siap');
})

function pemakaianjammesin() {
  $.ajax({
    url: baseurl + 'LaporanProduksiHarian/actiontwo/monPemakaianJamMesin',
    type: 'POST',
    // dataType: 'JSON',
    data: {
      tanggal : $('.tanggal_lph_99').val(),
      shift : $('.lph_pilih_shift_97').val(),
    },
    cache:false,
    beforeSend: function() {
      // swalLoadingCKMB('Sedang Memproses Data...');
      $('.area-pemakaian-jam-mesin').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                <span style="font-size:14px;font-weight:bold">Sedang memuat data...</span>
                            </div>`);
    },
    success: function(result) {
      $('.area-pemakaian-jam-mesin').html(result);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swaLPHLarge('error', textStatus)
     console.error();
    }
  })
}


// area setting lph

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
      let jamPerHari = ''
      if ($('.lph_jenis_target').text() == 'J-S') {
        jamPerHari = 6;
      }else {
        jamPerHari = 7;
      }
      $(e).parent().parent('tr').find('.waktu_mesin').val(((aktual/target*1)*jamPerHari).toFixed(2));

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
  let t_pe = '';
  let t_jam = '';
  $(e).parent().parent('tr').find('input[name="namaproses[]"]').val(val[1]);
  $(e).parent().parent('tr').find('input[name="target_harian_js[]"]').val(val[3]);
  $(e).parent().parent('tr').find('input[name="target_harian_sk[]"]').val(val[2]);
  if ($('.lph_jenis_target').text() == 'J-S') {
    $(e).parent().parent('tr').find('.lph_target_harian').val(val[3]);
    t_pe= val[3];
    t_jam = 6;
  }else {
    $(e).parent().parent('tr').find('.lph_target_harian').val(val[2]);
    t_pe = val[2];
    t_jam = 7;
  }

}
