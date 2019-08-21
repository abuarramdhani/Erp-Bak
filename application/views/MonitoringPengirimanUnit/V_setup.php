<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
	.capital{
    text-transform: uppercase;
}
thead.vehicle tr th {
  background-color: #bd3735;
}
thead.unit  tr th{
  background-color: #f5a442;
;
}
</style>

<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b><i class="fa fa-gear"></i> Setup Umum</b></span>
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
																<td style="width: 10%">
																	<span><label>Setup Kendaraan</label></span>
																</td>
																<td style="width: 40%">
																	<input class="form-control capital" style="width: 300px" type="text" id="set_jk" name="set_jk" placeholder="masukkan kendaraan"></input>
																</td>
															</tr>
															<tr>
																<td style="width: 10%">
																	<span><label>Setup Unit</label></span>
																</td>
																	<td style="width: 60%">
																	<input class="form-control capital" style="width: 300px" type="text" id="set_unit" name="set_unit" placeholder="masukkan unit" ></input>
																</td>
													</tr>
													</table>
												</div>
											</div>
										</div>
									<div class="col-md-12 pull-left">
										<button onclick="saveSetup($(this))" type="button" class="btn btn-success pull-right" style="margin-top: 10px; margin-bottom: 20px; margin-left: 20px;" > <i class="fa fa-check"></i> Save</button>
									</div>
								<div class="col-md-12">
								<table class="table vehicle cell-border table-bordered table-hover text-center tblMPM">
										<thead class ="vehicle">
											<tr class="bg-primary">
												<th style="width: 3%"class="text-center">NO.</th> 
												<th style="width: 35%"class="text-center">CEK KENDARAAN</th>
												<th style="width: 35%; display: none;"class="text-center">Vehicle ID</th>
												<th style="width: 10%"class="text-center">ACTION</th>
											</tr>
										</thead>
										<tbody id="tabelvehicleumum">
											<?php $noA=1; 
										 foreach($vehicle as $key => $p) { ?>
											<tr>
												<td><?php echo $noA ?></td>
												<td class="v_name"><?php echo $p['name']; ?></td>
												<td class="v_id" style="display: none;"><?php echo $p['vehicle_type_id'];?></td>
												<td>
												<a title="edit ..." rownum="<?php echo $noA ?>" class="btn btn-warning btn-sm" data-target="mdlVehicle" data-toggle="modal" onclick="OpenModalUV(<?php echo $p['vehicle_type_id'];?>,'vehicle')"><i class="fa fa-hand-pointer-o"></i></a>
												<a title="delete ..." rownum="<?php echo $noA ?>" class="btn btn-danger btn-sm" onclick="DeleteRowVehicle(<?php echo $p['vehicle_type_id'];?>)"><i class="fa fa-trash"></i></a></td>
											</tr>
											<?php $noA++; } ?>
											<thead class ="unit">
											<tr class="bg-primary">
												<th style="width: 3%"class="text-center">NO.</th> 
												<th style="width: 35%" class="text-center">CEK UNIT</th>
												<th style="width: 35%; display: none;"class="text-center">Unit ID</th>
												<th style="width: 10%"class="text-center">ACTION</th>
											</tr>
											</thead>
											<?php $noB=1; 
										 foreach($unit as $key => $l) { ?>
										 	<tr>
												<td><?php echo $noB ?></td>
												<td class="u_name"><?php echo $l['name']; ?></td>
												<td style="display: none;"><?php echo $l['unit_id'];?></td>
												<td>
												<a title="edit ..." rownum="<?php echo $noB ?>" class="btn btn-warning btn-sm" data-target="mdlUnit" data-toggle="modal" onclick="OpenModalUV(<?php echo $l['unit_id'];?>,'unit')"><i class="fa fa-hand-pointer-o"></i></a>
												<a title="delete ..." rownum="<?php echo $noB ?>" class="btn btn-danger btn-sm" onclick="DeleteRowUnit(<?php echo $l['unit_id'];?>)"><i class="fa fa-trash"></i></a></td>
											<?php $noB++; } ?>
											</tr>
										</tbody>
									</table>
								</center>
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

<div class="modal fade mdlVehicle"  id="mdlVehicle" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
            <div class="modal-body" style="width: 100%;">
                <div class="modal-tabel" >
				</div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade mdlUnit"  id="mdlUnit" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
            <div class="modal-body" style="width: 100%;">
                <div class="modal-tabel" >
				</div>
            </div>
        </div>
    </div>
</div>
