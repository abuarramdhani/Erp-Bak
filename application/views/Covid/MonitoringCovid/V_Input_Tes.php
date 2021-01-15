<style>
	.cvd_bg_trans{
		background-color: transparent;
	}
</style>
<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12 text-right">
						<h1><b><?=$Title ?></b></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div style="font-weight: bold;">
									<div class="col-md-1">
										Nama
									</div>
									<div class="col-md-11">
										: <?= $cvd->nama ?>
									</div>
									<div class="col-md-1">
										Seksi
									</div>
									<div class="col-md-11">
										: <?= $cvd->seksi ?>
									</div>
									<div class="col-md-1">
										Kasus
									</div>
									<div class="col-md-11">
										: <?= $cvd->kasus ?>
									</div>
								</div>
								<div class="col-md-12" id="cvd_tbhltes" style="margin-top: 50px;">
									
								</div>
								<div class="col-md-12 text-left">
									<a href="<?= base_url('Covid/MonitoringCovid') ?>" class="btn btn-warning">
										Kembali
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div id="surat-loading" hidden style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="<?php echo site_url('assets/img/gif/loadingtwo.gif');?>" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<div class="modal fade" id="cvd_mdladdtest" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<label class="modal-title" id="exampleModalLabel">Tambah Hasil Test</label>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="cvd_frmaddtes">
					<label>Jenis Test</label>
					<select class="cvd_select2 form-control" name="jns_test" placeholder="Jenis Test" style="width: 100%">
						<option></option>
						<option>Serology</option>
						<option>Swab Antigen</option>
						<option>Swab PCR</option>
					</select>
					<br>
					<label>Tanggal Test</label>
					<input class="form-control cvd_drange" name="tgl_test" placeholder="Masukan Tanggal Test" />
					<label>Tanggal Keluar Hasil Test</label>
					<input class="form-control cvd_dpick" name="tgl_keluar_test" placeholder="Masukan Tanggal Keluar Hasil Test" />
					<label>Hasil Test</label>
					<select class="cvd_select2 form-control" name="hsl_test" placeholder="Hasil Test" style="width: 100%">
						<option></option>
						<option value="1">Negatif</option>
						<option value="2">Non Reaktif</option>
						<option value="3">Reaktif</option>
						<option value="4">Positif</option>
					</select>
					<input hidden="" name="id" value="<?=$id?>" />
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button id="cvd_savehsltes" type="button" class="btn btn-success">Simpan</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="cvd_mdledtest" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<label class="modal-title" id="exampleModalLabel">Edit Hasil Test</label>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="cvd_frmedtes">
					<label>Jenis Test</label>
					<select class="cvd_select2 form-control" name="jns_test" placeholder="Jenis Test" style="width: 100%">
						<option></option>
						<option value="Serology">Serology</option>
						<option value="Swab Antigen">Swab Antigen</option>
						<option value="Swab PCR">Swab PCR</option>
					</select>
					<br>
					<label>Tanggal Test</label>
					<input class="form-control cvd_drange" name="tgl_test" placeholder="Masukan Tanggal Test" />
					<label>Tanggal Keluar hasil Test</label>
					<input class="form-control cvd_dpick" name="tgl_keluar_test" placeholder="Masukan Tanggal keluar Hasil Test" />
					<label>Hasil Test</label>
					<select class="cvd_select2 form-control" name="hsl_test" placeholder="Hasil Test" style="width: 100%">
						<option></option>
						<option value="1">Negatif</option>
						<option value="2">Non Reaktif</option>
						<option value="3">Reaktif</option>
						<option value="4">Positif</option>
					</select>
					<input hidden="" name="id" />
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button id="cvd_uphsltes" type="button" class="btn btn-success">Update</button>
			</div>
		</div>
	</div>
</div>
<script>
	var idenc = '<?= $id ?>';
	window.addEventListener('load', function () {
		getTabelhasiltest(idenc);
		$('[name="tgl_keluar_test"]').val('');
	})
</script>