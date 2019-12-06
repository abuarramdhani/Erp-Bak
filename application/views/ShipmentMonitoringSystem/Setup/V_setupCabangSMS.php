<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
	.capital{
    text-transform: uppercase;
}

thead.cabang tr th {
	background-color: #00a65a;
}

</style>

<?php $button = $cabang[0]['nama_cabang'];
$disAble = "";
if ($button == 'NON CABANG') {
	$disAble = 'disable';
}
?>
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span style="font-family: sans-serif;"><b><i class="fa fa-gear"></i> Setup Cabang</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-success">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="box box-success box-solid">
									<div class="box-body">
										<div class="col-md-12">
											<table id="filter"
												class="col-md-12" style="margin-bottom: 20px">
													<tr>
																<td style="width: 10%">
																	<span><label>Nama Cabang</label></span>
																</td>
																<td style="width: 40%">
																	<input class="form-control capital" style="width: 300px" type="text" id="cabangname" name="cabangname" placeholder="Masukkan nama cabang"></input>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>Provinsi</label></span>
																</td>
																<td> 
																	
																	<select id="provinsi" name="provinsi" class="form-control select2 select2-hidden-accessible provinsi_cabang" onchange="selectKotaSetup()" style="width:300px;" required="required" >
																		<option value="" > PILIH PROVINSI  </option>
																		<?php foreach ($propinsi as $k) { ?>
																		<option value="<?php echo $k['prov_id'] ?>"><?php echo $k['prov_name'] ?></option>
																		<?php } ?>
																	</select>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>Kota</label></span>
																</td>
																<td>
																	<select id="kota" name="kota" class="form-control select2 select2-hidden-accessible kota_cabang" style="width:300px;" required="required">
																		<option value="" > PILIH KOTA  </option>
																		<?php foreach ($kota as $k) { ?>
																		<option value="<?php echo $k['city_id'] ?>"><?php echo $k['city_name'] ?></option>
																		<?php } ?>
																	</select>
																</td>
															</tr>
															<tr>
																<td style="width: 10%">
																	<span><label>Alamat</label></span>
																</td>
																	<td style="width: 60%">
																	<textarea class="form-control capital" style="width: 300px" type="text" id="alamatcabang" name="alamatcabang" placeholder="Masukkan Alamat" ></textarea>
																</td>
															</tr>
													</table>
												</div>
											</div>
										</div>
									<div class="col-md-12 pull-right">
										<button onclick="SaveCabangSMS($(this))" type="button" class="btn btn-success pull-right" style="margin-top: 10px; margin-bottom: 20px; margin-left: 20px;" > <i class="fa fa-plus"></i> Add</button>
									</div>
									<table class="table table-bordered table-hover text-center tb_setup_sms">
										<thead class="cabang">
											<tr class="bg-primary">
												<th style="width: 5%"class="text-center">No.</th>
												<th style="width: 25%" class="text-center">NAMA CABANG</th>
												<th style="width: 10%" class="text-center">PROVINSI</th>
												<th style="width: 15%" class="text-center">KABUPATEN/KOTA</th>
												<th style="width: 35%" class="text-center">ALAMAT</th>
												<th style="width: 15%" class="text-center">ACTION</th>
											</tr>
										</thead>
										<tbody>
											<?php $no=1; 
										 foreach($cabang as $key => $p) { ?>
											<tr>
												<td><?php echo $no ?></td>
												<td><?php echo $p['nama_cabang']; ?></td>
												<td><?php echo $p['province_name'];?></td>
												<td><?php echo $p['city_name'];?></td>
												<td><?php echo $p['address'];?></td>
												<td>
												<?php if ($p['cabang_id'] == '2') { ?>
												<a title = "edit ..." rownum ="<?php echo $no ?>" class ="btn btn-warning btn-sm"disabled><i class="fa fa-hand-pointer-o"></i></a>
												<a title = "delete ..." rownum ="<?php echo $no ?>" class="btn btn-danger btn-sm" onclick="DeleteRowCabangSMS(<?php echo $p['cabang_id'];?>)" disabled><i class="fa fa-trash"></i></a>
												<?php } else if ($p['cabang_id'] !== '2') { ?>
												<a title="edit ..." rownum="<?php echo $no ?>" class="btn btn-warning btn-sm" data-target="MdlSetupCbgSMS" data-toggle="modal" onclick="OpenModalCabangSMS(<?php echo $p['cabang_id'];?>)"><i class="fa fa-hand-pointer-o"></i></a>
												<a title="delete ..." rownum="<?php echo $no ?>" class="btn btn-danger btn-sm" onclick="DeleteRowCabangSMS(<?php echo $p['cabang_id'];?>)"><i class="fa fa-trash"></i></a>
												<?php } ?>
											</td>
											</tr>
											<?php $no++; } ?>
										</tbody>
									</table>
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

<!-- <div class="modal fade MdlSetupCbg"  id="MdlSetupCbg" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:1150px;" role="document">
        <div class="modal-content">
            <div class="modal-header" style="width: 100%;" >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
                <div class="modal-body" style="width: 100%;">
                	<div class="modal-tabel" >
					</div>
                   
                    	<div class="modal-footer">
                    		<div class="col-md-2 pull-left">
                    		</div>
                    	</div>
                </div>
            </form>
        </div>
    </div>
</div> -->

<div class="modal fade MdlSetupCbgSMS"  id="MdlSetupCbgSMS" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
            <div class="modal-body" style="width: 100%;">
                <div class="modal-tabel" >
				</div>
            </div>
        </div>
    </div>
</div>