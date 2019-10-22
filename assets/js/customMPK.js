$(document).on('ifChecked', '#fingerYa', function(){
    // alert('oke');
  $('#fingerpindah').prop('hidden', false);
});

$(document).on('ifChecked', '#fingerTidak', function(){
    // alert('oke');
  $('#fingerpindah').prop('hidden', true);
  $('#MasterPekerja-Surat-FingerGanti').each(function () { //added a each loop here
                $(this).val(null).trigger("change");
            });
});

$(document).ready(function() {

    $('#dataTable-MasterLokasi').DataTable({
        dom: 'flrtp',
    });
    $('#dataTable-ReffJamLembur').DataTable({
        dom: 'flrtp',
    });

    $('.select-nama').select2({
        ajax: {
            url: baseurl + "MasterPekerja/Other/pekerja",
            dataType: 'json',
            type: "get",
            data: function(params) {
                return { p: params.term };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            id: item.noind,
                            text: item.noind + ' - ' + item.nama,
                        }
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 2,
        placeholder: 'Select Nama Pekerja',
        allowClear: false,
    });




    $(function() {
        $('#tabel-idcard').DataTable({
            dom: 'frt',
        });
    });

    $('#tbl').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel',
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'A4',
            }
        ],
        // scrollX: true,
        // // scrollY: 400,
        // lengthMenu: [
        //     [10, 25, 50, 100, -1],
        //     [10, 25, 50, 100, "All"]
        // ],
    });

    function SelectNama() {
        var val = $('#NamaPekerja').val();
        if (val) {
            $('#CariPekerja').removeAttr('disabled', 'disabled');
            $('#CariPekerja').removeClass('disabled');
        } else {
            $('#CariPekerja').attr('disabled', 'disabled');
            $('#CariPekerja').addClass('disabled', 'disabled');
        }
    }

    $(document).on('change', '#NamaPekerja', function() {
        SelectNama();
    });

    $(document).on('click', '#CariPekerja', function(e) {
        e.preventDefault();
        var nama = $('#NamaPekerja').val();

        $.ajax({
            url: baseurl + "MasterPekerja/Other/DataIDCard",
            type: "get",
            data: { nama: nama }
        }).done(function(data) {
            var html = '';
            var data = $.parseJSON(data);

            console.log(data['worker']);
            $('tbody#dataIDcard').empty(html);
            for (var i = 0; i < data['worker'].length; i++) {
                html += '<tr>';
                html += '<td>' + (i + 1) + '</td>';
                html += '<td>' + data['worker'][i][0]['no_induk'] + '<input type="hidden" name="noind[]" value="' + data['worker'][i][0]['noind'] + '"></td>';
                html += '<td>' + data['worker'][i][0]['nama'] + '</td>';
                if (data['worker'][i][0]['jabatan'] != null) {
                    html += '<td>' + data['worker'][i][0]['jabatan'] + ' ' + data['worker'][i][0]['seksi'] + '</td>';
                } else {
                    html += '<td>' + data['worker'][i][0]['seksi'] + '</td>';
                }
                html += '<td><a target="_blank" href="' + data['worker'][i][0]['photo'] + '">PHOTO</td>';
                html += '<td><input type="text" style="text-transform:uppercase" data-noind="' + data['worker'][i][0]['noind'] + '" class="form-control" name="nick[]" id="nickname" maxlength="10"></td>'
                html += '</tr>';
            }
            $('tbody#dataIDcard').append(html);
            $('#tampil-data').removeClass('hidden');
            $('#print_card').removeAttr('disabled', false);
            $('#print_card').removeClass('disabled');
        })
    });

});

