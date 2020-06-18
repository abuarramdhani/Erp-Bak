<section class="content">
	<div class="inner" >
	<div class="row">
		<!------------Preloader-------------->
			<div
			class="loader"
			style="	position: fixed;
					width: 90%;
					height: 90%;
					margin-top: -50px;
					z-index: 999;
					background: url('../assets/img/gif/loading5.gif') 50% 50% no-repeat rgb(249,249,249);"></div>
			<!-- <div class="preloader">
					<div class="loading">
						<p>Please Wait Loading Data Table...</p>
					</div>
			</div> -->
		<!------------Preloader End---------->
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b> Monitoring Request</b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('MonitoringPembelian/Monitoring');?>">
									<i class="icon-desktop icon-2x"></i>
									<span ><br /></span>
								</a>
							</div>
						</div>
					</div>
					<div class="col-lg-12">
					<form action="<?= base_url(); ?>MonitoringPembelian/EditData/ExportPDF" method="post" target="_blank">
						<div class="col-lg-3"><label style="float: right; padding: 10px 8px 10px 14px;"><center>FILTER NO DOKUMEN</center></label></div>
						<!-- <div class="col-lg-2" style="float:left; height: 100%; font-size: 13px; padding: 10px 8px 10px 14px; background: #fff; border: 1px solid #ccc; border-radius: 6px;  position: relative; overflow:hidden">
							<div id="filterid" style="vertical-align: middle;"></div>
						</div> -->
						<div class="col-lg-2" style="float:left; height: 100%; font-size: 13px; overflow:hidden">
							<div id="filterid" style="vertical-align: middle;">
								<select name="nodok" style="background: transparent; line-height: 1;margin-top: 5px; padding: 10px 8px 10px 14px; background: #fff; border: 1px solid #ccc; width: 120%; position: relative;font-size: 1em;" class="select2Pembelian"></select>
							</div>
						</div>
						<div class="col-lg-1">
							<center><button id="submitPDF" type="submit" name="submit" class="submit btn btn-lg bg-blue">CETAK DOKUMEN</button></center>
						</div>
					</form>
						<div class="col-lg-3"><label style="float: right; padding: 10px 8px 10px 14px;"><center>FILTER STATUS</center></label></div>
						<div class="col-lg-3" style="float:right; height: 100%; font-size: 13px; padding: 10px 8px 10px 14px; background: #fff; border: 1px solid #ccc; border-radius: 6px;  position: relative; overflow:hidden">
							<!-- <div id="filter" style="vertical-align: middle;"></div> -->
							<select id="filterStatus0" style="background: transparent; line-height: 1; border: 0; padding: 0; border-radius: 0; width: 120%; position: relative; z-index: 10;font-size: 1em;">
								<option value="">--Show All--</option>
								<option value="APPROVED">APPROVED</option>
								<option value="UNAPPROVED">UNAPPROVED</option>
								<option value="REJECTED">REJECTED</option>
							</select>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								Tabel Monitoring
							</div>
							<div class="box-body">
								<div class="table-responsive">
									<input type="hidden" name="" id="jenisapahayo" value="punyapembelian">
									<table class="table table-striped table-bordered table-hover text-left tblHistoryPembelian" id="tblHistoryPembelian" style="font-size:12px;">
									<!-- <table class="table table-striped table-bordered table-hover text-left " id="tblHistoryPembelian" style="font-size:12px;"> -->
										<thead>
											<tr class="bg-primary">
												<th width="2%"><center>No</center></th>
												<th width="2%"><center>STATUS CETAK</center></th>
												<th width="2%"><center>NO DOKUMEN</center></th>
												<th width="5%"><center>UPDATE DATE</center></th>
												<th width="5%"><center>ITEM CODE</center></th>
												<th width="30%"><center>ITEM DESCRIPTION</center></th>
												<th width="4%"><center>UOM1</center></th>
												<th width="4%"><center>UOM2</center></th>
												<th width="15%"><center>BUYER</center></th>
												<th width="2%"><center>PRE-PROCESSING LEAD TIME</center></th>
												<th width="%"><center>PREPARATION PO</center></th>
												<th width="%"><center>DELIVERY</center></th> 
												<th width="2%"><center>TOTAL PROCESSING LEAD TIME</center></th>
												<th width="2%"><center>POST-PROCESSING LEAD TIME</center></th>
												<th width="2%"><center>TOTAL LEAD TIME</center></th>
												<th width="2%"><center>MOQ</center></th>
												<th width="2%"><center>FLM</center></th>
												<th width="10%"><center>NAMA APPROVER PO</center></th>
												<th width=""><center>KETERANGAN</center></th>
												<th width=""><center>RECEIVE CLOSE TOLERANCE</center></th>
									      		<th width=""><center>TOLERANCE</center></th>
												<th width="7%"><center>STATUS</center></th>
												
											</tr>
										</thead>
										<!-- <tbody>
											<?php 
											$no = 0;
											foreach ($Input as $row):
												$no++;
											?>
													<tr row-id="1">	
														<td><?php echo $no ?></td>
														<td id="cetak" <?php if ($row['CETAK'] == '0') {
															echo 'style="color: deepskyblue;"';
														} elseif ($row['CETAK'] == '1') {
															echo 'style="color: crimson;"';
														}?>>
														<b>
															<?php if ($row['CETAK'] == '0') {
																	echo 'BELUM CETAK';
																} elseif ($row['CETAK'] == '1') {
																	echo 'SUDAH CETAK';
																}
																?>													
														</b>
															
														</td>
														<td><?php echo $row['UPDATE_ID']?></td>
														<td><?php echo $row['UPDATE_DATE']?></td>
														<td><?php echo $row['SEGMENT1']?></td>
														<td><?php echo $row['DESCRIPTION']?></td>
														<td><?php echo $row['PRIMARY_UOM_CODE']?></td>
														<td><?php echo $row['SECONDARY_UOM_CODE']?></td>
														<td><?php echo $row['FULL_NAME']?></td>
														<td><?php echo $row['PREPROCESSING_LEAD_TIME']?></td>
														<td><?php echo $row['PREPARATION_PO']?></td>
														<td><?php echo $row['DELIVERY']?></td>
														<td><?php echo $row['FULL_LEAD_TIME']?></td>
														<td><?php echo $row['POSTPROCESSING_LEAD_TIME']?></td>
														<td><?php echo $row['TOTAL_LEADTIME']?></td>
														<td><?php echo $row['MINIMUM_ORDER_QUANTITY']?></td>
														<td><?php echo $row['FIXED_LOT_MULTIPLIER']?></td>
														<td><?php echo $row['ATTRIBUTE18']?></td>
														<td><?php echo $row['KETERANGAN']?></td>
														<td <?php if  ($row['STATUS'] == 'UNAPPROVED'){ 
																	echo 'style="background-color: #ffc313";'; 
																} elseif ($row['STATUS'] == 'APPROVED') {
																		echo 'style="background-color: 	#529ecc";';
																} elseif ($row['STATUS'] == 'REJECTED') {
																		echo 'style="background-color: 	#aa1d05";';
																	}
																	?>><?php echo $row['STATUS']?></td>
														
													</tr>
											<?php endforeach ?>
										</tbody> -->
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