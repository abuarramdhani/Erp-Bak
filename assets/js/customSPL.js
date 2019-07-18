//--------------------- surat perintah lembur ----------------//
$(function () {
  // Initialize Elements
  /////////////////////////////////////////////////////////////////////////////////
  $(".spl-table").DataTable({
    "scrollX": true,
    "dom": 'Bfrtip',
    "buttons": [
                {
                  extend: 'excel',
                  className: 'btn btn-success'
                },
                {
                  text: 'Proses',
                  className: 'btn btn-primary disabled',
                  action: function(e, dt, node, config){
                    $('#btn-ProsesSPL').click();
                  }
                }
    ],
    "ordering": false,
    "retrieve": true,
    "initComplete": function(){
      if ($('#btn-ProsesSPL').attr('id') == undefined) {
        $('#example11_wrapper').find('a.dt-button:last').hide();
        $('#example11_wrapper').find('button.dt-button:last').hide();
      };
      $('#example11_wrapper').find('a.dt-button').removeClass('dt-button');
      $('#example11_wrapper').find('button.dt-button').removeClass('dt-button');
      $('#example11_wrapper').find('a.btn').css("margin-right","10px");
      $('#example11_wrapper').find('button.btn').css("margin-right","10px");
    }
  });

  $('.spl-date').daterangepicker({
    singleDatePicker: true,
    timePicker: false, 
    autoclose: true,
    locale: {
      format: 'DD-MM-YYYY'
    }
  });

  $('.spl-date-time').daterangepicker({
    timePicker: true, 
    timePickerIncrement: 1, 
    timePicker24Hour: true,
    singleDatePicker: true,
    locale: {
        format: 'DD-MM-YYYY HH:mm:ss'
    }
  });

  $(".spl-time").timepicker({
      defaultTime: 'value',
      minuteStep: 1,
      showMeridian:false,
      format: 'HH:mm:ss'
  });

  // Some Function
  /////////////////////////////////////////////////////////////////////////////////
  $('.spl-pkj-select2').select2({
    ajax:{
      url: baseurl+"SPLSeksi/C_splseksi/show_pekerja",
      dataType: 'json',
      type: 'get',
      data: function (params) {
        var other = "";

        if($('#noi').length){
          other = $('#noi').val();
        }

        return {key: params.term, key2: other};
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.noind,
              text: item.noind+' - '+item.nama,
            }
          })
        };
      },
      cache: true
    },
    minimumInputLength: 2,
    placeholder: 'Silahkan pilih',
    allowClear: true,
  });

  $('.spl-new-pkj-select2').select2({
    ajax:{
      url: baseurl+"SPLSeksi/C_splseksi/show_pekerja3",
      dataType: 'json',
      type: 'get',
      data: function (params) {
        var other = "";
          chk = "";
          $('.multiinput select').each(function(){
            if($(this).val() !== null) {chk += '.'+$(this).val();}
          });
          other = chk;

        return {key: params.term, key2: other};
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.noind,
              text: item.noind+' - '+item.nama,
            }
          })
        };
      },
      cache: true
    },
    minimumInputLength: 2,
    placeholder: 'Silahkan pilih',
    allowClear: true,
  });

  $('.spl-shift-select2').select2({
    ajax:{
      url: baseurl+"SPLSeksi/C_splseksi/show_shift",
      dataType: 'json',
      type: 'get',
      data: function (params) {
        var other = "";

        if($('#txtTanggal').length){
          other = $('#txtTanggal').val();
        }

        return {key: params.term, key2: other};
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.kd_shift,
              text: item.kd_shift+' - '+item.shift,
            }
          })
        };
      },
      cache: true
    },
    minimumInputLength: 1,
    placeholder: 'Silahkan pilih',
    allowClear: true,
  });

  $('.spl-pkj-select22').select2({
    ajax:{
      url: baseurl+"SPLSeksi/C_splseksi/show_pekerja2",
      dataType: 'json',
      type: 'get',
      data: function (params) {
        return {key: params.term};
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.noind,
              text: item.noind+' - '+item.nama,
            }
          })
        };
      },
      cache: true
    },
    minimumInputLength: 2,
    placeholder: 'Silahkan pilih',
    allowClear: true,
  });

  $('.spl-sie-select2').select2({
    ajax:{
      url: baseurl+"SPLSeksi/C_splseksi/show_seksi",
      dataType: 'json',
      type: 'get',
      data: function (params) {
        var other = "";

        if($('#kodel').length){
          other = $('#kodel').val();
        }

        return {key: params.term, key2: other};
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.kode,
              text: item.kode+' - '+item.nama,
            }
          })
        };
      },
      cache: true
    },
    minimumInputLength: 2,
    placeholder: 'Silahkan pilih',
    allowClear: true,
  });

  $('#spl-pencarian').on('click', function(e) {
    e.preventDefault();
    var table = $('.spl-table').DataTable();;
    var alamate = baseurl+"SPLSeksi/C_splseksi/data_spl_filter";

    table.clear().draw();
    $.ajax({
      url: alamate,
      type: "POST",
      data: {
        dari:$('#tgl_mulai').val(), 
        sampai:$('#tgl_selesai').val(), 
        status:$('#status').val(), 
        lokasi:$('#lokasi').val(),
        noind:$('#noind').val()},
      success: function(data) {
        if(data != "[]"){
          var send = $.parseJSON(data);
          table.rows.add(send);
          table.draw();
        }else{
          // alert('Data tidak di temukan');
        }
      }
    }); 
  });

  $('#example11').on('click','.spl-pkj-del',function(){
    $(this).closest('tr').remove();
  });

  $("#spl_pkj_add").click(function(e){
    e.preventDefault();
    $('.multiinput select[name*=noind]').last().select2("destroy");
    $('.multiinput').last().clone().appendTo('#example11 tbody');
    $(".multiinput:last .form-control").val("").change();
    $(".multiinput:last td:first").html("<button type='button' class='btn btn-danger spl-pkj-del'><span class='fa fa-trash'></span></button>");
    $(".multiinput:last select").val("").change();
    $(".multiinput:last .spl-new-error").remove();
    $(".multiinput:last select").closest("td").css("background", "#ffffff");
    $('.multiinput select[name*=noind]').select2({
      ajax:{
        url: baseurl+"SPLSeksi/C_splseksi/show_pekerja3",
        dataType: 'json',
        type: 'get',
        data: function (params) {
          var other = "";
          chk = "";
          $('.multiinput select').each(function(){
            if($(this).val() !== null) {chk += '.'+$(this).val();}
          });
          other = chk;
          return {key: params.term, key2: other};
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (item) {
              return {
                id: item.noind,
                text: item.noind+' - '+item.nama,
              }
            })
          };
        },
        cache: true
      },
      minimumInputLength: 2,
      placeholder: 'Silahkan pilih',
      allowClear: true,
    });
  });

  // $('#example11').on('change',".spl-cek", function(e){
  //   var noindSPL = $(this).val();
  //   var parentSelect = $(this).closest('td');
  //   if (noindSPL && noindSPL !== "") {
  //     $.ajax({
  //       url: baseurl+"SPLSeksi/C_splseksi/cek_anonymous",
  //       type: "POST",
  //       data: {
  //         tanggal: $('input[name*=tanggal]').val(),
  //         waktu0: $('input[name*=waktu_0]').val(),
  //         waktu1: $('input[name*=waktu_1]').val(),
  //         lembur: $('select[name*=kd_lembur]').val(),
  //         noind: $(this).val()},
  //       async: false,
  //       success: function(data) {
  //         if(data){
  //           // alert("result code : "+data);
  //           parentSelect.css("background", "#ffe6e6");
  //           $("button[type*=submit]").attr("type", "button").attr("class", "btn btn-grey");
  //           // $(".spl-error").remove();
  //           parentSelect.find(".spl-new-error").remove();
  //           parentSelect.append("<p class='spl-new-error' style='color: red'><br><i style='color:#ed2b1f' class='fa fa-lg fa-info-circle spl-error' title='"+data+"'></i>  Peringatan : "+data+"</p>");
             
  //         }else{
  //           parentSelect.css("background", "#ffffff");
  //           $("button[type*=button]").attr("type", "submit").attr("class", "btn btn-primary");
  //           // $(".spl-error").remove();
  //           parentSelect.find(".spl-new-error").remove();
  //         }
  //       }, 
  //       error : function() {
  //         alert("error code : spl-cek");
  //       }
  //     });
  //   }

    $('#example11').on('change',".spl-cek", function(e){
    var noindSPL = $(this).val();
    var parentSelect = $(this).closest('td');
    var parentTr = $(this).closest('tr');
    if (noindSPL && noindSPL !== "") {
      $.ajax({
        url: baseurl+"SPLSeksi/C_splseksi/cek_anonymous2",
        type: "POST",
        data: {
          tanggal: $('input[name*=tanggal]').val(),
          waktu0: $('input[name*=waktu_0]').val(),
          waktu1: $('input[name*=waktu_1]').val(),
          lembur: $('select[name*=kd_lembur]').val(),
          noind: $(this).val()},
        async: false,
        success: function(data) {
          obj = $.parseJSON(data);
          // console.log(obj);
          if (obj['error'] == '1') {
            parentSelect.css("background", "#ffe6e6");
            $("button[type*=submit]").attr("type", "button").attr("class", "btn btn-grey");
            parentSelect.find(".spl-new-error").remove();
            parentSelect.append("<p class='spl-new-error' style='color: red'><br><i style='color:#ed2b1f' class='fa fa-lg fa-info-circle spl-error'></i>  Peringatan : "+obj['text']+"</p>");
            parentTr.find('input[name*=lbrawal]').val("");
            parentTr.find('input[name*=lembur_awal]').val("");
            parentTr.find('input[name*=lbrakhir]').val("");
            parentTr.find('input[name*=lembur_akhir]').val("");
            parentTr.find('input[name*=target]').prop('disabled',true);
            parentTr.find('input[name*=realisasi]').prop('disabled',true);
            parentTr.find('textarea[name*=alasan]').prop('disabled',true);
          }else{
            parentTr.find('input[name*=target]').prop('disabled',false);
            parentTr.find('input[name*=realisasi]').prop('disabled',false);
            parentTr.find('textarea[name*=alasan]').prop('disabled',false);
            parentTr.find('input[name*=lbrawal]').val(obj['awal']);
            parentTr.find('input[name*=lembur_awal]').val(obj['awal']);
            parentTr.find('input[name*=lbrakhir]').val(obj['akhir']);
            parentTr.find('input[name*=lembur_akhir]').val(obj['akhir']);
            parentSelect.css("background", "#ffffff");
            parentSelect.find(".spl-new-error").remove();
            chk = "0";
            $('.spl-new-error').each(function(){
              chk = "1";
            }); 
            if(chk == "0") {
              $("button[type*=button]").attr("type", "submit").attr("class", "btn btn-primary");
            }
            
            
          }
        }, 
        error : function() {
          alert("error code : spl-cek");
        }
      });
    }
      
  });

  $('#spl-rekap').on('click', function(e) {
    e.preventDefault();
    var table = $('.spl-table').DataTable();;
    var alamate = baseurl+"SPLSeksi/C_splseksi/rekap_spl_filter";

    table.clear().draw();
    $.ajax({
      url: alamate,
      type: "POST",
      data: {
        dari:$('#tgl_mulai').val(), 
        sampai:$('#tgl_selesai').val(), 
        noi:$('#noi').val(), 
        noind:$('#noind').val()},
      success: function(data) {
        if(data != "[]"){
          var send = $.parseJSON(data);
          table.rows.add(send);
          table.draw();
        }else{
          // alert('Data tidak di temukan');
        }
      }
    });
  });

  $(document).ajaxStart(function(){
    $(".spl-loading").removeClass("hidden");
  });

  $(document).ajaxStop(function(){
    $(".spl-loading").addClass("hidden");
  });

  // $('#spl-chk-dt').on('click', function(e) {
  $('#spl-chk-dt').on('change', function(e){
    alert('dasfg');
    if(this.checked) {
      $('#tgl_mulai').prop("disabled", false);
      $('#tgl_selesai').prop("disabled", false);
    }else{
      $('#tgl_mulai').prop("disabled", true);
      $('#tgl_selesai').prop("disabled", true);
    }

  });

  for(x=0; x<2; x++){
    $('#spl-approval-'+x).on('click', {id: x}, function(e) {
      e.preventDefault();
      var id = e.data.id;
      var table = $('.spl-table').DataTable();;

      if(id == 0){
        var alamate = baseurl+"SPLSeksi/C_splkasie/data_spl_filter";
      }else{
        var alamate = baseurl+"SPLSeksi/C_splasska/data_spl_filter";
      }

      table.clear().draw();
      $.ajax({
        url: alamate,
        type: "POST",
        data: {
          dari:$('#tgl_mulai').val(), 
          sampai:$('#tgl_selesai').val(), 
          status:$('#status').val(), 
          lokasi:$('#lokasi').val(),
          noind:$('#noind').val(),
          kodesie:$('#kodesie').val()},
        success: function(data) {
          if(data != "[]"){
            var send = $.parseJSON(data);
            table.rows.add(send);
            table.draw();
          }else{
            // alert('Data tidak di temukan');
          }
        }
      }); 
    });

  }

  $(document).on('ready', function(){
    $('.spl-chk-data').iCheck('destroy');
  });

  function spl_load_data(){
    url = window.location.pathname;
    usr = $('#txt_ses').val();
    ket = $('#spl_tex_proses').val();

    if(url.indexOf('ALK') >= 0){
      tmp = "finspot:FingerspotVer;"+btoa(baseurl+'ALK/Approve/fp_proces?userid='+usr);
    }else{
      tmp = "finspot:FingerspotVer;"+btoa(baseurl+'ALA/Approve/fp_proces?userid='+usr);
    }
    
    chk = "";
    $('.spl-chk-data').each(function(){
      if(this.checked) {chk += '.'+$(this).val();}
    });
    console.log(chk);
    if (chk == "") {
      $('#example11_wrapper').find('a.btn-primary').addClass("disabled");
      $('#example11_wrapper').find('button.btn-primary').addClass("disabled");
      console.log("tidak ada");
    }else{
      $('#example11_wrapper').find('a.btn-primary').removeClass("disabled");
      $('#example11_wrapper').find('button.btn-primary').removeClass("disabled");
      console.log("ada");
    };

    if(url.indexOf('ALK') >= 0){
      $('#spl_proses_reject').attr('href', tmp+btoa('&stat=31&data='+chk+'&ket='+ket));
      $('#spl_proses_approve').attr('href', tmp+btoa('&stat=21&data='+chk+'&ket='+ket));
    }else{
      $('#spl_proses_reject').attr('href', tmp+btoa('&stat=35&data='+chk+'&ket='+ket));
      $('#spl_proses_approve').attr('href', tmp+btoa('&stat=25&data='+chk+'&ket='+ket));
    }
  }

  $(document).on('click', '.spl-chk-data', function(e){
    spl_load_data();
  });

  $(document).on('input', '#spl_tex_proses', function(e){
    spl_load_data();
  });

  $(document).on('click','#FingerDialogReject .spl_finger_proses',function(e){
    finger = $(this).attr('data');
    url = window.location.pathname;
    usr = $('#txt_ses').val();
    ket = $('#spl_tex_proses').val();

    if(url.indexOf('ALK') >= 0){
      tmp = "finspot:FingerspotVer;"+btoa(baseurl+'ALK/Approve/fp_proces?userid='+usr+'&finger_id='+finger);
    }else{
      tmp = "finspot:FingerspotVer;"+btoa(baseurl+'ALA/Approve/fp_proces?userid='+usr+'&finger_id='+finger);
    }
    
    chk = "";
    $('.spl-chk-data').each(function(){
      if(this.checked) {chk += '.'+$(this).val();}
    });

    if (chk == "") {
      $('#example11_wrapper').find('a.btn-primary').addClass("disabled");
    }else{
      $('#example11_wrapper').find('a.btn-primary').removeClass("disabled");
    };

    if(url.indexOf('ALK') >= 0){
      $('#spl_proses_reject').attr('href', tmp+btoa('&stat=31&data='+chk+'&ket='+ket));
      $('#spl_proses_approve').attr('href', tmp+btoa('&stat=21&data='+chk+'&ket='+ket));
    }else{
      $('#spl_proses_reject').attr('href', tmp+btoa('&stat=35&data='+chk+'&ket='+ket));
      $('#spl_proses_approve').attr('href', tmp+btoa('&stat=25&data='+chk+'&ket='+ket));
    }

    window.location.href = $('#spl_proses_reject').attr('href');
  });

  $(document).on('click','#FingerDialogApprove .spl_finger_proses',function(e){
    finger = $(this).attr('data');
    url = window.location.pathname;
    usr = $('#txt_ses').val();
    ket = $('#spl_tex_proses').val();

    if(url.indexOf('ALK') >= 0){
      tmp = "finspot:FingerspotVer;"+btoa(baseurl+'ALK/Approve/fp_proces?userid='+usr+'&finger_id='+finger);
    }else{
      tmp = "finspot:FingerspotVer;"+btoa(baseurl+'ALA/Approve/fp_proces?userid='+usr+'&finger_id='+finger);
    }
    
    chk = "";
    $('.spl-chk-data').each(function(){
      if(this.checked) {chk += '.'+$(this).val();}
    });

    if (chk == "") {
      $('#example11_wrapper').find('a.btn-primary').addClass("disabled");
    }else{
      $('#example11_wrapper').find('a.btn-primary').removeClass("disabled");
    };

    if(url.indexOf('ALK') >= 0){
      $('#spl_proses_reject').attr('href', tmp+btoa('&stat=31&data='+chk+'&ket='+ket));
      $('#spl_proses_approve').attr('href', tmp+btoa('&stat=21&data='+chk+'&ket='+ket));
    }else{
      $('#spl_proses_reject').attr('href', tmp+btoa('&stat=35&data='+chk+'&ket='+ket));
      $('#spl_proses_approve').attr('href', tmp+btoa('&stat=25&data='+chk+'&ket='+ket));
    }

    window.location.href = $('#spl_proses_approve').attr('href');
  });

});

