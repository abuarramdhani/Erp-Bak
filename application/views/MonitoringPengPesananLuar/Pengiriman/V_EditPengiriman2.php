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
<section class="content" >
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span style="font-family: sans-serif;"><b><i class="fa fa-pencil-square-o"></i> Edit PO. <?php echo $header[0]['no_po']?> Pengiriman  Ke- <?php echo $judul[0]['count'] ?></b></span>
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
										<button type="button" data-toggle="modal" data-target="mdlPengiriman" class="btn btn-default zoom pull-right" style="margin-left: 5px" onclick="openHistoryPengiriman(<?php echo $header[0]['id_rekap_pengiriman']?>)" class="btnMdlHis" id="btnMdlHis"><i class="fa fa-clock-o"></i> History</button>

										<a id="flexi_form_start" href="javascript:void(0);">
										<button class="btn btn-info pull-right flexi_form_title" data-step="8" data-intro="Selamat Bekerja :)" tooltip="panduan"><i class="fa fa-caret-square-o-right"></i> Panduan</button>
										</a>

										<a href="<?php echo base_url('MonitoringPengirimanPesananLuar/RekapPengiriman/TambahPengiriman/'.$header[0]['id_rekap_pengiriman'])?>">
										<button type="button" class="btn btn-primary zoom pull-right" style="margin-right: 5px" class="btnMdlHis" id="btnMdlHis"><i class="fa fa-plus"></i> Tambah </button>
										</a>

										<div class="col-md-12">
											<table id="filter"
												class="col-md-12" style="margin-bottom: 20px;margin-left:50px">
													<tr>
																<td>
																	<span><label>Customer</label></span>
																</td>
																<td style="padding-right: 300px">
																	<select disabled id="slcCustomerPengEd" name="slcCustomerPeng" class="form-control select2 select2-hidden-accessible selectCustPeng" onchange="onchangePOPengiriman()" style="width:300px;" required="required">
																		<option value="" > Pilih  </option>
																		<?php foreach ($cust as $k) { 
																		$s='';
																	    if ($k['id_customer']==$header[0]['id_customer']) {
																			$s='selected';
																		}?>
																		<option value="<?php echo $k['id_customer'] ?>" <?= $s?>><?php echo $k['nama_customer'] ?></option>
																		<?php } ?>
																	</select>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>Nomor PO</label></span>
																</td>
																<td>
																	<select disabled id="slcNoPoPengiriman" name="slcNoPO" class="form-control select2 select2-hidden-accessible slcPo" style="width:300px;" onchange="pilihPOEdit(this)" required="required">
																		<option value="" > Pilih  </option>
																		<?php foreach ($po as $k) { 
																		$s='';
																	    if ($k['no_po']==$header[0]['no_po']) {
																			$s='selected';
																		}?>
																		<option value="<?php echo $k['no_po'] ?>" <?= $s?>><?php echo $k['no_po'] ?></option>
																		<?php } ?>
																	</select>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>No. SO</label></span>
																</td>
																<td>
																	<input disabled class="form-control" style="width: 300px" type="text" id="txtNoSOEd" name="txtNoSO" value="<?php echo $header[0]['no_so']?>" required="required"></input>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>No. DOSP</label></span>
																</td>
																	<td>
																	<input disabled class="form-control" style="width: 300px" type="text" id="txtDOSPEd" name="txtDOSP" value="<?php echo $header[0]['no_dosp']?>" required="required"></input>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>Keterangan</label></span>
																</td>
																<td>
																		<textarea class="form-control" style="width: 300px" placeholder="Masukkan Keterangan" name="txaKeterangan" id="txaKeteranganEd"><?php echo $header[0]['keterangan']?></textarea>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>Ekspedisi</label></span>
																</td>
																<td>
																	<select id="slcEkspedisiEd" name="slcEkspedisi" class="form-control select2 select2-hidden-accessible" style="width:300px;" required="required">
																		<?php foreach ($ekspedisi as $k) { 
																		$s='';
																	    if ($k['id_ekspedisi']==$header[0]['id_ekspedisi']) {
																			$s='selected';
																		}?>
																		<option value="<?php echo $k['id_ekspedisi'] ?>" <?= $s?>><?php echo $k['nama_ekspedisi'] ?></option>
																		<?php } ?>
																	</select>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>Delivery Date</label></span>
																</td>
																<td>
																	<input value="<?php echo $header[0]['delivery_date']?>" class="form-control deldate" style="width: 300px" type="text" id="txdDeliveryDate" name="txdDeliveryDate" required="required"></input>
																</td>
															</tr>
											</table>
										</div>
									</div>
								</div>
									<table class="table table-bordered table-hover text-center tblMPM" data-step="1" data-intro="Berikut ini panduan untuk mengedit form pengiriman">
										<thead class="toscahead"> 
											<tr class="bg-primary">
												<th style="width: 5%"  class="text-center">No</th>
												<th style="width: 15%" class="text-center">Kode Item</th>
												<th style="width: 25%" class="text-center">Deskripsi</th>
												<th style="width: 10%" class="text-center">Qty Order</th>
												<th data-step="2" data-intro="Isilah form di kolom Delivered"style="width: 10%" class="text-center">Delivered</th>
												<th style="width: 10%" class="text-center">ACC </th>
												<th style="width: 10%" class="text-center">Out PO</th>
												<th style="width: 15%" class="text-center">Uom</th>
												<th style="width: 15%; display: none;" class="text-center">ID</th>
												<th style="width: 15%;" class="text-center">Reset</th>

											</tr>
										</thead>
										<tbody id="tblViewInputPengiriman">
											<?php $no=1; foreach ($lines as $key => $value) { ?>
											<tr class="bakso">
												<td><?php echo $no; ?></td>
												<td><input disabled id="txtKodeItemEd" type="text" class="form-control" value="<?php echo $value['kode_item']?>">
												</td>
												<td><input disabled type="text" value="<?php echo $value['nama_item']?>" class="form-control deskripsiClsIP2" style="width: 100%" id="txtDeskripsiEd" name="txtDeskripsi[]"></td>
												<td><input disabled type="number" value="<?php echo $value['ordered_qty']?>" class="form-control QtyClsIP QtyClsIP2" style="width: 100%" id="txnQtyOrderEd" name="txnQtyOrder[]">
												</td>
											<!-- 	<?php if ($value['outstanding_qty'] == '') {
													# code...
												} ?> -->
												<td data-step="3" data-intro="Apabila value pengiriman pertama sama dengan pengiriman kedua, maka hapus value pertama, klik tab, kemudian masukkan value yang sama"><input disabled value="<?php echo $value['delivered_qty']?>" max="<?php echo $value['ordered_qty']?>" onkeyup="if(this.value > <?php echo $value['ordered_qty']?>) this.value = null" onchange="functionDelivered3(this)"type="number" class="form-control deliveredClsIP2 deliveredClsIP" style="width: 100%" id="txnDeliveredEd" name="txnDelivered[]" >
												</td>
												<td data-step="5" data-intro="Pastikan pula value Accumulation sudah benar"><input disabled type="number" value="<?php echo $value['accumulation']?>" class="form-control ACCClsIP ACCClsIP2" style="width: 100%" id="txnACCEd" name="txnACC[]">
												</td>
												<td data-step="4" data-intro="Pastikan value Outstanding sesuai dengan perhitungan"><input disabled type="number" value="<?php echo $value['outstanding_qty']?>" class="form-control OutPoClsIP OutPoClsIP2" style="width: 100%" id="txnOutPOEd" name="txnOutPO[]">
												</td>
												<td><input disabled type="text" value="<?php echo $value['uom']?>" class="form-control UomClsIP" style="width: 100%" id="txtUomEd" name="txtUom[]">
												</td>
												<td style="display: none"><input disabled type="hidden" value="<?php echo $value['id_line_rp']?>" class="form-control " style="width: 100%" id="txtIdLIneEd" name="txtUom[]">
												</td>
												<td style="display: none"><input disabled type="hidden" value="<?php echo $value['id_action_detail']?>" class="form-control " style="width: 100%" id="txtActionDetail" name="txtUom[]">
												</td>
												<td><button onclick="Resetdata(this)" data-step="6" data-intro="Jika dirasa input salah, tekan button Reset untuk mengulang proses input" id="btnReset" class="btn btn-danger pull-right" style="margin-top: 10px;margin-left: 10px;" ><i class="fa fa-times"></i></button></td>
											</tr>
											<?php $no++;} ?>
										</tbody>
									</table>
								<div class="col-md-12">

									<button data-step="7" data-intro="Jika sudah benar dalam perhitungan, klik button Save" onclick="saveEditPengiriman(<?php echo $header[0]['id_rekap_pengiriman']?>)" id="btnSaveIP" class="btn btn-success pull-right" style="margin-top: 10px" ><i class="fa fa-check"></i> Save</button>
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

	$('.deldate').datepicker({
		format: 'dd M yyyy',
		autoclose: true,
	});

	});
</script>

<div class="modal fade mdlPengiriman"  id="mdlPengiriman" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-sm" style="width:1200px;" role="document">
        <div class="modal-content">
            <div class="modal-header" style="width: 100%;" >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body" style="width: 100%;">
                	<div class="modal-tabel" >
					</div>
                   
                    	<div class="modal-footer">
                    		<div class="col-md-2 pull-left">
                    		</div>
                    	</div>
                </div>
            </form>
        </div>
    </div>
</div>
