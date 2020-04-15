<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><?=$Title ?></h1>		
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-lg-4">Tanggal Idul Fitri</label>
												<div class="col-lg-4">
													<input type="text" name="txtHLCMIdulFitriBulanTHR" id="txtHLCMIdulFitriBulanTHR" class="form-control" placeholder="Pilih Tanggal Idul Fitri...">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Lokasi Kerja</label>
												<div class="col-lg-4">
													<select class="select2" style="width: 100%" data-placeholder="Pilih Lokasi Kerja" name="slcHCLMLokasiBulanTHR" id="slcHCLMLokasiBulanTHR">
														<option></option>
														<option value="01">Yogyakarta</option>
														<option value="02">Tuksono</option>
													</select>
													<i style="color: red">Kosongi Lokasi Kerja untuk memilih Yogyakarta dan Tuksono</i>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-right">
													<button class="btn btn-primary" type="button" id="btnHLCMHitungBulanTHR" disabled>Hitung THR</button>
													<button class="btn btn-success" type="button" id="btnHLCMExportBulanTHR" disabled><span class="fa fa-file-excel-o"></span> Export Excel</button>
													<button class="btn btn-danger" type="button" id="btnHLCMCetakBulanTHR" disabled><span class="fa fa-file-pdf-o"></span>Cetak PDF</button>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-striped table-bordered table-hover" id="tblHLCMBulanTHR">
											<thead class="bg-primary">
												<tr>
													<th>No.</th>
													<th>Action</th>
													<th>No. Induk</th>
													<th>Nama</th>
													<th>Lokasi Kerja</th>
													<th>Masa Kerja</th>
													<th>Bulan THR</th>
												</tr>
											</thead>
											<tbody id="tbodyBulanTHR">

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