// 	-------Master Pekerja--------------------------------------------start
$(function() {
    // 	Surat-surat
    // 	{
    //	DateRangePicker
    //	{
    $('.MasterPekerja-daterangepicker').daterangepicker({
        "showDropdowns": true,
        "autoApply": true,
        "locale": {
            "format": "YYYY-MM-DD",
            "separator": " - ",
            "applyLabel": "OK",
            "cancelLabel": "Batal",
            "fromLabel": "Dari",
            "toLabel": "Hingga",
            "customRangeLabel": "Custom",
            "weekLabel": "W",
            "daysOfWeek": [
                "Mg",
                "Sn",
                "Sl",
                "Rb",
                "Km",
                "Jm",
                "Sa"
            ],
            "monthNames": [
                "Januari",
                "Februari",
                "Maret",
                "April",
                "Mei",
                "Juni",
                "Juli",
                "Agustus ",
                "September",
                "Oktober",
                "November",
                "Desember"
            ],
            "firstDay": 1
        }
    }, function(start, end, label) {
        console.log("New date range selected: ' + start.format('YYYY-MM-DD H:i:s') + ' to ' + end.format('YYYY-MM-DD H:i:s') + ' (predefined range: ' + label + ')");
    });

    $('.MasterPekerja-daterangepickersingledate').daterangepicker({
        "singleDatePicker": true,
        "showDropdowns": true,
        "autoApply": true,
        "mask": true,
        "locale": {
            "format": "YYYY-MM-DD",
            "separator": " - ",
            "applyLabel": "OK",
            "cancelLabel": "Batal",
            "fromLabel": "Dari",
            "toLabel": "Hingga",
            "customRangeLabel": "Custom",
            "weekLabel": "W",
            "daysOfWeek": [
                "Mg",
                "Sn",
                "Sl",
                "Rb",
                "Km",
                "Jm",
                "Sa"
            ],
            "monthNames": [
                "Januari",
                "Februari",
                "Maret",
                "April",
                "Mei",
                "Juni",
                "Juli",
                "Agustus ",
                "September",
                "Oktober",
                "November",
                "Desember"
            ],
            "firstDay": 1
        }
    }, function(start, end, label) {
        console.log("New date range selected: ' + start.format('YYYY-MM-DD H:i:s') + ' to ' + end.format('YYYY-MM-DD H:i:s') + ' (predefined range: ' + label + ')");
    });

    $('.MasterPekerja-daterangepickersingledatewithtime').daterangepicker({
        "timePicker": true,
        "timePicker24Hour": true,
        "singleDatePicker": true,
        "showDropdowns": true,
        "autoApply": true,
        "locale": {
            "format": "YYYY-MM-DD HH:mm",
            "separator": " - ",
            "applyLabel": "OK",
            "cancelLabel": "Batal",
            "fromLabel": "Dari",
            "toLabel": "Hingga",
            "customRangeLabel": "Custom",
            "weekLabel": "W",
            "daysOfWeek": [
                "Mg",
                "Sn",
                "Sl",
                "Rb",
                "Km",
                "Jm",
                "Sa"
            ],
            "monthNames": [
                "Januari",
                "Februari",
                "Maret",
                "April",
                "Mei",
                "Juni",
                "Juli",
                "Agustus ",
                "September",
                "Oktober",
                "November",
                "Desember"
            ],
            "firstDay": 1
        }
    }, function(start, end, label) {
        console.log("New date range selected: ' + start.format('YYYY-MM-DD H:i:s') + ' to ' + end.format('YYYY-MM-DD H:i:s') + ' (predefined range: ' + label + ')");
    });
    //	}
    //  select3
    $('.MasterPekerja-PerhitunganPesangon-DaftarPekerja').select2({
        allowClear: false,
        placeholder: "Pilih Pekerja",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + 'MasterPekerja/PerhitunganPesangon/daftar_pekerja_aktif',
            dataType: 'json',
            delay: 500,
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.noind, text: obj.pekerja };
                    })
                };
            }
        }
    });

    $('#MasterPekerja-PerhitunganPesangon-DaftarPekerja').change(function() {
        var noind = $('#MasterPekerja-PerhitunganPesangon-DaftarPekerja').val();
        if (noind) {
            $.ajax({
                type: 'POST',
                data: { noind: noind },
                url: baseurl + "MasterPekerja/PerhitunganPesangon/detailPekerja",
                success: function(result) {
                    var res = JSON.parse(result);
                    $('#txtSeksi').val(res[0]['seksi']);
                    $('#txtUnit').val(res[0]['unit']);
                    $('#txtDepartemen').val(res[0]['departemen']);
                    $('#txtLokasi').val(res[0]['lokasi_kerja']);
                    $('#txtJabatan').val(res[0]['pekerjaan']);
                    $('#txtDiangkat').val(res[0]['diangkat']);
                    $('#txtAlamat').val(res[0]['alamat']);
                    $('#txtLahir').val(res[0]['tempat']);
                    $('#txtMasaKerja').val(res[0]['masakerja']);
                    $('#txtSisaCuti').val(res[0]['sisacuti']);
                    $('#txtProses').val(res[0]['metu']);
                    $('#txtStatus').val(res[0]['alasan']);
                    $('#txtUangPesangon').val(res[0]['pengali']);
                    $('#txtUangUMPK').val(res[0]['upmk']);
                    $('#txtSisaCutiHari').val(res[0]['sisacutihari']);
                    $('#txtUangGantiRugi').val(res[0]['gantirugi']);
                    $('#txtTahun').val(res[0]['masakerja_tahun']);
                    $('#txtBulan').val(res[0]['masakerja_bulan']);
                    $('#txtHari').val(res[0]['masakerja_hari']);
                    $('#txtPasal').val(res[0]['pasal']);
                    $('#txtPesangon').val(res[0]['pesangon']);
                    $('#txtUPMK').val(res[0]['up']);
                    $('#txtCuti').val(res[0]['cuti']);
                    $('#txtRugi').val(res[0]['rugi']);
                    $('#txtAkhir').val(res[0]['akhir']);

                }
            });
        }
    });

    //	Select2
    //	{
    $('#MasterPekerja-Surat-FingerGanti').select2({
         minimumInputLength: 1,
                ajax:
                {
                    url: baseurl + 'MasterPekerja/Surat/finger_reference',
                    dataType: 'json',
                    delay: 500,
                    data: function(params){
                        return {
                            term: params.term
                        }
                    },
                    processResults: function (data){
                        return {
                            results: $.map(data, function(obj){
                                return {id: obj.id_lokasi + ' - ' + obj.device_name, text: obj.id_lokasi + ' - ' + obj.device_name};
                            })
                        }
                    }
                }
            });

    $('#MasterPekerja-Surat-DaftarPekerja').select2({
        allowClear: false,
        placeholder: "Pilih Pekerja",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + 'MasterPekerja/Surat/daftar_pekerja_aktif',
            dataType: 'json',
            delay: 500,
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.noind, text: obj.noind + ' - ' + obj.nama };
                    })
                };
            }
        }
    });

    $('.MasterPekerja-Surat-DaftarPekerja').select2({
        allowClear: false,
        placeholder: "Pilih Pekerja",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + 'MasterPekerja/Surat/daftar_pekerja_aktif',
            dataType: 'json',
            delay: 500,
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.noind, text: obj.noind + ' - ' + obj.nama };
                    })
                };
            }
        }
    });

    $('#MasterPekerja-DaftarSeksi').select2({
        allowClear: false,
        placeholder: "Pilih Seksi",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + 'MasterPekerja/Surat/daftar_seksi',
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
                        return { id: obj.kodesie, text: obj.daftar_tseksi };
                    })
                };
            }
        }
    });

    $('#MasterPekerja-DaftarSeksi').change(function() {
        var kode_seksi = $(this).val();
        var kode_seksi = kode_seksi.substr(0, 7);

        $('#MasterPekerja-DaftarPekerjaan').select2({
            allowClear: false,
            placeholder: "Pilih Pekerjaan",
            ajax: {
                url: baseurl + 'MasterPekerja/Surat/daftar_pekerjaan',
                dataType: 'json',
                delay: 500,
                type: "GET",
                data: function(params) {
                    return {
                        term: params.term,
                        kode_seksi: kode_seksi
                    }
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(obj) {
                            return { id: obj.kdpekerjaan, text: obj.kdpekerjaan + ' - ' + obj.pekerjaan };
                        })
                    };
                }
            }
        });
    });

    $('.MasterPekerja-SuratMutasi-DaftarSeksi').select2({
        allowClear: false,
        placeholder: "Pilih Seksi",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + 'MasterPekerja/Surat/daftar_seksi',
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
                        return { id: obj.kodesie, text: obj.daftar_tseksi };
                    })
                };
            }
        }
    });

    $('.MasterPekerja-SuratMutasi-DaftarSeksi').change(function() {
        var kode_seksi = $(this).val();
        var kode_seksi = kode_seksi.substr(0, 7);

        $('#MasterPekerja-SuratMutasi-DaftarPekerjaan').select2({
            allowClear: true,
            placeholder: "Pilih Pekerjaan",
            ajax: {
                url: baseurl + 'MasterPekerja/Surat/daftar_pekerjaan',
                dataType: 'json',
                delay: 500,
                type: "GET",
                data: function(params) {
                    return {
                        term: params.term,
                        kode_seksi: kode_seksi
                    }
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(obj) {
                            return { id: obj.kdpekerjaan, text: obj.kdpekerjaan + ' - ' + obj.pekerjaan };
                        })
                    };
                }
            }
        });
    });

    $('#MasterPekerja-DaftarGolonganPekerjaan').select2({
        allowClear: false,
        placeholder: 'Pilih Golongan Pekerjaan',
        ajax: {
            url: baseurl + 'MasterPekerja/Surat/SuratMutasi/daftar_golongan_pekerjaan',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term,
                    kode_status_kerja: $('#MasterPekerja-Surat-DaftarPekerja').val().substr(0, 1)
                }

            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.golkerja, text: obj.golkerja };
                    })
                };
            }
        }
    });

    // var a = $('.MasterPekerja-Surat-DaftarPekerja').val();
    // alert(a);
    $('.MasterPekerja-SuratMutasi-DaftarGolongan').select2({
        // alert('a');
        allowClear: true,
        placeholder: 'Pilih Golongan Pekerjaan',
        ajax: {
            url: baseurl + 'MasterPekerja/Surat/daftar_golongan_pekerjaan',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term,
                    kode_status_kerja: $('.MasterPekerja-Surat-DaftarPekerja').val().substr(0, 1)
                }

            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.golkerja, text: obj.golkerja };
                    })
                };
            }
        }
    });

    $('#MasterPekerja-DaftarPekerjaan').select2({
        allowClear: false,
        placeholder: "Pilih Pekerjaan",
        ajax: {
            url: baseurl + 'MasterPekerja/Surat/daftar_pekerjaan',
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
                        return { id: obj.kdpekerjaan, text: obj.kdpekerjaan + ' - ' + obj.pekerjaan };
                    })
                };
            }
        }
    });

    $('.MasterPekerja-SuratMutasi-DaftarPekerjaan').select2({
        allowClear: true,
        placeholder: "Pilih Pekerjaan",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + 'MasterPekerja/Surat/daftar_pekerjaan',
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
                        return { id: obj.kdpekerjaan, text: obj.kdpekerjaan + ' - ' + obj.pekerjaan };
                    })
                };
            }
        }
    });

    $('#MasterPekerja-DaftarKodeJabatan').select2({
        allowClear: false,
        placeholder: "Pilih Kode Jabatan",
        minimumInputLength: 1,
        ajax: {
            url: baseurl + 'MasterPekerja/Surat/daftar_kode_jabatan_kerja',
            dataType: 'json',
            delay: 500,
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.kd_jabatan, text: obj.kd_jabatan + ' - ' + obj.jabatan };
                    })
                };
            }
        }
    });

    $('.MasterPekerja-DaftarKodeJabatan').select2({
        allowClear: false,
        placeholder: "Pilih Kode Jabatan",
        minimumInputLength: 1,
        ajax: {
            url: baseurl + 'MasterPekerja/Surat/daftar_kode_jabatan_kerja',
            dataType: 'json',
            delay: 500,
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.kd_jabatan, text: obj.kd_jabatan + ' - ' + obj.jabatan };
                    })
                };
            }
        }
    });

    $('#MasterPekerja-DaftarLokasiKerja').select2({
        allowClear: false,
        placeholder: "Pilih Lokasi Kerja",
        ajax: {
            url: baseurl + 'MasterPekerja/Surat/daftar_lokasi_kerja',
            dataType: 'json',
            delay: 500,
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.id_ + ' - ' + obj.lokasi_kerja, text: obj.id_ + ' - ' + obj.lokasi_kerja };
                    })
                };
            }
        }
    });

    $('.MasterPekerja-DaftarLokasiKerja').select2({
        allowClear: false,
        placeholder: "Pilih Lokasi Kerja",
        ajax: {
            url: baseurl + 'MasterPekerja/Surat/daftar_lokasi_kerja',
            dataType: 'json',
            delay: 500,
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.id_ + ' - ' + obj.lokasi_kerja, text: obj.id_ + ' - ' + obj.lokasi_kerja };
                    })
                };
            }
        }
    });

    $('.MasterPekerja-DaftarTempatMakan').select2({
        allowClear: false,
        placeholder: "Pilih Tempat Makan",
        ajax: {
            url: baseurl + 'MasterPekerja/Surat/daftar_tempat_makan',
            dataType: 'json',
            delay: 500,
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.fs_tempat_makan, text: obj.fs_tempat_makan };
                    })
                };
            }
        }
    });

    $('#MasterPekerja-BAPSP3-DaftarPekerja').select2({
        allowClear: false,
        placeholder: "Pilih Pekerja",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + 'MasterPekerja/Surat/daftar_pekerja_sp3',
            dataType: 'json',
            delay: 500,
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.noind, text: obj.noind + ' - ' + obj.nama };
                    })
                };
            }
        }
    });

    $('#MasterPekerja-BAPSP3-WakilPerusahaan').select2({
        allowClear: true,
        placeholder: "Pilih Wakil Perusahaan",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + 'MasterPekerja/Surat/daftar_pekerja_aktif',
            dataType: 'json',
            delay: 500,
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.noind, text: obj.noind + ' - ' + obj.nama };
                    })
                };
            }
        }
    });

    $('#MasterPekerja-BAPSP3-TandaTangan1').select2({
        allowClear: true,
        placeholder: "Pilih Pekerja",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + 'MasterPekerja/Surat/daftar_pekerja_aktif',
            dataType: 'json',
            delay: 500,
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.noind, text: obj.noind + ' - ' + obj.nama };
                    })
                };
            }
        }
    });

    $('#MasterPekerja-BAPSP3-TandaTangan2').select2({
        allowClear: true,
        placeholder: "Pilih Pekerja",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + 'MasterPekerja/Surat/daftar_pekerja_aktif',
            dataType: 'json',
            delay: 500,
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.noind, text: obj.noind + ' - ' + obj.nama };
                    })
                };
            }
        }
    });

    // 	Redactor WYSIWYG Text Editor
    // 	{
    $('#MasterPekerja-txtPokokMasalah').redactor();
    $('#MasterPekerja-Surat-txaPreview').redactor();
    $('.MasterPekerja-Surat-txaPreview').redactor();
    $('#MasterPekerja-SuratPerbantuan-txaPreview').redactor();
    $('.MasterPekerja-SuratRotasi-txaPreview').redactor();
    $('.MasterPekerja-SuratUsiaLanjut-txaPreview').redactor();
    $('.MasterPekerja-SuratPromosi-txaPreview').redactor();
    $('#MasterPekerja-Surat-txaFormatSurat').redactor();
    $('#MasterPekerja-SuratDemosi-txaPreview').redactor();
    $('#MasterPekerja-SuratPengangkatanStaf-txaPreview').redactor();
    //	}


    //	}

});


