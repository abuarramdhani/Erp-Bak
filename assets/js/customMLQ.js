$('#trx_type').on('change', function (){
    // let cek = $('#trx_type').val()
    // console.log(cek);
    $.ajax({
        url: baseurl + 'MonitoringLppbQC/MonLppb/getMon',
        type: 'POST',
        data: {
            params: $(this).val()
        },
        async: true,
        beforeSend: function() {
        $('.area-mon').html(`<div id="loadingArea">
                                <center>
                                    <img style="width:20%;margin-bottom:13px" src="${baseurl}assets/img/gif/loadingtwo.gif">
                                </center>
                            </div>`)
        },
        success: function(result) {
            // console.log(result);
            $('.area-mon').html(result)
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.error();
          }
    })
})

$(document).ready(function() {
    $('.slc_no_induk').select2({
        minimumInputLength: 2,
        placeholder: 'No Induk',
        ajax: {
            url: baseurl + 'MonitoringLppbQC/KirimLppb/getNoInduk',
            dataType: 'JSON',
            type: 'POST',
            data: function(params) {
                return {
                    term: params.term
                };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return {
                            id: obj.employee_code,
                            text: `${obj.employee_code}`
                        }
                    })
                }
            }
        }
    });

    $(".slc_no_lppb").select2({
		allowClear: false,
		placeholder: "No Lppb",
        minimumInputLength: 3,
		ajax: {
			url: baseurl + "MonitoringLppbQC/KirimLppb/getNoLppb",
			dataType: 'JSON',
			type: 'POST',
			data: function (params) {
				return {
                    term: params.term
                };
			},
			processResults: function (data) {
				console.log(data);
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.NO_LPPB,
							text: obj.NO_LPPB
						};
					})
				};
			}
		}
    });

    let cek_terima = $('#cek-terima-lppb').val();
    if (cek_terima == 'ok') {
        terima_ajx();
    }

})

const getNama = _ => {
    const no_induk = $('#no_induk').last().val();
    $.ajax({
        url: baseurl + 'MonitoringLppbQC/KirimLppb/getNama',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
            params: no_induk,
        },
        success: function(result) {
            $(`#nama`).val(result.nama);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
        }
    })
}

$('.dateMLQ').datepicker({
    format: 'DD/d MM yyyy',
    autoclose: true,
    todayHighlight: true
})

$('.timeMLQ').datetimepicker({
    datepicker: false,
    step: 15,
    format: 'H:i'
})

const autofill_mlq = (n) => {
    const code = $(`#no_lppb_${n}`).val();
    if (code != '') {
    $.ajax({
		url: baseurl + 'MonitoringLppbQC/KirimLppb/getDetail',
		dataType: 'JSON',
		type: 'POST',
		data: {
			params: code //$(this).val()
        },
        async: true,
        beforeSend: function() {
            Swal.showLoading()
        },
		success: function (result) {
            Swal.close()
            console.log(result);
            // var html = '';
            if(result.length == 1){
                $(`#nama_vendor_${n}`).val(result[0].VENDOR_NAME);
                $(`#kode_komponen_${n}`).val(result[0].ITEM);
                $(`#nama_komponen_${n}`).val(result[0].ITEM_DESCRIPTION);
                $(`#jumlah_${n}`).val(result[0].JUMLAH);
                $(`#ok_${n}`).val(result[0].OK);
                $(`#not_ok_${n}`).val(result[0].NOT_OK);
                $(`#keterangan_${n}`).val(result[0].KETERANGAN);
                $(`#sh_${n}`).val(result[0].SHIPMENT_HEADER_ID);
                $(`#sl_${n}`).val(result[0].SHIPMENT_LINE_ID);
            }else{
                result.forEach((v,i) => {
                    // console.log(i, 'cekcekcke');
                    if(i != 0){
                        let row = $('.cektabel tbody tr').length;
                        let nextrow = row + 1;
                        console.log(nextrow);
                        let html_ =
                        '<tr>'+
                        '<td class="text-center"><input type="text" class="form-control no" name="no[]" id="no_' + n + '" readonly value="' + nextrow + '"></td>'+
                        '<td class="text-center"><input type="text" class="form-control" id="no_lppb_' + n + '" name="no_lppb[]" readonly value="' + v.NO_LPPB + '"></td>'+
                        '<td class="text-center"><input type="text" class="form-control" id="nama_vendor_' + n + '" name="nama_vendor[]" readonly value="' + v.VENDOR_NAME + '"></td>'+
                        '<td class="text-center"><input type="text" class="form-control" id="kode_komponen_' + n + '" name="kode_komponen[]" readonly value="' + v.ITEM + '"></td>'+
                        '<td class="text-center"><input type="text" class="form-control" id="nama_komponen_' + n + '" name="nama_komponen[]" readonly value="' + v.ITEM_DESCRIPTION + '"></td>'+
                        '<td class="text-center"><input type="text" class="form-control" id="jumlah_' + n + '" name="jumlah[]" readonly value="' + v.JUMLAH + '"></td>'+
                        '<td class="text-center"><input type="text" class="form-control" id="ok_' + n + '" name="ok[]" readonly value="' + v.OK + '"></td>'+
                        '<td class="text-center"><input type="text" class="form-control" id="not_ok_' + n + '" name="not_ok[]" readonly value="' + v.NOT_OK + '"></td>'+
                        '<td class="text-center"><input type="text" class="form-control" id="keterangan_' + n + '" name="keterangan[]" readonly value="' + v.KETERANGAN + '"></td>'+
                        '<td class="text-center" hidden><input type="text" class="form-control" id="sh_' + n + '" name="sh[]" readonly value="' + v.SHIPMENT_HEADER_ID + '"></td>'+
                        '<td class="text-center" hidden><input type="text" class="form-control" id="sl_' + n + '" name="sl[]" readonly value="' + v.SHIPMENT_LINE_ID + '"></td>'+
                        '</tr>';
                        console.log(html_);
                        $("#body-lppb").append(html_);
                    }else{
                        $(`#nama_vendor_${n}`).val(v.VENDOR_NAME);
                        $(`#kode_komponen_${n}`).val(v.ITEM);
                        $(`#nama_komponen_${n}`).val(v.ITEM_DESCRIPTION);
                        $(`#jumlah_${n}`).val(v.JUMLAH);
                        $(`#ok_${n}`).val(v.OK);
                        $(`#not_ok_${n}`).val(v.NOT_OK);
                        $(`#keterangan_${n}`).val(v.KETERANGAN);
                        $(`#sh_${n}`).val(v.SHIPMENT_HEADER_ID);
                        $(`#sl_${n}`).val(v.SHIPMENT_LINE_ID);
                    }
                })
            }
		},
		error: function (error, status) {
			console.log(error);
		}
    });
}}

