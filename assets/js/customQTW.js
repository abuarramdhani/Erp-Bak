/*  Database QTW
    Created RNR-2020 */
$(document).ready(function () {
    $("#inpHpLawan").mask("0000 0000 0000");
    $("#txtKodePosQtw").mask("00000");
    $(".txttglqtw").datepicker({
        format: "dd MM yyyy",
        autoclose: true,
        todayHighlight: true,
    });


    $(".kendaraan_Qtw").select2({
        placeholder: "Pilih Kendaraan",
    });

    $('#tbl_monitoring_qtw').DataTable({
        scrollX: true
    })

    $("#slcJnsQtw").select2({
        placeholder: "---Pilih Jenis Kunjungan---",
    }).on("change", function () {
        let a = $(this).val();
        $.ajax({
            type: "post",
            data: {
                a
            },
            dataType: "json",
            beforeSend: function () {
                swal.showLoading();
            },
            url: baseurl + "QuickWisata/DBQTW/searchDetailInstansi",
            success: function (result) {
                if (result.value) {
                    swal.close();
                    let detailnya = "",
                        optione = "";
                    if (a < 3) {
                        $.map(result, function (e) {
                            optione +=
                                '<option value="' +
                                e.nama_univ +
                                '">' +
                                e.nama_univ +
                                "</option>";
                        });
                        detailnya =
                            '<select name="slcDtlQtw" id="slcDtlQtw" class="form-control select select2 getDetailInst" required><option value=""></option>' +
                            optione +
                            "</select>";
                    } else {
                        detailnya =
                            '<input type="text" name="slcDtlQtw" class="form-control getDetailInst" placeholder="---Detail Institusi---" style="text-transform: uppercase;" required>';
                    }
                    $("#applyDetailInstansi").html(detailnya);
                    $("#slcDtlQtw").select2({
                        placeholder: "---Detail Institusi---",
                        allowClear: true,
                        tags: true,
                    });

                    if (a == "1") {
                        $("#label_tua_qtw").text("Guru :");
                        $("#label_muda_qtw").text("Siswa :");
                    } else if (a == "2") {
                        $("#label_tua_qtw").text("Dosen :");
                        $("#label_muda_qtw").text("Mahasiswa :");
                    } else {
                        $("#label_tua_qtw").text("Pendamping :");
                        $("#label_muda_qtw").text("Peserta :");
                        $('.Provinsi_QTW').prop('disabled', true)
                        $('.Kabupaten_QTW').prop('disabled', true)
                        $('.Kecamatan_QTW').prop('disabled', true)
                        $('.Desa_QTW').prop('disabled', true)
                    }
                }
            }
        })
    })

    $(".slcPicQtw").select2({
        minimumInputLength: 1,
        placeholder: "---Pilih PIC---",
        ajax: {
            url: baseurl + 'QuickWisata/DBQTW/findPemandu',
            dataType: 'json',
            type: 'GET',
            data: params => {
                return {
                    term: params.term,
                    tanggal_slc: $('.txttglqtw').val(),
                    mulai_slc: $('.txtTimeAwalqtw').val(),
                    selesai_slc: $('.txtTimeAkhirqtw').val(),
                    loker_slc: $('.slcTjnQtw').val()
                }
            },
            processResults: data => {
                return {
                    results: data.map((b) => {
                        return {
                            id: b.noind,
                            text: b.noind + ' - ' + b.nama
                        }
                    })
                }
            }
        }
    })


    $(".Provinsi_QTW").on("change", function () {
        $(".Kabupaten_QTW").select2("val", "");
        $(".Kecamatan_QTW").select2("val", "");
        $(".Desa_QTW").select2("val", "");
    });

    $(".Provinsi_QTW").select2({
        minimumInputLength: 2,
        allowClear: true,
        placeholder: "---Provinsi---",
        ajax: {
            url: baseurl + "MasterPekerja/DataPekerjaKeluar/provinsiPekerja",
            dataType: "json",
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
                    }),
                };
            },
        },
    });

    $(".Kabupaten_QTW").select2({
        minimumInputLength: 0,
        allowClear: true,
        placeholder: "---Kabupaten---",
        ajax: {
            url: baseurl + "MasterPekerja/DataPekerjaKeluar/kabupatenPekerja",
            dataType: "json",
            type: "GET",
            data: function (params) {
                return { term: params.term, prov: $(".Provinsi_QTW").val() };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (ok) {
                        return {
                            id: ok.id_kab,
                            text: ok.nama,
                        };
                    }),
                };
            },
        },
    });

    $(".Kecamatan_QTW").select2({
        minimumInputLength: 0,
        allowClear: true,
        placeholder: "---Kecamatan---",
        ajax: {
            url: baseurl + "MasterPekerja/DataPekerjaKeluar/kecamatanPekerja",
            dataType: "json",
            type: "GET",
            data: function (params) {
                return { term: params.term, kab: $(".Kabupaten_QTW").val() };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (ok) {
                        return {
                            id: ok.id_kec,
                            text: ok.nama,
                        };
                    }),
                };
            },
        },
    });

    $(".Desa_QTW").select2({
        minimumInputLength: 0,
        allowClear: true,
        placeholder: "---Kelurahan---",
        ajax: {
            url: baseurl + "MasterPekerja/DataPekerjaKeluar/desaPekerja",
            dataType: "json",
            type: "GET",
            data: function (params) {
                return { term: params.term, kec: $(".Kecamatan_QTW").val() };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (ok) {
                        return {
                            id: ok.id_kel,
                            text: ok.nama,
                        };
                    }),
                };
            },
        },
    });

    $("#plus_kendaraan_qtw").on("click", function () {
        $("#tblKendaraanQtw").each(function () {
            let cek = "",
                lastCek = $(".kendaraan_Qtw:last").val(),
                lastInp = $(".lastInput_Qtw:last").val(),
                checking = lastCek && lastInp ? (cek = true) : (cek = false);

            if (!checking) {
                swal.fire({
                    title: "Peringatan !",
                    text: "Harap lengkapi data kendaraan sebelum menambah kendaraan !",
                    type: "warning",
                    allowOutsideClick: false,
                    showCancelButton: false,
                });
            } else {
                let kendaraan = [
                    "",
                    "Sepeda Motor",
                    "travello",
                    "Mobil Dinas",
                    "Bus Kecil",
                    "Bus Besar",
                ];
                optione = "";
                $.map(kendaraan, function (a) {
                    optione += '<option value="' + a + '">' + a + "</option>";
                });
                baris =
                    '<tr><td><select name="kendaraan_qtw[]" id="" class="form-control select select2 kendaraan_Qtw" required>' +
                    optione +
                    '</select><td><input name="jml_kdrn_qtw[]" type="number" min="1" class="form-control lastInput_Qtw" required><td><button class="btn btn-danger delRow_Kendaraan_Qtw"><span class="fa fa-close"></span></button></td></tr>';

                if ($("tbody", this).length > 0) {
                    $("tbody", this).append(baris);
                } else {
                    $(this).append(baris);
                }

                $(".kendaraan_Qtw").select2({
                    placeholder: "Pilih Kendaraan",
                });

                if ($("#tblKendaraanQtw tr").length == "2") {
                    $(".delRow_Kendaraan_Qtw").prop("disabled", true);
                } else {
                    $(".delRow_Kendaraan_Qtw").prop("disabled", false);
                }

                $(".delRow_Kendaraan_Qtw").on("click", function () {
                    if ($("#tblKendaraanQtw tr").length == "2") {
                        $(".delRow_Kendaraan_Qtw").prop("disabled", true);
                    } else {
                        $(this).closest("tr").remove();
                    }
                });
            }
        });
    });

    $(".delRow_Kendaraan_Qtw").on("click", function () {
        if ($("#tblKendaraanQtw tr").length == "2") {
            $(".delRow_Kendaraan_Qtw").prop("disabled", true);
        } else {
            $(this).closest("tr").remove();
        }
    });

    //for kalendar QTW
    if (window.location.href == baseurl + "QuickWisata/DBQTW/KalendarQTW") {
        $("#calendar_QTW").fullCalendar({
            header: {
                left: "prev,next today",
                center: "title",
                right: "month,agendaWeek,agendaDay",
            },
            buttonText: {
                today: "Today",
                month: "Month",
                week: "Week",
                day: "Day",
            },
            //Random default events
            events: {
                url: baseurl + "QuickWisata/DBQTW/cekThisMonth",
                method: "GET",
                result: function (a) {
                    alert(a);
                },
                failure: function () {
                    alert("Gagal mengambil data");
                },
            },
            eventTimeFormat: {
                hour: "numeric",
                minute: "2-digit",
                meridiem: false,
            },
            editable: false,
            eventClick: function (calEvent) {
                $.ajax({
                    type: "POST",
                    data: {
                        id: calEvent.id,
                    },
                    dataType: "json",
                    url: baseurl + "QuickWisata/DBQTW/getDetailData",
                    beforeSend: function () {
                        let loading = baseurl + "assets/img/gif/loading4.gif";
                        $("#makeLoading").html(
                            '<center><img src="' +
                            loading +
                            '" /><p>Loading...</p></center>'
                        );
                    },
                    success: (a) => {
                        $('.trueValue').removeAttr('hidden')
                        $('#makeLoading').attr('hidden', true)
                        $('#makePhoto').attr('src', a[0]["photo"])
                        $('#labelingPemandu').text(a[0]["nama_pemandu"])
                        $('#isianOption').val(a[0]["pemandu"]).text(a[0]["nama_pemandu"])
                        $('#inp_tgl_detail').val(a[0]["tanggal"])
                        $('#inp_wkt_detail').val(a[0]["wkt_mulai"] + ' - ' + a[0]["wkt_selesai"])
                        $('#inp_tjn_detail').val(a[0]["tujuan"])
                        $('#inp_pic_detail').val(a[0]["pic"])
                        $('#inp_nohp_detail').val(a[0]["nohp_pic"])
                        $('#inp_alamat_detail').val(a[0]["alamat"])
                        $('#inp_desa_detail').val(a[0]["desa"])
                        $('#inp_kec_detail').val(a[0]["kec"])
                        $('#inp_kab_detail').val(a[0]["kab"])
                        $('#inp_prop_detail').val(a[0]["prop"])

                        let kendaran = '<table style="width: 50%;">'
                        let i = 1;
                        kendaran += a.kendaraan.map((itemq) => {
                            return `<td><b>${i++}. <td><b>${itemq['nama']}</b><td>: ${itemq['jumlah']}</td><tr>`
                        }).join('')
                        kendaran += '</table>'
                        $('#inp_kdrn_detail').html(kendaran)

                        let rincian_peserta = `<table style="width: 50%;">
			  <td><b>1. <td><b>${a[0]['jenis_institusi'] == '1' ? 'Guru' : (a[0]['jenis_institusi'] == '2' ? 'Dosen' : 'Pendamping')}</b><td>: ${a[0]['pendamping'] ? a[0]['pendamping'] : '0'}</td><tr>
			  <td><b>2. <td><b>${a[0]['jenis_institusi'] == '1' ? 'Siswa' : (a[0]['jenis_institusi'] == '2' ? 'Mahasiswa' : 'Peserta')}</b><td>: ${a[0]['peserta'] ? a[0]['peserta'] : '0'}</td><tr>
			  <td colspan="2" align="center"><b>Total</b><td>: ${a[0]["total_peserta"] ? a[0]['total_peserta'] : '0'}</td>`
                        rincian_peserta += '</table>'
                        $('#inp_peserta_detail').html(rincian_peserta)

                        $("#slcPemanduQtw").select2({
                            minimumInputLength: 1,
                            placeholder: "---Pilih Pemandu Pengganti---",
                            ajax: {
                                url: baseurl + 'QuickWisata/DBQTW/findPemandu',
                                dataType: 'json',
                                type: 'GET',
                                data: params => {
                                    return {
                                        term: params.term,
                                        tanggal_slc: calEvent.start,//hanya untuk ngisi aja
                                        mulai_slc: calEvent.start,
                                        selesai_slc: calEvent.end,
                                        loker_slc: '' // ini juga 
                                    }
                                },
                                processResults: data => {
                                    return {
                                        results: data.map((b) => {
                                            return {
                                                id: b.noind,
                                                text: b.noind + ' - ' + b.nama
                                            }
                                        })
                                    }
                                }
                            }
                        })

                        $('#body_detailQtw').modal('show')

                        $('#hapus_disable').on('click', () => {
                            $('#hapus_disable').addClass('hide')
                            $('#HideEdit').addClass('hide')
                            $('#unHideEdit').removeClass('hide')
                            $('#save_edit_pic').removeClass('hide')
                            $('#batal_edit_pic').removeClass('hide')
                        })

                        $('#batal_edit_pic').on('click', () => {
                            $('#unHideEdit').addClass('hide')
                            $('#HideEdit').removeClass('hide')
                            $('#save_edit_pic').addClass('hide')
                            $('#batal_edit_pic').addClass('hide')
                            $('#hapus_disable').removeClass('hide')
                            $('#slcPemanduQtw').val('')
                        })

                        $('#save_edit_pic').on('click', function () {
                            let noind = $('#slcPemanduQtw').val(),
                                id = calEvent.id

                            swal.fire({
                                title: 'Yakin ?',
                                text: 'Apakah Anda Yakin ingin mengganti Pemandu ?',
                                type: 'question',
                                allowOutsideClick: false,
                                showCancelButton: true
                            }).then(result => {
                                if (result.value) {
                                    $.ajax({
                                        type: 'GET',
                                        data: {
                                            noind,
                                            id
                                        },
                                        dataType: 'json',
                                        url: baseurl + "QuickWisata/DBQTW/gantiPemandu",
                                        beforeSend: () => {
                                            swal.fire({
                                                html: "<img src='" + baseurl + "assets/img/gif/loading14.gif'>",
                                                backdrop: '',
                                                allowOutsideClick: false,
                                                showConfirmButton: false
                                            })
                                        },
                                        success: (a) => {
                                            if (a == 'OK') {
                                                swal.fire({
                                                    title: 'Success',
                                                    text: 'OK',
                                                    type: 'success',
                                                    showConfirmButton: false,
                                                    showCancelButton: false,
                                                    allowOutsideClick: false,
                                                    timer: 1500
                                                }).then(window.location.reload())
                                            } else if (a == 'NOT') {
                                                swal.fire({
                                                    title: 'Error',
                                                    text: 'Belum memilih Pemandu pengganti',
                                                    type: 'error',
                                                    showConfirmButton: false,
                                                    showCancelButton: false,
                                                    allowOutsideClick: false,
                                                    timer: 1500
                                                })
                                            }
                                        },
                                        error: () => {
                                            swal.fire({
                                                title: 'Error',
                                                text: 'Gagal mengganti Pemandu',
                                                type: 'error',
                                                showConfirmButton: false,
                                                showCancelButton: false,
                                                allowOutsideClick: false,
                                                timer: 1500
                                            })
                                        }
                                    })
                                }
                            })
                        })
                        //end of success
                    },
                });
            },
        })
    }
    $('#body_detailQtw').on('hide.bs.modal', () => {
        $('#unHideEdit').addClass('hide')
        $('#HideEdit').removeClass('hide')
        $('#save_edit_pic').addClass('hide')
        $('#batal_edit_pic').addClass('hide')
        $('#hapus_disable').removeClass('hide')
        $('#slcPemanduQtw').val('')
    })
    //end off calendar QTW

    //for Report QTW
    setTimeout(() => {
        $('.radioReport_qtw').on('ifChecked', function (event) {
            if ($(this).val() == '1') {
                $('.hiddenTahun_rangeQtw').removeClass('hide')
                $('.hiddenRange_qtw').addClass('hide')
            }
            if ($(this).val() == '2') {
                $('.hiddenTahun_rangeQtw').addClass('hide')
                $('.hiddenRange_qtw').removeClass('hide')
            }

        })
    }, 1500)
    $('.forDatePickerThn_qtw').datepicker({
        changeMonth: true,
        changeYear: true,
        autoclose: true,
        autoApply: true,
        viewMode: "years",
        format: 'yyyy',
        minViewMode: "years"
    })
    $('.forDatePicker_qtw').datepicker({
        changeMonth: true,
        changeYear: true,
        autoclose: true,
        autoApply: true,
        viewMode: "months",
        format: 'MM yyyy',
        minViewMode: "months"
    })
    // last

    // Grafik QTW
    if (window.location.href == baseurl + 'QuickWisata/DBQTW/TrafficQTW') {

        const chartQTW = new Chart($('#areaChart'), {
            type: 'bar',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'Jumlah Kunjungan',
                        data: [],
                        fill: false,
                        backgroundColor: 'rgb(54, 162, 235)',
                        borderColor: 'rgb(54, 162, 235)',
                    }
                ]
            },
            options: {
                exportEnabled: true,
                animationEnabled: true,
                legend: {
                    position: 'bottom'
                },
                tooltips: {
                    enabled: true,
                    mode: 'nearest',
                    callbacks: {
                        label: function (tooltipItems) {
                            var multistringText = [tooltipItems.yLabel] + ' Kunjungan';
                            return multistringText;
                        }
                    }
                },
                onClick: function (c) {
                    var element = this.getElementAtEvent(c);
                    var index = element[0]['_index'];
                    var dtClick = element[0]['_chart'].config.data;
                    var periode = dtClick.labels[index];

                    $.ajax({
                        type: 'GET',
                        data: {
                            periode,
                            tahun: yearNow
                        },
                        url: baseurl + 'QuickWisata/DBQTW/getDetailGrafik',
                        dataType: 'json',
                        beforeSend: () => {
                            swal.fire({
                                html: "<img src='" + baseurl + "assets/img/gif/loading14.gif'>",
                                backdrop: '',
                                allowOutsideClick: false,
                                showConfirmButton: false
                            })
                        },
                        success: res => {
                            setTimeout(() => {
                                swal.close()
                                $('#detailGrafikQTW').modal('show');

                                var i;
                                var no = 0;
                                var html = "";
                                for (i = 0; i < res.length; i++) {
                                    no++;
                                    html = html + '<tr>'
                                        + '<td>' + no + '</td>'
                                        + '<td>' + res[i].tanggalan + '</td>'
                                        + '<td>' + res[i].wkt_mulai + ' - ' + res[i].wkt_selesai + '</td>'
                                        + '<td>' + res[i].dtl_institusi + '</td>'
                                        + '<td>' + res[i].tujuan + '</td>'
                                        + '<td>' + res[i].nama_pemandu + '</td>'
                                        + '<td>(' + res[i].nohp_pic + ') - ' + res[i].pic + '</td>'
                                        + '<td>' + res[i].pendamping + '</td>'
                                        + '<td>' + res[i].peserta + '</td>'
                                        + '</tr>';
                                }
                                $("#bodyTab_QTW").html(html);
                                $("#detailQtw").DataTable();
                            }, 1500)

                        },
                        error: () => {
                            alert('error')
                        }
                    })
                }
            }
        })

        const updateChart = (data) => {
            chartQTW.data.datasets[0].data = data.template.map(e => e.jumlah)
            chartQTW.data.labels = data.bulan
            chartQTW.update()
        }

        $('#paramGrafik').datepicker({
            format: 'yyyy',
            autoclose: true,
            autoApply: true,
            viewMode: "years",
            minViewMode: "years"
        })
        let baru = new Date(),
            yearNow = baru.getFullYear()

        fetch(baseurl + 'QuickWisata/DBQTW/dataGrafik?tahun=' + yearNow)
            .then(response => response.json())
            .then(data => {
                updateChart(data)
            })
            .catch(e => {
                $('#areaChart').html('<center><p style="color: red"><b>Gagal Menampilkan Data...</b></p></center>')
            })

        $('#findGrafikQtw').on('click', function () {
            $.ajax({
                type: 'GET',
                data: {
                    tahun: $('#paramGrafik').val()
                },
                dataType: 'json',
                url: baseurl + 'QuickWisata/DBQTW/dataGrafik',
                beforeSend: () => {
                    $('#areaChart').html("<center><img src='" + baseurl + "assets/img/gif/loading14.gif'><p>Memuat Data...</p></center>")
                },
                success: data => {
                    $('.gantiTahun').html('&emsp;<b>GRAFIK DATABASE QTW TAHUN ' + data.tahun + '</b>')
                    updateChart(data)
                }
            })
        })// last on click
    }//last load page

}); // last document ready

