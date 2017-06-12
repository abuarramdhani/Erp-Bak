<section class="content-header">
	<h1>
		New Bon
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">	
			<div class="box box-primary">
				<div class="box-body with-border">
					<form method="post" action="<?php echo base_url('ItemManagement/User/MonitoringBon/insert') ?>">
						<div class="form-group">
							<div class="row">
								<div class="col-lg-12">
									<div class="row" style="margin: 10px 10px">
										<label class="col-lg-2 control-label">KODE BLANKO</label>
										<div class="col-lg-4">
											<input type="text" class="form-control text-uppercase" style="width: 100%" placeholder="KODE BLANKO" name="txt_kode_blanko" value="<?php echo $kode_blanko; ?>" required readonly></input>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<label class="col-lg-2 control-label">PERIODE/TANGGAL</label>
										<div class="col-lg-4">
											<input type="text" class="form-control text-uppercase im-datepicker" style="width: 100%" placeholder="DETAIL BARANG" name="txt_periode" value="" required></input>
										</div>
									</div>
									<div class="row" style="margin: 10px 10px">
										<label class="col-lg-2 control-label">KODESIE</label>
										<div class="col-lg-4">
											<input type="text" class="form-control" style="width: 100%" placeholder="KODESIE" name="txt_kodesie_detail" value="<?php echo $user_kodesie_detail ?>" readonly></input>
											<input type="hidden" class="form-control" style="width: 100%" placeholder="KODESIE" name="txt_kodesie" value="<?php echo $user_kodesie ?>" required readonly></input>
										</div>
										<div class="col-lg-6">
											<button id="save-button" type="button" class="btn btn-primary" data-toggle="modal" data-target="#data-preview">SAVE</button>
											<button  type="button" class="btn btn-primary" onclick="window.history.back()">BACK</button>
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
												<td width="75%" align="center">ITEM</td>
												<td width="20%" align="center">QTY</td>
												<td width="5%" align="center">#</td>
											</tr>
										</thead>
										<tbody id="multiple-form">
											<tr class="form-clone">
												<td>
													<select name="txt_kode_barang[]" class="form-control slcBonItem" data-placeholder="ITEM" style="width: 100%" required>
													</select>
													<input type="hidden" name="txt_item_detail[]" class="form-control item-details">
												</td>
												<td>
													<input type="number" name="txt_jumlah[]" onkeypress="return isNumberKey(event)" class="form-control jumlah-bon" style="width: 100%" placeholder="QTY" required>
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
						<div class="modal fade" id="data-preview">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header bg-primary">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title">Bon Preview</h4>
									</div>
									<div class="modal-body">
										Periksa kembali data Anda. Data yang sudah di submit tidak dapat diubah.
										<table width="100%">
											<tr>
												<td width="20%">Kode Blanko</td>
												<td width="5%">:</td>
												<td width="75%" id="kode_blanko_text" style="font-weight: bold;"></td>
											</tr>
											<tr>
												<td>Periode/Tanggal</td>
												<td>:</td>
												<td id="tgl_text" style="font-weight: bold;"></td>
											</tr>
											<tr>
												<td>Kodesie</td>
												<td>:</td>
												<td id="kodesie_text" style="font-weight: bold;"></td>
											</tr>
										</table>
										<br>
										<table class="table table-bordered table-striped">
											<thead class="bg-primary">
												<tr>
													<td width="80%" align="center">ITEM</td>
													<td width="20%" align="center">QTY</td>
												</tr>
											</thead>
											<tbody class="preview-body">
												
											</tbody>
										</table>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										<button type="submit" class="btn btn-warning">Save</a>
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