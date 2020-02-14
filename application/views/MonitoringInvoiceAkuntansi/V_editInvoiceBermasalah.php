<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
</style>

<script type="text/javascript">
	$(document).ready(function() {
	Swal.fire({
			  type: 'info',
			  title: 'Harap cek kembali data Invoice sebelum mengganti Nomor PO',
			  showConfirmButton: true,
			  // timer: 1500
			})
})
</script>

<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Edit PO Invoice ID <?php echo $detail[0]['INVOICE_ID']?></b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-8">
						<div class="box box-primary box-solid">
							<div class="box-body" style="padding-left:30px;padding-top:30px;">
								<table id="tbInvoice" >
									<tr>
										<td>
											<span><label>Cari Invoice ID</label></span>
										</td>
										<td>
											<input readonly value="<?php echo $detail[0]['INVOICE_ID']?>" type="text" name="txtInvID" class="invIdtxt form-control" size="40" id="invoice_id_nih" placeholder="Punya Invoice ID ?">
		                     			</td>
		                     			<td>
		                     				<button disabled style="width: 100px;" type="button" id="btnCariInvId" onclick="cariInvoicebyId()" class="btn btn-warning btn-md"></i> Go! </button>
		                     			</td>
									</tr>
									<tr>
										<td>
											<span><label>Nomor PO</label></span>
										</td>
										<td>
											<input data-toggle="tooltip" data-placement="top" title="Harap klik button 'Cari' setelah mengganti nomor PO" value="<?php echo $cari[0]['NO_PO']?>" type="text" name="txtNoPO" class="ininopo form-control" size="40" id="nomorPOID">
		                     			</td>
		                     			<td>
		                     				<button type="button" style="width: 100px;" id="btnCariTop" class="btn btn-success"> Cari </button>
		                     			</td>
									</tr>
									<tr>
										<td>
											<span><label>Vendor</label></span>
										</td>
										<td>
		                     				<select id="slcVendorEdit" name="vendor_number" class="vendorNameClass form-control select2 select2-hidden-accessible" style="width:100%;">
												<option value="" > Nama Vendor </option>
												<?php foreach ($allVendor as $k) { 
													$s='';
													if ($k['VENDOR_ID'] == $cari[0]['VENDOR_ID'] ) {
													$s='selected';
												}?>
											<option value="<?php echo $k['VENDOR_ID'] ?>" <?php echo $s ?>><?php echo $k['VENDOR_NAME'] ?></option>
													<?php } ?>
											</select>
											<input type="hidden" class="hdnTextForVendor" id="hdnTxt" name="hdnTxtVendor">
		                     			</td>
									</tr>
									<tr>
										<td>
											<span><label>Term of Payment</label></span>
										</td>
										<td>
											<input value="<?php echo $cari[0]['PAYMENT_TERMS']?>" type="text" name="txtToP" class="form-control termOfPayment" size="40" id="termOfPayment">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>PPN Status</label></span>
										</td>
										<td>
												<select id="ppn_status" name="ppn_status" class="ppn_status form-control select2 select2-hidden-accessible" style="width:100%;">
												<option value="">Pilih</option>
												<?php if ($cari[0]['PPN'] = 'Y') {
												$s = 'selected';
												}else if ($cari[0]['PPN'] = 'N'){
												$s = 'selected';
												} ?>
												<option value="Y" <?= $s?> >Y</option>
												<option value="N" <?= $s?> >N</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Date</label></span>
										</td>
										<td>
						                    <input readonly type='text' class="form-control idDateInvoiceTambahInvBer" id="invoice_dateid" size="40" name="invoice_date" value="<?php echo  date('d-M-Y',strtotime($detail[0]['INVOICE_DATE']))?>" placeholder="Invoice Date">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Number</label></span>
										</td>
										<td>
											<input readonly value="<?php echo $detail[0]['INVOICE_NUMBER']?>" class="form-control" size="40" type="text" name="invoice_number" placeholder="No. Invoice" id="invoice_numbergenerate">
										</td>
										<td>
											<button disabled type="button" style="width: 100px;" class="btn btn-primary" id="btnGenerate">Generate</button>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Amount</label></span>
										</td>
										<td>
											<input readonly value="<?php echo 'Rp. '. number_format($detail[0]['INVOICE_AMOUNT'],0,'.','.').',00-';?>" class="form-control" size="40" type="text" name="invoice_amount" placeholder="Invoice Amount" id="inv_amount_akt">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Category</label></span>
										</td>
										<td>
											<select disabled name="invoice_category" id="invoice_category" class="form-control select2 select2-hidden-accessible" style="width:100%;">
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
												<!-- reupload -->
												<!-- reupload -->
											</select>
										</td>
										<td id="jenis_jasa" style="display: none">
											<select name="jenis_jasa" class="form-control select2 select2-hidden-accessible" style="width:320px;">
												<option></option>
												<option>RECEIPT</option>
												<option>RECEIPT DAN PEMBAYARAN</option>
												<option>RECEIPT DAN REASLISASI PREPAYMENT</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Kategori</label></span>
										</td>
											<td>
											 <input readonly type="text" class="form-control" style="width: 320px;" name="txtKategori" value="<?php echo $detail[0]['KATEGORI_INV_BERMASALAH']?>">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Kelengkapan Dokumen</label></span>
										</td>
										<td>
											 <input readonly type="text" class="form-control" style="width: 320px;" name="txtKelengkapan" value="<?php echo $detail[0]['KELENGKAPAN_DOC_INV_BERMASALAH']?>">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Keterangan</label></span>
										</td>
										<td>
											<textarea readonly class="form-control" id="txaKeterangan" name="txaKeterangan" placeholder="Keterangan"><?php echo $detail[0]['KETERANGAN_INV_BERMASALAH']?></textarea>
										</td>
									</tr>
								</table>
									<div class="col-md-4 pull-right" style="margin-top: 50px;margin-bottom: 25px;">
										<button id="btnUpdatePO" onclick="updatePO(<?php echo $detail[0]['INVOICE_ID']?>)" class="btn btn-success pull-right" style="margin-top: 10px;margin-right: 5px;" ><i class="fa fa-check"></i> Update PO</button>
									</div>
								</div> 
			</div>
		</div>
	</div>
</section>
</form>