<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
</style>
<form method="POST" action="<?php echo base_url('MonitoringLppbAkuntansi/Unprocess/saveActionLppbNumber')?>">
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Detail Batch <?php echo $detailLppb[0]['BATCH_NUMBER']?></b></span>
							<input type="hidden" name="batch_number" value="<?php echo $detailLppb[0]['BATCH_NUMBER']?>">
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<div class="col-md-12">
									<div>
											<table id="" class="table table-striped table-bordered table-hover text-center dataTable">
												<thead style="vertical-align: middle;"> 
													<tr class="bg-primary">
														<td class="text-center">No</td>
														<td class="text-center">Nomor LPPB</td>
														<td class="text-center">Vendor name</td>
														<td class="text-center">Tanggal LPPB</td>
														<td class="text-center">Nomor PO</td>
														<td class="text-center" title="Kode Barang - Nama Barang | xx Ok | xx Reject | xx Repair" >Status LPPB</td>
														<td class="text-center">Action</td>
														<td class="text-center">Alasan</td>
													</tr>
												</thead>
												<tbody>
													<?php $no=1; foreach($detailLppb as $p) { ?>
													<tr>
														<td>
															<?php echo $no ?>
														</td> 
														<td><?php echo $p['LPPB_NUMBER']?></td>
														<td><?php echo $lppb[0]['VENDOR_NAME']?></td>
														<td><?php echo $lppb[0]['TANGGAL_LPPB']?></td>
														<td><?php echo $lppb[0]['PO_NUMBER']?></td>
														<td><?php echo $lppb[0]['KODE_BARANG'].' -- '.$lppb[0]['NAMA_BARANG']?></td>
														<td>
															<button class="btn btn-primary" onclick="actionLppbNumber(this)" value="6" name="proses" data-id="<?= $p['BATCH_DETAIL_ID']?>">Ok</button>
															<button class="btn btn-danger" onclick="actionLppbNumber(this)" value="7" name="proses" data-id="<?= $p['BATCH_DETAIL_ID']?>">Not Ok</button>
														</td>
														<td><?php echo $p['REASON']?><input type="text" value="<?php echo $p['REASON']?>" style="display: none;" class="form-control txtAlasan" name="alasan_reject[]">
															<input type="hidden" name="id[]" value="<?php echo $p['BATCH_DETAIL_ID']?>"></td>
													</tr>
												<?php $no++; } ?>
											</tbody>
										</table>
									</div>
									<div class="col-md-2 pull-right">
										<a href="<?php echo base_url('MonitoringLppbAkuntansi/Unprocess/')?>">
										<button type="button" id="" class="btn btn-danger" style="margin-top: 10px">Back</button>
										</a>
										<button id="" type="submit" name="submit_action" class="btn btn-success pull-right" style="margin-top: 10px" >Save</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
</form>