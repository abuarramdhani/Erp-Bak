<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11" style="height: 70px">
							<div class="text-right">
								<h1><b id="titleSrcFPD">Edit Improvement</b></h1>
							</div>
						</div>
						<div class="col-lg-1 " style="height: 70px">
							<div class="text-right ">
								<a class="" href="">
									<button class=" btn btn-default btn-md btnHoPg" style="border-radius: 50% !important">
										<b class="fa fa-edit fa-2x "></b>
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
								<button class="btn btn-md  btn-primary btnFrmFPDHome"><b>Edit Improvement</b></button>
							</div>
							<form enctype="multipart/form-data" method="post" action="<?= base_url('InternalAudit/MonitoringImprovement/SaveEdit') ?>">
								<input type="hidden" name="id_improvement" value="<?= $dataImprovement['id'] ?>">
							<div class="box-body" style="min-height: 350px" >
								<div class="res">
									
									<div class="col-lg-12 form-group">
											<div class="col-lg-12 form-group" >
												<div class="col-lg-4 text-right">
													<label>Seksi :</label>
												</div>
												<div class="col-lg-4 text-left">
													<select class="slc2" multiple="multiple" name="slcSeksi[]">
														<option></option>
														<?php foreach ($section_select as $key => $value) { ?>
															<option <?= (in_array($value['section_name'], $dataImprovement['seksi'])) ? 'selected' : '' ?> value="<?= $value['section_name'] ?>"><?= $value['section_name'] ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="col-lg-12 form-group" >
												<div class="col-lg-4 text-right">
													<label>Audit Object :</label>
												</div>
												<div class="col-lg-4 text-left">
													<select class="slc2" name="slcObjectAudit" >
														<?php foreach ($audit_object as $key => $value) { ?>
																<option value="<?= $value['id'] ?>" <?= $dataImprovement['audit_object']==$value['id'] ? 'selected' : '' ?>> <?= $value['audit_object'] ?></option>
															<?php } ?>
													</select>
												</div>
											</div>
											<div class="col-lg-12 form-group" >
												<div class="col-lg-4 text-right">
													<label>Period :</label>
												</div>
												<div class="col-lg-4 text-left">
													<input type="text" class="dtpc2 form-control" name="datePeriod" value="<?= $dataImprovement['period'] ?>">
												</div>
											</div>
											<div class="col-lg-12 form-group" >
												<div class="col-lg-4 text-right">
													<label>Laporan Hasil Audit Baru:</label>
												</div>
												<div class="col-lg-4 text-left">
													<table class="table table-curved">
														<tr>
															<td ><label>File lama</label></td>
															<td><a target="blank_"  href="<?= $dataImprovement['linkfileHA'] ?>"><?= $dataImprovement['fileHA'] ?></a></td>
														</tr>
														<tr>
															<td><label>File Baru</label></td>
															<td><input type="file" class="btnfile" name="fileLapAudit"></td>
														</tr>
													</table>
												</div>
											</div>
											<div class="col-lg-12 form-group" >
												<div class="col-lg-4 text-right">
													<label>Nomor Project :</label>
												</div>
												<div class="col-lg-4 text-left">
													<input type="text" class="form-control" name="txtNomorProject" value="<?= $dataImprovement['project_number'] ?>">
												</div>
											</div>
											<div class="col-lg-12 form-group" >
												<div class="col-lg-4 text-right">
													<label>Surat Tugas :</label>
												</div>
												<div class="col-lg-4 text-left">
													<table class="table table-curved">
														<tr>
															<td><label>File lama</label></td>
															<td><a  target="blank_" href="<?= $dataImprovement['linkfileST'] ?>"><?= $dataImprovement['fileST'] ?></a></td>
														</tr>
														<tr>
															<td><label>File Baru</label></td>
															<td><input type="file" class="btnfile" name="fileProjectNumber"></td>
														</tr>
													</table>
												</div>
											</div>
									</div>
								</div>
							</div>
							<div class="box-footer">
									<div class="col-lg-12">
										<center>
											<button class="btn btn-default btn-cust-f"> BACK </button>
											<button class="btn btn-success btn-cust-e" type="submit"> UPDATE </button>
										</center>
									</div>
							</div>
							</form>
						</div>
					</div>
				</div>
			</div>
	</div>
	</div>
</section>