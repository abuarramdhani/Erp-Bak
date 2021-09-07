$(function(){
    $('#slcTglRPL').daterangepicker({
        "todayHighlight" : true,
        "autoclose": true,
        locale: 
        {
            format: 'DD MMMM YYYY'
        },
    });

    $('#slcTglRPL').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD MMMM YYYY') + ' - ' + picker.endDate.format('DD MMMM YYYY'));
    });
  
    $('#slcTglRPL').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
});

function SearchRPL(){
    var tanggal = $('#slcTglRPL').val();
    var lokasi = $('#slcLokasiRPL option:selected').val();
    var io = $('#slcIORPL option:selected').val();
    // console.log(tanggal + ' ' + lokasi + ' ' + io);

    if (tanggal == '' || lokasi == '' || io == '') {
        Swal.fire(
            'Oops!',
            'Lengkapi Filter Terlebih Dahulu!',
            'error'
        )
    }else {
        ajax = $.ajax({
            url: baseurl + 'ReportPembuatanLPPB/Report/getDataLppb',
            data: {
                tanggal : tanggal,
                lokasi : lokasi,
                io : io
            },
            type: 'POST',
            beforeSend: function() {
                $('#loadingArea').show();
                $('div#tb_rpl').hide();
            },
            success: function(result) {
                $('#loadingArea').hide();
                $('div#tb_rpl').show();
                $('div#tb_rpl').html(result);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.error();
            }
        })
    }
}