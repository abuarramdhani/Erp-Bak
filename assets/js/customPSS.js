$(document).ready(function(){ //js untuk import polas shift
    $('.tabel_polashift').DataTable({
        // "scrollY"			: true,
        "scrollX"			: true,
        "scrollCollapse"	: true,
        "fixedColumns":   {
            "leftColumns": 3,
        },
    });

    $('.pss_getAllnoind').select2({
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
    $('.pss_getAllnoindName').select2({
        placeholder: 'Pilih Noind',
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: baseurl + 'PolaShiftSeksi/TukarShift/getNoind',
            dataType: 'json',
            delay: 500,
            type: "POST",
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.noind+ ' - ' + obj.nama, text: obj.noind+ ' - ' + obj.nama };//
                    })
                };
            }
        }
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
        minimumResultsForSearch: -1,
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
        $('#btn_ips_save').attr('disabled', false);
       $('.btn_ips_save').attr('disabled', false);
   });

    $('.tbl_tlis').DataTable();

    $('#ipscekdate').change(function(){
        $('#pssbtnhpsbrs').show();
        if ($.fn.DataTable.isDataTable( '#psstblsh' )) $('#psstblsh').DataTable().destroy();

        var v = $(this).val();
        $.ajax({
            url: baseurl + 'PolaShiftSeksi/createPolaShift/getMingguList',
            type: "post",
            data: {pr: v},
            success: function (response) {
                $('#ips_weekshift').html(response);
                init_sh();
            },
            error: function(jqXHR, textStatus, errorThrown) {
             console.log(textStatus, errorThrown);
         }
     });

        var pr = v.split(' - ');
        var t = new Date(Number(pr[1]), Number(pr[0]), 0);
        var tml = '<tr><th>NO.IND</th><th style="width: 100px;">NAMA</th>';
        for(let i = 1; i <= t.getDate(); i++){
            tml += '<th>'+i+'</th>';
        }
        tml += '</tr>';
        $('#psstblsh thead').html(tml);
        if ( ! $.fn.DataTable.isDataTable( '#psstblsh' ) ) {
            var pss_tbl = $('#psstblsh').DataTable( {
                dom: 'Brti',
                "scrollX": true,
                buttons: [
                {
                    extend: 'excelHtml5',
                    title: ''
                }
                ]
            });

            $('#psstblsh tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                }
                else {
                    pss_tbl.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });

            $( pss_tbl.table().header() ).addClass( 'highlight' );
        }
    });

    $( table.table().header() )
    .addClass( 'highlight' );

    $('.pss_coba_document').on('click', '#pssbtnhpsbrs', function(){
     $('#psstblsh').DataTable().row('.selected').remove().draw( false );
 });

    $('.pss_coba_document').on('click','#pssbtnsmpcr',function(){
        simpan_to_table();
    });
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
            window.location.replace(baseurl+"PolaShiftSeksi/createPolaShift");
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
            console.log(periode, nowPer);
            for (var i of arrayJs) {
                var noindErp = $('.Erp'+i);
                var noindPers = $('.Pers'+i);
                if (noindPers.length) {// update insert delete
                    var x = 0;
                    noindErp.each(function(){
                        var thisText = $(this).text();
                        var tgl = $(this).attr('data-tgl');
                        // if (periode == nowPer) { di komen karena lupa mbandingin periode buat afa?
                            if (tgl <= d.getDate()) {
                                x++;
                                return true;
                            }
                        // }
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

    initTglPick(); //untuk menginisialisasi tanggalnya
    
    // $('.ts_datePick').datepicker({
    //     startDate: date,
    //     format: 'yyyy-mm-dd',
    //     autoclose: true
    // });

    $('#btn_next_tukar').click(function(){
        var tgl_tukar = $('.ts_datePick').val();
        var tukar = $('input[name="tukarpekerja"]:checked').val();
        var periode = $('input[name="tgl_tukar"]').val();
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
                data: {tukar: tukar, pr: periode},
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
        minimumInputLength: 3,
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
        var noind = $(this).val();
        if (noind.length < 2) { return false }//cegah loop
            $('#surat-loading').attr('hidden', false);
        var tgl = $('.ts_datePick').val();
        var ini = $(this);
        $.ajax({
            url: baseurl + 'PolaShiftSeksi/TukarShift/getDetailNoind',
            type: "post",
            dataType: 'json',
            data: {noind: noind, tanggal: tgl},
            success: function (response) {
                if(typeof response === 'string')
                    alertNoShift(response, ini)
                else
                    setPerKolomAll(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    $('.pss_noind').change(function(){
        var noind = $(this).val();
        if (noind.length < 2) { return false }//cegah loop
            $('#surat-loading').attr('hidden', false);
        //cek apa sama
        cekNoindnya();
        var tgl = $('.ts_datePick').val();
        var ini = $(this);
        $.ajax({
            url: baseurl + 'PolaShiftSeksi/TukarShift/getDetailNoind',
            type: "post",
            dataType: 'json',
            data: {noind: noind, tanggal: tgl},
            success: function (response) {
                if(typeof response === 'string')
                    alertNoShift(response, ini)
                else
                    setPerKolom(response, ini);
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
                return { term: params.term, kd: getKD($(this)) };
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
                        window.location.replace(baseurl+"PolaShiftSeksi/Approval/ApprovalTukarShift");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('b');
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
                        window.location.replace(baseurl+"PolaShiftSeksi/Approval/ApprovalTukarShift");
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

function initTglPick(tambahan = 2)
{
    var dates = new Date();
    dates.setDate(dates.getDate() + 1);
    $('.ts_datePick').daterangepicker({
        "startDate": dates,
        "endDate": dates,
        minDate: dates,
        maxSpan: {
            days: tambahan
        },
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
}

$(document).on('ifChecked', '.pss_set_range', function(){
    var a = $(this).val();
    if (a == 'perusahaan')
        initTglPick(5)
    else
        initTglPick(2)
});

function setPerKolomAll(response)
{
    console.log(response);
    if (response.length < 1) {
        alert_no_shift(ini);
        $('#surat-loading').attr('hidden', true);
    }else{
        $('.pss_noind_input').val(response[0][0]['noind']);
        $('.pss_nama').val(response[0][0]['nama']);
        $('.pss_list_shift').attr('disabled', false);
        $('.pss_selc2').attr('disabled', false);
        $('#surat-loading').attr('hidden', true);
    }
    var mx = $('.pss_tgl').length/2;
    for(let i = 0; i < mx; i++){
        $('.pss_tgl').eq(i).val(response[i][0]['tanggal']);
        $('.pss_shift').eq(i).val(response[i][0]['shift']);
        $('.kd_sift').eq(i).val(response[i][0]['kd_shift']);
    }
    for(let i = mx; i < (mx*2); i++){
        $('.pss_tgl').eq(i).val(response[i-mx][0]['tanggal']);
    }
}

function setPerKolom(response, ini)
{
    if (response.length < 1) {
        alert_no_shift(ini);
        $('#surat-loading').attr('hidden', true);
    }else{
        ini.closest('div.pss_data_pkj').find('.pss_nama').val(response[0][0]['nama']);
        $('.pss_selc2').attr('disabled', false);
        $('#surat-loading').attr('hidden', true);
    }
    var mx = $('.pss_tgl').length/2;
    for(let i = 0; i < mx; i++){
        ini.closest('div.pss_data_pkj').find('.pss_tgl').eq(i).val(response[i][0]['tanggal']);
        ini.closest('div.pss_data_pkj').find('.pss_shift').eq(i).val(response[i][0]['shift']);
        ini.closest('div.pss_data_pkj').find('.kd_sift').eq(i).val(response[i][0]['kd_shift']);
    }
}

function cekNoindnya()
{
    var th = $('.pss_noind');
    if (th.eq(0).val() == th.eq(1).val()){
        $('#pss_submit_tukar').attr('disabled', true);
        alert('Pekerja Tidak boleh Sama');
    }else{
        $('#pss_submit_tukar').attr('disabled', false);
    }
}

function getKD(ini)
{
    var i = ini.index('.pss_list_shift');
    console.log(i);
    return $('.kd_sift').eq(i).val();
}

function alertNoShift(res, ini)
{
    $('#surat-loading').attr('hidden', true);
    Swal.fire({
        title: 'Error !!',
        text: res,
        type: 'error',
    });
    ini.val(null).trigger("change");
}

function init_sh()
{
    $('.pss_gs').select2({
        placeholder: 'Pilih Shift',
        minimumInputLength: -1,
        allowClear: false,
        ajax: {
            url: baseurl + 'PolaShiftSeksi/createPolaShift/getLsh',
            dataType: 'json',
            delay: 1000,
            data: function(params) {
                return {
                    term: params.term
                }
            },
            type: "POST",
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.inisial, text: obj.inisial+ ' - ' + obj['shift'] };//
                    })
                };
            }
        }
    });
}

function simpan_to_table()
{
    var noin = $('.pss_getAllnoindName').val();
    var oke = 1;
    if (noin == null || noin.length < 1) { alert('Harap Isi Noind!'); return false; }
    $('.pss_gs').each(function(){
        if ($(this).val().length < 1) { oke = 0; alert('Harap Isi Semua Shift !'); return false; }
    });
    if (oke == 0) { return false; };

    $('#ipscekdate').attr('disabled', true);
    $('#pssdivsavehid').removeAttr('hidden');
    init_btn_save_sh();

    var lisnoind = [];
    $('#psstblsh tbody tr').each(function(){
        lisnoind.push($(this).find('td').eq(0).text());
    });
    console.log(lisnoind);
    //mulai append
    for(var N of noin){
        if (N.length == 0) { continue; }
        var tr = [];
        var sN = N.split(' - ');
        if (lisnoind.indexOf(sN[0]) != -1) { continue; }
        tr.push(sN[0]);// noind dan nama
        tr.push(sN[1]);// noind dan nama
        
        var x = 1;
        for(let i = 0; i < $('.pss_gs').length; i++){
            var sh = $('.pss_gs').eq(i).val();
            var num = $('.pss_pr_js').eq(i).find('label').text().split(' - ');

            var a = num[0], b = (num.length>1) ? num[1]:num[0];
            for(let j = 0; j <= b-a; j++){
                if (list_hari_libur.indexOf(x) == -1) {
                    tr.push(sh);
                }else{
                    tr.push('');
                }
                x++;
            }
        }
        console.log(tr);
        $('#psstblsh').DataTable().row.add(tr).draw( false );
    }

    function init_btn_save_sh()
    {
        //beberapa variable berasal dari V_List_minggu.php
        $('#btn_ips_save').off('click');
        $('#btn_ips_save').click(function(){
            var noind = [];
            var sh = [];
            var ips_tgl = arr_total_hari;
            $('#psstblsh tbody tr').each(function(){
                noind.push($(this).find('td').eq(0).text());
                var x = 0;
                var arr = [];
                for(let i = 0; i <= ips_tgl.length+1; i++){
                    if (x < 2) { x++; continue; }
                    arr.push($(this).find('td').eq(i).text())
                    x++;
                }
                sh.push(arr);
            });
            console.log('tgl',ips_tgl);
            console.log('noind', noind);
            console.log('sh', sh);
            var atasan = $('.ips_get_atasan').val();
            $('#surat-loading').attr('hidden', false);
            $.ajax({
                url: baseurl + 'PolaShiftSeksi/ImportPolaShift/save_ods',
                type: "post",
                data: {tgl: ips_tgl, noind: noind, shift: sh, pri: createShiftPr, atasan: atasan},
                success: function (response) {
                    $('#surat-loading').attr('hidden', true);
                    ips_swetAlert();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   console.log(textStatus, errorThrown);
                }
            });
        });
    }
}