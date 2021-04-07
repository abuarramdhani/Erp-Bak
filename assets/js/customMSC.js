$(document).ready(function () {
    $(".itemreq").select2({
        allowClear: true,
        placeholder: "Masukkan Item",
        minimumInputLength: 3,
        ajax: {
                url: baseurl + "MiscellaneousKasie/Request/getItem",
                dataType: 'json',
                type: "GET",
                data: function (params) {
                        var queryParameters = {
                                term: params.term, 
                                sub : $('#subinvmis').val(), 
                                lok : $('#locatormis').val()
                        }
                        return queryParameters;
                },
                processResults: function (data) {
                        // console.log(apa);
                        return {
                                results: $.map(data, function (obj) {
                                        return {id:obj.SEGMENT1, text:obj.SEGMENT1+' - '+obj.DESCRIPTION};
                                })
                        };
                }
        }
    });
    
    $(".getioo").select2({
        allowClear: true,
        placeholder: "Pilih IO",
        minimumInputLength: 0,
        ajax: {
                url: baseurl + "MiscellaneousKasie/Request/getIO",
                dataType: 'json',
                type: "GET",
                data: function (params) {
                        var queryParameters = {
                                term: params.term,
                        }
                        return queryParameters;
                },
                processResults: function (data) {
                        // console.log(apa);
                        return {
                                results: $.map(data, function (obj) {
                                        return {id:obj.ORGANIZATION_CODE, text:obj.ORGANIZATION_CODE};
                                })
                        };
                }
        }
    });
    
    $(".getsubinv").select2({
        allowClear: true,
        placeholder: "Pilih Cost Center",
        minimumInputLength: 0,
        ajax: {
                url: baseurl + "MiscellaneousKasie/Request/getSubinv",
                dataType: 'json',
                type: "GET",
                data: function (params) {
                        var queryParameters = {
                                term: params.term,
                        }
                        return queryParameters;
                },
                processResults: function (data) {
                        // console.log(apa);
                        return {
                                results: $.map(data, function (obj) {
                                        return {id:obj.SUB_INV_CODE, text:obj.SUB_INV_CODE};
                                })
                        };
                }
        }
    });
    
    $(".getapproverReq").select2({
        allowClear: true,
        minimumInputLength: 0,
        ajax: {
                url: baseurl + "MiscellaneousKasie/Request/getAssignApprove",
                dataType: 'json',
                type: "GET",
                data: function (params) {
                        var queryParameters = {
                                term: params.term,
                        }
                        return queryParameters;
                },
                processResults: function (data) {
                        // console.log(apa);
                        return {
                                results: $.map(data, function (obj) {
                                        return {id:obj.user_name, text:obj.user_name+' - '+obj.employee_name};
                                })
                        };
                }
        }
    });
    
    $(".getppcReq").select2({
        allowClear: true,
        minimumInputLength: 0,
        ajax: {
                url: baseurl + "MiscellaneousKasie/Request/getAssignPPC",
                dataType: 'json',
                type: "GET",
                data: function (params) {
                        var queryParameters = {
                                term: params.term,
                        }
                        return queryParameters;
                },
                processResults: function (data) {
                        // console.log(apa);
                        return {
                                results: $.map(data, function (obj) {
                                        return {id:obj.user_name, text:obj.user_name+' - '+obj.employee_name};
                                })
                        };
                }
        }
    });
    
    $(".getcabangReq").select2({
        allowClear: true,
        minimumInputLength: 0,
        ajax: {
                url: baseurl + "MiscellaneousKasie/Request/getAssignCabang",
                dataType: 'json',
                type: "GET",
                data: function (params) {
                        var queryParameters = {
                                term: params.term,
                        }
                        return queryParameters;
                },
                processResults: function (data) {
                        // console.log(apa);
                        return {
                                results: $.map(data, function (obj) {
                                        return {id:obj.user_name, text:obj.user_name+' - '+obj.employee_name};
                                })
                        };
                }
        }
    });
    
    $(".getusermis").select2({
        allowClear: true,
        placeholder: "Pilih User",
        minimumInputLength: 0,
        ajax: {
                url: baseurl + "MiscellaneousKasie/UserManual/getUserMis",
                dataType: 'json',
                type: "GET",
                data: function (params) {
                        var queryParameters = {
                                term: params.term,
                        }
                        return queryParameters;
                },
                processResults: function (data) {
                        // console.log(apa);
                        return {
                                results: $.map(data, function (obj) {
                                        return {id:obj.noind, text:obj.noind+' - '+obj.nama};
                                })
                        };
                }
        }
    });

    $(".selectnoseri").select2({
        allowClear: true,
        minimumInputLength: 0,
        ajax: {
                url: baseurl + "MiscellaneousKasie/Request/getNoSerial",
                dataType: 'json',
                type: "GET",
                data: function (params) {
                        var queryParameters = {
                                term: params.term,
                                subinv : $('#subinvmis').val(),
                                item : $('#item').val()
                        }
                        return queryParameters;
                },
                processResults: function (data) {
                        // console.log(apa);
                        return {
                                results: $.map(data, function (obj) {
                                        return {id:obj.SERIAL_NUMBER, text:obj.SERIAL_NUMBER};
                                })
                        };
                }
        }
    });

    
    $(".selectmanual").select2({
        allowClear: true,
        width: "element",
        tags: true,
        id: function (object) {
          return object.text;
        },
        createSearchChoice: function (term, data) {
          if (
            $(data).filter(function () {
              return this.text.localeCompare(term) === 0;
            }).length === 0
          ) {
            return {
              id: term,
              text: term,
            };
          }
        },
      });

        var kasie = document.getElementById("miscellaneousKasie");
        if(kasie){ // resp. Niscellaneous Kepala Seksi
            viewrequest('onprocess', 'kasie', '#5EDB8C', 'onprocessKasie', 0);//parameter data onprocess Misc Kepala Seksi
            viewrequest('finished', 'kasie', '#50B6E6', 'finishedKasie', 8);//parameter data finished Misc Kepala Seksi
        }
        
        var askanit = document.getElementById("miscellaneousCabang");
        if(askanit){ // resp. miscellaneous kepala cabang
            viewrequest('approve', 'cabang', '#F2636E', 'approveCabang', 1);
        //     viewrequest('onprocess', 'askanit', '#5EDB8C', 'onprocessAskanit', 2);
        //     viewrequest('finished', 'askanit', '#50B6E6', 'finishedAskanit', 8);
        }
        
        var askanit = document.getElementById("miscellaneousAskanit");
        if(askanit){ // resp. miscellaneous kepala seksi utama
            viewrequest('approve', 'askanit', '#F2636E', 'approveAskanit', 2);
        //     viewrequest('onprocess', 'askanit', '#5EDB8C', 'onprocessAskanit', 2);
        //     viewrequest('finished', 'askanit', '#50B6E6', 'finishedAskanit', 8);
        }
        
        var ppc = document.getElementById("miscellaneousPPC");
        if(ppc){ // resp. miscellaneous seksi ppc
            viewrequest('approve', 'ppc', '#F2636E', 'approvePPC', 3);
        //     viewrequest('onprocess', 'ppc', '#5EDB8C', 'onprocessPPC', 3);
        //     viewrequest('finished', 'ppc', '#50B6E6', 'finishedPPC', 8);
        }
        
        var kadep = document.getElementById("miscellaneousKadep");
        if(kadep){ // resp. miscellaneous kepala department
            viewrequest('approve', 'kadep', '#F2636E', 'approveKadep', 4);
        //     viewrequest('onprocess', 'kadep', '#5EDB8C', 'onprocessKadep', 4);
        //     viewrequest('finished', 'kadep', '#50B6E6', 'finishedKadep', 8);
        }
        
        var costing = document.getElementById("miscellaneousCosting");
        if(costing){ // resp. miscellaneous costing menu request miscellaneous
            viewrequest('approve', 'costing', '#F2636E', 'approveCosting', 5);
            viewrequest('approvemanual', 'costing', '#FFA940', 'approvemanualCosting', 4);
            viewrequest('onprocess', 'costing', '#5EDB8C', 'onprocessCosting', 5);
        }
        
        var inputCosting = document.getElementById("miscellaneousinputCosting");
        if(inputCosting){ // resp. miscellaneous costing menu siap input miscellaneous
            viewrequest('siapinput', 'costing', '#5EDB8C', 'siapinputCosting', 7);
            viewrequest('finished', 'costing', '#50B6E6', 'finishedCosting', 8);
        }
        
        var akt = document.getElementById("miscellaneousAkuntansi");
        if(akt){ // resp. miscellaneous akuntansi
            viewrequest('approve', 'akt', '#F2636E', 'approveAkuntansi', 6);
        //     viewrequest('onprocess', 'akt', '#5EDB8C', 'onprocessAkuntansi', 6);
        //     viewrequest('finished', 'akt', '#50B6E6', 'finishedAkuntansi', 8);
        }
        
        var alasan = document.getElementById("tb_setdata_alasan");
        if(alasan){ // resp. miscellaneous costing menu setting alasan
                getdataalasan();
        }

        // var user = document.getElementById("tb_user_mng");
        // if(user){
        //         var ket = $('#ketuser').val();
        //         getdatausermis(ket);
        // }

})


