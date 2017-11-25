<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>
<section class="content">
	<div class="inner">
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Bon Assets</b></h1>
						
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('FixedAsset/BonAssets');?>">
                                <i class="fa fa-bookmark fa-2x"></i>
                                <span ><br /></span>
                            </a>
							
						</div>
					</div>
				</div>
			</div>
			<br />
		<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb text-right">
				<li class ="active"><?php echo date('d F Y') ?></a></li>
				<li class ="active"><span id="clockbox"><?php echo date('H:i:s') ?></span></li>
				<li class ="active">Bon Assets</li>
			</ol>
		</div>
			<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						INPUT DATA ASSETS
					</div>
					
					<div class="box-body">
						<fieldset class="row2" style="background:#F8F8F8 ;">
							<form id="formReceipt" target="_blank" action="<?php echo base_url('/FixedAsset/BonAssets/output'); ?>" method="post">
								<div class="row">
									<div class="col-lg-12">
										<div class="panel-heading text-left">
											<!-- panel header -->
										</div>
										<div class="panel-body">
											<div class="col-lg-12">
												<div class="form-group" style="float: right;">
													<label>Revisi </label>
													<input type="checkbox" name="chckRev" id="chckRev">
													<br>
													<input type="text" name="txtDocNum" id="txtDocNum" readonly="readonly" value="">
													<input type="hidden" name="hdnNum" id="hdnNum" readonly="readonly" value="<?php echo $docNum; ?>">
												</div>
												<div class="form-group"><!-- No. PP / BPPBG -->
													<label for="norm" class="control-label col-lg-3">No. PP / BPPBG</label>
													<div class="col-lg-4">
														<input type="text" placeholder="No. PP / BPPBG" name="txtPpBppbg" id="txtPpBppbg" class="form-control toupper" value="<?php echo $Pp; ?>" readonly="readonly" required="required" />
													</div>
												</div><br><br>
												<div class="form-group"><!-- kode -->
													<label for="norm" class="control-label col-lg-3">Kode Barang</label>
													<div class="col-lg-4">
														<input type="text" placeholder="Kode" name="txtKode" id="txtKode" class="form-control toupper" value="<?php echo $Kode; ?>"  readonly="readonly" required="required"/>
													</div>
												</div><br><br>
												<div class="form-group"><!-- nama -->
													<label for="norm" class="control-label col-lg-3">Nama Barang</label>
													<div class="col-lg-4">
														<input type="text" placeholder="Nama" name="txtNama" id="txtNama" class="form-control toupper" value="<?php echo $Deskripsi; ?>"  readonly="readonly" required="required"/>
													</div>
												</div><br><br>
												<div class="form-group"><!-- spek -->
													<label for="norm" class="control-label col-lg-3">Spesifikasi</label>
													<div class="col-lg-4">
														<textarea name="txaSpek" placeholder="Spek" class="form-control" id="txaSpek" required="required"></textarea>
													</div>
												</div><br><br><br><br>
												<div class="form-group" id="divNgr"><!-- ngr -->
													<label for="norm" class="control-label col-lg-3">Negara Pembuat</label>
													<div class="col-lg-4">
														<input type="text" placeholder="Negara" name="txtNgr" id="txtNgr" class="form-control toupper" required="required" />
													</div>
												</div><br><br>
												<div class="form-group"><!-- qty -->
													<label for="norm" class="control-label col-lg-3">Quantity</label>
													<div class="col-lg-4">
														<input type="text" placeholder="Quantity" name="txtQty" id="txtQty" value="<?php echo $Quantity; ?>" class="form-control toupper" required="required" />
													</div>
												</div><br><br>
												<div class="form-group" id="divKva"><!-- kva -->
													<label for="norm" class="control-label col-lg-3">KVA</label>
													<div class="col-lg-4">
														<input type="text" placeholder="KVA" name="txtKva" class="form-control toupper" id="txtKva" />
													</div>
												</div><br><br>
												<div class="form-group" id="divPlat"><!-- PLAT -->
													<label for="norm" class="control-label col-lg-3">Plat</label>
													<div class="col-lg-4">
														<input type="text" placeholder="Plat" name="txtPlat" class="form-control toupper" id="txtPlat" />
													</div>
												</div><br><br>
												<div class="form-group"><!-- tgl -->
													<label class="control-label col-lg-3" for="dpDigunakan">Tgl. Digunakan</label>
													<div class="col-lg-4">
														<input type="text" maxlength="11" placeholder="<?php echo date("d-M-Y")?>" name="dpDigunakan" value="" class="form-control" data-date-format="dd-M-yyyy" id="dpDigunakan" required="required" />
													</div>
												</div><br><br>
												<div class="form-group"><!-- dll -->
													<label for="norm" class="control-label col-lg-3">Informasi Lain</label>
													<div class="col-lg-4">
														<textarea name="txaInfo" placeholder="Info" class="form-control"></textarea>
													</div>
												</div><br><br><br><br>


