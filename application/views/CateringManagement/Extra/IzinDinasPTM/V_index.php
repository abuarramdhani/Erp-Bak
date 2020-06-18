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
										<h3 style="text-align: center;vertical-align: middle;">Pekerja Yang Izin Dinas Pusat / Tuksono / Mlati dan Makan Ditempat Tujuan Hari Ini</h3>
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
										<table class="table table-striped table-hover table-bordered" id="tbl-CM-IzinDinasPTM-table">
											<thead>
												<tr>
													<th class="bg-primary">No. Induk</th>
													<th class="bg-primary">Nama</th>
													<th class="bg-primary">Tujuan</th>
													<th class="bg-primary">Keterangan</th>
													<th class="bg-primary">Jenis Dinas</th>
													<th class="bg-primary">DiProses</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($data) && !empty($data)) {
													foreach ($data as $dt) {
														?>
														<tr>
															<td><?php echo $dt['noind'] ?></td>
															<td><?php echo $dt['nama'] ?></td>
															<td><?php echo $dt['tujuan'] ?></td>
															<td><?php echo $dt['keterangan'] ?></td>
															<td><?php echo $dt['jenis_dinas'] ?></td>
															<td><?php echo $dt['diproses'] ?></td>
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