function viewrequest(ket, apk, warna, name, bts) { //cari data dan tampilkan tabel sesuai parameter
	$.ajax({
		url: baseurl + 'MiscellaneousKasie/Request/viewrequest',
		data : {ket : ket, apk : apk, warna : warna, name : name, bts : bts},
		type: 'POST',
		beforeSend: function() {
			$('div#tb_'+ket ).html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading3.gif"></center>' );
		},
		success: function(result) {
			$('div#tb_'+ket).html(result);
                        $('#tbl_req'+name).DataTable({
                                "scrollX" : true,
                                "columnDefs": [{
                                "targets": '_all',
                                }],
                        });
                        if (ket == 'approve' || ket == 'siapinput') {
                                var jml = $('#jml_data').val();
                                $('#jml_approve').html(jml+' REQUEST'); // jumlah data yang muncul di tabel approve dan siap input
                        }
		}
	})
}

function getdataalasan() {
        $.ajax({
                url: baseurl + 'MiscellaneousCosting/SettingData/getdataAlasan',
                dataType: 'html',
                beforeSend: function() {
                        $('div#tb_setdata_alasan' ).html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
                },
                success: function(result) {
                        $('div#tb_setdata_alasan').html(result);
                        $('#tbl_req').DataTable({
                                "scrollX" : true,
                                "columnDefs": [{
                                "targets": '_all',
                                }],
                        });
                }
        })
}


