$(document).ready(function () {
    $('#slcLocationQland').select2({
        placeholder: 'Pilih Lokasi'
    })

    $('#fromDateQland, #toDateQland').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd'
    });

    $(document).on('click', '#btnSearchQland', function () {
        var loc = $('#slcLocationQland').val();
        var from_date = $('#fromDateQland').val();
        var to_date = $('#toDateQland').val();

        $('#loadingQland').css('display', 'block');
        $('.tableReportQland').css('display', 'none');
        //$('#btnSearchQland').attr('disabled', 'disabled');
        $.ajax({
            type: "POST",
            url: baseurl + "LandingPageMonitor/getData",
            data: {
                loc: loc,
                from_date: from_date,
                to_date: to_date,
            },
            success: function (response) {
                $('#btnSearchQland').removeAttr('disabled');
                $('.tableReportQland').css('display', 'block');
                $('.loadingQland').css('display', 'none');
                $('.tableReportQland').html(response);
                $('.tblReportQlanding').dataTable();
            }
        });
    })    

})