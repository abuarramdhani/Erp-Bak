$(document).ready(function () {
$(".oth_datepicker").datepicker({
    todayHighlight: true,
    format: 'yyyy-mm-dd',
  }).on('change', function(){
    $('.datepicker').hide();
});

$(document).on("change", "#jenis_order_handling", function(){
  $('#sarana_handling').select2('val', '');
  if ($(this).val() == 1) { // pembuatan sarana handling
    $('#sarana_handling').html('<option></option><option value="1">Sarana Handling Yang Tersedia</option><option value="2">Buat Baru</option>');
  }else if ($(this).val() == 2){ // repair sarana handling
    $('#sarana_handling').html('<option></option><option value="1">Sarana Handling Yang Tersedia</option><option value="2">Lain-lain</option>');
  }else{ // perusakan sarana handling
    $('#sarana_handling').html('<option></option><option value="3">Nama Komponen</option>');
  }
})

$(document).on("change", "#sarana_handling", function(){
    if ($(this).val() == 2) { // lain-lain / buat baru
        $('.ifsaranabaru').css('display', '');
        $('.ifsarana').css('display', '');
        $('#nm_handling').html('<input id="nama_handling" name="nama_handling" class="form-control" placeholder="nama handling" autocomplete="off" required>');
    }else if ($(this).val() == 1){ // sarana handling yg tersedia
        $('.ifsaranabaru').css('display', 'none');
        $('.ifsarana').css('display', '');
        $('#nm_handling').html('<select id="nama_handling" name="nama_handling" class="form-control select2 getsaranahandling" data-placeholder="nama handling" style="width:100%" required></select>');
        $('#nama_design').val('');
        document.getElementById("file_design").value = "";
        
        $(".getsaranahandling").select2({
          allowClear: true,
          // minimumInputLength: 3,
          ajax: {
              url: baseurl + "OrderHandling/InputOrder/getsaranahandling",
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
                          return {id:obj.nama_handling, text:obj.nama_handling};
                      })
                  };
              }
          }
      });		
    }else if ($(this).val() == 3) { // nama komponen khusus perusakan komponen reject
      $('.ifsaranabaru').css('display', 'none');
      $('.ifsarana').css('display', '');
      $('#nm_handling').html('<input id="nama_handling" name="nama_handling" class="form-control" placeholder="kode komponen" autocomplete="off" required>');
    }else{
      $('.ifsaranabaru').css('display', 'none');
      $('.ifsarana').css('display', 'none');
      $('#nm_handling').html('');
      $('#nama_design').val('');
      document.getElementById("file_design").value = "";
    }
})

})


var status = document.getElementById('oth_status_order');
if (status) {
  $.ajax({
    url: baseurl + 'OrderHandling/StatusOrder/data_status',
    type: 'POST',
    // dataType: 'JSON',
    cache: false,
    beforeSend: function() {
      $('#oth_status_order').html(`<div id="loadingArea0">
                                <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"><br>Please be patient..</center>
                            </div>`);
    },
    success: function(view) {
      $('#oth_status_order').html(view);
      $('#tb_status').dataTable({
          "scrollX": true,
      });
    }
  })
}


var order_masuk = document.getElementById('oth_order_masuk');
if (order_masuk) {
  $.ajax({
    url: baseurl + 'OrderHandling/MonitoringOrder/data_order',
    type: 'POST',
    // dataType: 'JSON',
    cache: false,
    beforeSend: function() {
      $('#oth_order_masuk').html(`<div id="loadingArea0">
                                <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"><br>Please be patient..</center>
                            </div>`);
    },
    success: function(view) {
      $('#oth_order_masuk').html(view);
      $('#tb_order').dataTable({
          "scrollX": true,
      });
    }
  })
}


var plotting = document.getElementById('oth_plotting_order');
if (plotting) {
  $.ajax({
    url: baseurl + 'OrderHandling/PlottingOrder/data_plotting',
    type: 'POST',
    // dataType: 'JSON',
    cache: false,
    beforeSend: function() {
      $('#oth_plotting_order').html(`<div id="loadingArea0">
                                <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"><br>Please be patient..</center>
                            </div>`);
    },
    success: function(view) {
      $('#oth_plotting_order').html(view);
      $('#tb_order').dataTable({
          scrollX: true,
          searching : false,
          paging:false,
          ordering : false,
          fixedColumns:   {
              leftColumns: 3,
          }
      });
    }
  })
}

var inprogres = document.getElementById('oth_order_inprogres');
if (inprogres) {
  $.ajax({
    url: baseurl + 'OrderHandling/InProgressOrder/data_inprogress',
    type: 'POST',
    // dataType: 'JSON',
    cache: false,
    beforeSend: function() {
      $('#oth_order_inprogres').html(`<div id="loadingArea0">
                                <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"><br>Please be patient..</center>
                            </div>`);
    },
    success: function(view) {
      $('#oth_order_inprogres').html(view);
      $('#tb_order').dataTable({
          scrollX: true,
      });
      // lanjut timer
      var nomor       = $('.nomor').map(function(){return $(this).val();}).get();
      var start_time  = $('.start_time').map(function(){return $(this).val();}).get();
      var end_time    = $('.end_time').map(function(){return $(this).val();}).get();
      var action      = $('.action').map(function(){return $(this).val();}).get();
      // console.log(nomor, start_time, end_time)
      for (let i = 0; i < nomor.length; i++) {
        if (start_time[i] != '' && end_time[i] == '' && action[i] == 0) {
          oth_timer_progres(nomor[i], '');
        }
      }
    }
  })
}


