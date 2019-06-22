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
								<span ><b>Lppb Number Details</b></span>
								<input name="batch_number" id="batch_number" value="<?php echo $lppb[0]['BATCH_NUMBER']?>">
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
												<table class="col-md-12" style="margin-bottom: 20px">
													<?php if ($lppb[0]['STATUS'] == 0 OR $lppb[0]['STATUS'] == 1) { ?>
														<tr>
															<td>
																<span><label>LPPB Info</label></span>
															</td>
															<td>
																<input type="text" name="" value="<?php echo $lppb[0]['LPPB_INFO']?>" class="form-control" style="width:100%;margin-bottom: 10px" readonly >
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
														<tr>
															<td>
																<span><label>IO</label></span>
															</td>
															<td>
																<select id="inventory" name="inventory" class="form-control select2 select2-hidden-accessible" style="width:100%;">
																	<!-- ngeluarin data dari option pake foreach -->
																	<option value="" > Inventory Organization </option>
																	<?php foreach ($inventory as $io) { 
																		$s='';
																		if ($io['ORGANIZATION_ID']==$lppb[0]['ORGANIZATION_ID']) {
																			$s='selected';
																		}
																		?>
																		<option value="<?php echo $io['ORGANIZATION_ID'] ?>" <?php echo $s ?>>
																			<?php echo $io['ORGANIZATION_CODE'] ?></option>
																	<?php } ?>
																</select>
															</td>
														</tr>
														<tr>
															<td>
																<span class="text-center"><label>Nomor LPPB</label></span>
															</td>
															<td>
																<input name="lppb_numberFrom" id="lppb_numberFrom" class="form-control" style="width:100%; margin-top: 10px">
															</input>
														</td>
														<td>
															<span> &nbsp; s/d &nbsp;</span>
														</td>
														<td>
															<input name="lppb_number" id="lppb_number" class="form-control" style="width:100%; margin-top: 10px">
														</input>
													</td>
													<td>
														<div><button class="btn btn-md btn-success pull-left" type="button" onclick="searchLppb($(this))" style="margin-top: 10px; margin-left: 10px;">Add</button>
														</div>
													</td>
												</tr>
											<?php }else{?>
												<tr>
													<td>
														<span><label>LPPB Info</label></span>
													</td>
													<td>
														<?php echo $lppb[0]['LPPB_INFO']?>
													</td>
												</tr>
												<tr>
													<td>
														<span class="text-center"><label>Nomor LPPB</label></span>
													</td>
													<td>
														<input name="lppb_number" id="lppb_number" class="form-control" style="width:100%; margin-top: 10px" disabled="disabled">
													</input>
												</td>
												<td>
													<div><button class="btn btn-md btn-success pull-left" type="button" style="margin-top: 10px; margin-left: 10px;" disabled="disabled" >Add</button>
													</div>
												</td>
											</tr>
										<?php } ?>
									</table>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="box-body">
								<div id="loading_search">

								</div>
							</div>
							<span>Jumlah Data : <b><?php echo $jml[0]['JUMLAH_DATA']?></b></span>
							<div>
								<table class="table text-center dtTableMl">
									<thead style="vertical-align: middle;"> 
										<tr class="bg-primary">
											<td class="text-center">No</td>
											<td class="text-center">IO</td>
											<td class="text-center">Action Date</td>
											<td class="text-center">Nomor LPPB</td>
											<td class="text-center">Vendor name</td>
											<td class="text-center">Tanggal LPPB</td>
											<td class="text-center">Nomor PO</td>
											<td class="text-center">Status Detail</td>
											<td class="text-center">Action</td>
										</tr>
									</thead>
									<tbody id="tabelNomorLPPB">
										<?php $no=1; foreach($lppb as $key => $p) { ?>
											<tr class="lppb_id" id="<?php echo $no; ?>">
												<td><?php echo $no ?></td>
												<td><?php echo $p['ORGANIZATION_CODE']?></td>
												<td><?php echo $p['ACTION_DATE']?></td>
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
													$status = '<span class="label label-info">Checking Akuntansi (Sumbit ke Akuntansi) &nbsp;<br></span>';
												}elseif ($p['STATUS'] == 6) {
													$status = '<span class="label label-success">Akuntansi Approve &nbsp;<br></span>';
												}elseif ($p['STATUS'] == 7) {
													$status = '<span class="label label-danger">Akuntansi Reject &nbsp;<br></span>';
												} ?>	
												<td>
													<?php echo $status;?>
												</td>
												<td>
													<?php if ($p['STATUS'] == 0 OR $p['STATUS'] == 4 OR $p['STATUS'] == 7) { ?>
														<a title="delete ..." rownum="<?php echo $no ?>" class="btn btn-danger" onclick="btnDeleteLppb($(this));"><i class="fa fa-trash"></i>
															<input type="hidden" name="batch_detail_id" class="batch_detail_id_<?php echo $no ?>" id="batch_detail_id" value="<?php echo $p['BATCH_DETAIL_ID']?>">
														</a>
													<?php }else{ ?>
														<a title="delete ..." style="display: none" rownum="<?php echo $no ?>" class="btn btn-danger" onclick="btnDeleteLppb($(this));" disabled="disabled"><i class="fa fa-trash"></i>
															<input type="hidden" name="batch_detail_id" class="batch_detail_id_<?php echo $no ?>" id="batch_detail_id" value="<?php echo $p['BATCH_DETAIL_ID']?>">
														</a>
													<?php } ?>
												</td>
											</tr>
											<?php $no++; } ?>
										</tbody>
									</table>
								</div>
								<div class="col-md-2 pull-right">
									<?php if ($lppb[0]['STATUS'] == 0 OR $lppb[0]['STATUS'] == 1) { ?>
										<a href="<?php echo base_url('MonitoringLPPB/NewDrafLppb')?>">
											<button type="button" class="btn btn-primary" style="margin-top: 10px">Back</button>
										</a>
										<button id="save_lppb" type="" name="save_lppb" onclick="saveEditLPPBNumber($(this))" class="btn btn-success pull-right" style="margin-top: 10px;">Save</button>
									<?php }else{ ?>
										<a href="<?php echo base_url('MonitoringLPPB/NewDrafLppb')?>">
											<button type="button" class="btn btn-primary pull-right" style="margin-top: 10px">Back</button>
										</a>
										<button id="save_lppb" type="" name="save_lppb" class="btn btn-primary pull-right" style="margin-top: 10px; display: none">Save</button>
									<?php } ?>
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
	var batch_number = <?php echo $lppb[0]['BATCH_NUMBER']?>;
</script>