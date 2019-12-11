$(document).ready(function(){ //js untuk import polas shift
    $('.tabel_polashift').DataTable({
        // "scrollY"			: true,
        "scrollX"			: true,
        "scrollCollapse"	: true,
        "fixedColumns":   {
        "leftColumns": 3,
        },
    });
    $('#ImportPola-DaftarSeksi').select2({
        allowClear: false,
        placeholder: "Pilih Seksi",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + 'PolaShiftSeksi/ImportPolaShift/daftar_seksi',
            dataType: 'json',
            delay: 500,
            type: "GET",
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.kodesie, text: obj.kodesie + ' - ' + obj.daftar_tseksi };
                    })
                };
            }
        }
    });

    $("input.importpola_periode").monthpicker({
        changeYear:true,
        dateFormat: 'yy-mm', 
    });

    $('.btn_see_shift').click(function(){
        var pr = $('#yangPentingtdkKosong').val();
        if (pr == '') {
            $('#yangPentingtdkKosong').focus();
        }else{
            $('#surat-loading').attr('hidden', false);
            $.ajax({
                url: baseurl + 'PolaShiftSeksi/Approval/cari_shift',
                type: "post",
                data: {pr: pr},
                success: function (response) {
                    $('#ips_view_shift').html(response);
                    pss_init();
                    $('#surat-loading').attr('hidden', true);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                 console.log(textStatus, errorThrown);
             }
         });
        }
    });

    $('.importpola_periode').change(function(){
        var vall = $(this).val();
        var sp = vall.split('-');
        var y = Number(sp[0]);
        var m = Number(sp[1]);
        var d = new Date();
            // alert(y+m);
            // alert(Number(d.getFullYear())+Number(d.getMonth()));
            if (y < Number(d.getFullYear())) {
                alert('Periode tidak boleh lebih kecil dari bulan sekarang');
                $(this).val('');
            }else if(y > Number(d.getFullYear())){
                //oke
            }else if (m < Number(d.getMonth())+1) {
                alert('Periode tidak boleh lebih kecil dari bulan sekarang');
                $(this).val('');
            }

    });
    pss_init();
    pss_init_approve();

    $('.ips_get_atasan').select2({
        allowClear: false,
        placeholder: "Pilih Atasan",
        minimumInputLength: -1,
        ajax: {
            url: baseurl + 'PolaShiftSeksi/ImportPolaShift/daftar_atasan',
            dataType: 'json',
            delay: 500,
            type: "GET",
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.noind, text: obj.noind + ' - ' + obj.nama };
                    })
                };
            }
        }
    });

    $('.ips_get_atasan').change(function(){
         $('.btn_ips_save').attr('disabled', false);
    });

    $('.tbl_tlis').DataTable();
});

function ips_swetAlert(){
    Swal.fire({
        title: 'Data Berhasil Di Import',
        allowOutsideClick: false,
        allowEscapeKey: false,
        type: 'success',
        focusCancel: true
    }).then(function(result) {
        if (result.value) {
            window.location.replace(baseurl+"PolaShiftSeksi/ImportPolaShift");
        }
    });
}

function pss_init()
{
    $('.tbl_ips_pr_shift').DataTable();
}

