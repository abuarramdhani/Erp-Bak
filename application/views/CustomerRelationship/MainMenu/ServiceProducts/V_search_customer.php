<script src="<?php echo base_url('assets/js/SearchFunction.js')?>" type="text/javascript"></script>
<head>
<title>Customer Search</title>
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
</style>
</head>
<body>
<!--
<h2><?php echo $title ?> List</h2>
-->
<table class="sortable" style="border:1px solid #333;border-collapse:collapse;" width="100%">
<thead style="background:#f5f5f5;" style="padding:3px;">
	<th align="center" style="border-right:1px solid #333;border-collapse:collapse;padding:3px;">No</th>
	<th align="center" style="padding:3px;">Customer Name</th>
</thead>
<?php
$num = 0;
foreach ($Customer as $Customer_item): 
$num++;
?>
<tr class="option" onClick="sendCustomer('<?php echo $Customer_item['customer_id']; ?>', '<?php echo $Customer_item['customer_name']; ?>', '')" style="padding:3px;">
<td align="center" width="18%" style="border-right:1px solid #333;border-collapse:collapse;padding:3px;"><?php echo $num ?></td>
<td align="left" width="82%" style="padding:3px;"><?php echo $Customer_item['customer_name'] ?></td>
</tr>
<?php endforeach ?>
</table>
</body>
			