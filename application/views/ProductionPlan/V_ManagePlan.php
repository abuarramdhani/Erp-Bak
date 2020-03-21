<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1>
									<b>
										<?= $Title ?>
									</b>
								</h1>
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('ProductionPlan/Item');?>">
									<i class="fa fa-wrench fa-2x">
									</i>
									<span>
										<br />
									</span>
								</a>
							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-md-12">
						
						<div class="box box-success">
							<div class="box-header with-border"><b>Manage Plan</b></div>
							<div class="box-body">
								<div class="panel-body">
									<div class="col-md-1" style="text-align: right;">
										<label>Bulan</label>
									</div>
									<form method="post" enctype="multipart/form-data" action="<?= base_url(); ?>ProductionPlan/Plan/importexcel" target="_blank">
									<div class="col-md-3" style="text-align: center;">
										<input style="text-align: center" type="text" class="form-control monthplan" id="monthplan" name="monthplan" placeholder="Bulan">
									</div>
                               
									<div class="col-md-1" style="text-align: right;">
										<label>Plan</label>
									</div>
										<div class="col-md-3" style="text-align: center;">
											 <input class="form-control" onchange="removedisabled(this)" type="file" name="excel_file" id="excel_file" accept=".xls,.xlsx" />
											<!-- <button class="btn btn-success"><i class="glyphicon glyphicon-import"></i> Import</button> -->
										</div>
										<div class="col-md-1" style="text-align: left;">
											<button class="btn btn-success" id="butonexport" disabled="disabled"><i class="glyphicon glyphicon-import"></i> Import</button>
										</div>
									</form>
									<form method="post" action="<?= base_url(); ?>ProductionPlan/Plan/Export" target="_blank">
									<div class="col-md-2" style="text-align: left;">
										<button class="btn btn-primary"><i class="fa fa-download"></i> Download Layout</button>
									</div>
								</form>
								</div>

								
							</div>
							<div class="box-footer"><b>Search</b></div>
							<div class="box-footer">
										<div class="panel-body">
									<div class="col-md-1" style="text-align: right;">
										<label>Bulan</label>
									</div>
									<div class="col-md-3" style="text-align: center;">
										<input style="text-align: center" type="text" class="form-control monthplan" id="monthplan2" name="monthplan2" placeholder="Bulan">
									</div>
									<div class="col-md-1" style="text-align: center;">
										<button onclick="TampilkanhasilPlan(this)" class="btn btn-info"><i class="fa fa-search"></i> Search</button>
									</div>    
						
								</div>
								<div id="hilangkan">
								<div class="panel-body">
									<div class="col-md-12">
										<h3 style="font-weight: bold">Body</h3>
									</div>
									<div class="col-md-12">
										<table class="table table-bordered">
											<thead class="bg-yellow">
												
												<tr>
													<th class="text-center">No</th>
													<th class="text-center">Kode Komponen</th>
													<th class="text-center">Nama Komponen</th>
													<th class="text-center">Bulan</th>
													<th class="text-center">Versi</th>
												</tr>
												
											</thead>
											<tbody>
												<?php $bo=1; foreach ($arrayplanbody as $body) { ?>
												<tr>
													<td class="text-center"><?=$bo?></td>
													<td class="text-center"><?=$body['kode_komponen']?></td>
													<td class="text-center"><?=$body['nama_komponen']?></td>
													<td class="text-center"><?=$body['bulan']?></td>
													<td class="text-center"><?=$body['versi_baru']?></td>

												</tr>
												<?php $bo++; } ?>
											</tbody>
										</table>
									</div>
								</div>

								<div class="panel-body">
									<div class="col-md-12">
										<h3 style="font-weight: bold">Handle Bar</h3>
									</div>
									<div class="col-md-12">
										<table class="table table-bordered">
											<thead class="bg-red">
												<tr>
													<th class="text-center">No</th>
													<th class="text-center">Kode Komponen</th>
													<th class="text-center">Nama Komponen</th>
													<th class="text-center">Bulan</th>
													<th class="text-center">Versi</th>

												</tr>
											</thead>
											<tbody>
												<?php $bo=1; foreach ($arrayplanhandlebar as $hand) { ?>
												<tr>
													<td class="text-center"><?=$bo?></td>
													<td class="text-center"><?=$hand['kode_komponen']?></td>
													<td class="text-center"><?=$hand['nama_komponen']?></td>
													<td class="text-center"><?=$hand['bulan']?></td>
													<td class="text-center"><?=$hand['versi_baru']?></td>

												</tr>
												<?php $bo++; } ?>
											</tbody>
										</table>
									</div>
								</div>

								<div class="panel-body">
									<div class="col-md-12">
										<h3 style="font-weight: bold">Dos</h3>
									</div>
									<div class="col-md-12">
										<table class="table table-bordered">
											<thead class="bg-primary">
												<tr>
													<th class="text-center">No</th>
													<th class="text-center">Kode Komponen</th>
													<th class="text-center">Nama Komponen</th>
													<th class="text-center">Bulan</th>
													<th class="text-center">Versi</th>

												</tr>
											</thead>
											<tbody>
												<?php $bo=1; foreach ($arrayplandos as $dos) { ?>
												<tr>
													<td class="text-center"><?=$bo?></td>
													<td class="text-center"><?=$dos['kode_komponen']?></td>
													<td class="text-center"><?=$dos['nama_komponen']?></td>
													<td class="text-center"><?=$dos['bulan']?></td>
													<td class="text-center"><?=$dos['versi_baru']?></td>

												</tr>
												<?php $bo++; } ?>
											</tbody>
										</table>
									</div>
								</div>

							</div>
								<div class="panel-body">
									<div class="col-md-12" id="tabelplan"></div>
								</div>	
							</div>
						</div>
						<div class="row">
							
						</div>
					</div>
				</div>
			</div>
		</section>