$(document).on("change", "#subinvmis", function(){
	var sub = $('#subinvmis').val();
	// console.log(sub);

	$.ajax({
		data: { sub: sub },
		url: baseurl + "MiscellaneousKasie/Request/getLokator",
		type: "POST",
		success: function (result) {
		  if (result != "<option></option>") {
			$("#gantilocatormis").html('<select name="locator" id="locatormis" class="form-control select2" style="width:100%" data-placeholder="Pilih Locator" required>'+result+'</select>');
                        $("#locatormis").select2({
                                allowClear: true,
                                minimumInputLength: 0,
                        });
		  } else {
                        $('#gantilocatormis').html('<input name="locator" id="locatormis" class="form-control" placeholder="Pilih Locator" readonly>');
		  }
		},
        });
});

$(document).on("change", '.ketcost', function () {
        var ket = $('input[name="ket_cost"]:checked').val();    
        console.log(ket)  
        
        $(".getcost").select2({
                allowClear: true,
                placeholder: "Pilih Cost Center",
                minimumInputLength: 0,
                ajax: {
                        url: baseurl + "MiscellaneousKasie/Request/getCostCenter",
                        dataType: 'json',
                        type: "GET",
                        data: function (params) {
                                var queryParameters = {
                                        term: params.term, ket : ket
                                }
                                return queryParameters;
                        },
                        processResults: function (data) {
                                // console.log(apa);
                                return {
                                        results: $.map(data, function (obj) {
                                                return {id:obj.COST_CENTER, text:obj.COST_CENTER+' - '+obj.PEMAKAI};
                                        })
                                };
                        }
                }
        });
})


$(document).on("change", "#qtymis", function () {
        var qty = parseFloat($('#qtymis').val());    
        var onhand = parseFloat($('#onhandmis').val());    
        var order = $('input[name="order"]:checked').val();    
        console.log(onhand, qty)  
        if (order == 'ISSUE') {
                if (qty > onhand) {
                        document.getElementById("qtymis").style.backgroundColor = "#F6B0AF";
                        $('#warning_qty').html('Permintaan melebihi ondand!');
                }else{
                        document.getElementById("qtymis").style.backgroundColor = "";
                        $('#warning_qty').html('');
                }
        }
})


