<table class="table table-hover table-bordered" id="tblSPB">
	<thead class="bg-primary">
		<td>#</td>
		<td>NO SPB</td>
		<td>ITEM CODE</td>
		<td>ITEM DESCRIPTION</td>
		<td>QTY DELIVERY</td>
		<td>QTY ATT</td>
		<td>QTY ATR</td>
		<td>QTY TOTAL</td>
	</thead>
	<tbody>
		<?php $no=1; foreach ($spb as $value) {
			if ($value['QUANTITY_NORMAL'] > $value['QTY_ATT']) {
				$bgclr = 'bg-danger';
			}else{
				$bgclr = '';
			}
			/// if(empty($value['QTY_TOTAL'])){
			// 	$bgclr = 'bg-danger';
			// 	$clr = "background-color:red;";
			// }
			?>
			<tr class=<?php echo $bgclr; ?> >
				<td><?php echo $no++; ?></td>
				<td><?php echo $value['NO_SPB']; ?></td>
				<td><?php echo $value['ITEM_CODE']; ?></td>
				<td><?php echo $value['ITEM_DESC']; ?></td>
				<td><?php echo $value['QUANTITY_NORMAL']; ?></td>
				<td><?php echo $value['QTY_ATT']; ?></td>
				<td><?php echo $value['QTY_ATR']; ?></td>
				<td><?php if(empty($value['QTY_TOTAL'])){
					echo 0;
				}else{
					echo $value['QTY_TOTAL'];
				} ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>