<style type="text/css">
.capital{
    text-transform: uppercase;
}
</style>

<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span style="font-family: sans-serif;"><b><i class="fa fa-gear"></i> Edit Cabang</b></span>
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
																<td style="width: 20%">
																	<span><label>Nama Cabang</label></span>
																</td>
																<td style="width: 40%">
																	<input class="form-control capital" style="width: 300px" type="text" id="cabangnameupdate" name="cabangname" placeholder="Masukkan nama cabang" value="<?php echo $data[0]['nama_cabang']?>"></input>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>Provinsi</label></span>
																</td>
																<td>
																	<select id="provinsisetupsms" name="provinsisetup" class="form-control select2 " style="width:300px;" required="required" onchange="provinsisetup()">
																		<option value="" > Pilih  </option>
																		<?php foreach ($propinsi as $k) { 
																		$s='';
																	    if ($k['prov_id']==$data[0]['province_id']) {
																			$s='selected';
																		}?>
																		<option value="<?php echo $k['prov_id'] ?>" <?= $s?>><?php echo $k['prov_name'] ?></option>
																		<?php } ?>
																	</select>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>Kota</label></span>
																</td>
																<td>
																	<select id="kotasetupsms" name="kotasetup" class="form-control select2" style="width:300px;" required="required">
																		<option value="" > Pilih  </option>
																		<?php foreach ($citi as $k) { 
																		$s='';
																	    if ($k['city_id']==$data[0]['city_id']) {
																			$s='selected';
																		}?>
																		<option value="<?php echo $k['city_id'] ?>" <?= $s?>><?php echo $k['city_name'] ?></option>
																		<?php } ?>
																	</select>
																</td>
															</tr>
															<tr>
																<td style="width: 10%">
																	<span><label>Alamat</label></span>
																</td>
																	<td style="width: 60%">
																	<input class="form-control capital" style="width: 300px" type="text" id="alamatcabangsms" name="alamatcabang" placeholder="Masukkan Alamat" value="<?php echo $data[0]['address']?>" ></input>
																</td>
															</tr>
													</table>
												</div>
											</div>
										</div>
									<div class="col-md-12 pull-left">
										<button onclick="SaveEditCabangsms(<?php echo $data[0]['cabang_id']?>)" type="button" class="btn btn-success pull-left" style="margin-top: 10px; margin-bottom: 20px; margin-left: 20px;" > <i class="fa fa-edit"></i> Save </button>
									</div>
								<div class="col-md-1 pull-right">
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
