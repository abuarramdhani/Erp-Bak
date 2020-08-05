//---------------Surat Penyerahan--------------------
$(document).on('input keyup keypress', 'input.select2-search__field', function (e) {
    $(this).val($(this).val().toUpperCase())
    $('#select2-results__option').val($(this).val().toUpperCase())
})
$(document).ready(function () {
    let loading = baseurl + 'assets/img/gif/loading11.gif'

    setTimeout(() => {
        $('.input_Pekerja_SP').on('ifChecked', function () {
            let jenis = $(this).val()
            let kelas = $('#slc_Kelas_SP').val()
            let kode = $('#slc_kodesie_SP').val()

            let Hidekelas = ''

            if ($('#kelas_pkj_SP').attr('hidden', false)) {
                let Hidekelas = `}else if (!kelas) {
                    swal.fire({
                        title: 'Peringatan !',
                        text: 'Kelas belum diisi !',
                        type: 'warning',
                        allowOutsideClick: false
                    }).then(result => {
                        $('.input_Pekerja_SP').iCheck('uncheck')
                    })`
            } else {
                let Hidekelas = ''
            }

            if (!kode) {
                swal.fire({
                    title: 'Peringatan !',
                    text: 'Kode Seksi belum diisi !',
                    type: 'warning',
                    allowOutsideClick: false
                }).then(result => {
                    ($('#slc_pkj_SP').val() == '1') ? $('#kelas_pkj_SP').attr('hidden', false) : $('#kelas_pkj_SP').attr('hidden', true)
                    $('.input_Pekerja_SP').iCheck('uncheck')
                })
                Hidekelas
            } else {
                ($('#slc_pkj_SP').val() == '1') ? $('#kelas_pkj_SP').attr('hidden', false) : $('#kelas_pkj_SP').attr('hidden', true)

                sumThey = jenis == '1' ? 0 : 2

                $('#slc_pri_pkj_SP').select2({
                    minimumInputLength: sumThey,
                    ajax: {
                        url: baseurl + "AdmSeleksi/SuratPenyerahan/getDataPekerja",
                        dataType: 'json',
                        type: 'get',
                        data: params => {
                            return {
                                term: params.term,
                                jenis,
                                kode,
                            }
                        },
                        processResults: data => {
                            return {
                                results: data.map(a => {
                                    let trig = jenis == '1' ? a.kodelamaran : a.noind
                                    return {
                                        id: trig,
                                        text: trig + ' - ' + a.nama,
                                    }
                                })
                            }
                        }
                    }
                })
            }
        })
    }, 5000)


    $('.txtNPWP_SP').mask('00.000.000.0-000.000', { placeholder: '00.000.000.0-000.000' })

    $('.txt_noHP_SP, .txt_noTlp_SP').mask('0000 0000 0000', { placeholder: '0000 0000 0000' })

    $('.SuratPenyerahan').dataTable()
    $('#txt_tglCetak_SP').datepicker({
        format: 'dd MM yyyy',
        todayHighlight: true,
        autoApply: true,
        autoclose: true,
        setDate: new Date()
    })

    $('.slc_loker_SP').select2({
        placeholder: "---Lokasi Kerja---",
        allowClear: true
    })
    $('.txt_ruang_SP').select2({
        placeholder: "---Ruang Kerja---",
        allowClear: true
    })
    $('.txt_Shift_SP').select2({
        placeholder: "---Shift Kerja---",
        allowClear: true
    })
    $('.inp_jenkel_SP').select2()

    $('.slc_asal_SP').select2({
        placeholder: "---Asal Perusahaan---",
        allowClear: true
    })

    $('.inp_Agama_SP').select2({
        placeholder: "---Pilih Agama---"
    })
    $('.txt_status_pri').select2({
        placeholder: "---Pilih Status Nikah---",
        allowClear: true
    })
    $('.slc_kantor_SP').select2({
        placeholder: "---Masukkan Kantor Asal---",
        allowClear: true
    })
    $('.slc_makan_SP').select2({
        placeholder: "---Masukkan tempat Makan---",
        allowClear: true
    })
    $('.forSelectJurusan2').select2({
        placeholder: "---Jurusan---",
        allowClear: true,
        tags: true
    })
    $('#slc_Kelas_SP').select2({
        placeholder: "---Kelas---",
        allowClear: true,
        tags: true
    })
    $('.forSelectSekulah2').select2({
        placeholder: "---Sekolah---",
        allowClear: true,
        tags: true
    })
    $('.txtPend_SP').select2({
        placeholder: "---Pendidikan Terakhir---",
        allowClear: true,
        tags: true
    })

    $(".inp_tgl_lahir").datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        autoApply: true,
        autoclose: true,
        setDate: new Date()
    })

    $("#inp_tgl_Keluar_SP").datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        autoApply: true,
        autoclose: true,
        setDate: new Date()
    })

    $("#txt_tgl_SP").datepicker({
        format: 'd MM yyyy',
        todayHighlight: true,
        autoApply: true,
        autoclose: true,
        setDate: new Date()
    })

    $("#txt_IK_hubker").datepicker({
        "format": 'yyyy-mm-dd',
        "todayHighlight": true,
        "autoApply": true,
        "autoclose": true,
        setDate: new Date()
    })
    $("#inp_tgl_angkat_SP").datepicker({
        "format": 'yyyy-mm-dd',
        "todayHighlight": true,
        "autoApply": true,
        "autoclose": true,
        setDate: new Date()
    })

    $('input[type=number][max]:not([max=""])').on('input', function (ev) {
        var $this = $(this);
        var maxlength = $this.attr('max').length;
        var value = $this.val();
        if (value && value.length >= maxlength) {
            $this.val(value.substr(0, maxlength));
        }
    })

    $('#txt_tgl_SP').on('change', () => {
        $('#slc_pkj_SP').val('').trigger('change')
    })

    $('.Provinsi_SP').select2({
        minimumInputLength: 2,
        allowClear: true,
        placeholder: 'Provinsi',
        ajax: {
            url: baseurl + "MasterPekerja/DataPekerjaKeluar/provinsiPekerja",
            dataType: 'json',
            type: "GET",
            data: function (params) {
                return { term: params.term };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return {
                            id: obj.id_prov,
                            text: obj.nama,
                        };
                    })

                };
            },
        },
    }).on('change', function () {
        $('.Kabupaten_SP').select2("val", "");
        $('.Kecamatan_SP').select2("val", "");
        $('.Desa_SP').select2("val", "");
    })


    $('.Kabupaten_SP').select2({
        minimumInputLength: 0,
        allowClear: true,
        placeholder: 'Kabupaten',
        ajax: {
            url: baseurl + "MasterPekerja/DataPekerjaKeluar/kabupatenPekerja",
            dataType: 'json',
            type: "GET",
            data: function (params) {
                return {
                    term: params.term,
                    prov: $(".Provinsi_SP").val(),
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (ok) {
                        return {
                            id: ok.id_kab,
                            text: ok.nama,
                        };
                    })

                };
            },
        },
    });

    $('.Kecamatan_SP').select2({
        minimumInputLength: 0,
        allowClear: true,
        placeholder: 'Kecamatan',
        ajax: {
            url: baseurl + "MasterPekerja/DataPekerjaKeluar/kecamatanPekerja",
            dataType: 'json',
            type: "GET",
            data: function (params) {
                return {
                    term: params.term,
                    kab: $(".Kabupaten_SP").val(),
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (ok) {
                        return {
                            id: ok.id_kec,
                            text: ok.nama,
                        };
                    })

                };
            },
        },
    });

    $('.Desa_SP').select2({
        minimumInputLength: 0,
        allowClear: true,
        placeholder: 'Kelurahan',
        ajax: {
            url: baseurl + "MasterPekerja/DataPekerjaKeluar/desaPekerja",
            dataType: 'json',
            type: "GET",
            data: function (params) {
                return {
                    term: params.term,
                    kec: $(".Kecamatan_SP").val(),
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (ok) {
                        return {
                            id: ok.id_kel,
                            text: ok.nama,
                        };
                    })

                };
            },
        },
    });

    $('#slc_pkj_SP').on('change', function (event) {
        let a = $(this).val()
        let try_hubker = $('#txt_try_hubker')
        let kode = $('#inputKode')
        let try_seleksi = $('#txt_try_seleksi')
        $('#slc_kodesie_SP').val('').trigger('change')
        $('#txtDeptPenyerahan').val('').trigger('change')
        $('#txtBidPenyerahan').val('').trigger('change')
        $('#txtUnitPenyerahan').val('').trigger('change')
        $('#txtSeksiPenyerahan').val('').trigger('change')
        $('#txtTmpPenyerahan').val('').trigger('change')
        $('#slc_gol_pkj_SP').val('').trigger('change')
        $('#keteranganPKL').html('').trigger('change')

        $(".inp_tgl_lahir").datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            autoApply: true,
            autoclose: true,
            setDate: new Date()
        })

        $('.slc_makan_SP').select2({
            placeholder: "---Masukkan tempat Makan---",
            allowClear: true
        })

        $('#slc_kodesie_SP').select2({
            placeholder: "---Masukkan Kodesie---",
            allowClear: true
        })

        $('#slc_RuangLingkup_SP').select2({
            placeholder: "---Masukkan Ruang Lingkup Kerja---",
            allowClear: true
        })

        $('#txtKerja_SP').select2({
            placeholder: "---Masukkan Pekerjaan---",
            allowClear: true
        })

        $('.forSelectJurusan2').select2({
            placeholder: "---Jurusan---",
            allowClear: true,
            tags: true
        })

        $('.txtPend_SP').select2({
            placeholder: "---Pendidikan Terakhir---",
            allowClear: true,
            tags: true
        })

        $("#txt_IK_hubker").datepicker({
            "format": 'yyyy-mm-dd',
            "todayHighlight": true,
            "autoApply": true,
            "autoclose": true,
            setDate: new Date()
        })
        $("#inp_tgl_angkat_SP").datepicker({
            "format": 'yyyy-mm-dd',
            "todayHighlight": true,
            "autoApply": true,
            "autoclose": true,
            setDate: new Date()
        })

        let elaa = ''
        if (a == '1') {
            kode.val('D')
            try_hubker.val('6')
            try_seleksi.val('6')
            elaa = moment($('#txt_tgl_SP').val()).add(6, 'month').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('6')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', true)
            $('#tgl_ik_hubker').attr('hidden', true)
        } else if (a == '2') {
            kode.val('D')
            try_hubker.val('30')
            try_seleksi.val('30')
            elaa = moment($('#txt_tgl_SP').val()).add(30, 'month').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('30')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', true)
            $('#tgl_ik_hubker').attr('hidden', true)
        } else if (a == '3') {
            kode.val('E')
            try_hubker.val('9')
            try_seleksi.val('9')
            elaa = moment($('#txt_tgl_SP').val()).add(9, 'month').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('9')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', true)
            $('#tgl_ik_hubker').attr('hidden', true)
        } else if (a == '4') {
            kode.val('H')
            try_hubker.val('1.5')
            try_seleksi.val('1.5')
            elaa = moment($('#txt_tgl_SP').val()).add(1, 'month').add(15, 'days').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('24')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', false)
            $('#tgl_ik_hubker').attr('hidden', false)
        } else if (a == '5') {
            kode.val('J')
            try_hubker.val('6')
            try_seleksi.val('6')
            elaa = moment($('#txt_tgl_SP').val()).add(6, 'month').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('24')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', false)
            $('#tgl_ik_hubker').attr('hidden', true)
        } else if (a == '6') {
            kode.val('G')
            try_hubker.val('0')
            try_seleksi.val('6')
            elaa = moment($('#txt_tgl_SP').val()).add(6, 'month').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('6')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', false)
            $('#tgl_ik_hubker').attr('hidden', true)
        } else if (a == '7') {
            kode.val('F')
            try_seleksi.val('1')
            elaa = moment($('#txt_tgl_SP').val()).add(1, 'month').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val(null)
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', true)
            $('#LM_K_Hubker').attr('hidden', true)
            $('#tgl_ik_hubker').attr('hidden', true)
        } else if (a == '8') {
            kode.val('L')
            try_seleksi.val('0')
            let jus = $('#txt_tgl_SP').val()
            $('#txt_lama_kontrak').val(null)
            $('#inp_tgl_angkat_SP').attr('value', jus)
            $('.hideAllHubker').addClass('hide')
            $('#hide_tgl_Selesai_SP').attr('hidden', false)
            $('#LM_Hide_Hubker').attr('hidden', true)
            $('#LM_K_Hubker').attr('hidden', true)
            $('#tgl_ik_hubker').attr('hidden', true)
        } else if (a == '9') {
            kode.val('K')
            try_hubker.val('0')
            try_seleksi.val('1')
            elaa = moment($('#txt_tgl_SP').val()).add(1, 'month').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('3')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', false)
            $('#tgl_ik_hubker').attr('hidden', false)
        } else if (a == '10') {
            kode.val('C')
            try_hubker.val('9')
            try_seleksi.val('9')
            elaa = moment($('#txt_tgl_SP').val()).add(9, 'month').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('9')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', false)
            $('#tgl_ik_hubker').attr('hidden', true)
        } else if (a == '11') {
            kode.val('C')
            try_hubker.val('2.5')
            try_seleksi.val('2.5')
            elaa = moment($('#txt_tgl_SP').val()).add(2, 'month').add(15, 'days').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('24')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', false)
            $('#tgl_ik_hubker').attr('hidden', true)
        } else if (a == '12') {
            kode.val('P')
            try_hubker.val('0')
            try_seleksi.val('1')
            elaa = moment($('#txt_tgl_SP').val()).add(1, 'month').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('3')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', false)
            $('#tgl_ik_hubker').attr('hidden', false)
        } else if (a == '13') {
            kode.val('Q')
            try_seleksi.val('1')
            elaa = moment($('#txt_tgl_SP').val()).add(1, 'month').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val(null)
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', true)
            $('#LM_K_Hubker').attr('hidden', true)
            $('#tgl_ik_hubker').attr('hidden', true)
        } else if (a == '14') {
            kode.val('C')
            try_hubker.val('0')
            try_seleksi.val('1')
            elaa = moment($('#txt_tgl_SP').val()).add(1, 'month').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('3')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', false)
            $('#tgl_ik_hubker').attr('hidden', false)
        } else if (a == '15') {
            kode.val('T')
            try_hubker.val('1.5')
            try_seleksi.val('1.5')
            elaa = moment($('#txt_tgl_SP').val()).add(1, 'month').add(15, 'days').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('24')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', false)
            $('#tgl_ik_hubker').attr('hidden', false)
        } else if (a == '16') {
            kode.val('N')
            try_hubker.val('0')
            try_seleksi.val('0')
            elaa = moment($('#txt_tgl_SP').val()).add(1, 'month').add(15, 'days').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('6')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', false)
            $('#tgl_ik_hubker').attr('hidden', true)
        }
        if (elaa != '') {
            $("#inp_tgl_angkat_SP").datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", elaa))
        }
        if (try_hubker.val()) {
            if ($('#tgl_ik_hubker').attr('hidden', false)) {
                let isi = try_hubker.val().split(/[,.]/)
                if (isi[1]) {
                    let DateFresh = moment($('#txt_tgl_SP').val()).add(Number(3) + Number(isi[0]), 'month').add(15, 'days').format('YYYY-MM-DD')
                    $('#txt_IK_hubker').datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", DateFresh))
                } else {
                    let DateFresh = moment($('#txt_tgl_SP').val()).add(Number(3) + Number(isi[0]), 'month').format('YYYY-MM-DD')
                    $('#txt_IK_hubker').datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", DateFresh))
                }
            }
        }

        if ($('.hideAllHubker').hasClass('hide')) {
            $('.nambahStyle').removeAttr('style')
        } else {
            $('.nambahStyle').attr('style', 'margin-top: 23px')
        }

        if (a == '10' || a == '7' || a == '4' || a == '3' || a == '13' || a == '15') {
            $('#gol_Pekerja_SP').attr('hidden', false)
            let golongan_baru = ["", "-", "1", "2", "3"]
            let golongan_baru2 = ["", "-", "A", "B", "C"]
            let golongan_pkl = ["", "-", "PKL1", "PKL2", "PKL3"]
            let opsi = ''
            if (a == '7' || a == '13') {
                for (var i = 0; i < golongan_pkl.length; i++) {
                    opsi += `<option value="${golongan_pkl[i]}">${golongan_pkl[i]}</option>`
                }
            } else {
                if (a == '3' || a == '10') {
                    for (var i = 0; i < golongan_baru.length; i++) {
                        opsi += `<option value="${golongan_baru[i]}">${golongan_baru[i]}</option>`
                    }
                } else {
                    for (var i = 0; i < golongan_baru2.length; i++) {
                        opsi += `<option value="${golongan_baru2[i]}">${golongan_baru2[i]}</option>`
                    }
                }
            }
            $('#slc_gol_pkj_SP').html(opsi)
        } else {
            $('#gol_Pekerja_SP').attr('hidden', true)
        }
        (a == '1') ? $('#kelas_pkj_SP').attr('hidden', false) : $('#kelas_pkj_SP').attr('hidden', true)

        let kodein = kode.val()
        $.ajax({
            type: 'post',
            data: {
                kode: kodein
            },
            dataType: 'json',
            url: baseurl + 'AdmSeleksi/SuratPenyerahan/getPekerjaan',
            success: function (data) {
                $('.input_noind_baru_SP').val(data.noind)
                $('#slc_kodesie_SP').attr('disabled', false)
                let kodesie_butuh = '<option></option>'
                for (var i = 0; i < data.butuh.length; i++) {
                    kodesie_butuh += `<option value="` + data.butuh[i]['kodesie'] + `">[` + data.butuh[i]['kodesie'] + `] - ` + data.butuh[i]['seksi'] + ` - ` + data.butuh[i]['pekerjaan'] + `</option>`
                }
                $('#slc_kodesie_SP').html(kodesie_butuh)
            }
        })
    })

    $('#txt_try_seleksi').on('keyup', function () {
        let isi = $(this).val().split(/[,.]/)
        elaa = moment($('#txt_tgl_SP').val()).add($(this).val(), 'month').format('YYYY-MM-DD')

        if (isi[1]) {
            let newEla = moment($('#txt_tgl_SP').val()).add(isi[0], 'month').add(15, 'days').format('YYYY-MM-DD')
            $('#inp_tgl_angkat_SP').val(newEla)
        } else {
            $('#inp_tgl_angkat_SP').val(elaa)
        }
    })

    $('#txt_try_hubker').on('keyup', function () {
        let a = $("#slc_pkj_SP").val()
        if (a == '12' || a == '9' || a == '14') {
            let DateFresh = moment($('#txt_tgl_SP').val()).add(Number(3), 'month').format('YYYY-MM-DD')
            $('#txt_IK_hubker').datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", DateFresh))
        } else {
            let isi = $(this).val().split(/[,.]/)

            if (isi[1]) {
                let DateFresh = moment($('#txt_tgl_SP').val()).add(Number(3) + Number(isi[0]), 'month').add(15, 'days').format('YYYY-MM-DD')
                $('#txt_IK_hubker').datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", DateFresh))
            } else {
                let DateFresh = moment($('#txt_tgl_SP').val()).add(Number(3) + Number(isi[0]), 'month').format('YYYY-MM-DD')
                $('#txt_IK_hubker').datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", DateFresh))
            }
        }

    })

    $('#slc_gol_pkj_SP').on('change', function () {
        let text = $(this).val()
        if (text == 'PKL1') {
            $('#keteranganPKL').html('<i>0 s/d 6 Bulan</i>')
            $('#HideMasaPKL').val('6')
        } else if (text == 'PKL2') {
            $('#keteranganPKL').html('<i>6 s/d 12 Bulan</i>')
            $('#HideMasaPKL').val('12')
        } else if (text == 'PKL3') {
            $('#keteranganPKL').html('<i>12 s/d 36 Bulan</i>')
            $('#HideMasaPKL').val('36')
        } else {
            $('#keteranganPKL').html('')
            $('#HideMasaPKL').val('')
        }
    })

    $('#slc_kodesie_SP').on('change', function () {
        let kode = $(this).val()
        $('.input_Pekerja_SP').iCheck('uncheck')
        $('#slc_pri_pkj_SP').val('').trigger('change')
        $('#plus_pkj_SP').html('')

        $.ajax({
            type: 'post',
            data: {
                kodesie: kode
            },
            dataType: 'json',
            beforeSend: function () {
                swal.fire({
                    html: '<img src="' + loading + '">',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    background: 'transparent',
                })
            },
            url: baseurl + 'AdmSeleksi/SuratPenyerahan/kodesie',
            success: function (data) {
                $('#txtKerja_SP').val('').trigger('change')
                swal.close()
                let result = '<option></option>'
                for (var i = 0; i < data.kerja.length; i++) {
                    result += '<option value=' + data.kerja[i]['kdpekerjaan'] + '>' + data.kerja[i]['pekerjaan'] + '</option>'
                }
                $('#txtKerja_SP').html(result)
                $('#txtDeptPenyerahan').val(data.kodesie[0]['dept'])
                $('#txtBidPenyerahan').val(data.kodesie[0]['bidang'])
                $('#txtUnitPenyerahan').val(data.kodesie[0]['unit'])
                $('#txtSeksiPenyerahan').val(data.kodesie[0]['seksi'])
                $('#txtTmpPenyerahan').val(data.kodesie[0]['seksi'])
                $('.hide_Perusahaan').attr('hidden', true)
                if ($('#slc_pkj_SP').val()) { forTable() }
            }
        })
    })

    $('.slc_makan_SP').on('change', function () {
        let a = $(this).val()
        $('.txt_ruang_SP').val(a).trigger('change')
    })

    $('.btn_GetModal').on('click', function () {
        let id = $(this).attr('value')

        $('.input_id_SP').val(id).trigger('change')
        $('#Modal_Cetak_SP').modal('show')
    })

    $('#btn_Plus_Pekerja_SP').on('click', function () {
        let cek = $('#SuratPenyerahan_utama').serializeArray()
        let jenis = $('input[class="input_Pekerja_SP"]:checked').attr('value')
        let isi = $('#slc_pri_pkj_SP').val()
        let Outsorcing = $('#slc_pkj_SP').val()

        if (jenis == 1) {
            $('.ganti_hide').attr({ 'disabled': true, 'hidden': true }).iCheck('uncheck').closest('form')
        } else {
            $('.ganti_hide').attr({ 'disabled': false, 'hidden': false }).iCheck('check').closest('form')
        }

        if (jenis == '' || jenis == null) {
            swal.fire({
                title: 'Warning',
                text: 'Harap Pilih Jenis Pekerja !',
                type: 'warning',
                allowOutsideClick: false
            })
        } else if (isi == '') {
            swal.fire({
                title: 'Warning',
                text: 'Harap Pilih Pekerja Yang diserahkan !',
                type: 'warning',
                allowOutsideClick: false
            })
        } else {
            $.ajax({
                type: 'post',
                data: { formUtama: cek },
                dataType: 'json',
                beforeSend: function () {
                    swal.fire({
                        html: '<img src="' + loading + '">',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        background: 'transparent',
                    })
                },
                url: baseurl + 'AdmSeleksi/SuratPenyerahan/plusPekerja',
                success: function (result) {
                    swal.close()
                    Outsorcing == '1' ? $('#kelas_pkj_SP').attr('hidden', false) : $('#kelas_pkj_SP').attr('hidden', true)
                    $('.input_Pekerja_SP').iCheck('uncheck')
                    $('#slc_pri_pkj_SP').val('').trigger('change')
                    let cekHide = result.jenis == 1 ? 'hidden' : '',
                        noind = result.jenis == 1 ? '' : result.pkj[0]['noind'],
                        pengganti = result.jenis == 1 ? 'disabled hidden' : 'checked',
                        no_keb = result.jenis == 1 ? result.pkj[0]['kodekebutuhan'] : result.pkj[0]['nokeb'],
                        kelahiran = result.jenis == 1 ? result.pkj[0]['tmplahir'] : result.pkj[0]['templahir'],
                        kodepos = result.jenis == 1 ? '' : result.pkj[0]['kodepos'],
                        no_kk = result.jenis == 1 ? '' : result.pkj[0]['no_kk'],
                        status_nikah = result.jenis == 1 ? '' : result.pkj[0]['statnikah'],
                        agama = ["ISLAM", "KATHOLIK", "KRISTEN", "HINDU", "BUDHA", "KONGHUCU"],
                        jenkel = ["L", "P"],
                        nikah = [
                            ["K", "KAWIN"],
                            ["BK", "BELUM KAWIN"],
                            ["KS", "KAWIN SIRI"]
                        ],
                        sekulah = ["SD", "SMP", "SMA", "SMK", "D1", "D3", "D4", "S1", "S2", "S3"],
                        pendidikan = '';
                    if (result.pkj[0]['pendidikan'] == 'SLTP') {
                        pendidikan += 'SMP'
                    } else if (result.pkj[0]['pendidikan'] == 'SLTA') {
                        pendidikan += 'SMA'
                    } else {
                        pendidikan += result.pkj[0]['pendidikan']
                    }

                    let ana = result.pkj[0]['tgllahir'].split('/'),
                        lahir1 = new Date(ana[2] + '-' + ana[1] + '-' + ana[0]),
                        lahir = moment(lahir1).format('YYYY-MM-DD'),
                        jurusanTetap = `<input type="text" class="form-control txtJurusan_SP" name="txtJurusan_SP" style="width: 100% !important; text-transform: uppercase; !important" value="${result.pkj[0]['jurusan']}" required>`,
                        gantiJurusan = `<select class="select select2 form-control txtJurusan_SP forSelectJurusan2" name="txtJurusan_SP" autocapitalize="on" style="width: 100% !important; text-transform: uppercase; !important" required>
                                            <option></option>
                                            ${
                            result.jurusan.map(item => {
                                return `<option ${item.nama_jurusan == result.pkj[0]['jurusan'] ? 'selected' : ''} value="${item.nama_jurusan}">${item.nama_jurusan}</option>`
                            }).join('')
                            }
                                        </select>`,
                        sekolahTetap = `<input type="text" class="form-control txtSkul_SP" name="txtSkul_SP" style="width: 100% !important; text-transform: uppercase; !important" value="${result.pkj[0]['sekolah']}" required>`,
                        gantiSekolah = `<select class="select select2 form-control txtSkul_SP forSelectSekulah2" name="txtSkul_SP" style="width: 100% !important; text-transform: uppercase !important" required>
                                            <option></option>
                                            ${
                            result.skul.map(item => {
                                return `<option ${item.nama_univ == result.pkj[0]['sekolah'] ? 'selected' : ''} value="${item.nama_univ}">${item.nama_univ}</option>`
                            }).join('')
                            }
                                        </select>`,
                        jursan = (result.jenis == '1') ? gantiJurusan : (result.jenis == '2' ? jurusanTetap : gantiJurusan),
                        sekul = (result.jenis == '1') ? gantiSekolah : (result.jenis == '2' ? sekolahTetap : gantiSekolah),
                        kode = $('#inputKode').val(),
                        gol_trig = $('#slc_gol_pkj_SP').val()

                    $('#plus_pkj_SP').html(`<div class="box">
                        <form class="form-horizontal" id="addReadonlyForm">
                        <div class="box-body">
                        <div class="box-header with-border" style="background-color: #d2d6de;"><b><p style="font-size: 15px;">---  Data Perusahaan ---</p></b></div>
                            <div class="col-lg-6">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="input_noind_baru_SP" class="col-lg-4 control-label">Nomor Induk</label>
                                        <div class="col-lg-3">
                                            <input type="text" name="input_noind_baru_SP" class="form-control text-left input_noind_baru_SP" value="${result.noind}" readonly>
                                        </div>
                                        <label for="input_noind_lama_SP" class="col-lg-2 control-label ${cekHide}">Lama</label>
                                        <div class="col-lg-3 ${cekHide}">
                                            <input type="text" name="input_noind_lama_SP" class="form-control text-left input_noind_lama_SP ${cekHide}" value="${noind}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="txt_Shift_SP" class="col-lg-4 control-label ">Shift</label>
                                        <div class="col-lg-8">
                                            <select class="select select2 form-control txt_Shift_SP" name="txt_Shift_SP" style="width: 100% !important" required>
                                                <option></option>
                                                ${
                        result.shift.map(item => {
                            return `<option ${item.kd_shift == '4' ? 'Selected' : ''} value="${item.kd_shift}">[${item.kd_shift}] - ${item.shift}</option>`
                        }).join('')
                        }
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="txt_kd_jabatan_SP" class="col-lg-4 control-label ">Kd Jabatan</label>
                                        <div class="col-lg-8">
                                            <select class="select select2 form-control txt_kd_jabatan_SP" name="txt_kd_jabatan_SP" style="width: 100% !important" required>
                                                <option></option>
                                                ${
                        result.kodejabatan.map(item => {
                            return `<option value="${item.kd_jabatan}">[${item.kd_jabatan}] - ${item.jabatan}</option>`
                        }).join('')
                        }
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="txt_jabatan_SP" class="col-lg-4 control-label ">Jabatan</label>
                                        <div class="col-lg-8">
                                            <input type="text" name="txt_jabatan_SP" class="form-control text-left txt_jabatan_SP" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="inp_stat_jbtn" class="col-lg-4 control-label ">Status Jabatan</label>
                                        <div class="col-lg-8">
                                            <input type="text" name="inp_stat_jbtn" class="form-control text-left inp_stat_jbtn" value="${kode == 'C' ? '' : result.stat_jab[0]['status']}" readonly>
                                            <input type="text" name="inp_kd_jbtn" class="form-control text-left inp_kd_jbtn hide" value="${kode == 'C' ? '' : result.stat_jab[0]['kd_hubker']}" hidden>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="slc_jab_upah" class="col-lg-4 control-label ">Jabatan Upah</label>
                                        <div class="col-lg-8">
                                            <select class="select select2 form-control slc_jab_upah" name="slc_jab_upah" style="width: 100% !important" required>
                                                <option></option>
                                                ${
                        result.jabatan_upah.map(item => {
                            return `<option ${(item.nama_jabatan.substr(21, 1) == gol_trig) || result.jabatan_upah.length == 1 ? 'selected' : ''} value="${item.kd_upah + '|' + item.nama_jabatan}">${item.nama_jabatan}</option>`
                        }).join('')
                        }
                                            </select >
                                        </div >
                                    </div >
                                </div >
                            </div >
            <div class="col-lg-6">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="no_kebutuhan_SP" class="col-lg-4 control-label">Nomor Kebutuhan</label>
                        <div class="col-lg-5">
                            <input type="text" name="no_kebutuhan_SP" class="form-control text-left no_kebutuhan_SP" value="${no_keb}" readonly>
                                        </div>
                            <div class="col-lg-1">
                                <input type="checkbox" ${pengganti} name="cekGanti" class="ganti_hide" value="1">
                                        </div>
                                <p for="cekGanti" ${pengganti} class="col-lg-2 ganti_hide">Pengganti</p>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="txt_Lamaran_SP" class="col-lg-4 control-label">Kode Lamaran</label>
                                <div class="col-lg-8">
                                    <input type="text" name="txt_Lamaran_SP" class="form-control txt_Lamaran_SP" value="${result.pkj[0]['kodelamaran']}" readonly>
                                        </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="slc_kantor_SP" class="col-lg-4 control-label ">Kantor Asal</label>
                                    <div class="col-lg-8">
                                        <select class="select select2 form-control slc_kantor_SP" name="slc_kantor_SP" style="width: 100% !important" required>
                                            <option></option>
                                                ${
                        result.kantor.map(item => {
                            return `<option value="${item.id_}">${item.kantor_asal}</option>`
                        }).join('')
                        }
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="slc_loker_SP" class="col-lg-4 control-label ">Lokasi Kerja</label>
                                    <div class="col-lg-8">
                                        <select class="select select2 form-control slc_loker_SP" name="slc_loker_SP" style="width: 100% !important" required>
                                            <option></option>
                                                ${
                        result.lokasi.map(item => {
                            return `<option value="${item.id_}">${item.lokasi_kerja}</option>`
                        }).join('')
                        }
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="slc_makan_SP" class="col-lg-4 control-label">Tempat Makan</label>
                                    <div class="col-lg-8">
                                        <select class="select select2 form-control slc_makan_SP" name="slc_makan_SP" style="width: 100% !important" required>
                                            <option></option>
                                                ${
                        result.tempat_makan.map(item => {
                            return `<option value="${item.fs_tempat_makan}">${item.fs_tempat_makan}</option>`
                        }).join('')
                        }
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="txt_ruang_SP" class="col-lg-4 control-label ">Ruang</label>
                                    <div class="col-lg-8">
                                        <select class="select select2 form-control txt_ruang_SP" name="txt_ruang_SP" style="width: 100% !important" required>
                                            <option></option>
                                                ${
                        result.tempat_makan.map(item => {
                            return `<option value="${item.fs_tempat_makan}">${item.fs_tempat_makan}</option>`
                        }).join('')
                        }
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="box-header with-border" style="background-color: #d2d6de;"><b><p style="font-size: 15px;">---  Data Pribadi ---</p></b></div>
                        <div class="col-lg-6">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="def_Nama_pkj" class="col-lg-4 control-label">Nama</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control def_Nama_pkj" style="text-transform: uppercase !important" name="def_Nama_pkj" value="${result.pkj[0]['nama']}">
                                            </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="inp_Agama_SP" class="col-lg-4 control-label">Agama</label>
                                        <div class="col-lg-5">
                                            <select class="select select2 form-control inp_Agama_SP" name="inp_jenkel_SP" value="${result.pkj[0]['agama']}" style="width: 100% !important" required>
                                                <option></option>
                                                    ${
                        agama.map(item => {
                            return `<option ${item == result.pkj[0]['agama'] ? 'selected' : ''} value="${item}">${item}</option>`
                        }).join('')
                        }
                                            </select>
                                        </div>
                                        <label for="inp_jenkel_SP" class="col-lg-1 control-label" style="margin-left: -15px">Gender</label>
                                        <div class="col-lg-2" style="margin-left: 15px">
                                            <select class="select select2 form-control inp_jenkel_SP" name="inp_jenkel_SP" style="width: 100% !important" required>
                                                <option></option>
                                                    ${
                        jenkel.map(item => {
                            return `<option ${item == result.pkj[0]['jenkel'] ? 'selected' : ''} value="${item}">${item}</option>`
                        }).join('')
                        }
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="txtLokasi_Lahir" class="col-lg-4 control-label">TTL</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtLokasi_Lahir" style="text-transform: uppercase !important" class="form-control txtLokasi_Lahir" value="${kelahiran}" required>
                                            </div>
                                            <div class="col-lg-4">
                                                <input type="text" name="inp_tgl_lahir" class="form-control inp_tgl_lahir" value="${lahir}" required>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="txt_status_pri" class="col-lg-4 control-label">Status Nikah</label>
                                                <div class="col-lg-8">
                                                    <select class="select select2 form-control txt_status_pri" name="txt_status_pri" style="width: 100% !important" required>
                                                        <option></option>
                                                        <option value="-">-</option>
                                                    ${
                        nikah.map(item => {
                            return `<option ${item[0] == status_nikah ? 'selected' : ''} value="${item[0]}">[${item[0]}] - ${item[1]}</option>`
                        }).join('')
                        }
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="txtNIK_SP" class="col-lg-4 control-label">NIK</label>
                                                <div class="col-lg-8">
                                                    <input type="number" max="9999999999999999" name="txtNIK_SP" class="form-control txtNIK_SP" value="${result.pkj[0]['nik']}" required>
                                            </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="txtNPWP_SP" class="col-lg-4 control-label">NPWP</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="txtNPWP_SP" class="form-control txtNPWP_SP">
                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="txt_noKK_SP" class="col-lg-4 control-label">Nomor KK</label>
                                                        <div class="col-lg-8">
                                                            <input type="number" max="9999999999999999" name="txt_noKK_SP" class="form-control txt_noKK_SP" value="${no_kk}">
                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="txtPend_SP" class="col-lg-4 control-label">Pendidikan
                                            </label>
                                                            <div class="col-lg-8">
                                                                <select class="select select2 form-control txtPend_SP" name="txtPend_SP" style="width: 100% !important; text-transform: uppercase !important" required>
                                                                    <option></option>
                                                    ${
                        sekulah.map(item => {
                            return `<option ${item == pendidikan ? 'selected' : ''} value="${item}">${item}</option>`
                        }).join('')
                        }
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="txtSkul_SP" class="col-lg-4 control-label">Sekolah </label>
                                                            <div class="col-lg-8">
                                                                ${sekul}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="txtJurusan_SP" class="col-lg-4 control-label">Jurusan </label>
                                                            <div class="col-lg-8">
                                                                ${jursan}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="col-lg-12" ${(Outsorcing == '14' || Outsorcing == '12' || Outsorcing == '9') ? '' : 'hidden'}>
                                                        <div class="form-group">
                                                            <label for="slc_asal_SP" class="col-lg-4 control-label">Asal</label>
                                                            <div class="col-lg-8">
                                                                <select class="select select2 form-control slc_asal_SP" name="slc_asal_SP" style="width: 100% !important" required>
                                                                    <option></option>
                                                    ${
                        result.pemborong.map(item => {
                            let Otsorcing = (Outsorcing == '14' || Outsorcing == '12' || Outsorcing == '9') ? item.asal_outsourcing : ''
                            return `<option value="${Otsorcing}">${Otsorcing}</option>`
                        }).join('')
                        }
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="txt_alamat_SP" class="col-lg-4 control-label">Alamat</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" name="txt_alamat_SP" class="form-control txt_alamat_SP" style="text-transform: uppercase !important" value="${result.pkj[0]['alamat']}" required>
                                            </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="txt_Prov_SP" class="col-lg-4 control-label">Provinsi</label>
                                                                <div class="col-lg-8">
                                                                    <select class="select select2 form-control Provinsi_SP" name="txt_Prov_SP" style="width: 100% !important" required>
                                                                        <option value="${result.pkj[0]['prop']}">${result.pkj[0]['prop']}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="txt_Kota_SP" class="col-lg-4 control-label">Kabupaten / Kota</label>
                                                                <div class="col-lg-8">
                                                                    <select class="select select2 form-control Kabupaten_SP" name="txt_Kota_SP" style="width: 100% !important" required>
                                                                        <option value="${result.pkj[0]['kab']}">${result.pkj[0]['kab']}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="txtKec_SP" class="col-lg-4 control-label">Kecamatan</label>
                                                                <div class="col-lg-8">
                                                                    <select class="select select2 form-control Kecamatan_SP" name="txtKec_SP" style="width: 100% !important" required>
                                                                        <option value="${result.pkj[0]['kec']}">${result.pkj[0]['kec']}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="txtDesa_SP" class="col-lg-4 control-label">Desa</label>
                                                                <div class="col-lg-8">
                                                                    <select class="select select2 form-control Desa_SP" name="txtDesa_SP" style="width: 100% !important" required>
                                                                        <option value="${result.pkj[0]['desa']}">${result.pkj[0]['desa']}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="inp_kodepos_SP" class="col-lg-4 control-label">Kodepos</label>
                                                                <div class="col-lg-8">
                                                                    <input type="number" name="inp_kodepos_SP" class="form-control inp_kodepos_SP" max="99999" value="${kodepos}">
                                            </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label for="txt_noHP_SP" class="col-lg-4 control-label">Nomor HP</label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" name="txt_noHP_SP" class="form-control txt_noHP_SP" value="${result.pkj[0]['nohp']}">
                                            </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <div class="col-lg-2"></div>
                                                                        <div class="col-lg-1">
                                                                            <input type="checkbox" class="cekSameNoHP">
                                            </div>
                                                                            <div class="col-lg-9">
                                                                                <p style="color: red;"><i>*) Beri tanda centang apabila No. Telp sama dengan No. HP</i></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <label for="txt_noTlp_SP" class="col-lg-4 control-label">Telephone</label>
                                                                            <div class="col-lg-8">
                                                                                <input type="text" name="txt_noTlp_SP" class="form-control txt_noTlp_SP" value="${result.pkj[0]['telepon']}">
                                            </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="box-body panel-footer text-center">
                                                                    <button type="button" class="btn btn-success btn_Save_SP" name="button"><span class="fa fa-check">&emsp;Simpan</span></button>
                                                                </div>
                                                            </div>
                    </form>
                                                    </div>`)

                    $('.cekSameNoHP').on('change', function (e) {
                        if ($(this).is(':checked')) {
                            let noHP = $('.txt_noHP_SP').val()
                            $('.txt_noTlp_SP').val(noHP)
                        }
                        if (!$(this).is(':checked')) {
                            $('.txt_noTlp_SP').val(null)
                        }
                    })

                    //redeclarated DOM
                    $('.txtNPWP_SP').mask('00.000.000.0-000.000', { placeholder: '00.000.000.0-000.000' })

                    $('.txt_noHP_SP, .txt_noTlp_SP').mask('0000 0000 0000', { placeholder: '0000 0000 0000' })

                    $('.slc_loker_SP').select2({
                        placeholder: "---Lokasi Kerja---",
                        allowClear: true
                    })
                    $('.txt_kd_jabatan_SP').select2({
                        placeholder: "---Kode Jabatan---",
                        allowClear: true
                    })
                    $('.slc_jab_upah').select2({
                        placeholder: "---Kode Jabatan Upah---",
                        allowClear: true
                    })
                    $('.txt_ruang_SP').select2({
                        placeholder: "---Ruang Kerja---",
                        allowClear: true
                    })
                    $('.txt_Shift_SP').select2({
                        placeholder: "---Shift Kerja---",
                        allowClear: true
                    })

                    $('.inp_jenkel_SP').select2()

                    $('.inp_Agama_SP').select2({
                        placeholder: "---Pilih Agama---"
                    })
                    $('.txt_status_pri').select2({
                        placeholder: "---Pilih Status Nikah---",
                        allowClear: true
                    })
                    $('.slc_kantor_SP').select2({
                        placeholder: "---Masukkan Kantor Asal---",
                        allowClear: true
                    })
                    $('.slc_asal_SP').select2({
                        placeholder: "---Asal Perusahaan---",
                        allowClear: true
                    })
                    $('.slc_makan_SP').select2({
                        placeholder: "---Masukkan tempat Makan---",
                        allowClear: true
                    })
                    $('.forSelectJurusan2').select2({
                        placeholder: "---Jurusan---",
                        allowClear: true,
                        tags: true
                    })
                    $('.forSelectSekulah2').select2({
                        placeholder: "---Sekolah---",
                        allowClear: true,
                        tags: true
                    })
                    $('.txtPend_SP').select2({
                        placeholder: "---Pendidikan Terakhir---",
                        allowClear: true,
                        tags: true
                    })

                    $(".inp_tgl_lahir").datepicker({
                        format: 'yyyy-mm-dd',
                        todayHighlight: true,
                        autoApply: true,
                        autoclose: true,
                        setDate: new Date()
                    })

                    $('.txt_kd_jabatan_SP').on('change', function () {
                        $.ajax({
                            type: 'post',
                            data: {
                                kd: $(this).val(),
                                kodesie: $('#slc_kodesie_SP').val()
                            },
                            url: baseurl + 'AdmSeleksi/SuratPenyerahan/getJabatan',
                            dataType: 'json',
                            beforeSend: function () {
                                swal.fire({
                                    html: '<img src="' + loading + '">',
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                    background: 'transparent',
                                })
                            },
                            success: function (res) {
                                swal.close()
                                $('.txt_jabatan_SP').val(res)
                            }
                        })
                    })

                    $('input[type=number][max]:not([max=""])').on('input', function (ev) {
                        var $this = $(this);
                        var maxlength = $this.attr('max').length;
                        var value = $this.val();
                        if (value && value.length >= maxlength) {
                            $this.val(value.substr(0, maxlength));
                        }
                    })

                    $('.Provinsi_SP').select2({
                        minimumInputLength: 2,
                        allowClear: true,
                        placeholder: 'Provinsi',
                        ajax: {
                            url: baseurl + "MasterPekerja/DataPekerjaKeluar/provinsiPekerja",
                            dataType: 'json',
                            type: "GET",
                            data: function (params) {
                                return { term: params.term };
                            },
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (obj) {
                                        return {
                                            id: obj.id_prov,
                                            text: obj.nama,
                                        };
                                    })

                                };
                            },
                        },
                    }).on('change', function () {
                        $('.Kabupaten_SP').select2("val", "");
                        $('.Kecamatan_SP').select2("val", "");
                        $('.Desa_SP').select2("val", "");
                    })


                    $('.Kabupaten_SP').select2({
                        minimumInputLength: 0,
                        allowClear: true,
                        placeholder: 'Kabupaten',
                        ajax: {
                            url: baseurl + "MasterPekerja/DataPekerjaKeluar/kabupatenPekerja",
                            dataType: 'json',
                            type: "GET",
                            data: function (params) {
                                return {
                                    term: params.term,
                                    prov: $(".Provinsi_SP").val(),
                                };
                            },
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (ok) {
                                        return {
                                            id: ok.id_kab,
                                            text: ok.nama,
                                        };
                                    })

                                };
                            },
                        },
                    });

                    $('.Kecamatan_SP').select2({
                        minimumInputLength: 0,
                        allowClear: true,
                        placeholder: 'Kecamatan',
                        ajax: {
                            url: baseurl + "MasterPekerja/DataPekerjaKeluar/kecamatanPekerja",
                            dataType: 'json',
                            type: "GET",
                            data: function (params) {
                                return {
                                    term: params.term,
                                    kab: $(".Kabupaten_SP").val(),
                                };
                            },
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (ok) {
                                        return {
                                            id: ok.id_kec,
                                            text: ok.nama,
                                        };
                                    })

                                };
                            },
                        },
                    });

                    $('.Desa_SP').select2({
                        minimumInputLength: 0,
                        allowClear: true,
                        placeholder: 'Kelurahan',
                        ajax: {
                            url: baseurl + "MasterPekerja/DataPekerjaKeluar/desaPekerja",
                            dataType: 'json',
                            type: "GET",
                            data: function (params) {
                                return {
                                    term: params.term,
                                    kec: $(".Kecamatan_SP").val(),
                                };
                            },
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (ok) {
                                        return {
                                            id: ok.id_kel,
                                            text: ok.nama,
                                        };
                                    })

                                };
                            },
                        },
                    });

                    $('.btn_Save_SP').on('click', function () {
                        const DataNew = {
                            jenis_pkj: pengganti,
                            //Data Diri
                            nama: $('.def_Nama_pkj').val(),
                            agama: $('.inp_Agama_SP').val(),
                            jenkel: $('.inp_jenkel_SP').val(),
                            tmp_lhr: $('.txtLokasi_Lahir').val(),
                            tgl_lhr: $('.inp_tgl_lahir').val(),
                            status: $('.txt_status_pri').val(),
                            nik: $('.txtNIK_SP').val(),
                            npwp: $('.txtNPWP_SP').val(),
                            no_kk: $('.txt_noKK_SP').val(),
                            pend: $('.txtPend_SP').val(),
                            skul: $('.txtSkul_SP').val(),
                            jurusan: $('.txtJurusan_SP').val(),
                            alamat: $('.txt_alamat_SP').val(),
                            prov: $('.Provinsi_SP').select2('data')[0].text,
                            kab: $('.Kabupaten_SP').select2('data')[0].text,
                            kec: $('.Kecamatan_SP').select2('data')[0].text,
                            desa: $('.Desa_SP').select2('data')[0].text,
                            kd_pos: $('.inp_kodepos_SP').val(),
                            no_tlp: $('.txt_noTlp_SP').val(),
                            no_hp: $('.txt_noHP_SP').val(),
                            nikah: $('.txt_status_pri').val(),
                            //Data perusahaan
                            sls_magang: $('#inp_tgl_Keluar_SP').val(),
                            MasaPKL: $('#HideMasaPKL').val(),
                            kelas: $('#kelas_pkj_SP').val(),
                            otsorcing: $('.slc_asal_SP').val(),
                            // slc_pkj_SP: $('#slc_pkj_SP').val(),
                            txt_tgl_SP: $('#txt_tgl_SP').val(),
                            golongan: $('#slc_gol_pkj_SP').val(),
                            jenis: $('#slc_pkj_SP').val(),
                            ruang_lingkup: $('#slc_RuangLingkup_SP').val(),
                            kode: $('#inputKode').val(),
                            kodesie: $('#slc_kodesie_SP').val(),
                            pekerjaan: $('#txtKerja_SP').val(),
                            tempat: $('#txtTmpPenyerahan').val(),
                            noind: $('.input_noind_baru_SP').val(),
                            kantor: $('.slc_kantor_SP').val(),
                            loker: $('.slc_loker_SP').val(),
                            ruang: $('.txt_ruang_SP').val(),
                            no_keb: $('.no_kebutuhan_SP').val(),
                            kd_lmrn: $('.txt_Lamaran_SP').val(),
                            tmp_mkn: $('.slc_makan_SP').val(),
                            shift: $('.txt_Shift_SP').val(),
                            kd_jabatan: $('.txt_kd_jabatan_SP').val(),
                            jabatan: $('.txt_jabatan_SP').val(),
                            status_jabatan: $('.inp_stat_jbtn').val(),
                            kd_hubker: $('.inp_kd_jbtn').val(),
                            jabatan_upah: $('.slc_jab_upah').val(),
                            //Data Hubker
                            ori_hubker: $('#txt_try_hubker').val(),
                            kontrak_hubker: $('#txt_lama_kontrak').val(),
                            ik_hubker: $('#txt_IK_hubker').val(),
                            //Data Seleksi
                            ori_seleksi: $('#txt_try_seleksi').val(),
                            'akt_seleksi': $('#inp_tgl_angkat_SP').val()
                        }

                        var empty = true;
                        $('input[type="text"]').not(":hidden").each(function () {
                            if ($(this).val() == "") {
                                empty = false;
                                return false;
                            }
                        })

                        if (!$('#slc_RuangLingkup_SP').val()) {
                            swal.fire('Warning', 'Ruang Lingkup belum diisi', 'warning')
                        } if (!$('.txt_kd_jabatan_SP').val()) {
                            swal.fire('Warning', 'Kode Jabatan Masih Kosong', 'warning')
                        } else {
                            if (!empty) {
                                swal.fire({
                                    title: 'Warning',
                                    html: '<p>Data Belum Lengkap !</p><p>Apakah anda yakin ingin menyimpan data ?</p>',
                                    type: 'warning',
                                    showCancelButton: true
                                }).then(result => {
                                    if (result.value) {
                                        $.ajax({
                                            type: 'POST',
                                            data: {
                                                DataNew
                                            },
                                            dataType: 'json',
                                            url: baseurl + "AdmSeleksi/SuratPenyerahan/saveDataPenyerahan",
                                            beforeSend: function () {
                                                swal.fire({
                                                    html: '<img src="' + loading + '">',
                                                    allowOutsideClick: false,
                                                    showConfirmButton: false,
                                                    background: 'transparent',
                                                })
                                            },
                                            success: result => {
                                                swal.close()
                                                if (result == 'OK') {
                                                    swal.fire({
                                                        title: 'Success',
                                                        text: 'Data Berhasil Disimpan',
                                                        type: 'success',
                                                        allowOutsideClick: false,
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                    }).then(() => {
                                                        forTable()
                                                    })
                                                }
                                            }
                                        })
                                    }
                                })
                            } else {
                                swal.fire({
                                    title: 'Warning',
                                    text: 'Apakah anda yakin ingin menyimpan data ?',
                                    type: 'warning',
                                    showCancelButton: true
                                }).then(result => {
                                    if (result.value) {
                                        $.ajax({
                                            type: 'POST',
                                            data: {
                                                DataNew
                                            },
                                            dataType: 'json',
                                            url: baseurl + "AdmSeleksi/SuratPenyerahan/saveDataPenyerahan",
                                            beforeSend: function () {
                                                swal.fire({
                                                    html: '<img src="' + loading + '">',
                                                    allowOutsideClick: false,
                                                    showConfirmButton: false,
                                                    background: 'transparent',
                                                })
                                            },
                                            success: result => {
                                                swal.close()
                                                if (result == 'OK') {
                                                    swal.fire({
                                                        title: 'Success',
                                                        text: 'Data Berhasil Disimpan',
                                                        type: 'success',
                                                        allowOutsideClick: false,
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                    }).then(() => {
                                                        forTable()
                                                    })
                                                }
                                            }
                                        })
                                    }
                                })
                            }
                        }
                    })
                    //batas akhir didalam success
                }
            })
        }
    })

    $('#tabelDaftarPekerjaSP').dataTable()

    $('elem').click(function () { })

    $('.txt_kd_jabatan_SP').on('change', function () {
        $.ajax({
            type: 'post',
            data: {
                kd: $(this).val(),
                kodesie: $('.inpKodesie_SP').val()
            },
            url: baseurl + 'AdmSeleksi/SuratPenyerahan/getJabatan',
            dataType: 'json',
            beforeSend: function () {
                swal.fire({
                    html: '<img src="' + loading + '">',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    background: 'transparent',
                })
            },
            success: function (res) {
                swal.close()
                $('.txt_jabatan_SP').val(res)
            }
        })
    })

    $('.cekSameNoHP').on('ifChecked ifUnchecked', function (e) {
        if ($(this).is(':checked')) {
            let noHP = $('.txt_noHP_SP').val()
            $('.txt_noTlp_SP').val(noHP)
        }
        if (!$(this).is(':checked')) {
            $('.txt_noTlp_SP').val(null)
        }
    })

    $('#btn_Cetak_SP').on('click', function () {
        let kepada = $('#slc_Kepada_SP').val()
        let pekerja = [];
        $.each($("input[class='childCekAll']:checked"), function () {
            pekerja.push($(this).val());
        })
        let ptgs1 = $('#slc_petugas1_SP').val()
        let ptgs2 = $('#slc_petugas2_SP').val()
        let app = $('#slc_approval_SP').val()
        let tgl_cetak = $('#txt_tglCetak_SP').val()
        let tgl_serah = $('#txt_tgl_SP').val()
        let kodesie = $('#slc_kodesie_SP').val()
        let jenis = $('#slc_pkj_SP').val()

        if (!kepada) {
            swal.fire({
                title: 'Peringatan !',
                text: 'Kepada siapa surat ini akan ditujukan ? Harap isikan tujuan surat',
                type: 'warning',
                allowOutsideClick: false
            })
        } else {
            swal.fire({
                title: 'Warning',
                text: 'Apakah anda yakin ingin mencetak ?',
                type: 'warning',
                showCancelButton: true,
                allowOutsideClick: false
            }).then(result => {
                if (result.value) {
                    window.open(baseurl + `AdmSeleksi/SuratPenyerahan/previewPDF?approve=${app}&&kepada=${kepada}&&petugas=${ptgs1}&&petugas2=${ptgs2}&&pekerja=${pekerja}&&tgl_cetak=${tgl_cetak}&&tgl_serah=${tgl_serah}&&kodesie=${kodesie}&&jenis=${jenis}`)
                }
            })
        }
    })

    $('#button_edit').on('click', () => {
        swal.fire({
            title: 'Warning',
            html: '<p>Apakah anda yakin ingin mengupdate data ?</p>',
            type: 'warning',
            showCancelButton: true,
            allowOutsideClick: false
        }).then(result => {
            if (result.value) {
                swal.fire({
                    title: 'Success',
                    text: 'Sukses mengupdate data',
                    type: 'success',
                    timer: '1500',
                    allowClickOutside: false,
                    showConfirmButton: false
                }).then(() => {
                    $('#button_simpan_edit').click()
                    return true
                })
            }
        })
    })
})


