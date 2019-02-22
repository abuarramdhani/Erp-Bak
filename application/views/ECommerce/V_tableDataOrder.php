<style type="text/css">
	#filter tr td{padding: 5px}
</style>
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b>Waktu Proses Penanganan Order</b></h1>
							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								Searching Parameter
							</div>
							<div class="box-body">
								<form id="filter-date" method="post" action="<?php echo base_url("ECommerce/WaktuPenangananOrder/getItemByDate") ?>">
									<table id="filter">
										<tr>
											<td>
												<span class="align-middle"><label>Periode Tanggal Receipt</label></span>
											</td>
											<td>
												<div class="input-group date" data-provide="datepicker">
							    					<input size="30" type="text" class="form-control" name="dateBegin" value="<?php echo $dateFrom; ?>">
							    					<div class="input-group-addon">
							        					<span class="glyphicon glyphicon-calendar"></span>
							    					</div>
												</div>
											</td>
											<td>
												<span class="align-middle">s/d</span>
											</td>
											<td>
												<div class="input-group date" data-provide="datepicker">
							    					<input size="30" type="text" class="form-control" name="dateEnd" value="<?php echo $dateTo; ?>">
							    					<div class="input-group-addon">
							        					<span class="glyphicon glyphicon-calendar"></span>
							    					</div>
												</div>
											</td>
											<td>
												<input type="submit" id="btn-search" class="btn btn-primary" value="Search"/>
											</td>
										</tr>
									</table>
									<hr size="30">
							 	<div class="col-lg-12">
									<button formaction="<?php echo base_url('ECommerce/WaktuPenangananOrder/exportExcel') ?>" class="btn btn-md btn-success pull-right" type="submit" ><i class="glyphicon glyphicon-export"></i> EXPORT</button>
								</div>
								</form>
								<div id="searchResultTableItemByDate" class="col-lg-12" style="margin-top:20px">
									<table id="dataWaktuOrder" class="table table-striped table-bordered table-hover text-center dataTable">
										<thead>
											<tr class="bg-primary">
												<th class="text-center">No</th>
												<th class="text-center">Nomor Receipt</th>
												<th class="text-center">Tanggal Receipt</th>
												<th class="text-center">Nomor SO</th>
												<th class="text-center">Nomor DO</th>
												<th class="text-center">Tanggal DO</th>
												<th class="text-center">Nomor Invoice</th>
												<th class="text-center">Tanggal Invoice</th>
												<th class="text-center">Gudang Transact</th>
												<th class="text-center">Shipping Instructions</th>
											</tr>
										</thead>
										<tbody>
										<?php 
										$i = 1;
										foreach($search_date as $row){?>
											<tr>
												<td><?php echo $i?></td>
												<td><?php echo $row['NO_RECEIPT']?></td>
												<td><?php echo $row['TGL_RECEIPT']?></td>
												<td><?php echo $row['NOMOR_SO']?></td>
												<td><?php echo $row['NOMOR_DO']?></td>
												<td><?php echo $row['TGL_DO']?></td>
												<td><?php echo $row['NOMOR_INVOICE']?></td>
												<td><?php echo $row['TGL_RECEIPT']?></td>
												<td><?php echo $row['GUDANG_TRANSACT']?></td>
												<td style="text-align: left"><?php echo $row['SHIPPING_INSTRUCTIONS']?></td>
											</tr>
										<?php $i++;}?>
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
</section>


		