<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h2><b>Halaman Download Retur Faktur Masukan</b></h2>
							</div>
						</div>
					</div>
				</div>
				<br />
				
				<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						Kriteria Retur Faktur Masukan
					</div>
					
					<div class="box-body">
					<form method="post" action="#">
						<!-- INPUT ROW 1 -->
						<div class="row" style="margin: 10px 10px">
							<div class=" col-lg-offset-8 col-lg-2">
								<a href="#"  class="btn btn-info btn-block">Faktur Masukan</a>
							</div>
							<div class=" col-lg-2">
								<a href="#"  class="btn btn-info btn-block">Retur Masukan</a>
							</div>
						</div>
						<!-- INPUT ROW 2 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Masa Pajak</label>
								<div class="col-lg-2">
									<input name="TxtMasaPajak" class="form-control" placeholder="Masa Pajak" required >
								</div>
								<label class="col-lg-1 control-label" align="right">Tahun</label>
								<div class="col-lg-2">
									<input name="TxtTahun" class="form-control" placeholder="Tahun" required >
								</div>
							</div>
						</div>
						<!-- INPUT ROW 3 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Nomor Faktur</label>
								<div class="col-lg-5">
									<input name="TxtNomorFaktur" class="form-control" placeholder="Nomor Faktur" required >
								</div>
							</div>
						</div>
						<!-- INPUT ROW 4 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Opsi</label>
								<div class="col-lg-3">
									<input type="checkbox"> All<br>
									<input type="checkbox"> Sudah Lapor<br>
									<input type="checkbox"> Belum Lapor
								</div>
							</div>
						</div>
						<!-- INPUT ROW 5 -->
						<div class="row" style="margin: 10px 10px">
							<div class="col-lg-offset-2 col-lg-2">
								<a href="#"  class="btn btn-info btn-rect">Find</a>
							</div>
							<div class="col-lg-offset-2 col-lg-2">
								<select class="form-control select4" data-placeholder="Select File Type" style="width:100%" required>
									<option></option>
									<option>CSV</option>
									<option>PDF</option>
								</select>
							</div>
							<div class=" col-lg-2">
								<a href="#"  class="btn btn-info btn-block">Save</a>
							</div>
							<div class=" col-lg-2">
								<a href="#"  class="btn btn-info btn-block">Import</a>
							</div>
						</div>
						<!-- INPUT ROW 6 -->
						<div class="row" style="margin: 10px 10px">
							<div class=" col-lg-offset-8 col-lg-4">
								<a href="#"  class="btn btn-primary btn-block">Input Manual</a>
							</div>
						</div>
						<hr>
					</form>
					
					<div class="table-responsive" style="overflow:hidden;">
						<table class="table table-striped table-bordered table-hover text-left" id="tabel-retur-faktur" style="font-size:14px;">
							<thead class="bg-primary">
								<tr>
									<th width="">RM</th>
									<th width="">NPWP</th>
									<th width="">NAMA</th>
									<th width="">KD_JENIS_TRANSAKSI</th>
									<th width="">FG_PENGGANTI</th>
									<th width="">NOMOR_FAKTUR</th>
									<th width="">TANGGAL_FAKTUR</th>
									<th width="">IS_CREDITABLE</th>
									<th width="">NOMOR_DOKUMEN_RETUR</th>
									<th width="">TANGGAL_RETUR</th>
									<th width="">MASA_PAJAK_RETUR</th>
									<th width="">TAHUN_PAJAK_RETUR</th>
									<th width="">NILAI_RETUR_DPP</th>
									<th width="">NILAI_RETUR_PPN</th>
									<th width="">NILAI_RETUR_PPNBM</th>
									<th width="">STATUS_FAKTUR</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td><a href="#"  class="btn btn-sm btn-danger">Lapor</a></td>
								</tr>
							</tbody>																			
						</table>
					</div>
				</div>
				</div>
			</div>	
			</div>
	</div>
	</div>
</section>


		