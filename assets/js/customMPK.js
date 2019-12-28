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

    $('#MP_GajiCutoff').DataTable({

    });
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

    //Untuk Rekap Perizinan Dinas
    $('#PD_Cari').on('click', function () {
        let tanggal = $('#periodeRekap').val()
        let jenis = $("input:radio[class=RD_radioDinas]:checked").val()
        var loading = baseurl + 'assets/img/gif/loadingquick.gif';
        console.log(jenis);

        if (jenis == '' || jenis == null) {
            swal.fire({
                title: 'Peringatan',
                text: 'Harap Memilih Jenis Rekap !',
                type: 'warning',
                allowOutsideClick: false
            })
        }else {
            $.ajax({
                type: 'POST',
                data:{
                    periodeRekap: tanggal,
                    jenis: jenis
                },
                url: baseurl + 'MasterPekerja/RekapPerizinanDinas/rekapbulanan',
                beforeSend: function () {
                    swal.fire({
                        html : "<img style='width: 320px; height: auto;'src='"+loading+"'>",
                        text : 'Loading...',
                        customClass: 'swal-wide',
                        showConfirmButton:false,
                        allowOutsideClick: false
                    })
                },
                success: function (result) {
                    swal.close()
                    $('#areaRekapIzin').html(result)

                    $('.tabel_rekap').DataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'excel', 'pdf'
                        ],
                        scrollX: true,
                        fixedColumns:{
                            leftColumns:4
                        }
                    });
                }
            })
        }
    })

    $('.tabel_izin').DataTable({
         "ordering" : false,
         "paging" : false,
         "searching": false
       });

     $("input.periodeRekap").daterangepicker({
       autoUpdateInput: false,
       locale: {
           cancelLabel: 'Clear'
       }
     });


     $('input.periodeRekap').on('apply.daterangepicker', function(ev, picker) {
       $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
     });

     $('input.periodeRekap').on('cancel.daterangepicker', function(ev, picker) {
         $(this).val('');
     });
  //Selesai

});

