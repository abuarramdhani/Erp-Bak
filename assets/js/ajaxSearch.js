function searchCustomer(base) {
var base_url = base;	
var name = $("#txtbyname").val().toUpperCase();
var village = $("#txtbyvillage").val().toUpperCase();
var city = $("#txtbycity").val().toUpperCase();
var category = $("#txtbycategory").val();


	//meminta request ajax
	var request = $.ajax ({
        url : base_url+"CustomerRelationship/Customer/AjaxSearching",
        data : "name="+name+"&village="+village+"&city="+city+"&category="+category,
        type : "GET",
        dataType: "html"
    });
 
    //menampilkan pesan Sedang mencari saat aplikasi melakukan proses pencarian
    $('#res').html('');
	$('#loading').html("<center><img id='loading' style='margin-top: 2%;' src='"+base_url+"assets/img/gif/loading5.gif'/><br /><p style='color:#575555;'>Searching Data</p></center><br />");
           
	//Jika pencarian selesai
    request.done(function(output) {
		window.setTimeout(function(){
			$('#loading').html(''); //Prints the progress text into our Progress DIV
			$('#res').html(output);                //Prints the data into the table
			
		}, 1000);
               //Tampilkan hasil pencarian pada tag div dengan id hasil-cari
               
    });
}

function searchCustomerReport(base) {
var base_url = base;	
var name = $("#txtbyname").val().toUpperCase();
var district = $("#txtbydistrict").val().toUpperCase();
var city = $("#txtbycity").val().toUpperCase();
var province = $("#txtbyprovince").val().toUpperCase();
var job = $("#txtbyjob").val();
var category = $("#txtbycategory").val();


	//meminta request ajax
	var request = $.ajax ({
        url : base_url+"CustomerRelationship/Report/AjaxCustomerReport",
        data : "name="+name+"&district="+district+"&city="+city+"&category="+category+"&job="+job+"&province="+province,
        type : "GET",
        dataType: "html"
    });
 
    //menampilkan pesan Sedang mencari saat aplikasi melakukan proses pencarian
    $('#res').html('');
	$('#loading').html("<center><img id='loading' style='margin-top: 2%;' src='"+base_url+"assets/img/gif/loading5.gif'/><br /><p style='color:#575555;'>Searching Data</p></center><br />");
           
	//Jika pencarian selesai
    request.done(function(output) {
		window.setTimeout(function(){
			$('#loading').html(''); //Prints the progress text into our Progress DIV
			$('#res').html(output);                //Prints the data into the table
			
		}, 1000);
               //Tampilkan hasil pencarian pada tag div dengan id hasil-cari
               
    });
}

function searchSoldUnitReport(base) {
var base_url = base;	
var item = $("#txtbyitem").val().toUpperCase();
var body_number = $("#txtbybodynumber").val().toUpperCase();
var engine_number = $("#txtbyenginenumber").val().toUpperCase();
var district = $("#txtbydistrict").val().toUpperCase();
var city = $("#txtbycity").val().toUpperCase();
var province = $("#txtbyprovince").val().toUpperCase();
var buying_type = $("#txtbybuyingtype").val().toUpperCase(); 
var owner_name = $("#txtbyownername").val().toUpperCase(); 
var rangesoldunit = $("#txtbyrangesoldunit").val(); 

	//meminta request ajax
	var request = $.ajax ({
        url : base_url+"CustomerRelationship/Report/AjaxSoldUnitReport",
        data : "item="+item+"&body_number="+body_number+"&engine_number="+engine_number+"&district="+district+"&city="+city+"&province="+province+"&buying_type="+buying_type+"&customer_name="+owner_name+"&rangesoldunit="+rangesoldunit,
        type : "GET",
        dataType: "html"
    });
 
    //menampilkan pesan Sedang mencari saat aplikasi melakukan proses pencarian
    $('#res').html('');
	$('#loading').html("<center><img id='loading' style='margin-top: 2%;' src='"+base_url+"assets/img/gif/loading5.gif'/><br /><p style='color:#575555;'>Searching Data</p></center><br />");
           
	//Jika pencarian selesai
    request.done(function(output) {
		window.setTimeout(function(){
			$('#loading').html(''); //Prints the progress text into our Progress DIV
			$('#res').html(output);                //Prints the data into the table
			
		}, 1000);
               //Tampilkan hasil pencarian pada tag div dengan id hasil-cari
               
    });
}