$(document).ready(function(){
  $('.spl-time-mask').on('input', function(e){
    value = $(this).val();
    if (value.length > 0) {
      value = value.match(/\d/g);
      if (value !== null) {
        value = value.join("");
        valjam = value.substring(0,2);
        // console.log(valjam);
        if (parseInt(valjam) >= 24) {
          valjam = "23";
        }
        valmenit = value.substring(2,4);
        // console.log(valmenit);
        if (parseInt(valmenit) >= 60) {
          valmenit = "59";
        }
        valdetik = value.substring(4,6);
        // console.log(valdetik);
        if (parseInt(valdetik) >= 60) {
          valdetik = "59";
        }

        if (value.length > 4) {
          value = valjam.concat(':',valmenit,':',valdetik);
        }else if(value.length > 2){
          value = valjam.concat(':',valmenit);
        }
        
      }else{
        value = "00:00:00";
      }
    }
    $(this).val(value);
  });
  $('.spl-time-mask').on('focusout', function(e){
    value = $(this).val();
    if (value.length > 0) {
      value = value.match(/\d/g);
      if (value !== null) {
        value = value.join("");
        valjam = value.substring(0,2);
        if (parseInt(valjam) >= 24) {
          valjam = "23";
        }else if(parseInt(valjam) < 10 && valjam.length < 2){
          valjam = "0"+valjam;
        }
        if (valjam.length == 0) {
          valjam = "00";
        }

        valmenit = value.substring(2,4);
        if (parseInt(valmenit) >= 60) {
          valmenit = "59";
        }else if(parseInt(valmenit) < 10 && valmenit.length < 2){
          valmenit = "0"+valmenit;
        }
        if (valmenit.length == 0) {
          valmenit = "00";
        }

        valdetik = value.substring(4,6);
        if (parseInt(valdetik) >= 60) {
          valdetik = "59";
        }else if(parseInt(valdetik) < 10 && valdetik.length < 2){
          valdetik = "0"+valdetik;
        }
        if (valdetik.length == 0) {
          valdetik = "00";
        }
          
        value = valjam.concat(':',valmenit,':',valdetik);
        
      }else{
        value = "00:00:00";
      }
    }
    $(this).val(value);
  });

  $('#spl-memopresensi').on('submit',function(e){
    e.preventDefault();
    $.ajax({
      url : baseurl+'SPLSeksi/C_splseksi/submit_memo',
      type : 'POST',
      data : new FormData(this),
      processData: false,
      contentType: false,
      cache: false,
      async: true,
      success : function(data){
        window.location.href = baseurl+'SPLSeksi/C_splseksi/pdf_memo?id='+data;
      }
    })
  });

  $('#spl-fingerspot').on('click','.spl-fingerprint-modal-edit-triger',function(e){
    sn = $(this).closest("tr").find(".d-sn").text();
    vc = $(this).closest("tr").find(".d-vc").text();
    ac = $(this).closest("tr").find(".d-ac").text();
    vkey = $(this).closest("tr").find(".d-vkey").text();
    idf = $(this).attr("data-id");
    $('#spl-fingerprint-modal-edit-id').val(idf);
    $('#spl-fingerprint-modal-edit-sn').val(sn);
    $('#spl-fingerprint-modal-edit-vc').val(vc);
    $('#spl-fingerprint-modal-edit-ac').val(ac);
    $('#spl-fingerprint-modal-edit-vkey').val(vkey);
    $('#spl-fingerprint-modal-edit').modal({backdrop: 'static', keyboard: false});
    $('#spl-fingerprint-modal-edit').modal("show");
  });

  $('.spl-fingerprint-modal-edit-close').on('click',function(e){
    $('#spl-fingerprint-modal-edit').modal("hide");
  });

  $('#spl-fingerprint-modal-edit-update').on('click',function(e){
    idf   = $('#spl-fingerprint-modal-edit-id').val();
    sn    = $('#spl-fingerprint-modal-edit-sn').val();
    vc    = $('#spl-fingerprint-modal-edit-vc').val();
    ac    = $('#spl-fingerprint-modal-edit-ac').val();
    vkey  = $('#spl-fingerprint-modal-edit-vkey').val();
    if (sn == "" || vc == "" || ac == "" || vkey == "") {
      alert('Lengkapi Data Yang Masih Kosong !!');
    }else{
      $.ajax({
        data : {idf: idf, sn : sn, vc: vc, ac: ac, vkey: vkey},
        type : 'POST',
        url : baseurl+'/SPL/DaftarFingerspot/updateFingerspot',
        success: function(e){
          alert('Sukses');
          generateFingerspotTable();
          $('#spl-fingerprint-modal-edit').modal("hide");
        },
        error: function(request, status, error){
          alert(request.responseText);
        }
      });
    }
  });

  $('#spl-fingerprint-modal-add-triger').on('click',function(e){
    $('#spl-fingerprint-modal-add').modal({backdrop: 'static', keyboard: false});
    $('#spl-fingerprint-modal-add').modal("show");
  });

  $('.spl-fingerprint-modal-add-close').on('click',function(e){
    $('#spl-fingerprint-modal-add').modal("hide");
  });

  $('#spl-fingerprint-modal-add-save').on('click', function(e){
    sn    = $('#spl-fingerprint-modal-add-sn').val();
    vc    = $('#spl-fingerprint-modal-add-vc').val();
    ac    = $('#spl-fingerprint-modal-add-ac').val();
    vkey  = $('#spl-fingerprint-modal-add-vkey').val();
    if (sn == "" || vc == "" || ac == "" || vkey == "") {
      alert('Lengkapi Data Yang Masih Kosong !!');
    }else{
      $.ajax({
        data : {sn : sn, vc: vc, ac: ac, vkey: vkey},
        type : 'POST',
        url : baseurl+'/SPL/DaftarFingerspot/insertFingerspot',
        success: function(e){
          alert('Sukses');
          generateFingerspotTable();
          $('#spl-fingerprint-modal-add').modal("hide");
        },
        error: function(request, status, error){
          alert(request.responseText);
        }
      });
    }
  });

  $('#spl-fingerspot').on('click','.spl-fingerprint-delete',function(e){
    idf = $(this).attr("data-id");
    con = confirm("Yakin ingin menghapus device ini ?");
    if (con) {
      $.ajax({
        data : {id: idf},
        type : 'POST',
        url : baseurl+'/SPL/DaftarFingerspot/deleteFingerspot',
        success: function(e){
          alert('Sukses');
          generateFingerspotTable();
        },
        error: function(request, status, error){
          alert(request.responseText);
        }
      });
    } 
  });

  $('.spl-fingertemp-modal-select-noind').select2({
    ajax:{
      url: baseurl+"/SPL/Daftarjari/getUserfinger",
      dataType: 'json',
      type: 'get',
      data: function (params) {
        return {key: params.term};
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.noind,
              text: item.noind+' - '+item.noind_baru+' - '+item.nama,
            }
          })
        };
      },
      cache: true
    },
    minimumInputLength: 2,
    placeholder: 'Silahkan pilih',
    allowClear: true,
    dropdownParent: $('#spl-fingertemp-modal-user')
  });

  $('#spl-fingertemp-modal-add-user-triger').on('click',function(){
    $('.spl-fingertemp-modal-select-noind').select2("val","");
    $('#spl-fingertemp-modal-user').modal({backdrop: 'static', keyboard: false});  
    $('#spl-fingertemp-modal-user').modal("show");
  });

  $('.spl-fingertemp-modal-user-add').on('click', function(e){
    noind = $('.spl-fingertemp-modal-select-noind').val();
    $.ajax({
      data : {noind: noind},
      type : 'POST',
      url : baseurl+'/SPL/DaftarFingerspot/getfingerdata',
      success: function(data){
        $('#spl-fingertemp-modal-finger tbody').html(data);
        $('#spl-fingertemp-modal-finger').modal({backdrop: 'static', keyboard: false});
        $('#spl-fingertemp-modal-finger').modal("show");
        $('#spl-fingertemp-modal-user').modal("hide");
      },
      error: function(request, status, error){
          alert(request.responseText);
      }
    })
  });

  $('.spl-fingertemp-modal-user-close').on('click', function(){
    $('#spl-fingertemp-modal-user').modal("hide");
  });

  $('#spl-fingertemp').on('click','.spl-fingertemp-modal-add-temp-triger',function(){
    noind =$(this).attr('data-id');
    $.ajax({
      data : {noind: noind},
      type : 'POST',
      url : baseurl+'/SPL/DaftarFingerspot/getfingerdata',
      success: function(data){
        $('#spl-fingertemp-modal-finger tbody').html(data);
        $('#spl-fingertemp-modal-finger').modal({backdrop: 'static', keyboard: false});
        $('#spl-fingertemp-modal-finger').modal("show");
      },
      error: function(request, status, error){
          alert(request.responseText);
      }
    })
  });

  $('.spl-fingertemp-modal-finger-close').on('click',function(e){
    generateFingertempTable();
    $('#spl-fingertemp-modal-finger').modal("hide");
  });

  $('#spl-fingertemp').on('click','.spl-fingertemp-delete', function(e){
    noind = $(this).attr("data-id");
    con = confirm("Yakin ingin menghapus semua template finger no induk ("+noind+") ini ?");
    if (con) {
      $.ajax({
        data : {noind: noind},
        type : 'POST',
        url : baseurl+'/SPL/DaftarFingerspot/deleteFingertempAll',
        success: function(e){
          alert('Sukses');
          generateFingertempTable();
        },
        error: function(request, status, error){
          alert(request.responseText);
        }
      });
    } 
  });

  $('#spl-fingertemp-modal-finger').on('click','.spl-fingertemp-modal-finger-delete', function(e){
    jari = $(this).attr('data-fid');
    userid = $(this).attr('data-userid');
    noind = $(this).attr('data-noind');
    con = confirm("Apakah anda yakin ingin menghapus template finger ("+jari+") ini ?");
    if (con) {
      $.ajax({
        data : {jari: jari,userid: userid},
        type : 'POST',
        url : baseurl+'/SPL/DaftarFingerspot/deleteFingertemp',
        success: function(e){
          alert('Sukses');
          $.ajax({
            data : {noind: noind},
            type : 'POST',
            url : baseurl+'/SPL/DaftarFingerspot/getfingerdata',
            success: function(data){
              $('#spl-fingertemp-modal-finger tbody').html(data);
            },
            error: function(request, status, error){
                alert(request.responseText);
            }
          })
        },
        error: function(request, status, error){
          alert(request.responseText);
        }
      });
    }
  }); 

  $('#spl-fingertemp-modal-finger').on('click','.spl-fingertemp-modal-finger-add', function(e){
    jari = $(this).attr('data-fid');
    userid = $(this).attr('data-userid');
    noind = $(this).attr('data-noind');
    link_base64encode = btoa(baseurl+"/SPL/DaftarFingerspot/finger_register?userid="+userid+"&finger="+jari);
    window.location.href = "finspot:FingerspotReg;"+link_base64encode;
    var run = 0;
    var interval = setInterval(function(){
      $.ajax({
        data : {noind: noind},
        type : 'POST',
        url : baseurl+'/SPL/DaftarFingerspot/getfingerdata',
        success: function(data){
          $('#spl-fingertemp-modal-finger tbody').html(data);
          generateFingertempTable();
        },
        error: function(request, status, error){
            alert(request.responseText);
        }
      });
      if (run === 25) {
        clearInterval(interval);
      }
      run++;
    },1000);
  });
});

function generateFingerspotTable(){
  $.ajax({
    data : {id: '1'},
    type : 'POST',
    url : baseurl+'/SPL/DaftarFingerspot/generateFingerspotTable',
    success: function(data){
      $('tbody').html(data);
    },
    error: function(request, status, error){
      alert(request.responseText);
    }
  });
}

function generateFingertempTable(){
   $.ajax({
    data : {id: '1'},
    type : 'POST',
    url : baseurl+'/SPL/DaftarFingerspot/generateFingertempTable',
    success: function(data){
      $('tbody#spl-fingertemp').html(data);
    },
    error: function(request, status, error){
      alert(request.responseText);
    }
  });
}