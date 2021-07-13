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
    $('#tbl-MPR-PekerjaKeluar-List').DataTable({
        "scrollX" : true,
        "fixedColumns":   {
            leftColumns: 5
        },
        "lengthMenu": [
            [ 5, 10, 25, 50, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "dom" : 'Bfrtip',
        "buttons" : [
            'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
        ],
    });

    $(document).on('ifChecked','#txtPuasaPKJKeluar', function() {
        $('#txtPeriodePuasaPKJKeluar').prop("disabled", false);
    });
    $(document).on('ifUnchecked','#txtPuasaPKJKeluar', function() {
        $('#txtPeriodePuasaPKJKeluar').prop("disabled", true);
    }); 
    $(document).on('ifChecked','#txtKhususPKJKeluarCheckList', function() {
        $('input[name=txtKhususPKJKeluar]').parents('.disabled').removeClass("disabled");
        $('input[name=txtKhususPKJKeluar]').prop("disabled", false);
    });
    $(document).on('ifUnchecked','#txtKhususPKJKeluarCheckList', function() {
        $('input[name=txtKhususPKJKeluar]').iCheck('uncheck');
        $('input[name=txtKhususPKJKeluar]').prop("disabled", true);
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

$(document).ready(function(){
    $('#txt-MPR-PekerjaKeluar-Export-PeriodeKeluar').daterangepicker({
        "autoclose": true,
        "todayHiglight": true,
        locale: {
            cancelLabel: 'Clear',
            "format": "YYYY-MM-DD",
            "separator": " - ",
        }
    });

    var tblMPRPekerjaKeluarExport = $('#tbl-MPR-PekerjaKeluar-Export').DataTable({
        "scrollX" : true,
        "lengthMenu": [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "dom" : 'Bfrtip',
        "buttons" : [
            'pageLength'
        ],
    });

    $('#btn-MPR-PekerjaKeluar-Export-Lihat').on('click', function(){
        var tanggal = $('#txt-MPR-PekerjaKeluar-Export-PeriodeKeluar').val();
        var kodeInduk = $('#txt-MPR-PekerjaKeluar-Export-KodeInduk').val();
        if (tanggal) {
            $('#ldg-MPR-PekerjaKeluar-Export-Loading').show();
            $.ajax({
                method: 'GET',
                url: baseurl + 'MasterPresensi/ReffGaji/PekerjaKeluar/lihatExport',
                data: {tanggal: tanggal, kode_induk: kodeInduk},
                error: function(xhr,status,error){
                    $('#ldg-MPR-PekerjaKeluar-Export-Loading').hide();
                    swal.fire({
                        title: xhr['status'] + "(" + xhr['statusText'] + ")",
                        html: xhr['responseText'],
                        type: "error",
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#d63031',
                    })
                },
                success: function(data){
                    $('#ldg-MPR-PekerjaKeluar-Export-Loading').hide();
                    obj = JSON.parse(data);
                    tblMPRPekerjaKeluarExport.clear().draw();
                    obj.forEach(function(daftar, index){
                        tblMPRPekerjaKeluarExport.row.add([
                            (index + 1),
                            daftar.noind,
                            daftar.nama,
                            daftar.tanggal_keluar,
                            daftar.ipe,
                            daftar.ika,
                            daftar.ubt,
                            daftar.upamk,
                            daftar.ief,
                            daftar.jam_lembur,
                            daftar.htm,
                            daftar.ijin,
                            daftar.ct,
                            daftar.ket,
                            daftar.um_puasa,
                            daftar.ims,
                            daftar.imm,
                            daftar.ipet,
                            daftar.um_cabang,
                            daftar.dldobat,
                            daftar.plain,
                            daftar.tambahan_str,
                            daftar.potongan_str,
                            daftar.jml_jkn,
                            daftar.jml_jht,
                            daftar.jml_jp,
                            daftar.pduka
                        ]).draw(false);
                    })
                    tblMPRPekerjaKeluarExport.columns.adjust().draw();
                }
            })
        }else{
            swal.fire(
                'Peringatan!!',
                'Pastikan Periode Keluar Sudah Terisi !!!',
                'warning'
            )
        }
    });

    $('#btn-MPR-PekerjaKeluar-Export-Pdf').on('click', function(){
        var tanggal = $('#txt-MPR-PekerjaKeluar-Export-PeriodeKeluar').val();
        var kodeInduk = $('#txt-MPR-PekerjaKeluar-Export-KodeInduk').val();
        if (tanggal) {
            var params = encodeURI("tanggal=" + tanggal + "&kodeInduk=" + kodeInduk);
            window.open(baseurl + 'MasterPresensi/ReffGaji/PekerjaKeluar/exPdf?' + params,'_blank');
        }else{
            swal.fire(
                'Peringatan!!',
                'Pastikan Periode Keluar Sudah Terisi !!!',
                'warning'
            )
        }
    });

    $('#btn-MPR-PekerjaKeluar-Export-Excel').on('click', function(){
        var tanggal = $('#txt-MPR-PekerjaKeluar-Export-PeriodeKeluar').val();
        var kodeInduk = $('#txt-MPR-PekerjaKeluar-Export-KodeInduk').val();
        if (tanggal) {
            var params = encodeURI("tanggal=" + tanggal + "&kodeInduk=" + kodeInduk);
            window.open(baseurl + 'MasterPresensi/ReffGaji/PekerjaKeluar/exExcel?' + params,'_blank');
        }else{
            swal.fire(
                'Peringatan!!',
                'Pastikan Periode Keluar Sudah Terisi !!!',
                'warning'
            )
        }
    });

    $('#btn-MPR-PekerjaKeluar-Export-Dbf').on('click', function(){
        var tanggal = $('#txt-MPR-PekerjaKeluar-Export-PeriodeKeluar').val();
        var kodeInduk = $('#txt-MPR-PekerjaKeluar-Export-KodeInduk').val();
        if (tanggal) {
            var params = encodeURI("tanggal=" + tanggal + "&kodeInduk=" + kodeInduk);
            window.open(baseurl + 'MasterPresensi/ReffGaji/PekerjaKeluar/exDbf?' + params,'_blank');
        }else{
            swal.fire(
                'Peringatan!!',
                'Pastikan Periode Keluar Sudah Terisi !!!',
                'warning'
            )
        }
    });
})

// end pekerja keluar

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
        memoNonStaff = $('#txt-MPR-transferreffgaji-memo-nonstaff').val();
        memoStaff = $('#txt-MPR-transferreffgaji-memo-staff').val();
        
        $('#MPR-transferreffgaji-progress').css("width","0%");
        $.ajax({
            data : {periode : periode,staff: memoStaff,nonstaff: memoNonStaff},
            url : baseurl + 'MasterPresensi/ReffGaji/TransferReffGaji/proses',
            type : 'GET',
            error: function(xhr,status,error){
                swal.fire({
                    title: xhr['status'] + "(" + xhr['statusText'] + ")",
                    html: xhr['responseText'],
                    type: "error",
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#d63031',
                })
                $('#MPR-status-Read').val("0");
            },
            success: function(e){
                $('#MPR-transferreffgaji-download').html(e);
                setTimeout(function(e){
                    $('#MPR-status-Read').val("0");
                },5000);
            }
        })
    });
    $('#MPR-transferreffgaji-khusus-noind').select2({
        searching: true,
        minimumInputLength: 3,
        placeholder: "No. Induk / Nama Pekerja",
        allowClear: false,
        ajax: {
            url: baseurl + 'MasterPresensi/ReffGaji/TransferReffGaji/search',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
                return {
                    term: params.term,
                    jenis: 'khusus'
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
    $('#MPR-transferreffgaji-khusus-noind-atasan').select2({
        searching: true,
        minimumInputLength: 3,
        placeholder: "No. Induk / Nama Pekerja",
        allowClear: false,
        ajax: {
            url: baseurl + 'MasterPresensi/ReffGaji/TransferReffGaji/search',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
                return {
                    term: params.term,
                    jenis: 'atasan'
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
    $('#txtPeriodeCutoff').datepicker({
      "autoclose": true,
      "todayHiglight": true,
      "format":'yyyymm - MM yyyy',
      "viewMode":'months',
      "minViewMode":'months'
    });

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

    $('.slc-pekerjaCutoff-aktif').select2({
        searching: true,
        minimumInputLength: 3,
        placeholder: "No. Induk / Nama Pekerja",
        allowClear: false,
        ajax: {
            url: baseurl + 'MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/searchAktif',
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

    $('#txtPeriodeCutoff').on('change',function(){
        periode = $('#txtPeriodeCutoff').val();
        $.ajax({
            data: {periode: periode},
            url: baseurl + 'MasterPresensi/ReffGaji/PekerjaCutoffMemo/getPekerjaCutoffMemo',
            type: 'GET',
            success: function(data){
                if (data !== "Tidak Ada Periode Cutoff" && data !== "Tidak Ada Periode Cutoff + 1" ) {
                    $('#boxCutoff').html(data);
                    $('#boxCutoff table').DataTable({
                        "paging":   false,
                        "ordering": false,
                        "info":     false
                    });    
                    $('#btnPekerjaCutoffMemoSubmit').attr('disabled',false);
                }else{
                    $('#boxCutoff').html("<h1 style='color: red;text-align: center'>" + data + "</h1>");
                    $('#btnPekerjaCutoffMemoSubmit').attr('disabled',true);
                }
            }
        })
    });

    $(document).on('ifChecked','input[name=txtPilihPekerjaCutoff]',function(){
        isi = $(this).val();
        if(isi == "Semua"){
            $('.txtNoindPekerjaCutoff').iCheck('check');
        }else{
            $('.txtNoindPekerjaCutoff').iCheck('uncheck');
        }
    })
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

// POtongan Lain
$(document).ready(function(){
    $('#pg_selectPekerja').on('change',function(){
        cekPotonganGajiExist()
    });

    $('#pg_inputNominalTotal').on('change',function(){
        cekPotonganGajiExist()
    });

    $('#pg_inputNominalTotal').on('keyup',function(){
        cekPotonganGajiExist()
    });

    $('#pg_selectJenisPotongan').on('change',function(){
        cekPotonganGajiExist()
    });

});

function cekPotonganGajiExist(){
    jenis = $('#pg_selectJenisPotongan').val();
    nominal = $('#pg_inputNominalTotal').val();
    noind = $('#pg_selectPekerja').val();

    if (jenis && nominal && noind) {
        $.ajax({
            data: {jenis:jenis, noind:noind, nominal:nominal},
            type: 'POST',
            url: baseurl + 'MasterPresensi/PotonganGaji/TambahData/cekDuplikat',
            error: function(xhr,status,error){
                console.log(xhr);
                console.log(status);
                console.log(error);
                swal.fire({
                    title: xhr['status'] + "(" + xhr['statusText'] + ")",
                    html: xhr['responseText'],
                    type: "error",
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#d63031',
                })
                $('#modalKPInputDataList').modal('hide');
            },
            success: function(result){
                if (result) {
                    obj = JSON.parse(result);
                    console.log(obj);
                    if (obj['jumlah'] !== '0') {
                        $('#pg_buttonSimulasi').attr('disabled',true);
                        // swal.fire({
                        //     title: "Data Sudah Pernah Diinput",
                        //     text: "Ditemukan Data dengan No. Induk, Jenis Potongan, dan Nominal Total Yang Sama",
                        //     type: "warning"
                        // })
                        console.log(obj['data']);
                        Swal.fire({
                            title: 'Ditemukan Data Yang Sama !!',
                            html: "Ditemukan Data dengan No. Induk, Jenis Potongan, dan Nominal Total Yang Sama<br>Apakah Anda Yakin Data Yang Ada Input Bukan Data Yang Sama ?",
                            // html: obj['data'],
                            // text: "Apakah Data Yang Ada Input Bukan Data Yang Sama ?",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, Bukan Data Yang Sama',
                            cancelButtonText: 'Tidak'
                        }).then((result) => {
                            if (result.value) {
                                $('#pg_buttonSimulasi').attr('disabled',false);
                            }
                        });
                    }else{
                        $('#pg_buttonSimulasi').attr('disabled',false);
                    }                    
                }
            }
        })
    }
}

// start THR

$(document).on('ready',function(){
    $('#txtTHRTanggalIdulFitri').datepicker({
        "autoclose": true,
        "todayHiglight": true,
        "format": 'yyyy-mm-dd'
    });

    $('#txtTHRTanggalPuasaPertama').datepicker({
        "autoclose": true,
        "todayHiglight": true,
        "format": 'yyyy-mm-dd'
    });

    $('#txtTHRTanggalDibuat').datepicker({
        "autoclose": true,
        "todayHiglight": true,
        "format": 'yyyy-mm-dd'
    });

    $('#tbl-MPR-THR-lihat').DataTable();
    $('#tbl-MPR-THR-index').DataTable();

    $('#slcTHRMengetahui').select2({
        searching: true,
        minimumInputLength: 3,
        placeholder: "No. Induk / Nama Pekerja",
        allowClear: false,
        ajax: {
            url: baseurl + 'MasterPresensi/ReffGaji/THR/getPekerja',
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
})

// end THR

// start Cuti Bersama
$(document).ready(function(){
    $('#txtTanggalCutiBersama').datepicker({
        "autoclose": true,
        "todayHiglight": true,
        "format": 'yyyy-mm-dd'
    });

    $('#tbl-MPR-CutiBersama-index').DataTable();
    
    $('#MPR-cutibersama-submit').on('click',function(){
        $('#MPR-status-Read').val("1");
        $('#MPR-cutibersama-download').html("");
        txtTanggalCutiBersama = $('#txtTanggalCutiBersama').val();
        txtKeteranganCutiBersama = $('#txtKeteranganCutiBersama').val();
        $('#MPR-cutibersama-progress').css("width","0%");
        $.ajax({
            data : {txtTanggalCutiBersama : txtTanggalCutiBersama, txtKeteranganCutiBersama : txtKeteranganCutiBersama},
            url : baseurl + 'MasterPresensi/Proses/CutiBersama/Proses',
            type : 'POST',
            success: function(e){
               $('#MPR-cutibersama-download').html(e);
               setTimeout(function(e){
                 $('#MPR-status-Read').val("0");
               },5000);
            }
        })
    });

    $('.td-MPR-CutiBersama-cb').on('click',function(){
       showModalCutiBersama($(this));
    });

    $('.td-MPR-CutiBersama-mtp').on('click',function(){
        showModalCutiBersama($(this));
    });

    $('.td-MPR-CutiBersama-mp').on('click',function(){
        showModalCutiBersama($(this));
    });

    $('.td-MPR-CutiBersama-l').on('click',function(){
        showModalCutiBersama($(this));
    });

    $('.td-MPR-CutiBersama-j').on('click',function(){
       showModalCutiBersama($(this));
    });

    $('.modal-close-MPR-CutiBersama').on('click',function(){
        $('#modal-MPR-CutiBersama').modal('hide');
    });

})

function showModalCutiBersama(dt){
    tanggal = dt.attr('data-tanggal');
    keterangan =  dt.attr('data-ket');
    $('.loading').show();
    $.ajax({
        data: {tanggal: tanggal, keterangan: keterangan},
        type: 'GET',
        url: baseurl + 'MasterPresensi/Proses/CutiBersama/Detail',
        error: function(xhr,status,error){
            console.log(xhr);
            console.log(status);
            console.log(error);
            $('.loading').hide();
            swal.fire({
                title: xhr['status'] + "(" + xhr['statusText'] + ")",
                html: xhr['responseText'],
                type: "error",
                confirmButtonText: 'OK',
                confirmButtonColor: '#d63031',
            })
        },
        success: function(result){
            $('#modal-MPR-CutiBersama-isi').html(result);
            $('#modal-MPR-CutiBersama-isi .tbl-MPR-CutiBersama-modal-table').DataTable();
            $('.loading').hide();
            $('#modal-MPR-CutiBersama').modal('show');
        }
    })
}
// end Cuti Bersama

// start tarik shift pekerja
$(document).ready(function(){
    $('#tblMPRTarikShiftPekerja').DataTable({
        scrollX: true,
        fixedColumns: {
            leftColumns: 3
        },
        "lengthMenu": [
            [ 10, 5, 25, 50, -1],
            [ '10', '5', '25', '50', 'All' ]
        ],
    })
})
// end tarik shift pekerja

// start cetak presensi harian
$(document).on('ready', function(){
    $('#txtMPRPresensiHarianTanggal').daterangepicker({
        "autoclose": true,
        "todayHiglight": true,
        locale: {
            cancelLabel: 'Clear',
            "format": "YYYY-MM-DD",
            "separator": " - ",
        }
    });

    var tblMPRPresensiHarianKodesie = $('#tblMPRPresensiHarianKodesie').DataTable()
    var tblMPRPresensiHarianPekerja = $('#tblMPRPresensiHarianPekerja').DataTable({
        columnDefs: [
            {
                targets : [0,-1],
                className: 'text-center'
            }
        ]
    })

    var tblMPRPresensiHarianModalKodesieSelected = $('#tblMPRPresensiHarianModalKodesieSelected').DataTable({
        scrollY: "400px",
        scrollX: true,
        paging: false
    })

    var tblMPRPresensiHarianModalPekerja = $('#tblMPRPresensiHarianModalPekerja').DataTable({
        scrollY: "400px",
        scrollX: true,
        paging: false,
        columnDefs: [
            {
                targets : [0,-1],
                className: 'text-center'
            }
        ]
    })


    $(document).on('ifChecked','#chkMPRPresensiHarianLokasiKerja',function(){
        $('#divMPRPresensiHarianLokasiKerja').show(500);
    })
    $(document).on('ifUnchecked','#chkMPRPresensiHarianLokasiKerja',function(){
        $('#divMPRPresensiHarianLokasiKerja').hide(500);
    })
    
    $(document).on('ifChecked','#chkMPRPresensiHarianKodeInduk',function(){
        $('#divMPRPresensiHarianKodeInduk').show(500);
    })
    $(document).on('ifUnchecked','#chkMPRPresensiHarianKodeInduk',function(){
        $('#divMPRPresensiHarianKodeInduk').hide(500);
    })
    
    $(document).on('ifChecked','#chkMPRPresensiHarianKodesie',function(){
        $('#chkMPRPresensiHarianPekerja').iCheck('uncheck');
        $('#divMPRPresensiHarianKodesie').show(500);
    })
    $(document).on('ifUnchecked','#chkMPRPresensiHarianKodesie',function(){
        $('#divMPRPresensiHarianKodesie').hide(500);
    })
    
    $(document).on('ifChecked','#chkMPRPresensiHarianPekerja',function(){
        $('#chkMPRPresensiHarianKodesie').iCheck('uncheck');
        $('#divMPRPresensiHarianPekerja').show(500);

    })
    $(document).on('ifUnchecked','#chkMPRPresensiHarianPekerja',function(){
        $('#divMPRPresensiHarianPekerja').hide(500);
    })

    $('#btnMPRPresensiHarianAddPekerja').on('click', function(){
        $('#mdlMPRPresensiHarianPekerja').modal('show');
    })

    $('#btnMPRPresensiHarianAddKodesie').on('click', function(){
        $('#mdlMPRPresensiHarianKodesie').modal('show');
    })

    $('#slcMPRPresensiHarianModalKodesieDepartemen').select2({
        searching: true,
        allowClear: false,
        ajax: {
            url: baseurl + 'MasterPresensi/DataPresensi/CetakPresensiHarian/getKodesie',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
                return {
                    term: params.term,
                    prev: '',
                    tingkat: 1
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.kode, text: obj.kode + " - " + obj.nama };
                    })
                }
            }
        }
    })

    $('#slcMPRPresensiHarianModalKodesieBidang').select2({
        searching: true,
        allowClear: false,
        ajax: {
            url: baseurl + 'MasterPresensi/DataPresensi/CetakPresensiHarian/getKodesie',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
                return {
                    term: params.term,
                    prev: $('#slcMPRPresensiHarianModalKodesieDepartemen').val(),
                    tingkat: 3
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.kode, text: obj.kode + " - " + obj.nama };
                    })
                }
            }
        }
    })


    $('#slcMPRPresensiHarianModalKodesieUnit').select2({
        searching: true,
        allowClear: false,
        ajax: {
            url: baseurl + 'MasterPresensi/DataPresensi/CetakPresensiHarian/getKodesie',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
                return {
                    term: params.term,
                    prev: $('#slcMPRPresensiHarianModalKodesieBidang').val(),
                    tingkat: 5
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.kode, text: obj.kode + " - " + obj.nama };
                    })
                }
            }
        }
    })


    $('#slcMPRPresensiHarianModalKodesieSeksi').select2({
        searching: true,
        allowClear: false,
        ajax: {
            url: baseurl + 'MasterPresensi/DataPresensi/CetakPresensiHarian/getKodesie',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
                return {
                    term: params.term,
                    prev: $('#slcMPRPresensiHarianModalKodesieUnit').val(),
                    tingkat: 7
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.kode, text: obj.kode + " - " + obj.nama };
                    })
                }
            }
        }
    })


    $('#slcMPRPresensiHarianModalKodesiePekerjaan').select2({
        searching: true,
        allowClear: false,
        ajax: {
            url: baseurl + 'MasterPresensi/DataPresensi/CetakPresensiHarian/getKodesie',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
                return {
                    term: params.term,
                    prev: $('#slcMPRPresensiHarianModalKodesieSeksi').val(),
                    tingkat: 9
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.kode, text: obj.kode + " - " + obj.nama };
                    })
                }
            }
        }
    })

    $('#slcMPRPresensiHarianModalKodesieDepartemen').on('change', function(){
        $('#btnMPRPresensiHarianModalKodesieAdd').attr('disabled', true)
        $('#slcMPRPresensiHarianModalKodesieBidang').attr('disabled', false)
        $('#slcMPRPresensiHarianModalKodesieBidang').val("").trigger('change');
    })
    $('#slcMPRPresensiHarianModalKodesieBidang').on('change', function(){
        $('#slcMPRPresensiHarianModalKodesieUnit').val("").trigger('change');
        if ($(this).attr('disabled') || $(this).val() == null) {
            $('#slcMPRPresensiHarianModalKodesieUnit').attr('disabled', true)
        }else if ($(this).attr('disabled') == false && $(this).val() == null) {
            $('#btnMPRPresensiHarianModalKodesieAdd').attr('disabled', true)
        }else{
            text = $(this).find('option:selected').text();
            if (text.includes("Semua") || text.includes("Hanya tingkat")) {
                $('#slcMPRPresensiHarianModalKodesieUnit').attr('disabled', true)
                $('#btnMPRPresensiHarianModalKodesieAdd').attr('disabled', false)
            }else{
                $('#slcMPRPresensiHarianModalKodesieUnit').attr('disabled', false)
                $('#btnMPRPresensiHarianModalKodesieAdd').attr('disabled', true)
            }
        }
    })
    $('#slcMPRPresensiHarianModalKodesieUnit').on('change', function(){
        $('#slcMPRPresensiHarianModalKodesieSeksi').val("").trigger('change');
        if ($(this).attr('disabled') || $(this).val() == null) {
            $('#slcMPRPresensiHarianModalKodesieSeksi').attr('disabled', true)
        }else if ($(this).attr('disabled') == false && $(this).val() == null) {
            $('#btnMPRPresensiHarianModalKodesieAdd').attr('disabled', true)
        }else{
            text = $(this).find('option:selected').text();
            if (text.includes("Semua") || text.includes("Hanya tingkat")) {
                $('#slcMPRPresensiHarianModalKodesieSeksi').attr('disabled', true)
                $('#btnMPRPresensiHarianModalKodesieAdd').attr('disabled', false)
            }else{
                $('#slcMPRPresensiHarianModalKodesieSeksi').attr('disabled', false)
                $('#btnMPRPresensiHarianModalKodesieAdd').attr('disabled', true)
            }
        }
    })
    $('#slcMPRPresensiHarianModalKodesieSeksi').on('change', function(){
        $('#slcMPRPresensiHarianModalKodesiePekerjaan').val("").trigger('change');
        if ($(this).attr('disabled') || $(this).val() == null) {
            $('#slcMPRPresensiHarianModalKodesiePekerjaan').attr('disabled', true)
        }else if ($(this).attr('disabled') == false && $(this).val() == null) {
            $('#btnMPRPresensiHarianModalKodesieAdd').attr('disabled', true)
        }else{
            text = $(this).find('option:selected').text();
            if (text.includes("Semua") || text.includes("Hanya tingkat")) {
                $('#slcMPRPresensiHarianModalKodesiePekerjaan').attr('disabled', true)
                $('#btnMPRPresensiHarianModalKodesieAdd').attr('disabled', false)
            }else{
                $('#slcMPRPresensiHarianModalKodesiePekerjaan').attr('disabled', false)
                $('#btnMPRPresensiHarianModalKodesieAdd').attr('disabled', true)
            }
        }
    })

    $('#slcMPRPresensiHarianModalKodesiePekerjaan').on('change', function(){
        if ($(this).attr('disabled') == false && $(this).val() == null) {
            $('#btnMPRPresensiHarianModalKodesieAdd').attr('disabled', true)
        }else{
            $('#btnMPRPresensiHarianModalKodesieAdd').attr('disabled', false)
        }
    })

    $('#btnMPRPresensiHarianModalKodesieAdd').on('click', function(){
        $('#ldgMPRCetakPresensiHarianLoading').show();

        kodesie = ""
        dept        =   $('#slcMPRPresensiHarianModalKodesieDepartemen').val()
        bidang      =   $('#slcMPRPresensiHarianModalKodesieBidang').val()
        unit        =   $('#slcMPRPresensiHarianModalKodesieUnit').val()
        seksi       =   $('#slcMPRPresensiHarianModalKodesieSeksi').val()
        pekerjaan   =   $('#slcMPRPresensiHarianModalKodesiePekerjaan').val()
        if (pekerjaan !== null) {
            kodesie = pekerjaan
        }else if(seksi !== null){
            kodesie = seksi
        }else if(unit !== null){
            kodesie = unit
        }else if(bidang !== null){
            kodesie = bidang
        }else if(dept !== null) {
            kodesie = dept
        }

        $.ajax({
            url : baseurl + 'MasterPresensi/DataPresensi/CetakPresensiHarian/getSeksi?kodesie=' + kodesie,
            error: function(xhr,status,error){
                $('#ldgMPRCetakPresensiHarianLoading').hide();
                swal.fire({
                    title: xhr['status'] + "(" + xhr['statusText'] + ")",
                    html: xhr['responseText'],
                    type: "error",
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#d63031',
                })
            },
            success: function(result){
                $('#ldgMPRCetakPresensiHarianLoading').hide();
                if (obj = JSON.parse(result)) {
                    obj.map(function(value){
                        tblMPRPresensiHarianModalKodesieSelected.row.add([
                            '<button type="button" class="btn btn-danger btnMPRPresensiHarianKodesieUnselect"><span class="fa fa-trash"></span></button>',
                            value['kodesie'],
                            value['dept'],
                            value['bidang'],
                            value['unit'],
                            value['seksi'],
                            value['pekerjaan']
                        ]).draw(false);
                    })
                }else{
                    swal.fire({
                        title: xhr['status'] + "(" + xhr['statusText'] + ")",
                        html: xhr['responseText'],
                        type: "error",
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#d63031',
                    })
                }
            }
        })

        $('#ldgMPRCetakPresensiHarianLoading').hide();
    })

    $('#tblMPRPresensiHarianModalKodesieSelected').on('click', '.btnMPRPresensiHarianKodesieUnselect', function(){
        $('#ldgMPRCetakPresensiHarianLoading').show();
        tblMPRPresensiHarianModalKodesieSelected.row(this.closest('tr')).remove().draw();
        $('#ldgMPRCetakPresensiHarianLoading').hide();
    })

    $('#mdlMPRPresensiHarianKodesie').on('shown.bs.modal', function(){
        tblMPRPresensiHarianModalKodesieSelected.columns.adjust();
        $('.chkMPRPresensiHarianKodesie').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
    })

    $('#mdlMPRPresensiHarianKodesie').on('hide.bs.modal', function(){
        var data = tblMPRPresensiHarianModalKodesieSelected.rows().data();
        tblMPRPresensiHarianKodesie.clear().draw();
        data.map(function(value){
            tblMPRPresensiHarianKodesie.row.add([
                value[1],
                value[2],
                value[3],
                value[4],
                value[5],
                value[6]
            ]).draw(false);

        })
    })

    $('#mdlMPRPresensiHarianPekerja').on('shown.bs.modal', function(){
        tblMPRPresensiHarianModalPekerja.columns.adjust();
    })

    $(document).on('click','#btnMPRPresensiHarianModalAddPekerja', function(){
        tblMPRPresensiHarianModalPekerja.row.add([
            '<select class="slcMPRPresensiHarianPekerja" style="width: 100%" data-placeholder="Noind - Nama"></select>',
            '',
            `<button type="button" class="btn btn-danger btnMPRPresensiHarianRemovePekerja">
                <span class="fa fa-trash"></span>
            </button>`
        ]).draw(false);

        $('.slcMPRPresensiHarianPekerja').last().select2({
            searching: true,
            minimumInputLength: 3,
            allowClear: false,
            ajax: {
                url: baseurl + 'MasterPresensi/DataPresensi/CetakPresensiHarian/getPekerja',
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
    })

    $(document).on('change','.slcMPRPresensiHarianPekerja', function(){
        var pekerja = $(this).find('option:selected').html();
        if (pekerja.length > 0) {
            existing = tblMPRPresensiHarianModalPekerja.row(this.closest('tr')).data();
            tblMPRPresensiHarianModalPekerja.row(this.closest('tr')).data([
                pekerja.split(" - ")[0],
                pekerja.split(" - ")[1],
                existing[2]
            ]).draw()
        }
            
    })

    $(document).on('click','.btnMPRPresensiHarianRemovePekerja', function(){
        tblMPRPresensiHarianModalPekerja.row(this.closest('tr')).remove().draw();
    })

    $('#mdlMPRPresensiHarianPekerja').on('hide.bs.modal', function(){
        var data = tblMPRPresensiHarianModalPekerja.rows().data();
        tblMPRPresensiHarianPekerja.clear().draw();
        data.map(function(value,index){
            if (value[0].length > 0 && value[1].length > 0) {
                tblMPRPresensiHarianPekerja.row.add([
                    value[0],
                    value[1]
                ]).draw(false);
            }
        })
    })

    function getCetakPresensiharianParams(){
        statLokasiKerja = $('#chkMPRPresensiHarianLokasiKerja').prop('checked')
        statKodeInduk   = $('#chkMPRPresensiHarianKodeInduk').prop('checked')
        statKodesie     = $('#chkMPRPresensiHarianKodesie').prop('checked')
        statPekerja     = $('#chkMPRPresensiHarianPekerja').prop('checked')

        var tanggal = $('#txtMPRPresensiHarianTanggal').val();
        var params = "tanggal=" + tanggal;
        var error = 0;


        if(statLokasiKerja === true){
            var lokasi_kerja = $('#slcMPRPresensiHarianLokasiKerja').val();
            if (lokasi_kerja !== null && lokasi_kerja.length > 0) {
                params += '&lokasi_kerja=' + lokasi_kerja;
            }else{
                error++;
            }
        }

        if (statKodeInduk === true) {
            var kode_induk = $('#slcMPRPresensiHarianKodeInduk').val();
            if (kode_induk !== null && kode_induk.length >0) {
                params += '&kode_induk=' + kode_induk
            }else{
                error++;
            }
        }

        if (statKodesie === true) {
            var kodesie = tblMPRPresensiHarianKodesie.rows().data();
            if (kodesie !== null && kodesie.length > 0) {
                kodesieParam = "";
                kodesie.map(function(value){
                    if (kodesieParam == "") {
                        kodesieParam = value[0]
                    }else{
                        kodesieParam += "," + value[0]
                    }
                })
                params += '&kodesie=' + kodesieParam
            }else{
                error++
            }
        }

        if (statPekerja === true) {
            var pekerja = tblMPRPresensiHarianPekerja.rows().data();
            if (pekerja !== null && pekerja.length > 0) {
                pekerjaParam = "";
                pekerja.map(function(value){
                    if (pekerjaParam == "") {
                        pekerjaParam = value[0]
                    }else{
                        pekerjaParam += "," + value[0]
                    }
                })
                params += "&noind=" + pekerjaParam
            }else{
                error++
            }
        }

        if(error == 0){
            return params
        }else{
            return false
        }
    }

    $('#btnMPRPresensiHarianPdf').on('click', function(){
        parameter = getCetakPresensiharianParams();
        if(parameter){
            window.open(baseurl + 'MasterPresensi/DataPresensi/CetakPresensiHarian/export_pdf?' + parameter ,'_blank');
        }else{
            swal.fire(
                "Data Tidak Lengkap!",
                "Lengkapi data yang di centang!",
                "warning"
            )
        }
    })

    $('#btnMPRPresensiHarianExcel').on('click', function(){
        parameter = getCetakPresensiharianParams();
        if(parameter){
            window.open(baseurl + 'MasterPresensi/DataPresensi/CetakPresensiHarian/export_excel?' + parameter ,'_blank');
        }else{
            swal.fire(
                "Data Tidak Lengkap!",
                "Lengkapi data yang di centang!",
                "warning"
            )
        }
    })

    $('#btnMPRPresensiHarianExcelView').on('click', function(){
        parameter = getCetakPresensiharianParams();
        if(parameter){
            window.open(baseurl + 'MasterPresensi/DataPresensi/CetakPresensiHarian/view_excel?' + parameter ,'_blank');
        }else{
            swal.fire(
                "Data Tidak Lengkap!",
                "Lengkapi data yang di centang!",
                "warning"
            )
        }
    })

})
// end cetak presensi harian

// start detail presensi
$(document).on('ready', function(){
    $('#txtMPRDetailPresensiPekerjaKeluar').daterangepicker({
        "autoclose": true,
        "todayHiglight": true,
        locale: {
            cancelLabel: 'Clear',
            "format": "YYYY-MM-DD",
            "separator": " - ",
        }
    });

    $('#slcMPRDetailPresensiPeriodeAbsen').daterangepicker({
        "autoclose": true,
        "todayHiglight": true,
        locale: {
            cancelLabel: 'Clear',
            "format": "YYYY-MM-DD",
            "separator": " - ",
        }
    });

    $('#tblMPRDetailPresensiPresensiHarian').DataTable({
        "scrollX": true,
        fixedColumns:   {
            leftColumns: 2
        }
    });

    var tblMPRDetailPresensiJamAbsen = $('#tblMPRDetailPresensiJamAbsen').DataTable();

    $('#slcMPRDetailPresensiJenisPresensi').select2({
        allowClear: false
    });
    $('#slcMPRDetailPresensiJenisTampilan').select2({
        allowClear: false
    });

    $(document).on('ifChecked','#chkMPRDetailPresensiPekerjaKeluar', function(){
        $('#txtMPRDetailPresensiPekerjaKeluar').attr('disabled', false);
    })

    $(document).on('ifUnchecked','#chkMPRDetailPresensiPekerjaKeluar', function(){
        $('#txtMPRDetailPresensiPekerjaKeluar').attr('disabled', true);
    })

    function getDetailPresensiParams(tipe){
        jenisPresensi           = $('#slcMPRDetailPresensiJenisPresensi').val();
        jenisTampilan           = $('#slcMPRDetailPresensiJenisTampilan').val();
        kodeInduk               = $('#slcMPRDetailPresensiKodeInduk').val();
        lokasiKerja             = $('#slcMPRDetailPresensiLokasiKerja').val();
        periodeAbsen            = $('#slcMPRDetailPresensiPeriodeAbsen').val();
        pekerjaKeluar           = $('#chkMPRDetailPresensiPekerjaKeluar').prop('checked');
        periodePekerjaKeluar    = $('#txtMPRDetailPresensiPekerjaKeluar').val();

        kodesie = ""
        dept        =   $('#slcMPRDetailPresensiDepartemen').val()
        bidang      =   $('#slcMPRDetailPresensiBidang').val()
        unit        =   $('#slcMPRDetailPresensiUnit').val()
        seksi       =   $('#slcMPRDetailPresensiSeksi').val()
        pekerjaan   =   $('#slcMPRDetailPresensiPekerjaan').val()
        if (pekerjaan !== null) {
            kodesie = pekerjaan
        }else if(seksi !== null){
            kodesie = seksi
        }else if(unit !== null){
            kodesie = unit
        }else if(bidang !== null){
            kodesie = bidang
        }else if(dept !== null) {
            kodesie = dept
        }
        
        filter = [
            `jenisPresensi=${jenisPresensi}`,
            `jenisTampilan=${jenisTampilan}`,
            `kodeInduk=${kodeInduk}`,
            `lokasiKerja=${lokasiKerja}`,
            `periodeAbsen=${periodeAbsen}`,
            `pekerjaKeluar=${pekerjaKeluar}`,
            `periodePekerjaKeluar=${periodePekerjaKeluar}`,
            `kodesie=${kodesie}`
        ]
        return '?' + filter.join("&");
    }

    $('#slcMPRDetailPresensiJenisPresensi, #slcMPRDetailPresensiJenisTampilan, #slcMPRDetailPresensiKodeInduk, #slcMPRDetailPresensiLokasiKerja, #slcMPRDetailPresensiPeriodeAbsen, #chkMPRDetailPresensiPekerjaKeluar, #txtMPRDetailPresensiPekerjaKeluar').on('change', function(){
        $('#btnMPRDetailPresensiPdf').attr('disabled', true);
        $('#btnMPRDetailPresensiExcel').attr('disabled', true);
    })

    $('#btnMPRDetailPresensiLihat').on('click', function(){
        params = getDetailPresensiParams();
        tblMPRDetailPresensiJamAbsen.clear().draw()
        $('#ldgMPRDetailPresensi').show()
        $.ajax({
            url : baseurl + 'MasterPresensi/DataPresensi/DetailPresensi/getData' + encodeURI(params),
            error: function(xhr,status,error){
                $('#ldgMPRDetailPresensi').hide();
                swal.fire({
                    title: xhr['status'] + "(" + xhr['statusText'] + ")",
                    html: xhr['responseText'],
                    type: "error",
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#d63031',
                })
            },
            success: function(result){
                $('#ldgMPRDetailPresensi').hide();
                if (obj = JSON.parse(result)) {
                    $('#btnMPRDetailPresensiPdf').attr('disabled', false);
                    $('#btnMPRDetailPresensiExcel').attr('disabled', false);
                    $('#tblMPRDetailPresensiPresensiHarian').DataTable().clear().destroy();
                    $('#tblMPRDetailPresensiPresensiHarian thead').html(obj['header'])
                    $('#tblMPRDetailPresensiPresensiHarian tbody').html(obj['body'])
                    $('#tblMPRDetailPresensiPresensiHarian').DataTable({
                        "scrollX": true,
                        paging: false,
                        dom: "Brftip",
                        "scrollY": "400px",
                        fixedColumns:   {
                            leftColumns: 2
                        },
                        buttons: [
                            {
                                text: 'Show Full Page',
                                id: 'btnMPRDetailPresensiFullPage',
                                action: function(){
                                    $('#divMPRDetailPresensiResultKetAbsen').addClass('table-full');
                                    $('#btnMPRDetailPresensiFullPage').hide();
                                    $('#btnMPRDetailPresensiExitFullPage').show();
                                    $('#tblMPRDetailPresensiPresensiHarian').DataTable().columns.adjust();
                                }
                            },
                            {
                                text: 'Exit Full Page',
                                id: 'btnMPRDetailPresensiExitFullPage',
                                action: function(){
                                    $('#divMPRDetailPresensiResultKetAbsen').removeClass('table-full');
                                    $('#btnMPRDetailPresensiFullPage').show();
                                    $('#btnMPRDetailPresensiExitFullPage').hide();
                                    $('#tblMPRDetailPresensiPresensiHarian').DataTable().columns.adjust();
                                }
                            }
                        ]
                    });
                    $('#divMPRDetailPresensiFilter').collapse('hide');
                }else{
                    swal.fire({
                        title: xhr['status'] + "(" + xhr['statusText'] + ")",
                        html: xhr['responseText'],
                        type: "error",
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#d63031',
                    })
                }
            }
        })
    })

    $('#btnMPRDetailPresensiPdf').on('click', function(){
        params = getDetailPresensiParams();
        window.open(baseurl + 'MasterPresensi/DataPresensi/DetailPresensi/getPdf' + encodeURI(params) ,'_blank');
    })
    $('#btnMPRDetailPresensiExcel').on('click', function(){
        params = getDetailPresensiParams();
        window.open(baseurl + 'MasterPresensi/DataPresensi/DetailPresensi/getExcel' + encodeURI(params) ,'_blank');
    })

    $('#tblMPRDetailPresensiPresensiHarian').on('dblclick','tbody tr', function(){
        if($(this).text() != "No data available in table"){
            periode = $(this).find('input').val()
            noind = $(this).find('td:eq(0)').text()
            $('#ldgMPRDetailPresensi').show();
            $.ajax({
                url : baseurl + 'MasterPresensi/DataPresensi/DetailPresensi/getWaktu' + encodeURI('?periode=' + periode + "&noind=" + noind),
                error: function(xhr,status,error){
                    $('#ldgMPRDetailPresensi').hide();
                    swal.fire({
                        title: xhr['status'] + "(" + xhr['statusText'] + ")",
                        html: xhr['responseText'],
                        type: "error",
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#d63031',
                    })
                },
                success: function(result){
                    $('#ldgMPRDetailPresensi').hide();
                    if (obj = JSON.parse(result)) {
                        tblMPRDetailPresensiJamAbsen.clear().draw()
                        obj.map(function(daftar){
                            tblMPRDetailPresensiJamAbsen.row.add([
                                daftar.tanggal,
                                daftar.nama,
                                daftar.waktu
                            ]).draw(false)
                        })
                    }else{
                        swal.fire({
                            title: xhr['status'] + "(" + xhr['statusText'] + ")",
                            html: xhr['responseText'],
                            type: "error",
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#d63031',
                        })
                    }
                }
            })
        }
    })

    $('#slcMPRDetailPresensiDepartemen').select2({
        searching: true,
        allowClear: false,
        ajax: {
            url: baseurl + 'MasterPresensi/DataPresensi/DetailPresensi/getKodesie',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
                return {
                    term: params.term,
                    prev: '',
                    tingkat: 1
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.kode, text: obj.kode + " - " + obj.nama };
                    })
                }
            }
        }
    })

    $('#slcMPRDetailPresensiBidang').select2({
        searching: true,
        allowClear: false,
        ajax: {
            url: baseurl + 'MasterPresensi/DataPresensi/DetailPresensi/getKodesie',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
                return {
                    term: params.term,
                    prev: $('#slcMPRDetailPresensiDepartemen').val(),
                    tingkat: 3
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.kode, text: obj.kode + " - " + obj.nama };
                    })
                }
            }
        }
    })

    $('#slcMPRDetailPresensiLokasiKerja').select2({
        allowClear: false,
    })

    $('#slcMPRDetailPresensiKodeInduk').select2({
        allowClear: false,
    })

    $('#slcMPRDetailPresensiUnit').select2({
        searching: true,
        allowClear: false,
        ajax: {
            url: baseurl + 'MasterPresensi/DataPresensi/DetailPresensi/getKodesie',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
                return {
                    term: params.term,
                    prev: $('#slcMPRDetailPresensiBidang').val(),
                    tingkat: 5
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.kode, text: obj.kode + " - " + obj.nama };
                    })
                }
            }
        }
    })


    $('#slcMPRDetailPresensiSeksi').select2({
        searching: true,
        allowClear: false,
        ajax: {
            url: baseurl + 'MasterPresensi/DataPresensi/DetailPresensi/getKodesie',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
                return {
                    term: params.term,
                    prev: $('#slcMPRDetailPresensiUnit').val(),
                    tingkat: 7
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.kode, text: obj.kode + " - " + obj.nama };
                    })
                }
            }
        }
    })


    $('#slcMPRDetailPresensiPekerjaan').select2({
        searching: true,
        allowClear: false,
        ajax: {
            url: baseurl + 'MasterPresensi/DataPresensi/DetailPresensi/getKodesie',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
                return {
                    term: params.term,
                    prev: $('#slcMPRDetailPresensiSeksi').val(),
                    tingkat: 9
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.kode, text: obj.kode + " - " + obj.nama };
                    })
                }
            }
        }
    })

    $('#slcMPRDetailPresensiDepartemen').on('change', function(){
        text = $(this).find('option:selected').text();
        if (text.includes("Semua")) {
            $('#slcMPRDetailPresensiBidang').attr('disabled', true)
        }else{
            $('#slcMPRDetailPresensiBidang').attr('disabled', false)
            $('#slcMPRDetailPresensiBidang').val("").trigger('change');
        }
        $('#btnMPRDetailPresensiPdf').attr('disabled', true);
        $('#btnMPRDetailPresensiExcel').attr('disabled', true);
    })
    $('#slcMPRDetailPresensiBidang').on('change', function(){
        $('#slcMPRDetailPresensiUnit').val("").trigger('change');
        if ($(this).attr('disabled') || $(this).val() == null) {
            $('#slcMPRDetailPresensiUnit').attr('disabled', true)
        }else{
            text = $(this).find('option:selected').text();
            if (text.includes("Semua") || text.includes("Hanya tingkat")) {
                $('#slcMPRDetailPresensiUnit').attr('disabled', true)
            }else{
                $('#slcMPRDetailPresensiUnit').attr('disabled', false)
            }
        }
        $('#btnMPRDetailPresensiPdf').attr('disabled', true);
        $('#btnMPRDetailPresensiExcel').attr('disabled', true);
    })
    $('#slcMPRDetailPresensiUnit').on('change', function(){
        $('#slcMPRDetailPresensiSeksi').val("").trigger('change');
        if ($(this).attr('disabled') || $(this).val() == null) {
            $('#slcMPRDetailPresensiSeksi').attr('disabled', true)
        }else{
            text = $(this).find('option:selected').text();
            if (text.includes("Semua") || text.includes("Hanya tingkat")) {
                $('#slcMPRDetailPresensiSeksi').attr('disabled', true)
            }else{
                $('#slcMPRDetailPresensiSeksi').attr('disabled', false)
            }
        }
        $('#btnMPRDetailPresensiPdf').attr('disabled', true);
        $('#btnMPRDetailPresensiExcel').attr('disabled', true);
    })
    $('#slcMPRDetailPresensiSeksi').on('change', function(){
        $('#slcMPRDetailPresensiPekerjaan').val("").trigger('change');
        if ($(this).attr('disabled') || $(this).val() == null) {
            $('#slcMPRDetailPresensiPekerjaan').attr('disabled', true)
        }else{
            text = $(this).find('option:selected').text();
            if (text.includes("Semua") || text.includes("Hanya tingkat")) {
                $('#slcMPRDetailPresensiPekerjaan').attr('disabled', true)
            }else{
                $('#slcMPRDetailPresensiPekerjaan').attr('disabled', false)
            }
        }
        $('#btnMPRDetailPresensiPdf').attr('disabled', true);
        $('#btnMPRDetailPresensiExcel').attr('disabled', true);
    })

    $('#btnMPRDetailPresensiCollapsible').on('click',function(){
        $('#divMPRDetailPresensiFilter').collapse('toggle');
    })

    $('#divMPRDetailPresensiFilter').on('show.bs.collapse',function(){
        $('#btnMPRDetailPresensiCollapsible').html("Hide Filter");
    })

    $('#divMPRDetailPresensiFilter').on('hide.bs.collapse',function(){
        $('#btnMPRDetailPresensiCollapsible').html("Show Filter");
    })
})
// end detail presensi

