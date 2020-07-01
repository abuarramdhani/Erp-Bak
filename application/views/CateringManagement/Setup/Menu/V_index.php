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
								<a href="<?php echo base_url('CateringManagement/Setup/Menu/tambah') ?>" class="btn btn-primary"><span class="fa fa-plus"></span> Tambah</a>
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
										<table class="table table-striped table-hover table-bordered" id="tbl-CM-Menu-Table">
											<thead>
												<tr>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">No.</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">Action</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">Bulan Tahun</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">Shift</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">Lokasi</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if(isset($data) && !empty($data)){
													$nomor = 1;
													$bulan = array(
														1 => 'Januari',
														2 => 'Februari',
														3 => 'Maret',
														4 => 'April',
														5 => 'Mei',
														6 => 'Juni',
														7 => 'Juli',
														8 => 'Agustus',
														9 => 'September',
														10 => 'Oktober',
														11 => 'November',
														12 => 'Desember'
													);
													$shift = array(
														1 => '1 & Umum',
														2 => '2',
														3 => '3'
													);
													$lokasi = array(
														1 => 'Yogyakarta & Mlati',
														2 => 'Tuksono'
													);
													foreach ($data as $key => $value) {
														$encrypted_string = $this->encrypt->encode($value['menu_id']);
                                                		$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
														?>
														<tr>
															<td style="text-align: center"><?php echo $nomor ?></td>
															<td style="text-align: center">
																<a href="<?php echo base_url('CateringManagement/Setup/Menu/detail?menu_id='.$encrypted_string) ?>" class="btn btn-primary"><span class="fa fa-info-circle"></span> Detail</a>
																<a target="_blank" href="<?php echo base_url('CateringManagement/Setup/Menu/pdf?menu_id='.$encrypted_string) ?>" class="btn btn-danger"><span class="fa fa-file-pdf-o"></span> PDF</a>
																<a href="<?php echo base_url('CateringManagement/Setup/Menu/edit?menu_id='.$encrypted_string) ?>" class="btn btn-info"><span class="fa fa-pencil-square-o"></span> Edit</a>
																<button 
																	class="btn btn-danger btn-CM-Menu-Hapus" 
																	data-bulan="<?php echo $bulan[$value['bulan']] ?>" 
																	data-tahun="<?php echo $value['tahun'] ?>" 
																	data-shift="<?php echo $shift[$value['shift']] ?>"
																	data-menuid="<?php echo $encrypted_string ?>">
																		<span class="fa fa-trash"></span> 
																	Hapus
																</button>
															</td>
															<td><?php echo $bulan[$value['bulan']].' - '.$value['tahun'] ?></td>
															<td><?php echo $shift[$value['shift']] ?></td>
															<td><?php echo $lokasi[$value['lokasi']] ?></td>
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
<div class="loading" id="ldg-CM-Menu-Loading" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>