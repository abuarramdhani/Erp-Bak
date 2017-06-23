<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>

<script type="text/javascript">
	$(".table_row input").keyup(function(){
		$("tr.table_row").each(function () {
			var $qty = $('.check_qty', this).val();
			var $ohm = $('.check_ohm', this).val();
			if (($qty/$ohm) <= 1) {
				$('.check_qty', this).css('background-color', 'white');;
				$('.check_qty', this).css('color', 'black');
			}
			else if (($qty/$ohm > 1)) {
				$('.check_qty', this).css('background-color', '	#F08080');
				$('.check_qty', this).css('color', 'white');
			}
		});
	});
</script>

	<table border="0" cellspacing="0" cellpadding="0" class="table table-striped table-hover" >
		<thead  >
			<tr style="width: 100%" >
				<td width="50%"><b> </b></td>
				<td align="center" width="20%"><b>QTY</b></td>
				<td align="center" width="20%"><b>OHN</b></td>		
			</tr>
		</thead>

		<tbody>
			<?php $sum = 0; foreach($DataExpDate as $Data_Expired) { ?>

				<tr class="table_row">
					<td><input class="form-control" type="text" name="txtExpiredDate[]" id="txtExpiredDate" readonly value="<?php echo $Data_Expired['expired_date']  ?>"></td>
					<td><input class="form-control check_qty" type="number" name="txtQuantity[]" id="txtQuantity" placeholder="Quantity"> </td>
					<td><input class="form-control check_ohm" type="number" name="txtOnHand[]" id="txtOnHand" readonly value="<?php echo $Data_Expired['on_hand']?>" ></td>
					<?php  $sum = $sum + $Data_Expired['on_hand']; ?>						
				</tr>
			<?php  } ?> 
				<tr>
					<td id="confirmQuantity" > </td>
					<td align="right">TOTAL STOCK:</td>
					<td> <input <input class="form-control" value="<?php echo $sum ?>" readonly> </td>
				</tr>
		</tbody>

	</table>

	