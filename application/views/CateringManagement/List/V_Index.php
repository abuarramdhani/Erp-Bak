<script src="<?php echo base_url('assets/js/ajaxSearch.js'); ?>"></script>

<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b>Catering Receipt</b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/List'); ?>">
									<i class="icon-wrench icon-2x"></i>
									<span><br /></span>
								</a>
							</div>
						</div>
					</div>
				</div>
				<br />

				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<a href="<?php echo site_url('CateringManagement/List/Create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New">
									<button type="button" class="btn btn-default btn-sm">
										<i class="icon-plus icon-2x"></i>
									</button>
								</a>
								<b>Catering List</b>
							</div>
							<div class="box-body">

								<div class="table-responsive" style="overflow:hidden;">
									<table class="table table-striped table-bordered table-hover text-left" id="dataTables-listCatering" style="font-size:14px;">
										<thead class="bg-primary">
											<tr>
												<th width="5%">NO</th>
												<th width="20%">CATERING NAME</th>
												<th width="10%">CODE</th>
												<th width="35%">ADDRESS</th>
												<th width="10%">PHONE</th>
												<th width="10%">PPH</th>
												<th width="10%">PPH VALUE</th>
												<th width="10%">ACTION</th>
											</tr>
										</thead>
										<tbody>
											<?php $no = 0;
											foreach ($Catering as $cl) {
												$no++;
												$pph_label = "<span class='badge bg-red'>Tidak</span>";
												if ($cl['catering_pph'] == 1) {
													$pph_label = "<span class='badge bg-blue'>Ya</span>";
												}
												?>

												<tr>
													<td><?php echo $no ?></td>
													<td><?php echo $cl['catering_name'] ?></td>
													<td><?php echo $cl['catering_code'] ?></td>
													<td><?php echo $cl['catering_address'] ?></td>
													<td align="right"><?php echo $cl['phone'] ?></td>
													<td align="center"><?php echo $pph_label ?></td>
													<td align="center"><?php echo $cl['pph_value'] ?>%</td>
													<td align="center">
														<a data-toggle="tooltip" title="Edit" href='<?php echo site_URL() ?>CateringManagement/List/Edit/<?php echo $cl['catering_id'] ?>' class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
														<a data-toggle="tooltip" title="Delete" href='<?php echo site_URL() ?>CateringManagement/List/Delete/<?php echo $cl['catering_id'] ?>' class="btn btn-danger btn-sm"><i class="fa fa-remove"></i></a>
													</td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>