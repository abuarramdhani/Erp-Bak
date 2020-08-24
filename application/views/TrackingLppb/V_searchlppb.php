<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px;
	}
</style>
<form action="<?php echo base_url('TrackingLppb/Tracking/exportExcelTrackingLppb') ?>" method="post">
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Tracking LPPB</b></span>
						</div>
					</div>
						<div class="col-lg-12">
							<button type="submit" class="btn btn-success pull-right" id="btnExport">Export Excel</button>
						</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<div class="box box-primary box-solid">
									<div class="box-body">
										<div class="box-header with-border">
										Kriteria Pencarian
										</div>
										<div class="col-md-12">
											<div class="col-md-12">
												<div class="col-md-8">
													<table>
														<tr>
															<td style="padding: 0 50px 0 0"><label style="width: 100px">Nama Vendor</label></td>
															<td>
																<select id="nama_vendor"  name="nama_vendor" class="form-control slcnmvendorLppb" style="margin-top: 10px; width:300px;">
																
																</select>
															</td>
														</tr>
														<tr>
															<td style="padding: 0 50px 0 0"><label style="width: 100px">Nomor LPPB</label></td>
															<td>
																<input type="text" class="form-control" name="nomor_lppb" id="nomor_lppb" style="margin-top: 10px; width:300px" placeholder="Nomor LPPB">
															</td>
														</tr>
														<tr>
															<td style="padding: 0 50px 0 0"><label style="width: 100px">Tanggal LPPB</label></td>
															<td>
																<input type="text" class="form-control dateFromAndTo" name="dateFrom" id="dateFromUw" style="margin-top: 10px; margin-bottom: 10px; width:300px" placeholder="From">
															</td>
															<td>&nbsp;s/d</td>
															<br>
															<td style="padding: 0 0 0 5px">
																<input type="text" class="form-control dateFromAndTo" name="dateTo" id="dateToUw" style="margin-top: 10px; margin-bottom: 10px; width:300px" placeholder="To">
															</td>
														</tr>
														<tr>
															<td style="padding: 0 50px 0 0"><label style="width: 100px">Nomor PO</label></td>
															<td>
																<input type="text" class="form-control" name="nomor_po" id="nomor_po" style="margin-top: 10px; margin-bottom: 10px; width:300px" placeholder="Nomor PO">
															</td>
														</tr>
														<tr>
															<td style="padding: 0 50px 0 0"><label style="width: 100px">Inventory Organization</label></td>
															<td>
																<select id="inventory" name="inventory" class="form-control select2 select2-hidden-accessible" style="margin-top: 10px; width:300px;">
																<option value="" >Pilih IO</option>
																<?php foreach ($inventory as $io) { ?>
																<option value="<?php echo $io['ORGANIZATION_ID'] ?>"><?php echo $io['ORGANIZATION_CODE'] ?></option>
																<?php } ?>
																</select>
															</td>
														</tr>
														<tr>
															<td style="padding: 0 50px 30px 0"><label style="width: 100px">Opsi Gudang</label></td>
															<td style="padding:10px 0 50px 0;">
																<select id="opsigdg" name="opsigdg" class="form-control select2 select2-hidden-accessible" style="margin-top: 30px; width:300px;">
																<option value="" >Pilih Gudang</option>
																<?php foreach ($opsi as $og) { ?>
																<option value="<?php echo $og['SECTION_ID'] ?>"><?php echo $og['SECTION_NAME'] ?></option>
																<?php } ?>
																</select>
															</td>
																<td>
																</td>
																<td>
																</td>
															<td>
															<div class="pull-right" style="padding: 0 0 0 50px">
														<button type="button" class="btn btn-primary" id="btn_search_lppb">Search</button>
															</div>
														</td>
														</tr>
													</table>
													
												</div>
											</div>
										</div>
									</div>
								</div>
								<div id="loading_lppb">
									<table id="tabel_search_tracking_lppb"></table>
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
</form>


<script type="text/javascript">
	var id_gd;
</script>

