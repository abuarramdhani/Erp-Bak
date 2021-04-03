const swalTCTLarge = (type, a) =>{
  Swal.fire({
    allowOutsideClick: true,
    type: type,
    cancelButtonText: 'Ok!',
    html: a,
    // onBeforeOpen: () => {
    // Swal.showLoading()
    // }
  })
}

$(document).ready(function () {

$('.select2-tct').select2({
  tags: true,
  allowClear:true,
  minimumInputLength: 3,
  placeholder: "NO BPPBGT",
  ajax: {
    url: baseurl + "TransaksiCuttingTool/Monitoring/getBppbgt",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: function(params) {
      return {
        term: params.term
      };
    },
    processResults: function(data) {
      return {
        results: $.map(data, function(obj) {
          return {
            id: obj.TRANSACTION_SOURCE_NAME,
            text: obj.TRANSACTION_SOURCE_NAME
          }
        })
      }
    }
  }
})

  if ($('#kondisi-tct').val() == "monitoring transaksi bppct") {
    // Hari Tanggal format Indonesia    
    let tanggalq = new Date();
    if (tanggalq.getTimezoneOffset() == 0) (a=tanggalq.getTime() + ( 7 *60*60*1000))
    else (a=tanggalq.getTime());
    tanggalq.setTime(a);
    let tahun_tct= tanggalq.getFullYear ();
    let hari_tct= tanggalq.getDay ();
    let bulan_tct= tanggalq.getMonth ();
    let tanggal_tct= tanggalq.getDate ();
    let hariarray_tct=new Array("Minggu,",
                            "Senin,",
                            "Selasa,",
                            "Rabu,",
                            "Kamis,",
                            "Jum'at,",
                            "Sabtu,");
    let bulanarray_tct=new Array("Januari",
                            "Februari",
                            "Maret",
                            "April",
                            "Mei",
                            "Juni",
                            "Juli",
                            "Agustus",
                            "September",
                            "Oktober",
                            "November",
                            "Desember");
    // document.getElementById("tanggal_server").innerHTML = hariarray[hari]+" "
    //                                                       +tanggal+" "
    //                                                       +bulanarray[bulan]+" "
    //                                                       +tahun;
  $('#tanggal_server').text(hariarray_tct[hari_tct]+" "+tanggal_tct+" "+bulanarray_tct[bulan_tct]+" "+tahun_tct);

    // Jam Aktif
    let serverClock_tct = jQuery("#jam_aktif");
    if (serverClock_tct.length > 0) {
      showServerTime(serverClock_tct, serverClock_tct.text());
    }
  }
  function showServerTime(obj, time) {
    let parts_tct = time.split(":"), newTime = new Date();

    newTime.setHours(parseInt(parts_tct[0], 10));
    newTime.setMinutes(parseInt(parts_tct[1], 10));
    newTime.setSeconds(parseInt(parts_tct[2], 10));

    let timeDifference_tct = new Date().getTime() - newTime.getTime();

    let methods_tct = {
      displayTime: function () {
        let now_tct = new Date(new Date().getTime() - timeDifference_tct);
        obj.text([
          methods_tct.leadZeros(now_tct.getHours(), 2),
          methods_tct.leadZeros(now_tct.getMinutes(), 2),
          methods_tct.leadZeros(now_tct.getSeconds(), 2)
        ].join(":"));
        setTimeout(methods_tct.displayTime, 500);
      },
      leadZeros: function (time, width) {
        while (time.toString().length < width) {
          time = "0" + time;
        }
        return time;
      }
    }
    methods_tct.displayTime();
  }

  // DateRangePicker format Indonesia
  $(".tanggal-TCT").daterangepicker({
    showDropdowns: true,
    autoApply:true,
    locale: {
      format: "DD-MMM-YYYY",
      separator: " - ",
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
      ]
    }
  })
})

$('.select2-tct').on('change', function () {
  let no_bppbgt = $('#no_bppbgt').val();
  if (no_bppbgt != "") {
    $.ajax({
      url: baseurl + 'TransaksiCuttingTool/Monitoring/getSm',
      dataType: 'JSON',
      type: 'POST',
      data: {
        bppbgt: no_bppbgt
      },
      cache: false,
      beforeSend: function() {

      },
      success: function (result) {
        $('#seksi-tct').val(result[0].SEKSI_PENGEBON);
        $('#mesin-tct').val(result[0].NO_MESIN);
        console.log(result);
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
  }else {
    $('#seksi-tct').val("");
    $('#mesin-tct').val("");
  }
})

// $(".tanggal").datepicker({
//     format: 'dd-mm-yyyy',
//     autoclose: true,
//     todayHighlight: true,
// });

  // Fungsi untuk filter
  const filter_tct = () => {
    // Mengambil nilai dari daterangepicker
    // Untuk pemisah antara tanggal 1 dan tanggal 2 ada di model
    const param_tanggal_tct = $('.tanggal-TCT').val();
    // Untuk mengambil nilai dari tiap tiap select
    let no_bppbgt = $('#no_bppbgt').val();
    let seksi = $('#seksi-tct').val();
    let mesin = $('#mesin-tct').val();
    let trans_type = $('#trans_type').val();
  $.ajax({
      url: baseurl + 'TransaksiCuttingTool/Monitoring/getFilter',
       type: 'POST',
       // dataType: 'JSON',
       data: {
         // range_tanggal sebagai variabel untuk mengambil nilai dari daterangepicker
         range_tanggal: param_tanggal_tct,
         no_bppbgt: no_bppbgt,
         seksi: seksi,
         mesin: mesin,
         trans_type: trans_type
       },
      cache:false,
      beforeSend: function() {
        // swalLoadingCKMB('Sedang Memproses Data...');
        $('.area_tct').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                  <img style="width: 13%;" src="${baseurl}assets/img/gif/loading14.gif"><br>
                                  <span style="font-size:15px;font-weight:bold">Sedang memuat data...</span>
                              </div>`);
      },
      success: function(result) {
        if (result != 0 && result != 10) {
          $('.area_tct').html(result);
          $('#atas').text(`Menampilkan data pada rentang tanggal ${param_tanggal_tct}`);
        }else if (result == 10) {
          $('.area_tct').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                  <i class="fa fa-remove" style="color:#d60d00;font-size:45px;"></i><br>
                                  <h3 style="font-size:14px;font-weight:bold">Tidak ada data yang sesuai</h3>
                              </div>`)
        }else {
          toastTCTxc("Warning", "Terdapat Kesalahan saat mengambil data");
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
      swalTCTLarge('error', textStatus)
       console.error();
      }
    })
}
