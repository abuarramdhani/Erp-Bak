$(document).ready(function() {

  var minDateCuti = $('#minDateCuti').val();

  $('#slc_approval1').on('change', function() {
    var noind = $('#slc_approval1').val();
    $('#slc_approval2').select2('val', '');
    $.ajax({
      method: 'POST',
      url: baseurl + 'PermohonanCuti/Tahunan/getApproval2',
      dataType: 'json',
      data: {
        noind: noind
      },
      success: function(data) {
        if (!$.trim(data)) {
          $('#submit_tahunan').attr("disabled", true);
          Swal.fire({
            title: 'Silahkan Menggunakan Form Manual',
            type: 'error',
            text: 'Tidak dapat mengambil cuti dengan aplikasi ERP'
          });
        } else {
          $('#slc_approval2 option.app2').remove();
          $.each(data, function() {
            $("#slc_approval2").append('<option class="app2" value="' + this.noind + '">' + this.noind + ' - ' + this.nama + '</option>');
          })
        }
      }
    })
  });

  $('.datatable-cuti').DataTable({
    'paging': true
  });

  $('#txtPengambilanCutiTahunan').datepicker({
    "autoclose": false,
    "multidate": true,
    "todayHighlight": true,
    "format": 'dd-M-yyyy',
    "startDate": minDateCuti,
    showButtonPanel: true,
    "clearBtn": true
  });

  $('#DetailTglCuti').datepicker({
    "autoclose": false,
    "multidate": true,
    "todayHighlight": true,
    "format": 'dd-M-yyyy',
    "clearBtn": true
  })

  $('#txtPengambilanCutiIstimewa').datepicker({
    "autoclose": false,
    "multidate": true,
    "todayHighlight": true,
    "format": 'dd-M-yyyy',
    "startDate": minDateCuti,
    "closeText": "Ok",
    "clearBtn": true
  });

  $('#txtPerkiraanLahir').datepicker({
    "autoclose": false,
    "multidate": false,
    "todayHighlight": true,
    "closeText": "Ok",
    "format": 'dd-mm-yyyy'
  });

  $('#txtPengambilanCutiTahunanSusulan').daterangepicker({
    // autoUpdateInput: false,
    locale: {
      format: 'DD-MMM-YYYY',
      cancelLabel: 'Clear'
    }
  });

  $('#txtPerkiraanLahir').on('change', function() {
    var hpl = $('#txtPerkiraanLahir').val();
    $('#txtSebelumLahir').prop('disabled', false);
    $('#txtSetelahLahir').prop('disabled', false);
  });

  //Tahunan
  $(".txtTglSusulan").hide();
  //Istimewa
  $('#submit_hpl').hide();
  $(".txtPerkiraanLahir").hide();
  $(".txtSebelumLahir").hide();
  $(".txtSetelahLahir").hide();
  $(".txtAlamat").hide();

  $('#slc_JenisCutiIstimewa').on('change', function() {
    var nilai = $('#slc_JenisCutiIstimewa').val();
    if (nilai == '6') {
      $(".txtPerkiraanLahir").show().removeClass('hidden');
      $(".txtSebelumLahir").show().removeClass('hidden');
      $(".txtSetelahLahir").show().removeClass('hidden');
      $(".txtAlamat").show().removeClass('hidden');
      $(".txtPengambilanCuti").hide();
      $('#submit_hpl').show().removeClass('hidden');
      $('#submit_istimewa').hide();
    } else {
      $(".txtPerkiraanLahir").hide();
      $(".txtSebelumLahir").hide();
      $(".txtSetelahLahir").hide();
      $(".txtAlamat").hide();
      $(".txtPengambilanCuti").show();
      $('#submit_hpl').hide();
      $('#submit_istimewa').show();
    }
  });

  $(".slc_Keperluan").hide();
  $('#slc_JenisCutiTahunan').on('change', function() {
    var nilai = $('#slc_JenisCutiTahunan').val();
    if (nilai == '13') {
      $(".slc_Keperluan").show();
      $(".txtKeperluan").hide();
      $(".txtTgl").hide();
      $(".txtTglSusulan").show();
      $(".txtTglSusulan").removeClass('hidden');
      $("#txtPengambilanCutiTahunan").val("");
      $("#txtKeperluan").val("");
      $("#slc_Keperluan").select2('val', "");
      $("#txtPengambilanCutiTahunanSusulan").val("");
    } else {
      $(".slc_Keperluan").hide();
      $(".txtKeperluan").show();
      $(".txtTgl").show();
      $(".txtTglSusulan").hide();
      $("#txtPengambilanCutiTahunanSusulan").val("");
      $("#slc_Keperluan").val("");
    }
  });

});


