<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11"></div>
						<div class="col-lg-1"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-solid box-primary" style="border-radius: 0px">
							<div class="box-header with-border text-right">
								<button type="button" id="spl-fingertemp-modal-add-user-triger" class="btn btn-primary" style="border: 2px solid white;border-radius: 0px" title="Add Fingerprint"><span class="fa fa-plus"></span></button>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-primary table-bordered table-hover">
											<thead class="bg-primary">
												<tr>
													<th>No</th>
													<th>No Induk</th>
													<th>No Induk Baru</th>
													<th>Nama</th>
													<th>Jumlah Finger</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody id = 'spl-fingertemp'>
												<?php $number = 1; foreach ($fingertemp as $temp) {
													?>
													<tr>
														<td><?php echo $number; ?></td>
														<td><?php echo $temp['noind'] ?></td>
														<td><?php echo $temp['noind_baru'];?></td>
														<td><?php echo $temp['nama'];?></td>
														<td><?php echo $temp['jumlah'];?></td>
														<td>
															<button class="btn btn-warning spl-fingertemp-modal-add-temp-triger" data-id="<?php echo $temp['noind'];?>" style="border-radius: 0px">
																Finger
															</button>
															<button class="btn btn-danger spl-fingertemp-delete" data-id="<?php echo $temp['noind'];?>" style="border-radius: 0px">
																Delete
															</button>
														</td>
													</tr>
													<?php
													$number++;
												} ?>
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
	</div>
</section>

<div class="modal" tabindex="-1" role="dialog" area-hidden="true" id="spl-fingertemp-modal-finger">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #F1C40F;">
				<label>Tambah Template Finger</label>
				<button class="btn btn-danger spl-fingertemp-modal-finger-close" style="float: right;border-radius: 0px">
					<span class="glyphicon glyphicon-remove"></span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-primary table-bordered table-hover">
							<thead style="background-color: #F1C40F;">
								<tr>
									<th>ID</th>
									<th>Jari</th>
									<th>Template</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<!-- ajax -->
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer" style="background-color: #F1C40F;">
				<button type="button" class="btn btn-danger spl-fingertemp-modal-finger-close" style="border-radius: 0px">Batal</button>
			</div>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" area-hidden="true" id="spl-fingertemp-modal-user">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #F1C40F;">
				<label>Tambah Pekerja</label>
				<button class="btn btn-danger spl-fingertemp-modal-user-close" style="float: right;border-radius: 0px">
					<span class="glyphicon glyphicon-remove"></span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12">
						<form class="form-horizontal">
							<div class="form-group">
								<label class="control-label col-lg-4">No Induk</label>
								<div class="col-lg-8">
									<select style="width: 100%" class="spl-fingertemp-modal-select-noind"></select>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer" style="background-color: #F1C40F;">
				<button type="button" class="btn btn-primary spl-fingertemp-modal-user-add" style="border-radius: 0px">Tambah</button>
				<button type="button" class="btn btn-danger spl-fingertemp-modal-user-close" style="border-radius: 0px">Batal</button>
			</div>
		</div>
	</div>
</div>