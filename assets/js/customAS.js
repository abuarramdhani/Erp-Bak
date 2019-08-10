$(document).ready(function(){
  $('.bio_tempat_lahir').select2({
    placeholder: "Tempat Lahir",
    minimumInputLength: 2,
    tags:true,
    allowClear: true,
    ajax: {
      url: baseurl+"ADMSeleksi/Menu/getkotaLahir",
      dataType:'json',
      type: "GET",
      data: function (params) {
        return {term: params.term,};
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.nama,
              text: item.nama
            };
          })

        };
      },
    },
  });

  $('.as_tglLahir').datepicker({
    format: 'dd/mm/yyyy',
    autoclose : true,
  });

  $('.as_agama').select2({
    allowClear: false,
    placeholder: "Pilih Agama",
    tags:true
  });

  $(".select-kota2").select2({
    allowClear: true,
    placeholder: "Pilih Kota",
    minimumInputLength: 1,
    tags:true,
    ajax: {
      url: baseurl+"ADMSeleksi/Menu/jsonKota2",
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
            return { id: obj.kokab_nama, text:obj.kokab_nama };
          })
        };
      }
    }
  });

  $(".as_select_institusi").select2({
    allowClear: true,
    placeholder: "Pilih Institusi",
    minimumInputLength: 1,
    tags:true,
    ajax: {
      url: baseurl+"ADMSeleksi/Menu/list_institusi",
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
            return { id: obj.institusi, text:obj.institusi };
          })
        };
      }
    }
  });

  $(".as_select_jurusan").select2({
    allowClear: true,
    placeholder: "Pilih Jurusan",
    minimumInputLength: 1,
    tags:true,
    ajax: {
      url: baseurl+"ADMSeleksi/Menu/list_jurusan",
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
            return { id: obj.jurusan, text:obj.jurusan };
          })
        };
      }
    }
  });

  $(".as_select_penempatan").select2({
    allowClear: false,
    placeholder: "Pilih Penempatan",
    tags:true,
    ajax: {
      url: baseurl+"ADMSeleksi/Menu/penempatan",
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
            return { id: obj.penempatan, text:obj.penempatan };
          })
        };
      }
    }
  });

  $('.as_select_penempatan').change(function(){
    var vall = $(this).val();
    // alert(vall);
    $(".as_select_pekerjaan").select2({
      placeholder: "[ Pilih Pekerjaan ]",
      minimumInputLength: 0,
      tags:true,
      allowClear: true,
      ajax: {
        url: baseurl+"ADMSeleksi/Menu/avail_job",
        dataType:'json',
        type: "GET",
        data: function (params) {
          return {term: params.term,
            penempatan: $('select.as_select_penempatan').val(),};
          },
          processResults: function (data) {
            return {
              results: $.map(data, function (item) {
                return {
                  id: item.job_nama,
                  text: item.job_nama
                };
              })

            };
          },
        },
      });
    $('.as_select_pekerjaan').attr('disabled', false);
  });

  $(".as_select_pendidikan").select2({
    placeholder: "Pilih jenjang Pendidikan",
    minimumInputLength: 0,
    tags:false,
    allowClear: false,
    ajax: {
      url: baseurl+"ADMSeleksi/Menu/getJenjang",
      dataType:'json',
      type: "GET",
      data: function (params) {
        return {term: params.term};
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.jenjang,
              text: item.jenjang
            };
          })

        };
      },
    },
  });

  $('.valHp').mask('Z00000000000000', {
      translation: {
        'Z': {
          pattern: /[+]/, optional: true
        }
      }
  });
  $('.valNilaiIjazah').mask('0.00');
  $('.valKTP').mask('0000000000000000');

  $('#as_pendidikan').change(function(){
    $('#as_nilaiIjazah').val('');
    var vall = $(this).val();
    if (vall == 'SD') {
      $('.valNilaiIjazah').mask('00.00');
    }else if (vall == 'SMP/SEDERAJAT') {
      $('.valNilaiIjazah').mask('00.00');
    }else if (vall == 'SMA/SMK/SEDERAJAT') {
      $('.valNilaiIjazah').mask('00.00');
    }else if (vall.substr(0,1) == 'D') {
      $('.valNilaiIjazah').mask('0.00');
    }else{
      $('.valNilaiIjazah').mask('0.00');
    }
  });

  $('#input_KTP').change(function(){
    $('#as_btn_submit').attr('disabled', false);
    var text = $(this).val();
    if (text.length < 16) {
      $('#as_alert_nik').css('color', 'red');
      $('#as_alert_nik').html('<i class="fa fa-times" aria-hidden="true"></i>  NIK / No. KTP harus 16 digit');
      // $('#as_alert_nik').html('<i class="fa fa-check" aria-hidden="true"></i>');
    }else{
      $.ajax({
        url : baseurl+"ADMSeleksi/Menu/checkData",
        type : 'GET',
        data : {
          'nik' : text
        },
        dataType:'json',
        success : function(data) { 
          // alert('Data: '+data);
          if (data == 'aman') {
            $('#as_alert_nik').css('color', 'green');
            $('#as_alert_nik').html('<i class="fa fa-check" aria-hidden="true"></i>  NIK / No. KTP Bisa Digunakan');
          }else if (data == 'tidak') {
            $('#as_btn_submit').attr('disabled', true);
            $('#as_alert_nik').css('color', 'red');
            $('#as_alert_nik').html('<i class="fa fa-times" aria-hidden="true"></i>  NIK / No. KTP Sudah Terdaftar');
          }        
        },
        error : function(request,error)
        {
          alert("Request: "+JSON.stringify(request));
        }
      });
    }
  });

  $('#as_btn_submit').click(function(){
   Swal.fire({
    showCancelButton: true,
    title: 'Apa anda sudah yakin?',
    // text: "Apa anda sudah yakin?",
    type: 'question',
    focusCancel: true
  }).then(function(result) {
    if (result.value) {
      setTimeout(function() {
        $('#as_btn_submit_true').click();
      }, 300);
    }
  });
});
});

$(document).on('ifChecked', '.rd_ijazah', function(){
  var isi = $(this).val();
  // alert(isi);
  $('#as_noIjazah').attr('readonly', false);
  $('#as_nilaiIjazah').attr('readonly', false);
  $('#as_nilaiIjazah').val('');
  if (isi == 'BL') {
    $('#as_noIjazah').val('BL');
    $('#as_nilaiIjazah').val('0.00');
    $('#as_noIjazah').attr('readonly', true);
    $('#as_nilaiIjazah').attr('readonly', true);
  }else if(isi == 'SK'){
    $('#as_noIjazah').val('SK');
    $('#as_noIjazah').attr('readonly', true);
  }else if(isi == 'Ijazah'){
    $('#as_noIjazah').val('');
  }
});

$(document).on('ifChecked', '#as_checkNoHp', function(){
  var no_hp = $('#as_noHP').val();
  $('#as_noWA').val(no_hp);
});

$(document).on('ifUnchecked', '#as_checkNoHp', function(){
  $('#as_noWA').val('');
});