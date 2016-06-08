
function delData(x) {
	event.preventDefault();
	var item_code = x;
	//meminta request ajax
	var request = $.ajax ({
        url : "<?php echo base_url(); ?>" + "/delete_detail",
        data : "item_code="+item_code,
        type : "GET",
        dataType: "html"
    });
 
    //menampilkan pesan Sedang mencari saat aplikasi melakukan proses pencarian
    $('#res').html('');
	$('#loading').html('<center><img id="loading" style="margin-top: 2%;" src="<?php echo site_url('assets/img/icon/loading.gif');?>"/><br /><font color="#575555">Menghapus Data</font></center><br />');
           
	//Jika pencarian selesai
    request.done(function(output) {
		window.setTimeout(function(){
			$('#loading').html(''); //Prints the progress text into our Progress DIV
			$('#res').html(output);                //Prints the data into the table
		}, 1000);
               //Tampilkan hasil pencarian pada tag div dengan id hasil-cari
               
    });
};

function addData() {
	event.preventDefault();

var item_code = $("input#item_code").val();
var description = $("input#description").val();
var qty = $("input#qty").val();
var needby = $("input#dp2").val();

	//meminta request ajax
	var request = $.ajax ({
        url : "<?php echo base_url(); ?>" + "/add_detail",
        data : "item_code="+item_code+"&description="+description+"&qty="+qty+"&needby="+needby,
        type : "GET",
        dataType: "html"
    });
 
    //menampilkan pesan Sedang mencari saat aplikasi melakukan proses pencarian
    $('#res').html('');
	$('#loading').html('<center><img id="loading" style="margin-top: 2%;" src="<?php echo site_url('assets/img/icon/loading.gif');?>"/><br /><font color="#575555">Menambahkan Data</font></center><br />');
           
	//Jika pencarian selesai
    request.done(function(output) {
		window.setTimeout(function(){
			$('#loading').html(''); //Prints the progress text into our Progress DIV
			$('#res').html(output);                //Prints the data into the table
			
		}, 1000);
               //Tampilkan hasil pencarian pada tag div dengan id hasil-cari
               
    });
};


function selectValue(){
	event.preventDefault();
	var aaa = document.getElementById('item_code').value;
	var aa = aaa.toUpperCase();
	//var table = document.getElementById('tbl1');
	//var bb = table.rows.length;;
	window.open('search/'+aa,'popuppage','width=700,toolbar=1,resizable=1,scrollbars=yes,height=400,top=100,left=100');
}

function updateValue(value, value2){
	document.getElementById('item_code').value = value;
	document.getElementById('description').value = value2;
	document.getElementById('qty').focus();
	}