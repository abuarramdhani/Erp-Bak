$('.toupper').keyup(function() {
  this.value = this.value.toUpperCase();
});


$(document).ready(function() {

  $('#tblSeksi').dataTable();

  $('.selectNameUser').select2({
    minimumInputLength: 3,
    placeholder: "Choose Option",
    allowClear: true,
    width: '100%',
    ajax: {
      url: baseurl + "PendaftaranBomRouting/ListBOMRouting/getUserall/",
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
              id: obj.nama,
              text: obj.nama
            }
          })
        }
      }
    }
  })

  $('.select2ind').select2({
    minimumInputLength: 3,
    placeholder: "Choose Option",
    allowClear: true,
    width: '100%',
    ajax: {
      url: baseurl + "PendaftaranBomRouting/ListBOMRouting/getUserall/",
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
              id: obj.noind,
              text: obj.noind
            }
          })
        }
      }
    }
  })

  $('.select2manual').select2({
    placeholder: "Choose Option",
    allowClear: true,
    width: '100%',
    // searching: false,
  })

  //redactor
  var BOMMessageDefaultFormat =
    '\
  <div style="  font-family: Times New Roman, Times, serif;">\
      <p>Selamat Siang,</p>\
          <br>\
      <p>\
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\
      </p>\
      <p>Template Balasan (disalin dari <b>"BUMI BULAT"</b> hingga <b>"BULAN BULAT")</b> : </p>\
          <br>\
      <p>Terima kasih atas kerjasamanya</p>\
          <br>\
      <p>\
          Salam,<br>\
          Ms. Edwin<br>\
          Admin Design<br>\
          <b>CV Karya Hidup Sentosa (QUICK)</b><br>\
          Jalan Magelang No 144 Yogyakarta - Indonesia<br>\
          Telp. <a href="https://m.quick.com/callto:+62-274-512095"><u>+62-274-512095</u></a> ext 211<br>\
          Fax. <a href="https://m.quick.com/callto:+62-274-563523"><u>+62-274-563523</u></a><br>\
          Website : <a href="http://www.quick.co.id/"><u>www.quick.co.id</u></a>\
      </p>\
  </div>\
  ';

  $('#BOMredactor').redactor('set', BOMMessageDefaultFormat);

})

$(document).ready(function() {
  // console.log('ayeaye')
  // for checkbox
  $(".iCheck-helper").on("click", function() {
    console.log('ayeaye')
    if ($(".numberPBR:checked").length > 14) {
      $('#btnOracle').prop('disabled', false);
    } else {
      $('#btnOracle').prop('disabled', true);
    }
  })

  var idHeader = $('#txtIdHeader').val();
  var tableUsed2 = $('#dataTablePBR2').DataTable({
    scrollX: true,
    lengthChange: false,
    searching: false,
    ordering: false,
    processing: true,
    serverSide: true,
    "order": [],
    "ajax": {
      url: baseurl + 'PendaftaranBomRouting/InputBOMRouting/getdataPenyusun',
      type: "POST",
      data: {
        txt_id_header: idHeader
      }
    },
    "columnDefs": [{
      "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
      "orderable": false,
    }, ],
    // bPaginate:false

  })
  var tableUsed = $('#dataTablePBR').DataTable({
    processing: true,
    serverSide: true,
    "order": [],
    "ajax": {
      url: baseurl + 'PendaftaranBomRouting/InputBOMRouting/getdataHeader',
      type: "POST"
    },
    "columnDefs": [{
      "targets": [0, 3, 4],
      "orderable": false,
    }, ],
  });
  $('.PBRdate').datepicker({
    "autoclose": true,
    "todayHighlight": true,
    "allowClear": true,
    "format": 'yyyy-mm-dd',
  })

})

