//------------------Monitoring------------------//
$(document).ready(function () {
    $('#EPNS_Monitoring_kns').DataTable({
      scrollX: true,
      fixedColumns:   {
        leftColumns: 4,
      }
    });
    $('#EPNS_Monitoring_staf').DataTable({
      scrollX: true,
      fixedColumns:   {
        leftColumns: 4,
      }
    });
    $('#EPNS_Monitoring_cabang').DataTable({
      scrollX: true,
      fixedColumns:   {
        leftColumns: 4,
      }
    });
    $('#EPNS_Monitoring_knk').DataTable({
      scrollX: true,
      fixedColumns:   {
        leftColumns: 4,
      }
    });
    $('#EPNS_Monitoring_ospp').DataTable({
      scrollX: true,
      fixedColumns:   {
        leftColumns: 4,
      }
    });
    $('#EPNS_Monitoring_pkl').DataTable({
      scrollX: true,
      fixedColumns:   {
        leftColumns: 4,
      }
    });
  
    $('#btn_save_pekerja_evaluasi').prop('disabled', true);
  })
  
  $(function () {
    $('#pickerevaluasi').datepicker({
      Button: false
    }).on('change', function(){
      $('.datepicker').hide();
  });
  
  })
  
  
  $('#btnSearchEvaluasi').click(function () {
    let periode = $('#pickerevaluasi').val();
    let jenis = $('#OptionJenisEvaluasi').val();
    $('#surat-loading').attr('hidden', false);
  
    if (periode == '' || jenis == '') {
      Swal.fire({
        title: 'Peringatan',
        text: "Pastikan Anda telah mengisi parameter yang diperlukan. ;)",
        type: 'warning',
      });
      $('#surat-loading').attr('hidden', true);
    }else {
      $.ajax({
        method: 'post',
        data: {
          periode: periode,
          jenis: jenis
        },
        url: baseurl + 'EvaluasiPekerjaNonStaf/Create/getTabel',
        success: function (data) {
  
          $('#CreatePekerjaEvaluasi').html(data);
          let body = $('#bodyPekerjaCreate').text().trim();
  
          if (body == 'Mohon Maaf Data Tidak Ditemukan :(') {
            Swal.fire({
              title: 'Peringatan',
              text: "Mohon Maaf Data Tidak Ditemukan",
              type: 'warning',
            });
            $('#btn_save_pekerja_evaluasi').prop('disabled', true);
          }else {
              $(".minPekerejaCreate").on('click', function () {
                  console.log('a');
                  $(this).closest('tr').remove();
              })
            $('#btn_save_pekerja_evaluasi').prop('disabled', false);
          }
          $('#surat-loading').attr('hidden', true);
        }
      })
    }
  })
  
  
  $('#btn_save_pekerja_evaluasi').click(function () {
    let mulai = $('#pickerevaluasi').val()
    let jenis = $('#OptionJenisEvaluasi').val()
    let loading = baseurl + 'assets/img/gif/loadingquick.gif';
    let noind = []
    $('.noindPekerjaCreate').each(function () {
      let newbie = $(this).text().trim()
      noind.push(newbie);
    })
    swal.fire({
      title: 'Peringatan !',
      text: 'Data Akan di Proses, Apakah Anda Yakin ?',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      allowOutsideClick: false
    }).then(result => {
      if (result.value) {
        $.ajax({
          method: 'post',
          beforeSend: function(){
              Swal.fire({
                html : "<img style='width: 100px; height: auto;'src='"+loading+"'>",
                text : 'Loading...',
                customClass: 'swal-wide',
                showConfirmButton:false,
                allowOutsideClick: false
              });
            },
          data: {
            noind: noind,
            jenis: jenis,
            mulai: mulai
          },
          url: baseurl + 'EvaluasiPekerjaNonStaf/save',
          success: function () {
            if (jenis == 'J' || jenis == 'G') {
              window.location = baseurl + 'EvaluasiPekerjaNonStaf/MonitoringStaf'
            }else{
              window.location = baseurl + 'EvaluasiPekerjaNonStaf/Monitoring'
            }
          }
        })
      }
    })
  })
  
  function updateToday(id) {
    let loading = baseurl + 'assets/img/gif/loadingquick.gif';
  
    swal.fire({
      title: 'Peringatan !',
      text: 'Blangko Akan Dikirim, Apakah Anda Yakin ?',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      allowOutsideClick: false
    }).then(result => {
      if (result.value) {
        $.ajax({
          method: 'post',
          beforeSend: function(){
              Swal.fire({
                html : "<img style='width: 100px; height: auto;'src='"+loading+"'>",
                text : 'Loading...',
                customClass: 'swal-wide',
                showConfirmButton:false,
                allowOutsideClick: false
              });
            },
          data: {
            id:id
          },
          url: baseurl + 'EvaluasiPekerjaNonStaf/updateNow',
          success: function (data) {
            window.location.reload(function () {
              swal.close()
            })
          }
        })
      }
    })
  }
  
  function Blangko_masuk(id) {
    let loading = baseurl + 'assets/img/gif/loadingquick.gif';
  
    swal.fire({
      title: 'Apakah Anda Yakin !',
      text: 'Apakah Blangko Sudah Dikirim atau Diterima ?',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      allowOutsideClick: false
    }).then(result => {
      if (result.value) {
        $.ajax({
          method: 'post',
          beforeSend: function(){
              Swal.fire({
                html : "<img style='width: 100px; height: auto;'src='"+loading+"'>",
                text : 'Loading...',
                customClass: 'swal-wide',
                showConfirmButton:false,
                allowOutsideClick: false
              });
            },
          data: {
            id:id
          },
          url: baseurl + 'EvaluasiPekerjaNonStaf/updateBlangkoMasuk',
          success: function (data) {
              console.log(data);
              if (data == 'No') {
                  Swal.fire({
                      title: 'Peringatan',
                      text: 'Blangko Belum Dikirim !',
                      type: 'warning',
                      allowOutsideClick: false
                  })
              }else {
                  window.location.reload(function () {
                        swal.close()
                  })
              }
          }
        })
      }
    })
  }

  function hubker_seleksi(id) {
    let loading = baseurl + 'assets/img/gif/loadingquick.gif';
  
    swal.fire({
      title: 'Peringatan !',
      text: 'Apakah Anda Yakin Akan Mengirim ke Seleksi ?',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      allowOutsideClick: false
    }).then(result => {
      if (result.value) {
        $.ajax({
          method: 'post',
          beforeSend: function(){
              Swal.fire({
                html : "<img style='width: 100px; height: auto;'src='"+loading+"'>",
                text : 'Loading...',
                customClass: 'swal-wide',
                showConfirmButton:false,
                allowOutsideClick: false
              });
            },
          data: {
            id:id
          },
          url: baseurl + 'EvaluasiPekerjaNonStaf/Monitoring/update_hubker_seleksi',
          success: function (data) {
            window.location.reload(function () {
              swal.close()
            })
          }
        })
      }
    })
  }

  
  function lulus_gugur(id, ket) {
    let loading = baseurl + 'assets/img/gif/loadingquick.gif';
    if (ket == 'lulus') {
      swal.fire({
        title: 'Peringatan !',
        text: 'Apakah Anda Yakin ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        allowOutsideClick: false
      }).then(result => {
        if (result.value) {
          $.ajax({
            method: 'post',
            beforeSend: function(){
                Swal.fire({
                  html : "<img style='width: 100px; height: auto;'src='"+loading+"'>",
                  text : 'Loading...',
                  customClass: 'swal-wide',
                  showConfirmButton:false,
                  allowOutsideClick: false
                });
              },
            data: {
              id:id, alasan : 'lulus'
            },
            url: baseurl + 'EvaluasiPekerjaNonStaf/Monitoring/update_lulus_gugur',
            success: function (data) {
              window.location.reload(function () {
                swal.close()
              })
            }
          })
        }
      })
    }else{
      Swal.fire({
        title: 'Berikan Alasan Gugur',
        // html : "",
        // type: 'success',
        input: 'textarea',
        inputAttributes: {
          autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Submit',
        showLoaderOnConfirm: true,
      }).then(result => {
        if (result.value) {
          var val 		= result.value;
          $.ajax({
            url : baseurl+"EvaluasiPekerjaNonStaf/Monitoring/update_lulus_gugur",
            data : {id:id, alasan : val},
            type : "POST",
            success : function (data) {
              window.location.reload(function () {
                swal.close()
              })
            }
          })
      }else{
        Swal.fire({
          title: 'Peringatan',
          text: "Pastikan Anda telah alasan gugur",
          type: 'warning',
        });
      }})
    }
    
  }

  function kirim_nilai(id, noind) {
    $.ajax({
      url : baseurl + "EvaluasiPekerjaNonStaf/Monitoring/import_kirim_nilai",
      data : {id : id, noind : noind},
      type : "POST",
      dataType: "html",
      success: function(data) {
          $('#mdl_kirim_nilai').modal('show');
          $('#data_kirim_nilai').html(data);
          $(".slc_atasan_trainee").select2({
            allowClear: true,
            minimumInputLength: 3,
            ajax: {
              url: baseurl + "EvaluasiPekerjaNonStaf/Monitoring/get_atasan_trainee",
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
                    return {id: obj.noind, text: obj.noind+' - '+obj.nama};
                  })
                };
              }
            }
          });
      }
    })
  }
  
  $('#EPNS_cari_pekerja').on('click', function () {
    let param = $('#EPNS_get_cabang').val()
    let loading = baseurl + 'assets/img/gif/loadingquick.gif';
    console.log(param);
  
    $.ajax({
      type: 'post',
      data: {
        lokasi: param
      },
      beforeSend: function () {
        Swal.fire({
          html: "<img style='width: 100px; height: auto;' src='"+loading+"'>",
          showConfirmButton: false,
          allowOutsideClick: false
        })
      },
      url: baseurl + 'EvaluasiPekerjaNonStaf/getBlangkoBelumTerkirim',
      success: function (data) {
        swal.close()
        if (data == 'kosong') {
          swal.fire({
            title: 'Empty',
            text: 'Semua Blangko Telah di Proses',
            type: 'success',
            allowOutsideClick: false
          })
        }else {
          $('#nambahTabel').html(data)
          $('.table').find('table')
  
  
          $('.check_all').on('click', function () {
            let table = $(this).closest('table')
            if($(this).is(':checked')) {
              table.find('.checkbox_table').prop('checked',true)
            }else{
              table.find('.checkbox_table').prop('checked',false)
            }
          })
  
          $('#EPNS_buttonKirim').on('click', function () {
            let check_all = []
            let check = $('.checkbox_table:checked').each(function(){
              let onecheck = $(this).val()
              check_all.push(onecheck)
            })
  
            if (check_all == '') {
              swal.fire({
                title: 'Peringatan',
                text: 'Tidak Ada Data yang Dipilih',
                type: 'warning',
                allowOutsideClick: false,
              })
            }else {
              swal.fire({
                title: 'Peringatan !',
                text: 'Blangko Akan Dikirim, Apakah Anda Yakin ?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                allowOutsideClick: false
              }).then(result => {
                if (result.value) {
                  $.ajax({
                    type: 'post',
                    data: {
                      id: check_all,
                      share: 1
                    },
                    beforeSend: function () {
                      swal.fire({
                        html: '<img style="width: 100px; height: auto;" src="'+loading+'">',
                        showConfirmButton: false,
                        allowOutsideClick: false
                      })
                    },
                    url: baseurl + 'EvaluasiPekerjaNonStaf/updateNow',
                    success: function () {
                      window.location.reload(function () {
                        swal.close()
                      })
                    }
                  })
                }
              })
            }
          })
        }
      }
    })
  })
  
  
  $('#EPNS_cari_pekerja_staf').on('click', function () {
    let param = $('#EPNS_get_cabang').val()
    let loading = baseurl + 'assets/img/gif/loadingquick.gif';
    console.log(param);
  
    $.ajax({
      type: 'post',
      data: {
        lokasi: param
      },
      beforeSend: function () {
        Swal.fire({
          html: "<img style='width: 100px; height: auto;' src='"+loading+"'>",
          showConfirmButton: false,
          allowOutsideClick: false
        })
      },
      url: baseurl + 'EvaluasiPekerjaNonStaf/MonitoringStaf/getBlangkoBelumTerkirimStaf',
      success: function (data) {
        swal.close()
        if (data == 'kosong') {
          swal.fire({
            title: 'Empty',
            text: 'Semua Blangko Telah di Proses',
            type: 'success',
            allowOutsideClick: false
          })
        }else {
          $('#nambahTabel').html(data)
          $('.table').find('table')
  
  
          $('.check_all').on('click', function () {
            let table = $(this).closest('table')
            if($(this).is(':checked')) {
              table.find('.checkbox_table').prop('checked',true)
            }else{
              table.find('.checkbox_table').prop('checked',false)
            }
          })
  
          $('#EPNS_buttonKirim').on('click', function () {
            let check_all = []
            let check = $('.checkbox_table:checked').each(function(){
              let onecheck = $(this).val()
              check_all.push(onecheck)
            })
  
            if (check_all == '') {
              swal.fire({
                title: 'Peringatan',
                text: 'Tidak Ada Data yang Dipilih',
                type: 'warning',
                allowOutsideClick: false,
              })
            }else {
              swal.fire({
                title: 'Peringatan !',
                text: 'Blangko Akan Dikirim, Apakah Anda Yakin ?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                allowOutsideClick: false
              }).then(result => {
                if (result.value) {
                  $.ajax({
                    type: 'post',
                    data: {
                      id: check_all,
                      share: 1
                    },
                    beforeSend: function () {
                      swal.fire({
                        html: '<img style="width: 100px; height: auto;" src="'+loading+'">',
                        showConfirmButton: false,
                        allowOutsideClick: false
                      })
                    },
                    url: baseurl + 'EvaluasiPekerjaNonStaf/updateNow',
                    success: function () {
                      window.location.reload(function () {
                        swal.close()
                      })
                    }
                  })
                }
              })
            }
          })
        }
      }
    })
  })