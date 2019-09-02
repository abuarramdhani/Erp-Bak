<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
</style>

<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b><i class="fa fa-pencil-square-o"></i> Shipment</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary">
							<div class="box-header with-border">
					  		</div>
							<div class="box-body">
								<div class="box box-primary box-solid">
									<div class="box-body">
										<div class="col-md-12">
											<table id="filter"
												class="col-md-12" style="margin-bottom: 20px">
													<tr>
																<td>
																	<span><label>Estimasi Berangkat</label></span>
																</td>
																<td>
																	<input class="form-control time-set" style="width: 300px" type="text" id="estimasi_brkt" name="estimasi_brkt" required="required"></input>
																</td>
																<td>
																	<span><label>Cabang Tujuan</label></span>
																</td>
																<td>
																	<select id="cabang" name="cabang" class="form-control select2 select2-hidden-accessible" style="width:300px;" required="required">
																		<option value="" > Pilih  </option>
																		<?php foreach ($cabang as $k) { ?>
																		<option value="<?php echo $k['cabang_id'] ?>"><?php echo $k['name'] ?></option>
																		<?php } ?>
																	</select>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>Estimasi Loading</label></span>
																</td>
																<td>
																	<input class="form-control time-set" style="width: 300px" type="text" id="estimasi_loading" name="estimasi_loading" required="required"></input>
																</td>
																<td>
																	<span><label>Finish Good</label></span>
																</td>
																<td>
																	<select id="fingo" name="fingo" class="form-control select2 select2-hidden-accessible" style="width:300px;" required="required">
																		<option value="" > Pilih  </option>
																		<?php foreach ($fingo as $k) { ?>
																		<option value="<?php echo $k['fingo'] ?>"><?php echo $k['name'] ?></option>
																		<?php } ?>
																	</select>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>Kendaraan</label></span>
																</td>
																	<td>
																	<select id="jk" name="jk" class="form-control select2 select2-hidden-accessible" style="width:300px;" required="required">
																		<option value="" > Pilih  </option>
																		<?php foreach ($kendaraan as $k) { ?>
																		<option value="<?php echo $k['jk'] ?>"><?php echo $k['name'] ?></option>
																		<?php } ?>
																	</select>
																</td>
																<td>
																	<span><label>Sudah Penuh?</label></span>
																</td>
																<td>
																	<select id="status" name="status" class="form-control select2 select2-hidden-accessible" style="width: 300px">
																		<option value="" > Pilih </option>
																		<option value="Y" > YES </option>
																		<option value="N" > NO </option>
																	</select>
																</td>
															</tr>
															<tr>
																
															</tr>
											</table>
										</div>
									</div>
								</div>
									<div class="col-md-12 pull-left">
										<button id="newship" onclick="addRowMpm();" type="button" class="btn btn-primary pull-right" style="margin-top: 10px; margin-bottom: 20px;"><i class="fa fa-plus"></i> Add</button>
									</div>
									<table class="table table-bordered table-hover text-center tblMPM">
										<thead>
											<tr class="bg-primary">
												<th style="width: 5%"  class="text-center">No</th>
												<th style="width: 10%" class="text-center">Jumlah</th>
												<th style="width: 25%" class="text-center">Satuan</th>
												<th style="width: 30%" class="text-center">Content Type</th>
												<th style="width: 30%" class="text-center">Unit/Sparepart</th>
												<th style="width: 10%" class="text-center">Action</th>
											</tr>
										</thead>
										<tbody id="tabelAddmpm">
											<tr class="bakso">
												<td>1</td>
												<td><input type="number" class="form-control" style="width: 100%" type="text" id="jumlah" name="jumlah">
												</td>
												<td>
													<select id="tipe" name="tipe" class="form-control selectUnitMPM" style="width:100%;">
																<option value="" > Pilih  </option>
																<?php foreach ($uom as $k) { ?>
																<option value="<?php echo $k['uom_id'] ?>"><?php echo $k['name'] ?></option>
																<?php } ?>
													</select>
												</td>
												<td>
													<select id="content" name="content" class="form-control selectUnitMPM" style="width:100%;">
																<option value="" > Pilih  </option>
																<?php foreach ($content as $k) { ?>
																<option value="<?php echo $k['content_id'] ?>"><?php echo $k['name'] ?></option>
																<?php } ?>
													</select>
												</td>
												<td><select id="unit" name="unit" class="form-control selectUnitMPM" style="width:100%;">
																<option value="" >Pilih</option>
																<?php foreach ($unit as $k) { ?>
																<option value="<?php echo $k['unit_id'] ?>"><?php echo $k['name'] ?></option>
																<?php } ?>
													</select></td>
												<td><button type="button" class="btnDeleteRow btn btn-danger" onclick="onClickBakso(1)" disabled><i class="glyphicon glyphicon-trash"></i></button></td>
											</tr>
										</tbody>
									</table>
								<div class="col-md-1 pull-right">
									<button id="buttonSaveMpm" onclick="saveMPM()" class="btn btn-success pull-right" style="margin-top: 10px" ><i class="fa fa-check"></i> Save</button>
								</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
