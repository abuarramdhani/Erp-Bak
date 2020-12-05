<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12 ">
						<h2><b><?=$Title ?></b></h2>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form method="post" class="form-horizontal" id="ovpfrmgetovp" enctype="multipart/form-data">
		                                    <div class="panel-body">
		                                        <div class="row">
		                                            <div class="form-group">
		                                                <label for="txtTanggalRekap" class="control-label col-lg-4">Tanggal Rekap</label>
		                                                <div class="col-lg-6">
		                                                    <input type="text" name="txtTanggalRekap" class="RekapAbsensi-daterangepicker form-control" />
		                                                </div>
		                                            </div>
		                                            <div class="form-group">
		                                            	<label class="control-label col-lg-4">Status Hubungan Kerja</label>
														<div class="col-lg-6">
															<select id="er-status" data-placeholder="Status Hubungan Kerja" class="form-control select2" style="width:100%" name ="statushubker[]" required multiple="multiple">
																<option value=""><option>
																	<!-- <option value="All">ALL</option> -->
																	<?php foreach ($status as $status_item){
																		?>
																		<option value="<?php echo $status_item['fs_noind'];?>"><?php echo $status_item['fs_noind'].' - '.$status_item['fs_ket'];?></option>
																		<?php } ?>
															</select>
														</div>
														<div class="col-lg-1">
															<label style="margin-top: 5px" class="pull-center">
																<input class="azek" type="checkbox" id="er_all" class="form-control" name="statusAll" value="1">
																ALL
															</label>
														</div>
													</div>
		                                            <div class="form-group">
		                                                <label for="cmbDepartemen" class="control-label col-lg-4">Departemen</label>
		                                                <div class="col-lg-6">
		                                                    <select name="cmbDepartemen" id="ovpslcdept" data-placeholder="Departement" class="select2" style="width: 100%" required="">
		                                                    	<option selected="" value="<?= substr($pkj['kodesie'], 0,1) ?>"><?= $pkj['dept'] ?></option>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <br/>
		                                            <div class="form-group">
		                                                <label for="cmbBidang" class="control-label col-lg-4">Bidang</label>
		                                                <div class="col-lg-6">
		                                                    <select name="cmbBidang" data-placeholder="Bidang" class="select2 RekapAbsensi-cmbBidang" style="width: 100%">
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <br/>
		                                            <div class="form-group">
		                                                <label for="cmbUnit" class="control-label col-lg-4">Unit</label>
		                                                <div class="col-lg-6">
		                                                    <select name="cmbUnit" data-placeholder="Unit" class="select2 RekapAbsensi-cmbUnit" style="width: 100%">
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <br/>
		                                            <div class="form-group">
		                                                <label for="cmbSeksi" class="control-label col-lg-4">Seksi</label>
		                                                <div class="col-lg-6">
		                                                    <select name="cmbSeksi" data-placeholder="Seksi" class="select2 RekapAbsensi-cmbSeksi" style="width: 100%">
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <div class="row" style="margin: 10px 10px;vertical-align: middle">
		                                            	<div class="col-md-7"></div>
		                                            	<div class="col-md-3">
		                                            		<div class="form-group" style="vertical-align: middle">
		                                            			<div class="checkbox">
		                                            				<label>
		                                            					<input id="toggle_button" name="detail" type="checkbox" value="1">
		                                            					Tampilkan Detail Data Overtime
		                                            				</label>
		                                            			</div>
		                                            		</div>
		                                            	</div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="panel-footer">
		                                        <div class="row text-right">
		                                            <button class="btn btn-info btn-md" type="button" id="ovpbtngetovp">
		                                                Proses
		                                            </button>
		                                        </div>
		                                    </div>
		                                </form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12" id="ovpdivrkp" style="margin-top: 20px;">
										
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
<script>
	window.addEventListener('load', function () {
		$('#ovpslcdept').trigger('change');
	});
</script>