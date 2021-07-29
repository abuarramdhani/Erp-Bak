$(document).ready(function() {
  $('.itemRMI1').select2({
    minimumInputLength: 3,
    placeholder: "Item Code",
    // tags: true,
    ajax: {
      url: baseurl + "RevisiMasterItem/UpdatePerItem/listCode",
      dataType: "JSON",
      type: "POST",
      // tags: true,
      data: function(params) {
        return {
          term: params.term
        };
      },
      processResults: function(data) {
        return {
          results: $.map(data, function(obj) {
            return {
              id: obj.SEGMENT1,
              text: `${obj.SEGMENT1}`
            }
          })
        }
      }
    }
  });
});

$('.itemRMI1').on('change',function () {
  let itemVal = $(this).select2('data')[0].text;
  console.log(itemVal);
  // itemVal = itemVal.split(' - ')[1];
  // $('.descRMI1').val(itemVal);
  $.ajax({ 
    url: baseurl + 'RevisiMasterItem/UpdatePerItem/getDescription',
    type: 'POST',
    dataType: 'JSON',
    async: true,
    data: {
        params: itemVal,
    },
    beforeSend: function() {
      $(`.descRMI1`).val('Loading ..'); 
    },
    success: function(result) {
      console.log(result);
    $(`.descRMI1`).val(result.ITEM_DESC);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    console.error();
    }
})
})

// const getDescription = _ => {
//   const item_code = $('#item_code').last().val();
//   console.log(item_code);
//   $.ajax({
//       url: baseurl + 'RevisiMasterItem/UpdatePerItem/getDescription',
//       type: 'POST',
//       dataType: 'JSON',
//       async: true,
//       data: {
//           params: item_code,
//       },
//       beforeSend: function() {
//         $(`#item_desc`).val('loading ..'); // loading nya biar ga blank
//       },
//       success: function(result) {
//           $(`#item_desc`).val(result.ITEM_DESC);
//       console.log(result);
//       },
//       error: function(XMLHttpRequest, textStatus, errorThrown) {
//       console.error();
//       }
//   })
// }

function addElement() {
  let nomor = Number($('.tablePerItem tbody tr').length)+1
  console.log(nomor,'ini nomor');
  let addRow = `<tr class="add_row${nomor}"> 
  <td class="text-center"><input type="text" class="form-control no${nomor}" name="no[]" id="no" value="${nomor}" readonly></td>
  <td class="text-center">
  <select class="form-control itemRMI${nomor}" id="item_code" name="item_code[]" style="text-transform:uppercase !important;width:210px !important;" required>
    <option selected="selected"></option>
  </select></td>
  <td> <input type="text" class="form-control descRMI${nomor}" id="item_desc" name="item_desc[]" placeholder="Item Description"></input>
  </td>
  <td> <input type="text" class="form-control stdPACKING${nomor}" id="std_packing" name="std_packing[]" placeholder="STD Packing"></input>          
  </td>
  <td><button type="button" class="btn btn-danger btn-sm btn_del${nomor}"><i class="fa fa-minus"></i></button></td>
  </tr>`
$('.tablePerItem tbody').append(addRow)
$(`.itemRMI${nomor}`).select2({
  minimumInputLength: 3,
  placeholder: "Item Code",
  ajax: {
    url: baseurl + "RevisiMasterItem/UpdatePerItem/listCode",
    dataType: "JSON",
    type: "POST",
    data: function(params) {
      return {
        term: params.term
      };
    },
    processResults: function(data) {
      return {
        results: $.map(data, function(obj) {
          return {
            id: obj.SEGMENT1,
            text: `${obj.SEGMENT1}`
          }
        })
      }
    }    
  }
})


$('.btn_del'+nomor).on('click', function() {
  //  $(this).parents('tr').remove();
  $('.add_row'+nomor).remove();
})

$(`.itemRMI${nomor}`).on('change',function () {
  console.log(nomor);
  let itemVal = $(this).val();
  console.log(itemVal, 'current');
  // itemVal = itemVal.split(' -')[1];
  $.ajax({ 
    url: baseurl + 'RevisiMasterItem/UpdatePerItem/getDescription',
    type: 'POST',
    dataType: 'JSON',
    async: true,
    data: {
        params: itemVal,
    },
    beforeSend: function() {
      $(`.descRMI${nomor}`).val('Loading ..'); // loading nya biar ga blank
    },
    success: function(result) {
      console.log(result);
    $(`.descRMI${nomor}`).val(result.ITEM_DESC); 
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    console.error();
    }
})
})

}

const toastRMI = (type, message) => {
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

const toastRMILoading = (pesan) => {
  Swal.fire({
    toast: true,
    position: 'top-end',
    onBeforeOpen: () => {
       Swal.showLoading();
       $('.swal2-loading').children('button').css({'width': '20px', 'height': '20px'})
     },
    text: pesan
  })
}

const swalRMI = (type, title) => {
  Swal.fire({
    type: type,
    title: title,
    text: '',
    showConfirmButton: false,
    showCloseButton: true,
  })
}

$(`#btn_changeItem`).on('click', function () {
  toastRMILoading('Running Update Master Items..')
})

$(`#submit_go`).on('click', function () {
  toastRMILoading('Running Update Master Items..')
})

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

$('.datatable-rmi').DataTable({
  dom: 'Bfrtip',
  buttons: [
    'pageLength',
    {
      extend: 'excelHtml5',
      title: 'KHS_RMI_' + today,
      exportOptions: {
        columns: ':visible',
        columns: [0, 1, 2, 3],
      }
    }
   ],
});

