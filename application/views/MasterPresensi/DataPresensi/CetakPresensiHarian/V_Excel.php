<!DOCTYPE html>
<html>
<head>
	<title>Excel</title>
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/jspreadsheet-xls/jsuites.css') ?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/jspreadsheet-xls/jexcel.css') ?>" type="text/css" />

	<script src="<?php echo base_url('assets/plugins/jspreadsheet-xls/jsuites.js') ?>"></script>
	<script src="<?php echo base_url('assets/plugins/jspreadsheet-xls/jexcel.js') ?>"></script>
	<script src="<?php echo base_url('assets/plugins/jspreadsheet-xls/jszip.js') ?>"></script>
	<script src="<?php echo base_url('assets/plugins/jspreadsheet-xls/xlsx.js') ?>"></script>
</head>
<body>
<div id="spreadsheet4"></div>
 
<script>
	jexcel.fromSpreadsheet('<?php echo base_url('assets/generated/CetakPresensiHarian/'.$filename) ?>', function(result) {
	    if (! result.length) {
	        console.error('jspreadsheet: Something went wrong.');
	    } else {
	        if (result.length == 1) {
	            jspreadsheet(document.getElementById('spreadsheet4'), result[0]);
	        } else {
	            jexcel.createTabs(document.getElementById('spreadsheet4'), result);
	        }
	    }
	});
</script>
</body>
</html>