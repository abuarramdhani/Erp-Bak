//---------------Surat Penyerahan--------------------
$(document).on('input keyup keypress', 'input.select2-search__field', function(e) {
    $(this).val($(this).val().toUpperCase())
    $('#select2-results__option').val($(this).val().toUpperCase())
})
$(document).ready(function () {
    let loading = baseurl + 'assets/img/gif/loading11.gif'

    setTimeout(() => {
        $('.input_Pekerja_SP').on('ifChecked', function() {
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
            }else {
                let Hidekelas = ''
            }

            if (!kode) {
                swal.fire({
                    title: 'Peringatan !',
                    text: 'Kode Seksi belum diisi !',
                    type: 'warning',
                    allowOutsideClick: false
                }).then(result => {
                    ($('#slc_pkj_SP').val() == '1')? $('#kelas_pkj_SP').attr('hidden', false):$('#kelas_pkj_SP').attr('hidden', true)
                    $('.input_Pekerja_SP').iCheck('uncheck')
                })
            Hidekelas
            }else {
                sumThey = jenis == '1' ? 0 : 2

                $('#slc_pri_pkj_SP').select2({
                    minimumInputLength: sumThey,
                    ajax: {
                        url: baseurl+"AdmSeleksi/SuratPenyerahan/getDataPekerja",
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
                                        text: trig+' - '+a.nama,
                                    }
                                })
                            }
                        }
                    }
                })
            }
        })
    }, 5000)

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

    $('input[type=number][max]:not([max=""])').on('input', function(ev) {
      var $this = $(this);
      var maxlength = $this.attr('max').length;
      var value = $this.val();
      if (value && value.length >= maxlength) {
        $this.val(value.substr(0, maxlength));
      }
    })

    $('.Provinsi_SP').on('change',function(){
        $('.Kabupaten_SP').select2("val","");
        $('.Kecamatan_SP').select2("val","");
        $('.Desa_SP').select2("val","");
    })

    $('.Provinsi_SP').select2({
        minimumInputLength: 2,
        allowClear: true,
        placeholder: 'Provinsi',
        ajax: {
            url: baseurl+"MasterPekerja/DataPekerjaKeluar/provinsiPekerja",
            dataType:'json',
            type: "GET",
            data: function (params) {
                return {term: params.term};
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
    });


    $('.Kabupaten_SP').select2({
        minimumInputLength: 0,
        allowClear: true,
        placeholder: 'Kabupaten',
        ajax: {
            url: baseurl+"MasterPekerja/DataPekerjaKeluar/kabupatenPekerja",
            dataType:'json',
            type: "GET",
            data: function (params) {
                return {term: params.term,
                        prov : $(".Provinsi_SP").val(),
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
            url: baseurl+"MasterPekerja/DataPekerjaKeluar/kecamatanPekerja",
            dataType:'json',
            type: "GET",
            data: function (params) {
                return {term: params.term,
                        kab : $(".Kabupaten_SP").val(),
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
            url: baseurl+"MasterPekerja/DataPekerjaKeluar/desaPekerja",
            dataType:'json',
            type: "GET",
            data: function (params) {
                return {term: params.term,
                        kec : $(".Kecamatan_SP").val(),
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
            elaa = moment().add(6, 'month').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('6')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', true)
            $('#tgl_ik_hubker').attr('hidden', true)
        }else if (a == '2') {
            kode.val('D')
            try_hubker.val('30')
            try_seleksi.val('30')
            elaa = moment().add(30, 'month').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('30')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', true)
            $('#tgl_ik_hubker').attr('hidden', true)
        }else if (a == '3') {
            kode.val('E')
            try_hubker.val('9')
            try_seleksi.val('9')
            elaa = moment().add(9, 'month').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('9')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', true)
            $('#tgl_ik_hubker').attr('hidden', true)
        }else if (a == '4') {
            kode.val('H')
            try_hubker.val('1.5')
            try_seleksi.val('1.5')
            elaa = moment().add(1, 'month').add(15, 'days').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('24')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', false)
            $('#tgl_ik_hubker').attr('hidden', false)
        }else if (a == '5') {
            kode.val('J')
            try_hubker.val('6')
            try_seleksi.val('6')
            elaa = moment().add(6, 'month').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('24')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', false)
            $('#tgl_ik_hubker').attr('hidden', true)
        }else if (a == '6') {
            kode.val('G')
            try_hubker.val('0')
            try_seleksi.val('6')
            elaa = moment().add(6, 'month').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('6')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', false)
            $('#tgl_ik_hubker').attr('hidden', true)
        }else if (a == '7') {
            kode.val('F')
            try_seleksi.val('1')
            elaa = moment().add(1, 'month').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val(null)
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', true)
            $('#LM_K_Hubker').attr('hidden', true)
            $('#tgl_ik_hubker').attr('hidden', true)
        }else if (a == '8') {
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
        }else if (a == '9') {
            kode.val('K')
            try_hubker.val('1')
            try_seleksi.val('1')
            elaa = moment().add(1, 'month').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('3')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', false)
            $('#tgl_ik_hubker').attr('hidden', false)
        }else if (a == '10') {
            kode.val('C')
            try_hubker.val('9')
            try_seleksi.val('9')
            elaa = moment().add(9, 'month').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('9')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', false)
            $('#tgl_ik_hubker').attr('hidden', true)
        }else if (a == '11') {
            kode.val('C')
            try_hubker.val('2.5')
            try_seleksi.val('2.5')
            elaa = moment().add(2, 'month').add(15, 'days').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('24')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', false)
            $('#tgl_ik_hubker').attr('hidden', true)
        }else if (a == '12') {
            kode.val('P')
            try_hubker.val('1')
            try_seleksi.val('1')
            elaa = moment().add(1, 'month').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('3')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', false)
            $('#tgl_ik_hubker').attr('hidden', false)
        }else if (a == '13') {
            kode.val('Q')
            try_seleksi.val('1')
            elaa = moment().add(1, 'month').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val(null)
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', true)
            $('#LM_K_Hubker').attr('hidden', true)
            $('#tgl_ik_hubker').attr('hidden', true)
        }else if (a == '14') {
            kode.val('C')
            try_hubker.val('1')
            try_seleksi.val('1')
            elaa = moment().add(1, 'month').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('3')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', false)
            $('#tgl_ik_hubker').attr('hidden', false)
        }else if (a == '15') {
            kode.val('T')
            try_hubker.val('1.5')
            try_seleksi.val('1.5')
            elaa = moment().add(1, 'month').add(15, 'days').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('24')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', false)
            $('#tgl_ik_hubker').attr('hidden', false)
        }else if (a == '16') {
            kode.val('N')
            try_hubker.val('0')
            try_seleksi.val('0')
            elaa = moment().add(1, 'month').add(15, 'days').format('YYYY-MM-DD')
            $('#txt_lama_kontrak').val('6')
            $('#hide_tgl_Selesai_SP').attr('hidden', true)
            $('.hideAllHubker').removeClass('hide')
            $('#LM_Hide_Hubker').attr('hidden', false)
            $('#LM_K_Hubker').attr('hidden', false)
            $('#tgl_ik_hubker').attr('hidden', true)
        }
        if (elaa != '') {
            $("#inp_tgl_angkat_SP").datepicker("setDate",$.datepicker.parseDate( "yy-mm-dd", elaa ))
        }
        if (try_hubker.val()) {
            if ($('#tgl_ik_hubker').attr('hidden', false)) {
                let isi = try_hubker.val().split(/[,.]/)

                if (isi[1]) {
                    let DateFresh = moment().add(Number(3)+Number(isi[0]), 'month').add( 15, 'days').format('YYYY-MM-DD')
                    $('#txt_IK_hubker').datepicker("setDate",$.datepicker.parseDate( "yy-mm-dd", DateFresh ))
                }else {
                    let DateFresh = moment().add(Number(3)+Number(isi[0]), 'month').format('YYYY-MM-DD')
                    $('#txt_IK_hubker').datepicker("setDate",$.datepicker.parseDate( "yy-mm-dd", DateFresh ))
                }
            }
        }

        if ($('.hideAllHubker').hasClass('hide')) {
            $('.nambahStyle').removeAttr('style')
        }else {
            $('.nambahStyle').attr('style','margin-top: 23px')
        }

        if (a == '10' || a == '7' || a == '4' || a == '3' || a == '13' || a == '15') {
            $('#gol_Pekerja_SP').attr('hidden', false)
            let golongan_baru = ["","-","1","2","3","A","B","C"]
            let golongan_pkl = ["","-","PKL1","PKL2","PKL3"]
            let opsi = ''
            if (a == '7' || a == '13') {
                for (var i = 0; i < golongan_pkl.length; i++) {
                    opsi += `<option value="${golongan_pkl[i]}">${golongan_pkl[i]}</option>`
                }
            }else {
                for (var i = 0; i < golongan_baru.length; i++) {
                    opsi += `<option value="${golongan_baru[i]}">${golongan_baru[i]}</option>`
                }
            }
            $('#slc_gol_pkj_SP').html(opsi)
        }else {
            $('#gol_Pekerja_SP').attr('hidden', true)
        }
        (a == '1')? $('#kelas_pkj_SP').attr('hidden', false):$('#kelas_pkj_SP').attr('hidden', true)

        let kodein = kode.val()
        $.ajax({
            type: 'post',
            data: {
                kode: kodein
            },
            dataType: 'json',
            url: baseurl+'AdmSeleksi/SuratPenyerahan/getPekerjaan',
            success: function (data) {
                $('.input_noind_baru_SP').val(data.noind)
                $('#slc_kodesie_SP').attr('disabled', false)
                let kodesie_butuh = '<option></option>'
                for (var i = 0; i < data.butuh.length; i++) {
                    kodesie_butuh += `<option value="`+data.butuh[i]['kodesie']+`">[`+data.butuh[i]['kodesie']+`] - `+data.butuh[i]['seksi']+` - `+data.butuh[i]['pekerjaan']+`</option>`
                }
                $('#slc_kodesie_SP').html(kodesie_butuh)
            }
        })
    })

    $('#txt_try_seleksi').on('keyup', function () {
        let isi = $(this).val().split(/[,.]/)
        elaa = moment().add($(this).val(), 'month').format('YYYY-MM-DD')

        if (isi[1]) {
            let newEla = moment().add(isi[0], 'month').add(15, 'days').format('YYYY-MM-DD')
            $('#inp_tgl_angkat_SP').val(newEla)
        }else {
            $('#inp_tgl_angkat_SP').val(elaa)
        }
    })

    $('#txt_try_hubker').on('keyup', function () {
        let isi = $(this).val().split(/[,.]/)

        if (isi[1]) {
            let DateFresh = moment().add(Number(3)+Number(isi[0]), 'month').add(15, 'days').format('YYYY-MM-DD')
            $('#txt_IK_hubker').datepicker("setDate",$.datepicker.parseDate( "yy-mm-dd", DateFresh ))
        }else {
            let DateFresh = moment().add(Number(3)+Number(isi[0]), 'month').format('YYYY-MM-DD')
            $('#txt_IK_hubker').datepicker("setDate",$.datepicker.parseDate( "yy-mm-dd", DateFresh ))
        }
    })

    $('#slc_gol_pkj_SP').on('change', function () {
        let text = $(this).val()
        if (text == 'PKL1') {
            $('#keteranganPKL').html('<i>0 s/d 6 Bulan</i>')
            $('#HideMasaPKL').val('6')
        }else if (text == 'PKL2') {
            $('#keteranganPKL').html('<i>6 s/d 12 Bulan</i>')
            $('#HideMasaPKL').val('12')
        }else if (text == 'PKL3') {
            $('#keteranganPKL').html('<i>12 s/d 36 Bulan</i>')
            $('#HideMasaPKL').val('36')
        }else {
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
                    html: '<img src="'+loading+'">',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    background: 'transparent',
                })
            },
            url: baseurl+'AdmSeleksi/SuratPenyerahan/kodesie',
            success: function (data) {
                $('#txtKerja_SP').val('').trigger('change')
                swal.close()
                let result = '<option></option>'
                for (var i = 0; i < data.kerja.length; i++) {
                    result += '<option value='+data.kerja[i]['kdpekerjaan']+'>'+data.kerja[i]['pekerjaan']+'</option>'
                }
                $('#txtKerja_SP').html(result)
                $('#txtDeptPenyerahan').val(data.kodesie[0]['dept'])
                $('#txtBidPenyerahan').val(data.kodesie[0]['bidang'])
                $('#txtUnitPenyerahan').val(data.kodesie[0]['unit'])
                $('#txtSeksiPenyerahan').val(data.kodesie[0]['seksi'])
                $('#txtTmpPenyerahan').val(data.kodesie[0]['seksi'])
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
            $('.ganti_hide').attr({'disabled': true, 'hidden': true}).iCheck('uncheck').closest('form')
        }else {
            $('.ganti_hide').attr({'disabled': false, 'hidden': false}).iCheck('check').closest('form')
        }

        if (jenis == '' || jenis == null) {
            swal.fire({
                title: 'Warning',
                text: 'Harap Pilih Jenis Pekerja !',
                type: 'warning',
                allowOutsideClick: false
            })
        }else if (isi == '') {
            swal.fire({
                title: 'Warning',
                text: 'Harap Pilih Pekerja Yang diserahkan !',
                type: 'warning',
                allowOutsideClick: false
            })
        }else {
            $.ajax({
                type: 'post',
                data: {formUtama: cek},
                dataType: 'json',
                beforeSend: function () {
                    swal.fire({
                        html: '<img src="'+loading+'">',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        background: 'transparent',
                    })
                },
                url: baseurl+'AdmSeleksi/SuratPenyerahan/plusPekerja',
                success: function (result) {
                    swal.close()
                    Outsorcing == '1'? $('#kelas_pkj_SP').attr('hidden', false):$('#kelas_pkj_SP').attr('hidden', true)
                    $('.input_Pekerja_SP').iCheck('uncheck')
                    $('#slc_pri_pkj_SP').val('').trigger('change')
                    let cekHide = result.jenis == 1 ? 'hidden' : ''
                    let noind = result.jenis == 1 ? '' : result.pkj[0]['noind']
                    let pengganti = result.jenis == 1 ? 'disabled hidden' : 'checked'
                    let no_keb = result.jenis == 1 ? result.pkj[0]['kodekebutuhan'] : result.pkj[0]['nokeb']
                    let kelahiran = result.jenis == 1 ? result.pkj[0]['tmplahir'] : result.pkj[0]['templahir']
                    let kodepos = result.jenis == 1 ? '' : result.pkj[0]['kodepos']
                    let no_kk = result.jenis == 1 ? '' : result.pkj[0]['no_kk']
                    let status_nikah = result.jenis == 1 ? '' : result.pkj[0]['statnikah']
                    let agama = ["ISLAM","KATHOLIK","KRISTEN","HINDU","BUDHA","KONGHUCU"]
                    let jenkel = ["L","P"]
                    let nikah = [
                        ["K","KAWIN"],
                        ["BK","BELUM KAWIN"],
                        ["KS","KAWIN SIRI"]
                    ]
                    let sekulah = ["SD","SMP","SMA","SMK","D1","D3","D4","S1","S2","S3"]
                    let pendidikan = ''
                    if (result.pkj[0]['pendidikan'] == 'SLTP') {
                        pendidikan += 'SMP'
                    }else if (result.pkj[0]['pendidikan'] == 'SLTA') {
                        pendidikan += 'SMA'
                    }else {
                        pendidikan += result.pkj[0]['pendidikan']
                    }

                    let ana = result.pkj[0]['tgllahir'].split('/')
                    let lahir1 = new Date(ana[2]+'-'+ana[1]+'-'+ana[0])
                    let lahir = moment(lahir1).format('YYYY-MM-DD')
                    let jurusanTetap = `<input type="text" class="form-control txtJurusan_SP" name="txtJurusan_SP" style="width: 100% !important; text-transform: uppercase; !important" value="${result.pkj[0]['jurusan']}" required>`
                    let gantiJurusan = `<select class="select select2 form-control txtJurusan_SP forSelectJurusan2" name="txtJurusan_SP" autocapitalize="on" style="width: 100% !important; text-transform: uppercase; !important" required>
                                            <option></option>
                                            ${
                                                result.jurusan.map(item => {
                                                    return `<option ${item.nama_jurusan == result.pkj[0]['jurusan'] ? 'selected': ''} value="${item.nama_jurusan}">${item.nama_jurusan}</option>`
                                                }).join('')
                                            }
                                        </select>`
                    let sekolahTetap = `<input type="text" class="form-control txtSkul_SP" name="txtSkul_SP" style="width: 100% !important; text-transform: uppercase; !important" value="${result.pkj[0]['sekolah']}" required>`
                    let gantiSekolah = `<select class="select select2 form-control txtSkul_SP forSelectSekulah2" name="txtSkul_SP" style="width: 100% !important; text-transform: uppercase !important" required>
                                            <option></option>
                                            ${
                                                result.skul.map(item => {
                                                    return `<option ${item.nama_univ == result.pkj[0]['sekolah'] ? 'selected': ''} value="${item.nama_univ}">${item.nama_univ}</option>`
                                                }).join('')
                                            }
                                        </select>`
                    let jursan =  (result.jenis == '1') ? gantiJurusan : (result.jenis == '2'? jurusanTetap : gantiJurusan)
                    let sekul = (result.jenis == '1') ? gantiSekolah : (result.jenis == '2' ? sekolahTetap : gantiSekolah)

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
                                            <input type="text" name="input_noind_lama_SP" class="form-control text-left input_noind_lama_SP" value="${noind}" readonly>
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
                                        <label for="txt_Shift_SP" class="col-lg-4 control-label ">Shift</label>
                                        <div class="col-lg-8">
                                            <select class="select select2 form-control txt_Shift_SP" name="txt_Shift_SP" style="width: 100% !important" required>
                                                <option></option>
                                                ${
                                                    result.shift.map(item => {
                                                        return `<option value="${item.kd_shift}">[${item.kd_shift}] - ${item.shift}</option>`
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
                                                <input type="text" class="form-control def_Nama_pkj"  style="text-transform: uppercase !important" name="def_Nama_pkj" value="${result.pkj[0]['nama']}">
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
                                                            return `<option ${item == result.pkj[0]['agama']? 'selected': ''} value="${item}">${item}</option>`
                                                        }).join('')
                                                    }
                                                </select>
                                            </div>
                                            <label for="inp_jenkel_SP" class="col-lg-1 control-label"  style="margin-left: -15px">Gender</label>
                                            <div class="col-lg-2"  style="margin-left: 15px">
                                                <select class="select select2 form-control inp_jenkel_SP" name="inp_jenkel_SP" style="width: 100% !important" required>
                                                    <option></option>
                                                    ${
                                                        jenkel.map(item => {
                                                            return `<option ${item == result.pkj[0]['jenkel']? 'selected': ''} value="${item}">${item}</option>`
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
                                                            return `<option ${item[0] == status_nikah ? 'selected': ''} value="${item[0]}">[${item[0]}] - ${item[1]}</option>`
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
                                                            return `<option ${item == pendidikan ? 'selected': ''} value="${item}">${item}</option>`
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
                                            ${ sekul }
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="txtJurusan_SP" class="col-lg-4 control-label">Jurusan </label>
                                            <div class="col-lg-8">
                                            ${ jursan }
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="col-lg-12" ${(Outsorcing == '14' || Outsorcing == '12'|| Outsorcing == '9') ? '':'hidden'}>
                                        <div class="form-group">
                                            <label for="slc_asal_SP" class="col-lg-4 control-label">Asal</label>
                                            <div class="col-lg-8">
                                                <select class="select select2 form-control slc_asal_SP" name="slc_asal_SP" style="width: 100% !important" required>
                                                    <option></option>
                                                    ${
                                                        result.pemborong.map(item => {
                                                            let Otsorcing = (Outsorcing == '14' || Outsorcing == '12'|| Outsorcing == '9') ? item.asal_outsourcing:''
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
                        </div>
                        <div class="box-body panel-footer text-center">
                            <button type="button" class="btn btn-success btn_Save_SP" name="button"><span class="fa fa-check">&emsp;Simpan</span></button>
                        </div>
                    </form>
                    </div>`)

                    $('.cekSameNoHP').on('change', function(e) {
                        if ($(this).is(':checked')) {
                            let noHP = $('.txt_noHP_SP').val()
                            $('.txt_noTlp_SP').val(noHP)
                        }
                        if(!$(this).is(':checked')) {
                            $('.txt_noTlp_SP').val(null)
                        }
                    })

                    //redeclarated DOM
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



                    $('input[type=number][max]:not([max=""])').on('input', function(ev) {
                      var $this = $(this);
                      var maxlength = $this.attr('max').length;
                      var value = $this.val();
                      if (value && value.length >= maxlength) {
                        $this.val(value.substr(0, maxlength));
                      }
                    })

                    $('.Provinsi_SP').on('change',function(){
                        $('.Kabupaten_SP').select2("val","");
                        $('.Kecamatan_SP').select2("val","");
                        $('.Desa_SP').select2("val","");
                    })

                    $('.Provinsi_SP').select2({
                        minimumInputLength: 2,
                        allowClear: true,
                        placeholder: 'Provinsi',
                        ajax: {
                            url: baseurl+"MasterPekerja/DataPekerjaKeluar/provinsiPekerja",
                            dataType:'json',
                            type: "GET",
                            data: function (params) {
                                return {term: params.term};
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
                    });


                    $('.Kabupaten_SP').select2({
                        minimumInputLength: 0,
                        allowClear: true,
                        placeholder: 'Kabupaten',
                        ajax: {
                            url: baseurl+"MasterPekerja/DataPekerjaKeluar/kabupatenPekerja",
                            dataType:'json',
                            type: "GET",
                            data: function (params) {
                                return {term: params.term,
                                        prov : $(".Provinsi_SP").val(),
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
                            url: baseurl+"MasterPekerja/DataPekerjaKeluar/kecamatanPekerja",
                            dataType:'json',
                            type: "GET",
                            data: function (params) {
                                return {term: params.term,
                                        kab : $(".Kabupaten_SP").val(),
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
                            url: baseurl+"MasterPekerja/DataPekerjaKeluar/desaPekerja",
                            dataType:'json',
                            type: "GET",
                            data: function (params) {
                                return {term: params.term,
                                        kec : $(".Kecamatan_SP").val(),
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
                            //Data Diri
                            nama          : $('.def_Nama_pkj').val(),
                            agama         : $('.inp_Agama_SP').val(),
                            jenkel        : $('.inp_jenkel_SP').val(),
                            tmp_lhr       : $('.txtLokasi_Lahir').val(),
                            tgl_lhr       : $('.inp_tgl_lahir').val(),
                            status        : $('.txt_status_pri').val(),
                            nik           : $('.txtNIK_SP').val(),
                            no_kk         : $('.txt_noKK_SP').val(),
                            pend          : $('.txtPend_SP').val(),
                            skul          : $('.txtSkul_SP').val(),
                            jurusan       : $('.txtJurusan_SP').val(),
                            alamat        : $('.txt_alamat_SP').val(),
                            prov          : $('.Provinsi_SP').select2('data')[0].text,
                            kab           : $('.Kabupaten_SP').select2('data')[0].text,
                            kec           : $('.Kecamatan_SP').select2('data')[0].text,
                            desa          : $('.Desa_SP').select2('data')[0].text,
                            kd_pos        : $('.inp_kodepos_SP').val(),
                            no_tlp        : $('.txt_noTlp_SP').val(),
                            no_hp         : $('.txt_noHP_SP').val(),
                            nikah         : $('.txt_status_pri').val(),
                            //Data perusahaan
                            sls_magang    : $('#inp_tgl_Keluar_SP').val(),
                            MasaPKL       : $('#HideMasaPKL').val(),
                            kelas         : $('#kelas_pkj_SP').val(),
                            otsorcing     : $('.slc_asal_SP').val(),
                            slc_pkj_SP    : $('#slc_pkj_SP').val(),
                            txt_tgl_SP    : $('#txt_tgl_SP').val(),
                            golongan      : $('#slc_gol_pkj_SP').val(),
                            jenis         : $('#slc_pkj_SP').val(),
                            ruang_lingkup : $('#slc_RuangLingkup_SP').val(),
                            kode          : $('#inputKode').val(),
                            kodesie       : $('#slc_kodesie_SP').val(),
                            pekerjaan     : $('#txtKerja_SP').val(),
                            tempat        : $('#txtTmpPenyerahan').val(),
                            noind         : $('.input_noind_baru_SP').val(),
                            kantor        : $('.slc_kantor_SP').val(),
                            loker         : $('.slc_loker_SP').val(),
                            ruang         : $('.txt_ruang_SP').val(),
                            no_keb        : $('.no_kebutuhan_SP').val(),
                            kd_lmrn       : $('.txt_Lamaran_SP').val(),
                            tmp_mkn       : $('.slc_makan_SP').val(),
                            shift         : $('.txt_Shift_SP').val(),
                            //Data Hubker
                            ori_hubker    : $('#txt_try_hubker').val(),
                            kontrak_hubker: $('#txt_lama_kontrak').val(),
                            ik_hubker     : $('#txt_IK_hubker').val(),
                            //Data Seleksi
                            ori_seleksi   : $('#txt_try_seleksi').val(),
                            'akt_seleksi'   : $('#inp_tgl_angkat_SP').val()
                        }
                        var empty = true;
                        $('input[type="text"]').each(function(){
                           if($(this).val()==""){
                              empty =false;
                              return false;
                            }
                         });

                        if (!$('#slc_RuangLingkup_SP').val()) {
                            swal.fire('Warning', 'Ruang Lingkup belum diisi', 'warning')
                        }else {
                            if (!empty) {
                                swal.fire({
                                    title: 'Warning',
                                    html: '<p>Data Belum Lengkap !</p><br><p>Apakah anda yakin ingin menyimpan data ?</p>',
                                    type: 'warning',
                                    showCancelButton: true
                                }).then(result =>  {
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
                                                    html: '<img src="'+loading+'">',
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
                                                        allowOutsideClick: false
                                                    }).then(result=>{
                                                        swal.fire({
                                                            html: '<img src="'+loading+'">',
                                                            allowOutsideClick: false,
                                                            showConfirmButton: false,
                                                            background: 'transparent',
                                                        }).then(window.location.reload())
                                                    })
                                                }
                                            }
                                        })
                                    }
                                })
                            }else {
                                swal.fire({
                                    title: 'Warning',
                                    text: 'Apakah anda yakin ingin menyimpan data ?',
                                    type: 'warning',
                                    showCancelButton: true
                                }).then(result =>  {
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
                                                    html: '<img src="'+loading+'">',
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
                                                        allowOutsideClick: false
                                                    }).then(result=>{
                                                        swal.fire({
                                                            html: '<img src="'+loading+'">',
                                                            allowOutsideClick: false,
                                                            showConfirmButton: false,
                                                            background: 'transparent',
                                                        }).then(window.location.reload())
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

    $('.cekSameNoHP').on('ifChecked ifUnchecked', function(e) {
        if ($(this).is(':checked')) {
            let noHP = $('.txt_noHP_SP').val()
            $('.txt_noTlp_SP').val(noHP)
        }
        if(!$(this).is(':checked')) {
            $('.txt_noTlp_SP').val(null)
        }
    })

    $('#Cari_HasilPenyerahan').on('click', function () {
        const data = {
            kodesie : $('#slc_kodesie_SP').val(),
            tanggal : $('#txt_tgl_SP').val(),
            jenis   : $('#slc_pkj_SP').val(),
            'ruangLingkup' : $('#slc_RuangLingkup_SP').val(),
        }

        if (data.kodesie == null) {
            swal.fire('Oops..!!', 'Harap melengkapi data', 'warning')
        }else {
            $.ajax({
                type: 'POST',
                data: {
                    data:data
                },
                url: baseurl+'AdmSeleksi/SuratPenyerahan/getDataSP',
                beforeSend: () => {
                    swal.fire({
                        html: '<div><p class="text-center"><b>Mohon Menunggu...</b></p><br><img src='+loading+'></div>',
                        allowOutsideClick: false,
                        showConfirmButton: false
                    })
                },
                dataType: 'json',
                success: function (res) {
                    swal.close()
                    if (res == '') {
                        swal.fire('Oops..', 'Data tidak Ditemukan, Harap diteliti kembali', 'warning')
                    } else {
                        $('#Cari_HasilPenyerahan').addClass('hide')
                        $('#Reset_HasilPenyerahan').removeClass('hide')

                        $('#tempelDataSP').html(`
                            <div class="col-lg-12">
                            <div class="box box-primary">
                            <div class="box-body">
                            <table class="SuratPenyerahan table table-striped table-bordered table-hover" width="100%">
                            <thead class="bg-primary">
                            <tr style="text-align: center !important">
                            <th style="width: 5%"><input type="checkbox" id="cekAll_SP"></th>
                            <th>Action</th>
                            <th>Pekerja</th>
                            <th>Seksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            ${
                                res.map(a => {
                                    return `<tr><td><input type="checkbox" class="childCekAll" value="${a.kode}"><td class="text-center"><a href="${baseurl+'AdmSeleksi/SuratPenyerahan/EditData?kode='+a.kode+'|'+a.noind+'|'+data['tanggal']+'|'+a.noind_baru}" type="button" class="btn btn-primary"><i class="fa fa-pencil-square"></i></a><td>${a.pekerja}<td>${a.seksi}</td></tr>`
                                }).join('')
                            }
                            </tbody>
                            </table>
                            </div>
                            </div>
                            </div>
                            `)

                            $('#cekAll_SP').on('change', function(e) {
                                const isCheck =  e.target.checked
                                let cekin = $('.childCekAll').prop('checked', isCheck ? true : false)
                                if (isCheck) {
                                    $('.hide_Perusahaan').attr('hidden', false)
                                }else {
                                    $('.hide_Perusahaan').attr('hidden', true)
                                }

                            })

                            $('.childCekAll').on('change',function (e) {
                                const isCheck =  e.target.checked
                                if (isCheck) {
                                    if ($('.childCekAll:checked').length == $('.childCekAll').length) {
                                        $('#cekAll_SP').prop('checked', true)
                                    }else {
                                        $('#cekAll_SP').prop('checked', false)
                                    }

                                    if ($('.childCekAll:checked').length == 0) {
                                        $('.hide_Perusahaan').attr('hidden', true)
                                    }else {
                                        $('.hide_Perusahaan').attr('hidden', false)
                                    }
                                }else {
                                    if ($('.childCekAll:checked').length == $('.childCekAll').length) {
                                        $('#cekAll_SP').prop('checked', true)
                                    }else {
                                        $('#cekAll_SP').prop('checked', false)
                                    }
                                    if ($('.childCekAll:checked').length == 0) {
                                        $('.hide_Perusahaan').attr('hidden', true)
                                    }else {
                                        $('.hide_Perusahaan').attr('hidden', false)
                                    }
                                }
                            })
                        }
                    },
                    error: () => {
                        swal.close()
                        swal.fire('Oops..', 'Data tidak Ditemukan,, Harap diteliti kembali', 'warning')
                    }
                })
        }

    })

    $('#btn_Cetak_SP').on('click', function () {
        let kepada = $('#slc_Kepada_SP').val()
        let pekerja = [];
            $.each($("input[class='childCekAll']:checked"), function(){
                pekerja.push($(this).val());
            })
        let ptgs1 = $('#slc_petugas1_SP').val()
        let ptgs2 = $('#slc_petugas2_SP').val()
        let app = $('#slc_approval_SP').val()
        let tgl_cetak = $('#txt_tglCetak_SP').val()
        let tgl_serah = $('#txt_tgl_SP').val()
        let kodesie = $('#slc_kodesie_SP').val()
        let jenis = $('#slc_pkj_SP').val()

        swal.fire({
            title: 'Warning',
            text: 'Apakah anda yakin ingin mencetak ?',
            type: 'warning',
            showCancelButton: true
        }).then(result => {
            if (result.value) {
                window.open(baseurl+`AdmSeleksi/SuratPenyerahan/previewPDF?approve=${app}&&kepada=${kepada}&&petugas=${ptgs1}&&petugas2=${ptgs2}&&pekerja=${pekerja}&&tgl_cetak=${tgl_cetak}&&tgl_serah=${tgl_serah}&&kodesie=${kodesie}&&jenis=${jenis}`)
            }
        })
    })

    $('#Reset_HasilPenyerahan').on('click', function () {
        // $(this).addClass('hide')
        let a = new Date()
        let newNow = a.getFullYear() +'-'+ (a.getMonth()+1) +'-'+ a.getDate()

        $('input').attr('value','').trigger('change')
        $('#txt_tgl_SP').datepicker("setDate",$.datepicker.parseDate( "yy-mm-dd", newNow ))
        $('#slc_pkj_SP').val("kosong").select2().trigger('change')
        $('#slc_RuangLingkup_SP').val("").select2().trigger('change')
        $('#tempelDataSP').html('')
        $('#Cari_HasilPenyerahan').removeClass('hide')
        $('.hide_Perusahaan').attr('hidden', true)
    })

})
