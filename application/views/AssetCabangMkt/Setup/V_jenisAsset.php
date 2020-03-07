<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-8">
						<div class="col-lg-8">
							<div class="text-left">
								<span><h3><b>Setup</b> - Jenis Asset</h3></span>
							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-md-8">
						<div class="box box-default box-solid">
							<div style="padding-top: 20px;" class="box-header with-border">
							</div>
								<div class="box-body">
									<div class="col-md-12">
										<table  id="filter" class=" tblResponsive" style="margin-bottom: 20px">
											<tr>
												<td style="width: 20%;padding-left: 0px">
													<span><b>Nama Jenis Asset</b></span>
												</td>
												<td style="width:35%; padding: ">
														<input type="text" style="width:300px" class="form-control" id="txtSetupJenisAset">
												</td>
												<td style="width:45%; padding: ">
													<button type="button" class="btn btn-success btn-sm"  style="width: 100px" id="btnSubmitSetup" onclick="saveSetupJA(this)" ><i class="fa fa-check"></i> Save </button> 
												</td>
											</tr>
										</table>
								<table class="table table-striped table-bordered table-hover text-center" id="tblSetupJAYeu" style="font-size:14px;">
										<thead>
											<tr style="background-color: #d2d6de; color:black;" class="bg-primary">
												<th width="5%"><center>No</center></th>
												<th style="display: none">ID</th>
												<th width="15%"><center>Jenis Asset</center></th>
												<th width="10%"><center>Action</center></th>
											</tr>
										</thead>
										<tbody id="tambahJA">
											<?php $i=1; foreach ($ja as $k) {?>
												<tr class="<?= $k['id_ja']?>">
													<td class="no"><?= $i;?></td>
													<td style="display: none"><input type="hidden" id="hdnIDAC" value="<?= $k['id_ja']?>"></td>
													<td class="ini_ya"><?= $k['nama_ja'];?></td>
													<td>
														<button type="button" onclick="deleteJA(this)" class="btn btn-sm btn-danger" style="width:100px;margin-right: 5px"><i class="fa fa-trash"></i> Delete</button>
														<button type="button" data-target="#mdlJenisAsset" data-toggle="modal" class="btn btn-sm btn-primary" onclick="openModalJA(<?php echo $k['id_ja']?>)" style="width:100px"><i class="fa fa-pencil"></i> Edit</button>
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

<!-- <div class="modal fade mdlJenisAsset"  id="mdlJenisAsset" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
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
                   
                      <div class="modal-footer">
                        <div class="col-md-2 pull-left">
                        </div>
                      </div> 
                </div>
            </form>
        </div>
    </div>
</div>-->

<div class="modal fade mdlJenisAsset"  id="mdlJenisAsset" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
            <div class="modal-body" style="width: 100%;">
                <div class="modal-tabel" >
				</div>
            </div>
        </div>
    </div>
</div>