var achievement = document.getElementById('oth_order_achievement');
if (achievement) {
  $.ajax({
    url: baseurl + 'OrderHandling/AchievementOrder/data_achievement',
    type: 'POST',
    // dataType: 'JSON',
    cache: false,
    beforeSend: function() {
      $('#oth_order_achievement').html(`<div id="loadingArea0">
                                <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"><br>Please be patient..</center>
                            </div>`);
    },
    success: function(view) {
      $('#oth_order_achievement').html(view);
      $('#tb_achiev1').dataTable({
          scrollX: true,
          pageLength : 5,
          lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']]
      });
    }
  })
}

function schAchievement(th) {
  $.ajax({
    url: baseurl + 'OrderHandling/AchievementOrder/data_sch_achievement',
    type: 'POST',
    // dataType: 'JSON',
    data: {tgl_awal : $('#prd_awal').val(),
          tgl_akhir : $('#prd_akhir').val()},
    cache: false,
    beforeSend: function() {
      $('#oth_sch_achievement').html(`<div id="loadingArea0">
                                <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"><br>Please be patient..</center>
                            </div>`);
    },
    success: function(view) {
      $('#oth_sch_achievement').html(view);
      $('#tb_achiev2').dataTable({
          scrollX: true,
      });
    }
  })
}

function approveOrder(id_order, id_revisi) {
  $.ajax({
    url : baseurl+"OrderHandling/MonitoringOrder/approve_order",
    data : {id_order : id_order, id_revisi : id_revisi},
    type : "POST",
    dataType : 'html',
    success : function (data) {
      Swal.fire({
          title: 'Order Approved!',
          type: 'success',
          allowOutsideClick: false
      }).then(result => {
          if (result.value) {
            window.location.reload();
      }})  
    }
  })
}

function rejectOrder(id_order, id_revisi) {
	Swal.fire({
		title: 'Berikan Alasan Penolakan Order',
		// html : "",
		// type: 'success',
		input: 'textarea',
		inputAttributes: {
			autocapitalize: 'off'
		},
		showCancelButton: false,
		confirmButtonText: 'Submit',
		showLoaderOnConfirm: true,
	}).then(result => {
		if (result.value) {
			var val 		= result.value;
      $.ajax({
        url : baseurl+"OrderHandling/MonitoringOrder/reject_order",
        data : {id_order : id_order, alasan : val, id_revisi : id_revisi},
        type : "POST",
        dataType : 'html',
        success : function (data) {
          Swal.fire({
              title: 'Order Rejected!',
              type: 'success',
              allowOutsideClick: false
          }).then(result => {
              if (result.value) {
                window.location.reload();
          }})  
        }
      })
	}})
}

function revisi_order(id_order) {
  $.ajax({
    url: baseurl + 'OrderHandling/StatusOrder/revisi_order',
    type: 'POST',
    // dataType: 'JSON',
    data: {id_order : id_order},
    cache: false,
    success: function(view) {
      $('#data_revisi').html(view);
      $('#mdl_rev_order').modal('show');
      $(".oth_datepicker").datepicker({
          // autoclose: true,
          todayHighlight: true,
          format: 'yyyy-mm-dd',
      }).on('change', function(){
        $('.datepicker').hide();
      });
      $('.oth_select2').select2({
        tags: true,
        allowClear:true,
      })
      
      $(".getsaranahandling").select2({
        allowClear: true,
        // minimumInputLength: 3,
        ajax: {
            url: baseurl + "OrderHandling/InputOrder/getsaranahandling",
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
                        return {id:obj.nama_handling, text:obj.nama_handling};
                    })
                };
            }
        }
      });	
    }
  })
}

function plotting_order() {
  $.ajax({
    url: baseurl + 'OrderHandling/PlottingOrder/plotting_order',
    type: 'POST',
    // dataType: 'JSON',
    cache: false,
    success: function(view) {
      $('#data_plotting').html(view);
      $('#mdl_plot_order').modal('show');
      $('#tb_plot').dataTable();
      periode_plotting();
    }
  })
}

function periode_plotting(id_order, id_revisi) {
  // console.log(id_order);
  if (id_order != undefined) {
    $.ajax({
      url: baseurl + 'OrderHandling/PlottingOrder/periode_plot',
      type: 'POST',
      // dataType: 'JSON',
      data: {id_order : id_order, id_revisi : id_revisi},
      cache: false,
      success: function(view) {
        $('#data_periode_plot').html(view);
        $('#mdl_periode_plot').modal('show');
        $(".oth_datepicker").datepicker({
          // autoclose: true,
          todayHighlight: true,
          format: 'yyyy-mm-dd',
        }).on('change', function(){
          $('.datepicker').hide();
        });
      },
    })
  }
}

