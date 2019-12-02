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
}
 .itsunit {
        border-top-color: #f5a442;
      }
  .box.mawang {
border-top-color: #f5a442;
  }
</style>

<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span style="font-family: sans-serif;"><b><i class="fa fa-gear"></i> Setup Unit</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box itsunit">
						<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="box box-warning box-solid">
									<div class="box-body">
										<div class="col-md-12">
											<table id="filter"
												class="col-md-12" style="margin-bottom: 20px">
															<tr>
																<td style="width: 10%">
																	<span><label>Nama Unit</label></span>
																</td>
																	<td style="width: 60%">
																	<input class="form-control capital" style="width: 300px" type="text" id="goods_name_set" name="goods_name_set" placeholder="masukkan nama unit" ></input>
																</td>
													</tr>
													<tr>
																<td style="width: 10%">
																	<span><label>Volume Unit (Cm<sup>3</sup>) </label></span>
																</td>
																	<td style="width: 60%">
																	<input type="number" class="form-control capital" style="width: 300px" type="text" id="volume_unit" name="volume_unit" placeholder="masukkan volume unit" ></input>
																</td>
													</tr>
													</table>
												</div>
											</div>
										</div>
									<div class="col-md-12 pull-left">
										<button onclick="saveSetupUnitSMS($(this))" type="button" class="btn btn-success pull-right" style="margin-top: 10px; margin-bottom: 20px; margin-left: 20px;" > <i class="fa fa-check"></i> Save</button>
									</div>
									<div class="col-md-12">
								<table class="table vehicle cell-border table-bordered table-hover text-center tblMPM">
										<tbody id="tabelvehicleumum">
											<thead class ="unit">
											<tr class="bg-primary">
												<th style="width: 5%"class="text-center">NO.</th> 
												<th style="width: 35%" class="text-center">NAMA UNIT</th>
												<th style="width: 35%" class="text-center">VOLUME CM <sup>3</sup></th>
												<th style="width: 15%; display: none;"class="text-center">Unit ID</th>
												<th style="width: 10%"class="text-center">ACTION</th>
											</tr>
											</thead>
											<?php $no=1; 
										 foreach($goods as $key => $l) { ?>
										 	<tr>
												<td><?php echo $no ?></td>
												<td><?php echo $l['goods_name']; ?></td>
												<td><?php echo $l['volume_cm3']; ?></td>
												<td style="display: none;"><?php echo $l['good_id'];?></td>
												<td>
												<a title="edit ..." rownum="<?php echo $no ?>" class="btn btn-warning btn-sm" data-target="mdlGoods" data-toggle="modal" onclick="OpenModalGoods(<?php echo $l['goods_id'];?>)"><i class="fa fa-hand-pointer-o"></i></a>
												<a title="delete ..." rownum="<?php echo $no ?>" class="btn btn-danger btn-sm" onclick="DeleteRowGoods(<?php echo $l['goods_id'];?>)"><i class="fa fa-trash"></i></a>
												</td>
											<?php $no++; } ?>
											</tr>
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

<div class="modal fade mdlGoods"  id="mdlGoods" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
            <div class="modal-body" style="width: 100%;">
                <div class="modal-tabel" >
				</div>
            </div>
        </div>
    </div>
</div>


