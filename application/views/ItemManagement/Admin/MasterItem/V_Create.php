<section class="content-header">
	<h1>
		New Item
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">	
			<div class="box box-primary">
				<div class="box-body with-border">
					<form method="post" action="<?php echo base_url('ItemManagement/MasterItem/insert') ?>">
						<div class="form-group">
							<div class="row">
								<div class="col-lg-6">
									<div class="row" style="margin: 10px 10px">
										<label class="col-lg-4 control-label">KODE BARANG</label>
										<div class="col-lg-8">
											<input type="text" class="form-control text-uppercase" style="width: 100%" placeholder="KODE BARANG" name="txt_kode_barang" value="" required></input>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<label class="col-lg-4 control-label">DETAIL BARANG</label>
										<div class="col-lg-8">
											<input type="text" class="form-control text-uppercase" style="width: 100%" placeholder="DETAIL BARANG" name="txt_detail" value="" required></input>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<label class="col-lg-4 control-label">UMUR</label>
										<div class="col-lg-8">
											<input type="text" class="form-control" style="width: 100%" onkeypress="return isNumberKey(event)" placeholder="UMUR" name="txt_umur" value="" required></input>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<label class="col-lg-4 control-label">SATUAN</label>
										<div class="col-lg-8">
											<select name="txt_satuan" class="form-control select2" style="width: 100%" data-placeholder="SATUAN">
												<option></option>
												<?php foreach ($SatuanList as $st) { ?>
												<option value="<?php echo $st['kode'] ?>"><?php echo $st['satuan'] ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<label class="col-lg-4 control-label">STOK</label>
										<div class="col-lg-8">
											<input type="text" class="form-control" style="width: 100%" onkeypress="return isNumberKey(event)" placeholder="STOK" name="txt_stok" value="" required></input>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<label class="col-lg-4 control-label">UKURAN</label>
										<div class="col-lg-8">
											<select name="txt_ukuran" class="form-control select2" style="width: 100%" data-placeholder="UKURAN">
												<option></option>
												<?php foreach ($UkuranList as $uk) { ?>
												<option value="<?php echo $uk['kode'] ?>"><?php echo $uk['ukuran'] ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="row" style="margin: 10px 10px">
										<label class="col-lg-5 control-label">DIKEMBALIKAN</label>
										<div class="col-lg-7">
											<input type="checkbox" name="txt_dikembalikan" value="1" />
										</div>
									</div>
										<div class="row" style="margin: 10px 10px">
											<label class="col-lg-5 control-label">PERINGATAN</label>
											<div class="col-lg-7">
												<input type="checkbox" id="chkPeringatan" name="txt_peringatan" value="1" />
											</div>
										</div>
									<div id="peringatan" style="display: none">
										<div class="row" style="margin: 10px 10px">
											<label class="col-lg-5 control-label">INTERVAL PERINGATAN</label>
											<div class="col-lg-7">
												<input type="text" class="form-control" style="width: 100%" placeholder="INTERVAL PERINGATAN" name="txt_interval_peringatan" value=""></input>
											</div>
										</div>
										<div class="row" style="margin: 10px 10px">
											<label class="col-lg-5 control-label">SATUAN PERINGATAN</label>
											<div class="col-lg-7">
												<select name="txt_satuan_peringatan" class="form-control select2" style="width: 100%" data-placeholder="SATUAN PERINGATAN">
												<option></option>
												<?php foreach ($SatuanList as $st) { ?>
												<option value="<?php echo $st['kode'] ?>"><?php echo $st['satuan'] ?></option>
												<?php } ?>
											</select>
											</div>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<label class="col-lg-5 control-label">SET BUFFER (%)</label>
										<div class="col-lg-7">
											<input type="text" class="form-control" style="width: 100%" placeholder="SET BUFFER" name="txt_set_buffer" value="" required></input>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<div class="col-lg-12" style="text-align: right">
											<button class="btn btn-primary">SIMPAN</button>
											<span class="btn btn-primary" onclick="window.history.back()">BACK</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>