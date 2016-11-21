<section class="content-header">
	<h1>
		Input Jumlah Pekerja
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">	
			<div class="box box-primary">
				<div class="box-body with-border">
					<form method="post" action="<?php echo base_url('ItemManagement/User/InputPekerja/insert') ?>">
						<div class="form-group">
							<div class="row">
								<div class="col-lg-12">
									<div class="row" style="margin: 10px 10px">
										<label class="col-lg-2 control-label">PERIODE/TANGGAL</label>
										<div class="col-lg-4">
											<input type="text" class="form-control text-uppercase im-datepicker" style="width: 100%" placeholder="DETAIL BARANG" name="txt_periode" value="" required></input>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<label class="col-lg-2 control-label">KODESIE</label>
										<div class="col-lg-4">
											<input type="text" class="form-control" style="width: 100%" placeholder="KODESIE" name="txt_kodesie" value="<?php echo $user_kodesie ?>" required readonly></input>
										</div>
										<div class="col-lg-6">
											<button type="submit" class="btn btn-primary">SAVE</button>
											<button class="btn btn-primary" onclick="window.history.back()">BACK</button>
											<button type="button" onclick="addNewForm()" class="btn btn-primary"><i class="fa fa-plus"></i> ADD NEW FORM</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-10 col-lg-offset-1">
								<div id="table-item">
									<table class="table table-bordered">
										<thead class="bg-primary">
											<tr>
												<td width="75%" align="center">PEKERJAAN</td>
												<td width="20%" align="center">JUMLAH</td>
												<td width="5%" align="center">#</td>
											</tr>
										</thead>
										<tbody id="multiple-form">
											<tr class="form-clone">
												<td>
													<select name="txt_kdpekerjaan[]" class="form-control slcKodePkj" data-placeholder="PEKERJAAN" style="width: 100%" required>
													</select>
												</td>
												<td>
													<input type="text" name="txt_jumlah[]" onkeypress="return isNumberKey(event)" class="form-control" placeholder="JUMLAH" style="width: 100%" required>
												</td>
												<td align="center">
													<button type="button" class="btn btn-primary btn-sm delete-form"><i class="fa fa-minus"></i></button>
												</td>
											</tr>
										</tbody>
									</table>
									<div class="alert alert-danger flyover flyover-top">
										<span style="float: right;cursor:pointer" onclick="$('.flyover-top').removeClass('in')">
											<b style="color: #fff;">&times;</b>
										</span>
										<b class="alert-text"></b>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>