// 	General Function
// 	{
//	Surat-surat
//	{
$('#MasterPekerja-Surat-DaftarPekerja').change(function() {
    var noind = $('#MasterPekerja-Surat-DaftarPekerja').val();
    var kode_status_kerja = noind.substr(0, 1);
    if (noind) {
        $.ajax({
            type: 'POST',
            data: { noind: noind },
            url: baseurl + "MasterPekerja/Surat/detail_pekerja",
            success: function(result) {
                var result = JSON.parse(result);

                $('#MasterPekerja-txtKodesieLama').val(result['kodesie'] + ' - ' + result['posisi']);
                $('#MasterPekerja-txtPekerjaanLama').val(result['kode_pekerjaan'] + ' - ' + result['nama_pekerjaan']);
                $('#MasterPekerja-txtGolonganKerjaLama').val(result['golongan_pekerjaan']);
                $('#MasterPekerja-txtLokasiKerjaLama').val(result['kode_lokasi_kerja'] + ' - ' + result['nama_lokasi_kerja']);
                $('#MasterPekerja-txtKdJabatanLama').val(result['kode_jabatan'] + ' - ' + result['jenis_jabatan']);
                $('#MasterPekerja-txtJabatanLama').val(result['nama_jabatan']);
                $('#MasterPekerja-txtTempatMakan1').val(result['tempat_makan1']);
                $('#MasterPekerja-txtTempatMakan2').val(result['tempat_makan2']);
                $('#MasterPekerja-txtStatusStaf').val(result['status_staf']);
                $('#MasterPekerja-Surat-FingerAwal').val(result['id_lokasifinger'] + ' - ' + result['lokasi_finger']);
            }
        });
        $('#MasterPekerja-DaftarGolonganPekerjaan').select2('val', '');
        $('#MasterPekerja-DaftarGolonganPekerjaan').select2({
            allowClear: false,
            placeholder: 'Pilih Golongan Pekerjaan',
            ajax: {
                url: baseurl + 'MasterPekerja/Surat/daftar_golongan_pekerjaan',
                dataType: 'json',
                data: function(params) {
                    return {
                        term: params.term,
                        kode_status_kerja: kode_status_kerja
                    }
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(obj) {
                            return { id: obj.golkerja, text: obj.golkerja };
                        })
                    };
                }
            }
        });
    } else {
        $('#kodesieLama').select2();
        $('#MasterPekerja-DaftarGolonganPekerjaan').select2('val', '');
    }
});

