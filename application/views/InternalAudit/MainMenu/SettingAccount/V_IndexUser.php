<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11" style="height: 70px">
							<div class="text-right">
								<h1><b id="titleSrcFPD">Setting User</b></h1>
							</div>
						</div>
						<div class="col-lg-1 " style="height: 70px">
							<div class="text-right ">
								<a class="" href="">
									<button class=" btn btn-default btn-md btnHoPg" style="border-radius: 50% !important">
										<b class="fa fa-user fa-2x "></b>
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
								<button class="btn btn-md  btn-primary btnFrmFPDHome"><b>List User</b></button>
							</div>
							<div class="box-body" style="min-height: 350px" >
								<div class="res">
									<div class="col-lg-12">
										<table class="table table-curved dtb">
											<thead>
												<tr>
													<th>No.</th>
													<th>Name</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($user as $key => $value) { ?>
												<tr>
													<td><center><?= $key+1 ?></center></td>
													<td><?= $value['employee_name'] ?></td>
													<td>
														<center>
															<a href="<?= base_url('InternalAudit/SettingAccount/User/Detail/'.$value['user_id']) ?>">
															<button class="btn-cust-f btn btn-md btn-primary"><b class="fa fa-eye"> Detail </b></button>
															</a>
															<a href="<?= base_url('InternalAudit/SettingAccount/User/Edit/'.$value['user_id']) ?>">
															<button class="btn-cust-e btn btn-md btn-info"><b class="fa fa-edit"> Edit </b></button>
															</a>
														</center>
													</td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
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
</section>