function DeletePenyusun(id) {
  console.log(id);
  var table1 = $('#dataTablePBR2').DataTable();
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.value) {
      Swal.fire(
        'Deleted!',
        'Your file has been deleted.',
        'success'
      ).then(_ => {
        $.ajax({
          method: 'POST',
          async: true,
          dataType: 'json',
          url: baseurl + 'PendaftaranBomRouting/ListBOMRouting/deleteCompPenyusun',
          data: {
            penyusun_id: id,
          },
          success: function(result) {
            table1.ajax.reload();
          }
        })
      })
    }
  })
}
//update header Area
$('#BtnUpdateHeader').click(function(event) {

  const id = $('#txtIdHeader').val()
  var js_nodocx = $('#txtNoDokumen').val()
  var js_tgl = $('#txtTanggalPembuatan').val()
  var js_barang = $('#txtNamaBarang').val()
  var js_seksi = $('#txtSeksiHeader').val()
  var js_io = $('#txtIO').val()
  var js_kode = $('#txtKodeParent').val()
  var js_berlaku = $('#txtTanggalBerlakuHeader').val()
  var js_deskripsi = $('#txtDescription').val()
  var js_perubahan = $('#txtPerubahan').val()

  $.ajax({
    method: 'POST',
    async: false,
    dataType: 'json',
    url: baseurl + 'PendaftaranBomRouting/ListBOMRouting/updateHeader',
    data: {
      id: id,
      pbr_nodocx: js_nodocx,
      pbr_tgl: js_tgl,
      pbr_barang: js_barang,
      pbr_seksi: js_seksi,
      pbr_io: js_io,
      pbr_kode: js_kode,
      pbr_deskripsi: js_deskripsi,
      pbr_berlaku: js_berlaku,
      pbr_perubahan: js_perubahan
    },
    success: function(id) {
      Swal.fire({
        position: 'middle',
        type: 'success',
        title: 'Your update data has been updated',
        showConfirmButton: false,
        timer: 1500
      })
    },
  }).then(_ => {
    setTimeout(function() {
      $('#MyModal').modal('hide');
    }, 1600);

  })

})

//update penyusun area
function getPenyusun(id) {
  $.ajax({
    method: 'POST',
    async: true,
    dataType: 'json',
    url: baseurl + 'PendaftaranBomRouting/InputBOMRouting/getDataComponent',
    data: {
      update_id: id
    },
    success: function(result) {
      // console.log(result);
      $('#txt_id').val(id);
      $('#txtKodePenyusun').val(result[0].kode_komponen_penyusun);
      $('#txtQuantity').val(result[0].quantity);
      $('#txtDeskripsi').html(result[0].deskripsi_penyusun);

      const newOption = `
             <option value="${result[0].uom}">${result[0].uom}</option>
             <option value="Ton">Ton</option>
             <option value="Kg">Kg</option>
             <option value="Hg">Hg</option>
            `;

      $("#txtOUM").html(newOption);
      $("#txtOUM").val(result[0].uom).trigger('change');
      $('#txtSupplySub').val(result[0].supply_subinventory);
      $('#txtSupplyLocator').val(result[0].supply_locator);
      $('#txtSubPicklist').val(result[0].subinventory_picklist);
      $('#txtLocatorPicklist').val(result[0].locator_picklist);
      $('#txtSupplytypeRev').val(result[0].supply_type);
      // alert(result[0].supply_type)
    },
  })
}

$('#UpdateComp').click(function(event) {
  const id = $('#txt_id').val()
  var js_penyusun = $('#txtKodePenyusun').val()
  var js_qty = $('#txtQuantity').val()
  var js_uom = $('#txtOUM').val()
  var js_deskripsi = $('#txtDeskripsi').val()
  var js_subtype = $('#txtSupplytypeRev').val()
  var js_supplysub = $('#txtSupplySub').val()
  var js_supplyloc = $('#txtSupplyLocator').val()
  var js_subpicklist = $('#txtSubPicklist').val()
  var js_locatorpicklist = $('#txtLocatorPicklist').val()

  var tablePenyusun = $('#dataTablePBR2').DataTable();
  // console.log(id);
  $.ajax({
    method: 'POST',
    async: false,
    dataType: 'json',
    url: baseurl + 'PendaftaranBomRouting/ListBOMRouting/updatePenyusun',
    data: {
      id: id,
      penyusun: js_penyusun,
      qty: js_qty,
      uom: js_uom,
      deskripsi: js_deskripsi,
      subtype: js_subtype,
      supplysub: js_supplysub,
      supplyloc: js_supplyloc,
      subpicklist: js_subpicklist,
      locatorpicklist: js_locatorpicklist,
    },
    success: function(id) {
      console.log(id);
      Swal.fire({
        position: 'middle',
        type: 'success',
        title: 'Your update data has been updated',
        showConfirmButton: false,
        timer: 1500
      })
      tablePenyusun.ajax.reload();
    },
  }).then(_ => {
    setTimeout(function() {
      $('#MyModal').modal('hide');
    }, 1600);

  })

})

