<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
</style>

<form method="post" action="<?php echo base_url('MonitoringLPPB/ListBatch/saveLppbNumber') ?>">
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Add LPPB Number</b></span>
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
											<table id="filter" class="col-md-12" style="margin-bottom: 20px">
												<tr>
													<td>
														<span><label>LPPB Info</label></span>
													</td>
													<td>
														<textarea class="form-control" size="40" type="text" name="lppb_info" placeholder="LPPB Info"></textarea>
													</td>
												</tr>
												<tr>
													<td>
														<span class="text-center"><label>Nomor LPPB</label></span>
													</td>
												<td>
													<input name="lppb_number" id="lppb_number" class="form-control" style="width:100%;">
													</input>
													</td>
												<td>
													<div><button class="btn btn-md btn-success pull-left" type="button" id="btnSearchNomorLPPB">Add</button>
													</div>
												</td>
												</tr>
											</table>
										</div>
									</div>
								</div>
								<div>
									<table class="table table-bordered table-hover table-striped text-center">
										<thead>
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
										<tbody id="tabelNomorLPPB">

										</tbody>
									</table>
								</div>
								<div class="col-md-2 pull-right">
									<a href="<?php echo base_url('MonitoringLPPB/ListBatch')?>">
									<button type="button" id="" class="btn btn-danger" style="margin-top: 10px">Back</button>
									</a>
									<button id="" type="submit" name="batch_number" class="btn btn-success pull-right" style="margin-top: 10px" >Save</button>
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
