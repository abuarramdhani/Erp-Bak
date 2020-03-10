<style type="text/css">
#filter tr td{padding: 5px}
.text-left span {
	font-size: 36px
}
#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
</style>
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Detail Batch <?php echo $detailLppb[0]['GROUP_BATCH']?></b></span>
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
											<span>Jumlah Data  : <b><?php echo $jml[0]['JUMLAH_DATA']?></b></span><br>
											<span>Batch Number : <b><?php echo $detailLppb[0]['BATCH_NUMBER']?></b></span>
											<div>
												<table id="tblFinishDetailAkt" class="table table-bordered table-hover text-center tblLPPBAkt">
													<thead style="vertical-align: middle;"> 
														<tr class="bg-primary">
															<td class="text-center">No</td>
															<td class="text-center">IO</td>
															<td class="text-center">Nomor LPPB</td>
															<td class="text-center">Vendor name</td>
															<td class="text-center">Tanggal LPPB</td>
															<td class="text-center">Nomor PO</td>
															<td class="text-center">Tanggal</td>
															<td class="text-center">Status Detail</td>
														</tr>
													</thead>
													<tbody>
														<?php $no=1; foreach($detailLppb as $p) { ?>
															<tr>
																<td>
																	<?php echo $no ?>
																</td> 
																<td><?php echo $p['ORGANIZATION_CODE']?></td>
																<td><?php echo $p['LPPB_NUMBER']?></td>
																<td><?php echo $p['VENDOR_NAME']?></td>
																<td><?php echo $p['TANGGAL_LPPB']?></td>
																<td><?php echo $p['PO_NUMBER']?></td>
																<td><?php echo $p['STATUS_DATE']?></td>
																<?php if ($p['STATUS'] == 3) {
																	$status = '<span class="label label-primary">Kasie Gudang Approve &nbsp;<br></span>';
																}elseif ($p['STATUS'] == 6) {
																	$status = '<span class="label label-success">Akuntansi Approve &nbsp;<br></span>';
																}?>	
																<td><?php echo $status; ?></td>
															</tr>
															<?php $no++; } ?>
														</tbody>
													</table>
												</div>
												<div class="col-md-2 pull-right">
													<!-- <a href="<?php echo base_url('MonitoringLppbAkuntansi/Finish/')?>">
														<button type="button" id="" class="btn btn-primary pull-right" style="margin-top: 10px">Back</button>
													</a> -->
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
<script type="text/javascript">
	var id_gd;
	$('#tblFinishDetailAkt').DataTable({
		"paging": true,
		"info":     true,
		"language" : {
			"zeroRecords": " "             
		}
	})
</script>