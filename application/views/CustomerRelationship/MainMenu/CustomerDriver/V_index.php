<h2><?php echo $title ?></h2>
<table>
		<tr>
			<td><a href="<?php echo site_url('CustomerRelationship/CustomerDriver/New/') ?>">New</a>
			</td>
		</tr>
<?php $num = 0;
			foreach ($CustomerDriver as $CustomerDriver_item): 
			$num++;
			$encrypted_string = $this->encrypt->encode($CustomerDriver_item['customer_driver_id']);
			$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
?>
		<tr>
			<td><?php echo $num ?>
			</td>
			<td><?php echo $CustomerDriver_item['driver_name'] ?>
			</td>
			<td><?php echo $CustomerDriver_item['customer_name'] ?>
			</td>
			<td><a href="<?php echo site_url('CustomerRelationship/CustomerDriver/Update/')."/".$encrypted_string ?>">Update</a>
			</td>
		</tr>
<?php endforeach ?>
		
</table>