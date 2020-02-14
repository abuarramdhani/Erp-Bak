
<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
</style>

<form method="post" action="<?php echo base_url('AccountPayables/MonitoringInvoice/InvoiceBermasalahAkt/addInvBermasalah') ?>">
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Add Invoice Bermasalah</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<table id="tbInvoice" >
									<tr>
										<td>
											<span><label>Cari Invoice ID</label></span>
										</td>
										<td>
											<input data-toggle="tooltip" data-placement="top" title="ID Invoice harus berasal dari invoice yang sudah diterima Akuntansi dan belum pernah dijadikan invoice bermasalah sebelumnya" type="text" name="txtInvID" class="invIdtxt form-control" size="40" id="invoice_id_nih" placeholder="Punya Invoice ID ?">
		                     			</td>
		                     			<td>
		                     				<button type="button" style="width: 100px;" id="btnCariInvId" onclick="cariInvoicebyId()" class="btn btn-warning btn-md"></i> Go! </button>
		                     			</td>
									</tr>
									<tr>
										<td>
											<span><label>Nomor PO</label></span>
										</td>
										<td>
											<input type="text" placeholder="Masukkan Nomor PO" name="txtNoPO" class="ininopo form-control" size="40" id="nomorPOID">
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
		                     				<select id="slcVendor" name="vendor_number" class="vendorNameClass form-control select2 select2-hidden-accessible" style="width:100%;">
												<option value="" > Nama Vendor </option>
												<?php foreach ($allVendor as $av) { ?>
												<option value="<?php echo $av['VENDOR_ID'] ?>"><?php echo $av['VENDOR_NAME'] ?></option>
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
											<input type="text" placeholder="-otomatis-" name="txtToP" class="form-control termOfPayment" size="40" id="termOfPayment">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>PPN Status</label></span>
										</td>
										<td>
												<select id="ppn_status" name="ppn_status" class="ppn_status form-control select2 select2-hidden-accessible" style="width:100%;">
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
						                    <input type='text' class="form-control idDateInvoiceTambahInvBer" id="invoice_dateid" size="40" name="invoice_date"  placeholder="Invoice Date">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Number</label></span>
										</td>
										<td>
											<input  class="form-control" size="40" type="text" name="invoice_number" placeholder="No. Invoice" id="invoice_numbergenerate">
										</td>
										<td>
											<button type="button" style="width: 100px;" class="btn btn-primary" id="btnGenerate">Generate</button>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Amount</label></span>
										</td>
										<td>
										<!-- 	data-toggle="tooltip" data-placement="top" title=" Masukkan nominal PO Amount secara manual, lalu tekan 'Tab' -->
											<input class="form-control" size="40" type="text" name="invoice_amount" placeholder="Invoice Amount" id="inv_amount_akt">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Category</label></span>
										</td>
										<td>
											<select name="invoice_category" id="invoice_category" class="form-control select2 select2-hidden-accessible" style="width:100%;">
												<option value="">Pilih</option>
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
												<option>RECEIPT DAN REALISASI PREPAYMENT</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Kategori</label></span>
										</td>
											<td>
											<select onchange="kategoriBermasalah(this)" name="slcKategori[]" id="slcKategori" class="form-control select2 select2-hidden-accessible" multiple style="width:100%;">
												<option value="Beda Harga">Beda Harga</option>
												<option value="Dokumen Tidak Lengkap">Dokumen Tidak Lengkap</option>
												<option value="Identitas Tidak Jelas">Identitas Tidak Jelas</option>
												<option value="LainLain">Lain Lain</option>
											 </select>
										</td>
										<td>
											<div class="customDiv">
											
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Kelengkapan Dokumen</label></span>
										</td>
										<td>
											<select onchange="kelengkapanDokumen(this)" name="slcKelengkapanDokumen[]" id="slcKelengkapanDokumen" multiple class="form-control select2 select2-hidden-accessible" style="width:100%;">
												<option value="Invoice">Invoice</option>
												<option value="FP">FP</option>
												<option value="LPPB">LPPB</option>
												<option value="SJ">SJ</option> 
												<option value="Without Document">Without Document</option> 
												<option value="DokumenLain">Dokumen Lain</option> 
											 </select>
										</td>
										<td>
											<div class="customDoc">
											
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Keterangan</label></span>
										</td>
									<td>
										<textarea class="form-control" id="txaKeterangan" name="txaKeterangan" placeholder="Keterangan"></textarea>
									</td>
									</tr>
								</table>
								<div class="col-md-12">
									<div class="col-md-12">
										<div class="col-md-6">
								</div>
							</div>
						</div>
						<div class="col-md-3" style="margin-top: 30px;margin-bottom: 20px">
							<!-- <a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice')?>"> -->
							<button style="width: 100px;margin-right:10px" type="reset" id="btnMICancel" class="btn btn-danger pull-left" >Clear</button>
							<button style="width: 100px;" id="btnMISave" class="btn btn-success pull-left" style="margin-top: 10px;margin-left: 5px;" >Save</button>
						</div>
			</div>
		</div>
	</div>
</section>
</form>