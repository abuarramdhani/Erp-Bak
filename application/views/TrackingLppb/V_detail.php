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
							<span><b>Lppb Details</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<div class="row">
								<div class="col-md-6">
								<table id="" >
									<tr>
										<td>
											<span><label>Lppb Info</label></span>
										</td>
										<td>
		                     				<input class="form-control" size="40" style="margin-bottom: 10px" type="text" name="" value="<?php echo $lppb[0]['LPPB_INFO']?>" readonly>
		                     			</td>
									</tr>
									<tr>
										<td>
											<span><label>Gudang</label></span>
										</td>
										<td>
											<input  class="form-control" size="40" style="margin-bottom: 10px" type="text" name="" value="<?php echo $lppb[0]['SOURCE']?>" readonly>
										</td>
									</tr>
									<!-- <span><?php echo $lppb[0]['BATCH_DETAIL_ID'] ?></span> -->
								</table>
								</div><!-- <div class="col-md-6">
								<span><label>Lppb History</label></span><br>
								<table id="tbHistoryInvoice" class="table table-striped table-bordered table-hover text-center" >
								<thead style="vertical-align: middle;"> 
									<tr class="bg-primary">
										<th class="text-center">No</th>
										<th class="text-center">Action Date</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
								<?php $no=1; foreach($historylppb as $hl) { ?>
									<tr>
										<td><?php echo $no?></td>
										<td><?php echo $hl['ACTION_DATE']?></td>
										<td><?php echo $hl['STATUS']?></td>
									</tr>
									<?php $no++;} ?>
								</tbody>												
								</table>
								</div> -->
								</div>
						<div class="box box-primary box-solid">
							<div class="box-body">
								<div class="col-md-12">
									<div>
											<table id="" class="table table-striped table-bordered table-hover text-center dtTableMl">
												<thead style="vertical-align: middle;"> 
													<tr class="bg-primary">
														<th class="text-center">No</th>
														<th class="text-center">IO</th>
														<th class="text-center">LPPB Number</th>
														<th class="text-center">Vendor Name</th>
														<th class="text-center">Create Date</th>
														<th class="text-center">PO Number</th>
														<th class="text-center">Source</th>
														<th class="text-center">Gudang</th>
														<th class="text-center" title="Kode Barang - Deskripsi Barang">Gudang Detail</th>
													</tr>
												</thead>
												<tbody>
													<?php $no=1; foreach($lppb as $lp) { ?>
													<tr>
														<td>
															<?php echo $no ?>
														</td> 
														<td><?php echo $lp['ORGANIZATION_CODE']?></td>
														<td><?php echo $lp['LPPB_NUMBER']?></td>
														<td><?php echo $lp['VENDOR_NAME']?></td>
														<td><?php echo $lp['CREATE_DATE']?></td>
														<td><?php echo $lp['PO_NUMBER']?></td>
														<td><?php echo $lp['SOURCE']?></td>
														<td><?php echo $lp['SECTION_NAME']?></td>
														<td><?php echo $lp['GUDANG_CODE'].'  -  '. $lp['GUDANG_DESCRIPTION']?></td>
													</tr>
												<?php $no++; } ?>
											</tbody>
										</table>
									</div>
									<div class="col-md-4 pull-left">
										<!-- <a href="<?php echo base_url('TrackingLppb')?>">
											<button class="btn btn-primary">Back</button>
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
</script>