// -------------------------------------------------
$('.datetimeOSR').datepicker({
  format: 'dd/mm/yyyy',
  autoclose: true,
  todayHighlight: true
});

// -------------------------------------------------
$('.namaForm').hide();
$('.nomorForm').hide();
$('.jmlForm').hide();
$('.spekForm').hide();
$('.tipeForm').hide();
$('.fungsiForm').hide();
$('.docForm').hide();

// -------------------------------------------------
$('#JenisOrder').on('change', function (){
  var jenisorder = $('select[name="JenisOrder"]').val();

	if (jenisorder == 'MEMBUAT ALAT/MESIN' || jenisorder == 'OTOMASI') {
    $('.namaForm').show();
    $('.jmlForm').show();
    $('.spekForm').show();
    $('.nomorForm').hide();
    $('#NomorAlatMesin').removeAttr('required');
    $('.tipeForm').hide();
    $('#TipeAlatMesin').removeAttr('required');
    $('.fungsiForm').hide();
    $('#FungsiAlatMesin').removeAttr('required');
    $('.docForm').hide();
    $('#LayoutAlatMesin').removeAttr('required');
  }else if (jenisorder == 'MODIFIKASI ALAT/MESIN' || jenisorder == 'REBUILDING MESIN') {
    $('.namaForm').show();
    $('.nomorForm').show();
    $('.jmlForm').show();
    $('.tipeForm').show();
    $('.fungsiForm').show();
    $('.spekForm').hide();
    $('#SpesifikasiAlatMesin').removeAttr('required');
    $('.docForm').hide();
    $('#LayoutAlatMesin').removeAttr('required');
  }else if (jenisorder == 'HANDLING MESIN') {
    $('.namaForm').show();
    $('.jmlForm').show();
    $('.docForm').show();
    $('.spekForm').hide();
    $('#SpesifikasiAlatMesin').removeAttr('required');
    $('.nomorForm').hide();
    $('#NomorAlatMesin').removeAttr('required');
    $('.tipeForm').hide();
    $('#TipeAlatMesin').removeAttr('required');
    $('.fungsiForm').hide();
    $('#FungsiAlatMesin').removeAttr('required');
	}else {
    $('.namaForm').hide();
    $('.nomorForm').hide();
    $('.jmlForm').hide();
    $('.spekForm').hide();
    $('.tipeForm').hide();
    $('.fungsiForm').hide();
    $('.docForm').hide();
	}
});

// -------------------------------------------------
$(document).ready(function(){
  if($('#order_seksi_rekayasa').val() == "ok"){
    console.log("cek_rekayasa")
  var checkbox_required = $('input[type="checkbox"]');

  checkbox_required.prop('required', true);
  
  checkbox_required.on('click', function(){
    if (checkbox_required.is(':checked')) {
      checkbox_required.prop('required', false);
    } else {
      checkbox_required.prop('required', true);
    }
  });
}
})

// -------------------------------------------------
$('.tblOSROrder').DataTable({
  order : [0, 'desc']
});

// -------------------------------------------------
const readFile = input => {
  if (input.files && input.files[0]) {
    let reader = new FileReader();
  
    reader.onload = function(e) {
      $('#showPre')
        .attr('src', e.target.result)
      };
      reader.readAsDataURL(input.files[0]);
  }
}

// -------------------------------------------------
const terimaOrder = id_order => {
  let status = 2;

  Swal.fire({
    title: 'Anda yakin untuk menerima order?',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes!'
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url: baseurl + 'AgentOrderSeksiRekayasa/MonOrder/terimaOrder',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          id_order: id_order,
          status: status,
        },
        beforeSend: function() {
          Swal.showLoading()
        },
        success: function(result) {
          if (result === 1) {
            $.ajax({
              url: baseurl + 'AgentOrderSeksiRekayasa/MonOrder/emailAlert/' + id_order,
              type: 'POST',
              dataType: 'JSON',
              async: true,
              data: {
                id_order: id_order,
              },
              beforeSend: function() {
                Swal.showLoading()
              },
              success: function(result) {
                if (result === "Success") {
                  Swal.fire({
                    type: 'success',
                    title: 'Order Diterima',
                  }).then(_ => {
                    location.reload();
                  })
                }else{
                  Swal.fire({
                    type: 'error',
                    title: 'Terjadi Kesalahan, Coba kembali...',
                  })
                }
              }
            })
          }else{
            Swal.fire({
              type: 'error',
              title: 'Terjadi Kesalahan, Coba kembali...',
            })
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }
  })
}