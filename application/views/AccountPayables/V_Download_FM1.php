<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h2><b>Halaman Download Faktur Masukan</b></h2>
							</div>
						</div>
					</div>
				</div>
				<br />
				
				<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						Kriteria Faktur Masukan
					</div>
					
					<div class="box-body">
						<!-- INPUT ROW 1 -->
						<div class="row" style="margin: 10px 10px">
							<div class=" col-lg-offset-8 col-lg-2">
								<a href="<?php echo base_url('AccountPayables/C_Invoice/downloadfm')?>"  class="btn btn-info btn-block">Faktur Masukan</a>
							</div>
							<div class=" col-lg-2">
								<a href="<?php echo base_url('AccountPayables/C_Invoice/downloadrfm')?>"  class="btn btn-info btn-block">Retur Masukan</a>
							</div>
						</div>
						<!-- INPUT ROW 2 -->
						<form method="post" action="<?php echo base_url('AccountPayables/C_Invoice/savefile')?>">
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-2 control-label">Masa Pajak</label>
									<div class="col-lg-2">
										<input name="TxtMasaPajak" class="form-control" placeholder="Masa Pajak" >
									</div>
									<label class="col-lg-1 control-label" align="right">Tahun</label>
									<div class="col-lg-2">
										<input name="TxtTahun" class="form-control" placeholder="Tahun" >
									</div>
								</div>
							</div>
							<!-- INPUT ROW 3 -->
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-2 control-label">Nomor Faktur</label>
									<div class="col-lg-5">
										<select id="slcInvoiceNumber2" name="TxtInvoiceNumber" class="form-control select2" style="width:265px;">
											<option value="">- pilih -</option>
										</select >
									</div>
								</div>
							</div>
							<!-- INPUT ROW 4 -->
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-2 control-label">Nama</label>
									<div class="col-lg-5">
										<input name="TxtNama" id="TxtNama" class="form-control" placeholder="Nama" readonly>
									</div>
								</div>
							</div>
							<!-- INPUT ROW 4 -->
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-2 control-label">Status</label>
									<div class="col-lg-2">
										<input type="checkbox" name="sta1" id="sta1"> Normal<br>
										<input type="checkbox" name="sta2" id="sta2"> Pengganti<br>
										<input type="checkbox" name="sta3" id="sta3"> Diganti<br>
									</div>
									<label class="col-lg-1 control-label">Keterangan</label>
									<div class="col-lg-2">
										<input type="checkbox" name="ket1" id="ket1"> Sudah Lapor<br>
										<input type="checkbox" name="ket2" id="ket2"> Belum Lapor<br>
									</div>
								</div>
							</div>
							<br>
							<!-- INPUT ROW 5 -->
							<div class="row" style="margin: 10px 10px">
								<div class="col-lg-offset-2 col-lg-2">
									<a id="FindFakturButton" class="btn btn-info btn-rect">Find</a>
								</div>
									<div class="col-lg-offset-3 col-lg-3">
										<select class="form-control select4" data-placeholder="Select File Type" style="width:100%" name="slcFileType" required>
											<option></option>
											<option value="1">CSV</option>
											<option value="2">PDF</option>
											<option value="3">EXCEL</option>
										</select>
									</div>
									<div class=" col-lg-2">
										<button class="btn btn-info btn-block">Save</button>
									</div>
							</div>
						</form>
						<!-- INPUT ROW 6 -->
						<form method="post" action="<?php echo base_url('AccountPayables/C_Invoice/importfm')?>" enctype="multipart/form-data">
							<div class="row" style="margin: 10px 10px">
								<div class=" col-lg-offset-7 col-lg-3">
									
										<input name="importfmfile" type="file" class="form-control" readonly required>
									
								</div>
								<div class=" col-lg-2">
									<button class="btn btn-info btn-block">Import</button>
								</div>
							</div>
						</form>
						<!-- INPUT ROW 7 -->
						<div class="row" style="margin: 10px 10px">
							<div class=" col-lg-offset-7 col-lg-5">
								<a href="#"  class="btn btn-primary btn-block">Input Manual</a>
							</div>
						</div>
						<hr>
					<div id="table-full">	