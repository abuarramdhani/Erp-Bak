<script src="<?php echo base_url('assets/js/SearchFunction.js')?>" type="text/javascript"></script>

<h2><?php echo $title ?></h2>
<table>
<?php $num = 0;
			foreach ($Item as $Item_item): 
			$num++;
			//$encrypted_string = $this->encrypt->encode($Employee_item['customer_id']);
			//$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
?>
		<tr>
			<td><?php echo $num ?>
			</td>
			<td><?php echo $Item_item['segment1'] ?>
			</td>
			<td><?php echo $Item_item['item_name'] ?>
			</td>
			<td><input type="button" value="Select" onClick="sendItem('<?php echo $Item_item['item_id']; ?>', '<?php echo $Item_item['segment1']; ?>', '<?php echo $Item_item['item_name']; ?>')" />
			</td>
		</tr>
<?php endforeach ?>
		
</table>