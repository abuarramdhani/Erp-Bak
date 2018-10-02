<style type="text/css">
	.red{color:red;}
	.orange{color:orange;}
	.green{color:green;}
</style>
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b>Data Server ICT</b></h1>

							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('MonitoringICT/DataServer');?>">
									<i class="icon-desktop icon-2x"></i>
									<span ><br /></span>
								</a>
							</div>
						</div>
					</div>
					<br />
					<center>
						<di12>
							<div style="position: center; margin: auto;" align="center" class="col-lg-12">
								<div class="box box-primary box-solid">
									<div class="box-header with-border">
										Tambah Data Server
									</div>
									<div class="box-body">
										<div class="col-lg-12">
											<center>
												<form method="post" action="<?php echo site_url('MonitoringICT/DataServer/add'); ?>">
													<div style="margin-top: 50px" class="col-lg-10 col-lg-offset-3">
														<div class="form-group">
															<label style="margin-top: 5px" for="txtKodesieLama" class="col-lg-2 control-label">Hostname</label>
															<div class="col-lg-4">
																<input required type="text" name="txthostname" class="form-control" id="monitoringict-hostname" placeholder="hostname.com">
															</div>
														</div> 
													</div>
													<div style="margin-top: 20px" class="col-lg-10 col-lg-offset-3">
														<div class="form-group">
															<label style="margin-top: 5px" for="txtKodesieLama" class="col-lg-2 control-label">IP Address &nbsp<i title="Contoh IP Address : 192.168.168.128" style="align-items: left" class="icon-question-sign"></i></label>
															<div class="col-lg-4">
																<input required name="txtipaddress" class="form-control" id="monitoringict-ipaddress" placeholder="xxx.xxx.xxx.xxx">
																<span id="result" class="result"></span> 
															</div>
														</div> 
													</div>
													<div style="margin-top: 20px" class="col-lg-10 col-lg-offset-3">
														<div class="form-group">
															<label style="margin-top: 5px" for="txtKodesieLama" class="col-lg-2 control-label">Lokasi</label>
															<div class="col-lg-4">
																<select required name="txtlokasi" class="form-control ict-lokasi select2" id="monitoringict-lokasi" style="width: 100%">
                                                                	<option value=""></option>
                                                           	 </select>
															</div>
														</div> 
													</div>
													<div class="row col-lg-3 col-lg-offset-6">
														<button  style="margin-top: 50px" type="submit" class="btn btn-primary btn-md btn-rect">
														Simpan
														</button>
													</div>
												</form>
											</center>
										</div>
									</div>
								</div>
							</div>
						</div>
					</center>
				</div>
			</div>
		</div>
	</div>
</section>