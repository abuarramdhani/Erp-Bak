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
							<span><b>Unprocessed Invoice</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<!-- <div style="overflow: auto;"> -->
								<table id="tbListBatchPembelian" class="table table-striped table-bordered table-hover text-center dataTable">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center">Vendor Name</th>
											<th class="text-center">Invoice Number</th>
											<th class="text-center">Invoice Date</th>
											<th class="text-center">Tax Invoice Number</th>
											<th class="text-center">Invoice Amount</th>
											<th class="text-center">Po Amount</th>
											<th class="text-center">Purchasing Submit Date</th>
											<th class="text-center">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach($unprocess as $u){?>
										<tr>
											<td><?php echo $no ?></td>
											<td><?php echo $u['vendor_name']?></td>
											<td><a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Unprocess/DetailUnprocess/'.$u['invoice_id']);?>">
												<?php echo $u['invoice_number']?>
											</a></td>
											<td><?php echo date('d-M-Y',strtotime($u['invoice_date']))?></td>
											<td><?php echo $u['tax_invoice_number']?></td>
											<td class="inv_amount"><?php echo $u['invoice_amount']?></td>
											<td class="po_amount"><?php echo $u['po_amount']?></td>
											<td><?php echo $u['last_status_purchasing_date']?></td>
											<td>
												<button type="submit" data-id="<?= $u['invoice_id'] ?>" onclick="prosesInvMI(this)" class="btn btn-primary" value="2" name="proses">Process</button>
											</td>
										</tr>
										<?php $no++; } ?>
									</tbody>
								</table>
								<!-- </div> -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
