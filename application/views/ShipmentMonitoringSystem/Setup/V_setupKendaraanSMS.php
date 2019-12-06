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
							<span style="font-family: sans-serif;"><b><i class="fa fa-gear"></i> Setup Kendaraan</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-danger">
						<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="box box-danger box-solid">
									<div class="box-body">
										<div class="col-md-12">
											<table id="filter"
												class="col-md-12" style="margin-bottom: 20px">
													<tr>
																<td style="width: 10%">
																	<span><label> Nama Kendaraan</label></span>
																</td>
																<td style="width: 40%">
																	<input class="form-control capital" style="width: 300px" type="text" id="jk_sms" name="jk_sms" placeholder="masukkan kendaraan"></input>
																</td>
															</tr>
															<tr>
																<td style="width: 10%">
																	<span><label> Volume Kendaraan cm<sup>3</sup></label></span>
																</td>
																<td style="width: 40%">
																	<input class="form-control capital" style="width: 300px" type="text" id="volume_jk_sms" name="volume_jk_sms" placeholder="masukkan volume"></input>
																</td>
															</tr>
													</table>
												</div>
											</div>
										</div>
									<div class="col-md-12 pull-left">
										<button onclick="saveSetupVehicleSMS($(this))" type="button" class="btn btn-success pull-right" style="margin-top: 10px; margin-bottom: 20px; margin-left: 20px;" > <i class="fa fa-check"></i> Save</button>
									</div>
									<div class="col-md-12">
								<table class="table vehicle cell-border table-bordered table-hover text-center tb_setup_sms">
										<thead class ="vehicle">
											<tr class="bg-primary">
												<th style="width: 5%;"class="text-center">NO.</th> 
												<th style="width: 30%;"class="text-center">NAMA KENDARAAN</th>
												<th style="width: 20%;" class="text-center">MUATAN</th>
												<th style="width: 35%;display: none;" class="text-center">VEHICLE ID</th>
												<th style="width: 10%;"class="text-center">ACTION</th>
											</tr>
										</thead>
										<tbody>
											<?php $no=1; 
										 foreach($vehicle as $key => $p) { ?>
											<tr>
												<td><?php echo $no ?></td>
												<td><?php echo $p['vehicle_name']; ?></td>
												<td><?php echo $p['volume_cm3']; ?></td>
												<td class="v_id" style="display: none;"><?php echo $p['vehicle_id'];?></td>
												<td>
												<a title="edit ..." rownum="<?php echo $no ?>" class="btn btn-warning btn-sm" data-target="mdlVehiclesms" data-toggle="modal" onclick="OpenModalUVsms(<?php echo $p['vehicle_id'];?>,'vehicle')"><i class="fa fa-hand-pointer-o"></i></a>
												<a title="delete ..." rownum="<?php echo $no?>" class="btn btn-danger btn-sm" onclick="DeleteRowVehiclesms(<?php echo $p['vehicle_id'];?>)"><i class="fa fa-trash"></i></a></td>
											</tr>
											<?php $no++; } ?>
										</tbody>
									</table>
						</div>
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

<div class="modal fade mdlVehiclesms"  id="mdlVehiclesms" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
            <div class="modal-body" style="width: 100%;">
                <div class="modal-tabel" >
				</div>
            </div>
        </div>
    </div>
</div>