function pss_init_approve()
{//di gunakan untuk mengetahui kolom mana yang akan di insert, update, delete
    if ($('.ini_approve').length) {
        if (arrayJs !== null) {
            var arry = [];
            var d = new Date();
            var per = periode.split('-');
            var m = per[1];
            var y = per[0];
            var nowPer = d.getFullYear()+'-'+(Number(d.getMonth())+1);
            for (var i of arrayJs) {
                var noindErp = $('.Erp'+i);
                var noindPers = $('.Pers'+i);
                if (noindPers.length) {// update insert delete
                    var x = 0;
                    noindErp.each(function(){
                        var thisText = $(this).text();
                        var tgl = $(this).attr('data-tgl');
                        if (periode == nowPer) {
                            if (tgl <= d.getDate()) {
                                x++;
                                return true;
                            }
                        }
                        var str = i+'|'+thisText+'|'+tgl;
                        var txtErp = thisText;
                        var txtPers = $('.Pers'+i).eq(x).text();
                        if (txtPers !== txtErp) {
                            if (txtPers.length < 1 && txtErp.length > 1) {// pers kosong dan erp ada
                                arry.push(str+'|insert');
                                $(this).css('background-color', '#8bc34a');
                                $('.Pers'+i).eq(x).css('background-color', '#8bc34a');
                            }else if(txtPers.length > 1 && txtErp.length > 1){ // pers ada dan erp ada{ 
                                arry.push(str+'|update');
                                $(this).css('background-color', '#ffeb3b');
                                $('.Pers'+i).eq(x).css('background-color', '#ffeb3b');
                            }else{
                                arry.push(str+'|delete');
                                $(this).css('background-color', '#f44336');
                                $('.Pers'+i).eq(x).css('background-color', '#f44336');
                            }
                        }
                        x++;
                    });
                }else{ // jelas insert
                    noindErp.each(function(){
                        var thisText = $(this).text();
                        var tgl = $(this).attr('data-tgl');
                        if (periode == nowPer) {
                            if (tgl <= d.getDate()) {
                                return true;
                            }
                        }
                        var str = i+'|'+thisText+'|'+tgl+'|insert';
                        if (thisText.length > 1) {
                            arry.push(str);
                            $(this).css('background-color', '#8bc34a');
                        }
                    });
                }
            }
            console.log(arry);
            $('#btn_ips_update').click(function(){
                if (arry.length < 1) {
                    alert('Ke dua Data Sama');
                }else{
                    Swal.fire({
                        title: 'Apa anda yakin ingin mengupdate shift?',
                        type: 'question',
                        showCancelButton: true,
                        focusConfirm: true
                    }).then(function(result) {
                        if (result.value) {
                            update_shift(arry, tgl_imp, kode_seksi, periode, '', 'approve');
                            //tgl_imp ada di view V_detail_shift
                        }
                    });               
                }
            });
            $('#btn_ips_rej').click(function(){
                if (arry.length < 1) {
                    alert('Ke dua Data Sama');
                }else{
                    Swal.fire({
                        input: 'textarea',
                        title: 'Masukan alasan mengapa anda me-Reject Shift ini!',
                        showCancelButton: true,
                        focusConfirm: true
                    }).then(function(result) {
                        if (result.value) {
                            // alert(result.value)
                            update_shift(arry, tgl_imp, kode_seksi, periode, result.value, 'reject');
                            //tgl_imp ada di view V_detail_shift
                        }
                    });               
                }
            });
        }
    }

    $('.tabel_polashiftInit').DataTable({
        // "scrollY"            : true,
        "scrollX"           : true,
        "scrollCollapse"    : true,
        "fixedColumns":   {
            "leftColumns": 3,
        },
    });
}

function update_shift(arry,tgl_imp, ks, pr, alasan, status)
{
    $('#surat-loading').attr('hidden', false);
    $.ajax({
        url: baseurl + 'PolaShiftSeksi/Approval/update_shift',
        type: "post",
        data: {arr: arry, tgl_imp: tgl_imp, kode_seksi: ks, periode: pr, alasan: alasan, stat:status},
        success: function (response) {
            $('#surat-loading').attr('hidden', true);
            show_success(status);
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
       }
   });
}

function show_success(stat)
{
    if (stat == 'reject') {
        Swal.fire({
            title: 'Data Berhasil Di Reject',
            allowOutsideClick: false,
            allowEscapeKey: false,
            type: 'success',
            focusCancel: true
        }).then(function(result) {
            window.location.replace(baseurl+"PolaShiftSeksi/Approval/ApprovalShift");
        });
    }else{
        Swal.fire({
            title: 'Data Berhasil Di Update',
            allowOutsideClick: false,
            allowEscapeKey: false,
            type: 'success',
            focusCancel: true
        }).then(function(result) {
            window.location.replace(baseurl+"PolaShiftSeksi/Approval/ApprovalShift");
        });
    }
}

