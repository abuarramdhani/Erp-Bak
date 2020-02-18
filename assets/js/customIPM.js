$(document).ready(function () {
    $('.tblMonitoringPingICT').dataTable();
    $('.slcIPIPM').select2({
        placeholder: "Pilih IP/Link"
    })

    $(document).on('change','.slcIPIPM',function () {
        var ipname = $(this).select2('data')[0]['title'];
        $('.ipnameIPM').val(ipname);
    })
})