// 	-------Master Pekerja--------------------------------------------start
$(function() {
    // 	Surat-surat
    // 	{
    //	DateRangePicker
    //	{

    $('.monthpickerq').monthpicker({
      Button: false ,
      dateFormat: "MM yy"
    });

    $('.monthpickerq1').monthpicker({
      Button: false ,
      dateFormat: "MM yy"
    });

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
                    $('#txtNPWP').val(res[0]['npwp']);
                    $('#txtNIK').val(res[0]['nik']);

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

        $('#MasterPekerja-txtStatusjabatanBaru').select2({
         allowClear: false,
         placeholder: "Pilih Status Jabatan Upah",
         ajax: {
             url: baseurl + 'MasterPekerja/Surat/daftar_nama_status',
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
                         return { id: obj.kd_status+ " - "+obj.nama_status, text: obj.kd_status+ " - "+obj.nama_status };
                     })
                 };
             }
         }
    });

        $('#MasterPekerja-txtNamaJabatanUpahBaru').select2({
         allowClear: false,
         placeholder: "Pilih Nama Jabatan Upah Baru",
         ajax: {
             url: baseurl + 'MasterPekerja/Surat/daftar_nama_jabatan_upah',
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
                         return { id: obj.nama_jabatan, text: obj.nama_jabatan };
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
        allowClear: true,
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
    $('.preview-Lapkun').redactor();

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
                console.log(result);
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
                $('#MasterPekerja-txtStatusJabatanlama').val(result['kd_status']+ " - " +result['nama_status']);
                $('#MasterPekerja-txtNamaJabatanUpahlama').val(result['nama_jabatan_upah']);
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
                console.log(result);
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
                $('#MasterPekerja-txtStatusJabatanlama').val(result['kd_status']+ " - " +result['nama_status']);
                $('#MasterPekerja-txtNamaJabatanUpahlama').val(result['nama_jabatan_upah']);
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

    $('#tbl_lapkun').DataTable();

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

// JS untuk Memo Pemberitahuan Gaji Pekerja Cutoff


$('.deleteMemoCutoff').click(function () {
  let id = $(this).data('value')
  console.log(id)
  Swal.fire({
    title: 'Apakah Anda Yakin?',
    text: "Mengapus data ini secara permanent !",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then( result => {
    if (result.value) {
      window.location.href = baseurl+"MasterPekerja/Surat/gajipekerjacutoff/deleteMemo/"+id
    }
  })
  return false;
})

$('.btn_save_info').prop("disabled", true).click(function() {
})
$(".MPK_tertandaInfo").select2("disabled", true);

$('#monthpickerq').on('change', function(){
  let periode = $(this).val();
  $('#surat-loading').removeAttr('hidden')

  $.ajax({
    method: 'post',
    data: {ajaxPeriode: periode},
    url: baseurl + 'MasterPekerja/Surat/gajipekerjacutoff/getDataPeriode',
    success: function(data){
      $('.MPK-btnPratinjauCutoff').prop("disabled", true).click(function() {

      })
      $('#surat-loading').attr('hidden', true);
      if(data == 'null'){
        swal.fire({
          title:'Peringatan',
          text:'Periode Cutoff tidak ditemukan',
          type:'warning',
          showConfirmButton:false
        })
        window.location.href = baseurl+"MasterPekerja/Surat/gajipekerjacutoff/create_Info";
      }
      $('#periodikCutoff').html(data);
      $('#monthpickerq').val(periode);
      $('#MPK_infoPekerja').change(function(){
        let jenis = $(this).val();
        if (jenis == 'nonstaf') {
          $('#groupPekerjaInfo').removeClass('hidden');
          $('#groupPekerjaStafInfo').addClass('hidden');
          $('#MPK-btnPratinjauCutoff').prop('disabled', true).click(function () {

          })
          $('#MPK_txtaAlasan').attr('readonly', true);
          $('#btnInfonext').click(function () {
            $('#MPK_txtaAlasan').attr('readonly', false);
            $('#MPK-btnPratinjauCutoff').prop('disabled', false);
          })
        }else if (jenis == 'staf') {
          $('#groupPekerjaInfo').addClass('hidden');
          $('#groupAtasanInfo').addClass('hidden');
          $('#groupPekerjaStafInfo').removeClass('hidden');
          $('#MPK-btnPratinjauCutoff').prop('disabled', false);
          $('#MPK_txtaAlasan').attr('readonly', false);

        }else {
          $('#MPK-btnPratinjauCutoff').prop("disabled", true).click(function() {

          })
          $('#MPK_txtaAlasan').attr('readonly', true);
          $('#groupPekerjaInfo').addClass('hidden');
          $('#groupAtasanInfo').addClass('hidden');
          $('#groupPekerjaStafInfo').addClass('hidden');
        }

        $.ajax({
          method: 'post',
          data: {jenis: jenis},
          url: baseurl + 'MasterPekerja/Surat/gajipekerjacutoff/getAlasan',
          success: function (data) {
            if (jenis = 'nonstaf') {
              $('#MPK_txtaAlasan').val(data);
              $('#MPK_txtaAlasan').text(data);
            }else if (jenis == 'staf') {
              $('#MPK_txtaAlasan').val(data);
              $('#MPK_txtaAlasan').text(data);
            }else {
              $('#MPK_txtaAlasan').val('');
              $('#MPK_txtaAlasan').text('');
            }
          }
        })
      });

      $('#MPK_txtaIsi').redactor();

      $('#MPK-btnPratinjauCutoff').click(function(){

        $('#surat-loading').attr('hidden', false);
        let allnoind    = []
        let getnoind    = $('.noind-staff').each(function(){
          let newind    = $(this).text().trim()
          allnoind.push(newind)
        })
        let seksiname  = []
        let name    = $('.namaSeksi').each(function(){
          let namesie     = $(this).text().trim()
          seksiname.push(namesie)
        })
        console.log(seksiname);
        let noindnstaf  = []
        let getnstaf    = $('.noind-nonstaff').each(function(){
          let nstaf     = $(this).text().trim()
          noindnstaf.push(nstaf)
        })
        let atasanA     = []
        let check = []
        $('.classkuhehe').each(function(){
          let newats    = $(this).val().trim()
          atasanA.push(newats)
          if (newats == '' || newats == null) {
            Swal.fire({
              title: 'Peringatan',
              text: "Pastikan Anda telah mengisi parameter yang diperlukan. ;)",
              type: 'warning',
            });
            $('#surat-loading').attr('hidden', true);
            check.push(true)
            return false
          }
        })
        let jenis       = $('#MPK_infoPekerja').val()
        let approval    = $('#MPK_tertandaInfo').val()
        let alasan      = $('#MPK_txtaAlasan').val()
        let period      = $('#monthpickerq').val()

        if(check[0] == true){
          return false;
        }

        if (allnoind == '' || allnoind == null || noindnstaf == '') {
          Swal.fire({
            title: 'Peringatan',
            text: "Pastikan Anda telah mengisi parameter yang diperlukan. ;)",
            type: 'warning',
          });
        }else {
          $.ajax({
            type: 'POST',
            data: {
              allnoind: allnoind,
              jenis: jenis,
              approval: approval,
              alasan: alasan,
              nstaf: noindnstaf,
              noindA: atasanA,
              periodeBaru: period,
              seksiName: seksiname
            },
            url: baseurl+'MasterPekerja/Surat/gajipekerjacutoff/isi_memo_cutoff',
            success: function(result)
            {
              $('.btn_save_info').prop("disabled", false);
              console.log(result);
              var result = JSON.parse(result);
              $('#MPK_txtaIsi').redactor('set', result['isi_txt_memo_cutoff']);
              $('#surat-loading').attr('hidden', true);
            }
          });
        }
      });

      $('.deletenonstaf').click(function(){
        $(this).closest('tr').remove();
      })

      $(document).ready(function() {
        $('#MPK_tertandaInfo').select2({
          allowClear: true,
          placeholder: "Pilih Approval"
        });

        $('#MPK_infoPekerja').select2({
          allowClear: true,
          placeholder: "Pilih Status Pekerja"
        });

      })
    }
  })
})

function nextInfo() {
  $('#groupPekerjaInfo').addClass('hidden');
  $('#groupAtasanInfo').removeClass('hidden');

  let noindnstaf1  = []
  let getnstaf1    = $('.noind-nonstaff').each(function(){
    let nstaf1     = $(this).text().trim()
    noindnstaf1.push(nstaf1)
  })
  $('#surat-loading').attr('hidden', false);
  $.ajax({
    method: 'post',
    data: {noindnstaf: noindnstaf1},
    url: baseurl + 'MasterPekerja/Surat/gajipekerjacutoff/getTabel',
    success: function (data) {
      $('#surat-loading').attr('hidden', true);
      $('#groupAtasanInfo').html(data);
      console.log(data);
      $(document).ready(function () {
        $('.classkuhehe').select2({
          allowClear: true,
          placeholder: "Pilih Atasan"
        });
      })
    }
  })
}

//Perizinan Dinas
$(document).ready(function(){
   $('.tabel_izin').DataTable({
    "ordering" : false,
    "paging" : false,
    "searching": false
      });

    $('.tabel_rekap').DataTable({
    "dom": 'Bfrtip',
        "buttons": [
            'excel', 'pdf'
        ],
        scrollX: true,
        fixedColumns:{
          leftColumns:4
        }
    });

    $("input.periodeRekap").monthpicker({
      changeYear:true,
      dateFormat: 'yy-mm', });

    $('#app_edit_Dinas').on('click', function () {
        var loading = baseurl + 'assets/img/gif/loadingquick.gif';
        let jenis = $(this).val()
        let id = $('#modal-id_dinas').val()
        let ma = []
        let checkbox = $("input:checkbox[class=checkAll_edit_class]:checked")
        checkbox.each(function(){
            ma.push($(this).val());
        });

        if (ma == null || ma == '') {
            swal.fire({
                title: 'Peringatan',
                text: 'Harap Pilih Pekerja',
                type: 'warning',
                allowOutsideClick: false
            })
        }else {
            swal.fire({
              title: 'Checking...',
              text: "Sudahkah Anda mengecek pekerja yang Berangkat Dinas ?",
              type: 'question',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'OK',
              allowOutsideClick: false
            }).then(result => {
              if (result.value) {
                  swal.fire({
                    title: 'Peringatan',
                    text: "Anda akan memberikan keputusan APPROVE !",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false
                  }).then(result => {
                    if (result.value) {
                        $.ajax({
                            type: 'post',
                            data: {
                                jenis: jenis,
                                id: id,
                                pekerja: ma
                            },
                            beforeSend: function(){
                              Swal.fire({
                                html : "<img style='width: 320px; height: auto;'src='"+loading+"'>",
                                text : 'Loading...',
                                customClass: 'swal-wide',
                                showConfirmButton:false,
                                allowOutsideClick: false
                              });
                            },
                            url: baseurl + 'PerizinanDinas/AtasanApproval/updatePekerja',
                            success: function (data) {
                                Swal.fire({
                                  title: 'Izin Telah di Approve',
                                  type: 'success',
                                  showCancelButton: false,
                                  allowOutsideClick: false
                                }).then( result => {
                                    Swal.fire({
                                      html : "<img style='width: 320px; height: auto;'src='"+loading+"'>",
                                      text : 'Loading...',
                                      customClass: 'swal-wide',
                                      showConfirmButton:false,
                                      allowOutsideClick: false
                                  }).then(window.location.reload())
                                })
                            }
                        })
                    }
                })
            }
            })
        }
    })

    $("#modal-approve-dinas").on("hidden.bs.modal", function () {
        $('.icheckbox_flat-blue').removeClass('checked')
    });

});

function getApproval(a, b) {
  var loading = baseurl + 'assets/img/gif/loadingquick.gif';

  if (a == '1') {
      swal.fire({
        title: 'Checking...',
        text: "Sudahkah Anda mengecek pekerja yang Berangkat Dinas ?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK',
        allowOutsideClick: false
      }).then(result => {
        if (result.value) {
            swal.fire({
              title: 'Peringatan',
              text: "Anda akan memberikan keputusan APPROVE !",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'OK',
              allowOutsideClick: false
            }).then(result => {
              if (result.value) {
                $.ajax({
                  beforeSend: function(){
                    Swal.fire({
                      html : "<img style='width: 320px; height: auto;'src='"+loading+"'>",
                      text : 'Loading...',
                      customClass: 'swal-wide',
                      showConfirmButton:false,
                      allowOutsideClick: false
                    });
                  },
                  data: {
                    keputusan: a,
                    id: b
                  },
                  type: 'post',
                  url: baseurl + 'PerizinanDinas/AtasanApproval/update',
                  success: function (data) {
                    Swal.fire({
                      title: 'Izin Telah di Approve',
                      type: 'success',
                      showCancelButton: false,
                      allowOutsideClick: false
                    }).then( result => {
                        Swal.fire({
                          html : "<img style='width: 320px; height: auto;'src='"+loading+"'>",
                          text : 'Loading...',
                          customClass: 'swal-wide',
                          showConfirmButton:false,
                          allowOutsideClick: false
                      }).then(window.location.reload())
                    })
                  }
                })
              }
            })
        }
    })
  }else if (a == '2') {
    swal.fire({
      title: 'Peringatan',
      text: "Anda akan memberikan keputusan REJECT !",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'OK',
      allowOutsideClick: false
    }).then(result => {
      if (result.value) {
        $.ajax({
          beforeSend: function(){
            Swal.fire({
              html : "<img style='width: 320px; height: auto;'src='"+loading+"'>",
              text : 'Loading...',
              customClass: 'swal-wide',
              showConfirmButton:false,
              allowOutsideClick: false
            });
          },
          data: {
            keputusan: a,
            id: b
          },
          type: 'post',
          url: baseurl + 'PerizinanDinas/AtasanApproval/update',
          success: function (data) {
            Swal.fire({
              title: 'Izin Telah di Reject',
              type: 'error',
              showCancelButton: false,
              allowOutsideClick: false
            }).then( result => {
                Swal.fire({
                  html : "<img style='width: 320px; height: auto;'src='"+loading+"'>",
                  text : 'Loading...',
                  customClass: 'swal-wide',
                  showConfirmButton:false,
                  allowOutsideClick: false
              }).then(window.location.reload())
            })
          }
        })
      }
    })
  }
}

function edit_pkj_dinas(id) {
    let table = $('.eachPekerjaEdit')
    console.log(id);
    $.ajax({
        type: 'post',
        data: {
            id: id
        },
        url: baseurl + 'PerizinanDinas/AtasanApproval/editPekerjaDinas',
        beforeSend: a =>{
            table.html('<tr><td colspan="4">loading....</td></tr>')
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $('#modal-approve-dinas').modal('show')
            $('#modal-id_dinas').val(data[0]['izin_id'])
            $('#modal-tgl_dinas').val(data[0]['created_date'])
            $('#modal-kep_dinas').val(data[0]['keterangan'])

            let row
            data.forEach( a => {
                row += `<tr>
                            <td><input type="checkbox" class="checkAll_edit_class" value="${a.noind}"></td>
                            <td>${a.noind}</td>
                            <td>${a.nama}</td>
                            <td>${a.tujuan == '' ? '-' : a.tujuan}</td>
                        </tr>`
            })
            table.html(row)

            $('input#checkAll_edit').on('ifChecked ifUnchecked', function (event) {
                $('.checkAll_edit_class').prop('checked', (event.type == 'ifChecked') ? true : false )
                $(this).prop('checked', (event.type == 'ifChecked') ? true : false )
            })
        }
    })
}


//JS untuk Transposition Plotting Job
$(document).ready(function () {
  $('#tanggalBerlaku').datepicker({
    autoclose: true,
    autoApply: true,
    format: 'dd MM yyyy',
  })

  $('#TPJ_noind').on('change', function () {
    let noind = $(this).val()
    let loading = 'assets/img/gif/loadingquick.gif';

    $.ajax({
      type: 'post',
      dataType: 'json',
      data: {
        noind: noind
      },
      beforeSend: function(){
            Swal.fire({
              html : "<img style='width: 200px; height: auto;'src='"+loading+"'>",
              text : 'Loading...',
              customClass: 'swal-wide',
              showConfirmButton:false,
              allowOutsideClick: false
            });
          },
      url: baseurl + 'TranspositionPlottingJob/change',
      success: function (data) {
        swal.close()
        // $(this).find('select').prop("selected", false)
        $('#TPJ_pkj_saat_ini').val(data[0]['kd_pkj']+' - '+data[0]['pekerjaan'])
        let isi_data = "<option></option>"
        for (var i = 0; i < data['kerja'].length; i++) {
					isi_data += "<option value='" + data['kerja'][i]['kdpekerjaan'] + "'>" + data['kerja'][i]['kdpekerjaan'] +' - '+data['kerja'][i]['pekerjaan'] +"</option>"
				}
        $('#TPJ_pekerjaan').html(isi_data)
      }
    })
  })

  $('#TPJ_reload').on('click', function () {
    let loading = 'assets/img/gif/loadingquick.gif';

    Swal.fire({
      html : "<img style='width: 200px; height: auto;'src='"+loading+"'>",
      text : 'Loading...',
      customClass: 'swal-wide',
      showConfirmButton:false,
      allowOutsideClick: false
    });
    window.location.reload(function () {
      swal.close()
    })
  })


  $('#TPJ_save').on('click', function () {
    let noind = $('#TPJ_noind').val()
    let pkj_lm = $('#TPJ_pkj_saat_ini').val()
    let pkj_now = $('#TPJ_pekerjaan').val()
    let date = $('#tanggalBerlaku').val()
    let loading = 'assets/img/gif/loadingquick.gif';

    if (noind == '' || pkj_lm == '' || pkj_now == '' || date == '') {
      swal.fire({
        title: 'Peringatan',
        text: 'Parameter Belum Lengkap',
        type: 'warning',
        allowOutsideClick: false,
        showCancelButton: false
      })
    }else {
      swal.fire({
        title: 'Peringatan',
        text: 'Apakah Anda Yakin Mau Mengubah Data Pekerjaan ?',
        type: 'question',
        allowOutsideClick: false,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            type: 'post',
            data: {
              noind: noind,
              pkj_lm: pkj_lm,
              pkj_now: pkj_now,
              date: date
            },
            url: baseurl + 'TranspositionPlottingJob/save',
            beforeSend: function(){
              Swal.fire({
                html : "<img style='width: 200px; height: auto;'src='"+loading+"'>",
                text : 'Loading...',
                customClass: 'swal-wide',
                showConfirmButton:false,
                allowOutsideClick: false
              });
            },
            success: function (data) {
              swal.fire({
                title: 'Success',
                text: 'Berhasil Mengganti Data Sesuai Tanggal Berlaku',
                type: 'success',
                allowOutsideClick: false,
                showCancelButton: false
              }).then((result) => {
                Swal.fire({
                  html : "<img style='width: 200px; height: auto;'src='"+loading+"'>",
                  text : 'Loading...',
                  customClass: 'swal-wide',
                  showConfirmButton:false,
                  allowOutsideClick: false
                });
                window.location.reload()
              });
            }
          })
        }
      })
    }
  })

})