$('.MasterPekerja-Surat-DaftarPekerja').change(function() {
    var noind = $('.MasterPekerja-Surat-DaftarPekerja').val();
    var kode_status_kerja = noind.substr(0, 1);
    if (noind) {
        $.ajax({
            type: 'POST',
            data: { noind: noind },
            url: baseurl + "MasterPekerja/Surat/detail_pekerja",
            success: function(result) {
                var result = JSON.parse(result);

                $('.MasterPekerja-txtKodesieLama').val(result['kodesie'] + ' - ' + result['posisi']);
                $('.MasterPekerja-txtPekerjaanLama').val(result['kode_pekerjaan'] + ' - ' + result['nama_pekerjaan']);
                $('.MasterPekerja-txtGolonganKerjaLama').val(result['golongan_pekerjaan']);
                $('.MasterPekerja-txtLokasiKerjaLama').val(result['kode_lokasi_kerja'] + ' - ' + result['nama_lokasi_kerja']);
                $('.MasterPekerja-txtKdJabatanLama').val(result['kode_jabatan'] + ' - ' + result['jenis_jabatan']);
                $('.MasterPekerja-txtJabatanLama').val(result['nama_jabatan']);
                $('.MasterPekerja-txtTempatMakan1').val(result['tempat_makan1']);
                $('.MasterPekerja-txtTempatMakan2').val(result['tempat_makan2']);
                $('.MasterPekerja-txtStatusStaf').val(result['status_staf']);
                $('#MasterPekerja-Surat-FingerAwal').val(result['id_lokasifinger'] + ' - ' + result['lokasi_finger']);
            }
        });
        $('.MasterPekerja-SuratMutasi-DaftarGolongan').select2('val', '');
        $('.MasterPekerja-SuratMutasi-DaftarGolongan').select2({
            allowClear: true,
            placeholder: 'Pilih Golongan Pekerjaan',
            ajax: {
                url: baseurl + 'MasterPekerja/Surat/daftar_golongan_pekerjaan',
                dataType: 'json',
                data: function(params) {
                    return {
                        term: params.term,
                        kode_status_kerja: kode_status_kerja
                    }
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(obj) {
                            return { id: obj.golkerja, text: obj.golkerja };
                        })
                    };
                }
            }
        });
    } else {
        $('#kodesieLama').select2();
        $('.MasterPekerja-SuratMutasi-DaftarGolongan').select2('val', '');
    }
});


$('#MasterPekerja-Surat-btnPreview').click(function() {
    // alert($('#MasterPekerja-txtLokasiKerjaLama').val());
    $('#surat-loading').attr('hidden', false);
    $(document).ajaxStop(function() {
        $('#surat-loading').attr('hidden', true);
    });
    $.ajax({
        type: 'POST',
        data: $('#MasterPekerja-FormCreate').serialize(),
        url: baseurl + "MasterPekerja/Surat/SuratMutasi/prosesPreviewMutasi",
        success: function(result) {
            var result = JSON.parse(result);
            console.log(result);

            /*CKEDITOR.instances['MasterPekerja-Surat-txaPreview'].setData(result['preview']);*/
            $('.MasterPekerja-Surat-txaPreview').redactor('set', result['preview']);
            $('#MasterPekerja-Surat-txtNomorSurat').val(result['nomor_surat']);
            $('#MasterPekerja-Surat-txtHalSurat').val(result['hal_surat']);
            $('#MasterPekerja-Surat-txtKodeSurat').val(result['kode_surat']);
        }
    });

});

