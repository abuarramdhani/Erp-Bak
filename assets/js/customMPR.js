//master Presensi Pekerja Keluar
$(function() {
    $('#txtPeriodeGajiPKJKeluar').daterangepicker({
        "autoclose": true,
        "todayHiglight": true,
        locale: {
            cancelLabel: 'Clear',
            "format": "YYYY-MM-DD",
            "separator": " - ",
        }
    });

    $('#txtPeriodePuasaPKJKeluar').daterangepicker({
        "autoclose": true,
        "todayHiglight": true,
        locale: {
            cancelLabel: 'Clear',
            "format": "YYYY-MM-DD",
            "separator": " - ",
        }
    });

    $('#txtTglCetakPKJKeluar').datepicker({
        "autoclose": true,
        "todayHiglight": true,
        "format": 'yyyy-mm-dd'
    });

    $('.txtpolareffgaji').datepicker({
        "autoclose": true,
        "todayHiglight": true,
        "format": 'yyyy-mm-dd'
    });


});

$(document).ready(function() {
    var tblexist = $('#table-gaji-pekerja-keluar').html();
    if (tblexist) {
        var table = $('#table-gaji-pekerja-keluar').DataTable({
            // fixedHeader		: true,
            scrollY: '400px',
            scrollX: true,
            scrollCollapse: true,
            columnDefs: [
                { width: 200, targets: 0 }
            ],
        });

        new $.fn.dataTable.FixedColumns(table, {
            leftColumns: 4
        });
    }
});

$(document).ready(function() {
    $('#txtPuasaPKJKeluar').on('ifChecked', function() {
        $('#txtPeriodePuasaPKJKeluar').prop("disabled", false);
    });
    $('#txtPuasaPKJKeluar').on('ifUnchecked', function() {
        $('#txtPeriodePuasaPKJKeluar').prop("disabled", true);
    });

    $('.slcPekerjaGajiPKJKeluar').select2({
        searching: true,
        minimumInputLength: 3,
        allowClear: false,
        disabled: true,
        ajax: {
            url: baseurl + 'MasterPresensi/ReffGaji/PekerjaKeluar/getPekerja',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
                return {
                    term: params.term,
                    kode: status
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.nomor, text: obj.noind + " - " + obj.nama };
                    })
                }
            }
        }
    });
});

$(document).on('change', '#slcStatusPekerja', function() {
    var status = $(this).val();
    if (status == "") {
        $('.slcPekerjaGajiPKJKeluar').prop("disabled", true);
        $(".slcPekerjaGajiPKJKeluar").val(null).trigger("change");
    } else {
        $('.slcPekerjaGajiPKJKeluar').prop("disabled", false);
        $('.slcPekerjaGajiPKJKeluar').select2({
            searching: true,
            minimumInputLength: 3,
            allowClear: false,
            ajax: {
                url: baseurl + 'MasterPresensi/ReffGaji/PekerjaKeluar/getPekerja',
                dataType: 'json',
                delay: 500,
                type: 'GET',
                data: function(params) {
                    return {
                        term: params.term,
                        kode: status
                    }
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(obj) {
                            return { id: obj.nomor, text: obj.noind + " - " + obj.nama };
                        })
                    }
                }
            }
        });
    }
});

$(document).on('ready', function() {
    $('.dataTable-pekerjaKeluar-detail').dataTable({
        scrollY: "300px",
        paging: false
    });

    $('#tbl-MPR-BPJSTambahan').dataTable({
        "processing": true,
        "serverSide": true,
        "order" : [],
        "ajax":{
          "url": baseurl+'MasterPresensi/ReffGaji/BPJSTambahan/ListPekerja',
          "type": "post"
        },
        "columnDefs" : [
        {
          "targets":[0],
          // "orderable":false,
          "className": 'text-center'
        },
        {
          "targets":[1],
          // "orderable":false,
          "className": 'text-center'
        },
        {
          "targets":[4],
          // "orderable":false,
          "className": 'text-center'
        },
        {
          "targets":[5],
          // "orderable":false,
          "className": 'text-center'
        }
        ],
    });
});

