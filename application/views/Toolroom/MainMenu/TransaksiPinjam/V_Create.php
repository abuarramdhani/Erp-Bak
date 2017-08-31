<section class="content">
	<div class="inner" >
		<div class="row">
			<form method="post" action="<?php echo site_url('Toolroom/Transaksi/savePeminjaman')?>" class="form-horizontal">
					<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
					<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" id="hdnDate"/>
					<input type="hidden" value="<?php echo $this->session->user; ?>" name="hdnUser" id="hdnUser"/>
			<div class="col-lg-12">
				<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-11">
								<div class="text-right">
								<h1><b><?= $Title?></b></h1>

								</div>
							</div>
							<div class="col-lg-1 ">
								<div class="text-right hidden-md hidden-sm hidden-xs">
									<a class="btn btn-default btn-lg" href="<?php echo site_url('Toolroom');?>">
										<i class="icon-wrench icon-2x"></i>
										<span ><br /></span>
									</a>
								</div>
							</div>
						</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								Header 
							</div>
						<div class="box-body">
							<div class="panel-body">
								<div class="row col-lg-12">
									<div class="form-group">
									<label for="norm" class="control-label col-md-1 text-center">Shift</label>
											<div class="col-md-2">
												<select name="txsShift" id="txsShift" class="form-control">
													<option value="">[Select Shift]</option>
													<option value="S1">SHIFT 1</option>
													<option value="S2">SHIFT 2</option>
													<option value="S3">SHIFT 3</option>
													<option value="SU">SHIFT UMUM</option>
													<option value="ST">TANGGUNG 1</option>
													<option value="T2">TANGGUNG 2</option>
													<option value="T3">TANGGUNG 3</option>
												</select>
											</div>
											<!-- <label for="norm" class="control-label col-md-1 text-center">Barcode</label> -->
											<div class="col-md-4">
												<input type="text" name="txtBarcode" id="txtBarcode" class="form-control" onChange="AddPinjamItem()" placeholder="[Barcode]" autofocus></input>
											</div>
											<div class="col-md-1">
												<a class="btn btn-md btn-default" id="showModalItem"><span class="fa fa-search"></span></a>
											</div>
											<div class="col-md-3">
											</div>
											<div class="col-md-1">
												<a class="btn btn-md btn-danger" onClick="clearListOutItem('0')" >Reset</a>
											</div>
											<!-- <div class="col-md-4">
												<select name="slcBarcode" id="slcBarcode" class="form-control select-item" onChange="AddPinjamItem()" style="width:100%;">
													<option value=""></option>
												</select>
											</div> -->
									</div>
								</div>
								<br>
								<div class="row col-lg-12">
									<table class="table table-striped table-bordered table-hover text-left table-create-peminjaman" id="table-create-peminjaman" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="5%">No.</th>
												<th width="15%"><center>Item Code</center></th>
												<th width="55%"><center>Item</center></th>
												<th width="10%"><center>Stock</center></th>
												<th width="10%"><center>Pinjam</center></th>
												<th width="5%"><center>Act</center></th>
											</tr>
										</thead>
										<tbody>
											<?php 
											if(!empty($itemOut)){
												$no = 0;
												foreach($itemOut as $itemOut_item){
														$no++;
														echo "
															<tr class='clone'>
																<td class='text-center'><span id='no'>".$no."</span></td>
																<td class='text-center item_id'>".$itemOut_item['item_id']."</td>
																<td class='item_name'>".$itemOut_item['item_name']."</td>
																<td class='text-center sisa_stok'>".$itemOut_item['sisa_stok']."</td>
																<td><input type='number' class='form-control item_out' name='txtQtyPinjam' id='txtQtyPinjam' value='".$itemOut_item['item_qty']."' style='100%'></input></td>
																<td class='text-center'><a onClick='removeListOutItem(\"".$itemOut_item['item_id']."\",\"0\",\"".$this->session->user."\")'><span class='fa fa-remove'></span></a></td>
															</tr>
														";
													}
												}
											?>
										</tbody>
									</table>
								</div>
								<br>
								<div class="row col-lg-12">
									<div class="form-group">
											<label for="norm" class="control-label col-md-1 text-center">Noind</label>
											<div class="col-md-2">
												<input type="text" name="txtNoind" onChange="getName()" id="txtNoind" class="form-control" placeholder="[Noind Pekerja]"></input>
											</div>
											<div class="col-md-4">
												<input type="text" name="txtName" id="txtName" class="form-control" placeholder="[Nama Pekerja]" readonly></input>
											</div>
											<div class="col-md-1">
												<a class="btn btn-md btn-default" id="showModalNoind"><span class="fa fa-search"></span></a>
											</div>
									</div>
								</div>
							</div>
							<div class="panel-footer">
								<div class="row text-right">
									<a href="<?php echo site_url('Toolroom/Transaksi/Keluar') ?>" class="btn btn-primary btn-lg btn-rect">Close</a>
									&nbsp;&nbsp;
									<a id="btnExecuteSave" class="btn btn-primary btn-lg btn-rect">Save</a>
								</div>
							</div>
						</div>
						</div>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</section>


<div class="modal fade" id="modalSearchItem" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #3c8dbc;">
			<b>- Pencarian Master Item -</b>
        </div>
        <div class="modal-body">
			<select name="slcModalBarcode" id="slcModalBarcode" onChange="copyItem()" class="form-control select-item" style="width:100%;">
				<option value=""></option>
			</select>
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="modalSearchNoind" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #3c8dbc;">
			<b>- List Pekerja -</b>
        </div>
        <div class="modal-body">
			<select name="slcNoind" id="slcModalNoind" class="form-control select-noind" onChange="copyPekerja()" style="width:100%;text-transform:uppercase;">
				<option value=""></option>
			</select>
        </div>
      </div>
    </div>
  </div>