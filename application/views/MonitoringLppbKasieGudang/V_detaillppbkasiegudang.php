<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
</style>
<form method="POST" action="<?php echo base_url('MonitoringLppbKasieGudang/Unprocess/saveActionLppbNumber')?>">
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Detail Batch </b></span>
							<input type="hidden" name="batch_number" value="<?php echo $lppb[0]['BATCH_NUMBER']?>">
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
									<span>Jumlah Data : <b><?php echo $jml[0]['JUMLAH_DATA']?></b></span>
									<div>
											<table class="table table-bordered table-hover text-center dtTableMl">
												<thead style="vertical-align: middle;"> 
													<tr class="bg-primary">
														<td class="text-center">No</td>
														<td class="text-center"><input type="checkbox" class="chkAllLppb"></td>
														<td class="text-center">IO</td>
														<td class="text-center">Nomor LPPB</td>
														<td class="text-center">Vendor name</td>
														<td class="text-center">Tanggal LPPB</td>
														<td class="text-center">Nomor PO</td>
														<td class="text-center">Action</td>
														<td class="text-center">Tanggal</td>
														<td class="text-center">Alasan</td>
													</tr>
												</thead>
												<tbody>
													<?php $no=1; foreach($lppb as $key => $p) {  
														// $removedisable=''; if ($no==count($lppb)) { 
														// 	$removedisable="$('#btnsavekasie').removeAttr('disabled');"; } 
														?>
													<tr <?=  $p['BATCH_DETAIL_ID']?>>
														<td>
															<?php echo $no ?>
														</td> 
														<td><input type="checkbox" class="checkbox chkAllLppbNumber" value="<?php echo $p['BATCH_DETAIL_ID']?>" name="check-id[]"></td>
														<td><?php echo $p['ORGANIZATION_CODE']?></td>
														<td><?php echo $p['LPPB_NUMBER']?></td>
														<td><?php echo $p['VENDOR_NAME']?></td>
														<!-- <td>
															<?php if ($p['STATUS'] == 3 OR $p['STATUS'] == 6) { ?>
																<button class="btn btn-success" disabled="disabled">Approved</button>
															<?php }elseif ($p['STATUS'] == 4 or $p['STATUS'] == 7) { ?>
																<button class="btn btn-danger" disabled="disabled">Rejected</button>
															<?php }else{ ?>
															<button class="btn btn-primary" onclick="actionLppbKasieGudang(this);<?php echo $removedisable; ?>" value="3" name="proses" data-id="<?= $p['BATCH_DETAIL_ID']?>">Ok</button>
															<button class="btn btn-danger" onclick="actionLppbKasieGudang(this);<?php echo $removedisable; ?>" value="4" name="proses" data-id="<?= $p['BATCH_DETAIL_ID']?>">Not Ok</button>
															<?php } ?>
														</td> -->
														<td><?php echo $p['TANGGAL_LPPB']?><?php echo $p['BATCH_DETAIL_ID']?></td>
														<td class="no_po"><?php echo $p['PO_NUMBER']?></td>
														<td class="batchdid_<?php echo $p['BATCH_DETAIL_ID']?>">
															<?php if ($p['STATUS'] == 3 OR $p['STATUS'] == 6) { ?>
																<span class="btn btn-success" style="cursor: none">Approved</span>
															<?php }else if($p['STATUS'] == 4 or $p['STATUS'] == 7){ ?>
																<span class="btn btn-danger" style="cursor: none">Rejected</span>
															<?php }else{ ?>
																<span class="btnApproveReject"></span>
															<?php } ?>
														</td>
														<td class="batchdid_<?php echo $p['BATCH_DETAIL_ID']?>"><span class="tglTerimaTolak"></span></td>
														<td class="batchdid_<?php echo $p['BATCH_DETAIL_ID']?>"><?php echo $p['REASON']?><input type="text" value="<?php echo $p['REASON']?>" style="display: none; width: 100px" class="form-control txtAlasan" name="alasan_reject[]" id="txtTolak_<?php echo $p['BATCH_DETAIL_ID']?>">
															<input type="hidden" name="id[]" value="<?php echo $p['BATCH_DETAIL_ID']?>"></td>
													</tr>
												<?php $no++; } ?>
											</tbody>
										</table>
									</div>
									<div class="col-md-2 pull-left">
										<button type="button" class="btn btn-primary" value="3" style="margin-top: 10px" onclick="approveLppbByKasie($(this));">Approve</button>
										<button type="button" class="btn btn-primary pull-right" value="4" style="margin-top: 10px" onclick="approveLppbByKasie($(this));">Reject</button>
									</div>
									<div class="col-md-2 pull-right">
										<a href="<?php echo base_url('MonitoringLppbKasieGudang/Unprocess/')?>">
										<button type="button" id="" class="btn btn-primary" style="margin-top: 10px">Back</button>
										</a>
										<button id="btnsavekasie" type="submit" name="submit_action" class="btn btn-primary pull-right" style="margin-top: 10px" >Save</button>
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
</script>