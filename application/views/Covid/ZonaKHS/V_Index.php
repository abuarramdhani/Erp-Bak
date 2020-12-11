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
								<a href="<?php echo base_url('Covid/ZonaKHS/Add') ?>" class="btn btn-success"><span class="fa fa-plus"></span> Tambah</a>
								<a href="<?php echo base_url('Covid/ZonaKHS/Email') ?>" class="btn btn-info"><span class="fa fa-paper-plane"></span> Kirim Email</a>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-2">
										<div class="box box-solid box-danger text-center">
											<div class="box-header with-border">
												Isolasi JOGJA <br>saat ini
											</div>
											<div class="box-body" style="font-size: 30pt;">
												<?php echo isset($summary) && !empty($summary) ? $summary->is_jogja : '0'; ?>
											</div>
										</div>
									</div>
									<div class="col-lg-2">
										<div class="box box-solid box-danger text-center">
											<div class="box-header with-border">
												Isolasi TUKSONO <br>saat ini
											</div>
											<div class="box-body" style="font-size: 30pt;">
												<?php echo isset($summary) && !empty($summary) ? $summary->is_tuksono : '0'; ?>
											</div>
										</div>
									</div>
									<div class="col-lg-2">
										<div class="box box-solid box-warning text-center">
											<div class="box-header with-border">
												Isolasi JOGJA <br>Berakhir Hari ini
											</div>
											<div class="box-body" style="font-size: 30pt;">
												<?php echo isset($summary) && !empty($summary) ? $summary->is_jogja_finish : '0'; ?>
											</div>
										</div>
									</div>
									<div class="col-lg-2">
										<div class="box box-solid box-warning text-center">
											<div class="box-header with-border">
												Isolasi TUKSONO <br>Berakhir Hari ini
											</div>
											<div class="box-body" style="font-size: 30pt;">
												<?php echo isset($summary) && !empty($summary) ? $summary->is_tuksono_finish : '0'; ?>
											</div>
										</div>
									</div>
								</div>
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
										<table id="tbl-CVD-ZonaKHS" class="table table-bordered table-hover table-striped">
											<thead>
												<th class="bg-primary" style="text-align: center;vertical-align: middle;">No.</th>
												<th class="bg-primary" style="text-align: center;vertical-align: middle;">Lokasi</th>
												<th class="bg-primary" style="text-align: center;vertical-align: middle;">Nama Seksi</th>
												<th class="bg-primary" style="text-align: center;vertical-align: middle;">Isolasi</th>
												<th class="bg-primary" style="text-align: center;vertical-align: middle;">Tanggal Awal Isolasi</th>
												<th class="bg-primary" style="text-align: center;vertical-align: middle;">Tanggal Akhir Isolasi</th>
												<th class="bg-primary" style="text-align: center;vertical-align: middle;">Kasus</th>
												<th class="bg-primary" style="text-align: center;vertical-align: middle;">Action</th>
											</thead>
											<tbody>
												<?php 
												if (isset($zona) && !empty($zona)) {
													$nomor = 1;
													foreach ($zona as $z) {
														$idEncoded = $this->encrypt->encode($z['id_zona']);
														$idEncoded = str_replace(array('+', '/', '='), array('-', '_', '~'), $idEncoded);
														?>
														<tr>
															<td>
																<?php echo $nomor ?>
																<input type="hidden" value="<?php echo $idEncoded ?>">
															</td>
															<td><?php echo $z['lokasi'] ?></td>
															<td><?php echo $z['nama_seksi'] ?></td>
															<td><?php echo $z['isolasi'] ?></td>
															<td><?php echo $z['tgl_awal_isolasi'] ?></td>
															<td><?php echo $z['tgl_akhir_isolasi'] ?></td>
															<td><?php echo $z['kasus'] ?></td>
															<td>
																<button class="btn btn-info btn-CVD-ZonaKHS-Edit" title="Edit"><span class="fa fa-edit"></span></button>
																<button class="btn btn-danger btn-CVD-ZonaKHS-Hapus" title="Hapus"><span class="fa fa-trash"></span></button>
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
    z-index: 9999;
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
<div class="loading" id="ldg-CVD-ZonaKHS" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>