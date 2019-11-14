<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
</style>
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>List Invoice Bermasalah</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<!-- <div style="overflow: auto;"> -->
								<table id="unprocessTabel" class="table table-striped table-bordered table-hover text-center tblMI">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center">Invoice ID</th>
											<th class="text-center">Detail</th>
											<th class="text-center">Vendor Name</th>
											<th class="text-center">Invoice Number</th>
											<th class="text-center">Invoice Date</th>
											<th class="text-center">PPN</th>
											<th class="text-center">Tax Invoice Number</th>
											<!-- <th class="text-center">Invoice Amount</th> -->
											<!-- <th class="text-center">Po Amount</th> -->
											<th class="text-center">PO Number</th>
											<th class="text-center">Creation Date </th>
											<th class="text-center">Masalah </th>
											<th class="text-center">PIC</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach($bermasalah as $u){?>
										<tr>
											<td><?php echo $no ?></td>
											<td><?php echo $u['INVOICE_ID'] ?></td>
											<td data-id="<?= $u['INVOICE_ID'] ?>" batch_number="<?= $u['BATCH_NUMBER'] ?>" class="ganti_<?= $u['INVOICE_ID'] ?>">
												<a title="Detail..." target="_blank" href="<?php echo base_url('AccountPayables/MonitoringInvoice/InvoiceBermasalahKasiePurc/List/DetailInvKasie/'.$u['INVOICE_ID']);?>" class="btn btn-info"><i class="fa fa-file-text-o"></i>
												</a>
											</td>
											<td><?php echo $u['VENDOR_NAME']?></td>
											<td><strong><?php echo $u['INVOICE_NUMBER']?></strong></td>
											<td><?php echo date('d-M-Y',strtotime($u['INVOICE_DATE']))?></td>
											<td><?php echo $u['PPN'] ?></td>
											<td><?php echo $u['TAX_INVOICE_NUMBER']?></td>
											<!-- <td class="inv_amount" >
											<?php if($u['INVOICE_AMOUNT']==NULL) {
								          	 echo 'Rp.'.' ,-';
								          	}else{
								          	 echo 'Rp. '. number_format($u['INVOICE_AMOUNT'],0,'.','.').',00-';
								          	};?>
								          	</td>
											<td class="po_amount">
											<?php if($u['PO_AMOUNT']==NULL) {
								          	 echo 'Rp.'.' ,-';
								          	}else{
								          	 echo 'Rp. '. number_format(round($u['PO_AMOUNT']),0,'.','.').',00-';
								          	};?>
								          	</td> -->
											<td><?php echo $u['PO_NUMBER']?></td>
											<td><b><?php echo $u['AKT_DATE']?></b></td>
											<td><b>KATEGORI : </b><?php echo $u['KATEGORI_INV_BERMASALAH']?> <br>
												<b>KELENGKAPAN DOKUMEN : </b><?php echo $u['KELENGKAPAN_DOC_INV_BERMASALAH']?> <br>
												<b>KETERANGAN : </b><?php echo $u['KETERANGAN_INV_BERMASALAH']?>	
											</td>
											<td><?php echo $u['SOURCE']?></td>
										</tr>
										<?php $no++; } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>	