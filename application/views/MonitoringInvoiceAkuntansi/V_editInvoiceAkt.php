<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
</style>

<form method="post" action="<?php echo base_url('AccountPayables/MonitoringInvoice/Unprocess/SaveEdit/'.$detail[0]['INVOICE_ID']) ?>">
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-8">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Edit Invoice</b></span>
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
											<span><label>Nomor PO</label></span>
										</td>
										<td>
											<input value="<?php echo $detail[0]['PO_NUMBER']?>"placeholder="Nomor PO" type="text" name="txtNoPO" class="ininopo form-control" size="40" id="nomorPOID">
		                     			</td>
		                     			<td>
		                     				<button type="button" id="btnCariTop" class="btn btn-success"> Cari </button>
		                     			</td>
									</tr>
									<tr>
										<td>
											<span><label>Vendor</label></span>
										</td>
										<td>
		                     				<select id="slcVendor" name="vendor_number" class="vendorNameClass form-control select2 select2-hidden-accessible" style="width:320px;">
												<!-- <option value="" > Nama Vendor </option>
												<?php foreach ($allVendor as $av) { ?>
												<option value="<?php echo $av['VENDOR_ID'] ?>"><?php echo $av['VENDOR_NAME'] ?></option>
												<?php } ?> -->

												<option value="" > Nama Vendor </option>
												<?php foreach ($allVendor as $k) { 
													$s='';
													if ($k['VENDOR_NAME'] === $detail[0]['VENDOR_NAME']) {
													$s='selected';
																		}
													?>
							<option value="<?php echo $k['VENDOR_ID'] ?>" <?php echo $s ?>><?php echo $k['VENDOR_NAME'] ?></option>
													<?php } ?>

											</select>
											<input type="hidden" class="hdnTextForVendor" id="hdnTxt" name="hdnTxtVendor">
		                     			</td>
		                     			<td>
		                     				<span><label>(*) Untuk cari nama vendor, TOP, dan status PPN. <br>Harap klik tombol 'Cari'</label></span>
		                     			</td>
									</tr>
									<tr>
										<td>
											<span><label>Term of Payment</label></span>
										</td>
										<td>
											<input value="<?php echo $detail[0]['TERM_OF_PAYMENT']?>" placeholder="Term of Payment" type="text" name="txtToP" class="form-control termOfPayment" size="40" id="termOfPayment">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>PPN Status</label></span>
										</td>
										<td>
											<input disabled type="text" name="ppnStatus" class="form-control ppnStatus" size="40" id="ppn_status">
										</td>
										<!-- value="<?php echo $detail[0]['PPN']?>" -->
									</tr>
									<tr>
										<td>
											<span><label>Invoice Date</label></span>
										</td>
										<td>
						                    <input value="<?php echo  date('d-M-Y',strtotime($detail[0]['INVOICE_DATE']))?>" placeholder="Wajib diisi" type='text' class="form-control idDateInvoice" id="invoice_dateid" size="40" name="invoice_date"  placeholder="Invoice Date">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Number</label></span>
										</td>
										<td>
											<input value="<?php echo $detail[0]['INVOICE_NUMBER']?>" placeholder="Wajib diisi" class="form-control" size="40" type="text" name="invoice_number" placeholder="No. Invoice" id="invoice_numbergenerate">
										</td>
										<td>
											<button type="button" class="btn btn-primary" id="btnGenerate">Generate</button>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Amount</label></span>
										</td>
										<td>
										
											<input value="<?php echo 'Rp. '. number_format($detail[0]['INVOICE_AMOUNT'],0,'.','.').',00-';?>" placeholder="Wajib diisi" class="form-control" size="40" type="text" name="invoice_amount" placeholder="Invoice Amount" id="inv_amount_akt">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Category</label></span>
										</td>
										<td>
											<select name="invoice_category" id="invoice_category" class="form-control select2 select2-hidden-accessible" style="width:320px;">
												<?php if ($detail[0]['INVOICE_CATEGORY'] == 'BARANG') { ?>
												<option value="BARANG">BARANG</option>
												<?php } else if ($detail[0]['INVOICE_CATEGORY'] == 'JASA NON EKSPEDISI TRAKTOR'){ ?>
												<option value="JASA NON EKSPEDISI TRAKTOR">JASA NON EKSPEDISI TRAKTOR</option>
												<?php } else if ($detail[0]['INVOICE_CATEGORY'] == 'JASA EKSPEDISI TRAKTOR') { ?>
												<option value="JASA EKSPEDISI TRAKTOR">JASA EKSPEDISI TRAKTOR</option>
												<?php } else { ?> 
												<option value="">Pilih</option>
												<option value="BARANG">BARANG</option>
												<option value="JASA NON EKSPEDISI TRAKTOR">JASA NON EKSPEDISI TRAKTOR</option>
												<option value="JASA EKSPEDISI TRAKTOR">JASA EKSPEDISI TRAKTOR</option>
											<?php } ?>
												<option value="BARANG">BARANG</option>
												<option value="JASA NON EKSPEDISI TRAKTOR">JASA NON EKSPEDISI TRAKTOR</option>
												<option value="JASA EKSPEDISI TRAKTOR">JASA EKSPEDISI TRAKTOR</option>
											</select>
									</tr>
									<tr>
										<td>
											<span><label>Tax Invoice Number</label></span>
										</td>
										<td>
											<input value="<?php echo $detail[0]['TAX_INVOICE_NUMBER']?>" class="form-control tax_class" size="40" type="text" id="tax_id_inv" name="tax_invoice_number" data-toggle="tooltip" data-placement="top" title="Jika Tax Invoice, Nominal DPP, dan Faktur Pajak tidak diisi. Harap masukkan Alasan di kolom Info" placeholder="Tax Invoice Number" >
										</td>
										<td>
											<span><b>(*)Jika Tax Invoice, Nominal DPP, dan Nominal PPN tidak diisi. <br>Harap masukkan Alasan di kolom Info</b></span>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Nominal DPP Faktur Pajak</label></span>
										</td>
										<td>
											<input value="<?php echo $detail[0]['NOMINAL_DPP']?>" class="form-control nomdppfaktur" size="40" id="idNominalDpp" type="text" name="nominal_dpp" placeholder="Nominal DPP Faktur Pajak" onchange="ambilNominalPPPN()" data-toggle="tooltip" data-placement="top"title="tekan 'Tab' untuk memunculkan Nominal PPN">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Nominal PPN</label></span>
										</td>
										<td>
											<input value="<?php echo $detail[0]['NOMINAL_PPN']?>" class="form-control nomppn" size="40" id="nominalPPN" type="text" name="nominalPPN" placeholder="Nominal PPN Otomatis" >
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Info</label></span>
										</td>
										<td>
											<textarea class="form-control" size="40" type="text" name="note_admin" placeholder="Info"><?php echo $detail[0]['INFO']?></textarea>
										</td>
									</tr>
								</table>
							</form>
						<div style="overflow: auto">
						<!-- <table id="detailUnprocessed" class="table table-bordered table-hover table-striped text-center tblMI" style="width: 200%">
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
						</table> -->
						</div>
						<!-- <div class="col-md-4 pull-left">
							<label>Po Amount: <span><?php echo 'Rp. '. number_format(round($po_amount),0,'.','.').',00-';?></span></label>
						</div> -->
						<div class="col-md-2 pull-right">
							<button type="submit" class="btn btn-warning pull-right" style="margin-top: 10px" >Edit</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
</form>