$(document).ready(function(){// js untuk tukar shift
    $('.tabel_tukarShift').DataTable({

    });

    var date = new Date();
    date.setDate(date.getDate() + 1);
    $('.ts_datePick').datepicker({
        startDate: date,
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    // $('.pss_noind').select2({
    //     placeholder: 'Pilih Noind',
    //     minimumInputLength: 2,
    //     allowClear: false,
    //     ajax: {
    //         url: baseurl + 'PolaShiftSeksi/TukarShift/getNoind',
    //         dataType: 'json',
    //         delay: 500,
    //         type: "POST",
    //         processResults: function(data) {
    //             return {
    //                 results: $.map(data, function(obj) {
    //                     return { id: obj.noind, text: obj.noind };//+ ' - ' + obj.nama
    //                 })
    //             };
    //         }
    //     }
    // });

    // $('.pss_noind').change(function(){
    //     var noind = $(this).val();
    //     var tgl = $('.ts_datePick').val();
    //     $.ajax({
    //         url: baseurl + 'PolaShiftSeksi/TukarShift/getDetailNoind',
    //         type: "post",
    //         dataType: 'json',
    //         data: {noind: noind, tanggal: tgl},
    //         success: function (response) {
    //             console.log(response);
    //         },
    //         error: function(jqXHR, textStatus, errorThrown) {
    //             console.log(textStatus, errorThrown);
    //         }
    //     });
    // });

    $('#btn_next_tukar').click(function(){
        var tgl_tukar = $('.ts_datePick').val();
        var tukar = $('input[name="tukarpekerja"]:checked').val();
        var inisiatif = $('input[name="inisiatif"]:checked').val();

        if (tgl_tukar.length < 1 || !tukar || !inisiatif) {
            Swal.fire({
                title: 'Data Kurang Lengkap',
                text: 'Harap isi data-data di atas!',
                type: 'error',
            });
        }else{
            $('#surat-loading').attr('hidden', false);
            $.ajax({
                url: baseurl + 'PolaShiftSeksi/TukarShift/getFormPekerja',
                type: "post",
                data: {tukar: tukar},
                success: function (response) {
                    $('.pss_formPekerja').html(response);
                    $('#surat-loading').attr('hidden', true);
                    init_select_tukar();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
    });
});

function init_select_tukar()
{
    $('.pss_noind').select2({
        placeholder: 'Pilih Noind',
        minimumInputLength: 2,
        allowClear: false,
        ajax: {
            url: baseurl + 'PolaShiftSeksi/TukarShift/getNoind',
            dataType: 'json',
            delay: 500,
            type: "POST",
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.noind, text: obj.noind+ ' - ' + obj.nama };//
                    })
                };
            }
        }
    });

    $('.pss_noind_to_all').select2({
        placeholder: 'Pilih Noind',
        minimumInputLength: 2,
        allowClear: false,
        ajax: {
            url: baseurl + 'PolaShiftSeksi/TukarShift/getNoind',
            dataType: 'json',
            delay: 500,
            type: "POST",
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.noind, text: obj.noind+ ' - ' + obj.nama };//
                    })
                };
            }
        }
    });

    $('.pss_noind_to_all').change(function(){
        $('#surat-loading').attr('hidden', false);
        var noind = $(this).val();
        var tgl = $('.ts_datePick').val();
        var ini = $(this);
        $.ajax({
            url: baseurl + 'PolaShiftSeksi/TukarShift/getDetailNoind',
            type: "post",
            dataType: 'json',
            data: {noind: noind, tanggal: tgl},
            success: function (response) {
                if (response.length < 1) {
                    alert_no_shift(ini);
                    $('#surat-loading').attr('hidden', true);
                }else{
                    $('.pss_noind_input').val(response[0]['noind']);
                    $('.pss_nama').val(response[0]['nama']);
                    $('.pss_tgl').val(response[0]['tanggal']);
                    $('.pss_shift').val(response[0]['shift']);
                    $('.kd_sift').val(response[0]['kd_shift']);
                    $('.pss_list_shift').attr('disabled', false);
                     $('.pss_selc2').attr('disabled', false);
                    $('#surat-loading').attr('hidden', true);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    $('.pss_noind').change(function(){
        $('#surat-loading').attr('hidden', false);
        var noind = $(this).val();
        var tgl = $('.ts_datePick').val();
        var ini = $(this);
        $.ajax({
            url: baseurl + 'PolaShiftSeksi/TukarShift/getDetailNoind',
            type: "post",
            dataType: 'json',
            data: {noind: noind, tanggal: tgl},
            success: function (response) {
                if (response.length < 1) {
                    alert_no_shift(ini);
                    $('#surat-loading').attr('hidden', true);
                }else{
                    ini.closest('div.pss_data_pkj').find('.pss_nama').val(response[0]['nama']);
                    ini.closest('div.pss_data_pkj').find('.pss_tgl').val(response[0]['tanggal']);
                    ini.closest('div.pss_data_pkj').find('.pss_shift').val(response[0]['shift']);
                    ini.closest('div.pss_data_pkj').find('.kd_sift').val(response[0]['kd_shift']);
                    $('.pss_selc2').attr('disabled', false);
                    
                    $('#surat-loading').attr('hidden', true);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    $('#pss_core_noind').change(function(){
        var noind = $(this).val();
        $('.pss_selc2').each(function() { //added a each loop here
            $(this).select2('destroy').val("").select2();
        });
        $('.pss_selc2').select2({
            placeholder: 'Pilih Atasan',
            minimumInputLength: -1,
            allowClear: false
        });
        // isi_select(noind);
    });

    $('.pss_list_shift').select2({
        placeholder: 'Pilih Shift',
        minimumInputLength: -1,
        allowClear: false,
        ajax: {
            url: baseurl + 'PolaShiftSeksi/TukarShift/getListShift',
            dataType: 'json',
            delay: 500,
            type: "POST",
            data: function(params) {
                return { term: params.term, kd: $('.kd_sift').val() };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.kd_shift, text: obj.shiftnya };
                    })
                };
            }
        }
    });

    $('.pss_selc2').select2({
        placeholder: 'Pilih Atasan',
        minimumInputLength: -1,
        allowClear: false
    });

    $('.pss_dis_cht').off('change');
    $('.pss_dis_cht').change(function(){
        $('#btn_next_tukar').click();
    });
    $('.pss_dis_ch').off('ifChanged');
    $('.pss_dis_ch').on('ifChanged', function(e){
        e.preventDefault()
        setTimeout(function (){
            $('#btn_next_tukar').click();
        }, 100);
    });
}

function isi_select(noind)
{
    $.ajax({
            url: baseurl + 'PolaShiftSeksi/TukarShift/iniSelect',
            type: "post",
            data: {noind: noind},
            success: function (response) {
                $('.pss_selc2').html(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
    });
}

$(document).ready(function(){
    $('.pss_app_now').click(function(){
        var level = $(this).attr('level');
        var isduo = $(this).attr('isduo');
        var id = $('#pss_tukar').val();
        Swal.fire({
            title: 'Apa anda yakin ?',
            text: 'Apa anda yakin ingin melakukan Approve?',
            showCancelButton: true,
            type: 'question',
        }).then(function(result) {
            if (result.value) {
                $('#surat-loading').attr('hidden', false);
                $.ajax({
                    url: baseurl + 'PolaShiftSeksi/Approval/ApproveTS_button',
                    type: "post",
                    data: {level: level, id: id, duo: isduo},
                    success: function (response) {
                        window.history.back();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
        });
    });
    $('.pss_rej_now').click(function(){
        var id = $('#pss_tukar').val();
        Swal.fire({
            title: 'Apa anda yakin ?',
            text: 'Apa anda yakin ingin melakukan Reject? \n Masukan alasan!',
            input: 'textarea',
            showCancelButton: true,
            type: 'question',
        }).then(function(result) {
            if (result.value) {
                $('#surat-loading').attr('hidden', false);
                $.ajax({
                    url: baseurl + 'PolaShiftSeksi/Approval/ApproveTS_button_reject',
                    type: "post",
                    data: {id: id, alasan: result.value},
                    success: function (response) {
                        window.history.back();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
        });
    });
});

function alert_no_shift(ini)
{
    Swal.fire({
            title: 'Data Shift Kosong',
            text: 'Pekerja tidak memiliki shift pada tanggal tersebut!',
            type: 'error',
    });
    ini.each(function() { //added a each loop here
        $(this).select2('destroy').val("").select2();
    });
    // di deklarasikan lagi karena methode di atas destroy selecet2 nya
    ini.select2({
        placeholder: 'Pilih Noind',
        minimumInputLength: 2,
        allowClear: false,
        ajax: {
            url: baseurl + 'PolaShiftSeksi/TukarShift/getNoind',
            dataType: 'json',
            delay: 500,
            type: "POST",
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.noind, text: obj.noind+ ' - ' + obj.nama };//
                    })
                };
            }
        }
    });
}