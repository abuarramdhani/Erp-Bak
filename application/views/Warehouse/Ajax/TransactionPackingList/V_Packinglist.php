<div class="row" style="padding-top:30px;">
	<div class="col-md-3">
		<h4>SPB Number : <?php echo $nomerspb; ?></h4>
	</div>
	<div class="col-md-9">
		<input type="text" name="ItemCode" class="form-control" placeholder="Packing item" onkeyup="updatePackingQty(event,this)">
	</div>
</div>
<form onsubmit="setPacking()" id="formSetPacking">
	<input type="hidden" name="spbNumber" value="<?php echo $nomerspb; ?>">
	<input type="hidden" name="packingNumber" value="1">
	<div class="row" style="padding-top:10px;">
		<div class="col-md-12">
			<table class="table table-hover table-bordered" id="tblSPB">
				<thead class="bg-primary">
					<td>#</td>
					<td>ITEM CODE</td>
					<td>ITEM DESCRIPTION</td>
					<td>ONHAND</td>
					<td>QUANTITY</td>
					<td colspan="2" class="text-center">PACKING</td>
				</thead>
				<tbody>
					<?php $no=1; foreach ($spb as $value) {
						if ($value['QUANTITY'] > $value['QTY_ONHAND']) {
							$bgclr = 'bg-danger';
						}else{
							$bgclr = '';
						}
					?>
						<tr class="<?php echo $bgclr; ?>" data-row="<?php echo $value['ITEM_CODE']; ?>" data-id="<?php echo $value['INVENTORY_ITEM_ID']; ?>">
							<input type="hidden" name="item_id[]" value="<?php echo $value['INVENTORY_ITEM_ID'] ?>">
							<input type="hidden" name="maxPack[]" value="<?php echo $value['QUANTITY'] ?>">
							<input type="hidden" name="maxOnhand[]" value="<?php echo $value['QTY_ONHAND'] ?>">
							<td><?php echo $no++; ?></td>
							<td><?php echo $value['ITEM_CODE']; ?></td>
							<td><?php echo $value['ITEM_DESC']; ?></td>
							<td><?php echo $value['QTY_ONHAND']; ?></td>
							<td class="quantityArea"><?php echo $value['QUANTITY']; ?></td>
							<td>
								<input type="number" name="packingqty[]" class="form-control" readonly="" placeholder="Total Item" max="<?php echo $value['QUANTITY'] ?>" min="0">
							</td>
							<td width="25px">
								<button type="button" class="btn btn-default" onclick="mdlPackingQtyCustom(this,'<?php echo $value['ITEM_CODE']; ?>')">
									<i class="fa fa-edit"></i>
								</button>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<select class="form-control select2-custom" name="kemasan" data-placeholder="Packing Type">
				<option></option>
				<option value="KK">Kardus Kecil</option>
				<option value="KS">Kardus Sedang</option>
				<option value="KP">Kardus Panjang</option>
				<option value="PP">Poly Propelyne</option>
				<option value="PT">Peti</option>
				<option value="LL">Lain - Lain</option>
			</select>
		</div>
		<div class="col-md-4">
			<select class="form-control select2-custom" name="ekspedisi" data-placeholder="Ekspedisi">
				<option></option>
				<option value="KGP">PT. KERTA GAYA PUSAKA</option>
				<option value="SADANA">PT SADANA Combinatama Express</option>
				<option value="ADEX">ADIKA EXPRESS</option>
				<option value="KHS">KHS</option>
				<option value="CUSTOMER">CUSTOMER</option>
				<option value="LAIN">LAIN LAIN</option>
			</select>
		</div>
		<div class="col-md-4">
			<button type="button" class="btn btn-warning pull-right" disabled="" id="btnSubmitPacking" data-toggle="modal" data-target="#submitPacking">PACKING <i class="fa fa-arrow-right"></i></button>
			<a class="btn btn-success pull-right" id="cetakPackingList" target="_blank" disabled href="http://produksi.quick.com/PACKINGLIST/packinglist.php?spb=<?php echo $nomerspb; ?>">CETAK <i class="fa fa-file-pdf-o"></i></a>
			<a class="btn btn-danger pull-right" id="reset" href="<?php echo base_url('Warehouse/Transaction/PackingListReset/'.$nomerspb) ?>">RESET <i class="fa fa-trash"></i></a>
		</div>
	</div>
	<div class="modal fade" id="submitPacking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Packing Weight</h4>
	      </div>
	      <div class="modal-body">
	      	<input type="number" name="weight" class="form-control" placeholder="Weight" required="">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
	        <button type="submit" class="btn btn-primary">SUBMIT</button>
	      </div>
	    </div>
	  </div>
	</div>
</form>
<div class="modal fade" id="packingqtyMdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Alter Packing Quantity</h4>
      </div>
      <form class="form-horizontal" onsubmit="packingqtyCustom(this)">
	      <div class="modal-body">
	      	<table class="table">
	      		<tr>
	      			<td>Quantity</td>
	      			<td></td>
	      			<td>Items</td>
	      			<td></td>
	      			<td>SUM</td>
	      		</tr>
	      		<tr>
	      			<td class="text-center quantity">
	      				<input type="hidden" name="onhand">
	      				<input type="hidden" name="required">
	      				<input type="hidden" name="itemcode">
	      				<input type="number" name="qty" readonly="" class="form-control">
	      			</td>
	      			<td class="text-center">X</td>
	      			<td>
	      				<input type="number" name="totalItems" class="form-control" onkeyup="getSum(this)">
	      			</td>
	      			<td>=</td>
	      			<td class="text-center sum">
	      				<input type="number" name="sum" class="form-control">
	      			</td>
	      		</tr>
	      	</table>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
	        <button type="submit" class="btn btn-primary">SUBMIT</button>
	      </div>
      </form>
    </div>
  </div>
</div>