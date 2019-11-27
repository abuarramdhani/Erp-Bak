<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}

	
.inputfile-1 + label {
    color: white;
    background-color: #14868c;
}
.inputfile + label {
    max-width: 80%;
    font-size: 1.25rem;
    text-overflow: ellipsis;
    white-space: nowrap;
    cursor: pointer;
    display: inline-block;
    overflow: hidden;
    padding: 0.625rem 1.25rem;
    font-family: sans-serif;
    border-radius: 400px;
}

thead.toscahead tr th {
        background-color: #14868c;
       	font-family: sans-serif;
      }

      .itsfun1 {
        border-top-color: #14868c;
      }

</style>
<!-- <?php echo form_open_multipart('MonitoringPengirimanPesananLuar/InputPurchaseOrder/submitPurchaseOrder') ?> -->
	<!-- <?php echo $error;?> -->
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span style="font-family: sans-serif;"><b><i class="fa fa-pencil-square-o"></i> Tambah Pengiriman</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box itsfun1">
							<div class="box-header with-border">
					  		</div>
							<div class="box-body">
								<div class="box box-white box-solid">
									<div class="box-body">
										<!-- <a id="flexi_form_start" href="javascript:void(0);">
										<button type="button" class="btn btn-info pull-right flexi_form_title" data-step="11" data-intro="Selamat Bekerja :)" tooltip="panduan"><i class="fa fa-caret-square-o-right"></i> Panduan</button>
										</a> -->
										<div class="col-md-12">
											<table id="filter"
												class="col-md-12" style="margin-bottom: 20px;margin-left:50px">
													<tr>
																<td>
																	<span><label>Customer</label></span>
																</td>
																<td style="padding-right: 300px">
																	<select data-step="1" data-intro="Pilih customer untuk memuat PO" id="slcCustomerPeng" name="slcCustomerPeng" class="form-control select2 select2-hidden-accessible selectCustPeng" onchange="onchangePOPengiriman()" style="width:300px;" required="required">
																		<option value="" > Pilih  </option>
																		 <?php foreach ($cust as $k) { ?>
																		<option value="<?php echo $k['id_customer'] ?>"><?php echo $k['nama_customer'] ?></option>
																		<?php } ?>
																	</select>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>Nomor PO</label></span>
																</td>
																<td>
																	<select id="slcNoPoPengiriman" data-step="2" data-intro="Pilih No PO untuk memuat data Purchase Order" name="slcNoPO" class="form-control select2 select2-hidden-accessible slcPo" style="width:300px;" onchange="pilihPO(this)" required="required">
																		<option value="" > Pilih  </option>
																	</select>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>No. SO</label></span>
																</td>
																<td>
																	<input placeholder="Masukkan Nomor SO" data-step="3" data-intro="Masukkan Nomor So" class="form-control" style="width: 300px" type="text" id="txtNoSO" name="txtNoSO" required="required"></input>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>No. DOSP</label></span>
																</td>
																	<td>
																	<input placeholder="Masukkan Nomor DOSP" data-step="4" data-intro="Masukkan Nomor DOSP" class="form-control" style="width: 300px" type="text" id="txtDOSP" name="txtDOSP" required="required"></input>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>Keterangan</label></span>
																</td>
																<td>
																		<textarea data-step="5" data-intro="Masukkan Keterangan" class="form-control" style="width: 300px" placeholder="Masukkan Keterangan" name="txaKeterangan" id="txaKeterangan"></textarea>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>Ekspedisi</label></span>
																</td>
																<td>
																	<select data-step="6" data-intro="Pilih Ekspedisi" id="slcEkspedisi" name="slcEkspedisi" class="form-control select2 select2-hidden-accessible" style="width:300px;" required="required">
																		<option value="" > Pilih  </option>
																		 <?php foreach ($ekspedisi as $k) { ?>
																		<option value="<?php echo $k['id_ekspedisi'] ?>"><?php echo $k['nama_ekspedisi'] ?></option>
																		<?php } ?>
																	</select>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>Delivery Date</label></span>
																</td>
																<td>
																	<input data-step="7" data-intro="Pilih Tanggal Delivery" class="form-control datedeliver" style="width: 300px" type="text" id="txdDeliveryDate" placeholder="Masukkan Delivery Date" name="txdDeliveryDate" required="required"></input>
																</td>
															</tr>
															<tr>
																
															</tr>
											</table>
										</div>
									</div>
								</div>
									<table class="table table-bordered table-hover text-center tblMPM">
										<thead class="toscahead"> 
											<tr class="bg-primary">
												<th style="width: 5%"  class="text-center">No</th>
												<th style="width: 15%" class="text-center">Kode Item</th>
												<th style="width: 25%" class="text-center">Deskripsi</th>
												<th style="width: 10%" class="text-center">Qty Order</th>
												<th style="width: 10%" class="text-center">Delivered</th>
												<th style="width: 10%" class="text-center">ACC </th>
												<th style="width: 10%" class="text-center">Out PO</th>
												<th style="width: 15%" class="text-center">Uom</th>
											</tr>
										</thead>
										<tbody id="tblViewInputPengiriman">
											<!-- <?php echo $no=1; foreach ($lines as $key => $value) { ?> -->
											<tr class="bakso">
												<td><?php echo $no; ?></td>
												<td><select onChange="cariKodeItemPO(this)" type="text" class="form-control select2 1 selectPOHtml kodeItemClsPO" style="width: 100%" id="slcKodeItem" name="slcKodeItemUpd[]">
													<!-- <option value="" > Pilih  </option>
														<?php foreach ($item as $k) { 
															$s='';
														if ($k['id']==$value['id_kode_item']) {
															$s='selected';
															}?>
														<option value="<?php echo $k['id'] ?>" <?= $s?>><?php echo $k['kode_item'] ?></option>
													<?php } ?> -->
												</td>
												<td><input type="text" class="form-control deskripsiClsIP" style="width: 100%" id="txtDeskripsi" name="txtDeskripsi[]"></td>
												<td><input type="number" class="form-control QtyClsIP" style="width: 100%" id="txnQtyOrder" name="txnQtyOrder[]">
												</td>
												<td><input data-step="8" data-intro="Masukkan nominal deliver" type="number" class="form-control deliveredClsIP" style="width: 100%" id="txnDelivered" name="txnDelivered[]" >
												</td>
												<td><input data-step="9" data-intro="Pastikan nominal Accumulation benar" type="number" class="form-control ACCClsIP" style="width: 100%" id="txnACC" name="txnACC[]">
												</td>
												<td><input data-step="9" data-intro="Pastikan nominal Outstanding PO benar" type="number" class="form-control OutPoClsIP" style="width: 100%" id="txnOutPO" name="txnOutPO[]">
												</td>
												<td><input type="text" class="form-control UomClsIP" style="width: 100%" id="txtUom" name="txtUom[]">
												</td>
												<td><button type="button" class="btnDeleteRow btn btn-danger" onclick="onClickBakso(1)" disabled><i class="glyphicon glyphicon-trash"></i></button></td>
											</tr>
											<!-- <?php $no++;} ?> -->
										</tbody>
									</table>
								<div class="col-md-12">
									<button data-step="10" data-intro="Save jika sudah dirasa benar" onclick="saveInputPengiriman()" id="btnSaveIP" class="btn btn-success pull-right" style="margin-top: 10px" ><i class="fa fa-check"></i> Save</button>
									<button id="btnCancel" onclick="backIP()" class="btn btn-danger pull-right" style="margin-top: 10px;margin-right: 10px;" ><i class="fa fa-exclamation"></i> Cancel</button>
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
<!-- </form> -->

<script type="text/javascript">
	$("#flexi_form_start").click(function() {
    introJs().start();

  
  });

	  $(document).ready(function(){

	$('.datedeliver').datepicker({
		format: 'dd M yyyy',
		autoclose: true,
	});
	});
</script>
