<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
</style>

<section class="content">
<!-- 	<form method="post" action="<?php echo base_url('AccountPayables/MonitoringInvoice/InvoiceBermasalahKasiePurc/List/saveInvBermasalah/'.$detail[0]['INVOICE_ID']); ?>"> -->
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
											<span><label>Nomor PO</label></span>
										</td>
										<td><input  class="form-control" size="40" type="text" value="<?php echo $detail[0]['PO_NUMBER']?>" readonly>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Vendor</label></span>
										</td>
										<td><input  class="form-control" size="40" type="text" value="<?php echo $detail[0]['VENDOR_NAME']?>" readonly>
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
											<input type="text" name="txtKategori" class="form-control" value="<?php echo $detail[0]['KATEGORI_INV_BERMASALAH']?>" readonly>
										</td>
									</tr>
									<!-- <tr>
										<td>
											<span><label>Kelengkapan Dokumen</label></span>
										</td>
										<td>
											<input type="text" name="txtKategori" class="form-control" value="<?php echo $detail[0]['KELENGKAPAN_DOC_INV_BERMASALAH']?>" readonly>
										</td>
									</tr> -->
									<tr>
										<td>
											<span><label>Keterangan Akuntansi</label></span>
										</td>
									<td>
										<textarea class="form-control" id="txaKeterangan" name="txaKeterangan" placeholder="Keterangan" readonly><?php echo $detail[0]['KETERANGAN_INV_BERMASALAH']?></textarea>
									</td>
									</tr>
									<tr>
										<td>
											<span><label>Feedback Purchasing</label></span>
										</td>
									<td>
										<textarea class="form-control" id="txaFbPurc" name="txaFbPurc" placeholder="Diisi oleh Kasie Purchasing"></textarea>
									</td>
									</tr>
								</table>
								<br>
							</form>
						<span><b>Invoice PO Detail</b></span>
						<div style="overflow: auto">
						<table id="detailUnprocessed" class="table table-bordered table-hover table-striped text-center tblMI" style="width: 100%">
							<thead>
								<tr class="bg-primary">
									<th class="text-center">No</th>
									<th class="text-center">Kelengkapan Dokumen</th>
									<th class="text-center">Action</th>
									<th class="text-center">Hasil Konfirmasi Pembelian</th>
									<th class="text-center">Hasil Konfirmasi Buyer</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=1; foreach($berkas as $b){?>
								<tr>
									<td class="text-center"><?php echo $no ?></td>
									<td class="text-center"><?php echo $b?></td>
									<td><button type="button" class="btn btn-success btn-sm" onclick="btnApproveBerkas(this)" id="btnApproved" style="margin-right: 5px"><i class="fa fa-check"></i></button>
										<button type="button" onclick="btnRejectBerkas(this)" class="btn btn-danger btn-sm" id="btnApproved"><i class="fa fa-times"></i></button>
									<td><input type="hidden" name="berkas_status_purc[]" id="pembelian_id"><div class="hasil_pembelian"></div></td>
									<td><input type="hidden" name="berkas_status_buyer[]" id="buyer_id"><div class="hasil_buyer"></div></td>
								</tr>
								<?php $no++; }?>
							</tbody>
						</table>
						</div>
						<div class="col-md-1 pull-right">
							<button id="btnKasieBermasalah" class="btn btn-success pull-right" data-target="mdlNotifikasiKasie" data-toggle="modal" onclick="KonfirmasiBerkasPurc(<?php echo $detail[0]['INVOICE_ID']?>)" style="margin-top: 10px" >Konfirmasi</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- </form> -->
</section>

<div id="mdlNotifikasiKasie" class="modal fade" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content"  id="content1" >
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		    <h5 class="modal-title"> Notification for Confirmation </h5>
		  </div>
		  <div class="modal-body">
		    <div class="row">
		      <div class="col-md-12">Apakah Anda yakin akan melakukan Konfirmasi Invoice Bermasalah : <b><?php echo $detail[0]['INVOICE_ID']?></b> ?</div>
		    </div>
		  </div>
		  <div class="modal-footer">
		    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
		    <button type="button" class="btn btn-primary" id="mdlYesAkt" >Yes</button>
		  </div>
		</div>
 	</div>
</div>