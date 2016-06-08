<script src="<?php echo base_url('assets/js/SearchFunction.js')?>" type="text/javascript"></script>

<h2><?php echo $title ?></h2>
<table>
<?php $num = 0;
			foreach ($Employee as $Employee_item): 
			$num++;
			//$encrypted_string = $this->encrypt->encode($Employee_item['customer_id']);
			//$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
?>
		<tr>
			<td><?php echo $num ?>
			</td>
			<td><?php echo $Employee_item['employee_num'] ?>
			</td>
			<td><?php echo $Employee_item['name'] ?>
			</td>
			<td><input type="button" value="Select" onClick="sendEmployee('<?php echo $Employee_item['employee_id']; ?>', '<?php echo $Employee_item['employee_num']; ?>', '<?php echo $Employee_item['name']; ?>')" />
			</td>
		</tr>
<?php endforeach ?>
		
</table>