<style type="text/css">
	/* .form-control{
		border-radius: 20px;
	} */

	.hh {
		text-align: right;
	}

	/* textarea.form-control{
		border-radius: 10px;
	} */
	.btnHoPg{
		height: 40px;
		width: 40px;
		border-radius: 50%;
		margin-top: 20px;
	}
	/* .select2-selection{
		border-radius: 20px !important;
	} */

	ul.select2-results__options:last-child{
		border-bottom-right-radius: 20px !important;
		border-bottom-left-radius: 20px !important;
	}

	label {
		font-size: 16px;
	}

	/* span.select2-dropdown{
		border-radius: 20px !important;
	} */

	.loadOSIMG{
		width: 30px;
		height: auto;
	}
	/* .btn {
		border-radius: 20px !important;
	} */
	
</style>
<?php
// echo "<pre>";
// print_r($io);
// exit;?>
<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11" style="height: 70px">
							<div class="text-right">
								<h1><b>Monitoring Barang Datang</b></h1>
							</div>
						</div>
						<div class="col-lg-1 " style="height: 70px">
							<div class="text-right ">
								<a class="" href="">
									<button class="btnHoPg btn btn-default btn-md">
										<b class="fa fa-table"></b>
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
								<button class="btn btn-md btn-primary"><b>Monitoring</b></button>
							</div>
							<div class="box-body">
							</div>
							<div class="box-footer" >
								<div class="col-lg-12">
									<div class="form-group col-lg-12">
										<!-- <div class="col-lg-12 hh">
										</div> -->
									<!-- </div>
									<div class="form-group col-lg-12"> -->
										<!-- <div class="col-lg-12 hh">
										</div> -->
										<div class="col-lg-2 hh">
										    <label >No. PO</label>
										</div>
										<div class="col-lg-4">
                                            <input type="text" id="no_po" autocomplete="off" name="txtNo_po" style="width: 100%;" class="form-control" placeholder="No. PO" required/>
										</div>
										<div class="col-lg-2 hh">
										    <label>Tanggal Mulai</label>
										</div>
										<div class="col-lg-4">
                                            <input type="text" id="tgl_mulaiMBD" name="tgl_mulaiMBD" class="dtPicker form-control bg-warning" placeholder="Tanggal Mulai">
										</div>
									</div>
                                    <div class="form-group col-lg-12">
										<!-- <div class="col-lg-12 hh">
										</div> -->
										<div class="col-lg-2 hh">
										    <label >No. Surat Jalan</label>
										</div>
										<div class="col-lg-4">
                                            <input type="text" id="no_surat_jalan" autocomplete="off" name="txtNo_surat_jalan" style="width: 100%;" class="form-control" placeholder="No. Surat Jalan" required/>
										</div>
									<!-- </div>
                                    <div class="form-group col-lg-12"> -->
										<!-- <div class="col-lg-12 hh">
										</div> -->
										<div class="col-lg-2 hh">
										    <label >Tanggal Akhir</label>
										</div>
										<div class="col-lg-4">
                                            <input type="text" id="tgl_akhirMBD" autocomplete="off" name="tgl_akhirMBD" style="width: 100%;" class="dtPicker form-control" placeholder="Tanggal Akhir"/>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<!-- <div class="col-lg-12 hh">
										</div> -->
										<div class="col-lg-2 hh">
										    <label>IO</label>
										</div>
										<div class="col-lg-4">
                                            <select id="" name="selectIO" class="form-control select2" placeholder="IO">
											<option disabled selected>Pilih IO</option>
											<?php $i=0;
											foreach ($io as $key) {?>
												<option value="<?php echo $key['ORGANIZATION_CODE'] ?>">
													<?php echo $key['ORGANIZATION_CODE'] ?>
												</option>
											<?php $i++; } ?>
											</select>
										</div>
										<div class="col-lg-2 hh">
										</div>
										<div class="col-lg-4">
											<div id="sub-div" align="right" style="padding-right:0px; padding-bottom: 10px" >
											<button onclick="clearfilterMBD(this)" id="" type="button" class="btn btn-warning btn-sm" style="font-size: 13px" ><strong>Reset</strong><span style="padding-left: 5px" class="fa fa-refresh"></span></button>
											<button onclick="getMBD(this)" id="btnGetMBD" type="button" class="btn btn-success btn-sm" style="font-size: 13px" disabled><strong>Search</strong><span style="padding-left: 5px" class="fa fa-search"></span></button>
											</div>
										</div>
									</div>
								</div>
								<!-- <div class="row" style="padding:10px">
									<div id="sub-div" align="center" style="padding-right:15px; padding-bottom: 10px" >
									    <button onclick="getMBD(this)" id="btnGetMBD" type="button" class="btn btn-success btn-sm" style="font-size: 13px" disabled><strong>Search</strong><span style="padding-left: 5px" class="fa fa-search"></span></button>
									</div>
								</div> -->
								</div>
								
                                <div id="loading" style="display: none;text-align: center;width:100%;margin-top: 0px;margin-bottom: 20px">
								<center><img style="width:70px; height:auto ;margin-top: 2%;" src="<?php echo base_url().'assets/img/gif/loading5.gif' ?>"/></center>
	                            </div>
								<br>
								<div id="ResultMBD">
								</div>
								</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>