$('#slc_approval1').on('change', function() {
  var approval1 = $('#slc_approval1').val();
  var approval2 = $('#slc_approval2').val();
  if (approval2 == approval1 && approval1 != '' && approval2 != '') {
    $('#submit_tahunan').prop('disabled', true);
    Swal.fire(
      'Approval tidak boleh sama !', '', 'Info');
  } else {
    $('#submit_tahunan').prop('disabled', false);
  }
});

$('#slc_approval2').on('change', function() {
  var approval1 = $('#slc_approval1').val();
  var approval2 = $('#slc_approval2').val();
  if (approval2 == approval1 && approval1 != '' && approval2 != '') {
    $("#submit_tahunan").prop('disabled', true);
    Swal.fire(
      'Approval tidak boleh sama !', '', 'Info')
  } else {
    $('#submit_tahunan').prop('disabled', false);
  }
});

// Notifikasi Cuti Tahunan //
$(document).ready(function() {
      $('#submit_tahunan').click(function() {
        var jenis = $('#slc_JenisCutiTahunan').val();
        var tgl = $('#txtPengambilanCutiTahunan').val();
        var tglsusulan = $('#txtPengambilanCutiTahunanSusulan').val();
        var app1 = $('#slc_approval1').val();
        var app2 = $('#slc_approval2').val();

        if (jenis == '' || (tgl != '' && tglsusulan != '') || app1 == '' || app2 == '') {
          Swal.fire({
            title: 'Isi data dengan lengkap !',
            type: 'error',
            text: ""
          })
        } else {
          setTimeout(function() {
            $('#loadingCuti').modal('hide');
          }, 10000);

          $.ajax({
            method: 'POST',
            dataType: 'json',
            url: baseurl + 'PermohonanCuti/Tahunan/getOtorisasi',
            data: {
              jenis_cuti: jenis,
              tanggal: tgl,
              tanggalsusulan: tglsusulan
            },
            beforeSend: function(){
              $('#loadingCuti').modal({
                backdrop: "static",
                keyboard: false,
                show: true
              });
            },
            success: function(data) {
              console.log(data);
              $('#loadingCuti').modal('hide');
              if (data == '-') {
                Swal.fire({
                  title: 'Apakah Anda Yakin?',
                  text: "Menyimpan Permohonan Ini !",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Ya, Saya Yakin!'
                }).then((result) => {
                  if (result.value) {
                    $('#submit_tahunan2').click();
                    return true;
                  }
                });
                return false;
              } else {
                $('#txtPengambilanCutiTahunan').val('');
                Swal.fire({
                  title: data,
                  type: 'error',
                  text: "Ubah Tanggal Pengambilan Cuti"
                })
              }
            }
          })
        }
      });

      $('#slc_JenisCutiIstimewa').on('change', function() {
        var jenis = $('#slc_JenisCutiIstimewa').val();
        console.log(jenis);
        switch (jenis) {
          case '4':
            var ket = 'PCZ';
            break;
          case '5':
            var ket = 'CIK';
            break;
          case '6':
            var ket = 'CM';
            break;
          case '7':
            var ket = 'CS';
            break;
          case '8':
            var ket = 'CPA';
            break;
          case '9':
            var ket = 'CS';
            break;
          case '10':
            var ket = 'CBA';
            break;
          case '11':
            var ket = 'CIK';
            break;
          case '12':
            var ket = 'CPP';
            break;
          case '14':
            var ket = 'CK';
            break;
          default:
            var ket = '-';
            break;
        }
        console.log(ket);

        $.ajax({
          method: 'POST',
          url: baseurl + 'PermohonanCuti/Istimewa/getHakCuti',
          dataType: 'json',
          data: {
            ket: ket
          },
          success: function(data) {
            $("#txtHakCuti").val('');
            $("#txtHakCuti").val(data.trim());
          }
        })
      });
      //untuk istirahat melahirkan dibuat 2 tombol, ketika pilih tsb tampil tombol dengan id berbeda, function berbeda//
      $('#submit_istimewa').click(function() {
        var jenis = $('#slc_JenisCutiIstimewa').val();
        var tgl = $('#txtPengambilanCutiIstimewa').val();
        var hakCuti = $('#txtHakCuti').val();
        var app1 = $('#slc_approval1').val();
        var app2 = $('#slc_approval2').val();

        if (jenis == '' || tgl == '' || app1 == '' || app2 == '') {
          Swal.fire({
            title: 'Isi data dengan lengkap !',
            type: 'error',
            text: ""
          })
        } else {
          $('#loadingCuti').modal({
            backdrop: "static",
            keyboard: false,
            show: true
          });
          setTimeout(function() {
            $('#loadingCuti').modal('hide');
          }, 10000);
          $.ajax({
            method: 'POST',
            dataType: 'json',
            url: baseurl + 'PermohonanCuti/Istimewa/getOtorisasi',
            data: {
              jenis_cuti: jenis,
              tanggal: tgl,
              hak_cuti: hakCuti,
            },
            success: function(data) {
              console.log(data);
              $('#loadingCuti').modal('hide');
              //-----
              if (data[0] == '-') {
                if (jenis == '4' || jenis == '5' || jenis == '7') {
                  Swal.fire({
                    title: 'Harus mengirimkan Dokumen(Bukti) ke seksi Hubker',
                    text: "",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "<i class='fa fa-check'> Ya</i>",
                    cancelButtonText: "<i class='fa fa-close'> Batal</i>"
                  }).then((result) => {
                    if (result.value) {
                      Swal.fire({
                        title: 'Apakah Anda Yakin?',
                        text: "Menyimpan Permohonan Ini !",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Saya Yakin!'
                      }).then((result) => {
                        if (result.value) {
                          $('#submit_istimewa2').click();
                          return true;
                        }
                      });
                      return false;
                    }
                  })
                } else {
                  Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Menyimpan Permohonan Ini !",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Saya Yakin!'
                  }).then((result) => {
                    if (result.value) {
                      $('#submit_istimewa2').click();
                      return true;
                    }
                  });
                  return false;
                }
              } else {
                $('#txtPengambilanCutiIstimewa').val('');
                Swal.fire({
                  title: data[0],
                  type: 'error',
                  text: "Ubah Tanggal Pengambilan Cuti"
                })
              }
              //-----
            }
          })
        }
      });

      $('#submit_hpl').click(function() {
        var jenis = $('#slc_JenisCutiIstimewa').val();
        var hpl = $('#txtPerkiraanLahir').val();
        var beforeHpl = $('#txtSebelumLahir').val();
        var afterHpl = $('#txtSetelahLahir').val();
        var app1 = $('#slc_approval1').val();
        var app2 = $('#slc_approval2').val();

        if (jenis == '' || hpl == '' || beforeHpl == '' || afterHpl == '' || app1 == '' || app2 == '') {
          Swal.fire({
            title: 'Isi data dengan lengkap !',
            type: 'error',
            text: ""
          });
        } else {
          $('#loadingCuti').modal({
            backdrop: "static",
            keyboard: false,
            show: true
          });
          setTimeout(function() {
            $('#loadingCuti').modal('hide');
          }, 10000);
          $.ajax({
            method: 'POST',
            dataType: 'json',
            url: baseurl + 'PermohonanCuti/Istimewa/getOtorisasi',
            data: {
              jenis_cuti: jenis,
              hpl: hpl,
              before: beforeHpl,
              after: afterHpl
            },
            success: function(data) {
              if (data[0] == '-') { //lolos
                if (data[3] === data[4] && data[3] == 45 && data[4] == 45) {
                  Swal.fire({
                    title: 'Anda Mengambil Cuti ' + data[5] + ' Hari',
                    text: data[1] + ' s/d ' + data[2],
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "<i class='fa fa-check'> Ya, benar</i>",
                    cancelButtonText: "<i class='fa fa-close'> Tidak</i>"
                  }).then((result) => {
                    if (result.value) {
                      Swal.fire({
                        title: 'Harap Mengirimkan Surat HPL dari Dokter / Rumah Sakit',
                        text: "",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: "<i class='fa fa-check'> Ya</i>",
                        cancelButtonText: "<i class='fa fa-close'> Batal</i>"
                      }).then((result) => {
                        if (result.value) {
                          $('#submit_istimewa2').click();
                          return true;
                        }
                      });
                      return false;
                    }
                  })

                } else {
                  Swal.fire({
                    title: 'Anda Mengambil Cuti ' + data[5] + ' Hari',
                    text: data[1] + ' s/d ' + data[2],
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "<i class='fa fa-check'> Ya, Benar !</i>",
                    cancelButtonText: "<i class='fa fa-close'> Tidak</i>"
                  }).then((result) => {
                    if (result.value) {
                      Swal.fire({
                        title: 'Harap Mengirimkan Surat HPL dari Dokter / Rumah Sakit',
                        text: "",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: "<i class='fa fa-check'> Ya</i>",
                        cancelButtonText: "<i class='fa fa-close'> Batal</i>"
                      }).then((result) => {
                        if (result.value) {
                          Swal.fire({
                            title: 'Membuat Surat Pernyataan Siap Mengambil Resiko',
                            text: "",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: "<i class='fa fa-check'> Ya</i>",
                            cancelButtonText: "<i class='fa fa-close'> Tidak</i>"
                          }).then((result) => {
                            if (result.value) {
                              $('#submit_istimewa2').click();
                              return true;
                            }
                          });
                          return false;
                        }
                      });
                      return false;
                    }
                  })
                }
              } else {
                Swal.fire({
                  title: data[0],
                  type: 'error',
                  text: "Ubah Tanggal Pengambilan Cuti"
                });
              }
            }
          })
        }
      });

      $('#approveCuti').click(function() {
        var alasan = $('#txtAlasan').val();
        Swal.fire({
          title: "Apakah anda yakin ?",
          text: "Untuk Approve",
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya'
        }).then((result) => {
          if (result.value) {
            if (alasan != ''){
              $('#approveCuti').prop('disabled', true);
              $('#rejectCuti').prop('disabled', true);
            }
            $('#approveCuti2').click();
            return true;
          }
        });
        return false;
      })


      $('#rejectCuti').click(function() {
        var alasan  = $('#txtAlasan').val();
        Swal.fire({
          title: "Apakah anda yakin ?",
          text: "Untuk Reject",
          type: 'question',
          input: 'textarea',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya'
          ,
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.value) {
            let alasanReject = $('.swal2-textarea')
            if(alasanReject.val() == ''){
              alert("alasan harus diisi")
            }else{
              $('#txtAlasan').val(alasanReject.val())
              $('#approveCuti').prop('disabled', true);
              $('#rejectCuti').prop('disabled', true);

              $('#rejectCuti2').click();
              return true;
            }
          }
        });
        //return false;
      })

      $('#txtAlamatEdit').blur(function() {
        $('#noteEditAlamat').fadeOut(7000);
        $("#txtAlamatEdit").prop('readonly', true);
        $("#txtAlamatEdit").css({
          "border": "",
          "border-radius": ""
        });
      });

      $('#txtAlamatEdit').focus(function() {
        $("#txtAlamatEdit").css({
          "border": "1px solid blue",
          "border-radius": "2px"
        });
      });

      $('#txtAlamatEdit').on('change', function() {
        var alamat = $('#txtAlamatEdit').val();
        var id_cuti = $('#id_cuti').val();

        $.ajax({
          method: 'POST',
          dataType: 'json',
          url: baseurl + 'PermohonanCuti/DraftCuti/updateAlamat',
          data: {
            alamat: alamat,
            id: id_cuti
          },
          success: function(data) {
            alert(data);
            console.log("Alamat berhasil diubah jadi" + data);
          }
        })
      });

      $('#cancelCuti').on('click', function() {
        var id = $('#id_cuti').val();
        var noind = $('#noind').val();
        var tipe = $('#tipeCuti').val();

        swal.fire({
          title: 'Apakah Anda Yakin Untuk Membatalkan Cuti Ini ?',
          text: 'cuti akan direject & presensi cuti dihapus',
          html: "Alasan : <input type='text' id='alasan'>",
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#0da700',
          cancelButtonColor: '#ff0000',
          cancelButtonText: 'Tidak',
          confirmButtonText: 'Ya'
        }).then((result) => {
          if (result.value) {
            var alasan = $('#alasan').val();
            if(alasan == '' || alasan == null || alasan == ' '){
              alert("Alasan harus diisi !")
            }else{
              $.ajax({
                url: baseurl + 'PermohonanCuti/Approval/CancelCuti',
                method: 'POST',
                data: {
                  id_cuti: id,
                  noind: noind,
                  tipe: tipe,
                  alasan: alasan
                },
                success: function(data) {
                  var enc = data.replace(/\s/g, '');
                  var link = baseurl + 'PermohonanCuti/Approval/Approved/Detail/' + enc;
                  $('.form-horizontal').load(link + ' .form-horizontal')
                  swal.fire({
                    title: 'Cuti ini Berhasil di Batalkan',
                    type: 'success'
                  });
                }
              })
            }
          }
        })
      });
});