function forTable() {
    let kodesie = $('#slc_kodesie_SP').val(),
        tanggal = $('#txt_tgl_SP').val(),
        kode = $('#slc_pkj_SP').val(),
        lingkup = $('#slc_RuangLingkup_SP').val()
    $.ajax({
        type: 'POST',
        data: {
            kodesie,
            tanggal,
            kode,
            lingkup
        },
        dataType: 'json',
        url: baseurl + 'AdmSeleksi/SuratPenyerahan/getDataTable',
        success: (response) => {
            $('.daftarPekerja').attr('hidden', false)
            $('#cekAll_Create').iCheck('uncheck')
            $('.cekNoindSP').iCheck()
            $('#plus_pkj_SP').html('')
            $('#tabelDaftarPekerjaSP').DataTable({
                destroy: true,
                data: response,
                columns: [
                    {
                        data: 'kode',
                        render(data) {
                            return `<input type="checkbox" class="childCekAll" value="${data}">`;
                        }
                    },
                    {
                        data: 'noind'
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'kodesie'
                    },
                    {
                        data: 'seksi'
                    },
                    {
                        data: 'gabungan',
                        render(data) {
                            return `<a href="${baseurl + 'AdmSeleksi/SuratPenyerahan/EditData?kode=' + data}" type="button" class="btn btn-primary" target="_blank"><i class="fa fa-pencil-square"></i></a>`;
                        }
                    }
                ]
            })

            $(document).on('icheck', function () {
                $('input[type=checkbox].childCekAll').iCheck({
                    checkboxClass: 'icheckbox_square-blue'
                })
            }).trigger('icheck')
            $('input.childCekAll').on('ifChanged', function (event) {
                checkedValue(response[0].kodesie)
                if ($('.childCekAll:checked').length == $('.childCekAll').length) {
                    $('#cekAll_Create').prop('checked', true);
                } else {
                    $('#cekAll_Create').prop('checked', false);
                }
                $('input#cekAll_Create').iCheck('update');

                if ($('.childCekAll:checked').length > 0) {
                    $('.hide_Perusahaan').attr('hidden', false)
                } else {
                    $('.hide_Perusahaan').attr('hidden', true)
                }
            });
        }
    })
    return
}

