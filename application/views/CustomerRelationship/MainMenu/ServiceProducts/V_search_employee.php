<script src="<?php echo base_url('assets/js/SearchFunction.js')?>" type="text/javascript"></script>
<head>
<title>Employee Search</title>
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
	<th align="center" style="border-right:1px solid #333;border-collapse:collapse;padding:3px;">Emp. Number</th>
	<th align="center" style="padding:3px;">Emp. Name</th>
</thead>
<?php
$num = 0;
foreach ($Employee as $Employee_item): 
$num++;
?>
<tr class="option" onClick="sendEmployee('<?php echo $Employee_item['employee_id']; ?>', '<?php echo $Employee_item['employee_num']; ?>', '<?php echo $Employee_item['name']; ?>')" style="padding:3px;">
<td align="center" width="5%" style="border-right:1px solid #333;border-collapse:collapse;padding:3px;"><?php echo $num ?></td>
<td align="center" width="15%" style="border-right:1px solid #333;border-collapse:collapse;padding:3px;"><?php echo $Employee_item['employee_num'] ?></td>
<td align="left" width="80%" style="padding:3px;"><?php echo $Employee_item['name'] ?></td>
</tr>
<?php endforeach ?>
</table>
</body>
			
