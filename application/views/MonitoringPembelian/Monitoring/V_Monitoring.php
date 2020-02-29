<section class="content">
	<div class="inner" >
	<div class="row">
		<!------------Preloader-------------->
			<div class="preloader">
					<div class="loading">
						<p>Please Wait Loading Data Table...</p>
					</div>
			</div>
		<!------------Preloader End---------->
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-3">
							
						</div>
						<div class="col-lg-8">
							<div class="text-right">
								<h1><b> EDIT DATA</b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('MonitoringPembelian/EditData');?>">
									<i class="icon-desktop icon-2x"></i>
									<span ><br /></span>
								</a>
							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								Tabel Monitoring Pembelian
							</div>
							<div class="box-body">
								<div class="table-responsive">
									<div class="row">
										<div class="col-lg-12">
											<label class="col-md-2 control-label text-right" style="font-size: 24px;">SEARCH ITEM</label>
											<div class="col-md-7">
												<div class="col-md-12" style="padding: 3px; float: left;">
													<select class="form-control select2" multiple data-placeholder="Masukkan ITEM CODE atau DESCRIPTION" id="search" name="search">	
													</select>
												</div>
											</div>
											<div class="col-md-1 import"><center>or</center></div> 
											<div class="col-md-2 import">
												<a href="<?php echo site_url('MonitoringPembelian/EditData/exportCSV');?>" target="_blank"><button name="export" class="btn btn-md bg-blue">EXPORT ALL TO CSV</button></a>
											</div>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-lg-12">
										<form action="<?= base_url(); ?>MonitoringPembelian/EditData/SaveUpdatePembelian" method="post">
											<table class="table table-striped table-bordered table-hover text-left saveall" id="tblMonitoringPembelian" style="font-size:12px;">
												<thead>
													<tr class="bg-primary">
														
														<th><center>No</center></th>
														<th><center>ITEM CODE</center></th>
														<th><center>ITEM DESCRIPTION</center></th>
														<th><center>UOM1</center></th>
														<th><center>UOM2</center></th>
														<th><center>BUYER</center></th>
														<th><center>PRE-PROCESSING LEAD TIME</center></th>
														<th><center>PREPARATION PO</center></th>
														<th><center>DELIVERY</center></th>						
														<th><center>TOTAL PROCESSING LEAD TIME</center></th>
														<th><center>POST-PROCESSING LEAD TIME</center></th>
														<th><center>TOTAL LEAD TIME</center></th>
														<th><center>MOQ</center></th>
														<th><center>FLM</center></th>
														<th><center>NAMA APPROVER PO</center></th>
														<th><center>KETERANGAN</center></th>
														<th><center>RECEIVE CLOSE TOLERANCE</center></th>
														<th><center>TOLERANCE</center></th>
														<th><center>ACTION</center></th>
													</tr>
												</thead>
												<tbody id="body-file">
												</tbody> 
											</table>
											
										</div>
									</div>
								</div>
								<br />
								<div class="col-md-12">
									
									<div class="col-md-8 saveall">
										<div class="col-md-3 text-right">
											<label style="color: #0073b7">Email Send To</label>
										</div>
										<div class="col-md-9 left">
											<select id="EmailPE" name="EmailPE[]" class="form-control select2" multiple="multiple">	
												<?php foreach ($EmailPE as $pe) :
												?>
													<option value="<?php echo $pe['EMAIL'] ?>"><?php echo $pe['EMAIL'] ?></option>
												<?php endforeach ?>
											</select>
										</div>
										<!-- <select id="EmailPE" name="EmailPE" class="EmailPE" multiple="multiple">	
											<?php foreach ($EmailPE as $pe) :
											?>
												<option value="<?php echo $pe['EMAIL'] ?>"><?php echo $pe['EMAIL'] ?></option>
											<?php endforeach ?>
										</select> -->
									</div>
									<div class="col-md-2 saveall">
										<center><button id="submitPembelian" type="submit" name="submit" class="submit btn btn-md bg-blue">SAVE DATA</button></center>
										</form>
									</div>
								</div>
								<br />
								<div class="col-md-2 import">
										<a  class="btn btn-md bg-blue" href="<?= base_url(); ?>MonitoringPembelian/EditData/SettingEmailPembelian">Setting Email <span class="fa fa-cog"></span></a>
									</div>
								<div class="col-md-10 import">
									<center>
									<table style="border: none;">
										<tr>
											<form method="post" class="import_csv" id="import_csv" enctype="multipart/form-data" action="<?= base_url(); ?>MonitoringPembelian/EditData/import">
											<td>
												<div class="col-md-1">
													<button type="submit" name="import_csv" class="btn btn-md bg-blue" id="import_csv_btn">IMPORT CSV</button>
												</div>
											</td>
											<td>
												<div class="col-md-1"> 
					 								 <input type="file" name="csv_file" id="csv_file" required accept=".csv" />
					 							</div>
											</td>
											</form>
											<td>
											</td>
										</tr>
									</table>
									</center>
								</div>
							</div>	
						</div>
						<div class="box box-primary box-solid">
							<div class="box-body">
								<table style="font-size: 10px;" width="100%">
									<tr>
										<td width="60%">
											<b><u>Notes</u></b>
											<div>1. Coret salah satu</div>
											<div>2. Dokumen atau data yang digunakan sebagai dasar penentuan lead time</div>
											<div>3. Lead time dari PP create sampai dengan PR Approved (standar 2 hari kerja)</div>
											<div>4. Lead time pemrosesan di pembelian (preparation lead time+delivery lead time)</div>
											<div>5. Lead time dari PR approved - PO approved (by system)</div>
											<div>6. Lead time dari PO approved sampai barang diterima PBB</div>
											   <div style="padding-left: 1.5em">*) Khusus untuk item subkontraktor (Outside processing type), Delivery PO lead time memuat std. post processing lead time,</div> 
											   <div style="padding-left: 1.5em">karena adanya kendala pada proses  auto create PR dari job jika field Post Processing Lead time pada master item terisi</div>
											<div>7. Lead time dari barang diterma PBB sampai barang diproses deliver (deliver ke seksi pemesan jika expense, deliver ke gudang jika item stock)</div>
											   <div style="padding-left: 1.5em">*) Perhitungan lead time merujuk pada ES-PBB-01-01 dan ES-QCT-01-43</div>
											   <div style="padding-left: 1.5em">*) Khusus untuk item subkontraktor (Outside processing type), Std. post processing digabungkan ke dalam Delivery PO lead time</div>
											<div>8. Total lead time = Preprocessing lead time + total processing lead time + post processing lead time</div>
											<div>9. Penentuan Nama Approver PO sesuai tabel pengelompokan approver</div> 
										</td>
										<td width="40%" style="padding-left: 5px;">
											<b>Tabel Pengelompokan Approver</b>
											<div>
												<table class="kelompok" width="100%">
													<tr>
														<td style="border: 1px solid black; background-color: gold;"><center><b>DASAR PENGELOMPOKAN</b></center></td>
														<td style="border: 1px solid black; background-color: gold;"><center><b>KELOMPOK BARANG</b></center></td>
														<td style="border: 1px solid black; background-color: gold;"><center><b>APPROVER PO</b></center></td>
													</tr>
													<tr>
														<td style="border: 1px solid black; padding-left: 3px;">Kode awal : N--</td>
														<td style="border: 1px solid black; padding-left: 3px;">ASET</td>
														<td style="border: 1px solid black; padding-left: 3px;">DRS. HENDRO WIJAYANTO</td>
													</tr>
													<tr>
														<td style="border: 1px solid black; padding-left: 3px;">Kode awal : Q--</td>
														<td style="border: 1px solid black; padding-left: 3px;">PROMOSI</td>
														<td style="border: 1px solid black; padding-left: 3px;">DRS. HENDRO WIJAYANTO</td>
													</tr>
													<tr>
														<td style="border: 1px solid black; padding-left: 3px;">Kode awal : G--</td>
														<td style="border: 1px solid black; padding-left: 3px;">BDL</td>
														<td style="border: 1px solid black; padding-left: 3px;">HARUN ALRASYID</td>
													</tr>
													<tr>
														<td style="border: 1px solid black; padding-left: 3px;">Kode awal : H--</td>
														<td style="border: 1px solid black; padding-left: 3px;">BDL</td>
														<td style="border: 1px solid black; padding-left: 3px;">HARUN ALRASYID</td>
													</tr>
													<tr>
														<td style="border: 1px solid black; padding-left: 3px;">Kode awal : I--</td>
														<td style="border: 1px solid black; padding-left: 3px;">BDL</td>
														<td style="border: 1px solid black; padding-left: 3px;">HARUN ALRASYID</td>
													</tr>
													<tr>
														<td style="border: 1px solid black; padding-left: 3px;">Kode awal : L--</td>
														<td style="border: 1px solid black; padding-left: 3px;">MATERIAL</td>
														<td style="border: 1px solid black; padding-left: 3px;">RIA CAHYANI</td>
													</tr>
													<tr>
														<td style="border: 1px solid black; padding-left: 3px;">Kode awal : P--</td>
														<td style="border: 1px solid black; padding-left: 3px;">OFFICE SUPPLIES</td>
														<td style="border: 1px solid black; padding-left: 3px;">RIA CAHYANI</td>
													</tr>
													<tr>
														<td style="border: 1px solid black; padding-left: 3px;">Kode awal : S--</td>
														<td style="border: 1px solid black; padding-left: 3px;">BANGUNAN</td>
														<td style="border: 1px solid black; padding-left: 3px;">RIA CAHYANI</td>
													</tr>
													<tr>
														<td style="border: 1px solid black; padding-left: 3px;">Kode jasa non JASA01, non JANG--</td>
														<td style="border: 1px solid black; padding-left: 3px;">JASA LAIN-LAIN</td>
														<td style="border: 1px solid black; padding-left: 3px;">RIA CAHYANI</td>
													</tr>
													<tr>
														<td style="border: 1px solid black; padding-left: 3px;">Kode awal : JANG--</td>
														<td style="border: 1px solid black; padding-left: 3px;">EKSPEDISI</td>
														<td style="border: 1px solid black; padding-left: 3px;">HARUN ALRASYID</td>
													</tr>
													<tr>
														<td style="border: 1px solid black; padding-left: 3px;">Kode awal : JASA01</td>
														<td style="border: 1px solid black; padding-left: 3px;">EKSPEDISI</td>
														<td style="border: 1px solid black; padding-left: 3px;">HARUN ALRASYID</td>
													</tr>
													<tr>
														<td style="border: 1px solid black; padding-left: 3px;">Kode awal : R--</td>
														<td style="border: 1px solid black; padding-left: 3px;">MAINTENANCE</td>
														<td style="border: 1px solid black; padding-left: 3px;">SUGENG SUTANTO</td>
													</tr>
													<tr>
														<td style="border: 1px solid black; padding-left: 3px;">Kode selain di atas</td>
														<td style="border: 1px solid black; padding-left: 3px;">NON MATERIAL</td>
														<td style="border: 1px solid black; padding-left: 3px;">SUGENG SUTANTO</td>
													</tr>
												</table>
											</div>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<!-- <div class="col-md-12">
				<div id="imported_csv_data"></div>
			</div>
	</div> -->
	</div>
</section>