function checkedValue(kodesie) {
    let pekerja = [];
    $.each($("input[class='childCekAll']:checked"), function () {
        pekerja.push($(this).val());
    })
    let seksi = $('#txtSeksiPenyerahan').val(),
        jenis = $('#slc_pkj_SP').val()

    $.ajax({
        type: 'POST',
        data: {
            kodesie,
            pekerja,
            jenis
        },
        url: baseurl + "AdmSeleksi/SuratPenyerahan/getKepada",
        dataType: 'json',
        success: (res) => {
            const kd_jabatan = []
            for (let a = 0; a < res.length; a++) {
                if (res[a].jabatan.includes(seksi)) {
                    kd_jabatan.push(res[a].kd_jabatan);
                }
            }

            let isi = ''
            for (let i = 0; i < res.length; i++) {

                if (res[i].jabatan.includes(seksi) === true && parseInt(res[i].kd_jabatan) === Math.max(parseInt(kd_jabatan))) {
                    selek = 'selected'
                } else {
                    if (res[i].jabatan.includes(seksi) === true && parseInt(res[i].kd_jabatan) === (Math.max(parseInt(kd_jabatan)) - i)) {
                        selek = 'selected'
                    } else if (parseInt(res[i].kd_jabatan) === Math.max(parseInt(kd_jabatan)) - i) {
                        selek = 'selected'
                    } else {
                        selek = ''
                    }
                }

                isi += `<option ${selek
                    } value = "${res[i].kodesie + '|' + res[i].kd_jabatan}" > ${res[i].kodesie + '|' + res[i].jabatan}</option > `
            }
            $('#slc_Kepada_SP').html(isi).trigger('change')
        }
    })
}

