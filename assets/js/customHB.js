$('#bppbg').on("keypress",function(e){
    if (e.keyCode == 13) {
        return false;
    }
}); 

function cekBppbgHB(th) {
    var bppbg = $('#bppbg').val();
    // console.log(bppbg);

    var request = $.ajax({
        url: baseurl+'HistoryBppbg/View/getData',
        data: {
            bppbg  : bppbg
        },
        type: "POST",
        datatype: 'html'
    });
    $('#tb_view').html('');
	$('#tb_view').html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
	request.done(function(result){
        // console.log(result);
        $('#tb_view').html(result);
    })
}