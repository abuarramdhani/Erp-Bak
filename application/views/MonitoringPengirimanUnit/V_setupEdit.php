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
							<span><b><i class="fa fa-gear"></i> Edit Cabang</b></span>
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
																<td style="width: 5%">
																	<span><label>Nama Cabang</label></span>
																</td>
																<td style="width: 40%">
																	<input class="form-control capital" style="width: 300px" type="text" id="cabangnamename" name="cabangname" value="<?php echo $data[0]['name'] ?>"></input>
																</td>
															</tr>
															<tr>																<td style="width: 5%">
																	<span><label>Alamat</label></span>
																</td>
																	<td style="width: 40%">
																	<input type="form" class="form-control capital entercbg" style="width: 300px" type="text" id="alamatcabangcabang" name="alamatcabangedit" value="<?php echo $data[0]['alamat'] ?>"></input>
																</td>
															</tr>
													</table>
												</div>
											</div>
										</div>
									<div class="col-md-12 pull-left">
										<button onclick="SaveEditCabang(<?php echo $data[0]['cabang_id']?>)" type="button" class="btn btn-success pull-left" style="margin-top: 10px; margin-bottom: 20px; margin-left: 20px;" > <i class="fa fa-edit"></i> Save </button>
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
