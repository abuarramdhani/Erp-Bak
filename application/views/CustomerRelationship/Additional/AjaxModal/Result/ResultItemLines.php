<table class="table table-bordered table-hover" id="example1">
		<thead>
			<tr>
				<th width="5%">No</th>
				<th width="25%">Item Code</th>
				<th width="40%">Item Name</th>
				<th width="15%">Body Number</th>
				<th width="15%">Engine Number</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$num = 1;
			foreach($Item as $cs){
			?>
			<tr onclick="sendValueItem('<?php echo $cs['customer_ownership_id'];?>','<?php echo $cs['segment1'];?>','<?php echo $cs['item_name'];?>','<?php echo $row;?>','<?php echo base_url(); ?>')" data-dismiss="modal" style="cursor:hand;">
				<td align="center"><?php echo $num;?></td>
				<td><?php echo $cs['segment1'];?></td>
				<td><?php echo $cs['item_name'];?></td>
				<td><?php echo $cs['no_body'];?></td>
				<td><?php echo $cs['no_engine'];?></td>
			</tr>
			<?php
				$num++;
			}
			?>
		</tbody>
	</table>
	</table>