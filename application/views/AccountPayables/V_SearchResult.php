<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover text-left" style="font-size:12px;">
		<thead>
			<tr class="bg-primary">
				<th width="5%"><center>No</center></th>
				<th width="10%"><center>Invoice Number</center></th>
				<th width="10%"><center>Supplier</center></th>
				<th width="10%"><center>Invoice Date</center></th>
				<th width="10%"><center>Product</center></th>
				<th width="10%"><center>DPP</center></th>
				<th width="10%"><center>PPN</center></th>
				<th width="15%"><center>QR Code Invoice</center></th>
				<th width="15%"><center>Tax Invoice Number</center></th>
				<th width="10%"><center>Voucher Number</center></th>
				<th width="15%"><center>Action</center></th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$i=1;
				$invbefore = '';
				foreach ($data as $row){
					if($row->PPN != 0){
				
				//Code to Generate QR
				$uniqpartcode = $row->INVOICE_ID;
				
				//Tax Invoice Number
				$TaxInvNum = $row->TAX_NUMBER_DEPAN.$row->TAX_NUMBER_BELAKANG;
				$TaxInvNum = preg_replace('/\D/', '', $TaxInvNum);//if they need check
				if($row->TAX_NUMBER_BELAKANG == NULL){$TaxInvNum = '-';}


				// if ($TaxInvNum != '-') {
				// 	$fakCheck = $this->M_Invoice->checkFaktur($TaxInvNum);
				// }else{
				// 	$fakCheck = false;
				// }


			?>
			<?php
		
				if($invbefore == $row->INVOICE_ID){
			?>
				<tr>
					<td><?php echo $row->DESCRIPTION?></td>
				</tr>
			<?php
				}else{
			?>
			<tr class="data-row">
				<td rowspan="<?php echo $row->JML?>"><?php echo $i;?></td>
				<td rowspan="<?php echo $row->JML?>"><?php echo $row->INVOICE_NUM?></td>
				<td rowspan="<?php echo $row->JML?>"><?php echo $row->VENDOR_NAME?></td>
				<td rowspan="<?php echo $row->JML?>"><?php echo $row->INVOICE_DATE?></td>
				<td><?php echo $row->DESCRIPTION?></td>
				<td rowspan="<?php echo $row->JML?>"><?php echo number_format($row->DPP, 0 , ',' , '.' )?></td>
				<td rowspan="<?php echo $row->JML?>"><?php echo number_format($row->PPN, 0 , ',' , '.' )?></td>
				<td rowspan="<?php echo $row->JML?>" align="center">
					<a class="btn btn-success inspectqr" data-toggle="modal" data-target="#qrcode" ><i class="fa fa-qrcode"></i> Generate</a>
					<input type="hidden" class="uniqpartcode" value="<?php echo $uniqpartcode?>">
				</td>
				<td rowspan="<?php echo $row->JML?>"><?php
					echo  $TaxInvNum
					// if ($fakCheck) {
					// 	echo  $TaxInvNum."<span style='color: green; font-weight: bold; font-size:13px'>&check;</span>";
					// }else{
					// 	echo  $TaxInvNum."<span style='color: red; font-weight: bold; font-size:13px'>&cross;</span>";
					// } 
				?></td>
				<td rowspan="<?php echo $row->JML?>"><?php echo $row->VOUCHER_NUMBER;?></td>
				<td rowspan="<?php echo $row->JML?>">
					<button type="button" class="btn btn-info btn-sm InputFakQr" inv_id="<?php echo $row->INVOICE_ID ?>"><i class="glyphicon glyphicon-qrcode"></i></button>
					<button type="button" class="btn btn-warning btn-sm InputFakMn" inv_id="<?php echo $row->INVOICE_ID ?>"><i class="glyphicon glyphicon-edit"></i></button>
					<?php $fkp = str_replace(str_split('.-'), '', $TaxInvNum); ?>
					<button type="button" class="btn btn-danger btn-sm DeleteFak" invnum="<?php echo $row->INVOICE_NUM ?>" trgt="<?php echo $row->INVOICE_ID.'/'.$fkp ?>"><i class="glyphicon glyphicon-trash"></i></button>					
				</td>
			</tr>
			<?php 
			$i++;
			}
			$invbefore = $row->INVOICE_ID;
			} } ?>
			<div class="modal fade modal-default" id="qrcode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<div class="col-sm-2"></div>
							<div class="col-sm-8" align="center"><b>QR Code</b></div>
							<div class="col-sm-2"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
							<br>
						</div>
						<div class="modal-body" align="center">
							<div class="qrarea">
							</div>
						</div>
					</div>
				</div>
			</div>
		</tbody>
	</table>
</div>