$(document).ready( function () {
    $('.slcCabangORS').select2({
        placeholder : 'Pilih Cabang'
    })
    $('.slcOrderTypeORS').select2({
        placeholder : 'Pilih Order Type'
    })

    $('.tahunORS').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy',
            viewMode: 'years',
            minViewMode: 'years'
    });

    $(document).on('click','.btnSearchReportORS', function () {
        var tahun = $('.tahunORS').val();
        var cabang = $('.slcCabangORS').val();
        var ordertype = $('.slcOrderTypeORS').val();

        if (!tahun && !cabang && !ordertype) {
            Swal.fire({
                type: 'error',
                title: 'Gagal',
                text: 'Anda mengisi form!',
            });
        }else if (!tahun) {
            Swal.fire({
                type: 'error',
                title: 'Gagal',
                text: 'Anda mengisi tahun!',
            });
        }else if (!cabang) {
            Swal.fire({
                type: 'error',
                title: 'Gagal',
                text: 'Anda mengisi cabang!',
            });
        }else if (!ordertype) {
            Swal.fire({
                type: 'error',
                title: 'Gagal',
                text: 'Anda mengisi order type!',
            });
        }else{
            $('.loadingORS').css('display','block');
            $('.tableReportORS').css('display','none');
            $('.btnSearchReportORS').attr('disabled','disabled');
            $.ajax({
                type: "POST",
                url: baseurl+"OmzetRelasiSparepart/Laporan/getReport",
                data: {
                    tahun : tahun,
                    cabang : cabang,
                    ordertype : ordertype,
                },
                success: function (response) {
                    $('.btnSearchReportORS').removeAttr('disabled');
                    $('.tableReportORS').css('display','block');
                    $('.loadingORS').css('display','none');
                    $('.tableReportORS').html(response);
                    $('.tblReportORS').dataTable({
                        dom :  `<'row' <'col-sm-12 col-md-4'l> <'col-sm-12 col-md-4 text-center'B> <'col-sm-12 col-md-4'f> >
                        <'row' <'col-sm-12'tr> >
                        <'row' <'col-sm-12 col-md-5'i> <'col-sm-12 col-md-7'p> >`,
                        buttons: [
                            'copy', 'excel', 'print'
                        ],
                        scrollY: "370px",
                        scrollX: true,
                        scrollCollapse: true,
                        fixedColumns: {
                            leftColumns: 3
                        }
                    });
                }
            });
        }
    })
  })
  