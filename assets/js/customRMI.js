// flyingdatmen style =====
$(document).ready(function() {
  $('.itemRMI1').select2({
    minimumInputLength: 3,
    placeholder: "Item Kode",
    tags: true,
    ajax: {
      url: baseurl + "RevisiMasterItem/UpdateItem/listCode",
      dataType: "JSON",
      type: "POST",
      tags: true,
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
              text: `${obj.SEGMENT1} - ${obj.DESCRIPTION}`
            }
          })
        }
      }
    }
  });
});

$('.itemRMI1').on('change',function () {
  let itemVal = $(this).select2('data')[0].text;
  itemVal = itemVal.split(' - ')[1];
  $('.descRMI1').val(itemVal);
})

function addElement() {
  let nomor = Number($('.tablePerItem tbody').length) +1
  let addRow = `<tr>
  <td class="text-center">
  <select class="form-control itemRMI${nomor}" name="item_code[]" style="text-transform:uppercase !important;width:210px !important;" required>
    <option selected="selected"></option>
  </select></td>
  <td> <input type="text" class="form-control descRMI${nomor}"></input>
  </td>
  </tr>`
$('.tablePerItem tbody').append(addRow)
$(`.itemRMI${nomor}`).select2({
  minimumInputLength: 3,
  placeholder: "Item Kode",
  tags: true,
  ajax: {
    url: baseurl + "RevisiMasterItem/UpdateItem/listCode",
    dataType: "JSON",
    type: "POST",
    tags: true,
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
            text: `${obj.SEGMENT1} - ${obj.DESCRIPTION}`
          }
        })
      }
    }
  }
})
$(`.itemRMI${nomor}`).on('change',function () {
  let itemVal = $(this).select2('data')[0].text;
  itemVal = itemVal.split(' - ')[1];
  $(`.descRMI${nomor}`).val(itemVal);
})
}

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

