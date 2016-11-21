<section class="content-header">
	<h1>
		Hitung Kebutuhan
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">	
			<div class="box box-primary">
				<div class="box-body with-border">
					<form id="form-hitung-kebutuhan" method="post" action="<?php echo base_url('ItemManagement/HitungKebutuhan/insert') ?>">
						<input type="hidden" name="txt_modul" value="">
						<div class="form-group">
							<div class="row">
								<div class="col-lg-12">
									<div class="row" style="margin: 10px 10px">
										<label class="col-lg-2 control-label">PERIODE</label>
										<div class="col-lg-4">
											<input type="text" class="form-control text-uppercase im-datepicker" style="width: 100%" placeholder="PERIODE" name="txt_periode" value="" required></input>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<label class="col-lg-2 control-label">KODESIE</label>
										<div class="col-lg-4">
											<select id="slcKodesie" name="txt_kodesie" class="form-control" data-placeholder="KODESIE" style="width: 100%;">
											</select>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<label class="col-lg-2 control-label">BARANG</label>
										<div class="col-lg-4">
											<select name="txt_kode_barang" class="form-control slcKodeBrg" data-placeholder="ITEM" style="width: 100%">
											</select>
										</div>
										<div class="col-lg-3">
											<button id="btn-hitung-kebutuhan" type="button" class="btn btn-primary">HITUNG</button>
											<button id="submit-kebutuhan" type="submit" class="btn btn-primary" disabled>SAVE</button>
											<button type="button" class="btn btn-primary" onclick="window.history.back()">BACK</button>
										</div>
										<div class="col-lg-3">
											<div id="calculating">
												
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-10 col-lg-offset-1">
								<div id="table-item">
									<table class="table table-bordered">
										<thead class="bg-primary">
											<tr>
												<td width="5%" align="center"></td>
												<td width="25%" align="center">KODE STANDAR</td>
												<td width="25%" align="center">KODE BARANG</td>
												<td width="35%" align="center">DETAIL</td>
												<td width="10%" align="center">JUMLAH</td>
											</tr>
										</thead>
										<tbody id="hitung-kebutuhan">

										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="row">
							<hr>
							<div class="col-lg-10 col-lg-offset-1">
								<h4>SUMMARY</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-10 col-lg-offset-1">
								<div id="table-item">
									<table class="table table-bordered">
										<thead class="bg-primary">
											<tr>
												<td width="45%" align="center">SEKSI</td>
												<td width="15%" align="center">KODE BARANG</td>
												<td width="35%" align="center">DETAIL</td>
												<td width="5%" align="center">JUMLAH</td>
											</tr>
										</thead>
										<tbody id="summary-kebutuhan">

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>