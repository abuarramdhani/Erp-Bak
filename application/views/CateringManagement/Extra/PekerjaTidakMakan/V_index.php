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
								<a href="<?php echo base_url('CateringManagement/Extra/PekerjaTidakMakan/tambah') ?>" class="btn btn-primary"><span class="fa fa-plus"></span> Tambah</a>
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
										<table class="table table-striped table-hover table-bordered" id="tbl-CM-PekerjaTidakMakan-Table">
											<thead>
												<tr>
													<th class="bg-primary">No.</th>
													<th class="bg-primary">Action</th>
													<th class="bg-primary">Pekerja</th>
													<th class="bg-primary">Dari</th>
													<th class="bg-primary">Sampai</th>
													<th class="bg-primary">Keterangan</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($data) && !empty($data)) {
													$nomor = 1;
													foreach ($data as $key => $value) {
														$encrypted_string = $this->encrypt->encode($value['permintaan_id']);
                                                		$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
														?>
														<tr>
															<td><?php echo $nomor ?></td>
															<td>
																<a href="<?php echo base_url('CateringManagement/Extra/PekerjaTidakMakan/edit?id='.$encrypted_string) ?>" class="btn btn-info"><span class="fa fa-pencil-square-o"></span> Edit</a>
																<button type="button" class="btn btn-danger btn-CM-PekerjaTidakMakan-Delete" data-id="<?php echo $encrypted_string ?>"><span class="fa fa-trash"></span> Hapus</button>
															</td>
															<td><?php echo $value['pekerja'].' - '.$value['nama'] ?></td>
															<td><?php echo date('d M Y',strtotime($value['dari'])) ?></td>
															<td><?php echo date('d M Y',strtotime($value['sampai'])) ?></td>
															<td><?php echo $value['keterangan'] ?></td>
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
<div class="loading" id="ldg-CM-PekerjaTidakMakan-Loading" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>