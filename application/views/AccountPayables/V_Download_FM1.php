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
							<div class=" col-lg-offset-7 col-lg-5">
								<div class="row">
									<div class=" col-lg-6">
										<a href="<?php echo base_url('AccountPayables/C_Invoice/downloadfm')?>"  class="btn btn-info btn-block">Faktur Masukan</a>
									</div>
									<div class=" col-lg-6">
										<a href="<?php echo base_url('AccountPayables/C_Invoice/downloadrfm')?>"  class="btn btn-info btn-block">Retur Masukan</a>
									</div>
								</div>
							</div>
						</div>
						<!-- INPUT ROW 2 -->
						<form method="post" id="fm-form" action="<?php echo base_url('AccountPayables/C_Invoice/savefile')?>">
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
										<input id="slcInvoiceNumber2_deactive" name="TxtInvoiceNumber" class="form-control select2_deactive" style="width:100%;">
											
									</div>
								</div>
							</div>
							<!-- INPUT ROW 4 -->
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-2 control-label">Nama</label>
									<div class="col-lg-5">
										<select id="slcnama" name="TxtNama" class="form-control select2" style="width:100%;">
											<option value="">- pilih -</option>
										</select >
										<!--<input name="TxtNama" id="TxtNama" class="form-control" placeholder="Nama">-->
									</div>
								</div>
							</div>

							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-2 control-label">Tanggal Faktur</label>
									<div class="col-lg-2">
										<div class="date" data-date="" data-date-format="dd-M-yyyy" data-link-field="dtp_input2" data-link-format="dd-M-yyyy">
												<input id="tanggal_awal" onkeypress="return hanyaAngka(event, false)" class="form-control datepicker" value="<?php echo date('d-m-y'); ?>"  data-date-format="dd-M-yyyy" type="text" name="tanggal_awal" riquaite placeholder=" Date" autocomplete="off">
										</div>
									</div>
									<label class="col-lg-1 control-label">S/D</label>
									<div class="col-lg-2">
										<div class="date" data-date="" data-date-format="dd-M-yyyy" data-link-field="dtp_input2" data-link-format="dd-M-yyyy">
												<input id="tanggal_akhir" onkeypress="return hanyaAngka(event, false)" class="form-control datepicker" value="<?php echo date('d-m-y'); ?>"  data-date-format="dd-M-yyyy" type="text" name="tanggal_akhir" riquaite placeholder=" Date" autocomplete="off">
										</div>
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
							<!-- INPUT ROW 5 -->
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-2 control-label">Faktur Type</label>
									<div class="col-lg-5">
										<input type="checkbox" name="typ1" id="typ1"> Faktur With Invoice<br>
										<input type="checkbox" name="typ2" id="typ2"> Faktur Without Invoice<br>
									</div>
								</div>
							</div>
							<br>
							<!-- INPUT ROW 6 -->
							<div class="row" style="margin: 10px 10px">
								<div class="col-lg-offset-2 col-lg-2">
									<a id="FindFakturButton" class="btn btn-info btn-block btn-rect">find</a>
								</div>
								<div class="col-lg-2">
									<a id="ClearFakturButton" class="btn btn-danger btn-block btn-rect">clear</a>
								</div>
								<div class="col-lg-1" align="center"  id="loading">
								</div>
								<div class="col-lg-3">
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
						<!-- INPUT ROW 7 -->
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
						<!-- INPUT ROW 8 -->
						<div class="row" style="margin: 10px 10px">
							<div class="col-lg-offset-7 col-lg-5">
								<a href="#"  class="btn btn-primary btn-block">Input Manual</a>
							</div>
						</div>
						<hr>
					<div id="table-full">	