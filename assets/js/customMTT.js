// ========================do something below the alert  =================

// ------------------------- GET TIME REV ALD ------------------------------//
const swalMTTToastrAlert = (type, message) => {
  Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  }).fire({
    customClass: 'swal-font-small',
    type: type,
    title: message
  })
}
const swalMTT = (type, title) => {
  Swal.fire({
    type: type,
    text: title,
  })
}

const update_mtt = (line_id) => {
  if ($(`alasan_${line_id}`).val() !== '') {
    $.ajax({
      url: baseurl + 'MOTerlambatTransact/Monitoring/Update',
      type: 'POST',
      async: true,
      dataType: 'JSON',
      data: {
        line_id: line_id,
        alasan: $(`alasan_${line_id}`).val(),
      },
      beforeSend: function() {
        Swal.fire({
          onBeforeOpen: () => {
             Swal.showLoading()
           },
          text: `Sedang mengupdate data...`
        })
      },
      success: function(result) {
        if (result) {
          swalMTT('success', 'Berhasil Mengupdate Data.')
        }else {
          swalMTT('error', 'Tidak Berhasil Mengupdate Data.')
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
  }else {
    swalMTTToastrAlert('error', 'Inputan tidak boleh kosong.')
  }
}

let dt_mtt =  $('.history_mtt').DataTable();

function format_mtt( d, id){
  return `<div style="width:40%;float:right;" class="detail_area${id}"> </div>`;
}

const detail = (id, alasan) => {
  let tr = $(`tr[data-mtt=${id}]`);
  let row = dt_mtt.row(tr);
  if ( row.child.isShown() ) {
      row.child.hide();
      tr.removeClass('shown');
      $(`tr[data-mtt=${id}]`).css({"background": ""});
  }
  else {
      row.child( format_mtt(row.data(), id)).show();
      tr.addClass('shown');
      $(`tr[data-mtt=${id}]`).css({"background": "rgba(27, 126, 207, 0.35)"});
      $.ajax({
        url: baseurl + 'MOTerlambatTransact/Monitoring/detail',
        type: 'POST',
        async: true,
        data: {
          line_id: id,
          alasan: alasan
        },
        beforeSend: function() {
          $('.detail_area'+id).html(`<div id="loadingArea0">
                                          <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"></center>
                                        </div>`)
        },
        success: function(result) {
          $('.detail_area'+id).html(result)
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
  }
}