function delCuti(id) {
  Swal.fire({
    title: "Apakah anda yakin ?",
    text: "Cuti ini akan dihapus dan dibatalkan",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Hapus'
  }).then((result) => {
    if (result.value) {
      $('#loadingRequest').modal({
        backdrop: "static",
        keyboard: false,
        show: true
      });

      $.ajax({
        url: baseurl + 'PermohonanCuti/DraftCuti/Delete',
        data: {
          id_cuti: id
        },
        dataType: 'json',
        method: 'post'
      });

      $(document).ajaxStop(function() {
        var url = baseurl + "PermohonanCuti/DraftCuti";
        $('#row'+id).remove();
        $('#loadingRequest').modal('hide');
      });
    }
  });
  return false;
}

function reqCuti(id) {
  Swal.fire({
    title: "Apakah anda yakin ?",
    text: "Untuk Request Approval",
    type: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya'
  }).then((result) => {
    if (result.value) {
      $('#loadingRequest').modal({
        backdrop: "static",
        keyboard: false,
        show: true
      });

      $.ajax({
        url: baseurl + 'PermohonanCuti/DraftCuti/Request',
        data: {
          id_cuti: id
        },
        dataType: 'json',
        method: 'post',
        complete: function(){
          var url = baseurl + "PermohonanCuti/DraftCuti";
          $(".table").load(url + ' .table');
        }
      });

      setTimeout(function() {
        $('#loadingRequest').modal('hide');
      }, 3500);
    }
  })
  return false;
};