function show_report_qtw(a) {
    const data = {
        jenis: $('input:radio[class=radioReport_qtw]:checked').val(),
        start: $('#getValueStart_rangeQtw').val(),
        end: $('#getValueEnd_rangeQtw').val(),
        'tahun': $('.forDatePickerThn_qtw').val()
    }

    if (!data['jenis']) {
        swal.fire({
            title: 'Peringatan !',
            text: 'Harap Pilih jenis report terlebih dahulu',
            type: 'warning',
            allowOutsideClick: false,
        })
    } else if (data['jenis'] == '2' ? (!data['start'] && data['end']) || (data['start'] && !data['end']) : '') {
        swal.fire({
            title: 'Peringatan !',
            text: 'Harap melengkapi parameter range',
            type: 'warning',
            allowOutsideClick: false
        })
    } else {
        if (a == '1') {
            $.ajax({
                type: 'POST',
                data: {
                    data
                },
                url: baseurl + 'QuickWisata/DBQTW/findDataReview',
                dataType: 'json',
                beforeSend: () => {
                    $('#loading').html("<center><img src='" + baseurl + "assets/img/gif/loading14.gif'><p>Memuat Data...</p></center>")
                },
                success: (b) => {
                    $('#munculSetelahGenerate').removeClass('hide')
                    $('#loading').html(b)
                }
            })
        } else {
            window.open(baseurl + 'QuickWisata/DBQTW/findDataPDF?jenis=' + data['jenis'] + '&start=' + data['start'] + '&end=' + data['end'] + '&tahun=' + data['tahun'] + '&a=' + a)
        }
    }
}

