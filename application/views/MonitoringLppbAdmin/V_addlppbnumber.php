<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}

	.zoom {
  transition: transform .2s;
}

.zoom:hover {
  -ms-transform: scale(1.3); /* IE 9 */
  -webkit-transform: scale(1.3); /* Safari 3-8 */
  transform: scale(1.3); 
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}
</style>

<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<!-- <div class="box box-header"> -->
						<div class="text-left ">
							<span style="font-family: 'Source Sans Pro',sans-serif;font-size: 30px;padding-left: 5px;"><b>ADD LPPB NUMBER</b></span>
							<!-- <input type="hidden" id="batch_number" value="<?php echo $lppb[0]['BATCH_NUMBER']?>"> -->
						</div>
						<!-- </div> -->
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<div class="box box-primary box-solid">
									<div class="box-body">
										<div class="col-md-12">
											<table id="filter" class="col-md-12" style="margin-bottom: 20px">
												<tr>
													<td>
														<span><label>LPPB Info</label></span>
													</td>
													<td>
														<textarea class="form-control" size="40" type="text" id="lppb_info" name="lppb_info" placeholder="LPPB Info"></textarea>
													</td>
												</tr>
												<tr>
													<td>
														<span><label>Opsi Gudang</label><i> (wajib diisi)</i></span>
													</td>
													<td>
														<select id="id_gudang" name="id_gudang" class="form-control select2 select2-hidden-accessible" style="width:100%;">
															<option value="" > Opsi Gudang </option>
															<?php foreach ($gudang as $gd) { ?>
															<option value="<?php echo $gd['SECTION_ID'] ?>"><?php echo $gd['SECTION_NAME'] ?></option>
															<?php } ?>
														</select>
													</td>
												</tr>
												<tr>
													<td>
														<span><i>Masukkan parameter pencarian LPPB</i></span>
													</td>
												</tr>
												<tr>
													<td>
														<span><label>IO</label></span>
													</td>
													<td>
														<select id="inventory" name="inventory" class="form-control select2 select2-hidden-accessible" style="width:100%;">
															<option value="" > Inventory Organization </option>
															<?php foreach ($inventory as $io) { ?>
															<option value="<?php echo $io['ORGANIZATION_ID'] ?>"><?php echo $io['ORGANIZATION_CODE'] ?></option>
															<?php } ?>
														</select>
													</td>
												</tr>
												<tr>
													<td>
														<span><label>Status Detail</label></span>
													</td>
													<td>
														<select id="status_lppb" name="status_lppb" class="form-control select2 select2-hidden-accessible" style="width:100%;">
															<option value="" > Pilih Status </option>
															<option value="RETURN TO VENDOR">RETURN TO VENDOR</option>
															<option value="TRANSFER">TRANSFER</option>
															<option value="RECEIVE">RECEIVE</option>
															<option value="RETURN TO RECEIVING">RETURN TO RECEIVING</option>
															<option value="ACCEPT">ACCEPT</option>
															<option value="CORRECT">CORRECT</option>
															<option value="DELIVER">DELIVER</option>
														</select>
													</td>
												</tr>
												<tr>
												<td>
													<span class="text-center"><label>Nomor LPPB</label></span>
												</td>
												<td>
													<input name="lppb_numberFrom" id="lppb_numberFrom" class="form-control" style="width:100%;">
													</input>
												</td>
												<td>
													<span>	s/d	</span>
												</td>
												<td>
													<input name="lppb_number" id="lppb_number" class="form-control" style="width:100%;">
													</input>
												</td>
												
												<td>
													<div><button class="btn btn-md btn-success pull-left zoom" type="button" onclick="searchNumberLppb($(this))">Search</button>
													</div>
												</td>
												</tr>
											</table>
										</div>
									</div>
								</div>
								<div class="box-body">
									<div id="loading_search">
										
									</div>
								</div>
								<div>
									<table class="table table-bordered table-hover text-center dtTableMl" style="width: 100%">
										<thead>
											<tr class="bg-primary">
												<td class="text-center">No</td>
												<th class="text-center" style="display: none">Po Line Id</th>
												<th class="text-center" style="display: none">Line Number</th>
												<td class="text-center" style="display: none">Organization Id</td>
												<td class="text-center">Organization Code</td>
												<td class="text-center">Nomor LPPB</td>
												<td class="text-center">Vendor name</td>
												<td class="text-center">Tanggal LPPB</td>
												<td class="text-center">Nomor PO</td>
												<td class="text-center">Status Detail</td>
												<td class="text-center">Action</td>
											</tr>
										</thead>
										<tbody id="tabelNomorLPPB">

										</tbody>
									</table>
								</div>
								<div class="col-md-2 pull-right">
									<button onclick="saveLPPBNumber($(this));" type="button"class="btn btn-primary pull-right zoom" style="margin-top: 10px" >Save</button>
								</div>
								<!-- <div class="col-md-2 pull-left">
									<label> Total LPPB Submitted : </label><span id="jml_LPPB"></span>
								</div> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
	var id_gd;
</script>