function ubahKeperluan() {
  $('#cancelKeperluan').removeClass('hidden');
  $('#DetailKeperluan').css('border','1px solid green');
  $('#DetailKeperluan').attr('readonly', false);
  $('#ubahKeperluan').addClass('hidden');
  $('#saveKeperluan').removeClass('hidden');
}

function batalKeperluan() {
  $('#cancelKeperluan').addClass('hidden');
  $('#DetailKeperluan').attr('readonly', true);
  $('#saveKeperluan').addClass('hidden');
  $('#ubahKeperluan').removeClass('hidden');
  $('#DetailKeperluan').css('border','');
}

function saveKeperluan(jenis) {
  $('#DetailKeperluan').css('border','');
  $('#DetailKeperluan').attr('readonly', true);
  $('#saveKeperluan').addClass('hidden');
  $('#ubahKeperluan').removeClass('hidden');
  let data = $('#DetailKeperluan').val();
  let id = $('#id_cuti').val();

  $.ajax({
    method: 'post',
    url: baseurl + 'PermohonanCuti/DraftCuti/changeKep',
    data: {jenis: jenis, data : data, id_cuti : id},
    success: function(data){
      console.log(data);
      Swal.fire({
        title: data,
        text: '',
        type: 'success'
      });
    }
  })
}

