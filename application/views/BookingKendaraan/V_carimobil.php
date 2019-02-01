<style type="text/css">
	.btn3d {
	    transition:all .08s linear;
	    position:relative;
	    outline:medium none;
	    -moz-outline-style:none;
	    border:0px;
	    margin-right:10px;
	    margin-top:15px;
	}
	.btn3d:focus {
	    outline:medium none;
	    -moz-outline-style:none;
	}
	.btn3d:active {
	    top:9px;
	}
	.btn-primary2 {
    box-shadow:0 0 0 1px #428bca inset, 0 0 0 2px rgba(255,255,255,0.15) inset, 0 8px 0 0 #357ebd, 0 8px 0 1px rgba(0,0,0,0.4), 0 8px 8px 1px rgba(0,0,0,0.5);
    background-color:#428bca;
    color: white;
	}
	.btn-primary2:hover{
		color: white;
	}
</style>
<section style="">
	<div class="row" style="padding: 40px;padding-bottom: 0px;">
		<div class="col-lg-11 text-right">
			<h1><b>Booking Kendaraan</b></h1>
		</div>
		<div class="col-lg-1">
			<a href="<?php echo base_url('BookingKendaraan/CariMobil'); ?>" class="btn btn-lg btn-default">
				<i class="icon-wrench icon-2x"></i>
			</a>
		</div>
	</div>
	<div class="panel-group" style="margin:30px;margin-top: 0px;">
		<div class="panel panel-primary">
			<div class="panel-heading">
				
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-justified">
				  <li class="active"><a href="<?php echo base_url('BookingKendaraan/CariMobil/index'); ?>">List Mobil</a></li>
				  <li><a href="<?php echo base_url('BookingKendaraan/CariMobil/isidata'); ?>">Isi Data</a></li>
				  <li><a href="<?php echo base_url('BookingKendaraan/CariMobil/konfirmasi'); ?>">Konfirmasi</a></li>
				</ul>
				<div style="width: 100%;background-color: white">
					<form method="POST" action="<?php echo base_url('BookingKendaraan/CariMobil/getMobil'); ?>">
					<div class="row" style="padding-top: 20px;">
						<div class="col-lg-1">
							
						</div>
						<div class="col-lg-3">
							<input placeholder="Tanggal" name="tgl_caribooking" id="tgl_caribooking" class="date form-control" style="width: 90%;margin-left: 10px;">
						</div>
						<div class="col-lg-3">
							<select name="slc_seksibooking" id="slc_seksibooking" class="form-control"></select>
						</div>
						<div class="col-lg-3">
							<select name="slc_picbooking" id="slc_picbooking" class="form-control"></select>
						</div>
						<div class="col-lg-2">
							<div style="margin-top: -20px;">
								<button type="submit" class="btn btn-primary2 btn3d">Check</button>
							</div>
						</div>
					</div>
					</form>
					<div class="panel-group" style="margin: 40px;margin-top: 60px">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h4>Tabel Data Ketersediaan Kendaraan</h4>
							</div>
							<div class="panel-body">
								<div style="width: 100%;">
									<table width="100%">
										<tr>
											<td>
												<div style="width: 90%;margin: 0px auto;background-color: white; height: 170px;border: 1px solid #4db8ff">
													<div style="height: 14px;"></div>
													<div style="width: 80px;height: 20px;background-color: green;margin-left: -17px;text-align: center;box-shadow: 2px 2px 3px black">
														<span style="color: white">Open</span>
													</div>
													<div class="row" style="width: 100%">
														<div class="col-lg-12">
															<div class="col-lg-3">
																<div style="width: 100%;margin-top: 13px;">
																	<div style="width: 183px;height: 100px;background-color: grey">
																		<img style="width: 183px;height: 100px;" src="">
																	</div>
																</div>
															</div>
															<div class="col-lg-4">
																<div style="margin-top: 13px;">
																	<label>ISUZU - Panther</label>
																	<br>
																	<label>( AB XXXX BA )</label>
																</div>
															</div>
															<div class="col-lg-4">
																<div style="margin-top: 13px;">
																	<label>PIC : Alfian Afief Nurtamsa</label>
																	<br>
																	<label style="margin-left: 37px;">B0689</label>
																	<br>
																	<label>Information & Communication Technology</label>
																	<br>
																	<label>Voip : 12300 (ext 3)</label>
																</div>
															</div>
															<div class="col-lg-1">
																<div style="margin-top: 65px;">
																	<a href="<?php echo base_url('BookingKendaraan/CariMobil/isidata'.'/'); ?>" class="btn btn-primary2 btn3d">Book**</a>
																</div>
															</div>
														</div>
													</div>
													<br>
												</div>
											</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</section 