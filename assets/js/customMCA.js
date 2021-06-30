
function submitCat(th) {
    var no_lppb = $('#no_lppb').val();
    $.ajax({
        url : baseurl + "MonitoringCat/InputCat/searchLppb",
        data : {no_lppb : no_lppb},
        dataType : 'html',
        type : 'POST',
        beforeSend: function() {
        $('div#cat_input' ).html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
        },
        success : function (data) {
            $('#cat_input').html(data);
            $('.cat_datatable').DataTable({
                scrollX : true
            });
        }
    })
}

$(document).ready(function () {
var monitoring = document.getElementById("cat_monitoring");
if(monitoring){
    monitoring_cat(this);
}

var setting = document.getElementById("cat_setting");
if(setting){
  data_setting_cat(this);
}

$(".getkodesettingcat").select2({
  allowClear: true,
  ajax: {
      url: baseurl + "MonitoringCat/SettingCat/getitemsetting",
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
                  return {id:obj.INVENTORY_ITEM_ID, text:obj.SEGMENT1+' - '+obj.DESCRIPTION};
              })
          };
      }
  }
});	 
})

const toastMCALoading = (pesan) => {
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

function monitoring_cat(th) {
  $.ajax({
    url : baseurl + "MonitoringCat/Monitoring/view_monitoring",
    dataType : 'html',
    type : 'POST',
    beforeSend: function() {
    $('div#cat_monitoring' ).html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
    },
    success : function (data) {
        $('#cat_monitoring').html(data);
        $('.cat_datatable').DataTable({
            scrollX : true
        });
    }
  })
}

function deletemoncat(code) {
    Swal.fire({
      title: 'Apakah anda yakin ingin menghapus data ini?',
      // text: "Anda tidak akan dapat mengembalikan ini!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, saya yakin!'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: baseurl + 'MonitoringCat/Monitoring/hapus_cat',
          type: 'POST',
          dataType: 'html',
          cache:false,
          data: {code : code},
          beforeSend: function() {
            toastMCALoading('Sedang menghapus data..');
          },
          success: function(result) {
            Swal.fire({
                title: 'Data Berhasil di Hapus!',
                type: 'success',
                allowOutsideClick: false
            }).then(result => {
                if (result.value) {
                  monitoring_cat(this);
            }}) 
          }
        })
      }
    })
}

function data_setting_cat(th) {
  $.ajax({
    url : baseurl + "MonitoringCat/SettingCat/view_setting",
    dataType : 'html',
    type : 'POST',
    beforeSend: function() {
    $('div#cat_setting' ).html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
    },
    success : function (data) {
        $('#cat_setting').html(data);
        $('.cat_datatable').DataTable({
            scrollX : true
        });
    }
})
}


function submit_setting_cat(th) {
  var kode_item = $('#kode_item').val();
  var konversi = $('#konversi').val();
  $.ajax({
      url : baseurl + "MonitoringCat/SettingCat/submit_setting_cat",
      data : {kode_item : kode_item, konversi : konversi},
      dataType : 'html',
      type : 'POST',
      success : function (data) {
        $('#mdl_tambah_setting').modal('hide');
        Swal.fire({
            title: 'Data Berhasil di Tambahkan!',
            type: 'success',
            allowOutsideClick: false
        }).then(result => {
            if (result.value) {
              data_setting_cat(this)
        }}) 
      }
  })
}


function deletesettingcat(inv) {
  Swal.fire({
    title: 'Apakah anda yakin ingin menghapus data ini?',
    text: "Anda tidak akan dapat mengembalikan ini!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, saya yakin!'
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url: baseurl + 'MonitoringCat/SettingCat/hapus_setting',
        type: 'POST',
        dataType: 'html',
        cache:false,
        data: {inv : inv},
        beforeSend: function() {
          toastMCALoading('Sedang menghapus data..');
        },
        success: function(result) {
          Swal.fire({
              title: 'Data Berhasil di Hapus!',
              type: 'success',
              allowOutsideClick: false
          }).then(result => {
              if (result.value) {
                data_setting_cat(this)
          }}) 
        }
      })
    }
  })
}

function editsettingcat(inv, no) {
  var item = $('#item'+no).val();
  var convers = $('#conversion'+no).val();
	Swal.fire({
		title: 'Edit Quantity Conversion',
    html : `Kode Item : `+item+`
            <br>Conversion : `+convers+``,
		// type: 'success',
		input: 'number',
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
        url : baseurl+"MonitoringCat/SettingCat/edit_setting",
        data : {inv : inv, qty : val},
        type : "POST",
        dataType : 'html',
        success : function (data) {
          Swal.fire({
              title: 'Conversion berhasil diedit!',
              type: 'success',
              allowOutsideClick: false
          }).then(result => {
              if (result.value) {
                data_setting_cat(this)
          }})  
        }
      })
	}})
}