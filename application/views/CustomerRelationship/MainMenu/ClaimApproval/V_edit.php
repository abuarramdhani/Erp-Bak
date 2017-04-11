<section class="content">
	<div class="inner" >
	<div class="box box-info">
	<div style="padding-top: 10px">
	<?php foreach ($search as $s) { ?>
		<div class="box-header with-border">
			<h3 style="text-align:center;"><strong>Edit Claims Data Number <?php echo $s['HEADER_ID']; ?><hr>
											<?php 	$itemLand = explode(', ', $s['LAND_CATEGORY']);
													$count = count($itemLand);
													for ($i=0; $i < $count ; $i++) { 
														$lc[$i] = $itemLand[$i];
														//print_r($lc[$i]);
														//exit(); 
													} ?>
										</strong></h3>
		</div>
		<div class="box-body">
			<form method="post" action="<?php echo base_url('SalesOrder/BranchApproval/NewClaims/Save')?>" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-5">
						<div class="form-group">
							<label>Claim Number</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="glyphicon glyphicon-list"></i>
								</div>
								<input type="text" class="form-control" name="ClaimNumber" placeholder="Number Claim" data-toggle="tooltip" data-placement="top" title="Nomor Klaim" required value="<?php echo $s['HEADER_ID']; ?>">
							</div>
						</div>
					</div>
					<div class="col-md-5 col-md-offset-2">
						<div class="form-group">
							<label>Claim Type</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="glyphicon glyphicon-list"></i>
								</div>
								<select style="width:100%;" class="form-control select2" name="claimType" data-placeholder="Claim Type" required>
									<option value="" disabled selected><-- PILIH SALAH SATU TIPE KLAIM --></option>
									<option value="muach" disabled><-- PILIH SALAH SATU TIPE KLAIM --></option>
									<?php if ($s['CLAIM_TYPE'] == 'UNIT') { ?>
										<option value="UNIT" selected>UNIT</option>
										<option value="SPAREPART">SPAREPART</option>
									<?php }elseif ($s['CLAIM_TYPE'] == 'SPAREPART') { ?>
										<option value="UNIT">UNIT</option>
										<option value="SPAREPART" selected>SPAREPART</option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<!-- MASUK KE MENU INPUT DATA KLAIM -->
				<div>
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<p class="help-block" style="text-align:center;">
								Hint! : Input with complete data on each tab , except for the data marked with an asterisk * , can be not filled.
							</p>
						<div class="box box-info">
							<strong>
								<!-- Nav tabs -->
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation" class="active">
										<a href="#tab1" role="tab" data-toggle="tab">CLAIM DATA</a>
									</li>
									<li role="presentation">
										<a href="#tab2" role="tab" data-toggle="tab">LOCATION OF THE INCIDENT</a>
									</li>
									<li role="presentation">
										<a href="#tab3" role="tab" data-toggle="tab">CLAIM DESCRIPTION</a>
									</li>
									<li role="presentation">
										<a href="#tab4" role="tab" data-toggle="tab">CLAIM ITEMS</a>
									</li>
									<li role="presentation">
										<a href="#tab5" role="tab" data-toggle="tab">CONDITION</a>
									</li>
									<li role="presentation">
										<a href="#tab6" role="tab" data-toggle="tab">DETAIL</a>
									</li>
								</ul>
							</strong>
						</div>
						</div>
					</div>
					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane fade in active" id="tab1">
							<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~INPUT BAGIAN DATA KLAIM~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
							<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~INPUT BAGIAN DATA KLAIM~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
							<div class="row">
								<div class="col-md-10 col-md-offset-1">	
									<p class="help-block" style="text-align:center;">
										Hint! : specify the number of claims data that will be input . then the claims data input form will appear automatically.
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-md-offset-1">
									<div class="form-group">
											<label>Amount of New Claims</label>
										<div class="input-group">
											<input type="number" name="amountClaims" id="amountClaims" class="form-control" placeholder="Amount of Claims" data-toggle="tooltip" data-placement="top" title="Masukkan banyaknya data klaim" required>
										</div>
									</div>
								</div>
							</div>
							<div id="manyClaim">
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="tab2">
							<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~INPUT BAGIAN LOKASI KEJADIAN~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
							<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~INPUT BAGIAN LOKASI KEJADIAN~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
							<div class="row">
								<div class="col-md-5 col-md-offset-1">
									<div class="form-group">
										<label>Province</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="glyphicon glyphicon-map-marker"></i>
											</div>
											<div>
											<select style="width:100%;" name="Province" id="Province" data-placeholder="Province" class="form-control select2" data-toggle="tooltip" data-placement="top" title="Pilih Provinsi" required>
												<option value=""></option>
												<option value="muach" disabled >-- PILIH SALAH SATU --</option>
												<?php foreach($Province as $p){ 
													if ($s['LOCATION_PROVINCE'] == $p['province_name']) {?>
														<option selected value="<?php echo $p['province_name'];?>"><?php echo strtoupper($p['province_name']);?></option>
												<?php }else{ ?>
													<option value="<?php echo $p['province_name'];?>"><?php echo strtoupper($p['province_name']);?></option>
												<?php }
												} ?>
											</select>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
											<label>City / Regency</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="glyphicon glyphicon-map-marker"></i>
											</div>
											<select style="width:100%;" data-placeholder="City / Regency" name="CityRegency" id="CityRegency" class="form-control select2" data-toggle="tooltip" data-placement="top" title="Pilih Kota / Kabupaten" required>
												<option value=""></option>
												<option value="muach" disabled >-- PILIH SALAH SATU --</option>
												<?php foreach($city as $c){ 
													if ($s['LOCATION_CITY'] == $c['regency_name']) { ?>
														<option selected value="<?php echo $c['regency_name'];?>"><?php echo strtoupper($c['regency_name']);?></option>
												<?php }else{ ?>
													<option value="<?php echo $c['regency_name'];?>"><?php echo strtoupper($c['regency_name']);?></option>
												<?php }
												} ?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-5 col-md-offset-1">
									<div class="form-group">
											<label>District</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="glyphicon glyphicon-map-marker"></i>
											</div>
											<select style="width:100%;" data-placeholder="District" name="District" id="District" class="form-control select2" data-toggle="tooltip" data-placement="top" title="Pilih Kecamatan" required>
												<option value=""></option>
												<option value="muach" disabled >-- PILIH SALAH SATU --</option>
												<?php foreach($district as $d){ 
													if ($s['LOCATION_DISTRICT'] == $d['district_name']) { ?>
														<option selected value="<?php echo $d['district_name'];?>"><?php echo strtoupper($d['district_name']);?></option>
												<?php }else{ ?>
													<option value="<?php echo $d['district_name'];?>"><?php echo strtoupper($d['district_name']);?></option>
												<?php }
												} ?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
											<label>Village</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="glyphicon glyphicon-map-marker"></i>
											</div>
											<select style="width:100%;" data-placeholder="Village" name="Village" id="Village" class="form-control select2" data-toggle="tooltip" data-placement="top" title="Pilih Desa / Kelurahan" required>
												<option value=""></option>
												<option value="muach" disabled >-- PILIH SALAH SATU --</option>
												<?php foreach($village as $v){ 
													if ($s['LOCATION_VILLAGE'] == $v['village_name']) { ?>
														<option selected value="<?php echo $v['village_name'];?>"><?php echo strtoupper($v['village_name']);?></option>
												<?php }else{ ?>
													<option value="<?php echo $v['village_name'];?>"><?php echo strtoupper($v['village_name']);?></option>
												<?php }
												} ?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-2 col-md-offset-1">
									<div class="form-group">
										<label>RT</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="glyphicon glyphicon-map-marker"></i>
											</div>
											<input type="number" class="form-control" name="RT" placeholder="RT" data-toggle="tooltip" data-placement="top" title="Masukkan RT" required value="<?php echo $s['HEADER_ID']; ?>">
										</div>
									</div>
								</div>
								<div class="col-md-2 col-md-offset-1">
									<div class="form-group">
										<label>RW</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="glyphicon glyphicon-map-marker"></i>
											</div>
											<input type="number" class="form-control" name="RW" placeholder="RW" data-toggle=tooltip" data-placement="top" title="Masukkan RW" required value="<?php echo $s['HEADER_ID']; ?>">
										</div>
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<label>Address</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="glyphicon glyphicon-map-marker"></i>
											</div>
											<textarea name="Address" class="form-control" rows="1" placeholder="Address" data-toggle="tooltip" data-placement="top" title="Masukkan alamat" data-toggle="tooltip" data-placement="top" title="Masukkan spesifik. Ex: Nama Jalan, Nama Dusun, Nomor Rumah" required>
												<?php echo $s['LOCATION_ADDRESS']; ?>
											</textarea>
										</div>
									</div>
								</div>
							</div>
			 			</div>
						<div role="tabpanel" class="tab-pane fade" id="tab3">
							<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~INPUT BAGIAN URAIAN KLAIM~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
							<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~INPUT BAGIAN URAIAN KLAIM~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
							<div class="row">
								<div class="col-md-5 col-md-offset-1">
									<div class="form-group">
											<label>Customer Name</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="glyphicon glyphicon-user"></i>
											</div>
											<select style="width:100%;" data-placeholder="Owner Name" name="custAccountId" id="partyName" class="form-control select2" data-toggle="tooltip" data-placement="top" title="Pilih Pemilik Terdaftar" required>
												<option value="" disabled></option>
												<option value="muach" disabled><-- PILIH SALAH SATU --></option>
												<?php foreach ($customer as $c) { 
													if ($s['CUST_ACCOUNT_ID'] == $c['CUST_ACCOUNT_ID']) { ?>
														<option selected value="<?php echo $c['CUST_ACCOUNT_ID']; ?>">
															<?php echo strtoupper($c['PARTY_NAME']); ?>
														</option>
												<?php }else{ ?>
														<option value="<?php echo $c['CUST_ACCOUNT_ID']; ?>">
															<?php echo strtoupper($c['PARTY_NAME']); ?>
														</option>
												<?php }
												} ?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
											<label>Phone Number</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="glyphicon glyphicon-phone-alt"></i>
											</div>
											<input type="number" class="form-control" name="PhoneNumber" placeholder="Owner Phone Number" data-toggle="tooltip" data-placement="top" title="Masukan nomer kontak pemilik" required value="<?php echo $s['OWNER_PHONE_NUMBER']; ?>">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-5 col-md-offset-1">
									<div class="form-group">
										<label>Specific Owner Name</label>
									<p class="help-block" style="text-align:center;">
										Hint! : This will enable when the Customer Name have a name wiht word KHS.
									</p>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="glyphicon glyphicon-user"></i>
											</div>
											<?php if ($s['OWNER_NAME'] == NULL) { ?>
												<input type="text" class="form-control" name="ownerName" placeholder="Owner Name" data-toggle="tooltip" data-placement="top" title="Masukkan nama pemilik" id="ownerName" disabled>
											<?php }else{ ?>
												<input type="text" class="form-control" name="ownerName" placeholder="Owner Name" data-toggle="tooltip" data-placement="top" title="Masukkan nama pemilik" id="ownerName" required value="<?php echo $s['OWNER_NAME']; ?>">
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<label>Duration of Use</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="glyphicon glyphicon-calendar"></i>
											</div>
											<?php 
												$val 	= $s['DURATION_OF_USE'];
												$item 	= explode(' ', $val);
												$duration = $item[0];
												$durationType = $item[1];
											?>
											<input type="number" class="form-control" name="durationUse" placeholder="Duration of Use" data-toggle="tooltip" data-placement="top" title="Masukkan lama waktu pemakaian" required value="<?php echo $duration; ?>">
											<select style="width:100%;" name="durationUseType" data-placeholder="Duration of Use Type" class="form-control select2" required>
												<option value="" disabled selected><-- PILIH TIPE SATUAN WAKTU --></option>
												<option value="muach" disabled><-- PILIH TIPE SATUAN WAKTU --></option>
												<?php if ($durationType == 'DAYS') { ?>
													<option selected value="DAYS">DAYS</option>
													<option value="MONTHS">MONTHS</option>
													<option value="YEARS">YEARS</option>
												<?php }elseif ($durationType == 'MONTHS') { ?>
													<option value="DAYS">DAYS</option>
													<option selected value="MONTHS">MONTHS</option>
													<option value="YEARS">YEARS</option>
												<?php }elseif ($durationType == 'YEARS') { ?>
													<option value="DAYS">DAYS</option>
													<option value="MONTHS">MONTHS</option>
													<option selected value="YEARS">YEARS</option>
												<?php }else{ ?>
													<option value="DAYS">DAYS</option>
													<option value="MONTHS">MONTHS</option>
													<option value="YEARS">YEARS</option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									<div class="form-group">
											<label>Address</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="glyphicon glyphicon-home"></i>
											</div>
											<textarea class="form-control" rows="3" name="ownerAddress" placeholder="Owner Address" data-toggle="tooltip" data-placement="top" title="Masukkan alamat pemilik" required value="<?php echo $s['OWNER_ADDRESS']; ?>"><?php echo $s['OWNER_ADDRESS']; ?></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="tab4">
							<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~INPUT BAGIAN BARANG KLAIM~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
							<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~INPUT BAGIAN BARANG KLAIM~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
							<div class="row">
								<div class="col-md-10 col-md-offset-1">	
									<p class="help-block" style="text-align:center;">
										Hint! : Choose on the left option to show the input data form. The input data form will appear on the right of option that you choose.
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-md-offset-1">
                    				<div class="btn-group-vertical" style="width:100%;">
                    					<button type="button" class="btn btn-default btn-flat" id="claimsItem1">SHIPPED</button>
                    					<button type="button" class="btn btn-default btn-flat" id="claimsItem2">NOT SHIPPED</button>
                    					<button type="button" class="btn btn-default btn-flat" id="claimsItem3">NO EVIDENCE</button>
                    				</div>
								</div>
								<div class="col-md-6">
									<?php if ($s['SHIPPED'] == 'YES') { ?>
										<div id="showClaimsItem">
											<div class="form-group">
												<label>Sent date</label>
												<div class="input-group">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-user"></i>
													</div>
													<input type="text" class="form-control" id="sentDate" name="sentDate" placeholder="Sent date items" data-toggle="tooltip" data-placement="top" title="Masukkan waktu produk klaim dikirim ke CV. KHS Yogyakarta" required value="<?php echo $s['SHIPMENT_DATE']; ?>">
												</div>
											</div>
										</div>
									<?php }elseif ($s['SHIPPED'] == 'NO' AND $s['NO_EVIDENCE'] == 'NO') { ?>
										<div id="showClaimsItem">
												<div class="form-group">
													<label>Reason Can Not be Sent</label>
													<div class="input-group">
														<div class="input-group-addon">
															<i class="glyphicon glyphicon-home"></i>
														</div>
														<input type="text" class="form-control" name="reason" placeholder="Reason Can Not be Sent" data-toggle="tooltip" data-placement="top" title="Masukkan alasan barang tidak dapat dikirim" required value="<?php echo $s['NOT_SHIPPED_REASON']; ?>">
													</div>
												</div>
										</div>
									<?php } elseif ($s['SHIPPED'] == 'NO' AND $s['NOT_SHIPPED_REASON'] == 'NO REASON') { ?> 
										<div id="showClaimsItem">
												<p style="text-align:center;">
													<strong>- No Evidence for The Claim -</strong>
												</p>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="tab5">
							<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~INPUT BAGIAN KONDISI KLAIM~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
							<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~INPUT BAGIAN KONDISI KLAIM~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
							<div class="row">
								<div class="col-md-10 col-md-offset-1">	
									<p class="help-block" style="text-align:center;">
										Hint! : Tick the appropriate option. May be more than one option.
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-2 col-md-offset-1">
									<div class="form-group">
										<label>Area Category</label>
										<div class="input-group">
											<?php 	//$itemLand = explode(', ', $s['LAND_CATEGORY']);
													 ?>
											<input type="checkbox" name="area[]" value="Basah tidak berair"> Basah tidak berair
											<br><input type="checkbox" name="area[]" value="Basah berair"> Basah berair
											<br><input type="checkbox" name="area[]" value="Kering"> Kering
											<br><input type="checkbox" name="area[]" value="Rawa"> Rawa
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Type of Soil</label>
										<div class="input-group">
											<input type="checkbox" name="Soil[]" value="Lempung"> Lempung
											<br><input type="checkbox" name="Soil[]" value="Lempung berpasir"> Lempung berpasir
											<br><input type="checkbox" name="Soil[]" value="Normal"> Normal
										<!--	<br><div class="input-group">
      												<span class="input-group-addon">
        												<input type="checkbox" name="Soil[]"> 
      												</span>
													<input class="form-control" type="text" name="Soil[]" placeholder="Other soil type" data-toggle="tooltip" data-placement="top" title="Masukkan tipe tanah yang lain">
												</div>
										-->
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Depth</label>
										<div class="input-group">
											<input type="checkbox" name="Depth[]" value="Normal (10-17 cm)"> Normal (10-17 cm)
											<br><input type="checkbox" name="Depth[]" value="Sedang (17-30 cm)"> Sedang (17-30 cm)
											<br><input type="checkbox" name="Depth[]" value="Dalam (30-40 cm)"> Dalam (30-40 cm)
											<br><input type="checkbox" name="Depth[]" value="Sangat Dalam (lebih dari 40 cm)"> Sangat Dalam (lebih dari 40 cm)
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Weeds</label>
										<div class="input-group">
      											<input type="checkbox" name="Weeds[]" value="Rumput liar">Rumput liar
											<br><input type="checkbox" name="Weeds[]" value="Tanaman perdu"> Tanaman perdu
											<br><input type="checkbox" name="Weeds[]" value="Alang - alang"> Alang - alang
										<!--	<br><div class="input-group">
      												<span class="input-group-addon">
      													<input type="checkbox" name="Weeds[]"> 
      												</span>
													<input class="form-control" type="text" name="Weeds[]" placeholder="Other weeds" data-toggle="tooltip" data-placement="top" title="Masukkan tipe tanaman pengganggu lain">
												</div>
										-->
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Topography</label>
										<div class="input-group">
											<input type="checkbox" name="Topography[]" value="Dataran rendah"> Dataran rendah
											<br><input type="checkbox" name="Topography[]" value="Dataran tinggi"> Dataran tinggi
											<br><input type="checkbox" name="Topography[]" value="Terasiring"> Terasiring
									<!--		<br><div class="input-group">
      												<span class="input-group-addon">
      													<input type="checkbox" name="Topography[]">
      												</span>
													<input class="form-control" type="text" name="Topography[]" placeholder="Other topography" data-toggle="tooltip" data-placement="top" title="Masukkan nama topografi yang lain">
												</div>
									-->
										</div>
									</div>
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="tab6">
							<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~INPUT BAGIAN KRONOLOGI KEJADIAN~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
							<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~INPUT BAGIAN KRONOLOGI KEJADIAN~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									<div class="form-group">
											<label>Details Chronology of Events</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="glyphicon glyphicon-user"></i>
											</div>
											<textarea name="Chronology" placeholder="Details Chronology of Events" class="form-control" rows="4" data-toggle="tooltip" data-placement="top" title="Masukkan detail kronologis kejadian" required><?php echo $s['EVENT_CHRONOLOGY']; ?></textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									<div class="form-group">
											<label>A Preliminary Investigation and Remediation</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="glyphicon glyphicon-user"></i>
											</div>
											<textarea name="note" placeholder="A Preliminary Investigation and Remediation" class="form-control" rows="4" data-toggle="tooltip" data-placement="top" title="Masukkan detail investigasi awal dan saran perbaikan" required><?php echo $s['NOTE']; ?></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<button class="btn btn-primary" type="submit" style="float:right">SAVE</button>
						<button class="btn btn-default" style="float:right" onclick="history.go(-1);">BACK</button>
					</div>
				</div>
			</form>
		</div>
		<div class="box box-info"></div>
	<?php } ?>
	</div>
	</div>
	</div>
</section>