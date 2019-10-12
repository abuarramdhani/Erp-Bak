<style type="text/css">
	.skin-blue-light .main-header .navbar {
		background-image: linear-gradient(70deg, #2ABB9B 70%, #16A085 30%);
	}
	.skin-blue-light .main-header .logo {
		background: #2ABB9B !important;
	}
	.logo:hover,
	a.logo:hover,
	.skin-blue-light .main-header .logo:hover,
	.skin-blue-light .main-header .logo .logo-lg:hover {
	  	background-color: #16A085 !important;
	}
	.skin-blue-light .main-header .navbar .sidebar-toggle:hover {
	  	background-color: #16A085 !important;
	}
	.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
		background: #2ABB9B !important;
		border-color: #16A085 !important;
	}

	.pagination > :not(.active) > a, .pagination > :not(.active) > span, .pagination > :not(.active) > a:focus, .pagination > :not(.active) > span:focus {
		color: #2ABB9B !important;
	}

	.pagination > :not(.active) > a:hover, .pagination > :not(.active) > span:hover {
		font-weight: bold;
		color: #16A085 !important;
	}
</style>

<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h3><b><?=$Title ?></b></h3>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-solid">
							<div class="box-header" style="background: #16A085;">
								<b style="color: white">Jaminan Kesehatan Nasional</b>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-bordered table-hover table-striped" id="tbl-MPR-BPJSTambahan">
											<thead class="bg-primary">
												<tr>
													<th class="text-center" style="background-image: linear-gradient(70deg, #2ABB9B 100%, #16A085 0%);">No</th>
													<th class="text-center" style="background-image: linear-gradient(70deg, #2ABB9B 100%, #16A085 0%);">No Induk</th>
													<th class="text-center" style="background-image: linear-gradient(70deg, #2ABB9B 100%, #16A085 0%);">Nama</th>
													<th class="text-center" style="background-image: linear-gradient(70deg, #2ABB9B 100%, #16A085 0%);">Seksi</th>
													<th class="text-center" style="background-image: linear-gradient(70deg, #2ABB9B 100%, #16A085 0%);">Jumlah</th>
													<th class="text-center" style="background-image: linear-gradient(70deg, #2ABB9B 100%, #16A085 0%);">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
													if (!empty($data)) {
														$nomor = 1;
														foreach ($data as $key) {
															?>
															<tr>
																<td class="text-center"><?=$nomor ?></td>
																<td class="text-center"><?=$key['noind'] ?></td>
																<td><?=$key['nama'] ?></td>
																<td><?=$key['seksi'] ?></td>
																<td class="text-center"><?=$key['jumlah'] ?></td>
																<td class="text-center">
																	<button type="button" class="btn btn-sm modal-trigger-MPR-BPJSTambahan" data-noind ='<?=$key['noind'] ?>' style="background-image: linear-gradient(70deg, #2ABB9B 70%, #16A085 30%);color: white"><span class="fa fa-pencil"></span></button>
																</td>
															</tr>
															<?php
															$nomor++;
														}
													}
												?>
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

<div class="modal" tabindex="-1" role="dialog" area-hidden="true" id="modal-MPR-BPJSTambahan">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background-image: linear-gradient(70deg, #2ABB9B 70%, #16A085 30%);">
				<label>Edit BPJS Tambahan</label>
				<button class="btn btn-danger modal-close-MPR-BPJSTambahan" style="float: right;border-radius: 0px">
					<span class="glyphicon glyphicon-off"></span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12">
						<label class="form-label">Ditanggung :</label>
						<div class="row">
							<div class="col-lg-12" style="overflow-x: scroll">
								<table class="table table-striped table-bordered table-hover">
									<thead class="bg-success">
										<th class="text-center">No</th>
										<th class="text-center">Hubungan</th>
										<th class="text-center">Nama</th>
										<th class="text-center">Nik</th>
										<th class="text-center">tanggal lahir</th>
										<th class="text-center">Alamat</th>
										<th class="text-center">Action</th>
									</thead>
									<tbody class="tbl-MPR-BPJSTambahan-ditanggung">

									</tbody>
								</table>
							</div>
						</div>
						<label class="form-label">Tidak ditanggung :</label>
						<div class="row">
						<div class="col-lg-12" style="overflow-x: scroll">
							<table class="table table-striped table-bordered table-hover">
								<thead class="bg-danger">
									<th class="text-center">No</th>
									<th class="text-center">Hubungan</th>
									<th class="text-center">Nama</th>
									<th class="text-center">Nik</th>
									<th class="text-center">tanggal lahir</th>
									<th class="text-center">Alamat</th>
									<th class="text-center">Action</th>
								</thead>
								<tbody class="tbl-MPR-BPJSTambahan-tidakditanggung">

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer" style="background-image: linear-gradient(70deg, #2ABB9B 75%, #16A085 25%);">

			</div>
		</div>
	</div>
</div>
