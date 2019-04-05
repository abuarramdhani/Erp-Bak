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