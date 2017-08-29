<section class="content">
	<div class="inner" >
		<div class="row">
			<form method="post" action="<?php echo site_url('Toolroom/Transaksi/updatePeminjaman')?>" class="form-horizontal">
					<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
					<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" id="hdnDate"/>
					<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" id="hdnUser"/>
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
											<label for="norm" class="control-label col-md-1 text-center">Barcode</label>
											<div class="col-md-3">
												<input type="text" name="txtBarcode" id="txtBarcode" class="form-control" onChange="UpdatePinjamItem()" placeholder="[Barcode]" autofocus></input>
												<input type="hidden" name="txtID" id="txtID" value="<?= $id_list ?>" class="form-control"></input>
											</div>
											<div class="col-md-1">
												<a class="btn btn-md btn-default" id="showModalItem"><span class="fa fa-search"></span></a>
											</div>
											<div class="col-md-5">
											</div>
											<div class="col-md-1">
												<a class="btn btn-md btn-danger" onClick="clearListOutItem('<?= $id_list ?>')" >Reset</a>
											</div>
									</div>
								</div>
								<br>
								<div class="row col-lg-12">
									<table class="table table-striped table-bordered table-hover text-left table-update-peminjaman" id="table-update-peminjaman" style="font-size:12px;">
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
											if(!empty($ListOutTransaction)){
												$no = 0;
												foreach($ListOutTransaction as $ListOutTransaction){
														$no++;
														echo "
															<tr class='clone-update'>
																<td class='text-center'><span id='no'>".$no."</span></td>
																<td class='text-center item_id'>".$ListOutTransaction['item_id']."</td>
																<td class='item_name'>".$ListOutTransaction['item_name']."</td>
																<td class='text-center sisa_stok'>".$ListOutTransaction['item_sisa']."</td>
																<td><input type='number' class='form-control item_out' name='txtQtyPinjam' id='txtQtyPinjam' value='".$ListOutTransaction['item_dipakai']."' style='100%'></input></td>
																<td class='text-center'><a onClick='removeListOutItem(\"".$ListOutTransaction['item_id']."\")'><span class='fa fa-remove'></span></a></td>
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
											<label for="norm" class="control-label col-md-1 text-center">Peminjam</label>
											<div class="col-md-2">
												<input type="text" name="txtNoind" onChange="getName()" value="<?= $noind_list ?>" id="txtNoind" class="form-control" placeholder="[Noind Pekerja]"></input>
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
									<a href="<?php echo site_url('Toolroom/MasterItem/UsableGroup') ?>" class="btn btn-primary btn-lg btn-rect">Close</a>
									&nbsp;&nbsp;
									<a id="btnExecuteUpdate" class="btn btn-primary btn-lg btn-rect">Update</a>
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
			<select name="txtBarcode" id="txtBarcode" class="form-control select-item" style="width:100%;">
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
			<select name="slcNoind" class="form-control select-noind" style="width:100%;text-transform:uppercase;">
				<option value=""></option>
			</select>
        </div>
      </div>
    </div>
  </div>