$(document).on("change", "#noseri", function () {
        var serial = $('#noseri').val();      
        var item = $('#item').val();      
        var subinv = $('#subinvmis').val();      
        var order = $('input[name="order"]:checked').val();    
        // console.log(serial, order);
        if (order == 'RECEIPT') {
                $.ajax({
                        data: { item: item, serial : serial, subinv : subinv },
                        url: baseurl + "MiscellaneousKasie/Request/cekSerialReceipt",
                        type: "POST",
                        success: function (result) {
                                if (result) {
                                        $('#warning_noseri').html('No Serial '+result+' sudah ada!');
                                }else{
                                        $('#warning_noseri').html('');
                                }
                        },
                });
        }
})

$(document).on("change", '.order_misc', function () {
        var order = $('input[name="order"]:checked').val();  
        console.log(order); 
        if (order == 'ISSUE') {
                $('#noseri').removeClass('selectmanual').addClass('selectnoseri');
                $(".selectnoseri").select2({
                        allowClear: true,
                        minimumInputLength: 0,
                        ajax: {
                                url: baseurl + "MiscellaneousKasie/Request/getNoSerial",
                                dataType: 'json',
                                type: "GET",
                                data: function (params) {
                                        var queryParameters = {
                                                term: params.term,
                                                subinv : $('#subinvmis').val(),
                                                item : $('#item').val()
                                        }
                                        return queryParameters;
                                },
                                processResults: function (data) {
                                        // console.log(apa);
                                        return {
                                                results: $.map(data, function (obj) {
                                                        return {id:obj.SERIAL_NUMBER, text:obj.SERIAL_NUMBER};
                                                })
                                        };
                                }
                        }
                    });
        }else{
                $('#noseri').removeClass('selectnoseri').addClass('selectmanual');
                $(".selectmanual").select2({
                        allowClear: true,
                        width: "element",
                        tags: true,
                        id: function (object) {
                        return object.text;
                        },
                        createSearchChoice: function (term, data) {
                        if (
                        $(data).filter(function () {
                        return this.text.localeCompare(term) === 0;
                        }).length === 0
                        ) {
                        return {
                        id: term,
                        text: term,
                        };
                        }
                        },
                });
        }
})

// $(document).on("change", '.pilihuom', function () {
//         var ket = $('input[name="uom"]:checked').val();   
//         console.log(ket); 
//         if (ket == 'Dual Uom') {
//                 $('#sec_uom').css('display', '');
//                 $('#sec_uom').html('<select name="second_uom" id="second_uom" class="form-control select2" style="width:100%" data-placeholder="Secondary Uom"><option></option></select>');
//                 $("#second_uom").select2({
//                         allowClear: true,
//                         minimumInputLength: 0,
//                         ajax: {
//                                 url: baseurl + "MiscellaneousKasie/Request/getUOM",
//                                 dataType: 'json',
//                                 type: "GET",
//                                 data: function (params) {
//                                         var queryParameters = {
//                                                 term: params.term
//                                         }
//                                         return queryParameters;
//                                 },
//                                 processResults: function (data) {
//                                         // console.log(apa);
//                                         return {
//                                                 results: $.map(data, function (obj) {
//                                                         return {id:obj.UOM_CODE, text:obj.UOM_CODE+' - '+obj.UNIT_OF_MEASURE};
//                                                 })
//                                         };
//                                 }
//                         }
//                 });
//         }else{
//                 $('#sec_uom').css('display', 'none');
//                 $('#second_uom').select2('val', '');
//                 $('#second_uom').val('');
//         }
// })


function getdescreq(th) {
	var item = $('#item').val();
        var sub = $('#subinvmis').val();
        var lok = $('#locatormis').val();
        // console.log(sub, lok)
	$.ajax({
		url: baseurl + 'MiscellaneousKasie/Request/getDescription',
		data  : {item : item, sub : sub, lok : lok},
		dataType: 'json',
		type: 'POST',
		success: function(result) {
                        console.log(result);
                        // var arr = Object.keys(result).length;
                        $('#qtymis').removeAttr('readonly')
                        $('#desc').val(result[0]);
			$('#onhandmis').val(result[1]);
			$('#first_uom').val(result[2]);
                        $('#inv_item').val(result[4]);
                        if (result[3] != null) {
                                $('#second_uom').val(result[3]);
                                $('#dual_uom').prop('checked', true);
                                // $('#sec_uom').css('display', '');
                                // $('#sec_uom').html('<input name="second_uom" id="second_uom" class="form-control" value="'+result[3]+'" readonly>');
                        }else{
                                $('#single_uom').prop('checked', true);
                                // $('#sec_uom').css('display', 'none');
                                // $('#sec_uom').html('<input name="second_uom" id="second_uom" class="form-control" value="" readonly>');
                        }
		}
	})
}

