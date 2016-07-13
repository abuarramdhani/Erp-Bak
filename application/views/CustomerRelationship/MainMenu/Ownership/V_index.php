<h2><?php echo $title ?></h2>
<table>
		<tr>
			<td><a href="<?php echo site_url('CustomerRelationship/Ownership/New/') ?>">New</a>
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>Item Name
			</td>
			<td>Body Number
			</td>
			<td>Engine Number
			</td>
			<td>Customer Name
			</td>
			<td>
			</td>
		</tr>
<?php $num = 0;
			foreach ($Ownership as $Ownership_item): 
			$num++;
			$encrypted_string = $this->encrypt->encode($Ownership_item['customer_ownership_id']);
			$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

?>
		<tr>
			<td><?php echo $num?>
			</td>
			<td><?php echo $Ownership_item['item_name'] ?>
			</td>
			<td><?php echo $Ownership_item['no_body'] ?>
			</td>
			<td><?php echo $Ownership_item['no_engine'] ?>
			</td>
			<td><?php echo $Ownership_item['customer_name'] ?>
			</td>
			<td><a href="<?php echo site_url('CustomerRelationship/Ownership/Detail/')."/".$encrypted_string ?>" >Detail</a>
			</td>
			<td><a href="<?php echo site_url('CustomerRelationship/Ownership/Update/')."/".$encrypted_string ?>" >Update</a>
			</td>
		</tr>
<?php endforeach ?>
</table>