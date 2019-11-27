<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
</style>

<form method="post" action="<?php echo base_url('AccountPayables/MonitoringInvoice/NewInvoice/addPoNumberAkt') ?>">
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Add Invoice Akuntansi</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-8">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<table id="tbInvoice" >
									<tr>
										<td>
											<span><label>Nomor PO</label></span>
										</td>
										<td>
											<input value="0" placeholder="Nomor PO" type="text" name="txtNoPO" class="ininopo form-control" size="40" id="nomorPOID">
		                     				<!-- <select id="slcNomorPO" onchange="cariNomorPO()" name="nomor_po" class="form-control select2 select2-hidden-accessible" style="width:320px;">
												<option value="" > Cari No. PO </option>
												<?php foreach ($nomor_po as $av) { ?>
												<option value="<?php echo $av['PO_NUMBER'] ?>"><?php echo $av['PO_NUMBER'] ?></option>
												<?php } ?> -->

											<!-- </select> -->
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
		                     				<select onchange="iniVendor()" id="slcVendor" name="vendor_number" class="vendorNameClass form-control select2 select2-hidden-accessible" style="width:320px;">
												<option value="" > Nama Vendor </option>
												<?php foreach ($allVendor as $av) { ?>
												<option value="<?php echo $av['VENDOR_ID'] ?>"><?php echo $av['VENDOR_NAME'] ?></option>
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
											<input placeholder="Term of Payment" type="text" name="txtToP" class="form-control termOfPayment" size="40" id="termOfPayment">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>PPN Status</label></span>
										</td>
										<td>
											<select name="ppn_status" id="ppn_status" class="form-control select2 select2-hidden-accessible" style="width:320px;">
												<option value="">Pilih</option>
												<option value="Y">Y</option>
												<option value="N">N</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Date</label></span>
										</td>
										<td>
						                    <input placeholder="Wajib diisi" type='text' class="form-control idDateInvoice" id="invoice_dateid" size="40" name="invoice_date"  placeholder="Invoice Date">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Number</label></span>
										</td>
										<td>
											<input placeholder="Wajib diisi" class="form-control" size="40" type="text" name="invoice_number" placeholder="No. Invoice" id="invoice_numbergenerate">
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
										<!-- 	data-toggle="tooltip" data-placement="top" title=" Masukkan nominal PO Amount secara manual, lalu tekan 'Tab' -->
											<input placeholder="Wajib diisi" class="form-control" size="40" type="text" name="invoice_amount" placeholder="Invoice Amount" id="inv_amount_akt">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Category</label></span>
										</td>
										<td>
											<select name="invoice_category" id="invoice_category" class="form-control select2 select2-hidden-accessible" style="width:320px;">
												<option value="">Pilih</option>
												<option value="BARANG">BARANG</option>
												<option value="JASA NON EKSPEDISI TRAKTOR">JASA NON EKSPEDISI TRAKTOR</option>
												<option value="JASA EKSPEDISI TRAKTOR">JASA EKSPEDISI TRAKTOR</option>
												<!-- reupload -->
												<!-- reupload -->
											</select>
										</td>
										<!-- <td id="jenis_jasa" style="display: none">
											<select name="jenis_jasa" class="form-control select2 select2-hidden-accessible" style="width:320px;">
												<option></option>
												<option>RECEIPT</option>
												<option>RECEIPT DAN PEMBAYARAN</option>
												<option>RECEIPT DAN REASLISASI PREPAYMENT</option>
											</select>
										</td> -->
									</tr>
									<tr>
										<td>
											<span><label>Tax Invoice Number</label></span>
										</td>
										<td>
											<!-- <input value ="010.005-" class="form-control tax_class" size="40" type="text" id="tax_id_inv" name="tax_invoice_number" data-toggle="tooltip" data-placement="top" title="Jika Tax Invoice, Nominal DPP, dan Faktur Pajak tidak diisi. Harap masukkan Alasan di kolom Info" placeholder="Tax Invoice Number" > -->
											<select name="tax_invoice_number" id="tax_status" class="form-control select2 select2-hidden-accessible" style="width:320px;">
												<option value="">Pilih</option>
												<option value="Y">YES</option>
												<option value="N">NO</option>
											</select>
										</td>
										<!-- <td>
											<span><b>(*)Jika Tax Invoice, Nominal DPP, dan Nominal PPN tidak diisi. <br>Harap masukkan Alasan di kolom Info</b></span>
										</td> -->
									</tr>
									<!-- <tr>
										<td>
											<span><label>Nominal DPP Faktur Pajak</label></span>
										</td>
										<td>
											<input value="0" class="form-control nomdppfaktur" size="40" id="idNominalDpp" type="text" name="nominal_dpp" placeholder="Nominal DPP Faktur Pajak" onchange="ambilNominalPPPN()" data-toggle="tooltip" data-placement="top"title="tekan 'Tab' untuk memunculkan Nominal PPN">

											
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Nominal PPN</label></span>
										</td>
										<td>
											<input value="0" class="form-control nomppn" size="40" id="nominalPPN" type="text" name="nominalPPN" placeholder="Nominal PPN Otomatis" >
										</td>
									</tr> -->
									<tr>
										<td>
											<span><label>Info</label></span>
										</td>
										<td>
											<textarea class="form-control" size="40" type="text" name="note_admin" placeholder="Jika status PPN 'Y' namun Tax Invoice bernilai 'N' wajib isi alasan di kolom info"></textarea>
										</td>
									</tr>
								</table>
						<!-- <div class="box box-primary box-solid"> -->
							<!-- <div class="box-body"> -->
								<!-- <div class="box-header with-border">
								PO Data
								</div> -->
								<div class="col-md-12">
									<div class="col-md-12">
										<div class="col-md-6">
									<!-- 		<table id="filter" class="col-md-12" style="margin-bottom: 20px">
												<tr>
													<td>
														<span class="text-center"><label>Po Number</label></span>
													</td>
												<td>
														<div class="col-md-12" id="divPoNumber">
															<div class="col-md-12">
																<input name="slcPoNumberInv" placeholder="Masukkan PO Number" id="slcPoNumberMonitoring" class="form-control" style="width:100%;">
																</input>
															</div>
														</div>
													</td>
													<td>
														<div><button class="btn btn-md btn-success pull-left btn_search" type="button" id="btnSearchPoNumber">Search</button>
														</div>
													</td>
												</tr>
											</table>
										</div>
									</div>
									<div id="tablePoLines">
										
									</div> -->
								</div>
							</div>
						</div>
						<!-- <span><b>Invoice PO Detail</b></span>
						<div style="overflow:auto;">
							<table class="table table-bordered table-hover table-striped text-center" style="min-width:200%;">
								<thead>
									<tr class="bg-primary">
										<th class="text-center">No</th>
										<th class="text-center">Line Number</th>
										<th class="text-center">Vendor Name</th>
										<th class="text-center">PO Number</th>
										<th class="text-center">LPPB Number</th>
										<th class="text-center">Status LPPB</th>
										<th class="text-center">Shipment Number</th>
										<th class="text-center">Receive Date</th>
										<th class="text-center">Item Code</th>
										<th class="text-center">Item Description</th>
										<th class="text-center">Qty Amount</th>
										<th class="text-center">Qty Billed</th>
										<th class="text-center">Qty Reject</th>
										<th class="text-center">Currency</th>
										<th class="text-center">Unit Price</th>
										<th class="text-center">Qty Po</th>
										<th class="text-center">Qty Invoice</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody id="tbodyPoDetailAll">

								</tbody>
							</table>
						</div>
						<div class="col-md-4 pull-left">
							<label>Po Amount : </label><span id="AmountOtomatis" ></span><span id="currency"></span>
						</div> -->
						<!-- <label>Po Amount : </label><span><?php echo 'Rp. '. number_format(round($po_amount),0,'.','.').',00-';
								          ?></span> -->
						<div class="col-lg-8">
							<!-- <a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice')?>"> -->
							<button type="reset" id="btnMICancel" class="btn btn-danger pull-left" style="margin-top: 10px;">Clear</button>
							<!-- </a> -->
							<button id="btnMISave" class="btn btn-success pull-left" style="margin-top: 10px;margin-left: 5px;" >Save</button>
						</div>
					<!-- </div> -->
				<!-- </div> -->
			</div>
		</div>
	</div>
</section>
</form>
