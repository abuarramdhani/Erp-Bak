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
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<?php 
										if (isset($data) && !empty($data)) {
											$permintaan_id = $data[0]['permintaan_id'];
											$pekerja = "<option value=\"".$data[0]['pekerja']."\" selected>".$data[0]['pekerja'].' - '.$data[0]['nama']."</option>";
											$tanggal_awal = $data[0]['dari'];
											$tanggal_akhir = $data[0]['sampai'];
											$keterangan = $data[0]['keterangan'];
											$disabled = "disabled";
										}else{
											$permintaan_id = "0";
											$pekerja = "";
											$tanggal_awal = "";
											$tanggal_akhir = "";
											$keterangan = "";
											$disabled = "";
										}

										?>
										<form class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-lg-4">Pekerja</label>
												<div class="col-lg-4">
													<select id="slc-CM-PekerjaTidakMakan-Pekerja" data-placeholder="Pilih Pekerja..." style="width: 100%" autocomplete="off" <?php echo $disabled ?>>
														<?php echo $pekerja; ?>
													</select>
													<input type="hidden" id="txt-CM-PekerjaTidakMakan-PermintaanId" value="<?php echo $permintaan_id ?>">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Dari Tanggal</label>
												<div class="col-lg-4">
													<input type="text" id="txt-CM-PekerjaTidakMakan-TanggalAwal" class="form-control" placeholder="Pilih Tanggal Dari..." required autocomplete="off" value="<?php echo $tanggal_awal ?>">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Sampai Tanggal</label>
												<div class="col-lg-4">
													<input type="text" id="txt-CM-PekerjaTidakMakan-TanggalAkhir" class="form-control" placeholder="Pilih Tanggal Sampai..." required autocomplete="off" value="<?php echo $tanggal_akhir ?>">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Keterangan</label>
												<div class="col-lg-4">
													<textarea class="form-control" id="txa-CM-PekerjaTidakMakan-Keterangan" placeholder="Tuliskan Keterangan atau Alasan..." required autocomplete="off"><?php echo $keterangan ?></textarea>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-7 text-right">
													<a href="javascript:history.back()" class="btn btn-danger"><span class="fa fa-arrow-left"></span> Kembali</a>
													<button type="button" class="btn btn-primary" id="btn-CM-PekerjaTidakMakan-Simpan"><span class="fa fa-save"></span> Simpan</button>
												</div>
											</div>
										</form>
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