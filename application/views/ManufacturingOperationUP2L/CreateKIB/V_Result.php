	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/dataTables/buttons.dataTables.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/dataTables/extensions/FixedColumns/css/dataTables.fixedColumns.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css');?>" />

 <style type="text/css">
 	.text-bold-cuk{
 		font-weight: bold;
 	}
 </style>

<?php if ($result === true): ?>

<table width="100%" class="table" >
	<thead>
		
	<tr class="bg-info">
		<th>JOB NUMBER</th>
		<th>:</th>
		<th><?= $header ? $header[0]['BATCH_NUMBER'] : ''; ?></th>
		<th>SHIFT</th>
		<th>:</th>
		<th><?= $header ? $header[0]['SHIFT'] : ''; ?></th>
	</tr>
	<tr class="bg-info">
		<th>KODE ITEM</th>
		<th>:</th>
		<th><?= $header ? $header[0]['ITEM_CODE'] : ''; ?></th>
		<th>DEPARTEMEN</th>
		<th>:</th>
		<th><?= $header ? $header[0]['DEPT_CLASS'] : ''; ?></th>
	</tr>
	<tr class="bg-info">
		<th>NAMA ITEM</th>
		<th>:</th>
		<th><?= $header ? $header[0]['DESCRIPTION'] : ''; ?></th>
		<th>QUANTITY</th>
		<th>:</th>
		<th><?= $header ? $header[0]['TARGET_PPIC'] : ''; ?></th>
	</tr>
	<tr class="bg-info">
		<th>TIPE PRODUK</th>
		<th>:</th>
		<th><?= $header ? $header[0]['TYPE_PRODUCT'] : ''; ?></th>
		<th>UNIT</th>
		<th>:</th>
		<th><?= $header ? $header[0]['UOM_CODE'] : ''; ?></th>
	</tr>
	</thead>
</table>
<table class="table tblResultIMO table-responsive table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th>NO.</th>
			<th>Status</th>
			<th>Qty</th>
			<th>Gudang Asal</th>
			<th>Locator Asal</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php $arrErr = array(); $no = 1; foreach ($detail as $key => $value) { ?>
		<tr>
			<td><?= $no++; ?>
				
			</td>
			<td><?= $value['STATUS'] ?></td>
			<td><?= $value['TRANSACTION_QUANTITY'] ?></td>
			<td><?= $value['SUBINVENTORY_CODE'] ?></td>
			<td><?= $value['LOCATOR_NAME'] ?></td>
			<td>
				<center>
					<?php if ($value['MO'] == 1) { ?>
						<a href="<?= base_url("InventoryManagement/CreateKIB/pdf/$value[STATUS_ITEM]")."/".$header[0]['BATCH_NUMBER']."/0" ?>" target="blank">
						<button type="submit" class="btn btn-sm btn-success">
							<b class="fa fa-print"></b> Print KIB
						</button>
						</a>
					<?php } else { ?>
					<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#formPrint" onclick="imo_printKIB(this)" status-val="<?= $value['STATUS_ITEM'] ?>" qty-val="<?= $value['TRANSACTION_QUANTITY'] ?>" subinv-val ="<?= $value['SUBINVENTORY_CODE'] ?>" loc-val="<?= $value['LOCATOR_ID'] ?>" >
						<b class="fa fa-print"></b> Print KIB
					</button>
					<?php } ?>
				</center>
			</td>
		</tr>
		<?php 
			} ?>
	</tbody>
</table>

		<div id="formPrint" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- konten modal-->
				<div class="modal-content">
					<!-- heading modal -->
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title text-center">Silahkan Isi Terlebih Dahulu</h4>
					</div>
					<!-- body modal -->
					<form action="<?php echo base_url('InventoryManagement/CreateKIB/submitpdf') ?>" method="post">
						<input type="hidden" name="txtNoBatch" value="<?= $header ? $header[0]['BATCH_NUMBER'] : ''; ?>">
						<input type="hidden" name="txtStatus" id="id_imo_txt_status">
						<input type="hidden" name="txtUom" value="<?= $header ? $header[0]['UOM_CODE'] : ''; ?>">
						<input type="hidden" name="txtQtyTarget" id="id_imo_qty_actual">
						<input type="hidden" name="txtSubInvFrom" id="id_imo_subinv_from">
						<input type="hidden" name="txtLocatorFrom" id="id_imo_loc_from">
					<div class="modal-body">
						<table width="100%">
							<tr class="bg-success">
								<td style="padding: 5px; width: 35%">
									<label>Pilih ORG</label>
								</td>
								<td style="padding: 5px; width: 65%">
									<select id="id_imo_slc_org" style="width:100%" name="slcOrgIMO" class="form-control selectIMO" onchange="getIMOSubInv(this)" data-placeholder="Pilih ORG ..">
										<option></option>
										<option value="ODM">ODM</option>
										<option value="OPM">OPM</option>
										<option value="OPT">OPT</option>
										<option value="YTH">YTH</option>
									</select>
								</td>
							</tr>
							<tr>
								<td style="padding: 5px">
									<label>Pilih Sub Inventory</label>
								</td>
								<td style="padding: 5px">
									<select style="width: 100%" name="slcSubInvIMO" id="id_imo_slc_subinv" class="form-control selectIMO" disabled="disabled" onchange="getIMODescSubInv(this)"  data-placeholder="Pilih Sub Inventory ..">
										<option></option>
									</select>
								</td>
							</tr>
							<tr style="display: none" id="id_imo_tr_desc_subinv">
								<td style="padding: 5px" >
									<label>Desc. Sub Inventory</label>
								</td>
								<td style="padding: 5px">
									<p id="id_imo_desc_sub_inv"></p>
								</td>
							</tr>
							<tr style="display: none" id="id_imo_tr_slc_loc">
								<td style="padding: 5px">
									<label>Pilih Locator</label>
								</td>
								<td style="padding: 5px">
									<select onchange="nextQty(this)" style="width: 100%" name="slcLocator" id="id_imo_slc_loc" class="selectIMO" disabled="disabled" data-placeholder="Pilih Locator..">
										<option></option>
									</select>
								</td>
							</tr>
							<tr>
								<td style="padding: 5px">
									<label>Qty per Handling</label>
								</td>
								<td style="padding: 5px">
									<input onkeyup="checkFill()" required id="id_imo_qty_handling" name="qtyHandling" type="number" class="form-control" style="width: 100%" <?= ($handling) ? 'readonly value="'.$handling.'"' : '' ?> >
								</td>
							</tr>
						</table>
					</div>
					<!-- footer modal -->
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" disabled="disabled" id="id_imo_btn_sub" ><b class="fa fa-print"></b> PRINT KIB</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
					</div>
					</form>
				</div>
			</div>
		</div>
<?php else: ?>
	<center>
		<div style="border: 1px solid #f48181">
			<?= "$message"; ?>
		</div>
	</center>
<?php endif; ?>


	<script src="<?php echo base_url('assets/js/customIMO.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>