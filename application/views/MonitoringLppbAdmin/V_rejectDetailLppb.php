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
							<span><b>Lppb Number Reject <?php echo $lppb[0]['GROUP_BATCH']?></b></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<div class="box box-primary box-solid">
									<div class="box-body">
										<div class="col-md-6">
											<table class="col-md-12" style="margin-bottom: 20px">
												<tr>
													<td>
														<span><label>LPPB Info</label></span>
													</td>
													<td>
														<input type="text" name="lppb_info" class="form-control" style="width:100%;margin-bottom: 10px" value="<?php echo $lppb[0]['LPPB_INFO']?>" readonly >
													</td>
												</tr>
												<tr>
													<td>
														<span><label>Gudang</label></span>
													</td>
													<td>
														<input type="text" name="" value="<?php echo $lppb[0]['SOURCE']?>" class="form-control" style="width:100%;margin-bottom: 10px" readonly >
													</td>
												</tr>
											</table>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<span>Jumlah Data : <b><?php echo $jml[0]['JUMLAH_DATA']?></b></span>
									<div>
										<div class="col-md-6 pull-left">
											<button type="button" id="deleteAllRows" class="btn btn-danger" value="<?php echo $lppb[0]['BATCH_NUMBER']?>">Delete All</button>
										</div>
										<table id="tabelNomorLPPB" class="table table-bordered table-hover text-center dtTableMl">
											<thead style="vertical-align: middle;"> 
												<tr class="bg-primary">
													<td class="text-center">No</td>
													<td class="text-center">IO</td>
													<td class="text-center">Nomor LPPB</td>
													<td class="text-center">Vendor name</td>
													<td class="text-center">Tanggal LPPB</td>
													<td class="text-center">Nomor PO</td>
													<td class="text-center">Status Detail</td>
													<td class="text-center">Alasan Reject</td>
													<td class="text-center">Action</td>
												</tr>
											</thead>
											<tbody>
												<?php $no=1; foreach($lppb as $key => $p) { ?>
													<tr class="deleteAll">
														<td>
															<?php echo $no ?>
														</td> 
														<td><?php echo $p['ORGANIZATION_CODE']?></td>
														<td><?php echo $p['LPPB_NUMBER']?></td>
														<td><?php echo $p['VENDOR_NAME']?></td>
														<td><?php echo $p['TANGGAL_LPPB']?></td>
														<td><?php echo $p['PO_NUMBER']?></td>
														<?php if($p['STATUS'] == 0){
															$status = '<span class="label label-default">New/Draf &nbsp;<br></span>';
														}elseif ($p['STATUS'] == 1) {
															$status = '<span class="label label-warning">Admin Edit &nbsp;<br></span>';
														}elseif ($p['STATUS'] == 2) {
															$status = '<span class="label label-info">Checking Kasie Gudang(Submit ke Kasie Gudang) &nbsp;<br></span>';
														}elseif ($p['STATUS'] == 3) {
															$status = '<span class="label label-primary">Kasie Gudang Approve &nbsp;<br></span>';
														}elseif ($p['STATUS'] == 4) {
															$status = '<span class="label label-danger">Kasie Gudang Reject &nbsp;<br></span>';
														}elseif ($p['STATUS'] == 5) {
															$status = '<span class="label label-info">Checking Akuntansi (submit ke Akuntansi) &nbsp;<br></span>';
														}elseif ($p['STATUS'] == 6) {
															$status = '<span class="label label-success">Akuntansi Approve &nbsp;<br></span>';
														}elseif ($p['STATUS'] == 7) {
															$status = '<span class="label label-danger">Akuntansi Reject &nbsp;<br></span>';
														} ?>		
														<td>
															<?php echo $status?>
														</td>
														<td>
															<?php echo $p['REASON']?>
														</td>
														<td>
															<?php if ($p['STATUS'] == 4 or $p['STATUS'] ==7 ) { ?>
																<a title="delete ..." rownum="<?php echo $key ?>" class="btn btn-danger" onclick="btnDeleteLppb($(this));"><i class="fa fa-trash"></i>
																	<input type="hidden" name="batch_detail_id[$key]" class="batch_detail_id_<?php echo $key ?>" id="batch_detail_id" value="<?php echo $p['BATCH_DETAIL_ID']?>">
																</a>
															<?php }else{ ?>
																<a title="delete ..." style="display: none" rownum="<?php echo $key ?>" class="btn btn-danger" onclick="btnDeleteLppb(this);"><i class="fa fa-trash"></i>
																	<input type="hidden" name="batch_detail_id[$key]" class="batch_detail_id_<?php echo $key ?>" id="batch_detail_id" value="<?php echo $p['BATCH_DETAIL_ID']?>">
																</a>
														</td>
													<?php } ?>
													</tr>
													<?php $no++; } ?>
												</tbody>
											</table>
										</div>
										<div class="col-md-2 pull-right">
											<a href="<?php echo base_url('MonitoringLPPB/RejectLppb')?>">
												<button type="button" class="btn btn-primary pull-right" style="margin-top: 10px">Back</button>
											</a>
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
</script>
