<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
.capitalize{
    text-transform: uppercase;
		}

	thead.toscahead tr th {
    background-color: #64b2cd;
    font-family: sans-serif;
      }
.zoom {
  transition: transform .2s;
}

.zoom:hover {
  -ms-transform: scale(1.3); /* IE 9 */
  -webkit-transform: scale(1.3); /* Safari 3-8 */
  transform: scale(1.3); 
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

option:checked {
    display: none;
}
</style>

<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span style="font-family: sans-serif;"><b><i class="fa fa-pencil-square-o"></i>Create Shipment</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-info">
							<div class="box-header with-border">
					  		</div>
							<div class="box-body">
								<div class="box box-info box-solid">
									<div class="box-body">
										<div class="col-md-12">
											<table id="filter"
												class="col-md-12 tbl_ship" style="margin-bottom: 5px">
													<tr>
																<td>
																	<span><label>Estimasi Berangkat</label></span>
																</td>
																<td>
																	<input class="form-control time-set" style="width: 300px" type="text" id="estimasi_brkt" name="estimasi_brkt" placeholder="Masukkan Waktu Estimasi" required="required"></input>
																</td>
																<td>
																	<span><label>PR Number</label></span>
																</td>
																<td>
																<input title="Jika Kosong, biarkan value nya 0" style="width: 300px;" placeholder="Masukkan PR Number" class="form-control" id="pr_numbersms" value="0" name="pr_number"></input>
																</td>
																
													</tr>
													<tr>
																<td>
																	<span><label>Estimasi Loading</label></span>
																</td>
																<td>
																	<input class="form-control time-set" style="width: 300px" type="text" id="estimasi_loading" name="estimasi_loading" placeholder="Masukkan Waktu Loading" required="required"></input>
																</td>
																<td>
																	<span><label>PR Line</label></span>
																</td>
																<td>
																<input title="Jika Kosong, biarkan value nya 0" style="width: 300px;" placeholder="Masukkan PR Line" class="form-control" id="pr_linesms" value="0" name="pr_line"></input>
																</td>
															
													</tr>
													<tr>
																<td>
																	<span><label>Kendaraan</label></span>
																</td>
																	<td>
																	<select id="jksms" name="jk" class="form-control select2 select2-hidden-accessible" style="width:300px;" required="required " onchange="cariVolume()">
																		<option value="" > Pilih  </option>
																		<?php foreach ($kendaraan as $k) { ?>
																		<option value="<?php echo $k['vehicle_id'] ?>"><?php echo $k['vehicle_name'] ?></option>
																		<?php } ?>
																	</select>
																</td>
																<td>
																	<span><label>Tujuan</label></span>
																</td>
																<td>
															<select id="cabangsms" name="cabang" class="form-control select2 select2-hidden-accessible" style="width:300px;" required="required" 
															onchange="selectTujuan()">
																		<option value="" > Pilih  </option>
																		<?php foreach ($cabang as $k) { ?>
																		<option value="<?php echo $k['cabang_id'] ?>"><?php echo $k['nama_cabang'] ?></option>
																		<?php } ?>
																	</select>
																</td>
																
													</tr>
													<tr>
													
																	<td>
																		<span><label>Volume Kendaraan cm <sup>3</sup></label></span>
																	</td>
																	<td>
																		<input style="width: 300px;" class="form-control" id="vksms" name="vksms" readonly="true"></input>
																	</td>
																
																
																<td>
																	<span><label>Provinsi</label></span>
																</td>
																<td>
																	<select id="provinsisms" name="provinsi" class="form-control select2 select2-hidden-accessible provcabang" style="width:300px;" required="required" onchange="selectKota()">
																		<option value="" > Pilih  </option>
																		<?php foreach ($propinsi as $k) { ?>
																		<option value="<?php echo $k['prov_id'] ?>"><?php echo $k['prov_name'] ?></option>
																		<?php } ?>
																	</select>
																</td>
																
																
															</tr>
															<tr>
																<td>
																	<span><label>Finish Good</label></span>
																</td>
																<td>
																	<select id="finishgud" name="finishgud" class="form-control select2 select2-hidden-accessible" style="width:300px;" required="required">
																		<option value="" > Pilih  </option>
																		<?php foreach ($fingo as $k) { ?>
																		<option value="<?php echo $k['fg_id'] ?>"><?php echo $k['fg_name'] ?></option>
																		<?php } ?>
																	</select>
																</td>
																
																<td>
																	<span><label>Kota</label></span>
																</td>
																<td>
																	<select id="kotasms" name="kota" class="form-control select2 select2-hidden-accessible kotacabang" style="width:300px;" required="required">
																		<option value="" > Pilih  </option>
																		<?php foreach ($kota as $k) { ?>
																		<option value="<?php echo $k['city_id'] ?>"><?php echo $k['city_name'] ?></option>
																		<?php } ?>
																	</select>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>Sudah Penuh?</label></span>
																</td>
																<td>
																	<select id="statussms" name="status" class="form-control select2 statussms" style="width: 300px" disabled>
																		<option value="N" > NO </option>
																		<option value="Y" > YES </option>
																	</select>
																</td>
																	<input type="hidden" style="width: 300px;" class="form-control" id="userhidden" name="userhidden" value="<?php echo $user; ?>" readonly="true"></input>
																<td>
																	<span><label>Full Percentage (%)</label></span>
																</td>
																<td>
																	<input style="width: 300px;" class="fullpersenya form-control" id="fullpersen" name="fullpersen" readonly="true"></input>
																</td>
															</tr>
															<tr>
																<td>
																</td>
																<td>
																</td>
																<td>
																	<span><label>Alamat</label></span>
																<td> <textarea style="width: 300px;" placeholder="Masukkan Alamat" class="form-control capitalize inialamatplz" id="alamatsms" name="alamatsms"></textarea>
																</td>
															</tr>
											</table>
											<br>
											<br>
											<br>
										</div>
									</div>
								</div>
									<div class="col-md-12 pull-left">
										<button id="new-shipment-sms" onclick="addRowSms();" type="button" class="zoom btn btn-warning pull-right" style="margin-top: 10px; margin-bottom: 20px;"><i class="fa fa-plus "></i> Add</button>
									</div>
									<table class="table table-bordered table-hover text-center tblSMS">
										<thead class="toscahead">
											<tr class="bg-primary">
												<th style="width: 5%"  class="text-center">No</th>
												<th style="width: 10%" class="text-center">Jumlah Unit</th>
												<th style="width: 40%" class="text-center">Muatan (goods)</th>
												<th style="width: 10%" class="text-center">Nomor DO</th>
												<th style="width: 10%" class="text-center">Nomor SPB</th>
												<th style="width: 20%" class="text-center">Volume </th>
												<th style="width: 15%" class="text-center">Persentase (%) </th>
												<th style="width: 15%" class="text-center">Action</th>
											</tr>
										</thead>
										<tbody id="tabelAddsms">
											<tr>
												<td>1</td>
												<td><input type="number" class="form-control jumlahsms" style="width: 100%" type="text" id="jumlahsms_id" onchange="volumeline(this)" name="jumlahsms[]">
												</td>
												<td><select onchange="volumeline(this)" id="unitsms_id" name="unitsms[]" class="form-control selectUnitMPM select_gud" style="width:100%;">
																<option value="" >Pilih</option>
																<?php foreach ($good as $k) { ?>
																<option value="<?php echo $k['goods_id'] ?>"><?php echo $k['goods_name'] ?></option>
																<?php } ?>
													</select></td>
												<td><input class="form-control no_do" style="width: 100%" type="text" id="nomor_do_id" name="nomor_do" value="0" ></td>
												<td><input class="form-control no_spb" style="width: 100%" type="text" id="nomor_spb" name="nomor_spb" value=" " ></td>
												<td><input class="form-control jumlahvol" style="width: 100%" type="text" id="jumlahvolinsert" name="jumlahvol1" readonly="true"></td>
												<td><input class="form-control persentasevolsms" style="width: 100%" type="text" id="persentasevolsmsinsert" name="persentasevolsms" readonly="true"></td>
												<td><button type="button" class="btnDeleteRow btn btn-danger" onclick="onClickBakso(1)" disabled><i class="glyphicon glyphicon-trash"></i></button></td>
											</tr>
										</tbody>
									</table>
								<div class="col-md-1 pull-right">
									<button id="buttonSaveSMS" onclick="saveSMS()" class="btn btn-success pull-right zoom" style="margin-top: 10px" ><i class="fa fa-check"></i> Save</button>
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

<script type="text/javascript">
			var user = $('#userhidden').val();
</script>