$(document).on('ready',function(){
    $('#MPR-transferreffgaji-submit').on('click',function(){
        $('#MPR-status-Read').val("1");
        $('#MPR-transferreffgaji-download').html("");
        periode = $('#MPR-transferreffgaji-periode').val();
        $('#MPR-transferreffgaji-progress').css("width","0%");
        $.ajax({
            data : {periode : periode},
            url : baseurl + 'MasterPresensi/ReffGaji/TransferReffGaji/proses',
            type : 'GET',
            success: function(e){
               $('#MPR-transferreffgaji-download').html(e);
               setTimeout(function(e){
                 $('#MPR-status-Read').val("0");
               },5000);
            }
        })
    });
});

$(document).on('ready',function(){
    $('#txttglpolareffgajiawal').on('change',function(){
        transferPolaReffGaji();
    });

    $('#txttglpolareffgajiakhir').on('change',function(){
        transferPolaReffGaji();
    });

    $('#MPR-transferpolareffgaji-submit').on('click',function(){
        $('#MPR-status-Read').val("1");
        awal = $('#txttglpolareffgajiawal').val();
        akhir = $('#txttglpolareffgajiakhir').val();
        $('#MPR-transferpolareffgaji-download').html("");
        $('#MPR-transferpolareffgaji-progress').css("width","0%");
        $.ajax({
            data : {tglawal: awal, tglakhir: akhir},
            url : baseurl + 'MasterPresensi/ReffGaji/TransferPolaReffGaji/proses',
            type : 'GET',
            success: function(e){
               $('#MPR-transferpolareffgaji-download').html(e);
               setTimeout(function(e){
                 $('#MPR-status-Read').val("0");
               },5000);
            }
        })
    });
});

function transferPolaReffGaji(){
    awal = $('#txttglpolareffgajiawal').val();
    akhir = $('#txttglpolareffgajiakhir').val();
    if (awal !== "" && akhir !== "") {
        tglawal = new Date(awal);
        tglakhir = new Date(akhir);

        difftime = Math.abs(tglakhir.getTime() - tglawal.getTime());
        diffdate = Math.ceil(difftime/ (1000 * 3600 * 24));
        console.log("awal:: " + awal + " akhir:: " + akhir + " selisih hari:: " + diffdate + "d");

        if (diffdate <= 48 && tglawal <= tglakhir && (tglawal.getMonth() == tglakhir.getMonth() || (tglakhir.getMonth() - tglawal.getMonth())  == 1  || (tglawal.getMonth() == 12 && tglakhir.getMonth() == 1))) {
            if (tglawal.getDate() < 15) {
                if (diffdate <= 31 && tglawal.getMonth() == tglakhir.getMonth()) {
                    $('#MPR-transferpolareffgaji-submit').removeClass('disabled');
                    $('#MPR-transferpolareffgaji-submit').removeClass('btn-danger');
                    $('#MPR-transferpolareffgaji-submit').addClass('btn-primary');
                    $('#MPR-transferpolareffgaji-download').html("Bisa dilakukan transfer");
                }else{
                    $('#MPR-transferpolareffgaji-submit').addClass('disabled');
                    $('#MPR-transferpolareffgaji-submit').addClass('btn-danger');
                    $('#MPR-transferpolareffgaji-submit').removeClass('btn-primary');
                    $('#MPR-transferpolareffgaji-download').html("tanggal a < 15 , tanggal b harus di bulan dan tahun yang sama");
                }
            }else{
                $('#MPR-transferpolareffgaji-submit').removeClass('disabled');
                $('#MPR-transferpolareffgaji-submit').removeClass('btn-danger');
                $('#MPR-transferpolareffgaji-submit').addClass('btn-primary');
                $('#MPR-transferpolareffgaji-download').html("Bisa dilakukan transfer");
            }
        }else{
            $('#MPR-transferpolareffgaji-submit').addClass('disabled');
            $('#MPR-transferpolareffgaji-submit').addClass('btn-danger');
            $('#MPR-transferpolareffgaji-submit').removeClass('btn-primary');
            if(diffdate > 48){
                $('#MPR-transferpolareffgaji-download').html("Maksimal 48 Hari ( '15 - 31' bulan a & '01 - 31' bulan b )");
            }
            if(tglawal > tglakhir){
                $('#MPR-transferpolareffgaji-download').html("tanggal a tidak boleh lebih besar dari tanggal b");
            }
            if((tglakhir.getMonth() - tglawal.getMonth())  > 1){
                $('#MPR-transferpolareffgaji-download').html("bulan b hanya dapat diisi bulan a atau bulan (a+1) atau bulan 01 jika bulan a = 12");
            }
        }
    }else{
        $('#MPR-transferpolareffgaji-submit').addClass('disabled');
        $('#MPR-transferpolareffgaji-submit').addClass('btn-danger');
        $('#MPR-transferpolareffgaji-submit').removeClass('btn-primary');
        $('#MPR-transferpolareffgaji-download').html('Input Tanggal ada yang Kosong');
    }
}

