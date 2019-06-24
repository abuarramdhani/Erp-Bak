function tampiSGA(th)
{
	var slcData = $('input[name="slcData"]').val();

	var request = $.ajax({
		url: baseurl+'StockGudangAlat/insertData/',
		data:{slcData:slcData
			},
		type: "POST",
		datatype: 'html', 
    });

    request.done(function(result){
        $('#ResultMonitoring').html(result);
    })
}

var table = null;
var counter = 1;

$(function(){
    table = $('#tblDataStock').DataTable({
        "lengthMenu" : [10],
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "deferRender" : true,
        "scroller": true
    });
})

function addData() {
    var tag = $('#tag').val();
    var nama = $('#nama').val();
    var merk = $('#merk').val();
    var qty = $('#qty').val();
    var jenis = $('#jenis').val();
    if(tag && nama && merk && qty && jenis) {
        table.row.add([
            counter + '.',
            tag,
            nama,
            merk,
            qty,
            jenis
        ]).draw( false );
        counter++;
    } else {
        alert('Mohon isi semua kolom form');
    }

    // $('#tblDataStock').text();
    // console.log

}