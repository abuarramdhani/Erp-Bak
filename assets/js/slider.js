/*//Slider

	$(document).ready(function(){
		setInterval(nextpage, 30000)
		function nextpage(){
		var oTable = $('#monitoring').dataTable();
		oTable.fnPageChange( 'next' );
		}
		
		var table = 
			$('#monitoring').DataTable({
				"dom": '<"pull-left"f><"pull-right"l>tip',
				"filter": false,
				"ordering": false,
				"lengthChange": false,
				"autoWidth": false,
				"pageLength": 3
			} );
	});
	
	$(document).ready(function(){
		setInterval(nextpage, 30000)
		function nextpage(){
		var oTable = $('#monitoring2').dataTable();
		oTable.fnPageChange( 'next' );
		}
		
		var table = 
			$('#monitoring2').DataTable({
				"dom": '<"pull-left"f><"pull-right"l>tip',
				"filter": false,
				"ordering": false,
				"lengthChange": false,
				"autoWidth": false,
				"pageLength": 7
			} );
	});
	
	
	$(function(){  // document.ready function...
   setTimeout(function(){
      $('#refresh').submit();
    },10000);
	});
*/