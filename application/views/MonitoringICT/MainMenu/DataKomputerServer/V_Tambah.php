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
					<div>
						<div align="center" class="col-lg-12">
							<div class="box box-primary box-solid">
								<div class="box-header with-border">
									Tambah Data Server
								</div>
								<div class="box-body">
									<div class="col-lg-12">
										<form class="form-horizontal" method="post" action="<?php echo site_url('MonitoringICT/DataServer/add'); ?>">
											<div class="form-group">
												<label style="margin-top: 5px" for="txtKodesieLama" class="col-lg-4 control-label">Hostname</label>
												<div data-toggle="tooltip" data-placement="top" id="ict-host" class="col-lg-4 has-feedback">
													<input required type="text" name="txthostname" class="form-control" id="monitoringict-hostname" placeholder="hostname.com" pattern="^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}$">
													<span id="ict-host-span" class="glyphicon  form-control-feedback"></span>
												</div>
											</div> 
											<div class="form-group">
												<label style="margin-top: 5px" for="txtKodesieLama" class="col-lg-4 control-label">IP Address &nbsp<i title="Contoh IP Address : 192.168.168.128" style="align-items: left" class="icon-question-sign" data-toggle="tooltip" data-placement="left"></i></label>
												<div data-toggle="tooltip" data-placement="top" id="ict-stat1" class="col-lg-4 has-feedback">
													<input required name="txtipaddress" pattern="^([0-9]{1,3}\.){3}[0-9]{1,3}$" class="form-control" id="monitoringict-ipaddress" placeholder="xxx.xxx.xxx.xxx">
													<span id="ict-stat2" class="glyphicon  form-control-feedback"></span>
												</div>
											</div>
											<div class="form-group">
												<label style="margin-top: 5px" for="txtKodesieLama" class="col-lg-4 control-label">Lokasi</label>
												<div class="col-lg-4">
													<select required name="txtlokasi" class="form-control ict-lokasi select2" id="monitoringict-lokasi" style="width: 100%">
														<option value=""></option>
													</select>
												</div>
											</div> 
											<div class="row col-lg-3 col-lg-offset-6">
											<!-- <input type="button" class="btn btn-primary" onclick="window.history.back(-1);">back</input> -->
												<button  style="margin-top: 50px" type="submit" class="btn btn-primary btn-md btn-rect">
													Simpan
												</button>
											</div>
										</form>
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