$('#MasterPekerja-SuratDemosi-btnPreview').click(function() {
    $('#surat-loading').attr('hidden', false);
    $(document).ajaxStop(function() {
        $('#surat-loading').attr('hidden', true);
    });
    $.ajax({
        type: 'POST',
        data: $('#MasterPekerja-SuratDemosi-FormCreate').serialize(),
        url: baseurl + "MasterPekerja/Surat/SuratDemosi/prosesPreviewDemosi",
        success: function(result) {
            var result = JSON.parse(result);
            console.log(result);

            // CKEDITOR.instances['MasterPekerja-SuratDemosi-txaPreview'].setData(result['preview']);
            $('#MasterPekerja-SuratDemosi-txaPreview').redactor('set', result['preview']);
            $('#MasterPekerja-SuratDemosi-txtNomorSurat').val(result['nomorSurat']);
            $('#MasterPekerja-SuratDemosi-txtHalSurat').val(result['halSurat']);
            $('#MasterPekerja-SuratDemosi-txtKodeSurat').val(result['kodeSurat']);
        }
    });

});

$('#MasterPekerja-SuratPromosi-btnPreview').click(function() {
    $('#surat-loading').attr('hidden', false);
    $(document).ajaxStop(function() {
        $('#surat-loading').attr('hidden', true);
    });
    $.ajax({
        type: 'POST',
        data: $('#MasterPekerja-SuratPromosi-FormCreate').serialize(),
        url: baseurl + "MasterPekerja/Surat/SuratPromosi/prosesPreviewPromosi",
        success: function(result) {
            var result = JSON.parse(result);
            console.log(result);

            // CKEDITOR.instances['MasterPekerja-SuratPromosi-txaPreview'].setData(result['preview']);
            $('.MasterPekerja-SuratPromosi-txaPreview').redactor('set', result['preview']);
            $('#MasterPekerja-SuratPromosi-txtNomorSurat').val('val', '');
            $('#MasterPekerja-SuratPromosi-txtNomorSurat').val(result['nomorSurat']);
            $('#MasterPekerja-SuratPromosi-txtHalSurat').val(result['halSurat']);
            $('#MasterPekerja-SuratPromosi-txtKodeSurat').val(result['kodeSurat']);
        }
    });

});
//    $('#MasterPekerja-DaftarGolonganPekerjaan').select2({
//     allowClear: false,
//     placeholder: 'Pilih Golongan Pekerjaan',
//     ajax:
//     {
// 		url: baseurl+"MasterPekerja/Surat/SuratMutasi/cariGolonganPekerjaan",
// 		dataType: 'json',
// 		data: function (params){
// 			return {
// 				term: params.term,
// 				kode_status_kerja: $('#MasterPekerja-Surat-DaftarPekerja').val().substr(0, 1)
// 			}
// 		},
// 		processResults: function(data) {
// 			return {
// 				results: $.map(data, function(obj){
// 					return {id: obj.golkerja, text: obj.golkerja};
// 				})
// 			};
// 		}
// 	}
// });

$('.MasterPekerja-SuratPerbantuan-btnPreview').click(function() {
    $('#surat-loading').attr('hidden', false);
    $(document).ajaxStop(function() {
        $('#surat-loading').attr('hidden', true);
    });
    // alert('a');
    $.ajax({
        type: 'POST',
        data: $('#MasterPekerja-SuratPerbantuan-FormCreate').serialize(),
        url: baseurl + "MasterPekerja/Surat/SuratPerbantuan/prosesPreviewPerbantuan",
        success: function(result) {
            var result = JSON.parse(result);
            console.log(result);

            // CKEDITOR.instances['MasterPekerja-SuratPerbantuan-txaPreview'].setData(result['preview']);
            $('#MasterPekerja-SuratPerbantuan-txaPreview').redactor('set', result['preview']);
            $('#MasterPekerja-SuratPerbantuan-txtNomorSurat').val(result['nomorSurat']);
            $('#MasterPekerja-SuratPerbantuan-txtHalSurat').val(result['halSurat']);
            $('#MasterPekerja-SuratPerbantuan-txtKodeSurat').val(result['kodeSurat']);
        }
    });
});



$('.MasterPekerja-SuratRotasi-btnPreview').click(function() {
    $('#surat-loading').attr('hidden', false);
    $(document).ajaxStop(function() {
        $('#surat-loading').attr('hidden', true);
    });
    // var a = $('.MasterPekerja-Surat-DaftarPekerja').val(); alert(a);
    $.ajax({
        type: 'POST',
        data: $('#MasterPekerja-SuratRotasi-FormCreate').serialize(),
        url: baseurl + "MasterPekerja/Surat/SuratRotasi/prosesPreviewRotasi",
        success: function(result) {
            var result = JSON.parse(result);
            console.log(result);

            // CKEDITOR.instances['MasterPekerja-SuratRotasi-txaPreview'].setData(result['preview']);
            $('.MasterPekerja-SuratRotasi-txaPreview').redactor('set', result['preview']);
            $('.MasterPekerja-SuratMutasi-txtNomorSurat').val(result['nomorSurat']);
            $('.MasterPekerja-SuratMutasi-txtHalSurat').val(result['halSurat']);
            $('.MasterPekerja-SuratMutasi-txtKodeSurat').val(result['kodeSurat']);
        }
    });

});

$('.MasterPekerja-SuratUsiaLanjut-btnPreview').click(function() {
    $('#surat-loading').attr('hidden', false);
    $(document).ajaxStop(function() {
        $('#surat-loading').attr('hidden', true);
    });
    // var a = $('.MasterPekerja-Surat-DaftarPekerja').val(); alert(a);
    $.ajax({
        type: 'POST',
        data: $('#MasterPekerja-SuratUsiaLanjut-FormCreate').serialize(),
        url: baseurl + "MasterPekerja/Surat/SuratUsiaLanjut/prosesPreviewUsiaLanjut",
        success: function(result) {
            var result = JSON.parse(result);
            console.log(result);

            // CKEDITOR.instances['MasterPekerja-SuratRotasi-txaPreview'].setData(result['preview']);
            $('.MasterPekerja-SuratUsiaLanjut-txaPreview').redactor('set', result['preview']);
            // $('.MasterPekerja-SuratUsiaLanjut-txtNomorSurat').val(result['nomorSurat']);
            // $('.MasterPekerja-SuratUsiaLanjut-txtHalSurat').val(result['halSurat']);
        }
    });

});

