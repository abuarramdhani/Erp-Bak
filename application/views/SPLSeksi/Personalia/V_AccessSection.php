<style media="screen">
	thead > tr > th, tbody > tr > td {
		text-align: center;
	}
</style>
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
								<button type="button" data-target="#modaladd" onclick="clearModalTable()" data-toggle="modal" class="btn btn-primary" style="border: 2px solid white;border-radius: 0px" title="Add Access"><span class="fa fa-plus"></span></button>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-primary table-bordered table-hover" id="tabel-access-section">
											<thead class="bg-primary">
												<tr>
													<th>No</th>
													<th>No Induk</th>
													<th>Nama</th>
													<th>Seksi</th>
													<th>Jumlah Akses</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>

												<?php $no=1;
													foreach ($all_access as $key): ?>
													<tr>
														<td><?= $no++ ?></td>
														<td><?= $key['noind'] ?></td>
														<td><?= $key['nama'] ?></td>
														<td><?= $key['seksi'] ?></td>
														<td><?php $data = explode('|', $key['nama_seksi']); echo count($data) ?></td>
														<td><button data-noind="<?= $key['noind'] ?>" data-nama="<?= $key['nama'] ?>" class="btn btn-success btn-md edit-access-section" onclick="btnEditListener($(this))" data-target="#modaladd" data-toggle="modal"><i class="fa fa-edit"></i></button></td>
													</tr>
												<?php endforeach; ?>
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

<div class="modal" role="dialog" area-hidden="true" id="modaladd">
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="border-radius: 10px;">
			<div class="modal-header bg-primary">
				<label>Tambah Akses Seksi</label>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12">
						<div class="form-group col-lg-12">
							<label>Pekerja</label>
							<select class="form-control select2 lembur-personalia-pekerja" style="width: 100%;">

							</select>
						</div>
						<div class="form-group col-lg-12">
							<label>Seksi</label>
							<select class="form-control select2 lembur-personalia-seksi" style="width: 100%;">
								<!-- ajax -->
							</select>
						</div>
						<div class="form-group col-lg-12 text-right">
							<small style="float: left; color: red;">*isian untuk menambah seksi</small>
							<button type="button" class="btn btn-primary btn-sm" id="btnAddRowAccessSection" style="border-radius: 50% !important;" name="button"><i class="fa fa-plus"></i></button>
						</div>
						<table class="table" id="overtime_table_access_section">
							<thead>
								<tr>
									<th>No</th>
									<th>Kodesie</th>
									<th>Dept/Bidang/Unit/Seksi</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<!-- this is form js -->
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer" style="background-color: #3c8dbc;">
				<button type="button" style="float: left; display: none" class="btn btn-danger" onclick="btnDeleteAccessListener()" id="deleteAccessSection" onclick="" style="border-radius: 10px">Hapus Akses <i class="fa fa-trash"></i></button>
				<button type="button" class="btn btn-success" id="saveAccessSection" onclick="saveAccessSection()" style="border-radius: 10px">Simpan</button>
				<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modaladd" style="border-radius: 10px">batal</button>
			</div>
		</div>
	</div>
</div>

<div class="modal" role="dialog" area-hidden="true" id="spl-fingertemp-modal-user">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #3c8dbc;">
				<label>Tambah Pekerja</label>
				<button class="btn btn-danger spl-fingertemp-modal-user-close" style="float: right;border-radius: 0px">
					<span class="glyphicon glyphicon-off"></span>
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
