function getDataSPB() {
    event.preventDefault();
    $.ajax({
        url: baseurl+"Warehouse/Ajax/Spb",
        type: 'POST',
        data: $('#formSPB').serialize(),
        beforeSend: function() {
            $('#loadingArea').show();
            $('#tableSPBArea').empty();
        },
        success: function(result) {
        	console.log(result);
            $('#tableSPBArea').html(result);
            $('#loadingArea').hide();
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $.toaster(textStatus+' | '+errorThrown, name, 'danger');
        }
    });
}