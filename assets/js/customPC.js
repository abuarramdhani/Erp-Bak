// ---- Custom JS Product Cost ----
$('table#tblBppbgAccount').dataTable({
	dom: 'rtip'
});
$('form#searchBppbgAccountArea').submit(function (event) {
	event.preventDefault();
	console.log('hallo pendekar');
	$.ajax({
		type: 'post',
		url: baseurl+'ProductCost/Ajax/getBppbgAccount',
		data: $('form#searchBppbgAccountArea').serialize(),
        beforeSend: function() {
            $('div#loadingArea').html('<div style="text-align: center; width: 100%; height: 100%; vertical-align: middle;">' + '<img src="' + baseurl + 'assets/img/gif/loading13.gif" style="display: block; margin: auto; width: auto;">' + '</div>');
            $('#tblBppbgAccount').DataTable().destroy();
            $('div#tblBppbgAccountArea').empty();
        },
        success: function(result) {
            $('div#loadingArea').empty();
            $('div#tblBppbgAccountArea').html(result);
            $('#tblBppbgAccount').DataTable({
                dom: 'rtip'
            });
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $('div#loadingArea').empty();
            $.toaster(textStatus+' | '+errorThrown, 'Error', 'danger');
            $('div#tbMemoArea').html();
        }
	});
});
$('.checking-database-account').change(function (event) {
    var value = $(this).val();
    var id = $(this).attr('name');
    console.log(value+' | '+id);
    $.ajax({
        type: 'post',
        url: baseurl+'ProductCost/Ajax/checkingAccount',
        data: {
            value:value,
            field:id
        },
        beforeSend: function() {
            $('span#'+id).html('<i class="fa fa-circle-o-notch fa-pulse"></i>');
            if ($('span#'+id).hasClass('bg-green')) {
                $('span#'+id).removeClass(' bg-green')
            }
        },
        success: function(result) {
            if (result==0) {
                $('span#'+id).html('<i class="fa fa-check"></i>');
                $('span#'+id).addClass(' bg-green');
                $('span#'+id).attr('data-original-title', 'Data not Exist!');
                $('input[name="'+id+'_checkout"]').val('1');
            }else{
                $('span#'+id).html('<i class="fa fa-close"></i>');
                $('span#'+id).addClass(' bg-red');
                $('span#'+id).attr('data-original-title', 'Data Already Exist!');
                $('input[name="'+id+'_checkout"]').val('0');
            }

            // ---- enable / disable button submit ----
                var c1 = $('input[name="using_category_code_checkout"]').val();
                var c2 = $('input[name="cost_center_checkout"]').val();
                var c3 = $('input[name="account_number_checkout"]').val();

                if (c1=='1' || c2=='1' || c3=='1') {
                    $('button#bAccountSubmitBtn').attr('disabled',false);
                }else{
                    $('button#bAccountSubmitBtn').attr('disabled',true);
                }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $('span#'+id).html('<i class="fa fa-close"></i>');
            $.toaster(textStatus+' | '+errorThrown, 'Error', 'danger');
        }
    });
});