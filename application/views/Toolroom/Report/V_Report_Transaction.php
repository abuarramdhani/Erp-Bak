<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b> <?= strtoupper($Title)?></b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('Toolroom');?>">
									<i class="icon-calendar icon-2x"></i>
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
								Header
							</div>
							<?php if($msg != null){ ?>
							<div class="alert alert-danger alert-dismissable"  style="width:100%;display:none;" >
								<b> Alert!</b> Tidak ada data transaksi
							</div>
							<?php } ?>
							<div class="box-body">
								<div class="row col-lg-12">
									<div class="form-group">
										<form method="post" action="<?php echo site_url('Toolroom/Report/SearchReportTransaction') ?>">
											<div class="col-md-2">
												<input type="text" name="txtPeriode" id="" class="form-control datepicker-range" data-date-format="yyyy-mm-dd" placeholder="[Periode]" required></input>
											</div>
											<div class="col-md-2">
												<select name="txsShift" id="txsShift" class="form-control" required>
													<option value="">[Select Shift]</option>
													<option value="S1">SHIFT 1</option>
													<option value="S2">SHIFT 2</option>
													<option value="S3">SHIFT 3</option>
													<option value="SU">SHIFT UMUM</option>
													<option value="ST">TANGGUNG 1</option>
													<option value="T2">TANGGUNG 2</option>
													<option value="T3">TANGGUNG 3</option>
												</select>
											</div>
											<div class="col-md-1">
												<button class="btn btn-md btn-primary btn-flat" >Search</button>
											</div>
											<div class="col-md-4 col-lg-offset-3 text-right">
											<?php 
												if(!empty($shift)){
													echo "<span style='font-size:18px;'><b>".$shift." / ".date("d F Y",strtotime($str_dt))." - ".date("d F Y",strtotime($str_end))."</b></span>";
												}
											?>
											</div>
										</form>
									</div>
								</div>
								<br>
								<br>
									<table class="table table-striped table-bordered table-hover text-left table-item-usable" id="table-item-usable" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="5%"><center>No</center></th>
												<th width="7%"><center>Item Code</center></th>
												<th width="23%"><center>Item</center></th>
												<th width="5%"><center>Merk</center></th>
												<th width="5%"><center>Stok Awal</center></th>
												<th width="5%"><center>Qty used</center></th>
												<th width="10%"><center>Date used</center></th>
												<th width="5%"><center>Qty Rtn</center></th>
												<th width="10%"><center>Last Rtn</center></th>
												<th width="5%"><center>Shift</center></th>
												<th width="5%"><center>User</center></th>
												<th width="5%"><center>Toolman</center></th>
												<th width="10%"><center>Spesification</center></th>
											</tr>
										</thead>
										<tbody>
											<?php
												if(!empty($RecordTransaction)){
													$no = 0;
													foreach($RecordTransaction as $RecordTransaction_item){
														$no++;
														echo "
															<tr>
																<td class='text-center'>".$no."</td>
																<td class='text-center'>".$RecordTransaction_item['item_id']."</td>
																<td>".$RecordTransaction_item['item_name']."</td>
																<td class='text-center'>-</td>
																<td class='text-center'>".$RecordTransaction_item['item_qty']."</td>
																<td class='text-center'>".$RecordTransaction_item['qty_dipakai']."</td>
																<td class='text-center'>".$RecordTransaction_item['creation_date']."</td>
																<td class='text-center'>".$RecordTransaction_item['item_qty_return']."</td>
																<td class='text-center'>".$RecordTransaction_item['date_return']."</td>
																<td class='text-center'>".$RecordTransaction_item['shift']."</td>
																<td class='text-center'>".$RecordTransaction_item['noind']."</td>
																<td class='text-center'>".$RecordTransaction_item['created_by']."</td>
																<td>".$RecordTransaction_item['item_desc']."</td>
															</tr>
														";
													}
												}
											?>
										</tbody>
									</table>
							</div>
							<?php if(!empty($RecordTransaction)){ ?>
							<div class="box-footer">
								<div class="col-md-12">
									<div class="col-md-3">
										<a class="btn btn-success btn-flat" href="<?php echo site_url('Toolroom/Report/ExportExcelTransaction/'.$shift.'?periode='.$periode) ?>" target="blank"><span class="fa fa-file-excel-o"></span> Export</a>
									</div>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
	</div>
	</div>
</section>