$(document).ready(function(){
    $('#tbl-MPR-BPJSTambahan').on('click','.modal-trigger-MPR-BPJSTambahan',function(){
        noind = $(this).attr('data-noind');
        BPJS_refreshkeluarga(noind);
        $('#modal-MPR-BPJSTambahan').modal('show');
    });

    $('.modal-close-MPR-BPJSTambahan').on('click',function(){
        $('#modal-MPR-BPJSTambahan').modal('hide');
    });

    $('.tbl-MPR-BPJSTambahan-tidakditanggung ').on('click','.btn-MPR-BPJSTambahan-tambah',function(){
        noind = $(this).attr('data-noind');
        nama = $(this).attr('data-nama');
        $.ajax({
            type: 'POST',
            url: baseurl + 'MasterPresensi/ReffGaji/BPJSTambahan/tambah',
            data: {noind: noind, nama: nama},
            success: function(data){
                BPJS_refreshkeluarga(noind);
                BPJS_refreshtableutama();
            }
        });

    });

    $('.tbl-MPR-BPJSTambahan-ditanggung ').on('click','.btn-MPR-BPJSTambahan-hapus',function(){
        noind = $(this).attr('data-noind');
        nama = $(this).attr('data-nama');
        $.ajax({
            type: 'POST',
            url: baseurl + 'MasterPresensi/ReffGaji/BPJSTambahan/hapus',
            data: {noind: noind, nama: nama},
            success: function(data){
                BPJS_refreshkeluarga(noind);
                BPJS_refreshtableutama();
            }
        });

    });
});

function BPJS_refreshkeluarga(noind){

    $.ajax({
        type: 'POST',
        url: baseurl + 'MasterPresensi/ReffGaji/BPJSTambahan/showFamily',
        data: {noind: noind},
        success: function(data){
            obj = JSON.parse(data);
            no1 = 1;
            no2 = 1;
            $('.tbl-MPR-BPJSTambahan-ditanggung').html("");
            $('.tbl-MPR-BPJSTambahan-tidakditanggung').html("");
            for (var i = 0; i < obj.length; i++) {
                if (obj[i]['status'] == "YA") {
                    isi = "<tr>";
                    isi += "<td class='text-center'>" + no1 + "</td>";
                    isi += "<td>" + obj[i]['jenisanggota'] + "</td>";
                    isi += "<td>" + obj[i]['nama'] + "</td>";
                    isi += "<td>" + obj[i]['nik'] + "</td>";
                    isi += "<td>" + obj[i]['tgllahir'] + "</td>";
                    isi += "<td>" + obj[i]['alamat'] + "</td>";
                    isi += "<td class='text-center'><button type='button' data-noind='" + noind + "' data-nama='" + obj[i]['nama'] + "' ";
                    isi += "class='btn btn-danger btn-sm btn-MPR-BPJSTambahan-hapus' data-toggle='tooltip' title='Hapus dari Tanggungan Pekerja' data-placement='left'><span class='fa fa-trash'></span></button></td>";
                    isi += "</tr>";
                    $('.tbl-MPR-BPJSTambahan-ditanggung').append(isi);
                    no1++;
                }else{
                    isi = "<tr>";
                    isi += "<td class='text-center'>" + no2 + "</td>";
                    isi += "<td>" + obj[i]['jenisanggota'] + "</td>";
                    isi += "<td>" + obj[i]['nama'] + "</td>";
                    isi += "<td>" + obj[i]['nik'] + "</td>";
                    isi += "<td>" + obj[i]['tgllahir'] + "</td>";
                    isi += "<td>" + obj[i]['alamat'] + "</td>";
                    isi += "<td class='text-center'><button type='button' data-noind='" + noind + "' data-nama='" + obj[i]['nama'] + "' ";
                    isi += "class='btn btn-success btn-sm btn-MPR-BPJSTambahan-tambah' data-toggle='tooltip' title='Tambahkan ke Tanggungan Pekerja' data-placement='left'><span class='fa fa-plus'></span></button></td>";
                    isi += "</tr>";
                    $('.tbl-MPR-BPJSTambahan-tidakditanggung').append(isi);
                    no2++;
                }
            }
        }
    })
}

