$(document).ready(function(){

	$('#btn_search_invoice').click(function(){
		$('#loading_invoice').html("<center><img id='loading12' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading4.gif'/><br /></center><br />");

		var nama_vendor = $('#nama_vendor').val();
		var po_number = $('#po_number').val();
		var any_keyword = $('#any_keyword').val();
		var invoice_number = $('#invoice_number').val();
		var invoice_date = $('#invoice_date').val();
		$.ajax({
			type: "POST",
			url: baseurl+"Monitoring/TrackingInvoice/btn_search",
			data: {
				nama_vendor: nama_vendor,
				po_number: po_number,
				any_keyword: any_keyword,
				invoice_number: invoice_number,
				invoice_date: invoice_date,
			},
			success: function (response) {
				$('#loading_invoice').html(response);
				$('#tabel_search_tracking_invoice').DataTable();
			}
		});
	})
})