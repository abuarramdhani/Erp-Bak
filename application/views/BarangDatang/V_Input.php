<?php 
$err =  $this->session->flashdata('response');
if ($err != null) {
	echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
		<script type="text/javascript">
			Swal.fire({
				type: \'error\',
				title: \''.$err.'\',
				width: 600,
				showConfirmButton: true,
			})
		</script>';
} ?>
<?php 
$succ =  $this->session->flashdata('return');
if ($succ != null) {
	echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
		<script type="text/javascript">
			Swal.fire({
				type: \'success\',
				title: \''.$succ.'\',
				width: 600,
				showConfirmButton: false,
				timer: 2200
			})
		</script>';
} ?>
<style type="text/css">
	.hh {
		text-align: right;
	}.btnHoPg{
		height: 40px;
		width: 40px;
		border-radius: 50%;
		margin-top: 20px;
	}ul.select2-results__options:last-child{
		border-bottom-right-radius: 20px !important;
		border-bottom-left-radius: 20px !important;
	}.loadOSIMG{
		width: 30px;
		height: auto;
	}
	
</style>
<section class="content">
	<div class="inner" >
	<div class="row">
		<form id="add-form" action="<?php echo site_url('');?>SaveData" method='post'>
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11" style="height: 70px">
							<div class="text-right">
								<h1><b>Input Barang Datang</b></h1>
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
								<button class="btn btn-md btn-primary"><b>Input</b></button>
							</div>
							<div class="box-body">
							</div>
							<div class="box-footer" >
								<div class="col-lg-12">
										<div class="col-lg-2">
											<input type="hidden" placeholder="ID" id="no_id" name="txtID" class="form-control"  style="width: 100%;" value="<?php echo $no_id ?>"/>
										</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										    <label>No. PO </label>
										</div>
										<div class="col-lg-5">
											<input type="number" placeholder="No PO" id="no_po" class="form-control" name="txtNoPo" style="width:100%"/>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										    <label >Supplier </label>
										</div>
										<div class="col-lg-5">
											<input type="text" style="width: 100%;" id="pilihsupplier" value="" placeholder="Supplier" class="form-control" name="txtSupplier" readonly/>
											<!-- <select name="txtSupplier" id="jspilihSupplier" style="width: 100%;" class="form-control jspilihSupplier">
												<option></option>
											</select> -->
										</div>
									</div>
                                    <div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										    <label>No. Surat Jalan </label>
										</div>
										<div class="col-lg-5">
											<input type="text" placeholder="No Surat Jalan" id="no_sj" name="txtNoSJ" class="form-control toupper" style="width:100%"/>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										    <label>Waktu Datang </label>
										</div>
										<div class="col-lg-3">
											<input type="text" placeholder="Tanggal Datang" id="dateDatang" name="dateDatang" class="form-control dtPicker" style="width:100%"/>
										</div>
										<div class="col-lg-2">
											<input type="time" title="Jam Datang" id="timeDatang" name="timeDatang" class="form-control" style="width:100%"/>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										</div>
										<div class="col-lg-6">
											<button id="searchdata" type="button" class="searchsupplier btn btn-success btn-sm" style="font-size: 13px" disabled><strong>Find Item</strong><span style="padding-left: 5px" class="fa fa-search"></span></button>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-3 hh">
										</div>
										<div class="col-lg-2">
										    <label><h4><b>Item PO:</b></h4></label>
										</div>
										<!-- <div class="col-lg-8">
										</div> -->
									</div>
								<!-- </div> -->
								<div class="row" style="padding:10px">
								<div class="col-lg-2"></div>
									<div class="col-lg-8">
									<div id="sub-div" align="center" style="padding-right:15px; padding-bottom: 10px" >
										<div id="loading"></div>
										<div id="res">
										<!-- <table class="table table-striped table-bordered table-hover text-left" id="dataTables" style="font-size:12px;"> -->
										<table class="table table-striped table-bordered table-hover text-left" id="" style="font-size:12px;">
											<thead>
												<tr class="bg-primary">
													<td width="8%"><b>No</b></td>
													<td width="1%"><b></td>
													<td width="20%"><b>Item </b></td>
													<td width="55%"><b>Item Description</b></td>
													<td width="15%"><b>Sub inv</b></td>
													<td width="5%"><b>QTY PO</b></td>
													<td width="5%"><b>QTY Simpan</b></td>
													<td width="5%"><b><center>QTY Datang</center></b></td>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td></td>
													<td><input type="checkbox"></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
											</tbody>
										</table>
									</div>
									</div>
									
								</div>
								</div>
								<div class="form-group col-lg-12">
										<div class="col-lg-3 hh">
										</div>
										<div class="col-lg-2">
										    <label><h4><b>Unknown Item :</b></h4></label>
										</div>
										<!-- <div class="col-lg-8">
										</div> -->
									</div>
								<!-- </div> -->
								<div class="row" style="padding:10px">
								<a type="button" title="Tambah Baris" onclick="addRow('tbl2')" class="btn-primary btn-sm" style="font-size: 13px;cursor: pointer;"><span style="padding-left: 5px" class="fa fa-plus"></span></a>
								&nbsp;<a type="button" title="Hapus Baris" onclick="deleteRow('tbl2')" class="btn-primary btn-sm" style="font-size: 13px;cursor: pointer;"><span style="padding-left: 5px" class="fa fa-minus"></span></a>
								<div class="col-lg-2"></div>
									<div class="col-lg-8">
										<div id="sub-div" align="center" style="padding-right:15px; padding-bottom: 10px" >
											<div id="loading"></div>
											<div id="res">
												<table name="tbl2" id="tbl2" class="table table-striped table-bordered table-hover text-left" style="font-size:12px;">
													<thead>
														<tr class="bg-primary">
															<!-- <td width="20%"><b>Item </b></td> -->
															<td width="50%"><b>Item Description</b></td>
															<td width="35%"><b>Sub inv</b></td>
															<td width="15%"><b>QTY</b></td>
														</tr>
														</tr>
													</thead>
													<tbody>
														<tr>
															<!-- <td><input class="toupper" type="text" name="line1[]" value="" ></td> -->
															<td><select class="form-control" type="text" id="itembd" name="line1[]" value="" ><option></option></select></td>
															<!-- <td><input class="toupper" style="width: 100%" type="text" name="line2[]" value=""></td> -->
															<td><select class="form-control" id="gudangbd" type="text" name="line3[]" value=""><option></option></select></td>
															<td><input class="form-control" type="number" name="line4[]" value=""></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-3 hh">
										    <label>Catatan :</label>
										</div>
										<div class="col-lg-7">
											<input type="text" id="note" name="note" class="form-control toupper">
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-3 hh"></div>
										<div class="col-lg-7 hh">
											<div id="sub-div" align="center" style="padding-right:15px; padding-bottom: 10px" >
												<button type="submit" id="btnSaveAssets" class="btn btn-primary btn-rect"><b>Save</b></button>
												<span onClick="location.reload()" class="btn btn-warning btn-rect"><b>Clear</b></span>
											</div>
										</div>
									</div>
								</div>
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