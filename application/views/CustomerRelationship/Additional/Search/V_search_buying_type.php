<script src="<?php echo base_url('assets/js/SearchFunction.js')?>" type="text/javascript"></script>
<head>
<title>Buying Type Search</title>
<link href="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.css');?>" rel="stylesheet" />
<!-- GLOBAL SCRIPTS -->
    <script src="<?php echo base_url('assets/plugins/jquery-2.0.3.min.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js');?>"></script>
    <!-- END GLOBAL SCRIPTS -->
	
    <!-- PAGE LEVEL SCRIPTS FOR DATATABLES-->
    <script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     <script>
         $(document).ready(function () {
             $('#dataTables-example').dataTable({
			  "bSort" : false,
			  "paging" : false
			});
			
			$('#dataTables-customer').dataTable({
			  "bSort" : false,
			   "searching": false,
			   "bLengthChange": false
			});
         });
    </script>
<style>
.sortable tr.option {
    cursor: pointer;
	border: 1px solid #333;
	border-collapse : collapse;
}

.sortable tr.option:hover{
    cursor: pointer;
	background: #428bca;
	color : #fff;
	border: 1px solid #333;
	border-collapse : collapse;
}

.form-control input-sm{
	
}
</style>
</head>
<body>
<!--
<h2><?php echo $title ?> List</h2>
-->
<table class="sortable" style="border:1px solid #333;border-collapse:collapse;" width="100%" id="dataTables-example">
<thead style="background:#f5f5f5;" style="padding:3px;">
	<th align="center" style="border-right:1px solid #333;border-collapse:collapse;padding:3px;">No</th>
	<th align="center" style="border-right:1px solid #333;border-collapse:collapse;padding:3px;">Buying Type</th>
	<th align="center" style="padding:3px;">Description</th>
</thead>
<?php
$num = 0;
foreach ($BuyingType as $BuyingType_item): 
$num++;
?>
<tr class="option" onClick="sendBuyingType('<?php echo $BuyingType_item['buying_type_id']; ?>', '<?php echo $BuyingType_item['buying_type_name']; ?>', '<?php echo $BuyingType_item['buying_type_description'] ?>')" style="padding:3px;">
<td align="center" width="5%" style="border-right:1px solid #333;border-collapse:collapse;padding:3px;font-size:12px;"><?php echo $num ?></td>
<td align="left" width="25%" style="border-right:1px solid #333;border-collapse:collapse;padding:3px;font-size:12px;"><?php echo $BuyingType_item['buying_type_name'] ?></td>
<td align="left" width="70%" style="padding:3px;font-size:12px;"><?php echo $BuyingType_item['buying_type_description'] ?></td>
</tr>
<?php endforeach ?>
</table>
</body>
			

