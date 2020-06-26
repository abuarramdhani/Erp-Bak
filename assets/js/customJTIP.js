
var jtipem = $('#jtipem').val();
$(document).ready(function() {
  var tempResult = null
  if (jtipem === 'inijtipembelian') {
    $.ajax({
      url: baseurl+'jtipembelian/History/getHistoryJTI',
      type: 'POST',
      success: function(result) {
        $('#loadingArea').hide()
        $('div#tableareajti').html(result);
        $('#tableJTIP').dataTable();
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
    setInterval(reloadAjaxJTI, 3500);
    function reloadAjaxJTI() {
      $.ajax({
        url: baseurl+'jtipembelian/History/getHistoryJTI',
        type: 'POST',
        success: function(result) {
          if(tempResult != result) {
            $('table.pembelianJTI').remove()
            $('div#tableareajti').html(result)
            $('#tableJTIP').dataTable()
          }
          tempResult = result
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }

  }else {
    console.log('JTI Success');
  }
})

function jtipembelianklikmodal(rowID) {
  let jtiReport = $('tr[row-id="' + rowID + '"] input[id="JTIReport"]').val();
  let JTIResponse = $('tr[row-id="' + rowID + '"] input[id="JTIResponse"]').val();
  let idNotifnya = $('tr[row-id="' + rowID + '"] input[id="JTInotifid"]').val();

  $('#valueReport').val(jtiReport);
  $('#valueResponse').val(JTIResponse);
  $('#idnotifikasi').val(idNotifnya);

  $.ajax({
    url: baseurl+'jtipembelian/Input/getNotfication',
    type: 'POST',
    dataType: 'json',
    data: {
      id: idNotifnya
    },
    success: function(result) {
      if (result.done == 't') {
        $('button[name="button-send-jti-pembelian"]').prop("disabled", true);
        $('button[name="button-done-jti-pembelian"]').prop("disabled", true);
        $('textarea[name="response-jti-send-pembelian"]').prop("disabled", true);
      }else {

      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })

}

function sendjtiahai() {
 var responseahai = $('#valueResponse').val();
 var idNotif = $('#idnotifikasi').val()

 $.ajax({
   url: baseurl+'jtipembelian/Input/updateResponseJTI',
   type: 'POST',
   data: {
     response: responseahai,
     id: idNotif
   },
   success: function(result) {
     if (result != '') {
       Swal.fire({
         position: 'middle',
         type: 'success',
         title: 'Data telah di kirim',
         showConfirmButton: false,
         timer: 1500
       }).then(function () {
         $('#MyModalJTIPembelian').modal('hide');
       })
     }else {
       Swal.fire({
         position: 'middle',
         type: 'error',
         title: 'Failed to send',
         showConfirmButton: false,
         timer: 3000
       });
     }
   },
   error: function(XMLHttpRequest, textStatus, errorThrown) {
     console.error();
   }
 })
}

function JTIPembelianInput() {
  var nomorSPBS = $('#nomorSPBS').val()
  var namaDriver = $('#namaDriver').val()
  var no_induk_mu = $('#no_induk_mu').val()
  var estimasi = $('#estimasi_jti').val()
  var jenis_dokumen = $('#jenis_dokumen').val()

  $.ajax({
    url: baseurl+'jtipembelian/Input/addDriver',
    type: 'POST',
    data: {
      document_number: nomorSPBS,
      name: namaDriver,
      created_by: no_induk_mu,
      estimation: estimasi,
      jenis_dokumen: jenis_dokumen,
    },
    beforeSend:function() {
      Swal.showLoading()
    },
    success: function(result) {
      if (result.success) {
        Swal.fire({
          position: 'middle',
          type: 'success',
          title: 'Data terlah dikirim',
          showConfirmButton: false,
          timer: 1500
        });
        $('#nomorSPBS').val('')
        $('#namaDriver').val('')
        $('#estimasi_jti').val('')
        $('#type_jti').val('')
      }else {
        Swal.fire({
          position: 'middle',
          type: 'error',
          title: result.message,
          showConfirmButton: false,
          timer: 4000
        });
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

function donejti() {
  var idNotif = $('#idnotifikasi').val()
    Swal.fire({
    title: 'Apakah anda yakin?',
    text: "",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, kirimkan pesan!'
  }).then((result) => {
    if (result.value) {
      Swal.fire(
        'Sukses!',
      ).then(function () {
        $.ajax({
          url: baseurl+'jtipembelian/Input/updateResponseJTIDone',
          type: 'POST',
          data: {
            id: idNotif
          },
          success: function(result) {
            $('#MyModalJTIPembelian').modal('hide');
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.error();
          }
        }).then(function() {
          $.ajax({
            url: baseurl+'jtipembelian/History/getHistoryJTI',
            type: 'POST',
            success: function(result) {
              $('#loadingArea').hide()
              $('div#tableareajti').html(result);
              $('#tableJTIP').dataTable();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.error();
            }
          })
        })

      })
    }
  })
}

function checkJTIP() {
  var id = $('#cari').val()
  if (id === '') {
    $('div#table-area').hide();
  }
}

$(".datepickerJTIP").datetimepicker({
    showSecond: false,
    timeFormat: 'hh:mm',
}).datetimepicker("setDate", new Date());

// aah300a001ay
