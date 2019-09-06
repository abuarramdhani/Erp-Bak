<style type="text/css">
thead.cabang tr th {
	background-color: #00acd6;
}
</style>
									<table style="width: 100%" id="tb_quick" class="tb_dash_unit table table-striped table-bordered table-hover text-center">
									<thead class="cabang">
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center">Bill Reference</th>
											<th class="text-center">Bill Number</th>
											<th class="text-center">Request ID</th>
											<th class="text-center">Transaction Date</th>
											<th class="text-center">Payment Flag Status</th>
											<th class="text-center">Reference</th>
											<th class="text-center">Total Amount</th>
											<th class="text-center">Paid Amount</th>
										</tr>
									</thead>
									<tbody id="tbody_quick">
										<?php if (empty($hasilArray['TransactionData'])) { ?>
											<?php echo "Data not found"; ?>
											<tr>
										<?php }$no=1;foreach($hasilArray['TransactionData'] as $ha) { ?>
										<tr id="<?php echo $no; ?>">
											<td class="text-center">  <?php echo $no; ?></td>
											 <?php $no=1;foreach($ha['DetailBills'] as $db) { ?>
											<td class="text-center"> <?php echo $db['BillReference']?></td>
											<td class="text-center"> <?php echo $db['BillNumber']?></td>
											<?php $no++;} ?>
											<td class="text-center"> <?php echo $ha['RequestID']?> </td>
											<td class="text-center"> <?php echo $ha['TransactionDate']?> </td>
											<td class="text-center"> <?php echo $ha['PaymentFlagStatus']?> </td>
											<td class="text-center"> <?php echo $ha['Reference']?> </td>
											<td class="text-center TotalAmount">
											<?php if($ha['TotalAmount']==NULL) {
								          	 echo 'Rp.'.' ,-';
								          	}else{
								          	 echo 'Rp. '. number_format($ha['TotalAmount'],0,'.','.').',00-';
								          	};?></td>
											<td class="text-center PaidAmount"> 
											<?php if($ha['PaidAmount']==NULL) {
								          	 echo 'Rp.'.' ,-';
								          	}else{
								          	 echo 'Rp. '. number_format($ha['PaidAmount'],0,'.','.').',00-';
								          	};?></td>
										</tr>
										<?php $no++;} ?>
									</tbody>
									</table>
									</div>
								</div>
					</div>
				</div>
			</div>
		</div>
	</div>