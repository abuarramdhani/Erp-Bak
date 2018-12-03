<section class="content">
	<div class="inner" >
		<div class="row">
			<form method="post" action="<?php echo site_url('Warehouse/Transaksi/savePeminjaman')?>" class="form-horizontal">
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
									<a class="btn btn-default btn-lg" href="<?php echo site_url('Warehouse');?>">
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
												<input type="text" name="txtBarcode" id="txtBarcode" class="form-control" onChange="AddPengembalianItemWh('<?= $list_id ?>','<?= $list_date ?>')" placeholder="[Barcode]" autofocus></input>
											</div>
											<div class="col-md-1">
												<a class="btn btn-md btn-default" id="showModalItem"><span class="fa fa-search"></span></a>
											</div>
											<div class="col-md-3">
											</div>
											<div class="col-md-1">
												<input type="text" class="form-control" value="<?= $list_id ?>" readonly></input>
											</div>
											<div class="col-md-3">
												<input type="text" class="form-control" value="<?= $list_date ?>" readonly></input>
											</div>
									</div>
								</div>
								<br>
								<div class="row col-lg-12">
									<table class="table table-striped table-bordered table-hover text-left table-create-pengembalian-today" id="table-create-pengembalian-today" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="5%"><center>No</center></th>
												<th width="10%"><center>Tanggal</center></th>
												<th width="10%"><center>Tool Code</center></th>
												<th width="35%"><center>Tool</center></th>
												<th width="10%"><center>Qty Item</center></th>
												<th width="10%"><center>Qty Dipinjam</center></th>
												<th width="10%"><center>Qty Kembali</center></th>
												<th width="10%"><center>Qty Sisa</center></th>
											</tr>
										</thead>
										<tbody>
											<?php
												if(!empty($ListOutTransaction)){
													$no = 0;
													foreach($ListOutTransaction as $ListOutTransaction_item){
														$no++;
														echo "
															<tr>
																<td class='text-center'>".$no."</td>
																<td class='text-center'>".$ListOutTransaction_item['tgl_transaksi']."</td>
																<td class='text-center'>".$ListOutTransaction_item['item_id']."</td>
																<td>".$ListOutTransaction_item['item_name']."</td>
																<td class='text-center'>".$ListOutTransaction_item['item_qty']."</td>
																<td class='text-center'>".$ListOutTransaction_item['qty_pinjam']."</td>
																<td class='text-center'>".$ListOutTransaction_item['qty_kembali']."</td>
																<td class='text-center'>".$ListOutTransaction_item['qty_kembali']."</td>
															</tr>
														";
													}
												}
											?>
										</tbody>
									</table>
								</div>
								<br>
							</div>
							<div class="panel-footer">
								<div class="row text-right">
									<a href="<?php echo site_url('Warehouse/Transaksi/Keluar') ?>" class="btn btn-primary btn-lg btn-rect">Back</a>
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
			<select name="txtBarcode" id="txtBarcode" class="form-control select-item-wh" style="width:100%;">
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
			<select name="slcNoind" class="form-control select-noind-wh" style="width:100%;text-transform:uppercase;">
				<option value=""></option>
			</select>
        </div>
      </div>
    </div>
  </div>