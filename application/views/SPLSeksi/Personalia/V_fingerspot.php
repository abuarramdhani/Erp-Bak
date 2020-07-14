<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<h3><b><?= $Menu; ?></b></h3>
						</div>
						<div class="col-lg-1"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-solid box-primary" style="border-radius: 0px">
							<div class="box-header with-border text-right">
								<button type="button" id="spl-fingerprint-modal-add-triger" class="btn btn-primary" style="border: 2px solid white;border-radius: 0px" title="Add Fingerprint"><span class="fa fa-plus"></span></button>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-primary table-bordered table-hover">
											<thead class="bg-primary">
												<tr>
													<th>No</th>
													<th>Serial Number</th>
													<th>Verification Code</th>
													<th>Activation Code</th>
													<th>Verification Code</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody id='spl-fingerspot'>
												<?php $number = 1;
												foreach ($fingerprint as $finger) :
												?>
													<tr>
														<td><?php echo $number; ?></td>
														<td class='d-sn'><?php echo $finger['SN'] ?></td>
														<td class='d-vc'><?php echo $finger['Verification_Code']; ?></td>
														<td class='d-ac'><?php echo $finger['Activation_Code']; ?></td>
														<td class='d-vkey'><?php echo $finger['VKEY']; ?></td>
														<td>
															<button class="btn btn-warning spl-fingerprint-modal-edit-triger" data-id="<?php echo $finger['ID_']; ?>" style="border-radius: 0px">
																Edit
															</button>
															<button class="btn btn-danger spl-fingerprint-delete" data-id="<?php echo $finger['ID_']; ?>" style="border-radius: 0px">
																Delete
															</button>
														</td>
													</tr>
												<?php
													$number++;
												endforeach ?>
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

<div class="modal" tabindex="-1" role="dialog" area-hidden="true" id="spl-fingerprint-modal-edit">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #F1C40F;">
				<label>Update Fingerspot</label>
				<button class="btn btn-danger spl-fingerprint-modal-edit-close" style="float: right;border-radius: 0px">
					<span class="glyphicon glyphicon-remove"></span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12">
						<form class="form">
							<div class="form-group">
								<label class="form-label">Id tcode_fingerprint</label>
								<input class="form-control" type="text" id="spl-fingerprint-modal-edit-id" disabled>
							</div>
							<div class="form-group">
								<label class="form-label">Serial Number</label>
								<input class="form-control" type="text" id="spl-fingerprint-modal-edit-sn">
							</div>
							<div class="form-group">
								<label class="form-label">Verification Code</label>
								<input class="form-control" type="text" id="spl-fingerprint-modal-edit-vc">
							</div>
							<div class="form-group">
								<label class="form-label">Activation Code</label>
								<input class="form-control" type="text" id="spl-fingerprint-modal-edit-ac">
							</div>
							<div class="form-group">
								<label class="form-label">Verification Key</label>
								<input class="form-control" type="text" id="spl-fingerprint-modal-edit-vkey">
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer" style="background-color: #F1C40F;">
				<button type="button" class="btn btn-primary" id="spl-fingerprint-modal-edit-update" style="border-radius: 0px">Update</button>
				<button type="button" class="btn btn-danger spl-fingerprint-modal-edit-close" style="border-radius: 0px">Batal</button>
			</div>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" area-hidden="true" id="spl-fingerprint-modal-add">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #2ECC71;">
				<label>Tambahkan Fingerspot</label>
				<button class="btn btn-danger spl-fingerprint-modal-add-close" style="float: right;border-radius: 0px">
					<span class="glyphicon glyphicon-remove"></span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12">
						<form class="form">
							<div class="form-group">
								<label class="form-label">Serial Number</label>
								<input class="form-control" type="text" id="spl-fingerprint-modal-add-sn">
							</div>
							<div class="form-group">
								<label class="form-label">Verification Code</label>
								<input class="form-control" type="text" id="spl-fingerprint-modal-add-vc">
							</div>
							<div class="form-group">
								<label class="form-label">Activation Code</label>
								<input class="form-control" type="text" id="spl-fingerprint-modal-add-ac">
							</div>
							<div class="form-group">
								<label class="form-label">Verification Key</label>
								<input class="form-control" type="text" id="spl-fingerprint-modal-add-vkey">
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer" style="background-color: #2ECC71;">
				<button type="button" class="btn btn-primary" id="spl-fingerprint-modal-add-save" style="border-radius: 0px">Tambah</button>
				<button type="button" class="btn btn-danger spl-fingerprint-modal-add-close" style="border-radius: 0px">Batal</button>
			</div>
		</div>
	</div>
</div>