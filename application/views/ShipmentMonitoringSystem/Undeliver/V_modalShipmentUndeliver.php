<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
.capitalize{
    text-transform: uppercase;}

  /* thead.toscahead tr th {
        background-color: #64b2cd;
       	font-family: sans-serif;
      }*/

      .itsfun1 {
        border-top-color: #599db5;
      }
      tr.danger td{
	 background-color: red;
	 /*animation: blinker 1.5s linear infinite;*/
}
		
</style>
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span style="font-family: sans-serif;"><b>Shipment No. <?php echo $header[0]['no_shipment'] ?></b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<!-- <div class="text-left">
					  				<span style="font-family: sans-serif;font-size:16px;"><i class="fa fa-child" style="color: black; size: 100px"></i><b> Hanya user <?php echo $header[0]['created_by']?> yang boleh mengedit header shipment</span></b> 
					  			</div>
					  			<br> -->
						<div class="box box-info box-solid">
							<div class="box-body">

								<div class="box box-info box-solid">
									<div class="box-body">
										<div class="col-md-12">

											<!-- kondisi -->
											<table id="filter"
												class="col-md-12" style="margin-bottom: 5px">
													<tr>
																<td>
																	<span><label>Estimasi Berangkat</label></span>
																</td>
																<td>
																	<input class="form-control time-form" style="width: 300px" type="text" id="estimasi_brkt1" name="estimasi_brkt" placeholder="Masukkan Waktu Estimasi" required="required" value="<?php echo $header[0]['estimate_depart_date'] ?>" disabled></input>
																</td>
																<td>
																	<span><label>PR Number</label></span>
																</td>
																<td>
																<input style="width: 300px;" placeholder="Masukkan PR Number" class="form-control" id="pr_number1" name="pr_number" value="<?php echo $header[0]['pr_number']?>" disabled></input>
																</td>
																
															</tr>
															<tr>
																<td>
																	<span><label>Estimasi Loading</label></span>
																</td>
																<td>
																	<input class="form-control time-form" style="width: 300px" type="text" id="estimasi_loading1" name="estimasi_loading" placeholder="Masukkan Waktu Loading" required="required" value="<?php echo $header[0]['estimate_loading_date']?>" disabled></input>
																</td>
																<td>
																	<span><label>PR Line</label></span>
																</td>
																<td>
																<input style="width: 300px;" placeholder="Masukkan PR Line" class="form-control" id="pr_line1" name="pr_line" value="<?php echo $header[0]['pr_line_number']?>" disabled></input>
																</td>
															
															</tr>
															<tr>
																<td>
																	<span><label>Kendaraan</label></span>
																</td>
																	<td>
																	<select onchange="cariVolume()" id="jk1" name="jk" class="form-control" style="width:300px;" required="required"  disabled>
																		<option value="" > Pilih  </option>
																		<?php foreach ($kendaraan as $k) { 
																		$s='';
																	    if ($k['vehicle_id']==$header[0]['vehicle_type_id']) {
																			$s='selected';
																		}?>
																		<option value="<?php echo $k['vehicle_id'] ?>" <?= $s?>><?php echo $k['vehicle_name'] ?></option>
																		<?php } ?>
																	</select>
																</td>

																
																<td>
																	<span><label>Tujuan</label></span>
																</td>
																<td>
															<select id="cabangsms1" name="cabang" class="form-control" style="width:300px;" required="required" 
															onchange="selectTujuanUpdate()" disabled>
																		<option value="" > Pilih  </option>
																		<?php
																			
																			foreach ($cabang as $cb) {

																				$sl = ($header[0]['ship_to_cabang_id'] == $cb['cabang_id']) ? 'selected' : '';
																				?>
																				<option value="<?= $cb['cabang_id']?>" <?= $sl?>><?= $cb['nama_cabang']?></option>
																				<?php
																			}
																		?>
																	</select>
																</td>
															</tr>
															<tr>
																<td>
																		<span><label>Volume Kendaraan cm <sup>3</sup></label></span>
																	</td>
																	<td>
																		<input style="width: 300px;" class="form-control" id="vksms" name="vksms" value="<?php echo $header[0]['volume_cm3'] ?>" readonly="true" disabled></input> 
																</td>
																	
																<td>
																	<span><label>Provinsi</label></span>
																</td>
																<td>
																	<select id="provinsi1" name="provinsi1" class="form-control" style="width:300px;" required="required" disabled>
																		<option value="" > Pilih  </option>
																		<?php foreach ($prov as $k) { 
																		$s='';
																	    if ($k['prov_id']==$header[0]['ship_to_province_id']) {
																			$s='selected';
																		}?>
																		<option value="<?php echo $k['prov_id'] ?>" <?= $s?>><?php echo $k['prov_name'] ?></option>
																		<?php } ?>
																	</select>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>Finish Good</label></span>
																</td>
																<td>
																	<select id="finishgud1" name="finishgud" class="form-control" style="width:300px;" required="required" disabled>
																		<option value="" > Pilih  </option>
																		<?php foreach ($fingo as $k) { 
																		$s='';
																	    if ($k['fg_id']==$header[0]['ship_from_id']) {
																			$s='selected';
																		}?>
																		<option value="<?php echo $k['fg_id'] ?>" <?= $s?>><?php echo $k['fg_name'] ?></option>
																		<?php } ?>
																	</select>
																</td>
																
																<td>
																	<span><label>Kota</label></span>
																</td>
																<td>
																	<select id="kota1" name="kotasms" class="form-control" style="width:300px;" required="required" disabled>
																		<option value="" > Pilih  </option>
																		<?php foreach ($kota as $k) { 
																		$s='';
																	    if ($k['city_id']==$header[0]['ship_to_city_id']) {
																			$s='selected';
																		}?>
																		<option value="<?php echo $k['city_id'] ?>" <?= $s?>><?php echo $k['city_name'] ?></option>
																		<?php } ?>
																	</select>
																</td>
															</tr>
															<tr><td>
																	<span><label>Sudah Penuh?</label></span>
																</td>
																<td>
																	<select id="status1" name="status" class="form-control" style="width: 300px" disabled>
																		<?php
																			$y = '';
																			$n = '';
																				if($header[0]['is_full_flag'] == 'N') {
																					$n = 'selected';
																				} else {
																					$y = 'selected';
																				}
																			?>
																			<option value="" > Pilih </option>
																		<option value="Y" <?php echo $y ?>> YES </option>
																		<option value="N" <?php echo $n ?>> NO </option>
																	</select>
																</td>
																
																<td>
																	<span><label>Alamat</label></span>
																</td>
																<td>
																	<input style="width: 300px;" placeholder="Masukkan Alamat" class="form-control capitalize alalalamat" id="alamatsms1" name="alamatsms" value="<?php echo $header[0]['ship_to_address']?>" disabled></input>
																</td>
																<tr>
																	<td>
																		<span><label> Header Created By</label></span>
																	</td>
																<td>
																	<input style="width: 300px;" placeholder="Masukkan Alamat" class="form-control" id="created_by" name="created_by" value="<?php echo $header[0]['created_by']?>" readonly disabled></input>
																</td>
																<td>
																	<span><label>Full Precentage (%)</label></span>
																</td>
																<td>
																	<input value="<?php echo $header[0]['full_percentage']?>" style="width: 300px;" class="fullpersenya form-control" id="fullpersen1" name="fullpersen" readonly="true"></input disabled>
																</td>
																</tr>
																<tr>
																	<td>
																		<span><label> Actual Loading</label></span>
																	</td>
																<td>
																	<input style="width: 300px;" class="form-control" id="created_by" name="created_by" value="<?php echo $header[0]['actual_loading_date']?>" readonly disabled></input>
																</td>
																<td>
																	<span><label>Actual Depart</label></span>
																</td>
																<td>
																	<input value="<?php echo $header[0]['actual_depart_date']?>" style="width: 300px;" class="fullpersenya form-control" id="fullpersen1" name="fullpersen" readonly="true"></input disabled>
																</td>
																</tr>
											</table>
											<div class="col-md-6 pull-right" style="padding-left: 133px;padding-bottom: 50px;">
												
											</div>
										</div>
									</div>
								</div>
									<table id="myTable" class="table table-bordered table-hover text-center tblMPM">
										<thead class="toscahead">
											<tr class="bg-primary">
												<th style="width: 5%" class="text-center">No</th>
												<th style="width: 10%" class="text-center">Jumlah Unit</th>
												<th style="width: 45%" class="text-center">Muatan (goods)</th>
												<th style="width: 10%" class="text-center">Volume </th>
												<th style="width: 10%" class="text-center">Persentase (%) </th>
												<th style="width: 10%" class="text-center">Delivered Qty</th>
												<th style="width: 10%" class="text-center">Created by</th>
												<!-- <th style="width: 10%" class="text-center">Action</th> -->
											</tr>
										</thead>
						 				<tbody class="findtabelsms" id="tabelAddSmsEdit">
				<?php $no=1;foreach($line as $key => $value) { ?>
					<?php if ($value['quantity'] !== $value['delivered_quantity'] ) { ?>
			<tr id="<?php echo $no; ?>" class="danger bakso">
					<?php } else { ?> 
			<tr id="<?php echo $no; ?>" class="bakso">
					<?php } ?>
				<td class="text-center editnum "><?php echo $no; ?> </td>

				<td class="text-center"><input type="number" id="jumlahsmsedit_id" value="<?php echo $value['quantity'] ?>" class="form-control jumlahsms" style="width: 100%" type="text" name="jumlahsms" disabled> </input></td>

				<td class="text-center"><select onchange="volumeline(this)" id="unitsms_id" name="unitsms[]" class="form-control select_gud" style="width:100%;" disabled>
						<option value="" > Pilih </option>
								<?php foreach ($good as $k) { 
									$s='';
										if ($k['goods_id']==$value['goods_id']) {
										$s='selected';
										}?>
						<option value="<?php echo $k['goods_id'] ?>" <?php echo $s ?>>
								<?php echo $k['goods_name'] ?></option>
									<?php } ?>						
						</select></td>
				<td class="text-center"><input type="number" class="form-control jumlahvol" style="width: 100%" type="text" id="jumlahvol_id" name="jumlahvol1" value="<?php echo $value['volume_goods']?>" readonly="true" disabled> </input></td>

				<td class="text-center"><input type="number" class="form-control persentasevolsms" id="persentasevolsms" style="width: 100%" type="text" readonly="true" value="<?php echo $value['volume_percentage']?>" name="persentasevolsms" disabled > </input></td>

				<td class="text-center"><input type="number" class="form-control" style="width: 100%" type="text" value="<?php echo $value['delivered_quantity'] ?>" id="jumlah_terkirim_id" name="jumlah_terkirim" disabled> </input></td>

				<td class="text-center"><input type="text" id="created_line" value="<?php echo $value['created_by'] ?>" class="form-control created_line" style="width: 100%" type="text" name="created_line" disabled> </input></td>

				<!-- <td class="text-center"><button type="button" class="btnDeleteRowUnit btn btn-danger" onclick="deleteEdit(<?php echo $no; ?>)"><i class="glyphicon glyphicon-trash" disable ></i></button></td> -->
				</tr>
				<?php $no++;} ?>
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

<script type="text/javascript">	
	$('.time-form').datetimepicker({
          locale : 'id'
    });

</script>