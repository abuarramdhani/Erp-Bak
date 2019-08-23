<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b> Data Import </b></h1>
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('CetakStikerCC/Cetak');?>">
									<i class="fa fa-refresh fa-2x"></i>
									<span><br /></span>
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
								<b>Data Excel</b>
							</div>
							<form target="_blank" action="<?= base_url(); ?>CetakStikerCC/Cetak/Report" method="post">
								<div class="box-body">
									<div class="panel-body">
										<div class="table-responsive">
											<table
												class="table table-bordered table-responsive table-hover no-footertable text-left"
												style="font-size: 12px;">
												<thead>
													<tr class="bg-info">
														<th width="5%">
															<center>NO</center>
														</th>
														<th>
															<center>COST CENTER</center>
														</th>
														<th>
															<center>SEKSI NOMESIN</center>
														</th>
														<th>
															<center>TAG NUMBER</center>
														</th>
														<th>
															<center>KODE RESOURCE</center>
														</th>
														<th>
															<center>DESKRIPSI</center>
														</th>
														<th>
															<center>TANGGAL UPDATE</center>
														</th>
													</tr>
												</thead>
												<tbody>
													<?php 
													$c = 0;
													$no = 0;
													foreach ($list as $key){

														foreach ($key as $row){
															$no++;
													?>
													<tr>
														<td>
															<center><?php echo $no ?></center>
														</td>
														<td>
															<center><input type="hidden" name="center[]" id="center"
																	value="<?php echo $row['COST_CENTER']?>"><?php echo $row['COST_CENTER']?>
															</center>
														</td>
														<td>
															<center><input type="hidden" name="seksi[]" id="seksi"
																	value="<?php echo $row['SEKSI_NOMESIN']?>"><?php echo $row['SEKSI_NOMESIN']?>
															</center>
														</td>
														<td>
															<center><input type="hidden" name="tag[]" id="tag"
																	value="<?php echo $row['TAG_NUMBER']?>"><?php echo $row['TAG_NUMBER']?>
															</center>
														</td>
														<td>
															<center><input type="hidden" name="kode[]" id="kode"
																	value="<?php echo $row['KODE_RESOURCE']?>"><?php echo $row['KODE_RESOURCE']?>
															</center>
														</td>
														<td>
															<center><input type="hidden" name="desc[]" id="desc"
																	value="<?php echo $row['DESKRIPSI']?>"><?php echo $row['DESKRIPSI']?>
															</center>
														</td>
														<td>
															<center><input type="hidden" name="tgl[]" id="tgl"
																	value="<?php echo $row['TANGGAL_UPDATE']?>"><?php echo $row['TANGGAL_UPDATE']?>
															</center>
														</td>
													</tr>
													<?php 
												$c++; }
												} ?>
												</tbody>
											</table>
										</div>
										<center>
											<button type="submit" title="Cetak Stiker" class="btn btn-success"> Cetak
												Stiker</button>
										</center>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
</section>