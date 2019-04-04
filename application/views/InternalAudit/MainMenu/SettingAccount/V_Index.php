<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11" style="height: 70px">
							<div class="text-right">
								<h1><b id="titleSrcFPD">Setting Audit Object</b></h1>
							</div>
						</div>
						<div class="col-lg-1 " style="height: 70px">
							<div class="text-right ">
								<a class="" href="">
									<button class=" btn btn-default btn-md btnHoPg" style="border-radius: 50% !important; width: 60px !important; height: 60px !important">
										<b class="fa fa-users fa-2x "></b>
									</button>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row" >
					<div class="col-lg-12" >
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<button class="btn btn-md  btn-primary btnFrmFPDHome"><b>List Audit Object</b></button>
								<button style="float: right;" class="btn btn-success btn-add add-new-account-ia"> Add New <b class="fa fa-plus"></b> </button>
							</div>
							<div class="box-body" style="min-height: 350px" >
								<div class="res">
									<div class="col-lg-12">
										<table class="table-curved table dtb" >
											<thead>
												<tr>
													<th width="20%">No.</th>
													<th width="50%">Audit Object</th>
													<th width="30%">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($data_audit as $key => $value) { ?>
													<tr>
														<td><?= $key+1 ?></td>
														<td><?= $value['audit_object'] ?></td>
														<td>
															<center>
															<button class="btn btn-md btn-cust-f btn-primary" data-toggle="modal" data-target="#ModDetail<?= $key ?>"> <b class="fa fa-eye"></b> Detail </button>
															<button data-id="<?= $value['id'] ?>" onclick="ShowFormEditAccount(this)" class="btn btn-md btn-info btn-cust-m" > <b class="fa fa-edit"></b> Edit </button>
															<button data-id="<?= $value['id'] ?>" data-toggle="modal" data-target="#ModDeleteAudit" class="btn btn-md btn-danger btn-cust-e" onclick="deleteAuditIa(this)"> <b class="fa fa-trash"></b> Delete </button>
															</center>
															<div class="modal fade" id="ModDetail<?= $key?>" data-id="" role="dialog" aria-labelledby="ModDetail" aria-hidden="true">
															<div class="modal-dialog" style="min-width:800px; border-radius: 20px">
																<div class="modal-content" style=" border-radius: 20px">
																  <div class="modal-header" style="background-color: #5fcdf2; border-top-right-radius: 20px; border-top-left-radius: 20px">
																  	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																  	<h4 class="modal-title"style="color: white; font-weight: bold;">Detail Object Audit</h4>
																  </div>
																  <div class="modal-body" >
																  	<table class="table-curved table table-responsive table-hover">
																  		<thead>
																  			<tr>
																  				<th>Position</th>
																  				<th>Nama</th>
																  			</tr>
																  		</thead>
																  		<tbody>
																  			<?php if ($value['pic']) { ?>
																  			<tr class="bg-warning">
																  				<td>PIC</td>
																  				<td><a class="userIa" data-id="<?= $value['pic'] ?>"><?= $value['employee_name'] ?></a></td>
																  			</tr>
																  			<?php } ?>
																  			<?php foreach ($value['staff'] as $key2 => $value2) { ?>
																  				<tr class="bg-success">
																  					<td>Staff <?= $key2+1 ?></td>
																  					<td><a class="userIa" data-id="<?= $value2['staff_id'] ?>"><?= $value2['employee_name'] ?></a></td>
																  				</tr>
																  			<?php } ?>
																  			<?php foreach ($value['auditor'] as $key3 => $value3) { ?>
																  				<tr class="bg-info">
																  					<td>Auditor <?= $key3+1 ?></td>
																  					<td><a class="userIa" data-id="<?= $value3['auditor_id'] ?>"><?= $value3['employee_name'] ?></a></td>
																  				</tr>
																  			<?php } ?>
																  		</tbody>
																  	</table>
																  </div>
																  <div class="modal-footer">
																    <button class="btn btn-md btn-default" data-dismiss="modal"> Close </button>
																  </div>
																</div>
															</div>
														</div>
														</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
									<div class="col-lg-12">
										
									</div>
								</div>
							</div>
							<div class="box-footer">
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	</div>
	
	<!--  -->
<div class="modal fade" id="ModDeleteAudit"role="dialog" aria-labelledby="ModDeleteAudit" aria-hidden="true">
	<div class="modal-dialog" style="min-width:800px; border-radius: 20px">
		<form id="formDeleteAuditIa" method="post" action="<?= base_url('InternalAudit/SettingAccount/AuditObject/DeleteAudit') ?>">
		<input type="hidden" name="id_audit" >
		<div class="modal-content" style=" border-radius: 20px">
		  <div class="modal-header" style="background-color: #dd4b39; border-top-right-radius: 20px; border-top-left-radius: 20px">
		  	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  	<h4 class="modal-title"style="color: white; font-weight: bold;">Delete Audit Object</h4>
		  </div>
		  <div class="modal-body" >
		  	<center>
		  		<b>Apakah anda Yakin?</b>
		  	</center>
		  </div>
		  <div class="modal-footer">
		    <button class="btn btn-md btn-default btn-cust-f" data-dismiss="modal"> Close </button>
		    <button class="btn btn-md btn-danger btn-cust-e" type="submit" > Delete </button>
		  </div>
		</div>
		</form>
	</div>
</div>
	<!--  -->
</section>