$("#group_add").click(function(e){
  e.preventDefault();
  $('.apd-select2').last().select2("destroy");
  $('.multiinput').last().clone().appendTo('#tb_InputKebutuhanAPD tbody');
  $("tr:last .form-control").val("").end();
  // var idsekarang = Number($('tr:last input#txtKodeItem').attr('data-id'));
  var nomorr = Number($('#tb_InputKebutuhanAPD tr:last').find('input#txtKodeItem').attr('data-id'));
  // var tez = $('tr:last input#txtKodeItem').attr('data-id');

  nomorr = nomorr+1;
  // alert(nomorr);
  // alert(tez);
  $('#tb_InputKebutuhanAPD tr:last td#nomor').html(nomorr);
  $('#tb_InputKebutuhanAPD tr:last input#txtKodeItem').attr('data-id', nomorr);
  $('.apd-select2').select2({
    ajax:
    {
      url: baseurl+'P2K3/Order/getItem',
      dataType: 'json',
      type: 'get',
      data: function (params) {
        return {s: params.term};
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.kode_item,
              text: item.item,
            }
          })
        };
      },
      cache: true
    },
    minimumInputLength: 2,
    placeholder: 'Select Item',
    allowClear: true,
  });
});


$(document).on('click', '.group_rem', function(e){
  e.preventDefault();
  if($('.multiinput').size()>1){
    $(this).closest('tr').remove();
  }else{
    alert('Minimal harus ada satu baris tersisa');
  }
});


$(function()
{
  $('.dataTable-p2k3').dataTable( {
    dom: 'frtp',
  });

  $('.apd-select2').select2({
    ajax:
    {
      url: baseurl+'P2K3/Order/getItem',
      dataType: 'json',
      type: 'get',
      data: function (params) {
        return {s: params.term};
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.kode_item,
              text: item.item,
            }
          })
        };
      },
      cache: true
    },
    minimumInputLength: 2,
    placeholder: 'Select Item',
    allowClear: true,
  });

});

function JenisAPD(hh){ 
  var id = $(hh).closest('tr').find('input#txtKodeItem'). 
  attr('data-id'); 
  var it = $("input[data-id='"+id+"']");
  var kode = $(hh).val();
  it.val(kode);
}

$(document).ready(function() {    
  function delSpesifikRow(th) {
    $(th).closest('tr').remove();  
  }

  $('#k3_periode').datepicker({
    autoclose : true,
  });

  $('#detailModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('New message to ' + recipient)
        modal.find('.modal-body input').val(recipient)

        var NextId = $(event.relatedTarget).data('next-id')
        $('#id-input').val(NextId)
        var id = $('id-input').val();

        $.ajax({
          type: "POST",
          url: baseurl+"P2K3/Order/detail",
          data: {
            id:id,
          },
          success: function (response) {
            $('#slcEcommerceSubInventory').removeAttr('disabled');
            $('#slcEcommerceOrganization').removeAttr('disabled');
            $('#btnTambahKriteriaPencarian').removeAttr('disabled');
            $('#submitExportExcelItemEcatalog').removeAttr('disabled');
            $('#searchResultTableItemBySubInventory').html(response);
            $('#tbItemTokoquick').DataTable();
          }
        });
      });


  $('.p2k3-daterangepicker').daterangepicker({
    "showDropdowns": true,
    "autoApply": true,
    "locale": {
      "format": "YYYY-MM-DD",
      "separator": " - ",
      "applyLabel": "OK",
      "cancelLabel": "Batal",
      "fromLabel": "Dari",
      "toLabel": "Hingga",
      "customRangeLabel": "Custom",
      "weekLabel": "W",
      "daysOfWeek": [
      "Mg",
      "Sn",
      "Sl",
      "Rb",
      "Km",
      "Jm",
      "Sa"
      ],
      "monthNames": [
      "Januari",
      "Februari",
      "Maret",
      "April",
      "Mei",
      "Juni",
      "Juli",
      "Agustus ",
      "September",
      "Oktober",
      "November",
      "Desember"
      ],
      "firstDay": 1
    }
  }, function(start, end, label) {
    console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
  });

  $('.p2k3-daterangepickersingledate').daterangepicker({
    "singleDatePicker": true,
    "showDropdowns": true,
    "autoApply": true,
    "mask": true,
    "locale": {
      "format": "YYYY-MM-DD",
      "separator": " - ",
      "applyLabel": "OK",
      "cancelLabel": "Batal",
      "fromLabel": "Dari",
      "toLabel": "Hingga",
      "customRangeLabel": "Custom",
      "weekLabel": "W",
      "daysOfWeek": [
      "Mg",
      "Sn",
      "Sl",
      "Rb",
      "Km",
      "Jm",
      "Sa"
      ],
      "monthNames": [
      "Januari",
      "Februari",
      "Maret",
      "April",
      "Mei",
      "Juni",
      "Juli",
      "Agustus ",
      "September",
      "Oktober",
      "November",
      "Desember"
      ],
      "firstDay": 1
    }
  }, function(start, end, label) {
    console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
  });

  $('.p2k3-daterangepickersingledatewithtime').daterangepicker({
    "timePicker": true,
    "timePicker24Hour": true,
    "singleDatePicker": true,
    "showDropdowns": true,
    "autoApply": true,
    "locale": {
      "format": "YYYY-MM-DD HH:mm:ss",
      "separator": " - ",
      "applyLabel": "OK",
      "cancelLabel": "Batal",
      "fromLabel": "Dari",
      "toLabel": "Hingga",
      "customRangeLabel": "Custom",
      "weekLabel": "W",
      "daysOfWeek": [
      "Mg",
      "Sn",
      "Sl",
      "Rb",
      "Km",
      "Jm",
      "Sa"
      ],
      "monthNames": [
      "Januari",
      "Februari",
      "Maret",
      "April",
      "Mei",
      "Juni",
      "Juli",
      "Agustus ",
      "September",
      "Oktober",
      "November",
      "Desember"
      ],
      "firstDay": 1
    }
  }, function(start, end, label) {
    console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
  }); 

  $('#exampleModalapd').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('New message to ' + recipient)
        modal.find('.modal-body input').val(recipient)
      });

});
$(document).ready(function() {
  $('#tb_p2k3').DataTable( {
    "pagingType": "full_numbers"
  } );
} );


// $('#tanggal').datepicker({
//   changeMonth: true,
//   changeYear: true,
//   showButtonPanel: true,
//   dateFormat: 'MM - yy'
// }).focus(function() {
//   var thisCalendar = $(this);
//   $('.ui-datepicker-calendar').detach();
//   $('.ui-datepicker-close').click(function() {
//     var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
//     var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
//     thisCalendar.datepicker('setDate', new Date(year, month, 1));
//   });
// });

    $("#tanggal").datepicker({
        dateFormat: 'mm/yy',
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,

        onClose: function(dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).val($.datepicker.formatDate('mm - yy', new Date(year, month, 1)));
        }
    });

    $(".monthPicker").focus(function () {
        $(".ui-datepicker-calendar").hide();
        $("#ui-datepicker-div").position({
            my: "center top",
            at: "center bottom",
            of: $(this)
        });
    });

    $(function(){
      $('#txtBulanTahunP2K3').datepicker({
      "autoclose": true,
      "todayHiglight": true,
      "format":'mm yyyy',
      "viewMode":'months',
      "minViewMode":'months'
    });
    });