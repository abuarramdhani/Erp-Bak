<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}

	
.inputfile-1 + label {
    color: white;
    background-color: #5eb7b7;
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
        background-color: #5eb7b7;
       	font-family: sans-serif;
      }

      .itsfun1 {
        border-top-color: #5eb7b7;
      }

       .zoom {
  transition: transform .2s;
}

</style>
<?php echo form_open_multipart('MonitoringPengirimanPesananLuar/InputPurchaseOrder/updatePurchaseOrder/'.$edit[0]['id_rekap_po']) ?>
	<!-- <?php echo $error;?> -->
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span style="font-family: sans-serif;"><b><i class="fa fa-pencil-square-o"></i> Edit Purchase Order</b></span>
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
										<button type="button" class="btn btn-info pull-right flexi_form_title" data-step="3" data-intro="Selamat Bekerja :)" tooltip="panduan"><i class="fa fa-caret-square-o-right"></i> Panduan</button>
										</a> -->
										<div class="col-md-12">
											<table id="filter"
												class="col-md-12" style="margin-bottom: 20px;margin-left:50px">
													<tr>
																<td>
																	<span><label>Customer</label></span>
																</td>
																<td style="padding-right: 300px">
																	<select id="txtcustomer" name="txtcustomerUpd" class="selectPOHtml form-control select2" style="width:300px;" required="required">
																		<option value="" > Pilih  </option>
																		<?php foreach ($cust as $k) { 
																		$s='';
																	    if ($k['id_customer']==$edit[0]['id_customer']) {
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
																	<input class="form-control" style="width: 300px" type="text" id="txtNoPO" value="<?php echo $edit[0]['no_po'] ?>" name="txtNoPOUpd" placeholder="Masukkan No PO" required="required"></input>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>Tanggal Issued</label></span>
																</td>
																<td>
																	<input class="form-control" style="width: 300px" type="text" id="txdIssue" value="<?php echo $edit[0]['tanggal_issued']?>" name="txdIssueUpd" required="required"></input>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>Need By Date</label></span>
																</td>
																	<td>
																	<input class="form-control" style="width: 300px" type="text" id="txdNbd" value="<?php echo $edit[0]['need_by_date'] ?>" name="txdNbdUpd" required="required"></input>
																</td>
															</tr>
															<tr>
																<td>
																	<span><label>Lampiran</label></span>
																</td>
																<td  >
																		<input style="display: none;" type="file" id="file-1" class="inputfile inputfile-1" name="txfPdf2[]" />
																		<!-- data-multiple-caption="{count} files selected" -->
																		<label data-step="1" data-intro="Diperbolehkan mengganti file asalkan format masih .pdf atau .jpg (bukan .JPG)" for="file-1" name="test">

																			<span name="inijudul" ><i class="fa fa-cloud-upload"></i> <?php echo $edit[0]['lampiran'] ?> </span>

																		</label>
																</td>
															</tr>
															<tr>
																<td>
																	<input type="hidden" name="txhJudul" value="<?php echo $edit[0]['lampiran'] ?>">
																</td>
																
															</tr>
											</table>
										</div>
									</div>
								</div>
									<div class="col-md-12 pull-left">
										<button data-step="2" data-intro="Diperbolehkan menambah lines atau menghapus lines" id="newship" onclick="addRowMpplEditPO()" type="button" class="btn btn-primary pull-right zoom" style="margin-top: 10px; margin-bottom: 20px;"><i class="fa fa-plus"></i> Add</button>
									</div>
									<table class="table table-bordered table-hover text-center tblMPM">
										<thead class="toscahead">
											<tr class="bg-primary">
												<th style="width: 5%"  class="text-center">No</th>
												<th style="width: 25%" class="text-center">Kode Item</th>
												<th style="width: 35%" class="text-center">Deskripsi</th>
												<th style="width: 15%" class="text-center">Qty Order</th>
												<th style="width: 15%" class="text-center">Uom</th>
												<th style="width: 5%"  class="text-center">Action</th>
											</tr>
										</thead>
										<tbody id="tabelAddMpplEditPO">
											<?php $i=1; foreach ($line as $key => $value){ ?>
											<tr class="1">
												<td class="editnum"><?php echo $i ?></td>
												<td><input type="text" class="form-control 1 kodeItemClsPO" style="width: 100%" id="slcKodeItem" name="slcKodeItemUpd[]" value="<?php echo $value['kode_item']?>" readonly>    
												</td>
												<td><select onChange="cariKodeItemPO(this)" type="text" class="form-control select2 1 selectPOHtml deskripsiClsPO" style="width: 100%" id="txtDeskripsi" name="txtDeskripsiUpd[]">
													<option value="" > Pilih  </option>
																		<?php foreach ($item as $k) { 
																		$s='';
																	    if ($k['id']== $value['id_kode_item']) {
																			$s='selected';
																		}?>
																		<option value="<?php echo $k['id'] ?>" <?= $s?>><?php echo $k['nama_item'] ?></option>
																		<?php } ?>
													</select></td>
												<td><input type="number" class="form-control 1 QtyClsPO" style="width: 100%" id="txnQtyOrder" value="<?php echo $value['ordered_qty'] ?>" name="txnQtyOrderUpd[]">
												</td>
												<td><input type="text" value="<?php echo $value['uom'] ?>" class="form-control 1 UomClsPO" style="width: 100%" id="txtUom" name="txtUomUpd[]">
												</td>
												<td><button type="button" class="btnDeleteRow btn btn-danger zoom" onclick="deleteEdit2(this)"><i class="glyphicon glyphicon-trash"></i></button></td>
											</tr>
											<?php $i++; } ?>
										</tbody>
									</table>
								<div class="col-md-12">
									<button type="submit" id="btnSavePO" class="btn btn-success pull-right zoom" style="margin-top: 10px" ><i class="fa fa-check"></i> Save</button>
									<a href="<?php echo base_url('MonitoringPengirimanPesananLuar/RekapPurchaseOrder')?>" >
									<button id="btnCancel" class="btn btn-danger pull-right zoom" style="margin-top: 10px;margin-right: 10px;" ><i class="fa fa-exclamation"></i> Cancel</button>
								</a>
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
</form>

<script type="text/javascript">
$(document).ready(function(){
	$('.selectPOHtml').select2({
		  placeholder: 'Pilih',
		  allowClear: true,
		});
});

$("#flexi_form_start").click(function() {
    introJs().start();
  });

$(document).ready(function(){

	$('#txdIssue').datepicker({
		format: 'dd M yyyy',
		autoclose: true,
	});

	$('#txdNbd').datepicker({
		format: 'dd M yyyy',
		autoclose: true,
	});
	});
</script>