function optionSub(id) {
  var a = $('#txtSupplytype' + id).val()
  // console.log(a);
  if (a == 'Operation Pull (Picklist)') {
    $('#sub1' + id).removeClass('hidden');
    $('#sub2' + id).removeClass('hidden');
    $('#sub3' + id).removeClass('hidden');
    $('#sub4' + id).removeClass('hidden');

    $('#txtSupplySub' + id).attr("required", "true");
    $('#txtSupplyLocator' + id).attr("required", "true");
    $('#txtSubPicklist' + id).attr("required", "true");
    $('#txtLocatorPicklist' + id).attr("required", "true");

  } else if (a == 'Operation Pull') {
    $('#sub1' + id).removeClass('hidden');
    $('#sub2' + id).removeClass('hidden');
    $('#sub3' + id).addClass('hidden');
    $('#sub4' + id).addClass('hidden');

    $('#txtSubPicklist' + id).removeAttr("required", "true");
    $('#txtLocatorPicklist' + id).removeAttr("required", "true");
    $('#txtSupplySub' + id).attr("required", "true");
    $('#txtSupplyLocator' + id).attr("required", "true");

  } else if (a == 'Push') {
    $('#sub1' + id).addClass('hidden');
    $('#sub2' + id).addClass('hidden');
    $('#sub3' + id).addClass('hidden');
    $('#sub4' + id).addClass('hidden');

    $('#txtSupplySub' + id).removeAttr("required", "true");
    $('#txtSupplyLocator' + id).removeAttr("required", "true");
    $('#txtSubPicklist' + id).removeAttr("required", "true");
    $('#txtLocatorPicklist' + id).removeAttr("required", "true");
  }
}

//trial
function plus() {
  var count = $(".boxInput").length + 1;
  var html =
    '<div id="boxInput' + count + '" class="row boxInput"> ' +
    '<hr height="3px">' +
    '  <div class="col-md-12"> ' +
    '    <h4>Page ' + count + '</h4>' +
    '    </div> ' +
    "<br/>" +
    "<br/>" +
    '  <div class="col-md-6"> ' +
    '    <input type="hidden" name="noSub[]" value=" ' +
    count +
    '">' +
    '    <div class="form-group"> ' +
    "      <label>Kode Komponen Penyusun</label> " +
    '      <input class="form-control" type="text" name="txtKodePenyusun[]" placeholder="Type" > ' +
    "    </div>" +
    '    <div class="form-group"> ' +
    '      <label for="usr">Deskripsi</label>' +
    '      <textarea rows="4" title="" class="form-control" name="txtDescriptionPenyusun[]" placeholder="Deskripsi Komponen Penyusun"></textarea>' +
    "    </div> " +
    '    <div class="form-group">' +
    "      <label>Quantity</label>" +
    '      <input class="form-control" type="number" name="txtQuantity[]" placeholder="Type">' +
    "    </div>" +
    '    <div class="form-group">' +
    '      <label for="usr">OUM</label>' +
    '\
  <select class="form-control select2" id="" name="txtOUM[]" data-placeholder="">\
    <option></option>\
    <option value="Ton">Ton</option>\
    <option value="Kg">Kg</option>\
    <option value="Hg">Hg</option>\
  </select>\
  ' +
    "    </div>" +
    "  </div>" +
    '  <div class="col-md-6">' +
    '    <div class="form-group">' +
    '      <label for="usr">Supply Type</label>' +
    '      <select class="form-control" onchange="optionSub(' + count + ')" id="txtSupplytype' + count + '" name="txtSupplytype[]" data-placeholder="Supply Type">' +
    '        <option value=""></option>' +
    '        <option value="Operation Pull (Picklist)">Operation Pull (Picklist)</option>' +
    '        <option value="Operation Pull">Operation Pull</option> ' +
    '        <option value="Push">Push</option> ' +
    "      </select>" +
    "    </div>" +
    '    <div class="form-group hidden" id="sub1' + count + '">' +
    "      <label>Supply Subinventory</label>" +
    '      <input class="form-control" id="txtSupplySub' + count + '" type="text" name="txtSupplySub[]" placeholder="Type">' +
    "    </div>" +
    '    <div class="form-group hidden" id="sub2' + count + '">' +
    "      <label>Supply Locator</label>" +
    '      <input class="form-control" id="txtSupplyLocator' + count + '" type="text" name="txtSupplyLocator[]" placeholder="Type">' +
    "    </div>" +
    '    <div class="form-group hidden" id="sub3' + count + '">' +
    "      <label>Subinventory Picklist</label>" +
    '      <input class="form-control" id="txtSubPicklist' + count + '" type="text" name="txtSubPicklist[]" placeholder="Type">' +
    "    </div>" +
    '    <div class="form-group hidden" id="sub4' + count + '">' +
    "      <label>Locator Picklist</label>" +
    '      <input class="form-control" id="txtLocatorPicklist' + count + '" type="text" name="txtLocatorPicklist[]" placeholder="Type">' +
    "    </div>" +
    "  </div>" +
    "</div>";
  $("#sub").append(html);

  // $(".remove_qi").show();
}

function Refresh() {
  var table = $('#dataTablePBR').DataTable()
  table.ajax.reload();
}

function Refresh2() {
  var table = $('#dataTablePBR2').DataTable()
  table.ajax.reload();
}

function minBox() {
  var lengBox = $(".boxInput").length
  // console.log(lengBox);
  $("#boxInput" + lengBox).remove()
}

