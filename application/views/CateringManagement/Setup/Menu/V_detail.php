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
									<div class="col-lg-12 text-center">
										<?php 
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

										if (isset($data) && !empty($data)) {
											foreach ($data as $data_key => $data_value) {
												?>
												<h1>Menu Bulan <?php echo $bulan[$data_value['bulan']].' '.$data_value['tahun']  ?> Shift <?php echo $shift[$data_value['shift']] ?></h1>
												<?php
											}
										}
										?>
									</div>
								</div>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-striped table-hover table-bordered" id="tbl-CM-Menu-Detail">
											<thead>
												<tr>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">Tanggal</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">Sayur</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">Lauk Utama</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">Lauk Pendamping</th>
													<th class="bg-primary" style="text-align: center;vertical-align: middle;">Buah</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($detail) && !empty($detail)) {
													foreach ($detail as $detail_key => $detail_value) {
														?>
														<tr>
															<td style="text-align: center;"><?php echo $detail_value['tanggal'] ?></td>
															<td><?php echo $detail_value['sayur'] ?></td>
															<td><?php echo $detail_value['lauk_utama'] ?></td>
															<td><?php echo $detail_value['lauk_pendamping'] ?></td>
															<td><?php echo $detail_value['buah'] ?></td>
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
<div class="loading" id="ldg-CM-Menu-Loading" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>