function ubahTglCuti(jenis) {
  if(jenis == '6'){
    $('#ModalEditCM').modal({
      backdrop: "static",
      keyboard: false,
      show: true
    });
  }else if(jenis == '13'){
    swal.fire({
      title: "Tidak dapat mengubah Tanggal Pengambilan Cuti Susulan",
      text: "Silahkan buat cuti baru",
      type: 'warning'
    });
  }else{
    $('#DetailTglCuti').css('border','1px solid green');
    $('#DetailTglCuti').attr('disabled', false);
    $('#ubahTglCuti').addClass('hidden');
    $('#saveTglCuti').removeClass('hidden');
    $('#cancelTglCuti').removeClass('hidden');
  }
}

function batalTgl() {
  $('#DetailTglCuti').css('border','').attr('disabled', true).val($('#DetailTglCuti').data('tgl'));
  $('#ubahTglCuti').removeClass('hidden');
  $('#saveTglCuti').addClass('hidden');
  $('#cancelTglCuti').addClass('hidden');
}

function saveTglCuti(id_cuti, tipe, jenis) {
  var tgl = $('#DetailTglCuti').val();
  // console.log(tgl);
  // console.log(tipe);
  // console.log(id_cuti);
  // console.log(jenis);

  if(tipe == 'Cuti Tahunan'){
    var url = baseurl + 'PermohonanCuti/DraftCuti/getOtorisasiTahunan';
    var tglsusulan = '';
    if(jenis == '13'){
      var tglsusulan = $('#txtPengambilanCutiTahunanSusulan').val();
      var tgl = '';
    }
    var data = {
      jenis_cuti: jenis,
      tanggal: tgl,
      tanggalsusulan: tglsusulan,
      id_cuti: id_cuti
    }
  }else{
    switch (jenis) {
      case 4:
        var hak = 1;
        break;
      case 5:
        var hak = 2;
        break;
      case 6:
        var hak = 91;
        break;
      case 7:
        var hak = 1;
        break;
      case 8:
        var hak = 2;
        break;
      case 9:
        var hak = 2;
        break;
      case 10:
        var hak = 2;
        break;
      case 11:
        var hak = 2;
        break;
      case 12:
        var hak = 3;
        break;
      case 14:
        var hak = 1;
        break;
      default:
        var hak = '-';
        break;
    }
    var url = baseurl + 'PermohonanCuti/DraftCuti/getOtorisasiIstimewa';
    var data = {
      jenis_cuti : jenis,
      tanggal: tgl,
      hak_cuti: hak,
      id_cuti: id_cuti
    }
  }

  $('#loadingEdit').modal({
    backdrop: "static",
    keyboard: false,
    show: true
  });

  $.ajax({
    method: 'POST',
    dataType: 'json',
    url: url,
    data: data,
    success: function(data) {
      $('#loadingEdit').modal('hide');
        if(data[0] == '-'){
          Swal.fire({
            title: "Tanggal Berhasil diubah",
            text: '',
            type: 'success'
          });
          $('#DetailTglCuti').css('border','');
          $('#DetailTglCuti').attr('disabled', true);
          $('#saveTglCuti').addClass('hidden');
          $('#ubahTglCuti').removeClass('hidden');
        }else{
          Swal.fire({
            title: data[0],
            text: 'Ubah Tanggal Pengambilan',
            type: 'warning'
          });
        }
      }
  });
}

