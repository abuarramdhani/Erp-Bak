 $(document).ready( function (){

    $('.hasiltablemumet').DataTable({
    	fixedHeader: true,
		scrollY:  400,
		paging: true,
		info:false
    });
    
    	

   
 });

$('#selectWare').change(function(){
	jQuery('DIV.ResultMonitoring').html('');
	var wh = $('select[name="slcWarehouse"]').val();
	$('DIV.filterForm').css("display","inline");
	$('#tanggal_spbs_1').val('');
	$('#tanggal_spbs_2').val('');
	$('#tanggal_kirim_1').val('');
	$('#tanggal_kirim_2').val('');
	$('#spbs_number').val('');
	$('#nama_sub_spbs').val('').trigger('change');
	$('#job_spbs').val('');
	$('#komponen').val('');

			
});

function tampilMPBG(th)
{
	var warehouse;
	var wh = $('select[name="slcWarehouse"]').val();
	var spbsAwal = $('#tanggal_spbs_1').val();
	var spbsAkhir = $('#tanggal_spbs_2').val();
	var kirimAwal = $('#tanggal_kirim_1').val();
	var kirimAkhir = $('#tanggal_kirim_2').val();
	var nomorSpbs = $('#spbs_number').val();
	var namaSub = $('#nama_sub_spbs').val();
	var noJob = $('#job_spbs').val();
	var komponen = $('#komponen').val();

	console.log(spbsAwal);
	console.log(spbsAkhir);
	console.log(kirimAwal);
	console.log(kirimAkhir);
	console.log(noJob);
	console.log(komponen.toUpperCase());

	if(wh == '') {
		warehouse = 'SEMUA';
	} else {
		warehouse = wh;
	};

	var request = $.ajax({
		url: baseurl+'MonitoringBarangGudang/Pengeluaran/Search/',
		data: {
			noJob : noJob,
			warehouse : warehouse, 
			spbsAwal : spbsAwal, 
			spbsAkhir : spbsAkhir,
			kirimAwal : kirimAwal,
			kirimAkhir : kirimAkhir,
			nomorSpbs : nomorSpbs,
			namaSub : namaSub,
			komponen : komponen.toUpperCase(),
		},
		type: "POST",
		datatype: 'html', 
	});
		$('#ResultMonitoring').html('');
		$('#ResultMonitoring').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );

	request.done(function(result){
			$('#ResultMonitoring').html(result);

			$('.jamMulaiMPBG').timepicker({
				showSeconds: true,
				showMeridian: false,
				//defaultTime: false
			});
			$('.jamAkhirMPBG').timepicker({
				showSeconds: true,
				showMeridian: false
			});

			var alls = 0;
			var lgth = $(".lama").length;
			$(".lama").each(function (index, element) {
				var hms = $(this).html(); 
				var a = hms.split(':');
				var seconds = (+a[0]) * 60 + (+a[1]); 
				alls = Number(alls)+Number(seconds);	
			});
			var avg = $('.rerata').html();
			console.log(alls+'||'+lgth+'||'+avg)
			var m = Math.floor(Number(avg)/60);
			var s = Math.floor(Number(avg)%60);
			// var s = Number(avg)-Number(m);
			// Math.floor(detik / 60) + ':' + ('0' + Math.floor(detik % 60)).slice(-2);
			$('.rerata').html(m+':'+s)

			// $("#tblOutPart1").CongelarFilaColumna({
			// 	Columnas:  3,
			// 	width:      '100%',
			// 	height:     '100%'
			//   });

			// var options = new GridViewScrollOptions();
			// options.elementID = "tblOutPart1";
			// options.width = 450;
			// options.height = 300;
			// options.freezeColumn = true;
			// options.freezeColumnCssClass = "GridViewScrollItemFreeze";
			// options.freezeColumnCount = 3;	
			// new GridViewScroll(option);

			// jQuery(document).ready(function() {
			// 	jQuery(".main-table").clone(true).appendTo('#table-scroll').addClass('clone');   
			//   });
		
		})

}



function updateData(th){
	var spbs = $('#spbs').val();
	var inv_id = $('#inv_id').val();
	var noMobil = $('#sel1').val();
	var kirimDate = $('#kirimDate').val();
	var jamMulaiMPBG = $('#jamMulaiMPBG').val();
	var jamAkhirMPBG = $('#jamAkhirMPBG').val();
	var qtyKirim = $('#qtyKirim').val();
	var keterangan = $('#keterangan').val();

	console.log("clicked");
	
	var request = $.ajax({
		url: baseurl+'MonitoringBarangGudang/Pengeluaran/updateData/',
		data: {
			spbs : spbs,
			inv_id : inv_id, 
			noMobil : noMobil, 
			kirimDate : kirimDate,
			jamMulaiMPBG : jamMulaiMPBG,
			jamAkhirMPBG : jamAkhirMPBG,
			qtyKirim : qtyKirim,
			keterangan : keterangan 
		},
		type: "POST",
		datatype: 'html', 
	});
		
	request.done(function(result){
			console.log("Done");
		})
}




