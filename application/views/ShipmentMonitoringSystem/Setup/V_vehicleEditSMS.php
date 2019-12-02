<style type="text/css">
.capital{
    text-transform: uppercase;
}
</style>

<section class="content">
	<div class="inner" >
		<div class="row">
					<div class="col-lg-12">
			<div class="text-left ">
							<span style="font-family: sans-serif;"><b><i class="fa fa-gear"></i> Edit Kendaraan </b></span>
						</div>
						<div class="box box-primary box-solid">
							<div class="box-body">
								<div class="box box-primary box-solid">
									<div class="box-body">
										<div class="col-md-12">
											<table id="filter"
												class="col-md-12" style="margin-bottom: 20px">
													<tr>
																<td style="width: 40%">
																	<span><label> Nama Kendaraan</label></span>
																</td>
																<td style="width: 40%">
																	<input class="form-control capital" style="width: 300px" type="text" id="jk_edit" name="jk_edit" placeholder="masukkan kendaraan" value="<?php echo $vehicle[0]['vehicle_name']?>"></input>
																</td>
															</tr>
															<tr>
																<td style="width: 40%">
																	<span><label> Volume Kendaraan cm<sup>3</sup></label></span>
																</td>
																<td style="width: 40%">
																	<input class="form-control capital" style="width: 300px" type="text" id="vol_edit" name="vol_edit" placeholder="masukkan volume" value="<?php echo $vehicle[0]['volume_cm3']?>"></input>
																</td>
															</tr>
													</table>
												</div>
											</div>
										</div>
									<div class="col-md-12 pull-left">                          
										<button onclick="SaveEditVehiclesms(<?php echo $vehicle[0]['vehicle_id']?>)" type="button" class="btn btn-success pull-left" style="margin-top: 10px; margin-bottom: 20px; margin-left: 20px;" > <i class="fa fa-edit"></i> Save </button>
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
