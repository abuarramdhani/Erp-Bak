<style type="text/css">
 	#filter tr td{padding: 5px}
 	.text-left span {
 		font-size: 36px
 	}
 	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
 </style>
 <form method="post" action="<?php echo base_url('MonitoringLPPB/ListBatch/saveEditLppbNumber')?>" > 
 <section class="content">
 	<div class="inner" >
 		<div class="row">
 			<div class="col-lg-12">
 				<div class="row">
 					<div class="col-lg-12">
 						<div class="text-left ">
 							<span><b>Lppb Number Details</b></span>
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
 										<div class="col-md-6">
 											<table class="col-md-12" style="margin-bottom: 20px">
 												<tr>
 													<td>
 														<span><label>LPPB Info</label></span>
 													</td>
 													<td>
 														<input type="text" name="" class="form-control" size="40" value="<?php echo $detailLppb[0]['LPPB_INFO']?>">
 													</td>
 												</tr>
 												<tr>
 													<td>
 														<span class="text-center"><label>Nomor LPPB</label></span>
 													</td>
 												<td>
 													<input name="lppb_number" id="lppb_number" class="form-control" style="width:100%; margin-top: 10px">
 													</input>
 													</td>
 												<td>
 													<div><button class="btn btn-md btn-success pull-left" type="button" id="btnSearchNomorLPPB" style="margin-top: 10px; margin-left: 10px;">Add</button>
 													</div>
 												</td>
 												</tr>
 											</table>
 										</div>
 									</div>
 								</div>
 								<div class="col-md-12">
 									<div>
 											<table id="tabelNomorLPPB" class="table table-striped table-bordered table-hover text-center dataTable">
 												<thead style="vertical-align: middle;"> 
 													<tr class="bg-primary">
 														<td class="text-center">No</td>
 														<td class="text-center">Nomor LPPB</td>
 														<td class="text-center">Vendor name</td>
 														<td class="text-center">Tanggal LPPB</td>
 														<td class="text-center">Nomor PO</td>
 														<td class="text-center">Status Detail</td>
 														<td class="text-center">Action</td>
 													</tr>
 												</thead>
 												<tbody>
 													<?php $no=1; foreach($detailLppb as $p) { ?>
 													<tr>
 														<td>
 															<?php echo $no ?>
 														</td> 
 														<td><input type="text" class="form-control" value="<?php echo $p['LPPB_NUMBER']?>"></td>
 														<td><input type="text" class="form-control" name="" value="<?php echo $lppb[0]['VENDOR_NAME']?>"></td>
 														<td><input type="text" class="form-control" name="" value="<?php echo $lppb[0]['TANGGAL_LPPB']?>"></td>
 														<td><input type="text" class="form-control" name="" value="<?php echo $lppb[0]['PO_NUMBER']?>"></td>
 														<?php if($p['STATUS'] == 0){
 																$status = 'New/Draf';
 															}elseif ($p['STATUS'] == 1) {
 																$status = 'Admin Edit';
 															}elseif ($p['STATUS'] == 2) {
 																$status = 'Checking Kasie Gudang(Submit ke Kasie Gudang)';
 															}elseif ($p['STATUS'] == 3) {
 																$status = 'Kasie Gudang Approve';
 															}elseif ($p['STATUS'] == 4) {
 																$status = 'Kasie Gudang Reject';
 															}elseif ($p['STATUS'] == 5) {
 																$status = 'Checking Akuntansi (Sumbit ke Akuntansi)';
 															}elseif ($p['STATUS'] == 6) {
 																$status = 'Akuntansi Approve';
 															}elseif ($p['STATUS'] == 7) {
 																$status = 'Akuntansi Reject';
 															} ?>	
 														<td>
 															<input type="text" class="form-control" name="" value="<?php echo $status?>">
 														</td>
 														<td>
 															<a title="delete ..." rownum="<?php echo $no ?>" class="btn btn-danger" onclick="btnDeleteLppb(this);"><i class="fa fa-trash"></i>
 															<input type="hidden" name="batch_detail_id" class="batch_detail_id_<?php echo $no ?>" id="batch_detail_id" value="<?php echo $p['BATCH_DETAIL_ID']?>">
 															</a>
 														</td>
 													</tr>
 												<?php $no++; } ?>
 											</tbody>
 										</table>
 									</div>
 									<div class="col-md-2 pull-right">
 										<a href="<?php echo base_url('MonitoringLPPB/ListBatch')?>">
 										<button type="button" class="btn btn-primary" style="margin-top: 10px">Back</button>
 										</a>
 										<button id="save_lppb" type="" name="save_lppb" class="btn btn-success pull-right" style="margin-top: 10px" >Save</button>
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