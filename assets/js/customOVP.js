$(document).ready(function(){
	$('#ovpbtngetovp').click(function(){
		
		var s1 = $('#er-status').val();
		var s2 = $('#er_all').closest('div').hasClass("checked");
		console.log(s1);
		console.log(s2);
		console.log(s1 == null && s2);
		if (s1 == null && !s2) {
			alert('Pilih Status Hubungan Kerja');
			return false;
		}
		
		var data = $('#ovpfrmgetovp').serialize();
		fakeLoading(0);
		$.ajax({
			type: 'POST',
			data: data,
			url: baseurl + 'overtime-pekerja/rekap/cari_ovp',
			success: function (result) {
				$('#ovpdivrkp').html(result);
				$('.datatableovertime').DataTable();
				$('html, body').animate({
					scrollTop: $("#ovpdivrkp").offset().top
				}, 1000);
				fakeLoading(1);
			},
			error: function (result) {
				alert('Error Please Try Again !');
				fakeLoading(1);
			}
		});
	});
});

$(document).on('change', '#ovpslcdept', function(){
	var departemen =	$(this).val();
	if(departemen=='0')
	{
		$('.RekapAbsensi-cmbBidang').each(function () { 
			$(this).select2('destroy').val("").select2();
		});
		$('.RekapAbsensi-cmbUnit').each(function () {
			$(this).select2('destroy').val("").select2();
		});
		$('.RekapAbsensi-cmbSeksi').each(function () {
			$(this).select2('destroy').val("").select2();
		});

		$('.RekapAbsensi-cmbBidang').attr('disabled', 'true');
		$('.RekapAbsensi-cmbUnit').attr('disabled','true');
		$('.RekapAbsensi-cmbSeksi').attr('disabled','true');
	}
	else
	{
		$('.RekapAbsensi-cmbBidang').each(function () {
			$(this).select2('destroy').val("").select2();
		});
		$('.RekapAbsensi-cmbUnit').each(function () {
			$(this).select2('destroy').val("").select2();
		});
		$('.RekapAbsensi-cmbSeksi').each(function () {
			$(this).select2('destroy').val("").select2();
		});

		$('.RekapAbsensi-cmbBidang').removeAttr('disabled');
		$('.RekapAbsensi-cmbUnit').removeAttr('disabled');
		$('.RekapAbsensi-cmbSeksi').removeAttr('disabled');

		$('.RekapAbsensi-cmbBidang').select2(
		{
			minimumResultsForSearch: 0,
			ajax:
			{
				url: baseurl+'RekapTIMSPromosiPekerja/RekapAbsensiPekerja/daftarBidang',
				dataType: 'json',
				data: function(params){
					return {
						term: params.term,
						departemen: departemen
					}
				},
				processResults: function (data){
					return {
						results: $.map(data, function(obj){
							return {id: obj.kode_bidang, text: obj.nama_bidang};
						})
					}
				}
			}
		});
	}
});