function btnpbr() {
  var getval = $(document.getElementById("txtLocatorPicklist")).val()
  var getval2 = $(document.getElementById("txtNoDokumen")).val()
  if (getval2 == '') {
    Swal.fire({
      type: 'error',
      title: 'Oops...',
      text: 'Cannot null',
    }).then(_ => {
      $('#txtLocatorPicklist').val('');
    })
  }
  // console.log(getval);
}

function modalPBRUpdate(id) {
  // console.log(id);
  $.ajax({
    method: 'POST',
    async: true,
    dataType: 'json',
    url: baseurl + 'PendaftaranBomRouting/UserManagement/getDataUserUpdate',
    data: {
      user_id: id
    },
    success: function(result) {
      console.log(result);

      const newOption = `
              <option value="${result[0].no_induk}">${result[0].no_induk}</option>
             `;
      const newOption2 = `
              <option value="${result[0].nama}">${result[0].nama}</option>
             `;
      const newOption3 = `
              <option value="${result[0].role_access}">${result[0].role_access}</option>
              <option value="Admin">Admin</option>
              <option value="Member">Member</option>
             `;

      $("#indIDUp").html(newOption);
      $("#indIDUp").val(result[0].no_induk).trigger('change');

      $("#txtUserUp").html(newOption2);
      $("#txtUserUp").val(result[0].nama).trigger('change');

      $("#txtPermissionUp").html(newOption3);
      $("#txtPermissionUp").val(result[0].role_access).trigger('change');
      $("#IDusr").val(id);
    },
  })
}

function getDataUserCreate() {
  var induk = $('#indID').val()
  console.log(induk);
  $.ajax({
    method: 'POST',
    async: true,
    dataType: 'json',
    url: baseurl + "PendaftaranBomRouting/UserManagement/getDataUserCreate",
    data: {
      user_id: induk,
    },
    success: function(result1) {
      const newOption2 = `
              <option value="${result1[0].nama}">${result1[0].nama}</option>
             `;
      $("#txtUser").html(newOption2);
      $("#txtUser").val(result1[0].nama).trigger('change');
    }


  })
}

function deleteUser(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.value) {
      Swal.fire(
        'Deleted!',
        'Your file has been deleted.',
        'success'
      )
    }
  }).then(_ => {
    window.location.href = baseurl + 'PendaftaranBomRouting/UserManagement/deleteUser/' + id;
  })
}

function DeleteHeader(id) {
  var tableSaitama = $('#dataTablePBR').DataTable();
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.value) {
      Swal.fire(
        'Deleted!',
        'Your file has been deleted.',
        'success'
      ).then(_ => {
        $.ajax({
          method: 'POST',
          async: true,
          dataType: 'json',
          url: baseurl + 'PendaftaranBomRouting/ListBOMRouting/DeleteHeader',
          data: {
            id: id,
          },
          success: function(result) {
            console.log(result);
          }
        })
      }).then(_ => {
        tableSaitama.ajax.reload();
      })
    }
  })
}


$('#BOMredactor').redactor({});

$('.btnBOMcheckSend').on('click', function() {
  // Disable form from user interaction
  Swal.fire({
    allowOutsideClick: false,
    title: 'Mohon menunggu',
    html: 'Sedang mengirim pesan ...',
    onBeforeOpen: () => {
      Swal.showLoading()
    },
  })
  // Ajax Send Email
  var
    form_data = new FormData(),
    toEmail = $('#BOMemail').val(),
    ccEmail = $('#BOMccemail').val(),
    // bccEmail 		    = $('#BOMbccemail').val(),
    subject = $('#BOMsubject').val(),
    file_attach = $('#BOMAttachment').prop('files')[0],
    body = $('#BOMredactor').val();

  form_data.append('PBRfile_att', file_attach);
  form_data.append('PBRemail', toEmail);
  form_data.append('PBRccemail', ccEmail);
  // form_data.append('PBRbccemail', bccEmail);
  form_data.append('PBRsubj', subject);
  form_data.append('PBRisi', body);

  // console.log('Hello World!')
  $.ajax({
    type: 'post',
    url: baseurl + 'PendaftaranBomRouting/InputBOMRouting/sendEmailSubmit',
    processData: false,
    contentType: false,
    data: form_data,
    dataType: 'json',
    success: function(result) {
      // console.log(result);
      if (result == 'Message sent!') {
        Swal.fire(
          'Success!',
          'Pesan telah terkirim',
          'success'
        )
      } else {
        Swal.fire({
          type: 'error',
          title: 'Oops...',
          text: 'Pesan gagal terkirim :(',
          footer: '<span style="color:#3c8dbc">' + result + '</span>'
        });
      }
    }
  })

});