function oth_timer_progres(no, ket) {
  var hoursLabel   = document.getElementById("jam"+no).value;
  var minutesLabel = document.getElementById("menit"+no).value;
  var secondsLabel = document.getElementById("detik"+no).value;
  var totalSeconds = parseInt(hoursLabel*3600) + parseInt(minutesLabel*60) + parseInt(secondsLabel);
  var timer = null;
  console.log(hoursLabel, minutesLabel, secondsLabel, totalSeconds, ket);

  $('#button_selesai'+no).on('click',function() { // button selesai di tabel
    $.ajax({
      url: baseurl + 'OrderHandling/InProgressOrder/selesai_progress',
      type: 'POST',
      data: {no : no, 
            id_order : $('#id_order'+no).val(),
            id_revisi : $('#id_revisi'+no).val(),
            qty : $('#qty'+no).val(),
      },
      cache: false,
      success: function(view) {
        $('#data_selesai').html(view);
        $('#mdl_selesai_progres').modal('show');
      },
    })
  })
  
  $(document).on('click', '#button_selesai_progress'+no,  function() { // button submit modal selesai
    clearInterval(timer);
    $('#button_selesai'+no).attr('disabled','disabled');
    $('#mdl_selesai_progres').modal('hide');
    var cat = $('#pengecatan').val() == '' ? 0 : $('#pengecatan').val();
    if (parseFloat(cat) < parseFloat($('#qty_order').val())) { //jika val pengecatan kurang dari qty order
      $.ajax({
        url: baseurl + 'OrderHandling/InProgressOrder/save_dummy_progres',
        type: 'POST',
        data: {
          id_order : $('#order_num').val(),
          jam : hoursLabel, menit : minutesLabel, detik : secondsLabel,
        },
        cache: false
      })
    }else{ // val pengecatan sudah sesuai order
      $.ajax({
        url: baseurl + 'OrderHandling/InProgressOrder/save_selesai_progres',
        type: 'POST',
        data: {
          id_order : $('#order_num').val(),
          id_revisi : $('#revisi_num').val(),
          jam : hoursLabel, menit : minutesLabel, detik : secondsLabel,
        },
        cache: false,
      })
    }
  })
  
  $(document).on('change', '#persiapan',  function() { // save value persiapan
    $.ajax({
      url: baseurl + 'OrderHandling/InProgressOrder/save_persiapan_progres',
      type: 'POST',
      data: {
        id_order : $('#order_num').val(),
        id_revisi : $('#revisi_num').val(),
        persiapan : $(this).val(),
      },
      cache: false
    })
  })

  $(document).on('change', '#pengelasan',  function() { // save value pengelasan
    $.ajax({
      url: baseurl + 'OrderHandling/InProgressOrder/save_pengelasan_progres',
      type: 'POST',
      data: {
        id_order : $('#order_num').val(),
        id_revisi : $('#revisi_num').val(),
        pengelasan : $(this).val(),
      },
      cache: false
    })
  })

  $(document).on('change', '#pengecatan',  function() { // save value pengecatan
    var qty_sisa = parseFloat($('#qty_order').val()) - parseFloat($(this).val());
    $('#td_qty'+no).html(qty_sisa < 0 ? 0 : qty_sisa);
    $.ajax({
      url: baseurl + 'OrderHandling/InProgressOrder/save_pengecatan_progres',
      type: 'POST',
      data: {
        id_order : $('#order_num').val(),
        id_revisi : $('#revisi_num').val(),
        pengecatan : $(this).val(),
      },
      cache: false
    })
  })
  
  function setTime() {
      totalSeconds++;
      document.getElementById("seconds"+no).innerHTML = pad(totalSeconds % 60);
      var menitnya = totalSeconds - pad(parseInt(totalSeconds / 3600)) * 3600;
      document.getElementById("minutes"+no).innerHTML = (pad(parseInt(menitnya / 60)));
      document.getElementById("hours"+no).innerHTML = pad(parseInt(totalSeconds / 3600));
      $('#detik'+no).val(pad(totalSeconds % 60));
      $('#menit'+no).val((pad(parseInt(menitnya / 60))));
      $('#jam'+no).val(pad(parseInt(totalSeconds / 3600)));
      // console.log((pad(parseInt(totalSeconds / 3600))), (pad(parseInt(menitnya / 60))), (pad(totalSeconds % 60)));
  }
  
  function pad(val) {
      var valString = val + "";
      if (valString.length < 2) {
      return "0" + valString;
      } else {
      return valString;
      }
  }
  if (!timer) {
      timer = setInterval(setTime, 1000);
  }
  if (ket == 'mulai') {
    $('#button_mulai'+no).css('display','none');
    $('#button_selesai'+no).css('display','');
    $.ajax({
      url: baseurl + 'OrderHandling/InProgressOrder/save_mulai_progres',
      type: 'POST',
      // dataType: 'JSON',
      data: {
        id_order : $('#id_order'+no).val(),
      },
      cache: false,
    })
  }
}