$('#MasterPekerja-SuratPengangkatanStaf-btnPreview').click(function() {
    $('#surat-loading').attr('hidden', false);
    $(document).ajaxStop(function() {
        $('#surat-loading').attr('hidden', true);
    });
    $.ajax({
        type: 'POST',
        data: $('#MasterPekerja-SuratPengangkatanStaff-FormCreate').serialize(),
        url: baseurl + "MasterPekerja/Surat/SuratPengangkatanStaff/prosesPreviewPengangkatan",
        success: function(result) {
            var result = JSON.parse(result);
            console.log(result);

            // CKEDITOR.instances['MasterPekerja-SuratPengangkatan-txaPreview'].setData(result['preview']);
            $('#MasterPekerja-SuratPengangkatanStaf-txaPreview').redactor('set', result['preview']);
            $('.MasterPekerja-SuratMutasi-txtNomorSurat').val(result['nomorSurat']);
            $('.MasterPekerja-SuratMutasi-txtHalSurat').val(result['halSurat']);
            $('.MasterPekerja-SuratMutasi-txtKodeSurat').val(result['kodeSurat']);
        }
    });

});

$('#MasterPekerja-BAPSP3-btnPreview').click(function() {
    if ($('#MasterPekerja-BAPSP3-DaftarPekerja').val() == '') { $.toaster('Mohon isi nomor induk pekerja', '', 'danger'); return; }
    $('#surat-loading').attr('hidden', false);
    $.ajax({
        async: true,
        type: 'POST',
        data: $('#MasterPekerja-FormCreate').serialize(),
        url: baseurl + "MasterPekerja/Surat/BAPSP3/prosesPreviewBAPSP3",
        success: function(response) {
            try {
                response = JSON.parse(response);
                $('#MasterPekerja-Surat-txaPreview').redactor('set', response['preview']);
            } catch (e) {
                console.error(e);
                $.toaster('Terjadi kesalahan saat memuat preview', '', 'danger');
            }
            $('#surat-loading').attr('hidden', true);
        },
        error: function(response) {
            console.error(response.status);
            $.toaster('Terjadi kesalahan saat memuat preview', '', 'danger');
            $('#surat-loading').attr('hidden', true);
        }
    });

});

$('#MasterPekerja-BAPSP3-DaftarPekerja').change(function() {
    var noind = $('#MasterPekerja-BAPSP3-DaftarPekerja').val();
    if (noind) {
        $.ajax({
            type: 'POST',
            data: { noind: noind },
            url: baseurl + "MasterPekerja/Surat/detail_pekerja",
            success: function(result) {
                var result = JSON.parse(result);
                $('#MasterPekerja-txtAlamatPekerja').val(result['alamat']);
                $('#MasterPekerja-txtCustomJabatan').val(result['custom_jabatan']);
                $('#MasterPekerja-txtNamaPerusahaan').val(result['nama_perusahaan']);
                $('#MasterPekerja-txtAlamatPerusahaan').val(result['alamat_perusahaan']);
            }
        });
    }
});

//	}

// 	}
// 	-------Master Pekerja----------------------------------------------end

// alert(top.location.pathname);
$(document).ready(function() {
    $('.jabatan').change(function() {
        var kd = $('.mpk-kdbaru').val();
        // alert(kd);
        var job = $('.kerja').val();
        var teks = $('.jabatan').val();
        var isi = $('.setjabatan').val().length;
        // if (isi < 1) {
        $.post(baseurl + "MasterPekerja/Surat/SuratDemosi/jabatan", {
                name: teks,
                job: job,
                kd: kd
            },
            function(data, status) {
                // alert(data.trim());
                $('.setjabatan').val(data.trim().toUpperCase());
            });
        // }
    });
    $('.mpk-kdbaru').change(function() {
        var kd = $('.mpk-kdbaru').val();
        // alert(kd);
        var job = $('.kerja').val();
        var teks = $('.jabatan').val();
        var isi = $('.setjabatan').val().length;
        // if (isi < 1) {
        $.post(baseurl + "MasterPekerja/Surat/SuratDemosi/jabatan", {
                name: teks,
                job: job,
                kd: kd
            },
            function(data, status) {
                // alert(data.trim());
                $('.setjabatan').val(data.trim().toUpperCase());
            });
        // }
    });
});
//-------------------------------------pengangkatan-----------------------------
$(document).ready(function() {
    var st = $('.stafStatus').val();
    if (st == '1') {
        st = 'daftar_pekerja_pengangkatan_non';
    } else {
        st = 'daftar_pekerja_pengangkatan';
    }
    $('.MasterPekerja-Surat-DaftarPekerja-staf').select2({
        allowClear: false,
        placeholder: "Pilih Pekerja",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + 'MasterPekerja/Surat/' + st,
            dataType: 'json',
            delay: 500,
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.noind, text: obj.noind + ' - ' + obj.nama };
                    })
                };
            }
        }
    });

    $('.MasterPekerja-Surat-DaftarPekerja-staf-pengangkatan').select2({
        allowClear: false,
        placeholder: "Pilih Pekerja",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + 'MasterPekerja/Surat/' + st,
            dataType: 'json',
            delay: 500,
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.noind, text: obj.noind + ' - ' + obj.nama };
                    })
                };
            }
        }
    });
});
$('.MasterPekerja-Surat-DaftarPekerja-staf').change(function() {
    var noind = $('.MasterPekerja-Surat-DaftarPekerja-staf').val();
    var kode_status_kerja = noind.substr(0, 1);
    if (noind) {
        $.ajax({
            type: 'POST',
            data: { noind: noind },
            url: baseurl + "MasterPekerja/Surat/detail_pekerja",
            success: function(result) {
                var result = JSON.parse(result);

                $('.MasterPekerja-txtKodesieLama').val(result['kodesie'] + ' - ' + result['posisi']);
                $('.MasterPekerja-txtPekerjaanLama').val(result['kode_pekerjaan'] + ' - ' + result['nama_pekerjaan']);
                $('.MasterPekerja-txtGolonganKerjaLama').val(result['golongan_pekerjaan']);
                $('.MasterPekerja-txtLokasiKerjaLama').val(result['kode_lokasi_kerja'] + ' - ' + result['nama_lokasi_kerja']);
                $('.MasterPekerja-txtKdJabatanLama').val(result['kode_jabatan'] + ' - ' + result['jenis_jabatan']);
                $('.MasterPekerja-txtJabatanLama').val(result['nama_jabatan']);
                $('.MasterPekerja-txtTempatMakan1').val(result['tempat_makan1']);
                $('.MasterPekerja-txtTempatMakan2').val(result['tempat_makan2']);
                $('.MasterPekerja-txtStatusStaf').val(result['status_staf']);
            }
        });
        $('.MasterPekerja-SuratMutasi-DaftarGolongan').select2('val', '');
        $('.MasterPekerja-SuratMutasi-DaftarGolongan').select2({
            allowClear: true,
            placeholder: 'Pilih Golongan Pekerjaan',
            ajax: {
                url: baseurl + 'MasterPekerja/Surat/daftar_golongan_pekerjaan',
                dataType: 'json',
                data: function(params) {
                    return {
                        term: params.term,
                        kode_status_kerja: kode_status_kerja
                    }
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(obj) {
                            return { id: obj.golkerja, text: obj.golkerja };
                        })
                    };
                }
            }
        });
    } else {
        $('#kodesieLama').select2();
        $('.MasterPekerja-SuratMutasi-DaftarGolongan').select2('val', '');
    }
});

