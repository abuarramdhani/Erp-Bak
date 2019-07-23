<div class="box box-primary box-solid">
 							<div class="box-body">

<form method="POST" action="<?php echo base_url('MonitoringLppbKasieGudang/Unprocess/saveActionLppbNumber')?>">
<input type="hidden" name="batch_number" value="<?php echo $lppb[0]['BATCH_NUMBER']?>">
<div class="box-body">
	<table class="col-md-12" style="margin-bottom: 20px">
		<tr>
			<td style="padding:0 0 0 10px">
			<span><b>Jumlah Data </b><span style="padding: 0 10px 0 20px">:</span><?php echo $jml[0]['JUMLAH_DATA']?></span>
 			</td>
 		</tr>

 		<tr>
			<td style="padding:0 0 0 10px">
			<span><b>Batch Number</b><span style="padding: 0 8px 0 12px">:</span><?php echo $lppb[0]['BATCH_NUMBER']?></span>
 			</td>
 		</tr>
</table>
</div>
 							
 <table class="table table-bordered table-hover text-center dtTableMl bakso">
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
														<td><?php echo $p['TANGGAL_LPPB']?></td>
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

														<!-- <td><input id="txtTolak_<?php echo $p['BATCH_DETAIL_ID'] ?>" type="text" value="<?php echo $p['REASON']?>" style="display: none;width: 100%;"  class="form-control txtAlasan" name="alasan_reject[]">
															<input type="hidden" name="id[]" value="<?php echo $p['BATCH_DETAIL_ID']?>"></td> -->

														<td class="batchdid_<?php echo $p['BATCH_DETAIL_ID']?>">
															<?php echo $p['REASON']?>
														<input type="text" value="<?php echo $p['REASON']?>" style="display: none; width: 100px" class="form-control txtAlasan" name="alasan_reject[]" id="txtTolak_<?php echo $p['BATCH_DETAIL_ID']?>">
															<input type="hidden" name="id[]" value="<?php echo $p['BATCH_DETAIL_ID']?>"></td>
													</tr>
												<?php $no++; } ?>
											</tbody>
										</table>
											<div class="col-md-3">
										<button type="button" class="btn btn-danger pull-left " value="4" style="margin-top: 10px" onclick="approveLppbByKasie(4);">Reject</button>
										<button type="button" class="btn btn-success pull-right " value="3" style="margin-top: 10px" onclick="approveLppbByKasie(3);">Approve</button>
										</table>
									</div>
									</div>
									<div class="col-md-2 pull-right">
										<!-- <a href="<?php echo base_url('MonitoringLppbKasieGudang/Unprocess/')?>">
										<button type="button" id="" class="btn btn-primary" style="margin-top: 10px">Back</button>
										</a> -->
										<button id="btnsavekasie" type="submit" name="submit_action" class="btn btn-primary pull-right" style="margin-top: 10px" >Save</button>
									</div>
								</div>
							</div>
						</div>
		</form>

<script type="text/javascript">
	$('.chkAllLppb').iCheck({
	  checkboxClass: 'icheckbox_square-blue',
	})
	$('.chkAllLppbNumber').iCheck({
	  checkboxClass: 'icheckbox_square-blue',
	})

	$(document).on('ifChanged', '.chkAllLppb', function(event) {
		if ($('.chkAllLppb').iCheck('update')[0].checked) {
			// alert('satu');
			$('.chkAllLppbNumber').each(function () {
				// $(this).prop('checked',true);
				$(this).iCheck('check');
			});
		}else{
			$('.chkAllLppbNumber').each(function () {
				// $(this).prop('checked',false);
				$(this).iCheck('uncheck');
			});
			// alert('dua');
		};
	})

	$('.dtTableMl.bakso').DataTable({
		"paging": false,
		"info":     true,
		"language" : {
			"zeroRecords": " "             
		}
	})


</script>