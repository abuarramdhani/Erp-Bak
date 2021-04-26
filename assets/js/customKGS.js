$(document).ready(function () {
    $('#modalPacking').on('shown.bs.modal', function() {
        $(document).off('focusin.modal');
    });

    var checkDO = $('#punyaeSP').val();
    if (checkDO == '1') {
        normal();
    }

    var checkPKG = $('#punyaPacking').val();
    if (checkPKG == '1') {
        packing();
        selesaiPacking();
    }

    var checkCTK = $('#punyaCetakDOSP').val();
    if (checkCTK == '1') {
        cetakDOSP();
        selesaiCetakDOSP();
    }

    var checkMFS = $('#punyaManifest').val();
    if (checkMFS == '1') {
        $(function() {
            $('#inputSPBMan').focus();
        });
        manifest();
        sudah_manifest();
    }


    $("#picfinish").select2({
        allowClear: false,
        placeholder: "Pilih PIC",
        minimumInputLength: 0,
        dropdownParent: $("#mdlfinishplyn"),
        ajax: {
            url: baseurl + "KapasitasGdSparepart/Pelayanan/getPIC",
            dataType: 'json',
            type: "GET",
            data: function (params) {
                var queryParameters = {
                        term: params.term,
                }
                return queryParameters;
            },
            processResults: function (data) {
                // console.log(data);
                return {
                    results: $.map(data, function (obj) {
                        return {id:obj.noind, text:obj.noind + ' - ' + obj.nama};
                    })
                };
            }
        }
    });


    $(".picSPB3").select2({
        allowClear: false,
        placeholder: "",
        minimumInputLength: 0,
        ajax: {
            url: baseurl + "KapasitasGdSparepart/Pengeluaran/getPIC",
            dataType: 'json',
            type: "GET",
            data: function (params) {
                var queryParameters = {
                        term: params.term,
                }
                return queryParameters;
            },
            processResults: function (data) {
                // console.log(data);
                return {
                    results: $.map(data, function (obj) {
                        return {id:obj.noind, text:obj.noind + ' - ' + obj.nama};
                    })
                };
            }
        }
    });


    $(".eksped").select2({
        allowClear: false,
        placeholder: "Pilih Ekspedisi",
        minimumInputLength: 0,
        ajax: {
            url: baseurl + "KapasitasGdSparepart/Penyerahan/getEkspedisi",
            dataType: 'json',
            type: "GET",
            data: function (params) {
                var queryParameters = {
                        term: params.term,
                }
                return queryParameters;
            },
            processResults: function (data) {
                console.log(data);
                return {
                    results: $.map(data, function (obj) {
                        return {id:obj.EKSPEDISI, text:obj.EKSPEDISI};
                    })
                };
            }
        }
      });
});


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////// PELAYANAN //////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

var ajax1  = null;
var ajax2  = null;
var ajax3  = null;
var ajax4  = null;
var ajax5  = null;
var ajax6  = null;


