$('.periodeBRS').datepicker({
    format: 'mm/yyyy',
    todayHighlight: true,
    viewMode: "months",
    minViewMode: "months",
    autoClose: true
}).on('change', function(){
    $('.datepicker').hide();
});

$(document).ready(function() {
    $('.getSubkon').select2({
        minimumInputLength: 4,
        placeholder: 'Nama Subkon',
        ajax: {
            url: baseurl + 'BarangRepairSubkon/Monitoring/getSubkon',
            dataType: 'JSON',
            type: 'POST',
            data: function(params) {
                return {
                    term: params.term
                };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return {
                            id: obj.VENDOR_NAME,
                            text: `${obj.VENDOR_NAME}`
                        }
                    })
                }
            }
        }
    });

    var request = $.ajax({
        url: baseurl+'BarangRepairSubkon/Monitoring/getMonBrgRepair',
        type: "POST",
        datatype: 'html'
    });
    $('#tbl_monbrgrepair').html('');
	$('#tbl_monbrgrepair').html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
	request.done(function(result){
        $('#tbl_monbrgrepair').html(result);
        $('.tblMonBrgRepair').dataTable();
    });

})

function getMonBrgRepair(th) {
    var periode = $('input[name="periode"]').val();
    var subkon = $('#subkon').val();

    var request = $.ajax({
        url: baseurl+'BarangRepairSubkon/Monitoring/search',
        data: {
            periode: periode,
            subkon: subkon
        },
        type: "POST",
        datatype: 'html'
    });
    $('#tbl_monbrgrepair').html('');
	$('#tbl_monbrgrepair').html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
	request.done(function(result){
        $('#tbl_monbrgrepair').html(result);
        $('.tblMonBrgRepair').dataTable();
    })
}