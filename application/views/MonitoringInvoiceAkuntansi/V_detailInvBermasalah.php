<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
</style>

<section class="content">
	<form method="post" action="<?php echo base_url('AccountPayables/MonitoringInvoice/Unprocess/EditInvBermasalah/'.$detail[0]['INVOICE_ID']); ?>">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Detail Invoice Bermasalah</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
							<form id="filInvoice" >
								<table id="tbInvoice" >
									<tr>
										<td>
											<span><label>Invoice Number</label></span>
										</td>
										<td><input  class="form-control" size="40" type="text" value="<?php echo $detail[0]['INVOICE_NUMBER']?>" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice ID</label></span>
										</td>
										<td><input  class="form-control" size="40" type="text" value="<?php echo $detail[0]['INVOICE_ID']?>" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Date</label></span>
										</td>
										<td>
											<input  class="form-control" size="40" type="text" value="<?php echo  date('d-M-Y',strtotime($detail[0]['INVOICE_DATE']))?>" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Amount</label></span>
										</td>
										<td>
											<input  class="form-control" size="40" type="text" value="<?php echo 'Rp. '. number_format($detail[0]['INVOICE_AMOUNT'],0,'.','.').',00-';?>" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Tax Invoice Number</label></span>
										</td>
										<td>
											<input  class="form-control" size="40" type="text" value="<?php echo $detail[0]['TAX_INVOICE_NUMBER']?>" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Category</label></span>
										</td>
										<td>
		                     				<input class="form-control" size="40" type="text"  value="<?php echo $detail[0]['INVOICE_CATEGORY']?>" readonly>
		                     			</td>
		                     			<td>
											<span><label>Jenis Jasa</label></span>
										</td>
										<td>
		                     				<input class="form-control" size="40" type="text"  value="<?php echo $detail[0]['JENIS_JASA']?>" readonly>
		                     			</td>
									</tr>
									<tr>
										<td>
											<span><label>Nominal DPP Faktur Pajak</label></span>
										</td>
										<td>
		                     				<input class="form-control" size="40" type="text"  value="<?php echo $detail[0]['NOMINAL_DPP']?>" readonly>
		                     			</td>
									</tr>
									<tr>
										<td>
											<span><label>Info</label></span>
										</td>
										<td>
											<textarea class="form-control" size="40" type="text" readonly><?php echo $detail[0]['INFO']?></textarea>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Kategori</label></span>
										</td>
										<td>
											<input type="text" name="txtKategori" class="form-control" value="<?php echo $detail[0]['KATEGORI_INV_BERMASALAH']?>">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Kelengkapan Dokumen</label></span>
										</td>
										<td>
											<input type="text" name="txtKategori" class="form-control" value="<?php echo $detail[0]['KELENGKAPAN_DOC_INV_BERMASALAH']?>">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Keterangan</label></span>
										</td>
									<td>
										<textarea class="form-control" id="txaKeterangan" name="txaKeterangan" placeholder="Keterangan"><?php echo $detail[0]['KETERANGAN_INV_BERMASALAH']?></textarea>
									</td>
									</tr>
								</table>
								<br>
							</form>
						<span><b>Invoice PO Detail</b></span>
						<div style="overflow: auto">
						<table id="detailUnprocessed" class="table table-bordered table-hover table-striped text-center tblMI" style="width: 200%">
							<thead>
								<tr class="bg-primary">
									<th class="text-center">No</th>
									<th class="text-center">Vendor</th>
									<th class="text-center">PO Number</th>
									<th class="text-center">LPPB Number</th>
									<th class="text-center">Shipment Number</th>
									<th class="text-center">Receive Date</th>
									<th class="text-center">Item Code</th>
									<th class="text-center">Item Description</th>
									<th class="text-center">Qty Receipt</th>
									<th class="text-center">Qty Reject</th>
									<th class="text-center">Currency</th>
									<th class="text-center">Unit Price</th>
									<th class="text-center">Qty Invoice</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=1; $po_amount=0; foreach($detail as $b){?>
								<tr>
									<td class="text-center"><?php echo $no ?></td>
									<td class="text-center"><?php echo $b['VENDOR_NAME']?></td>
									<td class="text-center"><?php echo $b['PO_NUMBER']?></td>
									<td class="text-center"><?php echo $b['LPPB_NUMBER']?></td>
									<td class="text-center"><?php echo $b['SHIPMENT_NUMBER']?></td>
									<td class="text-center"><?php echo $b['RECEIVED_DATE']?></td>
									<td class="text-center"><?php echo $b['ITEM_CODE']?></td>
									<td class="text-center"><?php echo $b['ITEM_DESCRIPTION']?></td>
									<td class="text-center"><?php echo $b['QTY_RECEIPT']?></td>
									<td class="text-center"><?php echo $b['QTY_REJECT']?></td>
									<td class="text-center"><?php echo $b['CURRENCY']?></td>
									<td class="text-center"><?php echo $b['UNIT_PRICE']?></td>
									<td class="text-center"><?php echo $b['QTY_INVOICE']?></td>
								</tr>
								<?php $no++; $po_amount=$po_amount+($b['UNIT_PRICE'] * $b['QTY_INVOICE']); }?>
							</tbody>
						</table>
						</div>
						<div class="col-md-4 pull-left">
							<label>Po Amount: <span><?php echo 'Rp. '. number_format(round($po_amount),0,'.','.').',00-';?></span></label>
						</div>
						<div class="col-md-2 pull-right">
					<?php if ($detail[0]['STATUS_IB'] == '1' && $detail[0]['SOURCE'] == 'AKUNTANSI') { ?>
					<button type="submit" id="btnEditInv" class="btn btn-success btn-m pull-right" style="margin-top: 10px;margin-left: 5px;"><i class="fa fa-pencil"></i> Edit</button>
					<?php }else { ?>

					<?php }?>
				</form>
					<button type="button" id="btnBack" onclick="window.location.replace(baseurl+'AccountPayables/MonitoringInvoice/InvoiceBermasalahAkt')" class="btn btn-primary btn-m pull-right" style="margin-top: 10px;" ><i class="fa fa-home"></i> Back</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>