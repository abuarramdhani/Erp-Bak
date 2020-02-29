<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<style type="text/css">
	.capitalize{
    text-transform: uppercase;
		}
</style>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-left">
						<h1><b>Setup Organizations</b></h1>
						</div>
					</div>
				</div>
			</div>
			<br />
			
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-body">
						<div class="table-responsive" style="overflow:hidden;">
							<br />
							<table class="table" style="width:100%">
								<tr>
									<td><span><label>Provinsi</label></span></td>
									<td>
										<select required id="slcProvinsi" class="form-control select4" style="width:300px" onchange="province_filter(this)" name="slcProvinsi" class="form-control">
										<option value=""></option>
										<?php $no = 0; foreach($province as $src) { $no++ ?>
										<?php echo '<option value="'.$src['province_id'].'">'.$src['province_name'].'</option>' ?>
										<?php } ?> 
										</select>
									</td>
									<td><span><label>Organization Code</label></span></td>
									<td>
										<input required placeholder="Masukkan Organization Code" type="text" class="form-control capitalize" name="txtOrgID" id="org_code" style="width: 300px;">
									</td>
								</tr>

								<tr>
									<td><span><label>Kota/Kabupaten</label></span></td>
									<td>
										<select required id="slcKotaKab" style="width:300px" class="form-control select4" onchange="kotakab_filter(this)" name="slcKotaKab" class="form-control">
										<option value=""></option>
										
										</select>
									</td>

									<td><span><label>Organization ID</label></span></td>
									<td>
										<input required placeholder="Masukkan Organization ID" type="text" class="form-control capitalize" name="txtOrgID" id="org_id" style="width: 300px;">
									</td>
								</tr>

								<tr>
									<td><span><label>Kecamatan</label></span></td>
									<td>
										<select required id="slcKecamatan" style="width:300px" class="form-control select4" onchange="district_filterr(this)" name="slcKecamatan" class="form-control">
										<option value=""></option>
										
										</select>
									</td>
									<td><span><label>Organization Name</label></span></td>
									<td>
										<input required placeholder="Masukkan Organization Name" type="text" class="form-control capitalize" name="txtOrgID" id="org_name" style="width: 300px;">
									</td>
								</tr>

								<tr>
									<td><span><label>Kelurahan/Desa</label></span></td>
									<td>
										<select required style="width:300px" id="slcKelurahanDesa" class="form-control select4" name="slcKelurahanDesa" class="form-control">
										<option value=""></option>
										
										</select>
									</td>

									<td><span><label>Alamat</label></span></td>
									<td>
										<textarea required placeholder="Masukkan Alamat" class="form-control" id="alamat_id" name="txaAlamat" style="width:300px"></textarea>
									</td>

									<td><button type="button" onclick="addRowSetupSM(this)" class="btn btn-m btn-success" id="btnsubmit" style="width:100px;margin-top:22px;"><i class="fa fa-check"></i> Add</td>
								</tr>
							</table>
							<table  class="table table-striped table-bordered table-hover" id="dataTables-customer" style="font-size:12px;">
								<thead>
									<tr class="bg-primary">
										<th width="5%" class="text-center">NO</th>
										<th width="10%" class="text-center">PROVINSI</th>
										<th width="10%" class="text-center">KABUPATEN/KOTA</th>
										<th width="10%" class="text-center">KECAMATAN</th>
										<th width="10%" class="text-center">KELURAHAN</th>
										<th width="10%" class="text-center">ORGANIZATION CODE</th>
										<th width="10%" class="text-center">ORGANIZATION ID</th>
										<th width="10%" class="text-center">ORGANIZATION NAME</th>
										<th width="30%" class="text-center">ALAMAT</th>
										<th width="10%" class="text-center">ACTION</th>
									</tr>
								</thead>
								<tbody id="tbodySetupSM">
									<?php $no = 0; foreach($org as $o) { $no++ ?>
										 <tr class="<?php echo $o['org_id'] ?>">
											<td class="text-center"><?php echo $no; ?></td>
											<td class="text-center"><?php echo $o['province_name'] ?></td>
											<td class="text-center"><?php echo $o['regency_name'] ?></td>
											<td class="text-center"><?php echo $o['district_name'] ?></td>
											<td class="text-center"><?php echo $o['village_name'] ?></td>
											<td class="text-center"><?php echo $o['org_code'] ?></td>
											<td class="text-center"><?php echo $o['org_id'] ?></td>
											<td class="text-center"><?php echo $o['org_name'] ?></td>
											<td class="text-left"><?php echo $o['address'] ?></td>
											<td class="text-center">
												<button onclick="deleteeeRow(<?php echo $o['org_id'] ?>)" type="button" class="btn btn-sm btn-danger" style="width:100px"><i class="fa fa-times"></i> Delete</button>
												<button type="button" data-target="#mdlOrgSM" data-toggle="modal" onclick="openDetailOrg(<?php echo $o['org_id'] ?>)" class="btn btn-sm btn-warning" style="width:100px;margin-top: 5px"><i class="fa fa-external-link"></i> Edit</button>
											</td>
										</tr> 
									<?php } ?>
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

<div class="modal fade mdlOrgSM"  id="mdlOrgSM" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:1300px;" role="document">
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
</div>	