// ------------------BPJS ketenagakerjaan--------------------
$(document).ready(function () {
    $('.inp_rangebpjs').daterangepicker()
    $('div#tbl_bpjs_lanjutan_length.dataTables_length').addClass('col-lg-3')
    $('div.dt-buttons.btn-group').addClass('col-lg-3')
    $('div#tbl_bpjs_lanjutan_filter.dataTables_filter').addClass('col-lg-3')
    $('#tbl_bpjs_lanjutan').DataTable({
        dom: '<"top"lBf>t<"bottom"ip><"clear">',
        buttons: [
            {
                extend: 'excel',
                className: "btn btn-success",
                title: "Data Proses BPJS Lanjutan"
            },
            {
                extend: 'pdf',
                className: "btn btn-danger",
                title: "Data Proses BPJS Lanjutan"
            }
        ]
    })
    $('#tbl_bpjs_tk').DataTable({
        dom: 'Blrftip',
        buttons: [
            {
                extend: 'excel',
                className: "btn btn-success",
                title: "Data Proses BPJS Tenaga Kerja"
            },
            {
                extend: 'pdf',
                className: "btn btn-danger",
                title: "Data Proses BPJS Tenaga Kerja"
            }
        ]
    })
    $('#tbl_bpjs_out').DataTable({
        dom: 'Blrftip',
        buttons: [
            {
                extend: 'excel',
                className: "btn btn-success",
                title: "Data Proses BPJS Pekerja Keluar"
            },
            {
                extend: 'pdf',
                className: "btn btn-danger",
                title: "Data Proses BPJS Pekerja Keluar"
            }
        ]
    })
})


function openNav(a) {
    if (a == '1') {
        document.getElementById("myNav").style.width = "100%";
    } else if (a == '2') {
        document.getElementById("myNav2").style.width = "100%";
    } else if (a == '3') {
        document.getElementById("myNav3").style.width = "100%";
    } else if (a == '4') {
        document.getElementById("myNav4").style.width = "100%";
    } else if (a == '5') {
        document.getElementById("myNav5").style.width = "100%";
    }
}

function closeNav() {
    $('.myNav').attr('style', 'width: 0%');
}