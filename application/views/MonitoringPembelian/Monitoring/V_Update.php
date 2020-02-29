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
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b> DATA IMPORT CSV</b></h1>
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
								Tabel Monitoring Pembelian PE
							</div>
							<form action="<?= base_url(); ?>MonitoringPembelian/EditData/SaveUpdatePembelianCSV" method="post">
							<div class="box-body">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover text-left " id="" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="%"><center>NO</center></th>
												<!--<th width="%"><center>UPDATE ID</center></th> -->
												<!-- <th width="%"><center>UPDATE DATE</center></th> -->
												<th width="%"><center>ITEM CODE</center></th>
												<th width="%"><center>ITEM DESCRIPTION</center></th>
												<th width="%"><center>UOM1</center></th>
												<th width="%"><center>UOM2</center></th>
												<th width="%"><center>BUYER</center></th>
												<th width="%"><center>PRE-PROCESSING LEAD TIME</center></th>
												<th width="%"><center>PREPARATION PO</center></th>
												<th width="%"><center>DELIVERY</center></th> 
												<!-- <th width="%"><center>TOTAL PROCESSING LEAD TIME</center></th> -->
												<th width="%"><center>POST-PROCESSING LEAD TIME</center></th>
												<!-- <th width="%"><center>TOTAL LEAD TIME</center></th> -->
												<th width="%"><center>MOQ</center></th>
												<th width="%"><center>FLM</center></th>
												<th width="%"><center>NAMA APPROVER PO</center></th>
												<th width="%"><center>RECEIVE CLOSE TOLERANCE</center></th>
												<th width="%"><center>TOLERANCE</center></th>
												<th width="%"><center>KETERANGAN</center></th>
												<!-- <th width="%"><center>STATUS</center></th> -->
											</tr>
										</thead>
										<tbody>
											<?php 
											$no = 0;
											foreach ($MonitoringUpdate as $row):
												$no++;
											?> 		
													<tr>
														<td><?php echo $no ?></td>
														<td><input type="hidden" name="seg1[]" id="seg" value="<?php echo $row['SEGMENT1']?>"><?php echo $row['SEGMENT1']?></td>
														<td><input type="hidden" name="desc[]" id="desc" value="<?php echo $row['DESCRIPTION']?>"><?php echo $row['DESCRIPTION']?></td>
														<td><input type="hidden" name="uom1[]" id="uom1" value="<?php echo $row['PRIMARY_UOM_CODE']?>"><?php echo $row['PRIMARY_UOM_CODE']?></td>
														<td><input type="hidden" name="uom2[]" id="uom2" value="<?php echo $row['SECONDARY_UOM_CODE']?>"><?php echo $row['SECONDARY_UOM_CODE']?></td>
														<td><input type="hidden" name="fullname[]" id="fullname" value="<?php echo $row['FULL_NAME']?>"><?php echo $row['FULL_NAME']?></td>
														<td><input type="hidden" name="preproc[]" id="preproc" value="<?php echo $row['PREPROCESSING_LEAD_TIME']?>"><?php echo $row['PREPROCESSING_LEAD_TIME']?></td>
														<td><input type="hidden" name="prepo[]" id="prepo" value="<?php echo $row['ATTRIBUTE6']?>"><?php echo $row['ATTRIBUTE6']?></td>
														<td><input type="hidden" name="deliv[]" id="deliv" value="<?php echo $row['ATTRIBUTE8']?>"><?php echo $row['ATTRIBUTE8']?></td>
														<!-- <td><input type="hidden" name="totproc[]" id="totproc" value="<?php echo $row['FULL_LEAD_TIME']?>"><?php echo $row['FULL_LEAD_TIME']?></td> -->
														<td><input type="hidden" name="posproc[]" id="posproc" value="<?php echo $row['POSTPROCESSING_LEAD_TIME']?>"><?php echo $row['POSTPROCESSING_LEAD_TIME']?></td>
														<!-- <td><input type="hidden" name="totlead[]" id="totlead" value="<?php echo $row['TOTAL_LEADTIME']?>"><?php echo $row['TOTAL_LEADTIME']?></td> -->
														<td><input type="hidden" name="moq[]" id="moq" value="<?php echo $row['MINIMUM_ORDER_QUANTITY']?>"><?php echo $row['MINIMUM_ORDER_QUANTITY']?></td>
														<td><input type="hidden" name="flm[]" id="flm" value="<?php echo $row['FIXED_LOT_MULTIPLIER']?>"><?php echo $row['FIXED_LOT_MULTIPLIER']?></td>
														<td><input type="hidden" name="attr18[]" id="attr18" value="<?php echo $row['ATTRIBUTE18']?>"><?php echo $row['ATTRIBUTE18']?></td>
														<td><input type="hidden" name="receive_close_tolerance[]" id="receive_close_tolerance" value="<?php echo $row['RECEIVE_CLOSE_TOLERANCE']?>"><?php echo $row['RECEIVE_CLOSE_TOLERANCE']?></td>
														<td><input type="hidden" name="qty_rcv_tolerance[]" id="qty_rcv_tolerance" value="<?php echo $row['QTY_RCV_TOLERANCE']?>"><?php echo $row['QTY_RCV_TOLERANCE']?></td>
														<td><input type="hidden" name="keterangan[]" id="keterangan" value="<?php echo $row['KETERANGAN'] ?>"><?php echo $row['KETERANGAN'] ?></td>
														<input type="hidden" name="stat[]" id="stat" value="UNAPPROVED">
													</tr>
											<?php endforeach ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="col-md-2">
							<a  class="btn btn-md bg-blue" href="<?= base_url(); ?>MonitoringPembelian/EditData/SettingEmailPembelian">Setting Email <span class="fa fa-cog"></span></a>
						</div>
						<div class="col-md-8">
							<div class="col-md-3 text-right"><label style="color: #0073b7">Email Send To</label></div>
							<div class="col-md-9 left">
								<select id="EmailPE" name="EmailPE[]" class="form-control select2" multiple="multiple">	
									<?php foreach ($EmailPE as $pe) :
									?>
										<option value="<?php echo $pe['EMAIL'] ?>"><?php echo $pe['EMAIL'] ?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>
						<div class="col-md-2">
							<center><button id="submitPembelian" type="submit" name="submit" class="submit btn btn-md bg-blue">SAVE ALL</button></center>
							</form>
						</div>
					</div>
				</div>
			</div>
	</div>
	</div>
</section>