<script src="<?php echo base_url('assets/js/SearchFunction.js')?>" type="text/javascript"></script>

<h2><?php echo $title ?></h2>
<table>
<?php $num = 0;
			foreach ($Customer as $Customer_item): 
			$num++;
			//$encrypted_string = $this->encrypt->encode($Customer_item['customer_id']);
			//$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
?>
		<tr>
			<td><?php echo $num ?>
			</td>
			<td><?php echo $Customer_item['customer_name'] ?>
			</td>
			<td><input type="button" value="Select" onClick="sendCustomer('<?php echo $Customer_item['customer_id']; ?>', '<?php echo $Customer_item['customer_name']; ?>', '')" />
			</td>
		</tr>
<?php endforeach ?>
		
</table>