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
							<span><b>Shipment Sparepart No. <?php echo $header[0]['no_shipment'] ?></b></span>
						</div>
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
											<table id="filter"
												class="col-md-12" style="margin-bottom: 20px">
													<tr>
																<td>
																	<span><label>Estimasi Berangkat</label></span>
																</td>
																<td>
																	<input class="form-control time-form" style="width: 300px" type="text" id="estimasi_brkt" value="<?php echo $header[0]['berangkat'] ?>" name="estimasi_brkt" disabled></input>
																</td>
																<td>
																	<span><label>Cabang Tujuan</label></span>
																</td>
																<td>
																	<select id="cabang" name="cabang" class="form-control select2" style="width:300px;" disabled>
																<option value="" > Pilih </option>
																	<?php foreach ($cabang as $k) { 
																		$s='';
																	    if ($k['cabang_id']==$header[0]['cabang_id']) {
																			$s='selected';
																		}
																	?>
																<option value="<?php echo $k['cabang_id'] ?>" <?php echo $s ?>>
																	<?php echo $k['name'] ?></option>
																	<?php } ?>
																	</select>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>Estimasi Loading</label></span>
																</td>
																<td>
																	<input class="form-control time-form" style="width: 300px" type="text" id="estimasi_loading" name="estimasi_loading" value="<?php echo $header[0]['loading'] ?>" disabled></input>
																</td>
																
																<td>
																	<span><label>Finish Good</label></span>
																</td>
																<td>
																	<select id="fingo" name="fingo" class="form-control select2" style="width:300px;" disabled>
																<option value="" > Pilih </option>
																	<?php foreach ($fingo as $k) { 
																		$s='';
																	    if ($k['fingo']==$header[0]['fg_id']) {
																			$s='selected';
																		}
																	?>
																<option value="<?php echo $k['fingo'] ?>" <?php echo $s ?>>
																	<?php echo $k['name'] ?></option>
																	<?php } ?>
																	</select>
																</td>
															</tr>
															<tr>
																
																<td>
																	<span><label>Kendaraan</label></span>
																</td>
																	<td>
																	<select id="jk" name="jk" class="form-control select2" style="width:300px;" disabled>
																<option value="" > Pilih </option>
																	<?php foreach ($kendaraan as $k) { 
																		$s='';
																	    if ($k['jk']==$header[0]['jk_id']) {
																			$s='selected';
																		}
																	?>
																<option value="<?php echo $k['jk'] ?>" <?php echo $s ?>>
																	<?php echo $k['name'] ?></option>
																	<?php } ?>
																	</select>
																</td>
																<td>
																	<span><label>Sudah Penuh?</label></span>
																</td>
																<td>
																	<select id="status" name="status" class="form-control select2" style="width: 300px" disabled>
																		<?php
																			$y = '';
																			$n = '';
																				if($header[0]['status'] == 'N') {
																					$n = 'selected';
																				} else {
																					$y = 'selected';
																				}
																			?>
																			<option value="" > Pilih </option>
																		<option value="Y" <?php echo $y ?>> YES </option>
																		<option value="N" <?php echo $n ?>> NO </option>
																</td>
															</tr>
											</table>
										</div>
									</div>
								</div>
									<div class="col-md-12 pull-left">
										<button onclick="addRowMpmSp();" type="button" class="btn btn-primary pull-right" style="margin-top: 10px; margin-bottom: 20px;" ><i class="fa fa-plus"></i> Add</button>
									</div>
									<table id="myTable" class="table table-bordered table-hover text-center tblMPM">
										<thead>
											<tr class="bg-primary">
												<th style="width: 5%" class="text-center">No</th>
												<th style="width: 10%" class="text-center">Jumlah</th>
												<th style="width: 25%" class="text-center">Satuan</th>
												<th style="width: 30%"class="text-center">Content Type</th>
												<th style="width: 30%" class="text-center">Unit/Sparepart</th>
												<th style="width: 10%" class="text-center">Action</th>
											</tr>
										</thead>
										<tbody id="tabelAddmpmsp">
				<?php $no=1;foreach($line as $key => $value) { ?>
				<tr id="<?php echo $no; ?>" class="bakso">
					<td class="text-center"> 
						<?php echo $no; ?> </td>
					<td class="text-center"> 
						<input type="number" value="<?php echo $value['quantity'] ?>" class="form-control" style="width: 100%" type="text" id="jumlah" name="jumlah"> </td>
					<td class="text-center">
						<select id="tipe" name="tipe" class="form-control selectUnitMPM" style="width:100%;">
							<option value="" > Pilih </option>
								<?php foreach ($uom as $k) { 
									$s='';
										if ($k['uom_id']==$value['uom_id']) {
										$s='selected';
										}?>
							<option value="<?php echo $k['uom_id'] ?>" <?php echo $s ?>>
								<?php echo $k['name'] ?></option>
									<?php } ?>
						</select>
					</td>
					<td class="text-center"> 
						<select id="content" name="content" class="form-control selectUnitMPM" style="width:100%;">
							<option value="" > Pilih </option>
								<?php foreach ($content as $k) { 
									$s='';
										if ($k['content_id']==$value['content_type_id']) {
										$s='selected';
										}?>
							<option value="<?php echo $k['content_id'] ?>" <?php echo $s ?>>
								<?php echo $k['name'] ?></option>
									<?php } ?>
						</select>
					</td>
					<td class="text-center"> 
						<select id="unit" name="unit" class="form-control selectUnitMPM" style="width:100%;">
							<option value="" > Pilih </option>
								<?php foreach ($unit as $k) { 
									$s='';
										if ($k['unit_id']==$value['unit_id']) {
										$s='selected';
										}?>
							<option value="<?php echo $k['unit_id'] ?>" <?php echo $s ?>>
								<?php echo $k['name'] ?></option>
									<?php } ?>						
						</select>
					</td>
					<td class="text-center"> 
						<button type="button" class="btnDeleteRowsp btn btn-danger" onclick="myFunction()"><i class="glyphicon glyphicon-trash" disable ></i>
						</button>
					</td>
				</tr>
				<?php $no++;} ?>
			</tbody>
									</table>
								<div class="col-md-1 pull-right">
									<!-- <?php echo $header[0]['no_shipment'] ?> -->
									<button  onclick="saveEditMPMsp(<?php echo $header[0]['no_shipment']; ?>)" class="btn btn-success pull-right" style="margin-top: 10px" ><i class="fa fa-check"></i> Save</button>
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
	$('.time-form').datetimepicker({
          locale : 'id'
    });
</script>