function deletebaris(no) { // hapus baris tabel request request baru miscellaneous
        var item        = $('#item'+no).val();
        var nomor       = $('#nomor'+no).val();
        var pic         = $('#pic'+no).val();
        var attachment  = $('#attachment'+no).val();
        $.ajax({
                url : baseurl + "MiscellaneousKasie/Request/deleteTemp",
                data : {item : item, nomor : nomor, pic : pic, attachment : attachment},
                dataType : 'html',
                type : 'POST',
                success : function (data) {
                        $('#baris'+no).remove()
                }
        })
}

function edit_attach(no) {
        var attachment  = $('#attachment'+no).val();
        $.ajax({
                url : baseurl + "MiscellaneousKasie/Request/edit_attachment",
                data : {attachment : attachment},
                dataType : 'html',
                type : 'POST',
                success : function (data) {
                        $('#data_edit_attach').html(data);
                        $('#mdleditattach').modal('show');
                }
        })
}

function delete_attach(no) {
        var attachment  = $('#attachment'+no).val();
        Swal.fire({
                title: 'Apakah Anda Yakin ?',
                type: 'question',
                showCancelButton: true,
                allowOutsideClick: false
            }).then(result => {
                if (result.value) {  
                        $.ajax({
                                url : baseurl + "MiscellaneousKasie/Request/delete_attachment",
                                data : {attachment : attachment},
                                dataType : 'html',
                                type : 'POST',
                        })
            }})  
}

function mdlTambahRequest(th) {
        $.ajax({
                url : baseurl + "MiscellaneousKasie/Request/modalTambahReq",
                dataType : 'html',
                type : 'POST',
                success : function (data) {
                        $('#mdlReqMis').modal('show');
                        $('#datareq').html(data);
                        $("#io").select2({
                                allowClear: true,
                                minimumInputLength: 0,
                        });
                }
        })
}

function mdlhistoryMis() {
        $.ajax({
                url : baseurl + "MiscellaneousKasie/Request/modalHistory",
                data : {id : $('#id_header').val()},
                dataType : 'html',
                type : 'POST',
                success : function (data) {
                        $('#judul_modal').html('HISTORY APPROVAL');
                        $('#mdldetailMis').modal('show');
                        $('#datareq').html(data);
                }
        })
}

function mdlnotesMis(id_item) {
        $.ajax({
                url : baseurl + "MiscellaneousKasie/Request/modalNotes",
                data : {id_item : id_item},
                dataType : 'html',
                type : 'POST',
                success : function (data) {
                        $('#judul_modal').html('NOTES APPROVAL');
                        $('#mdldetailMis').modal('show');
                        $('#datareq').html(data);
                }
        })
}

function revisiqty(no) {
        var item = $('#kode_item'+no).val();
        var qty = $('#qty'+no).val();
        var revqty = $('#revqty'+no).val();
        if (revqty == '') {
                isi = '<p style="text-align:left;margin-left:120px">Kode Item : <b>'+item+'</b> </p><p style="text-align:left;margin-left:120px"> QTY awal : <b>'+qty+'</b></p>';
        }else{
                isi = '<p style="text-align:left;margin-left:120px">Kode Item : <b>'+item+'</b> </p><p style="text-align:left;margin-left:120px"><span>QTY awal : <b>'+qty+'</b></span><span style="margin-left:50px">QTY revisi : <b>'+revqty+'</b></span></p>';
        }
        
	Swal.fire({
		title: 'Revisi Quantity : ',
		html : isi,
		// type: 'success',
		input: 'number',
		showCancelButton: true,
		confirmButtonText: 'OK',
		showLoaderOnConfirm: true,
	}).then(result => {
		if (result.value) {
			var val = parseFloat(result.value);
                        var onhand = parseFloat($('#onhand'+no).val());
                        console.log(val, onhand)
			if (val > onhand) {
                                swal.fire("Permintaan melebihi onhand.", "", "error");
                        }else{
                                $('#revqty'+no).val(val);
                        }
                }
        })
}

function mdlapprovemanual(ket, no) {
        $.ajax({
                url : baseurl + "MiscellaneousCosting/Request/modalApproveManual",
                data : {id_header : $('#idheader'+ket+no).val(),
                        nodoc : $('#nodoc'+ket+no).val(),
                        io : $('#io'+ket+no).val(),
                        tgl_transact : $('#tgl_transact'+ket+no).val(),
                        pic : $('#pic'+ket+no).val(),
                        status : $('#status'+ket+no).val(),
                        ket : ket},
                dataType : 'html',
                type : 'POST',
                success : function (data) {
                        $('#mdlReqMis').modal('show');
                        $('#datareq').html(data);
                }
        })
}

