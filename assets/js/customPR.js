$(document).ready(function() {
  $('#dataTables-kondite').DataTable( {
        dom: 'Bfrtip',
        buttons: [
          'excel','pdf'
        ]
      });
  $('#dataTables-masterGaji').DataTable({"lengthChange": false});
  $('#dataTables-potongan').DataTable( {
        dom: 'Bfrtip',
        buttons: [
          'excel','pdf'
        ]
      });
  $('#dataTables-masterGaji').DataTable( {
        dom: 'Bfrtip',
        buttons: [
          'excel','pdf'
        ]
      });
  $('#dataTables-tambahan').DataTable( {
        dom: 'Bfrtip',
        buttons: [
          'excel','pdf'
        ]
      });


  $('#btnCheckServer').click(function(){
    $(this).prop('disabled', true);
    $('#server-status').html('<i class="fa fa-spinner fa-2x faa-spin animated" style="color: #3c8dbc"></i>');
    $.ajax({
        url:baseurl+"PayrollManagementNonStaff/ProsesGaji/DataAbsensi/check_server",
        success:function(result)
        {
          if (result == 1) {
            $('#server-status').html('<i class="fa fa-check fa-2x faa-flash animated" style="color: green"></i>');
          }
          else{
            $('#server-status').html('<i class="fa fa-times fa-2x faa-flash animated" style="color: red"></i>');
          }
          $('#btnCheckServer').prop('disabled', false);
        },
        error:function()
        {
          $('#server-status').html('<i class="fa fa-times fa-2x faa-flash animated" style="color: red"></i>');
          $('#btnCheckServer').prop('disabled', false);
        }
      });
  });

  date_picker_non_staff();
  function date_picker_non_staff(){
    $('.date-picker-pr-non-staf').daterangepicker({
      "singleDatePicker": true,
      //"autoApply": true,
      "timePicker": false,
      "timePicker24Hour": false,
      "showDropdowns": false,
      locale: {
          format: 'YYYY-MM-DD'
        },
    });
  }

  date_picker_non_staff_with_time();
  function date_picker_non_staff_with_time(){
    $('.date-picker-pr-non-staf-with-time').daterangepicker({
      "singleDatePicker": true,
      //"autoApply": true,
      "timePicker": true,
      "timePicker24Hour": true,
      "showDropdowns": false,
      locale: {
          format: 'YYYY-MM-DD HH:mm:HH:mm:ss'
        },
    });
  }

  cmbNoind();
  function cmbNoind(){
    $(".cmbNoindHeader").select2({
      minimumInputLength: 3,
      ajax: {   
        url:baseurl+"PayrollManagementNonStaff/getNoind",
        dataType: 'json',
        type: "GET",
        data: function (params) {
          var queryParameters = {
            term: params.term,
          }
          return queryParameters;
        },
        processResults: function (data) {
          return {
            results: $.map(data, function(obj) {
              return { id:obj.NoInduk+' - '+obj.Kodesie, text:obj.NoInduk+' - '+obj.Nama};
            })
          };
        }
      } 
    });
  }

  cmbKodesie();
  function cmbKodesie(){
    $(".cmbKodesie").select2({
      minimumInputLength: 3,
      ajax: {   
        url:baseurl+"PayrollManagementNonStaff/getKodesie",
        dataType: 'json',
        type: "GET",
        data: function (params) {
          var queryParameters = {
            term: params.term,
          }
          return queryParameters;
        },
        processResults: function (data) {
          return {
            results: $.map(data, function(obj) {
              return { id:obj.Kodesie, text:obj.Kodesie+' - '+obj.Seksi};
            })
          };
        }
      } 
    });
  }

  $('#btnCetakForm').click(function(){
    var tgl1 = new Date($('#txtTanggal1').val());
    var tgl2 = new Date($('#txtTanggal2').val());
    var form = '';
    if (tgl1 > tgl2) {
      form += '<tr>'
            +   '<td colspan="8" class="text-center"><h4>End Date Must Be Greater Than Start Date</h4></td>'
            + '</tr>';
    }
    else{
      while(tgl1 <= tgl2){
        var day = ("0" + tgl1.getDate()).slice(-2);
        var month = ("0" + (tgl1.getMonth() + 1)).slice(-2);
        var year = tgl1.getFullYear();
        var full_date = year + '-' + month + '-' + day;
        form += '<tr>'
              +   '<td width="30%" class="text-center">'
              +     full_date
              +     '<input type="hidden" class="form-control" name="txtTanggalHeader[]" value="' + full_date + '" required>'
              +   '</td>'
              +   '<td width="7%"><input type="text" class="form-control text-center" name="txtMKHeader[]" placeholder="MK" required></td>'
              +   '<td width="7%"><input type="text" class="form-control text-center" name="txtBKIHeader[]" placeholder="BKI" required></td>'
              +   '<td width="7%"><input type="text" class="form-control text-center" name="txtBKPHeader[]" placeholder="BKP" required></td>'
              +   '<td width="7%"><input type="text" class="form-control text-center" name="txtTKPHeader[]" placeholder="TKP" required></td>'
              +   '<td width="7%"><input type="text" class="form-control text-center" name="txtKBHeader[]" placeholder="KB" required></td>'
              +   '<td width="7%"><input type="text" class="form-control text-center" name="txtKKHeader[]" placeholder="KK" required></td>'
              +   '<td width="7%"><input type="text" class="form-control text-center" name="txtKSHeader[]" placeholder="KS" required></td>'
              + '</tr>';

        var newDate = tgl1.setDate(tgl1.getDate() + 1);
        tgl1 = new Date(newDate);
      }
    }
    $('#FormWrapper').html(form);
    date_picker_non_staff();
    date_picker_non_staff_with_time();

    $('.approval').change(function(){
      var val = $(this).val();
      if (val == '1') {
        $(this).closest('tr').find('.approval-date').prop('readonly', false);
        $(this).closest('tr').find('.approval-by').prop('readonly', false);
      }
      else{
        $(this).closest('tr').find('.approval-date').prop('readonly', true);
        $(this).closest('tr').find('.approval-by').prop('readonly', true);
      }
    })

    cmbNoind();

  })

  $('#cmbKodesie').change(function(){
    var val = $(this).val();
    $('#cmbKodesie').prop('disabled', true);
    $('#cmbKodesie-loading').html('<i class="fa fa-spinner fa-2x faa-spin animated" style="color: #3c8dbc"></i>');
    $.ajax({
      type:'POST',
      data:{kodesie:val},
      url:baseurl+"PayrollManagementNonStaff/ProsesGaji/Kondite/getPekerja",
      success:function(result)
      {
        $('#FormWrapper').html(result);
        $('#cmbKodesie').prop('disabled', false);
        $('#cmbKodesie-loading').html('');
      },
      error:function()
      {
        var form = '';
        form += '<tr>'
            +   '<td colspan="8" class="text-center"><h4>Something Error, Please try again</h4></td>'
            + '</tr>';
        $('#FormWrapper').html(form);
        $('#cmbKodesie').prop('disabled', false);
        $('#cmbKodesie-loading').html('');
      }
    });
  })

  $('#btnImportDataAbsensi').click(function(){
    var loading_full =  '<div class="pace pace-active">'+
                        ' <div class="pace-progress" style="height:100px;width:80px" data-progress="100">'+
                        '  <div class="pace-progress-inner">'+
                        '  </div>'+
                        ' </div>'+
                        ' <div class="pace-activity">'+
                        ' </div>'+
                        '</div>';

    var file = $('input[name="file"]').val();
    var bulan = $('select[name="slcBulan"]').val();
    var tahun = $('input[name="txtTahun"]').val();

    $('#errorImportData').html('');
    $('#btnImportDataAbsensi').prop('disabled', true);

    if (file == '' || bulan == '' || tahun == '') {
      $('#errorImportData').html('<b style="color: red">Data belum lengkap</b>');
      $('#btnImportDataAbsensi').prop('disabled', false);
    }
    else{
      $('body').addClass('noscroll');
      $('#loadingAjax').addClass('overlay_loading');
      $('#loadingAjax').html(loading_full);

      var formDataAbsensi = new FormData($('#ImportDataAbsensi')[0]);

      //Import Request
      $.ajax({
        type:'POST',
        data:formDataAbsensi,
        url:$('#ImportDataAbsensi').attr('action'),
        success:function(result)
        {
          $('#errorImportData').html('<b style="color: #3c8dbc">Import Data Berhasil</b>');
          $('input[name="file_path"]').val('');
          $('input[name="file"]').val('');
          $('select[name="slcBulan"]').select2('val', null);
          $('input[name="txtTahun"]').val('');
          $('#btnImportDataAbsensi').prop('disabled', false);

          $('body').removeClass('noscroll');
          $('#loadingAjax').html('');
          $('#loadingAjax').removeClass('overlay_loading');
        },
        error:function()
        {
          $('#errorImportData').html('<b style="color: red">Terjadi Kesalahan</b>');
          $('#btnImportDataAbsensi').prop('disabled', false);

          $('body').removeClass('noscroll');
          $('#loadingAjax').html('');
          $('#loadingAjax').removeClass('overlay_loading');
        },
        contentType: false,
        processData: false
      });
    }
  });

  $('#btnPreClearData').click(function(){
    var loading_full =  '<div class="pace pace-active">'+
                        ' <div class="pace-progress" style="height:100px;width:80px" data-progress="100">'+
                        '  <div class="pace-progress-inner">'+
                        '  </div>'+
                        ' </div>'+
                        ' <div class="pace-activity">'+
                        ' </div>'+
                        '</div>';
    var bulan = $('select[name="slcBulan"]').val();
    var tahun = $('input[name="txtTahun"]').val();

    $('#errorClearData').html('');
    $('#btnPreClearData').prop('disabled', true);
    
    if (bulan == '' || tahun == '') {
      $('#errorClearData').html('<b style="color: red">Data belum lengkap</b>');
      $('#btnPreClearData').prop('disabled', false);
    }
    else{
      $('#btnPreClearData').prop('disabled', false);

      $('#clear-alert').modal();
      $('#btnClearData').click(function(){
        $('#clear-alert').modal('hide');
        $('#btnClearData').prop('disabled', true);

        $('body').addClass('noscroll');
        $('#loadingAjax').addClass('overlay_loading');
        $('#loadingAjax').html(loading_full);

        //Import Request
        $.ajax({
          type:'POST',
          data:$('#clearData').serialize(),
          url:$('#clearData').attr('action'),
          success:function(result)
          {
            $('#errorClearData').html('<b style="color: #3c8dbc">Hapus Data Berhasil</b>');
            $('input[name="file_path"]').val('');
            $('input[name="file"]').val('');
            $('select[name="slcBulan"]').select2('val', null);
            $('input[name="txtTahun"]').val('');
            $('#btnClearData').prop('disabled', false);

            $('body').removeClass('noscroll');
            $('#loadingAjax').html('');
            $('#loadingAjax').removeClass('overlay_loading');
          },
          error:function()
          {
            $('#errorClearData').html('<b style="color: red">Terjadi Kesalahan</b>');
            $('#btnClearData').prop('disabled', false);

            $('body').removeClass('noscroll');
            $('#loadingAjax').html('');
            $('#loadingAjax').removeClass('overlay_loading');
          }
        });
      });
    }
  });

  $('#btnImportDataLKH').click(function(){
    var loading_full =  '<div class="pace pace-active">'+
                        ' <div class="pace-progress" style="height:100px;width:80px" data-progress="100">'+
                        '  <div class="pace-progress-inner">'+
                        '  </div>'+
                        ' </div>'+
                        ' <div class="pace-activity">'+
                        ' </div>'+
                        '</div>';

    var file = $('input[name="file"]').val();
    var bulan = $('select[name="slcBulan"]').val();
    var tahun = $('input[name="txtTahun"]').val();

    $('#errorImportData').html('');
    $('#btnImportDataLKH').prop('disabled', true);

    if (file == '' || bulan == '' || tahun == '') {
      $('#errorImportData').html('<b style="color: red">Data belum lengkap</b>');
      $('#btnImportDataLKH').prop('disabled', false);
    }
    else{
      $('body').addClass('noscroll');
      $('#loadingAjax').addClass('overlay_loading');
      $('#loadingAjax').html(loading_full);


      var formDataLKH = new FormData($('#ImportDataLKH')[0]);

      //Import Request
      $.ajax({
        type:'POST',
        data:formDataLKH,
        url:$('#ImportDataLKH').attr('action'),
        success:function(result)
        {
          $('#errorImportData').html('<b style="color: #3c8dbc">Import Data Berhasil</b>');
          $('input[name="file_path"]').val('');
          $('input[name="file"]').val('');
          $('select[name="slcBulan"]').select2('val', null);
          $('input[name="txtTahun"]').val('');
          $('#btnImportDataLKH').prop('disabled', false);

          $('body').removeClass('noscroll');
          $('#loadingAjax').html('');
          $('#loadingAjax').removeClass('overlay_loading');
        },
        error:function()
        {
          $('#errorImportData').html('<b style="color: red">Terjadi Kesalahan</b>');
          $('#btnImportDataLKH').prop('disabled', false);

          $('body').removeClass('noscroll');
          $('#loadingAjax').html('');
          $('#loadingAjax').removeClass('overlay_loading');
        },
        contentType: false,
        processData: false
      });
    }
  });

  $('#btnProsesGaji').click(function(){
    var loading_full =  '<div class="pace pace-active">'+
                        ' <div class="pace-progress" style="height:100px;width:80px" data-progress="100">'+
                        '  <div class="pace-progress-inner">'+
                        '  </div>'+
                        ' </div>'+
                        ' <div class="pace-activity">'+
                        ' </div>'+
                        '</div>';

    var seksi = $('select[name="cmbKodesie"]').val();
    var bulan = $('select[name="cmbBulan"]').val();
    var tahun = $('input[name="txtTahun"]').val();

    $('#errorProsesGaji').html('');
    $('#btnProsesGaji').prop('disabled', true);

    if (seksi == '' || bulan == '' || tahun == '') {
      $('#errorProsesGaji').html('<b style="color: red">Data belum lengkap</b>');
      $('#btnProsesGaji').prop('disabled', false);
    }
    else{
      $('body').addClass('noscroll');
      $('#loadingAjax').addClass('overlay_loading');
      $('#loadingAjax').html(loading_full);

      //Hitung Request
      $.ajax({
        type:'POST',
        data:$('#ProsesGajiForm').serialize(),
        url:$('#ProsesGajiForm').attr('action'),
        success:function(result)
        {
          $('#errorProsesGaji').html('<b style="color: #3c8dbc">Hitung Gaji Berhasil</b>');
          $('#prosesGaji').html(result);
          // $('select[name="cmbKodesie"]').select2('val', null);
          // $('select[name="cmbBulan"]').select2('val', null);
          // $('input[name="txtTahun"]').val('');
          $('#btnProsesGaji').prop('disabled', false);

          $('body').removeClass('noscroll');
          $('#loadingAjax').html('');
          $('#loadingAjax').removeClass('overlay_loading');
        },
        error:function()
        {
          $('#errorProsesGaji').html('<b style="color: red">Terjadi Kesalahan</b>');
          $('#btnProsesGaji').prop('disabled', false);

          $('body').removeClass('noscroll');
          $('#loadingAjax').html('');
          $('#loadingAjax').removeClass('overlay_loading');
        }
      });
    }
  });

});