<!-- 												<div class="form-group" id="divTag">
													<label for="norm" class="control-label col-lg-3">Tag Number</label>
													<div class="col-lg-4">
														<input type="text" placeholder="Tag Number" name="txtTag" class="form-control toupper" id="txtTag" />
													</div>
												</div><br><br>
												<div class="form-group" id="divCost">
													<label for="norm" class="control-label col-lg-3">Cost Center</label>
													<div class="col-lg-4">
														<input type="text" placeholder="Cost Center" name="txtCost" class="form-control toupper" id="txtCost" />
													</div>
												</div><br><br>
												<div class="form-group" id="divUmur">
													<label for="norm" class="control-label col-lg-3">Umur Teknis</label>
													<div class="col-lg-4">
														<input type="text" placeholder="Umur Teknis" name="txtUmur" class="form-control toupper" id="txtUmur" />
													</div>
												</div><br><br> -->


												
											</div>
										</div>
										<div class="panel-footer"></div><!-- pembatas -->
										<div class="panel-body">
											<div class="col-lg-12">
												<div class="form-group"><!-- Seksi -->
													<label for="norm" class="control-label col-lg-3">Seksi Pemakai</label>
													<div class="col-lg-4">
														<input type="text" placeholder="Seksi" name="txtSeksi" id="txtSeksi" class="form-control toupper"  value="<?php echo $seksi[0]['section_name'] ?>" readonly="readonly" required="required"/>
													</div>
												</div><br><br>
												<div class="form-group"><!-- Kota -->
													<label for="norm" class="control-label col-lg-3">Kota</label>
													<div class="col-lg-4">
														<input type="text" placeholder="Kota" name="txtKota" id="txtKota" class="form-control toupper" required="required"  />
													</div>
												</div><br><br>
												<div class="form-group"><!-- Gedung -->
													<label for="norm" class="control-label col-lg-3">Gedung</label>
													<div class="col-lg-4">
														<input type="text" placeholder="Gedung" name="txtGedung" id="txtGedung" class="form-control toupper" required="required"  />
													</div>
												</div><br><br>
												<div class="form-group"><!-- Lantai -->
													<label for="norm" class="control-label col-lg-3">Lantai</label>
													<div class="col-lg-4">
														<input type="text" placeholder="Lantai" name="txtLantai" id="txtLantai" class="form-control toupper" required="required"  />
													</div>
												</div><br><br>
												<div class="form-group"><!-- Ruang -->
													<label for="norm" class="control-label col-lg-3">Ruang</label>
													<div class="col-lg-4">
														<input type="text" placeholder="Ruang" name="txtRuang" id="txtRuang" class="form-control toupper" required="required"  />
													</div>
												</div><br><br>
											</div>
										</div>
										<div class="panel-footer">
											<div class="row text-right">
												<button type="button" id="btnExport" class="btn btn-primary btn-lg btn-rect">EXPORT</button>
											</div>
										</div>
									</div>
								</div>
							</form>
					 	</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>
</div>
</section>