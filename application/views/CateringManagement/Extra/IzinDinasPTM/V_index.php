<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><b><?=$Title ?></b></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<div class="row">
									<div class="col-sm-11">
										<h3 style="text-align: center;vertical-align: middle;">Pekerja Yang Izin Dinas Pusat / Tuksono / Mlati dan Makan Ditempat Tujuan Hari Ini yang Bisa Diproses</h3>
										<h5 style="text-align: center;vertical-align: middle;">pekerja yang bisa diproses adalah pekerja yang ijin dinasnya di approve kurang atau sama dengan jam 09:00 WIB.</h5>
									</div>
									<div class="col-sm-1">
										<button class="btn btn-primary" style="text-align: right;vertical-align: middle;" id="btn-CM-IzinDinasPTM-Proses">Proses</button>
									</div>
								</div>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<style type="text/css">
											.dt-buttons {
												float: left;
											}
											.dataTables_filter {
												float: right;
											}

											.dataTables_info {
												float: left
											}
										</style>
										<table class="table table-striped table-hover table-bordered" id="tbl-CM-IzinDinasPTM-table" style="width: 100%">
											<thead>
												<tr>
													<th class="bg-primary text-center">Tanggal</th>
													<th class="bg-primary text-center">ID Dinas</th>
													<th class="bg-primary text-center">No. Induk</th>
													<th class="bg-primary text-center">Nama</th>
													<th class="bg-primary text-center">Tempat Makan Asal</th>
													<th class="bg-primary text-center">Tempat Makan Tujuan</th>
													<th class="bg-primary text-center">Keterangan</th>
													<th class="bg-primary text-center">Jenis Dinas</th>
													<th class="bg-primary text-center">Status Tambahan</th>
													<th class="bg-primary text-center">Status Pengurangan</th>
													<th class="bg-primary text-center">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($data) && !empty($data)) {
													foreach ($data as $dt) {
														?>
														<tr style="color: <?php echo ($dt['diproses_tambah'] == "Belum diproses" || $dt['diproses_kurang'] == "Belum diproses") ? "red" : "black"; ?>">
															<td><?php echo $dt['tanggal'] ?></td>
															<td><?php echo $dt['izin_id'] ?></td>
															<td><?php echo $dt['noind'] ?></td>
															<td><?php echo $dt['nama'] ?></td>
															<td><?php echo $dt['tempat_makan'] ?></td>
															<td><?php echo $dt['tujuan'] ?></td>
															<td><?php echo $dt['keterangan'] ?></td>
															<td><?php echo $dt['jenis_dinas'] ?></td>
															<td><?php echo $dt['diproses_tambah'] ?></td>
															<td><?php echo $dt['diproses_kurang'] ?></td>
															<td>
																<?php 
																if ($dt['tidak_dihitung'] == "ada") {
																	?>
																	<button type="button" class="btn btn-primary btn-CM-IzinDinasPTM-dihitung" 
																		data-tanggal="<?php echo $dt['tanggal'] ?>"
																		data-noind="<?php echo $dt['noind'] ?>"
																		data-asal="<?php echo $dt['tempat_makan'] ?>"
																		data-tujuan="<?php echo $dt['tujuan'] ?>"
																		>
																		<span class="fa fa-check"></span> 
																		Hitung Lagi
																	</button>
																	<?php
																}else{
																	?>
																	<button type="button" class="btn btn-danger btn-CM-IzinDinasPTM-tidakdihitung"
																		data-tanggal="<?php echo $dt['tanggal'] ?>"
																		data-noind="<?php echo $dt['noind'] ?>"
																		data-asal="<?php echo $dt['tempat_makan'] ?>"
																		data-tujuan="<?php echo $dt['tujuan'] ?>"
																		>
																		<span class="fa fa-times"></span> 
																		Tidak Dihitung
																	</button>
																	<?php
																}
																?>
															</td>
														</tr>
														<?php
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
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-danger box-solid">
							<div class="box-header with-border">
								<div class="row">
									<div class="col-sm-12">
										<h3 style="text-align: center;vertical-align: middle;">Pekerja Yang Izin Dinas Pusat / Tuksono / Mlati Hari Ini yang Tidak bisa diproses</h3>
									</div>
								</div>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<style type="text/css">
											.dt-buttons {
												float: left;
											}
											.dataTables_filter {
												float: right;
											}

											.dataTables_info {
												float: left
											}
										</style>
										<table class="table table-striped table-hover table-bordered" id="tbl-CM-IzinDinasPTM-table2" style="width: 100%">
											<thead>
												<tr>
													<th class="bg-danger text-center">Tanggal</th>
													<th class="bg-danger text-center">ID Dinas</th>
													<th class="bg-danger text-center">No. Induk</th>
													<th class="bg-danger text-center">Nama</th>
													<th class="bg-danger text-center">Tempat Makan Asal</th>
													<th class="bg-danger text-center">Tempat Makan Tujuan</th>
													<th class="bg-danger text-center">Keterangan</th>
													<th class="bg-danger text-center">Jenis Dinas</th>
													<th class="bg-danger text-center">Alasan Tidak Bisa Diproses</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($data_cant_proses) && !empty($data_cant_proses)) {
													foreach ($data_cant_proses as $dt) {
														?>
														<tr>
															<td><?php echo $dt['tanggal'] ?></td>
															<td><?php echo $dt['izin_id'] ?></td>
															<td><?php echo $dt['noind'] ?></td>
															<td><?php echo $dt['nama'] ?></td>
															<td><?php echo $dt['tempat_makan'] ?></td>
															<td><?php echo $dt['tujuan'] ?></td>
															<td><?php echo $dt['keterangan'] ?></td>
															<td><?php echo $dt['jenis_dinas'] ?></td>
															<td><?php echo $dt['alasan'] ?></td>
														</tr>
														<?php
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

<style type="text/css">
	.loading {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(0,0,0,.5);
    z-index: 9999 !important;
}
.loading-wheel {
    width: 40px;
    height: 40px;
    margin-top: -80px;
    margin-left: -40px;
    
    position: absolute;
    top: 50%;
    left: 50%;
}
.loading-wheel-2 {
    width: 100%;
    height: 20px;
    margin-top: -50px;
    
    position: absolute;
    top: 70%;
    font-weight: bold;
    font-size: 30pt;
    color: white;
    text-align: center;
}

</style>
<div class="loading" id="ldg-CM-IzinDinasPTM-Loading" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>