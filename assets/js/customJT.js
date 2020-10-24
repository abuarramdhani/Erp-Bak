// flyingdatmen style =====
$(document).ready(function() {
  // $('#tblJMT').hide();
});

var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!

var yyyy = today.getFullYear();
if (dd < 10) {
  dd = '0' + dd;
}
if (mm < 10) {
  mm = '0' + mm;
}
var today = dd + '_' + mm + '_' + yyyy;

 $('#dataTableJT001').DataTable({
   dom: 'Bfrtip',
   buttons: [
     'pageLength',
     {
       extend: 'excelHtml5',
       title: 'KHS_JTI_' + today,
       exportOptions: {
         columns: ':visible',
         columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
       }
     }
    ],
 });


var table = $('#dataTableJT').DataTable({
  dom: 'rtp',
});

function getDataTicketJTI() {
  const employee = $('#noind').val();
  const pass = $('#pass').val();
  const qrcode = $('#qrcode').val();

  var no = 1;
  var html = '';

  event.preventDefault();
  $.ajax({
    url: 'http://produksi.quick.com/api-jti/out/report',
    type: 'POST',
    async: true,
    dataType: 'json',
    data: {
      code: qrcode,
    },
    beforeSend: function() {
      $('#loadingArea').show();
    },
    success: function(result) {
      // html += '';
      // $("#tbody").append(html);
      $('tr[id="Kawaki"]').remove();

      $('#loadingArea').hide();
      if (result.success) {
        $('#tblJMT').removeClass('tblJMT');
        $('#nothing').hide();
      } else {
        $('#tblJMT').addClass('tblJMT');
        $('#nothing').show();
      }
      console.log(result);
      $('#photo').attr('src', 'http://produksi.quick.com/api-jti/' + result['driver'].photo);

      $('#no_id').val(result['ticket'].id);
      $('#nama').val(result['driver'].name);
      $('#vendor').val(result['document'].vendor);
      $('#noDokumen').val(result['document'].document_number);
      $('#noTiket').val(result['ticket'].ticket_number);
      $('#noPolisi').val(result['ticket'].vehicle_number);
      $('#jenKen').val(result['ticket'].vehicle_name);
      $('#berat1').val('');
      $('#berat2').val('');
      $('#berat3').val('');
      // $.each(result.item,function(item,data){
      //
      //   if (data.TO_SUBINVENTORY_CODE == null) {
      //     var tujuan = '-'
      //   }else {
      //     var tujuan = data.TO_SUBINVENTORY_CODE
      //   }
      //
      //   html += '<tr id="Kawaki">\
      //   <td>'+no+'</td>\
      //   <td>'+data.KODE_BARANG+'</td>\
      //   <td>'+data.NAMA_BARANG+'</td>\
      //   <td>'+data.QUANTITY+'</td>\
      //   <td>'+data.PRIMARY_UOM_CODE+'</td>\
      //   <td>'+tujuan+'</td>\
      //   </tr>'
      //   no++;
      // });
      $('#tbody').append(html);

    },

    error: function(XMLHttpRequest, textStatus, errorThrown) {
      $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
    }
  });
}

function SubmitMasterTimbangan() { //rev
  //value
  var id = $('#no_id').val();
  var code = $('#qrcode').val();
  var berat1 = $('#berat1').val();
  var berat2 = $('#berat2').val();
  var berat3 = $('#berat3').val();
  var berat = berat1 + ',' + berat2 + ',' + berat3;

  if (berat1 == '' || berat2 == '' || berat3 == '') {
    Swal.fire({
      position: 'middle',
      type: 'warning',
      title: 'Please complete the input !!!',
      showConfirmButton: false,
      timer: 1500
    })
  }else {

    $.ajax({
      method: 'POST',
      async: false,
      dataType: 'json',
      url: 'http://produksi.quick.com/api-jti/out/report/history',
      data: {
        ticket: code
      },
      success: function(result) {
        console.log(result);
        if (result == '') {
          $.ajax({
            method: 'POST',
            async: false,
            dataType: 'json',
            url: 'http://produksi.quick.com/api-jti/out/report/save/' + id,
            data: {
              noTiket: $('#noTiket').val(),
              noind: $('#noind').val(),
              nameOpe: $('#namaPetu').val(),
              requirements: $('#keperluan').val(),
              berat1: berat
            },
            success: function(id) {
              Swal.fire({
                position: 'middle',
                type: 'success',
                title: 'Sukses Melakukan Input Data Timbang',
                showConfirmButton: false,
                timer: 1500
              });
            },
          }).then(_ => {
            setTimeout(function() {
              window.open('http://produksi.quick.com/api-jti/out/report/pdf/' + code);
            }, 1600);
            $('#tblJMT').addClass('tblJMT');
            $('#qrcode').val('');
          });
        } else {

          if (result[0].weight_2 == null) {
            $.ajax({
              method: 'POST',
              async: false,
              dataType: 'json',
              url: 'http://produksi.quick.com/api-jti/out/report/save/' + id,
              data: {
                noTiket: $('#noTiket').val(),
                noind: $('#noind').val(),
                nameOpe: $('#namaPetu').val(),
                requirements: $('#keperluan').val(),
                berat1: berat
              },
              success: function(id) {
                Swal.fire({
                  position: 'middle',
                  type: 'success',
                  title: 'Sukses Melakukan Input Data Timbang',
                  showConfirmButton: false,
                  timer: 1500
                });
              },
            }).then(_ => {
              setTimeout(function() {
                window.open('http://produksi.quick.com/api-jti/out/report/pdf/' + code);
              }, 1600);
              $('#tblJMT').addClass('tblJMT');
              $('#qrcode').val('');
            });
          } else {
            Swal.fire({
              position: 'middle',
              type: 'warning',
              title: 'Ticket number telah digunakan sebelumnya',
              showConfirmButton: false,
              timer: 1500
            }).then(function () {
              $('#tblJMT').addClass('tblJMT');
              $('#qrcode').val('');
            })
          }
        }
      },
    })

  }

}