function saveAlasan() {
        var alasan = $('#alasan').val();
        if (alasan != '') {
                $.ajax({
                        url : baseurl + "MiscellaneousCosting/SettingData/saveAlasan",
                        data : {alasan : alasan},
                        dataType : 'html',
                        type : 'POST',
                        success : function (data) {
                                $('#mdlTambahAlasan').modal('hide');
                                $('#alasan').val('');
                                getdataalasan();
                        }
                })
        }else{
                $.toaster('ERROR', 'Alasan Belum Diisi!', 'danger');
        }
}

function delAlasan(no) {
        $.ajax({
                url : baseurl + "MiscellaneousCosting/SettingData/delAlasan",
                data : {id : $('#id'+no).val()},
                dataType : 'html',
                type : 'POST',
                success : function (data) {
                        getdataalasan();
                }
        })

}

function gantiAction(no) {
        var act = $('#action_costing'+no).val(); 
        console.log(act);
        if (act == 'Reject') {
                $('#gantitipe'+no).html('<input name="type_transaksi[]" id="type_transaksi'+no+'" class="form-control" style="width:150px" readonly>')
                $('#ganticoa'+no).html('<input name="coa[]" id="coa'+no+'" class="form-control" style="width:150px" readonly>')
                $('#desc_biaya'+no).val('');
                $('#desc_cc'+no).val('');
                $('#produk'+no).attr('readonly', 'readonly');
        }else{
                $('#gantitipe'+no).html('<select name="type_transaksi[]" id="type_transaksi'+no+'" class="form-control select2 getTipeTrans" style="width:150px" required></select>');
                $('#ganticoa'+no).html('<select name="coa[]" id="coa'+no+'" class="form-control select2 getAkunCOA" style="width:150px" onchange="getdescCOA('+no+')" required></select>');
                $('#desc_biaya'+no).val('');
                $('#desc_cc'+no).val('');
                $('#produk'+no).removeAttr('readonly', '');
                
                $(".getTipeTrans").select2({
                        allowClear: true,
                        placeholder: "",
                        minimumInputLength: 0,
                        ajax: {
                                url: baseurl + "MiscellaneousCosting/Request/getTypeTransact",
                                dataType: 'json',
                                type: "GET",
                                data: function (params) {
                                        var queryParameters = {
                                                term: params.term,
                                        }
                                        return queryParameters;
                                },
                                processResults: function (data) {
                                        // console.log(apa);
                                        return {
                                                results: $.map(data, function (obj) {
                                                        return {id:obj.TRANSACTION_TYPE_NAME, text:obj.TRANSACTION_TYPE_NAME};
                                                })
                                        };
                                }
                        }
                });
                
                $("#coa"+no).select2({
                        allowClear: true,
                        placeholder: "",
                        minimumInputLength: 0,
                        ajax: {
                                url: baseurl + "MiscellaneousCosting/Request/getAkunCOA",
                                dataType: 'json',
                                type: "GET",
                                data: function (params) {
                                        var queryParameters = {
                                                term: params.term, cost : $('#cost_center'+no).val()
                                        }
                                        return queryParameters;
                                },
                                processResults: function (data) {
                                        // console.log(apa);
                                        return {
                                                results: $.map(data, function (obj) {
                                                        return {id:obj.AKUN, text:obj.AKUN};
                                                })
                                        };
                                }
                        }
                });
        }
}

function getdescCOA(no) {
        var akun = $('#coa'+no).val();
        var cost = $('#cost_center'+no).val();
        $.ajax({
		url: baseurl + 'MiscellaneousCosting/Request/getDescriptionCOA',
		data  : {akun : akun, cost : cost},
		dataType: 'json',
		type: 'POST',
		success: function(result) {
                        // console.log(result)
                        $('#desc_biaya'+no).val(result[0]);
                        $('#desc_cc'+no).val(result[1]);
		}
	})
}


function deleteitem(id_item) {
        $.ajax({
		url: baseurl + 'MiscellaneousCosting/Request/deleteItem',
		data  : {id_item : id_item},
		dataType: 'html',
		type: 'POST',
		success: function(result) {
                        $('#hapusdata'+id_item).css('display', 'none');
		}
	})
}