function searchTroubledPartReport(base) {
var base_url = base;	

var spare_part = $("#txtbysparepart").val().toUpperCase();
var item = $("#txtbyitem").val().toUpperCase();
var body_number = $("#txtbybodynumber").val().toUpperCase();
var category = $("#txtbycategory").val().toUpperCase();


	//meminta request ajax
	var request = $.ajax ({
        url : base_url+"CustomerRelationship/Report/AjaxTroubledPartReport",
        data : "item="+item+"&body_number="+body_number+"&spare_part="+spare_part+"&category="+category,
        type : "GET",
        dataType: "html"
    });
 
    //menampilkan pesan Sedang mencari saat aplikasi melakukan proses pencarian
    $('#res').html('');
	$('#loading').html("<center><img id='loading' style='margin-top: 2%;' src='"+base_url+"assets/img/gif/loading5.gif'/><br /><p style='color:#575555;'>Searching Data</p></center><br />");
           
	//Jika pencarian selesai
    request.done(function(output) {
		window.setTimeout(function(){
			$('#loading').html(''); //Prints the progress text into our Progress DIV
			$('#res').html(output);                //Prints the data into the table
			
		}, 1000);
               //Tampilkan hasil pencarian pada tag div dengan id hasil-cari
               
    });
}

function tesalert(){
	alert('tes');
}

function searchCustomerGroup(base) {
var base_url = base;	
var name = $("#txtbyname").val().toUpperCase();
var village = $("#txtbyvillage").val().toUpperCase();
var city = $("#txtbycity").val().toUpperCase();
var province = $("#txtbyprovince").val();

	//meminta request ajax
	var request = $.ajax ({
        url : base_url+"CustomerRelationship/CustomerGroup/AjaxSearching",
        data : "name="+name+"&village="+village+"&city="+city+"&province="+province,
        type : "GET",
        dataType: "html"
    });
 
    //menampilkan pesan Sedang mencari saat aplikasi melakukan proses pencarian
    $('#res').html('');
	$('#loading').html("<center><img id='loading' style='margin-top: 2%;' src='"+base_url+"assets/img/gif/loading5.gif'/><br /><p style='color:#575555;'>Searching Data</p></center><br />");
           
	//Jika pencarian selesai
    request.done(function(output) {
		window.setTimeout(function(){
			$('#loading').html(''); //Prints the progress text into our Progress DIV
			$('#res').html(output);                //Prints the data into the table
			
		}, 1000);
               //Tampilkan hasil pencarian pada tag div dengan id hasil-cari
               
    });
}

function searchServiceProducts(base) {
var base_url = base;	
var name = $("#txtbyname").val().toUpperCase();
var service_number = $("#txtbyservicenumber").val().toUpperCase();
var activity = $("#txtbyactivity").val();
var method = $("#txtbymethod").val();
var contact = $("#txtByContact").val();

	//meminta request ajax
	var request = $.ajax ({
        url : base_url+"CustomerRelationship/ServiceProducts/AjaxSearching",
        data : "name="+name+"&service_number="+service_number+"&activity="+activity+"&method="+method+"&contact="+contact,
        type : "GET",
        dataType: "html"
    });
 
    //menampilkan pesan Sedang mencari saat aplikasi melakukan proses pencarian
    $('#res').html('');
	$('#loading').html("<center><img id='loading' style='margin-top: 2%;' src='"+base_url+"assets/img/gif/loading5.gif'/><br /><p style='color:#575555;'>Searching Data</p></center><br />");
           
	//Jika pencarian selesai
    request.done(function(output) {
		window.setTimeout(function(){
			$('#loading').html(''); //Prints the progress text into our Progress DIV
			$('#res').html(output);                //Prints the data into the table
			
		}, 1000);
               //Tampilkan hasil pencarian pada tag div dengan id hasil-cari
               
    });
}