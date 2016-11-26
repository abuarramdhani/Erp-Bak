<?php
	foreach ($UpdateData as $ud) {
?>
<div class="form-group">
	<div class="row">
		<div class="col-lg-6">
			<div class="row" style="margin: 10px 10px">
				<label class="col-lg-4 control-label">KODE BARANG</label>
				<div class="col-lg-8">
					<input type="text" class="form-control text-uppercase" style="width: 100%" placeholder="KODE BARANG" name="txt_kode_barang" value="<?php echo $ud['kode_barang'] ?>" required></input>
					<input type="hidden" class="form-control text-uppercase" style="width: 100%" placeholder="KODE BARANG" name="txt_kode_barang_old" value="<?php echo $ud['kode_barang'] ?>" required></input>
				</div>
			</div>
			<div class="row" style="margin: 10px 10px">
				<label class="col-lg-4 control-label">DETAIL BARANG</label>
				<div class="col-lg-8">
					<input type="text" class="form-control text-uppercase" style="width: 100%" placeholder="DETAIL BARANG" name="txt_detail" value="<?php echo $ud['detail'] ?>" required></input>
				</div>
			</div>
			<div class="row" style="margin: 10px 10px">
				<label class="col-lg-4 control-label">UMUR</label>
				<div class="col-lg-8">
					<input type="text" class="form-control" style="width: 100%" onkeypress="return isNumberKey(event)" placeholder="UMUR" name="txt_umur" value="<?php echo $ud['umur'] ?>" required></input>
				</div>
			</div>
			<div class="row" style="margin: 10px 10px">
				<label class="col-lg-4 control-label">SATUAN</label>
				<div class="col-lg-8">
					<select name="txt_satuan" class="form-control select2" style="width: 100%" data-placeholder="SATUAN">
						<option></option>
						<?php
							foreach ($SatuanList as $st) {
								$select_st = '';
								if ($st['kode'] == $ud['satuan']) {
									$select_st = 'selected';
								}
						?>
						<option <?php echo $select_st; ?> value="<?php echo $st['kode'] ?>"><?php echo $st['satuan'] ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="row" style="margin: 10px 10px">
				<label class="col-lg-4 control-label">STOK</label>
				<div class="col-lg-8">
					<input type="text" class="form-control" style="width: 100%" onkeypress="return isNumberKey(event)" placeholder="STOK" name="txt_stok" value="<?php echo $ud['stok'] ?>" required></input>
				</div>
			</div>
			<div class="row" style="margin: 10px 10px">
				<label class="col-lg-4 control-label">UKURAN</label>
				<div class="col-lg-8">
					<select name="txt_ukuran" class="form-control select2" style="width: 100%" data-placeholder="UKURAN">
						<option></option>
						<?php
							foreach ($UkuranList as $uk) {
								$select_uk = '';
								if ($uk['kode'] == $ud['ukuran']) {
									$select_uk = 'selected';
								}
						?>
						<option <?php echo $select_uk; ?> value="<?php echo $uk['kode'] ?>"><?php echo $uk['ukuran'] ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="row" style="margin: 10px 10px">
				<label class="col-lg-6 control-label">DIKEMBALIKAN</label>
				<div class="col-lg-6">
					<input type="checkbox" name="txt_dikembalikan" value="1" <?php if ($ud['dikembalikan'] == 1){ echo "checked";}?> />
				</div>
			</div>
			<div class="row" style="margin: 10px 10px">
				<label class="col-lg-6 control-label">PERINGATAN</label>
				<div class="col-lg-6">
					<input type="checkbox" id="chkPeringatan" name="txt_peringatan" value="1" <?php if ($ud['peringatan'] == 1){ echo "checked";}?>  />
				</div>
			</div>
			<?php
				if ($ud['peringatan'] == 1) {
					$display = "block";
				}
				else{
					$display = "none";
				}
			?>
			<div id="peringatan" style="display: <?php echo $display;?>;">
				<div class="row" style="margin: 10px 10px">
					<label class="col-lg-6 control-label">INTERVAL PERINGATAN</label>
					<div class="col-lg-6">
						<input type="text" class="form-control" style="width: 100%" placeholder="INTERVAL PERINGATAN" name="txt_interval_peringatan" value="<?php echo $ud['interval_peringatan'] ?>"></input>
					</div>
				</div>
				<div class="row" style="margin: 10px 10px">
					<label class="col-lg-6 control-label">SATUAN PERINGATAN</label>
					<div class="col-lg-6">
						<select name="txt_satuan_peringatan" class="form-control select2" style="width: 100%" data-placeholder="SATUAN PERINGATAN">
						<option></option>
						<?php
							foreach ($SatuanList as $st) {
								$select_st_pr = '';
								if ($st['kode'] == $ud['satuan_peringatan']) {
									$select_st_pr = 'selected';
								}
						?>
						<option <?php echo $select_st_pr; ?> value="<?php echo $st['kode'] ?>"><?php echo $st['satuan'] ?></option>
						<?php } ?>
					</select>
					</div>
				</div>
			</div>
			<div class="row" style="margin: 10px 10px">
				<label class="col-lg-6 control-label">SET BUFFER (%)</label>
				<div class="col-lg-6">
					<input type="text" class="form-control" style="width: 100%" placeholder="SET BUFFER" name="txt_set_buffer" value="<?php echo $ud['set_buffer'] ?>" required></input>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	}
?>