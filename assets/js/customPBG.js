$(document).ready(function () {
    $(".proses_assembly").select2({
        allowClear: true,
        placeholder: "Pilih Tipe Produk",
        minimumInputLength: 0,
        ajax: {
            url: baseurl + "PengembalianBarangGudang/Input/getTipeProduk",
            dataType: 'json',
            type: "GET",
            data: function (params) {
                var queryParameters = {
                        term: params.term,
                }
                return queryParameters;
            },
            processResults: function (data) {
                // console.log(data);
                return {
                    results: $.map(data, function (obj) {
                        return {id:obj.KODE, text:obj.TIPE_PRODUK};
                    })
                };
            }
        }
    });

    $(".pic_assembly").select2({
        allowClear: true,
        placeholder: "Input PIC Assembly",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + "PengembalianBarangGudang/Input/getPic",
            dataType: 'json',
            type: "GET",
            data: function (params) {
                var queryParameters = {
                        term: params.term,
                }
                return queryParameters;
            },
            processResults: function (data) {
                // console.log(data);
                return {
                    results: $.map(data, function (obj) {
                        return {id:obj.pic, text:obj.pic};
                    })
                };
            }
        }
    });

    $(".pic_gudang").select2({
        allowClear: true,
        placeholder: "Input PIC Gudang",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + "PengembalianBarangGudang/Input/getPic",
            dataType: 'json',
            type: "GET",
            data: function (params) {
                var queryParameters = {
                        term: params.term,
                }
                return queryParameters;
            },
            processResults: function (data) {
                // console.log(data);
                return {
                    results: $.map(data, function (obj) {
                        return {id:obj.pic, text:obj.pic};
                    })
                };
            }
        }
    });

    $(".pic_email").select2({
        allowClear: true,
        placeholder: "Input PIC",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + "PengembalianBarangGudang/Input/getPic",
            dataType: 'json',
            type: "GET",
            data: function (params) {
                var queryParameters = {
                        term: params.term,
                }
                return queryParameters;
            },
            processResults: function (data) {
                // console.log(data);
                return {
                    results: $.map(data, function (obj) {
                        return {id:obj.pic, text:obj.pic};
                    })
                };
            }
        }
    });

})

$('#proses_assembly').change(function(){
    var kode_produk = $(this).val();
    // console.log(kode_produk);

	$(".kode_komponen").select2({
        allowClear: true,
        placeholder: "Pilih Kode Komponen",
        minimumInputLength: 0,
        ajax: {
            url: baseurl + "PengembalianBarangGudang/Input/getKodeKomponen",
            dataType: 'json',
            type: "GET",
            data: function (params) {
                var queryParameters = {
                    term : params.term,
                    kode_produk : kode_produk
                }
                return queryParameters;
            },
            processResults: function (data) {
                // console.log(data);
                return {
                    results: $.map(data, function (obj) {
                        return {id:obj.ITEM, text:obj.KODE};
                    })
                };
            }
        }
    });
});

function InputBarang(){
    var proses_assembly = $('#proses_assembly').val();
    var kode_komponen = $('#kode_komponen').val();
    var asal_barang = $('#asal_barang').val();
    var qty_komponen = $('#qty_komponen').val();
    var alasan_pengembalian = $('#alasan_pengembalian').val();
    var pic_assembly = $('#pic_assembly').val();
    var pic_gudang = $('#pic_gudang').val();

    $.ajax ({
        url : baseurl + "PengembalianBarangGudang/Input/InputPengembalian",
        data: { 
            proses_assembly : proses_assembly,
            kode_komponen : kode_komponen,
            asal_barang : asal_barang,
            qty_komponen : qty_komponen,
            alasan_pengembalian : alasan_pengembalian,
            pic_assembly : pic_assembly,
            pic_gudang : pic_gudang
        },
        type : "POST",
        dataType: "html",
        beforeSend: function() {
            Swal.showLoading();
        },
        success: function (response) {
            Swal.fire({
                title: "Sukses",
                title: "Berhasil Menginput Pengembalian Barang!",
                type: "success"
            }).then(function(result) {
                location.reload();
            })
        }
    });
}

var input = document.getElementById("tb_data_input");
if (input) {
    var request = $.ajax({
        url: baseurl+'PengembalianBarangGudang/Input/getDataInput',
        type: "POST",
        datatype: 'html'
    });

    $('#tb_data_input').html('');
	$('#tb_data_input').html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
    
    request.done(function(result){
        $('#tb_data_input').html(result);
        $('#tblInputPengembalian').dataTable({
            "scrollX": true
        });
    })
}

