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
					</div>
				</div>
			</div>
			
			<!-- <div class="col-md-12">
				<div id="imported_csv_data"></div>
			</div>
	</div> -->
	</div>
</section>