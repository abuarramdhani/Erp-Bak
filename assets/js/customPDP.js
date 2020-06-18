$(document).ready(function() {
    var a = $("input#checkall"),
        e = $("input.check");
    a.on("ifChecked ifUnchecked", function(a) {
        "ifChecked" == a.type ? e.iCheck("check") : e.iCheck("uncheck")
    }), $("#modalNoInduk, #modalEditNoInduk").select2({
        placeholder: "noind",
        minimumInputLength: 2,
        ajax: {
            type: "GET",
            url: baseurl + "PengirimanDokumen/ajax/noind",
            dataType: "json",
            data: a => ({
                params: a.term
            }),
            processResults: a => {
                1 == a.length ? ($("#modalNameWorker").val(a[0].nama), $("#modalSeksi").val(a[0].seksi)) : ($("#modalNameWorker").val(""), $("#modalSeksi").val(""));
                return {
                    results: $.map(a, a => ({
                        id: a.noind,
                        text: a.noind
                    }))
                }
            }
        }
    }), $("#modalNoInduk, #modalEditNoInduk").on("change", function() {
        let a = $(this).val();
        null != a && $.ajax({
            type: "GET",
            url: baseurl + "PengirimanDokumen/ajax/noind",
            dataType: "json",
            data: {
                params: a
            },
            success: a => {
                $("#modalNameWorker").val(a[0].nama);
                $("#modalSeksi").val(a[0].seksi)
                $("#modalEditNameWorker").val(a[0].nama);
                $("#modalEditSeksi").val(a[0].seksi)
            }
        })
    }), $("#modalLevelOne, #modalLevelTwo").select2({
        width: "100%"
    }), $("#modalInputInformation").select2({
        width: "100%",
        placeholder: "jenis keterangan"
    }), $(".table-input-dokumen thead td").each(function() {
        $(this).closest("table").find("tfoot tr").append("<th></th>")
    }), $(".table-input-dokumen tfoot th").each(function() {
        var a = $(this).text();
        $(this).html(`<input type="text" placeholder="search ${a}" style="width:100%;"></input>`)
    }), $(".table-input-dokumen").DataTable({
        dom: 'Bfrtip',
            buttons: [
            {
                extend: 'excel',
                title: '',
                filename: 'Pengiriman Dokumen'
            }
            ]
    }).columns().every(function() {
        let a = this;
        $("input", this.footer()).on("keyup change", function() {
            a.search(this.value, !0, !1).draw()
        })
    }), $("#modalDate, #modalEditDate").daterangepicker({
        drops: 'down',
        locale: {
            format: 'DD/MM/YYYY'
        }
    }), $("#modalDate").change(function() {
        let a = $(this).val().split(" - ");
        a[0] == a[1] && $(this).val(a[0])
    }), $(".RekapAll").dataTable({
        dom: "Bfrtip",
        buttons: [{
            extend: "excelHtml5",
            exportOptions: {
                orthogonal: "export"
            },
            title: "Rekap Dokumen"
        }, {
            extend: "pdfHtml5",
            exportOptions: {
                orthogonal: "export"
            },
            download: "open",
            pageSize: "A4",
            orientation: "portrait",
            title: "Rekap Dokumen"
        }]
    }), $(".dt-buttons button.buttons-excel").removeClass("btn-default").addClass("btn-success"), $(".dt-buttons button.buttons-excel span").html('<i class="fa fa-file-excel-o"></i> Excel'), $(".dt-buttons button.buttons-pdf").removeClass("btn-default").addClass("btn-danger"), $(".dt-buttons button.buttons-pdf span").html('<i class="fa fa-file-pdf-o"></i> PDF'), $("#periode").daterangepicker({
        locale: {
            format: "YYYY/MM/DD"
        }
    })

    $('.SendDocument').dataTable({
        scrollY: '350px'
    })

    $('.lembur-personalia-seksi').select2({
        ajax: {
            url: baseurl + "SPL/AccessSection/ajax/showallsection",
            dataType: 'json',
            method: 'GET',
            data: a => {
                return {
                    key: a.term,
                };
            },
            processResults: data => {
                return {
                    results: $.map(data, item => {
                        return {
                            id: item.kodesie + ' - ' + item.nama,
                            text: item.kodesie + ' - ' + item.nama,
                        }
                    })
                };
            },
        },
        minimumInputLength: 2,
        placeholder: 'Silahkan pilih',
        allowClear: true,
    })
})

const deleteMaster = a => {
        swal.fire({
            title: "Apakah anda yakin",
            text: "Menghapus Data ini ?",
            type: "warning",
            showCancelButton: !0
        }).then(e => {
            if (!e.value) return;
            $.ajax({
                method: "POST",
                data: {
                    id: a
                },
                url: baseurl + "PengirimanDokumen/ajax/deleteMaster",
                success: a => {
                    "ok" == a ? (swal.fire("Data telah dihapus", "", "success"), loadTable()) : swal.fire({
                        type: "error",
                        title: "Oops...",
                        text: "Data tidak boleh dihapus!",
                        footer: `<small>terdapat data input yang telah menggunakan master ini</small>`
                    })
                }
            })
        })
    },
    showSuccessAlert = () => {
        swal.fire("Sukses Menambahkan data", "", "success")
    },
    showSweetAlert = a => {
        swal.fire(a)
    },
    showSweetAlertQuestion = (a, b, c) => {
        return swal.fire({
            title: a,
            text: b,
            type: c,
            showCancelButton: !0,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "<i class='fa fa-check'> Ya</i>",
            cancelButtonText: "<i class='fa fa-close'> Tidak</i>"
        })
    },
    appDocument = (a, e) => {
        let t = e ? "Cek ke-valid an data !" : "Isikan alasan";
        let n = e ? "" : "textarea";
        let o = e ? "Setuju" : "Tolak";
        swal.fire({
            title: "Konfirmasi " + o,
            text: t,
            type: "warning",
            input: n,
            showCancelButton: !0,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "<i class='fa fa-check'> Ya</i>",
            cancelButtonText: "<i class='fa fa-close'> Tidak</i>"
        }).then(t => {
            if (t.value) {
                let t = null;
                if (0 == e && (t = $(".swal2-textarea").val(), console.log(t), "" == t)) return swal.fire({
                    title: "Isikan alasan !",
                    text: "alasan wajib diisi",
                    type: "danger"
                }), !1;
                $.ajax({
                    method: "post",
                    data: {
                        id: a,
                        app: e,
                        alasan: t
                    },
                    url: baseurl + "PengirimanDokumen/Personalia/ajax/changeapp",
                    success: a => {
                        location.reload()
                    },
                    error: function() {
                        alert("error")
                    }
                })
            }
        })
    }