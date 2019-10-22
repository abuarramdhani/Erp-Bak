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
	}#myBtn {
  /* display: none; */
  position: fixed;
  bottom: 50px;
  right: 30px;
  z-index: 99;
  font-size: 14px;
  border: none;
  outline: none;
  /* background-color: blue; */
  color: white;
  cursor: pointer;
  padding: 7px;
  border-radius: 4px;
}

#myBtn:hover {
  background-color: #555;
}
	
</style>
<section class="content">
	<div class="inner" >
	<div class="row">
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
								<button class="btn btn-md btn-primary"><b>Item PO</b></button>
							</div>
							<button onClick="document.getElementById('divini').scrollIntoView();" id="myBtn" class="btn-info" title="Input Unknown Item"><b>Unknown Item <i class="fa fa-caret-square-o-down"></i></b></button>
							<form id="add-form" action="<?php echo site_url('');?>SaveData" method='post'>
							<!-- <div class="box-body">
							</div> -->
							<div class="box-footer" >
								<div class="col-lg-12">
										<div class="col-lg-2">
											<input type="hidden" readonly placeholder="ID" id="no_id" name="txtID" class="form-control"  style="width: 100%;" value="<?php echo $id_ok ?>"/>
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
										</div>
									</div>
                                    <div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										    <label>No. Surat Jalan </label>
										</div>
										<div class="col-lg-5">
											<input type="text" placeholder="No Surat Jalan" id="no_sj" name="txtNoSJ" class="form-control" style="width:100%"/>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										    <label>Waktu Datang </label>
										</div>
										<div class="col-lg-3">
											<input type="text" placeholder="Tanggal Datang" autocomplete="off" id="dateDatang" name="dateDatang" class="form-control dtPicker" style="width:100%"/>
										</div>
										<div class="col-lg-2">
											<input type="time" title="Jam Datang" id="timeDatang" name="timeDatang" class="form-control" style="width:100%"/>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										</div>
										<div class="col-lg-6">
											<button id="searchdata" type="button" class="searchsupplier btn btn-primary btn-sm" style="font-size: 13px" disabled><strong>Find Item</strong><span style="padding-left: 5px" class="fa fa-search"></span></button>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-3 hh">
										</div>
										<div class="col-lg-2">
										    <label><h4><b>Item PO:</b></h4></label>
										</div>
									</div>
								<div class="row" style="padding:10px">
								<div class="col-lg-2"></div>
									<div class="col-lg-8">
									<div id="sub-div" align="center" style="padding-right:15px; padding-bottom: 10px" >
										<div id="loading"></div>
										<div id="ResultBd">
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
								<div class="row" style="padding:10px">
								
								<div class="col-lg-2"></div>
									<div class="col-lg-8">
										<div id="sub-div" align="center" style="padding-right:15px; padding-bottom: 10px" >
											<div id="loading"></div>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-3 hh">
										    <label>Catatan :</label>
										</div>
										<div class="col-lg-7">
											<input type="text" id="note" name="note" Placeholder="Catatan" class="form-control toupper">
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-3 hh"></div>
										<div class="col-lg-7 hh">
											<div id="sub-div" align="center" style="padding-right:15px; padding-bottom: 10px" >
												<button type="submit" class="btn btn-success btn-rect"><b>Save <span id="btnjumlahcheck"></span></b></button>
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

						<div class="box box-primary box-solid">
							<div class="box-header with-border" id="divini">
								<button class="btn btn-md btn-primary"><b>Unknown Item</b></button>
							</div>
							<!-- <div class="box-body">
							</div> -->
							<div class="box-footer" >
							<form id="add-form" action="<?php echo site_url('');?>SaveDataUnknown" method='post'>
								<div class="col-lg-12">
										<div class="col-lg-2">
											<input type="hidden" readonly placeholder="ID" id="no_id" name="txtID" class="form-control"  style="width: 100%;" value="<?php echo $id_not_ok ?>"/>
										</div>
								</div>
								<div class="form-group col-lg-12">
									<div class="col-lg-4 hh">
										<label>Waktu Datang </label>
									</div>
									<div class="col-lg-3">
										<input type="text" autocomplete="off" placeholder="Tanggal Datang" id="dateBD" name="dateDatang" class="form-control dtPicker" style="width:100%"/>
									</div>
									<div class="col-lg-2">
										<input type="time" title="Jam Datang" id="timeDatang" name="timeBD" class="form-control" style="width:100%"/>
									</div>
								</div>
								<div class="row" style="padding:10px">
								</div>
								</div>
								<div class="row" style="padding:10px">
								<a type="button" title="Tambah Baris" onclick="addRow('tbl2')" class="btn-primary btn-sm" style="font-size: 13px;cursor: pointer;"><span style="padding-left: 5px" class="fa fa-plus"></span></a>
								&nbsp;<a type="button" title="Hapus Baris" onclick="deleteRow('tbl2')" class="btn-primary btn-sm" style="font-size: 13px;cursor: pointer;"><span style="padding-left: 5px" class="fa fa-minus"></span></a>
								<div class="col-lg-1"></div>
									<div class="col-lg-10">
										<div id="sub-div" align="center" style="padding-right:15px; padding-bottom: 10px" >
											<div id="loading"></div>
											<div id="ResultBdrev">
												<table name="tbl2" id="tbl2" class="table table-striped table-bordered table-hover text-left" style="font-size:12px;">
													<thead>
														<tr class="bg-primary">
															<td width="20%"><b>No SJ </b></td>
															<td width="35%"><b>Item</b></td>
															<td width="15%"><b>QTY</b></td>
															<td width="30%"><b>Catatan</b></td>
														</tr>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td><input class="form-control" Placeholder="No. Surat jalan" type="text" name="linenosj[]" value="" ></td>
															<td>
																<select class="form-control" Placeholder="Item" type="text" id="itembd" name="lineitem[]" value="" ><option></option></select>
															</td>
															<td><input class="form-control" Placeholder="Qty" type="number" name="lineqty[]" value=""></td>
															<td><input class="form-control" Placeholder="Catatan" id="" type="text" name="linenote[]" value=""></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-3 hh"></div>
										<div class="col-lg-7 hh">
											<div id="sub-div" align="center" style="padding-right:15px; padding-bottom: 10px" >
												<button type="submit" id="" class="btn btn-success btn-rect"><b>Save</b></button>
												<span id="" onClick="location.reload()" class="btn btn-warning btn-rect"><b>Clear</b></span>
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