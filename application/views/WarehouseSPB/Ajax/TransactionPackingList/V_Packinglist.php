<div class="row" style="padding-top:30px;">
	<div class="col-md-12">
		<h4>SPB Number : <?php echo $nomerspb; ?></h4>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<select class="form-control select2-custom" name="kemasan" data-placeholder="Packing Type" onchange="enaDisItemScan()">
			<option></option>
			<option value="KK">Kardus Kecil</option>
			<option value="KS">Kardus Sedang</option>
			<option value="KP">Kardus Panjang</option>
			<option value="PP">Karung</option>
			<option value="PT">Peti</option>
		</select>
	</div>
	<div class="col-md-3">
		<?php if ($ekpedisi[0]['ATTRIBUTE15']) { ?>
			<input type="text" name="ekspedisi" id="ekspedisi" placeholder="Ekspedisi" class="form-control toupper" readonly="" value="<?php echo $ekpedisi[0]['ATTRIBUTE15'] ?>">
		<?php }else{ ?>
			<select class="form-control" name="ekspedisi" id="ekspedisi" data-placeholder="Ekspedisi" onchange="enaDisItemScan()">
				<option></option>
				<?php foreach ($listEkspedisi as $key => $value): ?>	
					<option value="<?php echo $value['EKS']; ?>"><?php echo $value['EKS']; ?></option>
				<?php endforeach ?>
			</select>
		<?php } ?>
	</div>
	<div class="col-md-2">
		<input type="text" id="idItemColy" name="coly" class="form-control" placeholder="Item Coly" >
	</div>
	<div class="col-md-4">
		<input type="text" style="text-transform:uppercase" id="inputPackingPlus" name="ItemCode" class="form-control" placeholder="Packing item" disabled onkeyup="updatePackingQty(event,this)">
	</div>
</div>
<form onsubmit="setPacking()" id="formSetPacking">
	<input type="hidden" id="spbNumber" name="spbNumber" value="<?php echo $nomerspb; ?>">
	<input type="hidden" name="packingNumber" value="<?php echo $last_pack; ?>">
	<div class="row" style="padding-top:10px;">
		<div class="col-md-12">
			<table class="table table-hover table-bordered" id="tblSPB">
				<thead class="bg-primary">
					<td>#</td>
					<td>ITEM CODE</td>
					<td>ITEM DESCRIPTION</td>
					<!-- <td>ONHAND</td> -->
					<!-- <td>QUANTITY</td> -->
					<td colspan="3" class="text-center">PACKING</td>
				</thead>
				<tbody>
					<?php 
					// echo "<pre>";
					// print_r($spb);
					// exit();

					$totalQtyMinta=0; $no=1; foreach ($spb as $value) {
						if ($value['QUANTITY_PACKING'] == NULL) {
							$a = 'class="bg-danger" title="Data belum transact!"';
						}elseif ($value['QUANTITY_PACKING'] == 0){
							$a = 'class="bg-success"';
						}else{
							$a = '';
						}

						if($value['QUANTITY_STANDARD'] != NULL) {
							$x = '';
						}elseif ($value['QUANTITY_TRANSACT'] > 10){
							$x = '';
						}else{
							$x = 'disabled=""';
						}
					?>
						
						<tr data-row="<?php echo $value['ITEM_CODE']; ?>" data-id="<?php echo $value['INVENTORY_ITEM_ID']; ?>" <?php echo $a; ?>>
						
							<input type="hidden" name="item_id[]" value="<?php echo $value['INVENTORY_ITEM_ID'] ?>">
							<input type="hidden" name="maxPack[]" value="<?php echo $value['QUANTITY_TRANSACT'] ?>">
							<input type="hidden" name="maxOnhand[]" value="<?php echo $value['QTY_ATT'] ?>">
							<td><?php echo $no++; ?></td>
							<td><?php echo $value['ITEM_CODE']; ?></td>
							<td><?php echo $value['ITEM_DESC']; ?></td>
							<!-- <td><?php //echo $value['QTY_ONHAND']; ?></td> -->
							<!-- <td class="quantityArea"><?php // echo $value['QUANTITY_NORMAL']; ?></td> -->
							<td>
								<input type="number" name="packingqty[]" class="form-control" readonly="" placeholder=<?php 
								if($value['LINE_STATUS'] == 6){
									echo "CANCELED";
								}else{
									echo "Total Item";
								}
								?> 
								max="<?php echo $value['QUANTITY_TRANSACT'] ?>" min="0">
							</td>
							<td width="25px">
								<button type="button" class="btn btn-default" <?php echo $x; ?> onclick="mdlPackingQtyCustom(this,'<?php echo $value['ITEM_CODE']; ?>')" >
									<i class="fa fa-edit"></i>
								</button>
							</td>
							<td width="25px">
					<button type="button" class="btn btn-danger"  onclick="resetThis(this)">
									<i class="fa fa-trash"></i>
								</button>
							</td>
						</tr>
						<?php $totalQtyMinta+=$value['QUANTITY_PACKING']; ?>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<input type="hidden" name="totalQtyMinta" value="<?php echo $totalQtyMinta; ?>">
	<input type="hidden" name="totalQtyKasih" value="0">
	<input type="hidden" name="inputPackingAct" id="inputPackingAct" value="0">
	<input type="hidden" name="kemasanValue">
	<input type="hidden" name="EkspedisiValue" value="<?php echo $ekpedisi[0]['ATTRIBUTE15'] ?>">
	<input type="hidden" name="itemColy" value="0">
	<div class="row">
		<div class="col-md-12">
			<button type="button" class="btn btn-warning pull-right" disabled="" id="btnSubmitPacking" data-toggle="modal" data-target="#submitPacking">PACKING <i class="fa fa-arrow-right"></i></button>
			<button onclick="delTemp()" type="button" class="btn btn-success pull-right"  id="cetakPackingList" <?php if ($totalQtyMinta > 0) {echo 'disabled';} ?> >VERIFIKASI <i class="fa fa-file-pdf-o"></i></button>
			<!-- <a class="btn btn-danger pull-right" id="reset" data-toggle="modal" data-target="#resetPacking">RESET <i class="fa fa-trash"></i></a> -->
		</div>
	</div>
	<div class="modal fade" id="submitPacking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Packing Weight (.Kg)</h4>
	      </div>
	      <div class="modal-body">
	      	<input type="number"  pattern="[0-9]+([,\.][0-9]+)?" step="0.01" title="This should be a number with up to 2 decimal places." name="weight" class="form-control" placeholder="Weight (.Kg)" required="">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
	        <button type="submit" class="btn btn-primary">CETAK</button>
	      </div>
	    </div>
	  </div>
	</div>
</form>
<div class="modal fade" id="resetPacking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Are you sure you want to reset?</h4>
        <small>All packing data in this SPB will be remove</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
        <a class="btn btn-primary" href="<?php echo base_url('WarehouseSPB/Transaction/PackingListReset/'.$nomerspb) ?>">RESET</a>
      </div>
    </div>
  </div>
</div>
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