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
						<div class="col-lg-12">
							<div class="text-left">
								<span><h2><b>Super User</b> - Atur Admin Cabang</h2></span>
							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-md-12">
						<div class="box box-default box-solid">
							<div style="padding-top: 20px;" class="box-header with-border">
							</div>
								<div class="box-body">
									<div class="col-md-12">
										<table  id="filter" class=" tblResponsive" style="margin-bottom: 20px">
											<tr>
												<td style="width: 20%;padding-left: 20px">
													<span><b>Cari User</b></span>
												</td>
												<td style="width:35%; padding: ">
													<input type="text" style="width:300px" class="form-control capital" id="txtNomorIndukAC">
												</td>
												<td style="width:45%; padding-left:10px ">
													<button type="button" class="btn btn-primary btn-sm"  style="width: 100px;margin-left: 10px" id="btnSubmitSetup" onclick="cariNomorInduk(this)" ><i class="fa fa-check"></i> Cari </button> 
												</td>
											</tr>
											<tr>
												<td style="width: 20%;padding-left: 20px;padding-top: 10px;">
													<span><b>Nama User</b></span>
												</td>
												<td style="width:35%; padding-top: 10px;">
													<input type="text" disabled style="width:300px" class="form-control" id="txtNamaUserAC">
											</tr>
											<tr>
												<td style="width: 20%;padding-left: 20px;padding-top: 10px;">
													<span><b>Nama Seksi</b></span>
												</td>
												<td style="width:35%; padding-top: 10px;">
													<input type="text" disabled style="width:300px" class="form-control" id="txtSectionName">
											</tr>
											<tr>
												<td style="width: 20%;padding-top: 10px;padding-left: 20px">
													<span><b>Asal Cabang</b></span>
												</td>
												<td style="padding-top: 10px;">
													<select id="slcAsalCabangSU" name="slcAsalCabangSU" class="form-control select2 select2-hidden-accessible capital" style="width:300px;" required="required">
						                                    <option value="" > Pilih Asal Cabang </option>
						                                    <?php foreach ($cbg as $k) { ?>
						                                    <option value="<?php echo $k['branch_code'] ?>"><?php echo $k['nama_cabang'] ?>
						                                    </option>
						                                    <?php } ?>
                  									</select>
												</td>
												<td style="width:45%; padding-left:10px;padding-top: 10px;">
													<button type="button" class="btn btn-success btn-sm"  style="width: 100px;margin-left: 10px" id="btnSubmitSetup" onclick="saveSuperUser(this)" ><i class="fa fa-check"></i> Save </button> 
												</td>
											</tr>
										</table>
							<div class="col-md-12" style="margin-top: 100px">
								<table class="table table-responsive table-striped table-bordered table-hover text-center" id="tblACLDAO" style="font-size:14px;width:100%">
										<thead>
											<tr style="background-color: #d2d6de; color:black;" class="bg-primary">
												<th width="5%"><center>No</center></th>
												<th style="display: none">ID</th>
												<th width="15%"><center>Nomor Induk</center></th>
												<th width="15%"><center>Nama Pekerja</center></th>
												<th width="15%"><center>Kode Cabang</center></th>
												<th width="15%"><center>Section Name</center></th>
												<th width="10%"><center>Action</center></th>
											</tr>
										</thead>
										<tbody id="tambahJA">
											<?php $i=1; foreach ($ss as $k) {?> 
												<tr class="<?= $k['id_user']?>" >
													<td class="no"><?= $i;?></td>
													<td style="display: none"><input type="hidden" id="hdnIDAC" value="<?= $k['id_user']?>"></td>
													<td><?= $k['no_induk'];?></td>
													<td><?= $k['nama_user'];?></td>
													<td><?= $k['kode_cabang'];?></td>
													<td><?= $k['section_name'];?></td>
													<td>
														<button type="button" onclick="deleteSU(<?= $k['id_user']?>)" class="btn btn-sm btn-danger" style="width:100px;margin-bottom: 5px"><i class="fa fa-trash"></i> Delete</button>
														<button type="button" data-target="#mdlSuperUser" data-toggle="modal" class="btn btn-sm btn-primary" onclick="openEditSU(<?php echo $k['id_user']?>)" style="width:100px"><i class="fa fa-pencil"></i> Edit</button>
													</td>
												</tr>
											<?php $i++;} ?> 
													
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
<script type="text/javascript">
	$( document ).ready(function() {
	$('#tblACLDAO').DataTable({
		"pageLength": 50
	});
})
</script>

<div class="modal fade mdlSuperUser"  id="mdlSuperUser" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-sm" style="width:600px;" role="document">
        <div class="modal-content" style="height: 50%">
            <div class="modal-header" style="width: 100%;" >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
                <div class="modal-body" style="width: 100%;">
                  <div class="modal-tabel" >
          </div>
                   
                      <!-- <div class="modal-footer">
                        <div class="col-md-2 pull-left">
                        </div>
                      </div> -->
                </div>
            </form>
        </div>
    </div>
</div>
