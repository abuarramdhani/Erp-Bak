<style type="text/css">
.capital{
    text-transform: uppercase;
}
</style>

<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="text-left ">
							<span><b><i class="fa fa-gear"></i> Edit Unit</b></span>
						</div>
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
																	<span><label> Unit</label></span>
																</td>
																<td style="width: 40%">
																	<input class="form-control capital" style="width: 300px;margin-left: 10px" type="text" id="unitname" name="unitname" value="<?php echo $unit[0]['name'] ?>"></input>
																</td>
															</tr>
													</table>
												</div>
											</div>
										</div>
									<div class="col-md-12 pull-left">
										<button onclick="SaveEditUnit(<?php echo $unit[0]['id']?>)" type="button" class="btn btn-success pull-left" style="margin-top: 10px; margin-bottom: 20px; margin-left: 20px;" > <i class="fa fa-edit"></i> Save </button>
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