$('.MasterPekerja-Surat-DaftarPekerja-staf-pengangkatan').change(function() {
    var noind = $('.MasterPekerja-Surat-DaftarPekerja-staf-pengangkatan').val();
    var kode_status_kerja = noind.substr(0, 1);
    if (noind) {
        $.ajax({
            type: 'POST',
            data: { noind: noind },
            url: baseurl + "MasterPekerja/Surat/detail_pekerja",
            success: function(result) {
                var result = JSON.parse(result);
                // alert(result);

                $('.MasterPekerja-txtKodesieLama').val(result['kodesie'] + ' - ' + result['posisi']);
                $('.MasterPekerja-txtPekerjaanLama').val(result['kode_pekerjaan'] + ' - ' + result['nama_pekerjaan']);
                $('.MasterPekerja-txtGolonganKerjaLama').val(result['golongan_pekerjaan']);
                $('.MasterPekerja-txtLokasiKerjaLama').val(result['kode_lokasi_kerja'] + ' - ' + result['nama_lokasi_kerja']);
                $('.MasterPekerja-txtKdJabatanLama').val(result['kode_jabatan'] + ' - ' + result['jenis_jabatan']);
                $('.MasterPekerja-txtJabatanLama').val(result['nama_jabatan']);
                $('.MasterPekerja-txtTempatMakan1').val(result['tempat_makan1']);
                $('.MasterPekerja-txtTempatMakan2').val(result['tempat_makan2']);
                $('.MasterPekerja-txtStatusStaf').val(result['status_staf']);
                $('.MasterPekerja-txtjabatanDlLama').val(result['jabatan_dl']);
                $('#MasterPekerja-Surat-FingerAwal').val(result['id_lokasifinger'] + ' - ' + result['lokasi_finger']);
                // alert(result);
            }
        });
        $('.MasterPekerja-SuratMutasi-DaftarGolongan').select2('val', '');
        $('.MasterPekerja-SuratMutasi-DaftarGolongan').select2({
            allowClear: true,
            placeholder: 'Pilih Golongan Pekerjaan',
            ajax: {
                url: baseurl + 'MasterPekerja/Surat/daftar_golongan_pekerjaan',
                dataType: 'json',
                data: function(params) {
                    return {
                        term: params.term,
                        kode_status_kerja: kode_status_kerja
                    }
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(obj) {
                            return { id: obj.golkerja, text: obj.golkerja };
                        })
                    };
                }
            }
        });
    } else {
        $('#kodesieLama').select2();
        $('.MasterPekerja-SuratMutasi-DaftarGolongan').select2('val', '');
    }
});

$(function() {
    $('#MasterPekerja-txtPokokMasalah').redactor('set', "Sdr. 	<strong>[nama_pekerja] ([noind_pekerja]) </strong>mendapat 	Surat Peringatan Ke-3 yang berlaku sejak tanggal <strong>[tgl_berlaku_mulai] sampai dengan tanggal [tgl_berlaku_selesai]&nbsp;</strong>sehingga 	berdasarkan Perjanjian Kerja Bersama CV. Karya Hidup Sentosa dan 	Pasal 161 (1) UU No 13 Tahun 2003 tentang Ketenagakerjaan, apabila 	yang bersangkutan melakukan pelanggaran kembali terhadap Perjanjian 	Kerja Bersama selama berlakunya Surat Peringatan Ke-3 tersebut, maka 	perusahaan akan melakukan Pemutusan Hubungan Kerja.");
    $(document).on('change', '.noind', function(event) {
        var isi = $('.noind').val();
        if (isi.substring(0, 1) == 'J') {
            $('.MasterPekerja-txtNoindBaru').val(isi);
            $('.MasterPekerja-txtNoindBaru').attr('readonly', true);
        } else {
            $('.MasterPekerja-txtNoindBaru').val('');
            $('.MasterPekerja-txtNoindBaru').attr('readonly', false);
        }
    });
    if ($('select').hasClass('golker')) {
        // alert(top.location.pathname);
        var noind = $('.golker').val();
        var kode_status_kerja = noind.substr(0, 1);
        $('.MasterPekerja-SuratMutasi-DaftarGolongan').select2({
            allowClear: true,
            placeholder: 'Pilih Golongan Pekerjaan',
            ajax: {
                url: baseurl + 'MasterPekerja/Surat/daftar_golongan_pekerjaan',
                dataType: 'json',
                data: function(params) {
                    return {
                        term: params.term,
                        kode_status_kerja: kode_status_kerja
                    }
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(obj) {
                            return { id: obj.golkerja, text: obj.golkerja };
                        })
                    };
                }
            }
        });
    } else {
        // alert('a');
    }
});

$(document).ready(function() {
    $('#Saksi_Janji1').select2({
      placeholder:"Input Nama Saksi"
    });

    $('#Saksi_Janji2').select2({
      placeholder:"Input Nama Saksi"
    });

    $('#Saksi_Janji3').select2({
      placeholder:"Input Nama Saksi"
    });

    $('#usialanjut').DataTable();
});