function selesai() {
ajax_selesai = $.ajax({
    url: baseurl + 'KapasitasGdSparepart/Pelayanan/getSelesai',
    type: 'POST',
    beforeSend: function() {
      $('#loadingArea5').show();
      $('div.table_area_selesai').hide();
    },
    success: function(result) {
      // console.log(result);
      $('#loadingArea5').hide();
      $('div.table_area_selesai').show();
      $('div.table_area_selesai').html(result);

    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

//------------------------------------------------------------------ TAB PELAYANAN ------------------------------------------------------------------

function normal() {
    if(ajax2 != null) ajax2.abort()
    if(ajax3 != null) ajax3.abort()
    if(ajax4 != null) ajax4.abort()
    if(ajax5 != null) ajax5.abort()
    if(ajax6 != null) ajax6.abort()
ajax1 = $.ajax({
    url: baseurl + 'KapasitasGdSparepart/Pelayanan/getNormal',
    type: 'POST',
    beforeSend: function() {
      $('#loadingArea1').show();
      $('div.table_area_1').hide();
      selesai();
    },
    success: function(result) {
      // console.log(result);
      $('#loadingArea1').hide();
      $('div.table_area_1').show();
      $('div.table_area_1').html(result);
      $('#tipe').val('NORMAL');

    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}


function urgent() {
    if(ajax1 != null) ajax1.abort()
    if(ajax3 != null) ajax3.abort()
    if(ajax4 != null) ajax4.abort()
    if(ajax5 != null) ajax5.abort()
    if(ajax6 != null) ajax6.abort()
    ajax2 = $.ajax({
        url: baseurl + 'KapasitasGdSparepart/Pelayanan/getUrgent',
        type: 'POST',
        beforeSend: function() {
          $('#loadingArea2').show();
          $('div.table_area_2').hide();
          selesai();
        },
        success: function(result) {
          // console.log(result);
          $('#loadingArea2').hide();
          $('div.table_area_2').show();
          $('div.table_area_2').html(result);
          $('#tipe').val('URGENT');

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
    })
}


function eceran() {
    if(ajax2 != null) ajax2.abort()
    if(ajax1 != null) ajax1.abort()
    if(ajax4 != null) ajax4.abort()
    if(ajax5 != null) ajax5.abort()
    if(ajax6 != null) ajax6.abort()
    ajax3 = $.ajax({
        url: baseurl + 'KapasitasGdSparepart/Pelayanan/getEceran',
        type: 'POST',
        beforeSend: function() {
          $('#loadingArea3').show();
          $('div.table_area_3').hide();
          selesai();
        },
        success: function(result) {
          // console.log(result);
          $('#loadingArea3').hide();
          $('div.table_area_3').show();
          $('div.table_area_3').html(result);
          $('#tipe').val('ECERAN');

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
    })
}


function best() {
    if(ajax2 != null) ajax2.abort()
    if(ajax3 != null) ajax3.abort()
    if(ajax1 != null) ajax1.abort()
    if(ajax5 != null) ajax5.abort()
    if(ajax6 != null) ajax6.abort()
    ajax4 = $.ajax({
        url: baseurl + 'KapasitasGdSparepart/Pelayanan/getBest',
        type: 'POST',
        beforeSend: function() {
          $('#loadingArea4').show();
          $('div.table_area_4').hide();
          selesai();
        },
        success: function(result) {
          // console.log(result);
          $('#loadingArea4').hide();
          $('div.table_area_4').show();
          $('div.table_area_4').html(result);
          $('#tipe').val('BEST');

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
    })
}


function ecom() {
    if(ajax2 != null) ajax2.abort()
    if(ajax3 != null) ajax3.abort()
    if(ajax1 != null) ajax1.abort()
    if(ajax5 != null) ajax5.abort()
    if(ajax4 != null) ajax4.abort()
    ajax6 = $.ajax({
        url: baseurl + 'KapasitasGdSparepart/Pelayanan/getEcom',
        type: 'POST',
        beforeSend: function() {
          $('#loadingArea6').show();
          $('div.table_area_6').hide();
          selesai();
        },
        success: function(result) {
          // console.log(result);
          $('#loadingArea6').hide();
          $('div.table_area_6').show();
          $('div.table_area_6').html(result);
          $('#tipe').val('ECOM');

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
    })
}


function cetak() {
    if(ajax2 != null) ajax2.abort()
    if(ajax3 != null) ajax3.abort()
    if(ajax1 != null) ajax1.abort()
    if(ajax4 != null) ajax4.abort()
    if(ajax6 != null) ajax6.abort()
    ajax5 = $.ajax({
        url: baseurl + 'KapasitasGdSparepart/Pelayanan/getCetak',
        type: 'POST',
        beforeSend: function() {
          $('#loadingArea5').show();
          $('div.table_area_5').hide();
          $('div.table_area_selesai').hide();
        },
        success: function(result) {
          // console.log(result);
          $('#loadingArea5').hide();
          $('div.table_area_5').show();
          $('div.table_area_5').html(result);
          $('#tipe').val('CETAK');

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
    })
}


function detailDOSP(no) {
    // $('#modalDetailDOSP').modal();

    $.ajax({
      url: baseurl + 'KapasitasGdSparepart/Pelayanan/getDetail',
      type: 'POST',
      data: {
        doc: no
      },
      beforeSend: function() {
        $('#loadingAreaDetail').show();
        $('div.table_detail').hide();
        $('#nospbdetail').html('');

      },
      success: function(result) {
        $('#loadingAreaDetail').hide();
        $('div.table_detail').show();
        $('#nospbdetail').html(no);
        $('div.table_detail').html(result);

      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
  }

// ----------------------------------------------------------------------------------------------------------------------------------------------

function btnPelayananSPB(doc) {
    var valBtn = $('#btnPelayanan'+doc).val();
    var jenis  = $('#jenis'+doc).val();
    var no_spb = $('#nodoc'+doc).val();
    var pic = $('#pic'+doc).val();
    var d    = new Date();
    var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    var wkt  = d.getFullYear()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    //  console.log(jenis, no_spb);

    var hoursLabel   = document.getElementById("hours"+doc);
    var minutesLabel = document.getElementById("minutes"+doc);
    var secondsLabel = document.getElementById("seconds"+doc);
    var totalSeconds = 0;
    var timer = null;

    if (pic != '') {
        $("#btnrestartSPB"+doc).on('click',function() {
            if (timer) {
                totalSeconds = 0;
                stop();
            }
        });

        function setTime() {
            totalSeconds++;
            secondsLabel.innerHTML = pad(totalSeconds % 60);
            minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
            hoursLabel.innerHTML = pad(parseInt(totalSeconds / 3600))
        }

        function pad(val) {
            var valString = val + "";
            if (valString.length < 2) {
                return "0" + valString;
            } else {
                return valString;
            }
        }

        $('#btnPelayanan'+doc).on('click',function() {

        })

        if (valBtn == 'Mulai') {
            $('#btnPelayanan'+doc).each(function() {
                $('#btnPelayanan'+doc).val('Selesai');
                $('#mulai'+doc).val(wkt);
                $(this).removeClass('btn-success').addClass('btn-danger');
                $('#pic'+doc).prop("disabled", true);

                if (!timer) {
                    timer = setInterval(setTime, 1000);
                }
            })
            $.ajax ({
                url : baseurl + "KapasitasGdSparepart/Pelayanan/updateMulai",
                data: { date : date , jenis : jenis, no_spb : no_spb, pic : pic},
                type : "POST",
                dataType: "html"
                });

        } else if (valBtn == 'Selesai') {
                $('#btnPelayanan'+doc).attr("disabled", "disabled");
                $('#btnrestartSPB'+doc).attr("disabled", "disabled");
                var mulai  = $('#mulai'+doc).val();
                $('#timer'+doc).css('display','none');

                $.ajax ({
                url : baseurl + "KapasitasGdSparepart/Pelayanan/updateSelesai",
                data: { date : date,jenis : jenis, no_spb : no_spb, mulai : mulai, wkt : wkt, pic : pic},
                type : "POST",
                dataType: "html",
                success: function(result) {
                    selesai();
                    var tipe = $('#tipe').val();
                    if (tipe == 'NORMAL') {
                        normal();
                    }
                    else if (tipe == 'URGENT') {
                        urgent();
                    }
                    else if (tipe == 'ECERAN') {
                        eceran();
                    }
                    else if (tipe == 'BEST') {
                        best();
                    }
                    else if (tipe == 'ECOM') {
                        ecom();
                    }
                }
            });
        }
    }
    else {
        swal.fire("Gagal!", "Silahkan isi PIC terlebih dahulu.", "error");
    }
}


function btnRestartPelayanan(doc) {
    var jenis  = $('#jenis'+doc).val();
    var no_spb = $('#nodoc'+doc).val();
    var pic = $('#pic'+doc).val();
    var d    = new Date();
    var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    var wkt  = d.getFullYear()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();

    Swal.fire({
        title: 'Apakah Anda Yakin?',
        text : 'Restart akan dilakukan...',
        type: 'question',
        showCancelButton: true,
        allowOutsideClick: false
    }).then(result => {
        if (result.value) {
            $('#mulai'+doc).val(wkt);
            $("#btnrestartSPB"+doc).removeClass('btn-info').addClass('btn-warning');
            $.ajax ({
                url : baseurl + "KapasitasGdSparepart/Pelayanan/updateMulai",
                data: {jenis : jenis, no_spb : no_spb, date : date, pic : pic},
                type : "POST",
                dataType: "html",
                success: function(data){
                    swal.fire("Berhasil!", "Restart telah dilakukan.", "success");
                }
            });
    }})
}


function btnPausePelayanan(doc) {
    var jenis  = $('#jenis'+doc).val();
    var no_spb = $('#nodoc'+doc).val();
    var mulai  = $('#mulai'+doc).val();
    var d    = new Date();
    var wkt  = d.getFullYear()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();

    Swal.fire({
        title: 'Apakah Anda Yakin?',
        text : 'Pause akan dilakukan...',
        type: 'question',
        showCancelButton: true,
        allowOutsideClick: false
    }).then(result => {
        if (result.value) {
            $('#timer'+doc).css('display','none');
            $('#btnrestartSPB'+doc).attr("disabled", "disabled");
            $('#btnPelayanan'+doc).attr("disabled", "disabled");
            $.ajax ({
                url : baseurl + "KapasitasGdSparepart/Pelayanan/pauseSPB",
                data: {jenis : jenis, no_spb : no_spb, wkt : wkt, mulai : mulai},
                type : "POST",
                dataType: "html",
                success: function(data){
                    swal.fire("Berhasil!", "Waktu telah ditunda.", "success");
                    var tipe = $('#tipe').val();
                    if (tipe == 'NORMAL') {
                        normal();
                    }
                    else if (tipe == 'URGENT') {
                        urgent();
                    }
                    else if (tipe == 'ECERAN') {
                        eceran();
                    }
                    else if (tipe == 'BEST') {
                        best();
                    }
                    else if (tipe == 'ECOM') {
                        ecom();
                    }
                }
            });
    }})
}


function checkdata(doc) {
    var val = $('#tandacek'+doc).val();
    console.log(val);

    if (val == 'cek') {
        $('#tandacek'+doc).val('uncek');
        $('#ceka'+doc).removeClass('fa-square-o').addClass('fa-check-square-o');
        $('#nodoc'+doc).addClass('noall');
        $('#pic'+doc).addClass('picall');
    }else{
        $('#tandacek'+doc).val('cek');
        $('#ceka'+doc).removeClass('fa-check-square-o').addClass('fa-square-o');
        $('#nodoc'+doc).removeClass('noall');
        $('#pic'+doc).removeClass('picall');
    }
}


function startselectedPelayanan() {
    var no = $('.noall').map(function(){
        return $(this).val();
    }).get();

    for (let i = 0; i < no.length; i++) {
        const n = no[i];
        var cekpic = $('#pic'+n).val();
        if (cekpic != '') {
            mulaiselect(n);
        }
        else {
            swal.fire("Gagal!", "Silahkan isi PIC terlebih dahulu.", "error");
        }
    }
}


function mulaiselect(no) {
    var valBtn = $('#btnPelayanan'+no).val();
    var jenis  = $('#jenis'+no).val();
    var no_spb = $('#nodoc'+no).val();
    var pic = $('#pic'+no).val();
    var d    = new Date();
    var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    var wkt  = d.getFullYear()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    //  console.log(jenis, no_spb);

    var hoursLabel   = document.getElementById("hours"+no);
    var minutesLabel = document.getElementById("minutes"+no);
    var secondsLabel = document.getElementById("seconds"+no);
    var totalSeconds = 0;
    var timer = null;

    $("#btnrestartSPB"+no).on('click',function() {
        if (timer) {
            totalSeconds = 0;
            stop();
        }
    });

    function setTime() {
        totalSeconds++;
        secondsLabel.innerHTML = pad(totalSeconds % 60);
        minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
        hoursLabel.innerHTML = pad(parseInt(totalSeconds / 3600))
    }

    function pad(val) {
        var valString = val + "";
        if (valString.length < 2) {
            return "0" + valString;
        } else {
            return valString;
        }
    }

    if (valBtn == 'Mulai') {
        $('#btnPelayanan'+no).each(function() {
            $('#btnPelayanan'+no).val('Selesai');
            $('#mulai'+no).val(wkt);
            $(this).removeClass('btn-success').addClass('btn-danger');
            $('#pic'+no).prop("disabled", true);

            if (!timer) {
                timer = setInterval(setTime, 1000);
            }
        })
        $.ajax ({
            url : baseurl + "KapasitasGdSparepart/Pelayanan/updateMulai",
            data: { date : date , jenis : jenis, no_spb : no_spb, pic : pic},
            type : "POST",
            dataType: "html"
            });

    }
}


function finishselectedPelayanan() {
    $("#mdlfinishplyn").modal('show');
}


function savefinish() {
    var no = $('.noall').map(function(){return $(this).val();}).get();
    var pic = $('.picall').map(function(){return $(this).val();}).get();
    var pic_finish = $('#picfinish').val();
    $("#mdlfinishplyn").modal('hide');
    var j = 0;

    for (let i = 0; i < no.length; i++) {
        if (pic[i] == pic_finish) {
            j = j + 1;
        }
    }

    for (let i = 0; i < no.length; i++) {
        const n = no[i];
        selesaiselect(n, pic_finish, j);
        selesai();
    }
}


function selesaiselect(no, pic_finish, j) {
    var valBtn = $('#btnPelayanan'+no).val();
    var jenis  = $('#jenis'+no).val();
    var no_spb = $('#nodoc'+no).val();
    var pic = $('#pic'+no).val();
    var d    = new Date();
    var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    var wkt  = d.getFullYear()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
     // console.log(pic);

    var hoursLabel   = document.getElementById("hours"+no);
    var minutesLabel = document.getElementById("minutes"+no);
    var secondsLabel = document.getElementById("seconds"+no);
    var totalSeconds = 0;
    var timer = null;

    $("#btnrestartSPB"+no).on('click',function() {
        if (timer) {
            totalSeconds = 0;
            stop();
        }
    });

    function setTime() {
        totalSeconds++;
        secondsLabel.innerHTML = pad(totalSeconds % 60);
        minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
        hoursLabel.innerHTML = pad(parseInt(totalSeconds / 3600))
    }

    function pad(val) {
        var valString = val + "";
        if (valString.length < 2) {
        return "0" + valString;
        } else {
        return valString;
        }
    }

    if(valBtn == 'Selesai' && pic == pic_finish){
        $('#btnPelayanan'+no).attr("disabled", "disabled");
        $('#btnrestartSPB'+no).attr("disabled", "disabled");
        var mulai  = $('#mulai'+no).val();
        $('#timer'+no).css('display','none');

        $.ajax ({
        url : baseurl + "KapasitasGdSparepart/Pelayanan/updateSelesai2",
        data: { date : date,jenis : jenis, no_spb : no_spb, mulai : mulai, wkt : wkt, pic : pic, j : j},
        type : "POST",
        dataType: "html"
        });


    }

    var tipe = $('#tipe').val();
    if (tipe == 'NORMAL') {
        normal();
    }
    else if (tipe == 'URGENT') {
        urgent();
    }
    else if (tipe == 'ECERAN') {
        eceran();
    }
    else if (tipe == 'BEST') {
        best();
    }
    else if (tipe == 'ECOM') {
        ecom();
    }
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////// INPUT //////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// function inputPSPB(th) {
// 	$(document).ready(function(){
//     var no_spb      = $('input[name="no_spb[]"]').map(function(){return $(this).val();}).get();
//     var btn_urgent  = $('input[name="btn_urgent[]"]').map(function(){return $(this).val();}).get();
//     var btn_bon     = $('input[name="btn_bon[]"]').map(function(){return $(this).val();}).get();
//     var btn_langsung = $('input[name="btn_langsung[]"]').map(function(){return $(this).val();}).get();
//     var btn_besc = $('input[name="btn_besc[]"]').map(function(){return $(this).val();}).get();
//     // console.log(btn1);
//     $("#mdlloading").modal({
//                 backdrop: 'static',
//                 keyboard: true,
//                 show: true
//         });
// 	var request = $.ajax({
//         url: baseurl+'KapasitasGdSparepart/Input/save',
//         data: {no_spb : no_spb, btn_urgent : btn_urgent, btn_bon : btn_bon, btn_langsung : btn_langsung, btn_besc : btn_besc},
//         type: "POST",
//         datatype: 'html',
//         success: function(data){
//             $("#mdlloading").modal("hide");
// 			window.location.reload();
// 	    }
// 	});
// 	});
// }


// function btnUrgent(no) {
//     var valBtn = $('#btn'+no).val();
//     if (valBtn == 'Urgent') {
//         $('#btn'+no).val('Batal');
//         $('#btn'+no).removeClass('btn-warning').addClass('btn-success');
//         document.getElementById('btn'+no).removeAttribute("style");
//     }else if (valBtn == 'Batal') {
//         $('#btn'+no).val('Urgent');
//         $('#btn'+no).removeClass('btn-success').addClass('btn-warning');
//         document.getElementById('btn'+no).style.color = 'black';
//     }
// }


// function btnBonKgs(no) {
//     var valbon = $('#btnbon'+no).val();
//     if (valbon == 'Bon') {
//         $('#btnbon'+no).val('Batal');
//         $('#btnbon'+no).removeClass('btn-default').addClass('btn-danger');
//     }else if (valbon == 'Batal') {
//         $('#btnbon'+no).val('Bon');
//         $('#btnbon'+no).removeClass('btn-danger').addClass('btn-default');
//     }
// }


// function btnLangsungKgs(no) {
//     var langsung = $('#btnlangsung'+no).val();
//     if (langsung == 'Langsung') {
//         $('#btnlangsung'+no).val('Batal');
//         $('#btnlangsung'+no).removeClass('btn-info').addClass('btn-danger');
//     }else if (langsung == 'Batal') {
//         $('#btnlangsung'+no).val('Langsung');
//         $('#btnlangsung'+no).removeClass('btn-danger').addClass('btn-info');
//     }
// }


// function btnBescKgs(no) {
//     var valBtn = $('#btnbesc'+no).val();
//     if (valBtn == 'Best') {
//         $('#btnbesc'+no).val('Batal');
//         $('#btnbesc'+no).removeClass('btn-success').addClass('btn-danger');
//     }else if (valBtn == 'Batal') {
//         $('#btnbesc'+no).val('Best');
//         $('#btnbesc'+no).removeClass('btn-danger').addClass('btn-success');
//     }
// }


// function btnCancelKGS(no) {
//     var jenis = $('#jenis'+no).val();
//     var nodoc = $('#nodoc'+no).val();
//     // console.log(jenis);
//     Swal.fire({
//         title: 'Apakah Anda Yakin Akan Melakukan Cancel?',
//         type: 'question',
//         showCancelButton: true,
//         allowOutsideClick: false
//     }).then(result => {
//         if (result.value) {
//             $('#baris'+no).css('display', 'none');
//             $.ajax ({
//                 url : baseurl + "KapasitasGdSparepart/Input/cancelSPB",
//                 data: { no : no , jenis : jenis, nodoc : nodoc},
//                 type : "POST",
//                 dataType: "html",
//                 success: function(data){
//                     swal.fire("Berhasil!", "", "success");
//                     }
//                 });
//     }})

// }


// function btnPendingSpb(no) {
//     var jenis = $('#jenis'+no).val();
//     var nodoc = $('#nodoc'+no).val();
//     var bon = $('#bon'+no).val();
//     // console.log(jenis);
//     if (bon == 'PENDING') {
//         Swal.fire({
//             title: 'Apakah Anda Yakin Akan Menghapus Pending?',
//             type: 'question',
//             showCancelButton: true,
//             allowOutsideClick: false
//         }).then(result => {
//             if (result.value) {
//                 $.ajax ({
//                     url : baseurl + "KapasitasGdSparepart/Tracking/deletependingSPB",
//                     data: { no : no , jenis : jenis, nodoc : nodoc},
//                     type : "POST",
//                     dataType: "html",
//                     success: function(data){
//                         swal.fire("Berhasil!", "", "success");
//                         window.location.reload();
//                         }
//                     });
//         }})
//     }else {
//         Swal.fire({
//             title: 'Apakah Anda Yakin Akan Melakukan Pending?',
//             type: 'question',
//             showCancelButton: true,
//             allowOutsideClick: false
//         }).then(result => {
//             if (result.value) {
//                 $.ajax ({
//                     url : baseurl + "KapasitasGdSparepart/Tracking/pendingSPB",
//                     data: { no : no , jenis : jenis, nodoc : nodoc},
//                     type : "POST",
//                     dataType: "html",
//                     success: function(data){
//                         swal.fire("Berhasil!", "", "success");
//                         window.location.reload();
//                         }
//                     });
//         }})
//     }
// }



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////// ADMIN //////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// function btnAdminSPB(th) {
//     var valBtn = $('#btnAdmin').val();
//     var hoursLabel   = document.getElementById("hours");
//     var minutesLabel = document.getElementById("minutes");
//     var secondsLabel = document.getElementById("seconds");
//     var totalSeconds = 0;
//     //  console.log(valBtn, hoursLabel);
//     if (valBtn == 'Mulai Allocate') {
//         var d    = new Date();
//         var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
//         var unix = Math.round((new Date()).getTime() / 1000);
//         var wkt  = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
//         $('#btnAdmin').each(function() {
//             $('#btnAdmin').val('Selesai');
//             $(this).removeClass('btn-success').addClass('btn-danger');
//             $('#idunix').val(unix);
//             $('#mulai').val(wkt);
//             $("#btnAdmin").attr("disabled", true);
//             setInterval(setTime, 1000);

//             function setTime(){
//                 ++totalSeconds;
//                 secondsLabel.innerHTML = pad(totalSeconds%60);
//                 minutesLabel.innerHTML = pad(parseInt(totalSeconds/60));
//                 hoursLabel.innerHTML   = pad(parseInt(totalSeconds/(60*60)));
//             }

//             function pad(val) {
//                 var valString = val + "";
//                 if(valString.length < 2){
//                     return "0" + valString;
//                 }else{
//                     return valString;
//                 }
//             }
//         })

//         $.ajax ({
//             url : baseurl + "KapasitasGdSparepart/Admin/saveAdmin",
//             data: { date : date , valBtn : valBtn, unix : unix},
//             type : "POST",
//             dataType: "html"
//             });

//     } else if (valBtn == 'Selesai') {
//         var jml_spb = $('#jml_spb').val();
//         var unix    = $('#idunix').val();
//         var mulai   = $('#mulai').val();
//         var d       = new Date();
//         var date    = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
//         var wkt     = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
//         $('#btnAdmin').each(function() {
//             $('#btnAdmin').val('Mulai Allocate');
//             $(this).removeClass('btn-danger').addClass('btn-success');

//         })

//         $.ajax ({
//         url : baseurl + "KapasitasGdSparepart/Admin/",
//         data: { date : date, valBtn : valBtn, jml_spb : jml_spb, unix : unix, mulai : mulai, wkt : wkt},
//         type : "POST",
//         dataType: "html"
//         });
//         window.location.reload();
//     }

// }

// $('.inputQTY').change(function(){
// 	$('#btnAdmin').removeAttr("disabled");
// })

// function saveJmlSpb(th) {
//     var jml_spb = $('#jml_spb').val();
//     // console.log(jml_spb);

//     $.ajax ({
//         url : baseurl + "KapasitasGdSparepart/Admin/saveAdminSpb",
//         data: {jml_spb : jml_spb},
//         type : "POST",
//         dataType: "html"
//         });
// }



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////// PENGELUARAN //////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// function btnPengeluaranSPB(no) {
//     var valBtn = $('#btnPengeluaran'+no).val();
//     var jenis  = $('#jenis'+no).val();
//     var no_spb = $('#nodoc'+no).val();
//     var pic = $('#pic'+no).val();
//     var d    = new Date();
//     var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
//     var wkt  = d.getFullYear()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
//     //  console.log(jenis, no_spb);

//     var hoursLabel   = document.getElementById("hours"+no);
//     var minutesLabel = document.getElementById("minutes"+no);
//     var secondsLabel = document.getElementById("seconds"+no);
//     var totalSeconds = 0;
//     var timer = null;

//     $("#btnrestartSPB"+no).on('click',function() {
//         if (timer) {
//             totalSeconds = 0;
//             stop();
//         }
//     });

//     function setTime() {
//         totalSeconds++;
//         secondsLabel.innerHTML = pad(totalSeconds % 60);
//         minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
//         hoursLabel.innerHTML = pad(parseInt(totalSeconds / 3600))
//     }

//     function pad(val) {
//         var valString = val + "";
//         if (valString.length < 2) {
//         return "0" + valString;
//         } else {
//         return valString;
//         }
//     }
//      $('#btnPengeluaran'+no).on('click',function() {

//     })

//     if (valBtn == 'Mulai') {
//         $('#btnPengeluaran'+no).each(function() {
//             $('#btnPengeluaran'+no).val('Selesai');
//             $('#mulai'+no).val(wkt);
//             $(this).removeClass('btn-success').addClass('btn-danger');
//             $('#pic'+no).prop("disabled", true);

//             if (!timer) {
//                 timer = setInterval(setTime, 1000);
//             }
//         })
//         $.ajax ({
//             url : baseurl + "KapasitasGdSparepart/Pengeluaran/updateMulai",
//             data: { date : date , jenis : jenis, no_spb : no_spb, pic : pic},
//             type : "POST",
//             dataType: "html"
//             });

//     }else if(valBtn == 'Selesai'){
//             $('#btnPengeluaran'+no).attr("disabled", "disabled");
//             $('#btnrestartSPB'+no).attr("disabled", "disabled");
//             var mulai  = $('#mulai'+no).val();
//             $('#timer'+no).css('display','none');

//             $.ajax ({
//             url : baseurl + "KapasitasGdSparepart/Pengeluaran/updateSelesai",
//             data: { date : date,jenis : jenis, no_spb : no_spb, mulai : mulai, wkt : wkt, pic : pic},
//             type : "POST",
//             dataType: "html"
//             });
//     }
// }


// function btnRestartPengeluaran(no) {
//     var jenis  = $('#jenis'+no).val();
//     var no_spb = $('#nodoc'+no).val();
//     var pic = $('#pic'+no).val();
//     var d    = new Date();
//     var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
//     var wkt  = d.getFullYear()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
//     //  console.log(jenis, no_spb);

//      Swal.fire({
//         title: 'Apakah Anda Yakin?',
//         text: 'Restart akan dilakukan...',
//         type: 'question',
//         showCancelButton: true,
//         allowOutsideClick: false
//     }).then(result => {
//         if (result.value) {
//             $('#mulai'+no).val(wkt);
//             $("#btnrestartSPB"+no).removeClass('btn-info').addClass('btn-warning');
//             $.ajax ({
//                 url : baseurl + "KapasitasGdSparepart/Pengeluaran/updateMulai",
//                 data: {jenis : jenis, no_spb : no_spb, date : date, pic : pic},
//                 type : "POST",
//                 dataType: "html",
//                 success: function(data){
//                     swal.fire("Berhasil!", "Restart telah dilakukan.", "success");
//                 }
//             });
//     }})
// }


// function btnPausePengeluaran(no) {
//     var jenis  = $('#jenis'+no).val();
//     var no_spb = $('#nodoc'+no).val();
//     var mulai  = $('#mulai'+no).val();
//     var d      = new Date();
//     var wkt    = d.getFullYear()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();

//     Swal.fire({
//         title: 'Apakah Anda Yakin?',
//         type: 'question',
//         showCancelButton: true,
//         allowOutsideClick: false
//     }).then(result => {
//         if (result.value) {
//             $('#timer'+no).css('display','none');
//             $('#btnPengeluaran'+no).attr("disabled", "disabled");
//             $('#btnrestartSPB'+no).attr("disabled", "disabled");
//             $.ajax ({
//                 url : baseurl + "KapasitasGdSparepart/Pengeluaran/pauseSPB",
//                 data: {jenis : jenis, no_spb : no_spb, wkt : wkt, mulai : mulai},
//                 type : "POST",
//                 dataType: "html",
//                 success: function(data){
//                     swal.fire("Berhasil!", "Waktu telah ditunda.", "success");
//                     }
//             });
//     }})
// }


// function startselectedPengeluaran() {
//     var no = $('.noall').map(function(){return $(this).val();}).get();
//     for (let i = 0; i < no.length; i++) {
//         const n = no[i];
//         mulaiselect2(n);
//     }
// }


// function mulaiselect2(no) {
//     var valBtn = $('#btnPengeluaran'+no).val();
//     var jenis  = $('#jenis'+no).val();
//     var no_spb = $('#nodoc'+no).val();
//     var pic = $('#pic'+no).val();
//     var d    = new Date();
//     var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
//     var wkt  = d.getFullYear()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
//     //  console.log(jenis, no_spb);

//     var hoursLabel   = document.getElementById("hours"+no);
//     var minutesLabel = document.getElementById("minutes"+no);
//     var secondsLabel = document.getElementById("seconds"+no);
//     var totalSeconds = 0;
//     var timer = null;

//     $("#btnrestartSPB"+no).on('click',function() {
//         if (timer) {
//             totalSeconds = 0;
//             stop();
//         }
//     });

//     function setTime() {
//         totalSeconds++;
//         secondsLabel.innerHTML = pad(totalSeconds % 60);
//         minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
//         hoursLabel.innerHTML = pad(parseInt(totalSeconds / 3600))
//     }

//     function pad(val) {
//         var valString = val + "";
//         if (valString.length < 2) {
//         return "0" + valString;
//         } else {
//         return valString;
//         }
//     }

//     if (valBtn == 'Mulai') {
//         $('#btnPengeluaran'+no).each(function() {
//             $('#btnPengeluaran'+no).val('Selesai');
//             $('#mulai'+no).val(wkt);
//             $(this).removeClass('btn-success').addClass('btn-danger');
//             $('#pic'+no).prop("disabled", true);

//             if (!timer) {
//                 timer = setInterval(setTime, 1000);
//             }
//         })
//         $.ajax ({
//             url : baseurl + "KapasitasGdSparepart/Pengeluaran/updateMulai",
//             data: { date : date , jenis : jenis, no_spb : no_spb, pic : pic},
//             type : "POST",
//             dataType: "html"
//             });

//     }
// }


// function finishselectedPengeluaran() {
//     $("#mdlfinishpglr").modal('show');
// }


// function savefinish2() {
//     var no = $('.noall').map(function(){return $(this).val();}).get();
//     var pic = $('.picall').map(function(){return $(this).val();}).get();
//     var pic_finish = $('#picfinish').val();
//     $("#mdlfinishpglr").modal('hide');
//     var j = 0;
//     for (let i = 0; i < no.length; i++) {
//         if (pic[i] == pic_finish) {
//             j = j + 1;
//         }
//         // selesaiselect2(n, pic);
//     }
//     for (let i = 0; i < no.length; i++) {
//         const n = no[i];
//         selesaiselect2(n, pic_finish, j);
//     }
// }

// function selesaiselect2(no, pic_finish, j) {
//     var valBtn = $('#btnPengeluaran'+no).val();
//     var jenis  = $('#jenis'+no).val();
//     var no_spb = $('#nodoc'+no).val();
//     var pic = $('#pic'+no).val();
//     var d    = new Date();
//     var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
//     var wkt  = d.getFullYear()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
//     //  console.log(jenis, no_spb);

//     var hoursLabel   = document.getElementById("hours"+no);
//     var minutesLabel = document.getElementById("minutes"+no);
//     var secondsLabel = document.getElementById("seconds"+no);
//     var totalSeconds = 0;
//     var timer = null;

//     $("#btnrestartSPB"+no).on('click',function() {
//         if (timer) {
//             totalSeconds = 0;
//             stop();
//         }
//     });

//     function setTime() {
//         totalSeconds++;
//         secondsLabel.innerHTML = pad(totalSeconds % 60);
//         minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
//         hoursLabel.innerHTML = pad(parseInt(totalSeconds / 3600))
//     }

//     function pad(val) {
//         var valString = val + "";
//         if (valString.length < 2) {
//         return "0" + valString;
//         } else {
//         return valString;
//         }
//     }

//     if(valBtn == 'Selesai' && pic == pic_finish){
//             $('#btnPengeluaran'+no).attr("disabled", "disabled");
//             $('#btnrestartSPB'+no).attr("disabled", "disabled");
//             var mulai  = $('#mulai'+no).val();
//             $('#timer'+no).css('display','none');

//             $.ajax ({
//             url : baseurl + "KapasitasGdSparepart/Pengeluaran/updateSelesai2",
//             data: { date : date,jenis : jenis, no_spb : no_spb, mulai : mulai, wkt : wkt, pic : pic, j : j},
//             type : "POST",
//             dataType: "html"
//             });
//     }
// }



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////// PACKING //////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function packing() {
    ajax_packing = $.ajax({
        url: baseurl + 'KapasitasGdSparepart/Packing/getPacking',
        type: 'POST',
        beforeSend: function() {
          $('#loadingAreaPacking').show();
          $('div.table_area_packing').hide();
          selesai();
        },
        success: function(result) {
          // console.log(result);
          $('#loadingAreaPacking').hide();
          $('div.table_area_packing').show();
          $('div.table_area_packing').html(result);
          // $('#tipe').val('NORMAL');

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
    })
}


function selesaiPacking() {
    ajax_packing_sls = $.ajax({
        url: baseurl + 'KapasitasGdSparepart/Packing/getSelesaiPacking',
        type: 'POST',
        beforeSend: function() {
          $('#loadingArea6').show();
          $('div.table_area_selesai2').hide();
          selesai();
        },
        success: function(result) {
          // console.log(result);
          $('#loadingArea6').hide();
          $('div.table_area_selesai2').show();
          $('div.table_area_selesai2').html(result);
          // $('#tipe').val('NORMAL');

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
    })
}


function btnPackingSPB(no) {
    var valBtn = $('#btnPacking'+no).val();
    var jenis  = $('#jenis'+no).val();
    var no_spb = $('#nodoc'+no).val();
    var pic = $('#pic'+no).val();
    var d    = new Date();
    var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    var wkt  = d.getFullYear()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    //  console.log(jenis, no_spb);

    var hoursLabel   = document.getElementById("hours"+no);
    var minutesLabel = document.getElementById("minutes"+no);
    var secondsLabel = document.getElementById("seconds"+no);
    var totalSeconds = 0;
    var timer = null;

    if (pic != '') {
        $("#btnrestartSPB"+no).on('click',function() {
            if (timer) {
                totalSeconds = 0;
                stop();
            }
        });

        function setTime() {
            totalSeconds++;
            secondsLabel.innerHTML = pad(totalSeconds % 60);
            minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
            hoursLabel.innerHTML = pad(parseInt(totalSeconds / 3600))
        }

        function pad(val) {
            var valString = val + "";
            if (valString.length < 2) {
            return "0" + valString;
            } else {
            return valString;
            }
        }
         $('#btnPacking'+no).on('click',function() {

        })

        if (valBtn == 'Mulai') {
            $('#btnPacking'+no).each(function() {
                $('#btnPacking'+no).val('Selesai');
                $('#mulai'+no).val(wkt);
                $(this).removeClass('btn-success').addClass('btn-danger');
                $('#pic'+no).prop("disabled", true);
                // $('#btnPack'+no).css('display', '');

                if (!timer) {
                    timer = setInterval(setTime, 1000);
                }
            })
            $.ajax ({
                url : baseurl + "KapasitasGdSparepart/Packing/updateMulai",
                data: { date : date , jenis : jenis, no_spb : no_spb, pic : pic},
                type : "POST",
                dataType: "html",
                success: function(result) {
                    testmodal(no);
                }
            });

        } else if (valBtn == 'Selesaikan') {
            // $('#btnPacking'+no).attr("disabled", "disabled");
            // $('#btnrestartSPB'+no).attr("disabled", "disabled");
            // var mulai  = $('#mulai'+no).val();
            // $('#timer'+no).css('display','none');

            // $.ajax ({
            //     url : baseurl + "KapasitasGdSparepart/Packing/updateSelesai",
            //     data: { date : date,jenis : jenis, no_spb : no_spb, mulai : mulai, wkt : wkt, pic : pic},
            //     type : "POST",
            //     dataType: "html",
            //     success: function(result) {
            //         packing();
            //         selesaiPacking();
            //     }
            // });
            testmodal(no);
        }
    }
    else {
        swal.fire("Gagal!", "Silahkan isi PIC terlebih dahulu.", "error");
    }
}

function testmodal(no) {
    $('#modalPacking').modal();

    var jenis  = $('#jenis'+no).val();
    var no_spb = $('#nodoc'+no).val();
    // console.log(no_spb);


    $.ajax({
      url: baseurl + 'KapasitasGdSparepart/Packing/getData',
      type: 'POST',
      data: {
        no_spb: no_spb
      },
      beforeSend: function() {
        $('#loadingAreaColly').show();
        $('div.table_area_colly').hide();
      },
      success: function(result) {
        $('#loadingAreaColly').hide();
        $('div.table_area_colly').show();
        $("#headPack").html(jenis + ' - ' + no);
        $('div.table_area_colly').html(result);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
}


function showisiPL(colly) {
    $('.rowshow').hide();
    $('.rowshow').removeClass('rowshow').addClass('rowhide');
    $('#row'+colly).show();
    $('#row'+colly).removeClass('rowhide').addClass('rowshow');
    $('#activeColly').val(colly);
    $("#inputItemColly").focus();
}


function updateQty(event,item) {
    if (event.keyCode === 13) {
        var item    = $(item).val().toUpperCase();
        var colly   = $('#activeColly').val();
        var no_spb  = $('#spbcolly').val();
        var qty_pack = $('#qty'+colly+item).val();
        var auto = $('#auto'+colly).val();

        var inputOptions = new Promise(function(resolve) {
            resolve({
              'KARDUS KECIL'    : 'KARDUS KECIL',
              'KARDUS SEDANG'   : 'KARDUS SEDANG',
              'KARDUS PANJANG'  : 'KARDUS PANJANG',
              'KARUNG'          : 'KARUNG',
              'PETI'            : 'PETI'
            });
        });

        $.ajax({
            url: baseurl + 'KapasitasGdSparepart/Packing/cekItem',
            type: 'POST',
            dataType: 'JSON',
            data: {
              item: item,
              colly: colly
            },
            beforeSend: function() {
                Swal.showLoading();
            },
            success: function(result) {
                if (result) {
                    Swal.fire({
                        title: 'Masukkan qty ' + item,
                        input: 'number',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showCancelButton: true,
                        confirmButtonText: 'OK'
                        // showLoaderOnConfirm: true
                    }).then(function (result) {
                        if (Number(result.value) <= Number(qty_pack) && Number(result.value) > 0) {
                            $.ajax({
                                type: "POST",
                                url: baseurl + 'KapasitasGdSparepart/Packing/updateQtyVerif',
                                data: {
                                    qty_verif: result.value,
                                    colly: colly,
                                    item: item
                                },
                                beforeSend: function() {
                                    Swal.showLoading();
                                },
                                success: function (response) {
                                    Swal.fire({
                                        title: "Sukses",
                                        text: "Verifikasi berhasil!",
                                        type: "success"
                                    }).then(function() {
                                        $.ajax({
                                            type: "POST",
                                            dataType: 'JSON',
                                            url: baseurl + 'KapasitasGdSparepart/Packing/cekColly',
                                            data: {
                                                colly: colly
                                            },
                                            beforeSend: function() {
                                                Swal.showLoading();
                                            },
                                            success: function (response) {
                                                console.log(auto);
                                                if (response) {
                                                    Swal.fire({
                                                        title: 'Masukkan berat colly ' + colly + ' (KG)',
                                                        input: 'text',
                                                        allowOutsideClick: false,
                                                        allowEscapeKey: false,
                                                        showCancelButton: false,
                                                        confirmButtonText: 'OK'
                                                        // showLoaderOnConfirm: true
                                                    }).then(function (result) {
                                                        if (result.value) {
                                                            $.ajax({
                                                                type: "POST",
                                                                url: baseurl + 'KapasitasGdSparepart/Packing/updateBeratColly',
                                                                data: {
                                                                    berat: result.value,
                                                                    colly: colly
                                                                },
                                                                beforeSend: function() {
                                                                    Swal.showLoading();
                                                                },
                                                                success: function (response) {
                                                                    Swal.fire({
                                                                        title: "Sukses",
                                                                        text: "Berhasil menyimpan berat colly!!",
                                                                        type: "success"
                                                                    }).then(function() {
                                                                        Swal.fire({
                                                                            title: 'Pilih Jenis Packing',
                                                                            input: 'radio',
                                                                            allowOutsideClick: false,
                                                                            allowEscapeKey: false,
                                                                            showCancelButton: false,
                                                                            confirmButtonText: 'OK',
                                                                            inputOptions: inputOptions,
                                                                              inputValidator: function(result) {
                                                                                return new Promise(function(resolve, reject) {
                                                                                  if (result) {
                                                                                    resolve();
                                                                                  } else {
                                                                                    reject('You need to select something!');
                                                                                  }
                                                                                });
                                                                              }
                                                                        }).then(function(result) {
                                                                            var jenis = $('input[name=swal2-radio]:checked').val();
                                                                            console.log(jenis);
                                                                            $.ajax({
                                                                                type: "POST",
                                                                                url: baseurl + 'KapasitasGdSparepart/Packing/updateJenisColly',
                                                                                data: {
                                                                                    jenis: jenis,
                                                                                    colly: colly
                                                                                },
                                                                                beforeSend: function() {
                                                                                    Swal.showLoading();
                                                                                },
                                                                                success: function (response) {
                                                                                    Swal.fire({
                                                                                        title: "Sukses",
                                                                                        text: "Berhasil menyimpan jenis colly!!",
                                                                                        type: "success"
                                                                                    }).then(function() {
                                                                                        $.ajax({
                                                                                              url: baseurl + 'KapasitasGdSparepart/Packing/getData',
                                                                                              type: 'POST',
                                                                                              data: {
                                                                                                no_spb: no_spb
                                                                                              },
                                                                                              beforeSend: function() {
                                                                                                $('#loadingAreaColly').show();
                                                                                                $('div.table_area_colly').hide();
                                                                                              },
                                                                                              success: function(result) {
                                                                                                $('#loadingAreaColly').hide();
                                                                                                $('div.table_area_colly').show();
                                                                                                $('div.table_area_colly').html(result);
                                                                                                showisiPL(colly);
                                                                                                // $('#modalJenisPacking').modal();
                                                                                                // $("#inputItemColly").focus();
                                                                                              },
                                                                                              error: function(XMLHttpRequest, textStatus, errorThrown) {
                                                                                                console.error();
                                                                                              }
                                                                                        });
                                                                                        $('#cetak'+colly).attr('disabled',false);
                                                                                        // $('#cetak'+colly).removeAttr('disabled');
                                                                                    })
                                                                                }
                                                                            });
                                                                        })
                                                                    })
                                                                }
                                                            });
                                                        }
                                                    });
                                                }
                                                // else if (response && auto == 'Y') {
                                                //     Swal.fire({
                                                //         title: 'Pilih Jenis Packing',
                                                //         input: 'radio',
                                                //         allowOutsideClick: false,
                                                //         allowEscapeKey: false,
                                                //         showCancelButton: false,
                                                //         confirmButtonText: 'OK',
                                                //         inputOptions: inputOptions,
                                                //           inputValidator: function(result) {
                                                //             return new Promise(function(resolve, reject) {
                                                //               if (result) {
                                                //                 resolve();
                                                //               } else {
                                                //                 reject('You need to select something!');
                                                //               }
                                                //             });
                                                //           }
                                                //     }).then(function(result) {
                                                //         var jenis = $('input[name=swal2-radio]:checked').val();
                                                //         console.log(jenis);
                                                //         $.ajax({
                                                //             type: "POST",
                                                //             url: baseurl + 'KapasitasGdSparepart/Packing/updateJenisColly',
                                                //             data: {
                                                //                 jenis: jenis,
                                                //                 colly: colly
                                                //             },
                                                //             beforeSend: function() {
                                                //                 Swal.showLoading();
                                                //             },
                                                //             success: function (response) {
                                                //                 Swal.fire({
                                                //                     title: "Sukses",
                                                //                     text: "Berhasil menyimpan jenis colly!!",
                                                //                     type: "success"
                                                //                 }).then(function() {
                                                //                     $.ajax({
                                                //                           url: baseurl + 'KapasitasGdSparepart/Packing/getData',
                                                //                           type: 'POST',
                                                //                           data: {
                                                //                             no_spb: no_spb
                                                //                           },
                                                //                           beforeSend: function() {
                                                //                             $('#loadingAreaColly').show();
                                                //                             $('div.table_area_colly').hide();
                                                //                           },
                                                //                           success: function(result) {
                                                //                             $('#loadingAreaColly').hide();
                                                //                             $('div.table_area_colly').show();
                                                //                             $('div.table_area_colly').html(result);
                                                //                             showisiPL(colly);
                                                //                           },
                                                //                           error: function(XMLHttpRequest, textStatus, errorThrown) {
                                                //                             console.error();
                                                //                           }
                                                //                     });
                                                //                     $('#cetak'+colly).attr('disabled',false);
                                                //                 })
                                                //             }
                                                //         });
                                                //     })
                                                // }
                                                else {
                                                    $.ajax({
                                                          url: baseurl + 'KapasitasGdSparepart/Packing/getData',
                                                          type: 'POST',
                                                          data: {
                                                            no_spb: no_spb
                                                          },
                                                          beforeSend: function() {
                                                            $('#loadingAreaColly').show();
                                                            $('div.table_area_colly').hide();
                                                          },
                                                          success: function(result) {
                                                            $('#loadingAreaColly').hide();
                                                            $('div.table_area_colly').show();
                                                            $('div.table_area_colly').html(result);
                                                            showisiPL(colly);
                                                          },
                                                          error: function(XMLHttpRequest, textStatus, errorThrown) {
                                                            console.error();
                                                          }
                                                    });
                                                }
                                            }
                                        });
                                    });
                                }
                            });
                        }
                        else {
                            Swal.fire(
                                'Oops!',
                                'Masukkan qty dengan benar!!',
                                'error'
                            )
                        }
                    });
                }
                else {
                    Swal.fire(
                        'Oops!',
                        'Item <b>' + item + '</b><br>tidak ditemukan dalam colly <b>' + colly + '</b><br>atau item sudah terverifikasi!!',
                        'error'
                    )
                }
                $('#inputItemColly').val('');
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.error();
            }
        })
    } else {
        console.log("gagal");
    }
}


function saveBeratPack(no) {
    var no_spb       = $('#no_spb'+no).val();
    var jenis_kemasan  = $('#jenis_kemasan'+no).val();
    var berat        = $('#berat'+no).val();
    var nomor = no + 1;
    // console.log(no_spb);
    $.ajax ({
        url : baseurl + "KapasitasGdSparepart/Packing/saveberatPacking",
        data: { no_spb : no_spb, jenis_kemasan : jenis_kemasan, berat : berat, no : no},
        type : "POST",
        dataType: "html",
        success: function(data){
            if (data == 'save') {
                $('#tambahbrt').append('<tr><td>'+nomor+'</td><td><select class="form-control select2" id="jenis_kemasan'+nomor+'" name="jenis_kemasan" style="width:100%" data-placeholder="pilih kemasan"><option></option><option value="1">KARDUS KECIL</option><option value="2">KARDUS SEDANG</option><option value="3">KARDUS PANJANG</option><option value="4">KARUNG</option><option value="5">PETI</option></select></td><td><input type="text" class="form-control" id="berat'+nomor+'" name="berat" placeholder="masukkan berat (KG)" onchange="saveBeratPack('+nomor+')"><input type="hidden" id="no_spb'+nomor+'" value="'+no_spb+'"></td></tr>');
            }
        }
    });
}


// function selesaipacking(th) {
//     var jenis  = $('#jenis').val();
//     var no_spb = $('#no_spb').val();
//     var pic = $('#pic').val();
//     var d    = new Date();
//     var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
//     var wkt  = d.getFullYear()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
//     var mulai  = $('#mulai').val();
//     var no  = $('#no').val();

//     $.ajax ({
//         url : baseurl + "KapasitasGdSparepart/Packing/updateSelesai",
//         data: { date : date,jenis : jenis, no_spb : no_spb, mulai : mulai, wkt : wkt, pic : pic, no : no},
//         type : "POST",
//         dataType: "html",
//         success: function(data){
//             $('#btnPacking'+no).attr("disabled", "disabled");
//             $('#btnrestartSPB'+no).attr("disabled", "disabled");
//             $('#timer'+no).css('display','none');
//             $('#mdlcolly2').modal('hide');
//         }
//         });
// }


function btnRestartPacking(no) {
    var jenis  = $('#jenis'+no).val();
    var no_spb = $('#nodoc'+no).val();
    var pic = $('#pic'+no).val();
    var d    = new Date();
    var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    var wkt  = d.getFullYear()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    //  console.log(jenis, no_spb);

    Swal.fire({
        title: 'Apakah Anda Yakin Akan Melakukan Restart?',
        type: 'question',
        showCancelButton: true,
        allowOutsideClick: false
    }).then(result => {
        if (result.value) {
            $('#mulai'+no).val(wkt);
            $("#btnrestartSPB"+no).removeClass('btn-info').addClass('btn-warning');
            $.ajax ({
                url : baseurl + "KapasitasGdSparepart/Packing/updateMulai",
                data: {jenis : jenis, no_spb : no_spb, date : date, pic : pic},
                type : "POST",
                dataType: "html",
                success: function(data){
                    swal.fire("Berhasil!", "Restart telah dilakukan.", "success");
                }
            });
    }})
}


function btnPausePacking(no) {
    var jenis  = $('#jenis'+no).val();
    var no_spb = $('#nodoc'+no).val();
    var mulai  = $('#mulai'+no).val();
    var d    = new Date();
    var wkt  = d.getFullYear()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();

    Swal.fire({
        title: 'Apakah Anda Yakin?',
        text : 'Pause akan dilakukan...',
        type: 'question',
        showCancelButton: true,
        allowOutsideClick: false
    }).then(result => {
        if (result.value) {
            $('#btnPacking'+no).attr("disabled", "disabled");
            $('#btnrestartSPB'+no).attr("disabled", "disabled");
            $('#timer'+no).css('display','none');
            $.ajax ({
                url : baseurl + "KapasitasGdSparepart/Packing/pauseSPB",
                data: {jenis : jenis, no_spb : no_spb, wkt : wkt, mulai : mulai},
                type : "POST",
                dataType: "html",
                success: function(data){
                    swal.fire("Berhasil!", "Waktu telah ditunda.", "success");
                    packing();
                    selesaiPacking();
                }
            });
        }
    })
}


function gantikemasan(no) {
    var no_spb       = $('#no_spb'+no).val();
    var jenis_kemasan  = $('#jenis_kemasan'+no).val();
    var berat        = $('#berat'+no).val();
    // console.log(no_spb);
    $.ajax ({
        url : baseurl + "KapasitasGdSparepart/Packing/gantiPacking",
        data: { no_spb : no_spb, jenis_kemasan : jenis_kemasan, berat : berat, no : no},
        type : "POST",
        dataType: "html"
    });
}


function transactDOSP(th) {
    var no_spb  = $('#spbcolly').val();
    var valBtn = $('#btnPacking'+no_spb).val();
    var jenis  = $('#jenis'+no_spb).val();
    var no_spb = $('#nodoc'+no_spb).val();
    var pic = $('#pic'+no_spb).val();
    var d    = new Date();
    var date = d.getDate()+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear()+" "+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    var wkt  = d.getFullYear()+'-'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    //  console.log(jenis, no_spb);

    var hoursLabel   = document.getElementById("hours"+no_spb);
    var minutesLabel = document.getElementById("minutes"+no_spb);
    var secondsLabel = document.getElementById("seconds"+no_spb);
    var totalSeconds = 0;
    var timer = null;

    $(th).attr('disabled', 'disabled');
    $.ajax ({
        url: baseurl + 'KapasitasGdSparepart/Packing/cekTransact',
        type: 'POST',
        dataType: 'JSON',
        data: {
            no_spb: no_spb
        },
        beforeSend: function() {
            Swal.showLoading();
        },
        success: function(result) {
            if (result) {
                $.ajax ({
                    url: baseurl + 'KapasitasGdSparepart/Packing/transactDOSP',
                    type: 'POST',
                    data: {
                        no_spb: no_spb
                    },
                    beforeSend: function() {
                        Swal.showLoading();
                    },
                    success: function(result) {
                        Swal.fire({
                            title: "Sukses",
                            text: "Transact " + no_spb + " berhasil!",
                            type: "success"
                        }).then(function() {
                            $('#btnPacking'+no_spb).attr("disabled", "disabled");
                            $('#btnrestartSPB'+no_spb).attr("disabled", "disabled");
                            var mulai  = $('#mulai'+no_spb).val();
                            $('#timer'+no_spb).css('display','none');

                            $.ajax ({
                                url : baseurl + "KapasitasGdSparepart/Packing/updateSelesai",
                                data: { date : date,jenis : jenis, no_spb : no_spb, mulai : mulai, wkt : wkt, pic : pic},
                                type : "POST",
                                dataType: "html",
                                success: function(result) {
                                    packing();
                                    selesaiPacking();
                                }
                            });
                            $(th).removeAttr('disabled');
                            $('#modalPacking').modal('hide');
                        });
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.error();
                    }
                })
            }
            else {
                Swal.fire(
                    'Oops!',
                    'Ada item yang belum dipacking!!',
                    'error'
                )
                $(th).removeAttr('disabled');
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.error();
        }
    })
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////// CETAK DOSP ///////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function cetakDOSP() {
    ajax_packing = $.ajax({
        url: baseurl + 'KapasitasGdSparepart/Cetak/getCetakDO',
        type: 'POST',
        beforeSend: function() {
          $('#loadingAreaCetak').show();
          $('div.table_area_cetak').hide();
          selesai();
        },
        success: function(result) {
          // console.log(result);
          $('#loadingAreaCetak').hide();
          $('div.table_area_cetak').show();
          $('div.table_area_cetak').html(result);
          // $('#tipe').val('NORMAL');

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
    })
}


function selesaiCetakDOSP() {
    ajax_packing_sls = $.ajax({
        url: baseurl + 'KapasitasGdSparepart/Cetak/getSelesaiCetakDO',
        type: 'POST',
        beforeSend: function() {
          $('#loadingArea7').show();
          $('div.table_area_selesai3').hide();
          selesai();
        },
        success: function(result) {
          // console.log(result);
          $('#loadingArea7').hide();
          $('div.table_area_selesai3').show();
          $('div.table_area_selesai3').html(result);
          // $('#tipe').val('NORMAL');

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
    })
}


function refreshCetak() {
    cetakDOSP();
    selesaiCetakDOSP();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////// MONITORING ///////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function addDoSpb(th){
	var title = $(th).text();
	$('#DoSpb').slideToggle('slow');
}

function addDoSpb2(th, num){
	var title = $(th).text();
	$('#DoSpb'+num).slideToggle('slow');
}

function addRinPelayanan1(th){
	var title = $(th).text();
	$('#RinPelayanan1').slideToggle('slow');
	$('#RinPelayanan2').slideToggle('slow');
}

function addRinPelayanan2(th, num){
	var title = $(th).text();
	$('#RinPelayanan1'+num).slideToggle('slow');
	$('#RinPelayanan2'+num).slideToggle('slow');
}

function addRinPengeluaran1(th){
	var title = $(th).text();
	$('#RinPengeluaran1').slideToggle('slow');
	$('#RinPengeluaran2').slideToggle('slow');
}

function addRinPengeluaran2(th, num){
	var title = $(th).text();
	$('#RinPengeluaran1'+num).slideToggle('slow');
	$('#RinPengeluaran2'+num).slideToggle('slow');
}

function addRinPacking1(th){
	var title = $(th).text();
	$('#RinPacking1').slideToggle('slow');
	$('#RinPacking2').slideToggle('slow');
}

function addRinPacking2(th, num){
	var title = $(th).text();
	$('#RinPacking1'+num).slideToggle('slow');
	$('#RinPacking2'+num).slideToggle('slow');
}


function schMonitoringSPB(th) {
	$(document).ready(function(){
	var tglAkh = $('#tglAkhir').val();
	var tglAwl = $('#tglAwal').val();
	// console.log(tglAwl);
	var request = $.ajax({
        url: baseurl+'KapasitasGdSparepart/Monitoring/searchSPB',
        data: {	tglAkh : tglAkh, tglAwl : tglAwl },
        type: "POST",
        datatype: 'html'
	});
	$('#tb_MonSPB').html('');
	$('#tb_MonSPB').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );
	request.done(function(result){
        $('#tb_MonSPB').html('');
        $('#tb_MonSPB').html(result);

        })
	});
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////// PENYERAHAN ///////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function getDataPenyerahan(th) {
    var tglAwal = $('#tglAwal').val();

    var request = $.ajax({
        url: baseurl+'KapasitasGdSparepart/Penyerahan/getData',
        data: {tglAwal : tglAwal },
        type: "POST",
        datatype: 'html'
	});
	$('#tb_penyerahan').html('');
	$('#tb_penyerahan').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );
	request.done(function(result){
        $('#tb_penyerahan').html('');
        $('#tb_penyerahan').html(result);

    })
}


function upnostttpenyerahan(event, th) {
    if (event.keyCode === 13) {
        var valno = $('#noscan').val();
        var qty   = Number($('#tbserah tbody tr[data-row="'+valno+'"] input[name="item[]"]').val());
        var jml   = Number($('#tbserah tbody tr[data-row="'+valno+'"] input[name="jmlscan[]"]').val());
        var tambah = jml + 1;
        $('#tbserah tbody tr[data-row="'+valno+'"] input[name="jmlscan[]"]').val(tambah);
        if (tambah > qty) {
            $.toaster('ERROR', 'Melebihi jumlah coly', 'danger');
            $('#tbserah tbody td[class="'+valno+'"]').addClass('bg-success');
            $('#tbserah tbody tr[data-row="'+valno+'"] input[name="jmlscan[]"]').val(qty);
        }else if (tambah == qty) {
            $('#tbserah tbody td[class="'+valno+'"]').addClass('bg-success');
        }
        $('#noscan').val('');
        // console.log('disini senang disana senang');
    }else{
        // console.log('hahahaha');
    }
}


function manifest() {
    ajax_manifest = $.ajax({
        url: baseurl + 'KapasitasGdSparepart/Penyerahan/getManifest',
        type: 'POST',
        beforeSend: function() {
          $('#loadingAreaPenyerahan').show();
          $('div.table_penyerahan').hide();
        },
        success: function(result) {
          // console.log(result);
          $('#loadingAreaPenyerahan').hide();
          $('div.table_penyerahan').show();
          $('div.table_penyerahan').html(result);

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
    })
}


function sudah_manifest() {
    ajax_sudah_manifest = $.ajax({
        url: baseurl + 'KapasitasGdSparepart/Penyerahan/getSudahManifest',
        type: 'POST',
        beforeSend: function() {
          $('#loadingAreaSdhPenyerahan').show();
          $('div.table_sudah_penyerahan').hide();
        },
        success: function(result) {
          // console.log(result);
          $('#loadingAreaSdhPenyerahan').hide();
          $('div.table_sudah_penyerahan').show();
          $('div.table_sudah_penyerahan').html(result);

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
    })
}


function inputManifest(event,no_spb) {
    if (event.keyCode === 13) {
        var no_spb    = $(no_spb).val().toUpperCase();
        var ekspedisi = $('#jenisEksped').val();
        // var colly   = $('#activeColly').val();
        // var no_spb  = $('#spbcolly').val();
        // var qty_pack = $('#qty'+colly+item).val();

        $.ajax({
            url: baseurl + 'KapasitasGdSparepart/Penyerahan/cekSiapManifest',
            type: 'POST',
            dataType: 'JSON',
            data: {
              no_spb: no_spb,
              ekspedisi: ekspedisi
            },
            beforeSend: function() {
                Swal.showLoading();
            },
            success: function(result) {
                if (result) {
                    $.ajax({
                        url: baseurl + 'KapasitasGdSparepart/Penyerahan/cekSudahManifest',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                          no_spb: no_spb
                        },
                        beforeSend: function() {
                            Swal.showLoading();
                        },
                        success: function(result) {
                            if (result) {
                                $.ajax({
                                    url: baseurl + 'KapasitasGdSparepart/Penyerahan/insertManifest',
                                    type: 'POST',
                                    dataType: 'JSON',
                                    data: {
                                      no_spb: no_spb,
                                      ekspedisi: ekspedisi
                                    },
                                    beforeSend: function() {
                                        Swal.showLoading();
                                    },
                                    success: function(result) {
                                        Swal.fire({
                                            title: "Sukses",
                                            text: "Berhasil menyimpan data!!",
                                            type: "success"
                                        }).then(function() {
                                            $('#inputSPBMan').val('');
                                            manifest();
                                            sudah_manifest();
                                        })
                                    }
                                })
                            }
                            else {
                                Swal.fire(
                                    'Oops!',
                                    'SPB/DOSP sudah pernah discan!!!',
                                    'error'
                                );
                                $('#inputSPBMan').val('');
                            }
                        }
                    })
                }
                else {
                    Swal.fire(
                        'Oops!',
                        'SPB/DOSP tidak ditemukan <br> atau salah pilih eksepedisi!!!',
                        'error'
                    );
                    $('#inputSPBMan').val('');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.error();
            }
        })
    } else {
        console.log("gagal");
    }
}


function generateNumber() {
    var ekspedisi = $('#jenisEksped').val();

    $.ajax({
        url: baseurl + 'KapasitasGdSparepart/Penyerahan/cekBeforeGenerate',
        type: 'POST',
        dataType: 'JSON',
        data: {
            ekspedisi: ekspedisi
        },
        beforeSend: function() {
            Swal.showLoading();
        },
        success: function(result) {
            if (result) {
                $.ajax({
                    url: baseurl + 'KapasitasGdSparepart/Penyerahan/generateManifestNum',
                    type: 'POST',
                    dataType: 'JSON',
                    beforeSend: function() {
                        Swal.showLoading();
                    },
                    success: function(result) {
                        Swal.fire({
                            title: "Sukses",
                            text: "Berhasil membuat manifest!!",
                            type: "success"
                        }).then(function() {
                            // $('#inputSPBMan').val();
                            manifest();
                            sudah_manifest();
                        })
                    }
                })
            }
            else {
                Swal.fire(
                    'Oops!',
                    'Tidak ditemukan data yang sudah discan <br> atau salah memilih ekspedisi!!!',
                    'error'
                )
            }
        }
      })
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////// ARSIP ////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function schArsipdospb(th) {
    var tgl_awal = $('#tglAwal').val();
    var tgl_akhir = $('#tglAkhir').val();
    $.ajax({
        url : baseurl + "KapasitasGdSparepart/Arsip/searchDataArsip",
        data : {tgl_awal : tgl_awal, tgl_akhir : tgl_akhir},
        type : 'POST',
        datatype : "html",
        beforeSend: function() {
            $('div#tbl_arsip_dospb' ).html('<center><img style="width:80px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
        },
        success : function (result) {
            $('div#tbl_arsip_dospb' ).html(result);
            $('#tbl_arsip').dataTable({
                "scrollX": true,
            });
        }
    })
}


function editColy(no) {
    var jenis  = $('#jenis'+no).val();
    var no_spb = $('#nospb'+no).val();

    var request = $.ajax ({
        url : baseurl + "KapasitasGdSparepart/Arsip/editColy",
        data: { jenis : jenis, no_spb : no_spb, no : no},
        type : "POST",
        dataType: "html",
        });

        request.done(function(result){
            $('#datacoly2').html(result);
            $('#editcoly').modal('show');
            $('#head_mdl_arsip').html(no_spb);
        })
}


function saveColly2(no) {
    var no_spb = $('#no_spb'+no).val();
    var no_colly = $('#no_colly'+no).val();
    var berat = $('#berat'+no).val();
    
    var request = $.ajax ({
        url : baseurl + "KapasitasGdSparepart/Arsip/saveColly2",
        data: { no_colly : no_colly, no_spb : no_spb, berat : berat},
        type : "POST",
        dataType: "html",
    });
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////// HISTORY ////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function detailJenisItem(no) {
    var tanggal = $('#tgl_input'+no).val();

    $.ajax({
        url : baseurl + "KapasitasGdSparepart/History/detailJenisItem",
        data : {tanggal : tanggal},
        type : 'POST',
        datatype : "html",
        success : function (result) {
            $('#datajenisitem').html(result);
            $('#detailjenisitem').modal('show');
            $('#tbl_jenisitem').dataTable({
                "scrollX": true,
            });
        }
    })
}

function schPICdospb(th) {
    var tgl_awal = $('#tglAwal').val();
    var tgl_akhir = $('#tglAkhir').val();
    getdataPIC(tgl_awal, tgl_akhir);
}


$(document).ready(function(){
    var history = document.getElementById('tbl_pic_dospb');
    if (history) {
        var d    = new Date();
        var tanggal  = ((d.getDate()).toString().length==2?(d.getDate()).toString():"0"+(d.getDate()).toString())+'/'+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+'/'+d.getFullYear();
        getdataPIC(tanggal, tanggal);

        $.ajax({
            url : baseurl + "KapasitasGdSparepart/History/searchDataHistory",
            type : 'POST',
            datatype : "html",
            beforeSend: function() {
                $('div#data_dospb_history' ).html('<center><img style="width:80px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
            },
            success : function (result) {
                $('div#data_dospb_history' ).html(result);
            }
        })
    }
})

function getdataPIC(tgl_awal, tgl_akhir) {
    $.ajax({
        url : baseurl + "KapasitasGdSparepart/History/searchDataPIC",
        data : {tgl_awal : tgl_awal, tgl_akhir : tgl_akhir},
        type : 'POST',
        datatype : "html",
        beforeSend: function() {
            $('div#tbl_pic_dospb' ).html('<center><img style="width:80px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
        },
        success : function (result) {
            $('div#tbl_pic_dospb' ).html(result);
            $('#tbl_pic_history').dataTable({
                "scrollX": true,
            });
        }
    })
}