// start presensi hari ini
$(document).on('ready', function(){
    var tblMPRPresensiHariIniDetail = $('#tblMPRPresensiHariIniDetail').DataTable({
        "lengthMenu": [
            [ 5, 10, 25, 50, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "dom" : 'Blfrtip',
        "buttons" : [
            'excel', 'pdf'
        ],      
    });

    $('#tblMPRPresensiHariIniRekap').on('dblclick','td',function(){
        params = $(this).data('params');
        $('#tblMPRPresensiHariIniRekap td').css('background-color','white');
        $('#tblMPRPresensiHariIniRekap td').css('color','black');
        $('[data-params='+params+']').css('background-color','#2196F3');
        $('[data-params='+params+']').css('color','white');
        $('#ldgMPRPresensiHariIniLoading').show();
        $.ajax({
            url: baseurl+'MasterPresensi/DataPresensi/PresensiHariIni/detail/'+params,
            error: function(xhr,status,error){
                $('#ldgMPRPresensiHariIniLoading').hide();
                swal.fire({
                    title: xhr['status'] + "(" + xhr['statusText'] + ")",
                    html: xhr['responseText'],
                    type: "error",
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#d63031',
                })
            },
            success: function(result){
                if(obj = JSON.parse(result)){
                    tblMPRPresensiHariIniDetail.clear().draw();
                    obj.map(function(value,index){
                        tblMPRPresensiHariIniDetail.row.add([
                            (index +1),
                            value['noind'],
                            value['nama'],
                            value['kodesie'],
                            value['shift'],
                            value['waktu'],
                            value['noind_baru']
                        ]).draw(false);

                    })
                    tblMPRPresensiHariIniDetail.columns.adjust();
                }
                $('#ldgMPRPresensiHariIniLoading').hide();
            }
        })
    })
})
// end presensi hari ini