// Grafik QTW
const showFullscreen = async () => {
    const element = document.getElementById('box-qtw');
    if (element.requestFullscreen) {
        element.requestFullscreen();
    } else if (element.mozRequestFullScreen) {
        element.mozRequestFullScreen();
    } else if (element.webkitRequestFullscreen) {
        element.webkitRequestFullscreen();
    } else if (element.msRequestFullscreen) {
        element.msRequestFullscreen();
    }
};

function deleteJadwalQTW(id) {
    swal.fire({
        title: 'Peringatan !',
        text: 'Apakah anda yakin ingin menghapus data ?',
        type: 'warning',
        allowOutsideClick: false,
        showCancelButton: true
    }).then(result => {
        if (result.value) {
            $.get(baseurl + 'QuickWisata/DBQTW/deleteData?id=' + id, function (params) {
                if (params == 'sukses') {
                    swal.fire({
                        title: 'Success !',
                        text: 'Berhasil menghapus data.',
                        type: 'success',
                        timer: 1500,
                        allowOutsideClick: false,
                        showConfirmButton: false
                    }).then(window.location.reload())
                } else {
                    swal.fire({
                        title: 'Error !',
                        text: 'Gagal menghapus data.',
                        type: 'error',
                        timer: 1500,
                        allowOutsideClick: false,
                        showConfirmButton: false
                    })
                }
            })
        }
    })
}