function BPJS_refreshtableutama(){
    // table = $('#tbl-MPR-BPJSTambahan').dataTable();
    //
    // $.ajax({
    //     type: 'POST',
    //     url: baseurl + 'MasterPresensi/ReffGaji/BPJSTambahan/refresh',
    //     data: {noind: noind},
    //     success: function(data){
    //         table.fnClearTable();
    //         obj = JSON.parse(data);
    //         no3 = 1;
    //         for (var i = 0; i < obj.length; i++) {
    //             table.fnAddData([
    //                 no3,
    //                 obj[i]['noind'],
    //                 obj[i]['nama'],
    //                 obj[i]['seksi'],
    //                 obj[i]['jumlah'],
    //                 '<button type="button" class="btn btn-sm modal-trigger-MPR-BPJSTambahan" data-noind =' + obj[i]['noind'] + ' style="background-image: linear-gradient(70deg, #2ABB9B 70%, #16A085 30%);color: white"><span class="fa fa-pencil"></span></button>'
    //                 ]);
    //             no3++;
    //         }
    //     }
    // })

    $('#tbl-MPR-BPJSTambahan').DataTable().ajax.reload();
}

$(document).ready(function(){
    $('.dataTable-pekerjaCutoff').dataTable();
    $('.slc-pekerjaCutoff').select2({
        searching: true,
        minimumInputLength: 3,
        placeholder: "No. Induk / Nama Pekerja",
        allowClear: false,
        ajax: {
            url: baseurl + 'MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/search',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.noind, text: obj.noind + " - " + obj.nama };
                    })
                }
            }
        }
    });
    $('#btn-PekerjaCutoff-search').on('click',function(){
        noind = $('.slc-pekerjaCutoff').val();
        $.ajax({
            data: {noind: noind},
            url: baseurl + 'MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/pekerjaDetail',
            type: 'GET',
            success: function(data){
                obj = JSON.parse(data);
                $('#tbodyPekerjaCutoff').html("");
                $('#td-pekerjaCutoff-noind').html(obj['pekerja']['noind']);
                $('#td-pekerjaCutoff-nama').html(obj['pekerja']['nama']);
                $('#td-pekerjaCutoff-seksi').html(obj['pekerja']['seksi']);
                $('#btn-pekerjaCutoff-pekerja-pdf').attr('data-noind',obj['pekerja']['noind']);
                $('#btn-pekerjaCutoff-pekerja-xls').attr('data-noind',obj['pekerja']['noind']);
                if(obj['data'].length > 0){
                    for (var i = 0; i < obj['data'].length; i++) {
                        $('#tbodyPekerjaCutoff').append("<tr><td class='text-center'>" + (i + 1) + "</td><td class='text-center'><a href='" + baseurl + 'MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/d/' + obj[i]['tanggal_proses'] + "'>" + obj[i]['periode'] + "</a></td></tr>");
                    }
                }else{
                    $('#tbodyPekerjaCutoff').append('<tr><td colspan="2" class="text-center"><i>Tidak Ditemukan Data untuk Nomor Induk <b>' + noind +'</b> di Data Pekerja Cut Off</i></td></tr>');
                }    
            }
        });
    });
    $('#btn-pekerjaCutoff-pekerja-pdf').on('click',function(){
        noind = $(this).attr('data-noind');
        if(noind !== "-"){
            window.open(baseurl + "MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/pdf/n/" + noind, "_blank");    
        }        
    });
    $('#btn-pekerjaCutoff-pekerja-xls').on('click',function(){
        noind = $(this).attr('data-noind');
        if(noind !== "-"){
            window.open(baseurl + "MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/xls/n/" + noind, "_blank");    
        }        
    });
});

$(document).ready(function(){
    $('.slcKhususNoind').select2({
        searching: true,
        minimumInputLength: 3,
        placeholder: "No. Induk / Nama Pekerja",
        allowClear: false,
        ajax: {
            url: baseurl + 'MasterPresensi/ReffGaji/PekerjaKhusus/searchActiveEmployees',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.noind, text: obj.noind + " - " + obj.nama };
                    })
                }
            }
        }
    });
    $('#tblPekerjaKhusus').DataTable({
        scrollX: true,
        fixedColumns: {
            leftColumns: 4
        }
    });
});