function orderverifselectedPBG(){
    var id = $('input[name="selectedKompPBG"]').val();
    var id_pengembalian = $('input[name="id_pengembalian[]"]').map(function(){return $(this).val();}).get();
    var id2 = id.split('+');
    // console.log(id, id_pengembalian);
    for (let i = 0; i < id2.length; i++) {
		for (let x = 0; x < id_pengembalian.length; x++) {
			if (id2[i] == id_pengembalian[x]) {
				// console.log(id_pengembalian[x]);
				CreateOrderVerifQc(id_pengembalian[x]);
			}
		}
		
	}
}

 function CreateOrderVerifQc(id_pengembalian) {
    let status_verifikasi = 'Menunggu Hasil Verifikasi QC';
    // console.log(id_pengembalian, status_verifikasi);
    var request = $.ajax({
        url: baseurl + 'PengembalianBarangGudang/Input/UpdateStatusVerif',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          id_pengembalian: id_pengembalian,
          status_verifikasi: status_verifikasi
        },
        beforeSend: function() {
          Swal.showLoading()
        },
        success: function(result) {
            if (result === 1) {
                // location.reload();
                $.ajax({
                    url: baseurl + 'PengembalianBarangGudang/Input/EmailQC/' + id_pengembalian,
                    type: 'POST',
                    dataType: 'JSON',
                    async: true,
                    data: {
                        id_pengembalian: id_pengembalian,
                    },
                    beforeSend: function() {
                        Swal.showLoading()
                    },
                    success: function(result) {
                        if (result === "Success") {
                            location.reload();
                            // Swal.fire({
                            //     type: 'success',
                            //     title: 'Order Verifikasi Telah Dikirim ke QC',
                            //     text: 'Mohon untuk menunggu hasil verifikasi QC max 2x24 jam',
                            // }).then(_ => {
                            //     location.reload();
                            // })
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

$('.tblMonPengembalian').DataTable({
    "scrollX": true
});

function InputVerifQc(id_pengembalian){
    var sub_ok = 'DMC';
    var loc_ok = 1432 //KOM-DMC;
    var sub_not_ok = 'REJECT-DM';
    var sub_lain = null;
    var inputOptions = new Promise(function(resolve) {
        resolve({
            '82' : 'MACHINING A REJ',
            '83' : 'MACHINING B REJ',
            '84' : 'MACHINING C REJ',
            '85' : 'MACHINING D REJ',
            '88' : 'PAINTING REJ',
            '1017' : 'AREA HTM',
            '1007' : 'AREA WELDING',
            'LAIN-LAIN' : 'LAIN-LAIN'
        });
    });

    Swal.fire({
        title: 'Input Hasil Verifikasi QC',
        input: 'select',
        inputOptions: {
            'OK':'OK',
            'REPAIR':'REPAIR',
            'REJECT':'REJECT'
        },
        inputPlaceholder: 'Hasil Verifikasi QC',
        allowOutsideClick: false,
        inputValidator: (value) => {
            return !value && 'Mohon Input Hasil Verifikasi Terlebih Dahulu'
        },
    }).then((result) => {
        if (result.value == 'OK') {
            $.ajax({
                type: "POST",
                url: baseurl + 'VerifikasiPengembalianBarang/Verifikasi/UpdateStatusVerifQC',
                data: {
                    id_pengembalian: id_pengembalian,
                    status_verifikasi: result.value
                },
                beforeSend: function() {
                    Swal.showLoading();
                },
                success: function (result) {
                    Swal.fire({
                        title: "Sukses",
                        text: "Verifikasi Berhasil!",
                        type: "success"
                    }).then(function(result) {
                        // EmailGudang(id_pengembalian);
                        if (result.value) {
                            $.ajax({
                                type: "POST",
                                url: baseurl + 'VerifikasiPengembalianBarang/Verifikasi/UpdateSeksiPenerimaBrg',
                                data: {
                                    id_pengembalian : id_pengembalian,
                                    subinv_penerima_brg : sub_ok,
                                    loc_penerima_brg : loc_ok
                                },
                                beforeSend: function() {
                                    Swal.showLoading();
                                },
                                success: function (response) {
                                    EmailGudang(id_pengembalian);
                                }
                            })
                        }
                    })
                }
            })
        }else {
            $.ajax({
                type: "POST",
                url: baseurl + 'VerifikasiPengembalianBarang/Verifikasi/UpdateStatusVerifQC',
                data: {
                    id_pengembalian: id_pengembalian,
                    status_verifikasi: result.value
                },
                beforeSend: function() {
                    Swal.showLoading();
                },
                success: function (result) {
                    Swal.fire({
                        title: "Sukses",
                        text: "Verifikasi Berhasil!",
                        type: "success"
                    }).then(function() {
                        Swal.fire({
                            title: 'Input Keterangan',
                            input: 'text',
                            inputPlaceholder: 'Keterangan Verifikasi',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showCancelButton: false,
                            confirmButtonText: 'OK'
                        }).then(function (result) {
                            if (result.value) {
                                $.ajax({
                                    type: "POST",
                                    url: baseurl + 'VerifikasiPengembalianBarang/Verifikasi/UpdateKetVerif',
                                    data: {
                                        id_pengembalian: id_pengembalian,
                                        ket_verif : result.value
                                    },
                                    beforeSend: function() {
                                        Swal.showLoading();
                                    },
                                    success: function (response) {
                                        Swal.fire({
                                            title: "Sukses",
                                            text: "Berhasil Menyimpan Keterangan Verifikasi!",
                                            type: "success"
                                        }).then(function(result) {
                                            Swal.fire({
                                                title: 'Pilih Seksi Penerima Barang',
                                                input: 'select',
                                                inputPlaceholder: 'Seksi Penerima Barang',
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                showCancelButton: false,
                                                confirmButtonText: 'OK',
                                                inputOptions: inputOptions,
                                                    inputValidator: function(result) {
                                                        return new Promise(function(resolve, reject) {
                                                            if (result) {
                                                                resolve();
                                                            } else {
                                                                reject('You need to select something!');
                                                            }
                                                        });
                                                    }
                                            }).then(function (result) {
                                                if (result.value == 'LAIN-LAIN') {
                                                    Swal.fire({
                                                        title: 'Input Penerima Barang',
                                                        input: 'text',
                                                        inputPlaceholder: 'Penerima Barang',
                                                        allowOutsideClick: false,
                                                        allowEscapeKey: false,
                                                        showCancelButton: false,
                                                        confirmButtonText: 'OK'
                                                    }).then(function (result) {
                                                        $.ajax({
                                                            type: "POST",
                                                            url: baseurl + 'VerifikasiPengembalianBarang/Verifikasi/UpdateSeksiPenerimaBrg',
                                                            data: {
                                                                id_pengembalian: id_pengembalian,
                                                                subinv_penerima_brg: sub_lain,
                                                                loc_penerima_brg : result.value
                                                            },
                                                            beforeSend: function() {
                                                                Swal.showLoading();
                                                            },
                                                            success: function (response) {
                                                                Swal.fire({
                                                                    title: "Sukses",
                                                                    text: "Berhasil Menyimpan Seksi Penerima Barang!",
                                                                    type: "success"
                                                                }).then(function(result) {
                                                                    EmailGudang(id_pengembalian);
                                                                })
                                                            }
                                                        })
                                                    })
                                                } else {
                                                    $.ajax({
                                                        type: "POST",
                                                        url: baseurl + 'VerifikasiPengembalianBarang/Verifikasi/UpdateSeksiPenerimaBrg',
                                                        data: {
                                                            id_pengembalian: id_pengembalian,
                                                            subinv_penerima_brg: sub_not_ok,
                                                            loc_penerima_brg : result.value
                                                        },
                                                        beforeSend: function() {
                                                            Swal.showLoading();
                                                        },
                                                        success: function (response) {
                                                            Swal.fire({
                                                                title: "Sukses",
                                                                text: "Berhasil Menyimpan Seksi Penerima Barang!",
                                                                type: "success"
                                                            }).then(function(result) {
                                                                EmailGudang(id_pengembalian);
                                                            })
                                                        }
                                                    })
                                                }
                                            })
                                        })
                                    }
                                })
                            }
                        })
                        // Swal.fire({
                        //     title: 'Pilih Seksi Penerima Barang',
                        //     input: 'select',
                        //     inputPlaceholder: 'Seksi Penerima Barang',
                        //     allowOutsideClick: false,
                        //     allowEscapeKey: false,
                        //     showCancelButton: false,
                        //     confirmButtonText: 'OK',
                        //     inputOptions: inputOptions,
                        //       inputValidator: function(result) {
                        //         return new Promise(function(resolve, reject) {
                        //             if (result) {
                        //                 resolve();
                        //             } else {
                        //                 reject('You need to select something!');
                        //             }
                        //         });
                        //       }
                        // }).then(function (result) {
                        //     if (result.value) {
                        //         $.ajax({
                        //             type: "POST",
                        //             url: baseurl + 'VerifikasiPengembalianBarang/Verifikasi/UpdateSeksiPenerimaBrg',
                        //             data: {
                        //                 id_pengembalian: id_pengembalian,
                        //                 subinv_penerima_brg: sub_not_ok,
                        //                 loc_penerima_brg : result.value
                        //             },
                        //             beforeSend: function() {
                        //                 Swal.showLoading();
                        //             },
                        //             success: function (response) {
                        //                 Swal.fire({
                        //                     title: "Sukses",
                        //                     text: "Berhasil Menyimpan Seksi Penerima Barang!",
                        //                     type: "success"
                        //                 }).then(function(result) {
                        //                     EmailGudang(id_pengembalian);
                        //                 })
                        //             }
                        //         })
                        //     }
                        // })
                    })
                }
            })
        }
    })
}

function EmailGudang(id_pengembalian){
    $.ajax({
        url: baseurl + 'VerifikasiPengembalianBarang/Verifikasi/EmailGudang/' + id_pengembalian,
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
            id_pengembalian: id_pengembalian,
        },
        beforeSend: function() {
            Swal.showLoading()
        },
        success: function(result) {
            if (result === "Success") {
            Swal.fire({
                type: 'success',
                title: 'Hasil Verifikasi Telah Dikirim ke Gudang'
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
}

$('.datePBGRekap').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true
})

function SearchRekapPBG(th) {
    var tgl_awal = $('#tgl_awal').val();
    var tgl_akhir = $('#tgl_akhir').val();
    // console.log(tgl_awal, tgl_akhir);

    var request = $.ajax({
        url: baseurl+'PengembalianBarangGudang/Rekap/SearchRekapPBG',
        data: {	
            tgl_awal : tgl_awal, 
            tgl_akhir: tgl_akhir
        },
        type: "POST",
        datatype: 'html'
    });

    $('#tblRekapPBG').html('');
    $('#tblRekapPBG').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );
    
    request.done(function(result){
        $('#tblRekapPBG').html('');
        $('#tblRekapPBG').html(result);
        
    })
}

function tambahemailPBG(){
    $('#mdlEmailPBG').modal();
}

const getEmailPic = _ => {
    const pic = $('#pic_email').last().val();
    // console.log(pic);
    $.ajax({
        url: baseurl + 'PengembalianBarangGudang/Email/getEmailPic',
        dataType: 'json',
        type: 'POST',
        async: true,
        data: {
            term: pic,
        },
        success: function(result) {
            // console.log(result);
            if (result == 0) {
                $(`#email`).val();
            }else {
                $(`#email`).val(result[0].internal_mail);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
        }
    })
}

function SaveEmail(){
    var pic = $('#pic_email').val();
    var email = $('#email').val();
    var ket = $('#ket').val();

    $.ajax ({
        url : baseurl + "PengembalianBarangGudang/Email/SaveEmail",
        data: { 
            pic : pic,
            email : email,
            ket : ket
        },
        type : "POST",
        dataType: "html",
        success: function (response) {
            location.reload();
        }
    });
}

function DeleteEmail(no) {
	var pic = $('#pic'+no).val();
    var email = $('#email'+no).val();
    var ket = $('#keterangan'+no).val();
	Swal.fire({
        title: 'Apakah Anda Yakin?',
        type: 'question',
        showCancelButton: true,
        allowOutsideClick: false
	}).then(result => {
			if (result.value) {  
				$.ajax({
					url: baseurl + 'PengembalianBarangGudang/Email/DeleteEmail',
					data: {
                        pic : pic, 
                        email : email, 
                        ket : ket
                    },
					type : "POST",
					dataType: "html",
					success: function(data) {
						Swal.fire({
							title: 'Data Berhasil di Hapus!',
							type: 'success',
							allowOutsideClick: false
						}).then(result => {
							if (result.value) {
								location.reload();
						}})  
					}
				})
	}})  
}

$('.ch_komp_pbg_seksi').on('click',function(){
    var a = 0;
    var jml = 0;
    var val = '';
    $('input[name="ch_komp_seksi[]"]').each(function(){``
        if ($(this).is(":checked") === true ) {
            a = 1;
            jml +=1;
            val += $(this).val();
        }
    });
    if (a == 0) {
        $('#jmlSlcPBGSeksi').text('');
        $('#btnCreateMoSeksi').attr("disabled","disabled");
    }else{
        $('#jmlSlcPBGSeksi').text('('+jml+')');
        $('input[name="slcKompPBGSeksi"]').val(val);
        $('#btnCreateMoSeksi').removeAttr("disabled");  
    }

});

$('.checkedAllPBGSeksi').on('click', function(){
    var check = 0;
    var a = 0;
    var jml = 0;
    var val = '';
    if ($(this).is(":checked")) {
        check = 1;
    }else{
        check = 0;
    }
    $('input[name="ch_komp_seksi[]"]').each(function(){
        if (check == 1) {
            $(this).prop('checked', true);
        }else{
            $(this).prop('checked', false);
        }
    });

$('input[name="ch_komp_seksi[]"]').each(function(){
        if ($(this).is(":checked") === true ) {
            a = 1;
            jml +=1;
            val += $(this).val();
        }
    });
    if (a == 0) {
        $('#btnCreateMoSeksi').attr("disabled","disabled");
        $('#jmlSlcPBGSeksi').text('');
    }else{
        $('#btnCreateMoSeksi').removeAttr("disabled");
        $('#jmlSlcPBGSeksi').text('('+jml+')');
        $('input[name="slcKompPBGSeksi"]').val(val);
    }
});

function btnDeletePBG(id_pengembalian) {
    let user = $('#user').val();
    // console.log(user, id_pengembalian);
    if (user != 'B0937' && user != 'B0636' && user != 'B0887') {
        Swal.fire({
            type: 'error',
            title: 'Anda tidak memiliki hak akses',
        })
    }else{
        Swal.fire({
            title: "Anda Yakin?",
            text: "Data Akan Di Hapus",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.value) {
                var request = $.ajax({
                    url: baseurl + "PengembalianBarangGudang/Input/deleteIputan",
                    data: {
                        id_pengembalian: id_pengembalian,
                    },
                    type: "POST",
                    datatype: "html",
                });
                request.done(function (result) {
                    Swal.fire({
                        type: "success",
                        title: "Berhasil Dihapus",
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(() => {
                        window.location.reload();
                    });
                });
            }
        })
    }
}

function btnUpdatePBG(id_pengembalian){
    // $('.area-edit-seksi').html('<h5>Sedang Menyiapkan Data...</h5>');
    let html = '';
    html = `
    <center style="margin-bottom: 3px;">
        <button type="button" style="font-weight:bold" onclick="saveupdate('${id_pengembalian}')" class="btn btn-success" name="button"><i class="fa fa-pencil"></i> Save</button>
    </center>`
    $.ajax({
        url: baseurl + 'VerifikasiPengembalianBarang/Verifikasi/getData',
        type: 'POST',
        async: true,
        dataType:'JSON',
        data: {
            id_pengembalian : id_pengembalian,
        },
        success: function(result) {
            // console.log(result);
            if (result[0].MO_SEKSI != 0) {
                Swal.fire({
                    type: `error`,
                    text: `Gudang sudah membuat MO untuk Seksi Penerima Barang, Anda tidak bisa mengedit data ini`,
                })
            } else if (result[0].STATUS_VERIFIKASI == 'Menunggu Hasil Verifikasi QC') {
                Swal.fire({
                    type: `error`,
                    text: `Mohon Input Hasil Verifikasi Terlebih Dahulu`,
                })
            } else {
                $('#editseksi').modal('show');
                $('#update_seksi').val(result[0].LOCATOR_PENERIMA_BARANG);
                $('.area-save-edit').html(html);
            }
            
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
}

function saveupdate(id_pengembalian){
    let seksi = $('#update_seksi').val();
    // console.log(id_pengembalian, seksi);
    $.ajax({
        url: baseurl + 'VerifikasiPengembalianBarang/Verifikasi/SaveUpdate',
        type: 'POST',
        async: true,
        dataType:'JSON',
        data: {
          id_pengembalian : id_pengembalian,
          seksi : seksi
        },
        beforeSend: function() {
          Swal.fire({
            onBeforeOpen: () => {
               Swal.showLoading()
             },
            text: `Sedang memproses data...`
          })
        },
        success: function(result) {
            // console.log(result);
            if (result) {
                Swal.fire({
                    type: `success`,
                    text: `Data telah berhasil diperbarui.`,
                }).then(_=>{
                    $('#editseksi').modal('toggle');
                    window.location.reload();
                })
            }else {
                Swal.fire({
                    type: `danger`,
                    text: `Terjadi kesalahan saat memperbarui data.`,
                })
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
    })
}