$(document).on('ready', function() {
    $('.setupPekerjaan-cmbDepartemen').select2({
        minimumResultsForSearch: -1,
        allowClear: false,
        ajax: {
            url: baseurl + 'MasterPekerja/SetupPekerjaan/daftarDepartemen',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        // if (obj.kode_departemen == '2') {
                        // 	return {id: obj.kode_departemen, text: obj.nama_departemen, disabled: true};
                        // }
                        return { id: obj.kode_departemen, text: obj.nama_departemen };
                    })
                }
            }
        }
    });

    $(document).on('change', '.setupPekerjaan-cmbDepartemen', function() {
        var departemen = $(this).val();
        // alert(departemen);
        if (departemen == '0') {
            $('.setupPekerjaan-cmbBidang').each(function() { //added a each loop here
                $(this).select2('destroy').val("").select2();
            });
            $('.setupPekerjaan-cmbUnit').each(function() { //added a each loop here
                $(this).select2('destroy').val("").select2();
            });
            $('.setupPekerjaan-cmbSeksi').each(function() { //added a each loop here
                $(this).select2('destroy').val("").select2();
            });

            $('.setupPekerjaan-cmbBidang').attr('disabled', 'true');
            $('.setupPekerjaan-cmbUnit').attr('disabled', 'true');
            $('.setupPekerjaan-cmbSeksi').attr('disabled', 'true');
        } else {
            $('.setupPekerjaan-cmbBidang').each(function() { //added a each loop here
                $(this).select2('destroy').val("").select2();
            });
            $('.setupPekerjaan-cmbUnit').each(function() { //added a each loop here
                $(this).select2('destroy').val("").select2();
            });
            $('.setupPekerjaan-cmbSeksi').each(function() { //added a each loop here
                $(this).select2('destroy').val("").select2();
            });

            $('.setupPekerjaan-cmbBidang').removeAttr('disabled');
            $('.setupPekerjaan-cmbUnit').removeAttr('disabled');
            $('.setupPekerjaan-cmbSeksi').removeAttr('disabled');

            $('.setupPekerjaan-cmbBidang').select2({
                minimumResultsForSearch: -1,
                ajax: {
                    url: baseurl + 'MasterPekerja/SetupPekerjaan/daftarBidang',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term,
                            departemen: departemen
                        }
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(obj) {
                                return { id: obj.kode_bidang, text: obj.nama_bidang };
                            })
                        }
                    }
                }
            });
            $.ajax({
                data: { kodesie: departemen },
                url: baseurl + 'MasterPekerja/SetupPekerjaan/getKodePekerjaan',
                type: 'POST',
                success: function(data) {
                    $('#txtKodeUrut').val(data);
                }
            });
        }
    });

    $(document).on('change', '.setupPekerjaan-cmbBidang', function() {
        var bidang = $(this).val();

        if (bidang.substr(bidang.length - 2) == '00') {
            $('.setupPekerjaan-cmbUnit').each(function() { //added a each loop here
                $(this).select2('destroy').val("").select2();
            });
            $('.setupPekerjaan-cmbSeksi').each(function() { //added a each loop here
                $(this).select2('destroy').val("").select2();
            });

            $('.setupPekerjaan-cmbUnit').attr('disabled', 'true');
            $('.setupPekerjaan-cmbSeksi').attr('disabled', 'true');
        } else {
            $('.setupPekerjaan-cmbUnit').each(function() { //added a each loop here
                $(this).select2('destroy').val("").select2();
            });
            $('.setupPekerjaan-cmbSeksi').each(function() { //added a each loop here
                $(this).select2('destroy').val("").select2();
            });

            $('.setupPekerjaan-cmbUnit').removeAttr('disabled');
            $('.setupPekerjaan-cmbSeksi').removeAttr('disabled');

            $('.setupPekerjaan-cmbUnit').select2({
                minimumResultsForSearch: -1,
                ajax: {
                    url: baseurl + 'MasterPekerja/SetupPekerjaan/daftarUnit',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term,
                            bidang: bidang
                        }
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(obj) {
                                return { id: obj.kode_unit, text: obj.nama_unit };
                            })
                        }
                    }
                }
            });
            $.ajax({
                data: { kodesie: bidang },
                url: baseurl + 'MasterPekerja/SetupPekerjaan/getKodePekerjaan',
                type: 'POST',
                success: function(data) {
                    $('#txtKodeUrut').val(data);
                }
            });
        }
    });

    $(document).on('change', '.setupPekerjaan-cmbUnit', function() {
        var unit = $(this).val();

        if (unit.substr(unit.length - 2) == '00') {
            $('.setupPekerjaan-cmbSeksi').each(function() { //added a each loop here
                $(this).select2('destroy').val("").select2();
            });

            $('.setupPekerjaan-cmbSeksi').attr('disabled', 'true');
        } else {
            $('.setupPekerjaan-cmbSeksi').each(function() { //added a each loop here
                $(this).select2('destroy').val("").select2();
            });

            $('.setupPekerjaan-cmbSeksi').removeAttr('disabled');

            $('.setupPekerjaan-cmbSeksi').select2({
                minimumResultsForSearch: -1,
                ajax: {
                    url: baseurl + 'MasterPekerja/SetupPekerjaan/daftarSeksi',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term,
                            unit: unit
                        }
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(obj) {

                                return { id: obj.kode_seksi, text: obj.nama_seksi };
                            })
                        }
                    }
                }
            });

            $.ajax({
                data: { kodesie: unit },
                url: baseurl + 'MasterPekerja/SetupPekerjaan/getKodePekerjaan',
                type: 'POST',
                success: function(data) {
                    $('#txtKodeUrut').val(data);
                }
            });
        }
    });

    $(document).on('change', '.setupPekerjaan-cmbSeksi', function() {
        var unit = $(this).val();
        $.ajax({
            data: { kodesie: unit },
            url: baseurl + 'MasterPekerja/SetupPekerjaan/getKodePekerjaan',
            type: 'POST',
            success: function(data) {
                $('#txtKodeUrut').val(data);
            }
        });
    });
})

$('.nyobaaja').click(function() {
  $('#id_sangu').val($(this).attr('value'));
});

$('#perjanjianPHK').click(function(){
  let saksi1      = $('#Saksi_Janji1').val(),
      saksi2      = $('#Saksi_Janji2').val()

  if (saksi1 === null || saksi1 == '') {
    Swal.fire(
      'Peringatan!',
      'Saksi 1 Harus Di Input!',
      'warning'
    )
  }else {
    $("#Modal_Hadirin_Perjanjian").modal('hide');
  }
});

$('#form_cetak_sangu').submit(function(e){
	e.preventDefault();
	a = $('#id_modal_cetak_sangu').val();
	this.submit()
	setTimeout(function(){
		window.open(a, '_self');
	}), 100 ;

});
