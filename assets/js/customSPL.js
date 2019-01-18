//--------------------- surat perintah lembur ----------------//
$(function () {
  // Initialize Elements
  /////////////////////////////////////////////////////////////////////////////////
  $(".spl-table").DataTable({
    "scrollX": true,
    "dom": 'Bfrtip',
    "buttons": ['excel'],
    "aaSorting": []
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

  // Some Function
  /////////////////////////////////////////////////////////////////////////////////
  $('.spl-pkj-select2').select2({
    ajax:{
      url: baseurl+"SPLSeksi/C_SPLSeksi/show_pekerja",
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

  $('#spl-pencarian').on('click', function(e) {
    e.preventDefault();
    var table = $('#example1').DataTable();
    var alamate = baseurl+"SPLSeksi/C_SPLSeksi/data_spl_filter";

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
          
          table.clear();
          table.rows.add(send);
          table.draw();
        }else{
          alert('Data tidak di temukan');
        }
      }
    });
  });

  $("#spl_pkj_add").click(function(e){
    e.preventDefault();
    $('.multiinput select[name*=noind]').last().select2("destroy");
    $('.multiinput').last().clone().appendTo('#example1 tbody');
    $(".multiinput:last .form-control").val("").change();
    $('.multiinput select[name*=noind]').select2({
      ajax:{
        url: baseurl+"SPLSeksi/C_SPLSeksi/show_pekerja",
        dataType: 'json',
        type: 'get',
        data: function (params) {
          var other = "";
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

  $(".spl-cek").on('change', function(e){
    $.ajax({
      url: baseurl+"SPLSeksi/C_SPLSeksi/cek_anonymous",
      type: "POST",
      data: {
        tanggal: $('input[name*=tanggal]').val(),
        waktu0: $('input[name*=waktu_0]').val(),
        waktu1: $('input[name*=waktu_1]').val(),
        lembur: $('select[name*=kd_lembur]').val(),
        noind: $(this).val()},
      async: false,
      success: function(data) {
        if(data){
          alert("result code : "+data);
          $(".spl-cek").closest("td").css("background", "#ffe6e6");
        }else{
          $(".spl-cek").closest("td").css("background", "#ffffff");
        }
      }, 
      error : function() {
        alert("error code : spl-cek");
      }
    });
  });

  $('#spl-rekap').on('click', function(e) {
    e.preventDefault();
    var table = $('#example1').DataTable();
    var alamate = baseurl+"SPLSeksi/C_SPLSeksi/rekap_spl_filter";

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
          
          table.clear();
          table.rows.add(send);
          table.draw();
        }else{
          alert('Data tidak di temukan');
        }
      }
    });
  });


});