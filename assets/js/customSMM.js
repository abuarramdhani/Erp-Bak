$(document).ready( function () {
    $('#tableDataMinMax').DataTable(  {
    	columnDefs: [
    		{ targets: '_all', orderable: false}
    	]
    });

} );

$(window).load(function() {
    $(".loader").fadeOut("slow");
});

$('#org').change(function(){
	org = $(this).val();
	console.log(org);
	if (org == 'OPM') {
			$.ajax({
			url: baseurl+'SettingMinMaxOPM/C_settingMinMaxOPM/getRouteOPM',
			success: function(results){
				$('#routing_class').html(results);
			}
		});
		} else if (org == 'ODM') {
			$.ajax({
			url: baseurl+'SettingMinMaxOPM/C_settingMinMaxOPM/getRouteODM',
			success: function(results){
				$('#routing_class').html(results);
			}
		});
		}
	
});