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
							    					<input size="30" type="text" class="form-control" name="dateBegin" id="dateBegin"placeholder="From">
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
							    					<input size="30" type="text" class="form-control" name="dateEnd" id="dateEnd" placeholder="To">
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
									<button class="btn btn-md btn-success pull-right" type="submit" id="submitExportExcelItemEcatalog" disabled><i class="glyphicon glyphicon-export"></i> EXPORT</button>
								</div>
								</form>
								<div id="searchResultTableItemByDate" class="col-lg-12" style="margin-top:20px">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


		