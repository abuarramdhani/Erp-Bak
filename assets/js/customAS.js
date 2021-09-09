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


//-------------------------- PENJADWALAN dan HASIL TES PSIKOTEST ----------------------------------------------------------------------------------------

$(document).ready(function() {
	$('.waktu_psikotest').mask('00:00:00');
	
	$('.pickerpenjadwalan').datepicker({
	  todayHighlight: true,
	  format: 'dd/mm/yyyy',
	}).on('change', function(){
	  $('.datepicker').hide();
  });

  var smk_sma = document.getElementById('smk_sma_jdwl_psikotest');
  if (smk_sma) {
    findPenjadwalanPsikotest('SMK/SMA','smk_sma_jdwl_psikotest');
  }
  
  var d3s1 = document.getElementById('d3s1_jdwl_psikotest');
  if (d3s1) {
    findPenjadwalanPsikotest('D3/S1','d3s1_jdwl_psikotest');
  }
  
  var os = document.getElementById('os_jdwl_psikotest');
  if (os) {
    findPenjadwalanPsikotest('OS','os_jdwl_psikotest');
  }
  
  var cabang = document.getElementById('cabang_jdwl_psikotest');
  if (cabang) {
    findPenjadwalanPsikotest('Cabang','cabang_jdwl_psikotest');
  }
  
  var pkl = document.getElementById('pkl_magang_jdwl_psikotest');
  if (pkl) {
    findPenjadwalanPsikotest('PKL/Magang', 'pkl_magang_jdwl_psikotest');
  }
  
  var hasil_smksma = document.getElementById('smk_sma_hasil_psikotest');
  if (hasil_smksma) {
    findHasilTesPsikotest('SMK/SMA','smk_sma_hasil_psikotest');
  }
  
  var hasil_d3s1 = document.getElementById('d3s1_hasil_psikotest');
  if (hasil_d3s1) {
    findHasilTesPsikotest('D3/S1','d3s1_hasil_psikotest');
  }
  
  var hasil_os = document.getElementById('os_hasil_psikotest');
  if (hasil_os) {
    findHasilTesPsikotest('OS','os_hasil_psikotest');
  }
  
  var hasil_cabang = document.getElementById('cabang_hasil_psikotest');
  if (hasil_cabang) {
    findHasilTesPsikotest('Cabang','cabang_hasil_psikotest');
  }
  
  var hasil_pkl = document.getElementById('pkl_magang_hasil_psikotest');
  if (hasil_pkl) {
    findHasilTesPsikotest('PKL/Magang', 'pkl_magang_hasil_psikotest');
  }

  
  $(".get_nama_psikotest").select2({
    allowClear: true,
    // minimumInputLength: 3,
    ajax: {
        url: baseurl + "ADMSeleksi/Penjadwalan/get_nama_psikotest",
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
                results: $.map(data, function (obj) {
                    return {id:obj.id_tes, text:obj.nama_tes};
                })
            };
        }
    }
  });	
  
  $(".get_peserta_psikotest").select2({
    allowClear: true,
    // minimumInputLength: 3,
    ajax: {
        url: baseurl + "ADMSeleksi/MonitoringHasilTes/get_nama_peserta",
        dataType: 'json',
        type: "GET",
        data: function (params) {
                var queryParameters = {
                        term: params.term,
                        tipe : $('#tipe_seleksi_psikotest').val(),
                        tanggal : $('#tanggal_psikotest').val()
                }
                return queryParameters;
        },
        processResults: function (data) {
            return {
                results: $.map(data, function (obj) {
                    return {id:obj.nama_peserta, text:obj.nama_peserta};
                })
            };
        }
    }
  });	
  
  })

  function findPenjadwalanPsikotest(ket, id) {
    $.ajax({
      url : baseurl + 'ADMSeleksi/MonitoringPenjadwalan/search_monitoring',
      data : {ket : ket, id : id},
      type : 'post',
      dataType : 'html',
      beforeSend: function() {
      $('div#'+id ).html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
      },
      success : function(data) {
        $('div#'+id ).html(data);
        $('#tb_'+id).dataTable({
            "scrollX": true,
        });
      }
    })
  }
  
  function findHasilTesPsikotest(ket, id) {
    $.ajax({
      url : baseurl + 'ADMSeleksi/MonitoringHasilTes/search_monitoring',
      data : {ket : ket, id : id},
      type : 'post',
      dataType : 'html',
      beforeSend: function() {
      $('div#'+id ).html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
      },
      success : function(data) {
        $('div#'+id ).html(data);
        $('#tb_'+id).dataTable({
            "lengthMenu": [[10, 100, -1], [10, 100, "All"]],
          rowsGroup: [1,2],
        });
      }
    })
  }

  
  $(document).on('click', '.tombolhapus1',  function() {
    $(this).parents('.tambah_nama_psikotest').remove()
  });
  
  var i = 2;
  function tambah_nama_psikotest() {
	  $('#tambah_nama_psikotest').append(`<div class="tambah_nama_psikotest">
											<br><br>
											<div class="col-md-2"></div>
											<div class="col-lg-3">
												<select name="nama_test_psikotest[]" class="form-control select2 get_nama_psikotest" id="nama_test_psikotest`+i+`" style="width:100%" data-placeholder="pilih nama test"></select>
											</div>
											<div class="col-md-1">
											  <button type="button" class="btn btn-danger tombolhapus`+i+`"><i class="fa fa-minus"></i></button>
											</div>
										  </div>`);
  
	  $(document).on('click', '.tombolhapus'+i,  function() {
		  $(this).parents('.tambah_nama_psikotest').remove()
	  });
    $(".get_nama_psikotest").select2({
      allowClear: true,
      // minimumInputLength: 3,
      ajax: {
          url: baseurl + "ADMSeleksi/Penjadwalan/get_nama_psikotest",
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
                  results: $.map(data, function (obj) {
                      return {id:obj.id_tes, text:obj.nama_tes};
                  })
              };
          }
      }
    });	
  }
  
  function findDataPsikotest(th) {
	var tipe = $('#kode_akses_psikotest').val();
	var tanggal = $('#tanggal_surat_psikotest').val();
	$.ajax({
	  url : baseurl + 'ADMSeleksi/Penjadwalan/search',
	  data : {tipe : tipe, tanggal : tanggal},
	  type : 'post',
	  dataType : 'html',
	  beforeSend: function() {
		$('div#view_data_psikotest' ).html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
		},
		success : function(data) {
			$('div#view_data_psikotest' ).html(data);
			// $('#tb_peserta_psikotest').dataTable({
      //   scrollX: true,
      //   paging:false,
      //   scrollY : 500,
      // });
		}
	})
  }

  function delete_peserta_psikotest(no) {
    var nama = $('#nama_peserta'+no).val();
    var kode = $('#kode_lamaran'+no).val();
    
    let loading = baseurl + 'assets/img/gif/loadingquick.gif';
  
    swal.fire({
      title: 'Apakah anda yakin akan menghapus peserta '+nama+' ?',
      text: 'Data yang terhapus tidak bisa dikembalikan.',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      allowOutsideClick: false
    }).then(result => {
      if (result.value) {
        // $.ajax({
        //   method: 'post',
        //   beforeSend: function(){
        //       Swal.fire({
        //         html : "<img style='width: 100px; height: auto;'src='"+loading+"'>",
        //         text : 'Loading...',
        //         customClass: 'swal-wide',
        //         showConfirmButton:false,
        //         allowOutsideClick: false
        //       });
        //     },
        //   data: {
        //     kode : kode, nama : nama
        //   },
        //   url: baseurl + 'ADMSeleksi/Penjadwalan/hapus_peserta',
        //   success: function (data) {
            $('#tr_peserta'+no).remove();
            swal.close()
        //   }
        // })
      }
    })
  }

  
    function delete_peserta_psikotest2(no) {
      var nama = $('#nama_peserta'+no).val();
      var kode = $('#kode_akses'+no).val();
      
      let loading = baseurl + 'assets/img/gif/loadingquick.gif';
    
      swal.fire({
        title: 'Peringatan !',
        text: 'Apakah anda yakin akan menghapus peserta '+nama+' ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        allowOutsideClick: false
      }).then(result => {
        if (result.value) {
              $('#tr_peserta'+no).remove();
              var terhapus = $('input[name="peserta_terhapus"]').val();
              var peserta = terhapus+nama+'_'+kode+'+';
              $('input[name="peserta_terhapus"]').val(peserta);
              swal.close()
          // $.ajax({
          //   method: 'post',
          //   beforeSend: function(){
          //       Swal.fire({
          //         html : "<img style='width: 100px; height: auto;'src='"+loading+"'>",
          //         text : 'Loading...',
          //         customClass: 'swal-wide',
          //         showConfirmButton:false,
          //         allowOutsideClick: false
          //       });
          //     },
          //   data: {
          //     kode : kode, nama : nama
          //   },
          //   url: baseurl + 'ADMSeleksi/Penjadwalan/hapus_peserta2',
          //   success: function (data) {
          //     $('#tr_peserta'+no).remove();
          //     swal.close()
          //   }
          // })
        }
      })
    }

  function cari_hari(val) {
    if (val.match(/Sunday.*/)) {
      return 'Minggu';
    }else if (val.match(/Monday.*/)) {
      return 'Senin';
    }else if (val.match(/Tuesday.*/)) {
      return 'Selasa';
    }else if (val.match(/Wednesday.*/)) {
      return 'Rabu';
    }else if (val.match(/Thursday.*/)) {
      return 'Kamis';
    }else if (val.match(/Friday.*/)) {
      return 'Jumat';
    }else if (val.match(/Saturday.*/)) {
      return 'Sabtu';
    }
  }
  
  function cari_bulan(val) {
    if (val.match(/January.*/)) {
      return 'Januari';
    }else if (val.match(/February.*/)) {
      return 'Februari';
    }else if (val.match(/March.*/)) {
      return 'Maret';
    }else if (val.match(/May.*/)) {
      return 'Mei';
    }else if (val.match(/June.*/)) {
      return 'Juni';
    }else if (val.match(/July.*/)) {
      return 'Juli';
    }else if (val.match(/August.*/)) {
      return 'Agustus';
    }else if (val.match(/October.*/)) {
      return 'Oktober';
    }else if (val.match(/December.*/)) {
      return 'Desember';
    }else{
      return val;
    }
  }

  function get_tanggal(tanggal) {
    var from      = tanggal.split('/');
    var gabung    = new Date((from[1]+'/'+from[0]+'/'+from[2])) ;
    var options   = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    var tanggal2  = gabung.toLocaleString('en', options);
    var pisah     = tanggal2.split(' ');
    var hari      = cari_hari(pisah[0]);
    var bulan     = cari_bulan(pisah[1]);
    return hari+', '+pisah[2].substring(0, 2)+' '+bulan+' '+pisah[3];
  }
  
  
  function preview_chat_psikotest(no) {
	var nama          = $('#nama_peserta'+no).val();
	var nohp          = $('#no_hp'+no).val();
	var kode          = $('#kode_akses'+no).val();
	var tanggal       = $('#tanggal_psikotest').val();
	var tanggal2      = get_tanggal(tanggal);
	var waktu_mulai   = $('#waktu_mulai_psikotest').val();
	var waktu_selesai = $('#waktu_selesai_psikotest').val()
	
	Swal.fire({
		  title: 'Preview Chat',
	  html : `<div class="text-left" id="chat_psikotest">Yth. Sdr. *`+nama+`*, sesuai dengan panggilan *Psikotes Online* terjadwal pada : <br> 
			  Tanggal : *`+tanggal2+`* <br>
			  Pukul   : *`+waktu_mulai+`* s/d *`+waktu_selesai+`* <br> 
			  Kode akses : *`+kode+`* <br>
			  Harap untuk mengerjakan tes di antara waktu yang telah ditentukan. Di luar waktu tersebut, tes sudah tidak dapat diakses lagi.
			  Silakan mengakses Psikotes Online dengan username dan password dari akun e-recruitment, serta kode akses yang tercantum diatas. 
			  Username, password, dan kode akses adalah milik Saudara pribadi dan tidak boleh diserahkan ke pihak lain. 
			  <br>Terima kasih. <br>Sie Seleksi.</div>`,
		  confirmButtonText: 'Copy',
      showLoaderOnConfirm: true,
      cancelButtonText: "Close",
		  showCancelButton: true,
	  }).then(result => {
		if (result.value) {
		  var text = `Yth. Sdr. *`+nama+`*, sesuai dengan panggilan *Psikotes Online* terjadwal pada :  
Tanggal       : *`+tanggal2+`* 
Pukul           : *`+waktu_mulai+`* s/d *`+waktu_selesai+`*
Kode akses  : *`+kode+`*
Harap untuk mengerjakan tes di antara waktu yang telah ditentukan. Di luar waktu tersebut, tes sudah tidak dapat diakses lagi. Silakan mengakses Psikotes Online dengan username dan password dari akun e-recruitment, serta kode akses yang tercantum diatas. Username, password, dan kode akses adalah milik Saudara pribadi dan tidak boleh diserahkan ke pihak lain. 
Terima kasih. 
Sie Seleksi.`;
		  // console.log(text);      
		  var textArea = document.createElement( "textarea" );
		  textArea.value = text;
		  document.body.appendChild( textArea );       
		  textArea.select();
		  document.execCommand('copy');
	}}) 
  }

  function readmorepsikotest(kode, ket) {
    if(ket == 'read more') {
      $('.list_peserta_'+kode).removeClass('hide');
      $('.list_show_'+kode).addClass('hide');
      $('.list_hide_'+kode).removeClass('hide');
    }else{
      $('.list_peserta_'+kode).addClass('hide');
      $('.list_show_'+kode).removeClass('hide');
      $('.list_hide_'+kode).addClass('hide');

    }
  }

  function delete_jadwal_psikotest(kode, tgl) {    
    let loading = baseurl + 'assets/img/gif/loadingquick.gif';
  
    swal.fire({
      title: 'Apakah anda yakin akan menghapus jadwal '+kode+' ?',
      text: 'Data tidak dapat dikembalikan.',
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
            kode : kode, tgl : tgl
          },
          url: baseurl + 'ADMSeleksi/Penjadwalan/hapus_jadwal',
          success: function (data) {
            swal.close()
            window.location.reload();
          }
        })
      }
    })
  }
  
  
  //-------------------------- PENJADWALAN PSIKOTEST ----------------------------------------------------------------------------------------

  //-------------------------- HASIL PSIKOTEST ----------------------------------------------------------------------------------------
  function findDataHasilPsikotest(th) {
    var tipe = $('#tipe_seleksi_psikotest').val();
    var tanggal = $('#tanggal_psikotest').val();
    var tes = $('#nama_test_psikotest').val();
    var peserta = $('#nama_peserta_psikotest').val();
    $.ajax({
      url : baseurl + 'ADMSeleksi/MonitoringHasilTes/search',
      data : {tipe : tipe, tanggal : tanggal, tes : tes, peserta : peserta},
      type : 'post',
      dataType : 'html',
      beforeSend: function() {
      $('div#view_hasil_tes' ).html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
      },
      success : function(data) {
        $('div#view_hasil_tes' ).html(data);
      }
    })
  }

  function collect_peserta(kode, id) {
    var ket = $('#ket_'+kode).val();
    var collect = $('#collect_peserta_'+id).val();
    console.log(ket, collect);
    if (ket == 'N') {
      $('#ket_'+kode).val('Y');
      $('#fa_'+kode).removeClass('fa-square-o').addClass('fa-check-square-o');
      var tambah = collect+kode+'+';
      $('#collect_peserta_'+id).val(tambah);
    }else{
      $('#ket_'+kode).val('N');
      $('#fa_'+kode).removeClass('fa-check-square-o').addClass('fa-square-o');
      var pisah = collect.split('+');
      var tambah = '';
      for (let i = 0; i < pisah.length; i++) {
        if(pisah[i] != '' && kode != pisah[i]){
          var tambah = tambah+kode+'+';
        }
      }
      $('#collect_peserta_'+id).val(tambah);
    }
  }

  function delete_hasil_tes(kode, id_tes) {
    let loading = baseurl + 'assets/img/gif/loadingquick.gif';
  
    swal.fire({
      title: 'Apakah anda yakin?',
      text: 'Data yang terhapus tidak bisa dikembalikan.',
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
            kode : kode, id_tes : id_tes
          },
          url: baseurl + 'ADMSeleksi/MonitoringHasilTes/hapus_hasil_tes',
          success: function (data) {
            swal.fire({
              title: 'Apakah anda ingin menjadwalkan ulang?',
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              allowOutsideClick: false
            }).then(result => {
              if (result.value) {
                window.location.replace(baseurl+"ADMSeleksi/Penjadwalan/");
              }
            })
          }
        })
      }
    })
  }

  //-------------------------- HASIL PSIKOTEST ----------------------------------------------------------------------------------------