const addRowElement_mlq = () => {
    let cek_no_lppb = $('.slc_no_lppb').last().val()
    // console.log(cek_no_lppb);
    if (!cek_no_lppb) {
        Swal.fire({
            type: 'warning',
            title: 'Peringatan',
            text: 'Data LPPB Harap Dilengkapi Terlebih Dahulu',
            allowOutsideClick: false
        })
    }else {
        let n = $('.cektabel tbody tr').length;
        let a = n + 1;
        console.log(a);
        $('#body-lppb').append(`<tr class="rowbaru" id ="tr${n}">
        <td class="text-center"><input type="text" class="form-control" name="no[]" value="${a}" id="no_${a}" readonly></td>
        <td class="text-center">
            <select class="form-control slc_no_lppb" id="no_lppb_${a}" name="no_lppb[]" onchange="autofill_mlq(${a})">
                <option selected="selected"></option>
            </select>
        </td>
        <td class="text-center"><input type="text" class="form-control" id="nama_vendor_${a}" name="nama_vendor[]" readonly></td>
        <td class="text-center"><input type="text" class="form-control" id="kode_komponen_${a}" name="kode_komponen[]" readonly></td>
        <td class="text-center"><input type="text" class="form-control" id="nama_komponen_${a}" name="nama_komponen[]" readonly></td>
        <td class="text-center"><input type="text" class="form-control" id="jumlah_${a}" name="jumlah[]" readonly></td>
        <td class="text-center"><input type="text" class="form-control" id="ok_${a}" name="ok[]" readonly></td>
        <td class="text-center"><input type="text" class="form-control" id="not_ok_${a}" name="not_ok[]" readonly></td>
        <td class="text-center"><input type="text" class="form-control" id="keterangan_${a}" name="keterangan[]" readonly></td>
        <td class="text-center" hidden><input type="text" class="form-control" id="sh_${a}" name="sh[]" readonly></td>
        <td class="text-center" hidden><input type="text" class="form-control" id="sl_${a}" name="sl[]" readonly></td>
        </tr>`);

        $(".slc_no_lppb").select2({
            allowClear: false,
            placeholder: "No Lppb",
            minimumInputLength: 3,
            ajax: {
                url: baseurl + "MonitoringLppbQC/KirimLppb/getNoLppb",
                dataType: 'JSON',
                type: 'POST',
                data: function (params) {
                    return {
                        term: params.term
                    };
                },
                processResults: function (data) {
                    console.log(data);
                    return {
                        results: $.map(data, function (obj) {
                            return {
                                id: obj.NO_LPPB,
                                text: obj.NO_LPPB
                            };
                        })
                    };
                }
            }
        });

    }
}

const kirimlppb = () => {
    let no_induk = $('#no_induk').val(),
        nama = $('#nama').val(),
        tanggal_kirim = $('#hari_tgl').val(),
        jam_kirim = $('#jam').val(),
        no_lppb_1 = $('#no_lppb_1').val()

    if (no_induk !== '' && nama !== '' && tanggal_kirim !== '' && jam_kirim !== '' && no_lppb_1 !== '') {
        Swal.fire({
            onBeforeOpen: () => {
               Swal.showLoading()
            },
            text: 'Sedang Memproses Data...',
            timer: 500,
        }).then(_=>{
            Swal.fire({
                type: `success`,
                text: `Data telah berhasil dikirim !`,
                // allowOutsideClick: false
            })
        })
    }
}

function terima_ajx() {
    $.ajax({
      url: baseurl + 'MonitoringLppbQC/TerimaLppb/getTerima',
      type: 'POST',
      async: true,
      beforeSend: function() {
        $('.area-terima').html(`<div id="loadingArea">
                                    <center>
                                        <img style="width: 3%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif">
                                    </center>
                                </div>`)
      },
      success: function(result) {
        $('.area-terima').html(result)
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
}

function btn_sdhterima(id_kirim, line_num){
    let status = 2,
        user = $('#user').val();
    // console.log(status, user)
    // if (user != 'K2077' && user != 'K1070' && user != 'T0008') {
    if (user != 'K2077' && user != 'K1070') {
        Swal.fire({
            type: 'error',
            title: 'Anda tidak memiliki hak akses',
        })
    }else{
        $.ajax({
            url: baseurl + 'MonitoringLppbQC/TerimaLppb/sdhTerima',
            type: 'POST',
            dataType: 'JSON',
            data: {
                id_kirim: id_kirim,
                line_num: line_num,
                status: status,
            },
            beforeSend: function() {
                Swal.showLoading()
            },
            success: function(result) {
                Swal.close()
                console.log(result);
                if (result === 1) {
                    window.location.reload();
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
}