function saveModalCM() {
  var id_cuti = $('#id_cuti').val();
  var hpl = $('#txtPerkiraanLahir').val();
  var beforeHpl = $('#txtSebelumLahir').val();
  var afterHpl = $('#txtSetelahLahir').val();
  var jenis = 6;
  if (hpl =='' || beforeHpl=='' || afterHpl=='') {
    swal.fire({
      title: 'Isi data dengan lengkap',
      text: '',
      type: 'warning'
    })
  }else{
    $.ajax({
      method: 'POST',
      dataType: 'json',
      url: baseurl + 'PermohonanCuti/DraftCuti/getOtorisasiIstimewa',
      data: {
        jenis_cuti: jenis,
        hpl: hpl,
        before: beforeHpl,
        after: afterHpl,
        id_cuti: id_cuti
      },
      success: function(data) {
        if (data[0] == '-') { //lolos
          if (data[3] === data[4] && data[3] == 45 && data[4] == 45) {
            Swal.fire({
              title: 'Anda Mengambil Cuti ' + data[5] + ' Hari',
              text: data[1] + ' s/d ' + data[2],
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: "<i class='fa fa-check'> Ya, benar</i>",
              cancelButtonText: "<i class='fa fa-close'> Tidak</i>"
            }).then((result) => {
              if (result.value) {
                Swal.fire({
                  title: 'Harap Mengirimkan Surat HPL dari Dokter / Rumah Sakit',
                  text: "",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: "<i class='fa fa-check'> Ya</i>",
                  cancelButtonText: "<i class='fa fa-close'> Batal</i>"
                }).then((result) => {
                  if (result.value) {
                    $('#submit_istimewa2').click();
                    return true;
                  }
                });
                return false;
              }
            })

          } else {
            Swal.fire({
              title: 'Anda Mengambil Cuti ' + data[5] + ' Hari',
              text: data[1] + ' s/d ' + data[2],
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: "<i class='fa fa-check'> Ya, Benar !</i>",
              cancelButtonText: "<i class='fa fa-close'> Tidak</i>"
            }).then((result) => {
              if (result.value) {
                Swal.fire({
                  title: 'Harap Mengirimkan Surat HPL dari Dokter / Rumah Sakit',
                  text: "",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: "<i class='fa fa-check'> Ya</i>",
                  cancelButtonText: "<i class='fa fa-close'> Batal</i>"
                }).then((result) => {
                  if (result.value) {
                    Swal.fire({
                      title: 'Membuat Surat Pernyataan Siap Mengambil Resiko',
                      text: "",
                      type: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: "<i class='fa fa-check'> Ya</i>",
                      cancelButtonText: "<i class='fa fa-close'> Tidak</i>"
                    }).then((result) => {
                      if (result.value) {
                        swal.fire({
                          title: 'Tanggal Pengambilan Cuti Telah diubah',
                          type: 'success'
                        })
                        $('#ModalEditCM').modal('hide');
                        location.reload();
                      }
                    });
                    return false;
                  }
                });
                return false;
              }
            })
          }
        } else {
          Swal.fire({
            title: data[0],
            type: 'error',
            text: "Ubah Tanggal Pengambilan Cuti"
          });
        }
      }
    })
  }
}
