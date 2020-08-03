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
							<div class="box-header with-border text-right">
								<a href="<?php echo base_url('CateringManagement/Setup/PekerjaMakanKhusus/tambah') ?>" class="btn btn-primary"><span class="fa fa-plus"></span> Tambah</a>
								<a href="<?php echo base_url('CateringManagement/Setup/PekerjaMakanKhusus/importExcel') ?>" class="btn btn-primary"><span class="fa fa-file-excel-o"></span> Import</a>
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
										<table class="table table-striped table-hover table-bordered" id="tbl-CM-PekerjaMakanKhusus-Table">
											<thead>
												<tr>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">No.</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">Action</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">Pekerja</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">Menu</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">Menu Pengganti</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">Tanggal Mulai</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">Tanggal Selesai</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($data) && !empty($data)) {
													$nomor = 1;
													foreach ($data as $key => $value) {
														$encrypted_string = $this->encrypt->encode($value['pekerja_menu_khusus_id']);
                                                		$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
														?>
														<tr>
															<td><?php echo $nomor ?></td>
															<td>
																<a href="<?php echo base_url('CateringManagement/Setup/PekerjaMakanKhusus/edit?id='.$encrypted_string) ?>" class="btn btn-info"><span class="fa fa-pencil-square-o"></span> Edit</a>
																<button class="btn btn-danger btn-CM-PekerjaMakanKhusus-Hapus" data-id="<?php echo $encrypted_string ?>"><span class="fa fa-trash"></span> Hapus</button>
															</td>
															<td><?php echo $value['noind'].' - '.$value['nama'] ?></td>
															<td><?php echo $value['menu_sayur'].' - '.$value['menu_lauk_utama'].' - '.$value['menu_lauk_pendamping'].' - '.$value['menu_buah'] ?></td>
															<td><?php echo $value['pengganti_sayur'].' - '.$value['pengganti_lauk_utama'].' - '.$value['pengganti_lauk_pendamping'].' - '.$value['pengganti_buah'] ?></td>
															<td><?php echo $value['tanggal_mulai'] ?></td>
															<td><?php echo $value['tanggal_selesai'] ?></td>
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
<div class="loading" id="ldg-CM-PekerjaMakanKhusus-Loading" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>