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
							<span><b>Detail Batch <?php echo $detailLppb[0]['GROUP_BATCH']?></b></span>
							<input type="hidden" id="batch_number" name="batch_number" value="<?php echo $detailLppb[0]['BATCH_NUMBER']?>" >
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
									<div ><!-- //class="table-responsive text-nowrap" -->
											<table id="tblLPPBwew" style="width: 100%;" class="table table-bordered text-center">
												<thead> 
													<tr class="bg-primary">
														<td class="text-center">No</td>
														<td class="text-center">IO</td>
														<td class="text-center">Nomor LPPB</td>
														<td class="text-center" style="width:10%;">Vendor name</td>
														<td class="text-center">Tanggal LPPB</td>
														<td class="text-center">Nomor PO</td>
														<td class="text-center" style="width:20%;">Action</td>
														<td class="text-center" style="width:10%;">Tanggal Diterima/Ditolak</td>
														<td class="text-center" style="width:30%;">Alasan</td>
													</tr>
												</thead>
												<tbody>
													<?php $no=1; foreach($detailLppb as $p) { $removeDesable=''; if ($no==count($detailLppb)) { $removeDesable="$('#btnAkuntansii').removeAttr('disabled');"; } ?>
													<tr>
														<td>
															<?php echo $no ?>
														</td> 
														<td><?php echo $p['ORGANIZATION_CODE']?></td>
														<td><?php echo $p['LPPB_NUMBER']?></td>
														<td><?php echo $p['VENDOR_NAME']?></td>
														<td><?php echo $p['TANGGAL_LPPB']?></td>
														<td><?php echo $p['PO_NUMBER']?></td>
														<td data="<?= $p['BATCH_DETAIL_ID']?>">
															<?php if ($p['STATUS'] == 3 OR $p['STATUS'] == 6) { ?>
																<button class="btn btn-success" disabled="disabled">Approved</button>
															<?php }elseif ($p['STATUS'] == 4 OR $p['STATUS'] == 7) { ?>
																<button class="btn btn-danger" disabled="disabled">Rejected</button>
															<?php }else{ ?>
																<button id="btnAkt_<?php echo $p['BATCH_DETAIL_ID'] ?>" class="btn btn-primary" onclick="actionLppbNumber(this);<?php echo $removeDesable; ?>" value="6" name="proses" data-id="<?= $p['BATCH_DETAIL_ID']?>">OK</button>
																<button id="btnAkt_<?php echo $p['BATCH_DETAIL_ID'] ?>" class="btn btn-danger" onclick="actionLppbNumber(this);<?php echo $removeDesable; ?>" value="7" name="proses" data-id="<?= $p['BATCH_DETAIL_ID']?>">NOT OK</button>
															<?php } ?>
														</td>
														<td><span class="tglTerimaTolak"></span></td>
														<td><input id="txtTolak_<?php echo $p['BATCH_DETAIL_ID'] ?>" type="text" value="<?php echo $p['REASON']?>" style="display: none;width:200px;"  class="form-control txtAlasan" name="alasan_reject[]">
															<input type="hidden" name="id[]" value="<?php echo $p['BATCH_DETAIL_ID']?>"></td>
													</tr>
												<?php $no++; } ?>
											</tbody>
										</table>
									</div>
									<div class="col-md-2 pull-right">
										<!-- <a href="<?php echo base_url('MonitoringLppbAkuntansi/Unprocess/')?>">
										<button type="button" class="btn btn-primary" style="margin-top: 10px">Back</button>
										</a> -->
										<button id="btnAkuntansii" type="submit" disabled="disabled" name="submit_action" class="btn btn-primary pull-right" style="margin-top: 10px" >Save</button>
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
<script type="text/javascript">
	var id_gd;
	var txtTolak = "txtTolak_<?php echo $p['BATCH_DETAIL_ID']?>";

	$(document).ready(function(){
	$('#tblLPPBwew').DataTable({
		"paging":   false,
        "ordering": false,
        "info":     false
	})
})
</script>