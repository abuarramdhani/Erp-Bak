<div class="row" style="padding-top:30px;">
	<div class="col-md-3">
		<h4>SPB Number : <?php echo $nomerspb; ?></h4>
	</div>
	<div class="col-md-3">
		<select class="form-control select2-custom" name="kemasan" data-placeholder="Packing Type">
			<option></option>
			<option value="Kardus Kecil">Kardus Kecil</option>
			<option value="Kardus Sedang">Kardus Sedang</option>
			<option value="Kardus Panjang">Kardus Panjang</option>
			<option value="Poly Propelyne">Poly Propelyne</option>
			<option value="Peti">Peti</option>
		</select>
	</div>
	<div class="col-md-6">
		<input type="text" name="Item Code" class="form-control" placeholder="Packing item" onkeyup="updatePackingQty(event,this)">
	</div>
</div>
<div class="row" style="padding-top:10px;">
	<div class="col-md-12">
		<table class="table table-hover table-bordered table-striped" id="tblSPB">
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
					<tr class="<?php echo $bgclr; ?>" data-row="<?php echo $value['ITEM_CODE']; ?>">
						<input type="hidden" name="maxPack" value="<?php echo $value['QUANTITY'] ?>">
						<td><?php echo $no++; ?></td>
						<td><?php echo $value['ITEM_CODE']; ?></td>
						<td><?php echo $value['ITEM_DESC']; ?></td>
						<td><?php echo $value['QTY_ONHAND']; ?></td>
						<td><?php echo $value['QUANTITY']; ?></td>
						<td>
							<input type="number" name="packingqty" class="form-control" readonly="" placeholder="Total Item" max="<?php echo $value['QUANTITY'] ?>" min="0">
						</td>
						<td>
							<button type="button" class="btn btn-default" onclick="mdlPackingQtyCustom(this)">
								<i class="fa fa-edit"></i>
							</button>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<div class="modal fade" id="packingqtyMdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Alter Packing Quantity</h4>
      </div>
      <form class="form-horizontal" onsubmit="packingqtyCustom()">
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