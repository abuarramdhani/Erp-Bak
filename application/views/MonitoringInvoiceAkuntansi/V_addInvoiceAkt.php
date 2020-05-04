<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
</style>

<!-- <div style="background-color: black; width: 100%; height: 100%">
</div> -->

<form method="post" action="<?php echo base_url('AccountPayables/MonitoringInvoice/NewInvoice/addPoNumberAkt') ?>">
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12 div_loading">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Add Invoice Akuntansi</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-8">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<table id="tbInvoice" >
									<tr>
										<td>
											<span><label>Nomor PO</label></span>
										</td>
										<td>
											<input data-toggle="tooltip" data-placement="top" title="Jika Nomor PO tidak dicantumkan, harap isi dengan 0" placeholder="Nomor PO" type="text" name="txtNoPO" class="ininopo form-control" size="40" id="nomorPOID">
		                     			</td>
		                     			<td>
		                     				<button type="button" id="btnCariTop" class="btn btn-success"> Cari </button>
		                     			</td>
									</tr>
									<tr>
										<td>
											<span><label>Vendor</label></span>
										</td>
										<td>
		                     				<select onchange="iniVendor()" id="slcVendor" name="vendor_number" class="vendorNameClass form-control select2 select2-hidden-accessible" style="width:320px;">
												<option value="" > Nama Vendor </option>
												<?php foreach ($allVendor as $av) { ?>
												<option value="<?php echo $av['VENDOR_ID'] ?>"><?php echo $av['VENDOR_NAME'] ?></option>
												<?php } ?>

											</select>
											<input type="hidden" class="hdnTextForVendor" id="hdnTxt" name="hdnTxtVendor">
		                     			</td>
		                     			<td>
		                     				<span><label>(*) Untuk cari nama vendor, TOP, dan status PPN. <br>Harap klik tombol 'Cari'</label></span>
		                     			</td>
									</tr>
									<tr>
										<td>
											<span><label>Term of Payment</label></span>
										</td>
										<td>
											<input placeholder="Term of Payment" type="text" name="txtToP" class="form-control termOfPayment" size="40" id="termOfPayment">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>PPN Status</label></span>
										</td>
										<td>
											<select name="ppn_status" id="ppn_status" class="form-control select2 select2-hidden-accessible" style="width:320px;">
												<option value="">Pilih</option>
												<option value="Y">Y</option>
												<option value="N">N</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Date</label></span>
										</td>
										<td>
						                    <input placeholder="Wajib diisi" type='text' class="form-control idDateInvoice" id="invoice_dateid" size="40" name="invoice_date"  placeholder="Invoice Date">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Number</label></span>
										</td>
										<td>
											<input placeholder="Wajib diisi" class="form-control" size="40" type="text" name="invoice_number" placeholder="No. Invoice" id="invoice_numbergenerate">
										</td>
										<td>
											<button type="button" class="btn btn-primary" id="btnGenerate">Generate</button>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Amount</label></span>
										</td>
										<td>
										
											<input placeholder="Wajib diisi" class="form-control" size="40" type="text" name="invoice_amount" placeholder="Invoice Amount" id="inv_amount_akt">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Category</label></span>
										</td>
										<td>
											<select name="invoice_category" id="invoice_category" class="form-control select2 select2-hidden-accessible" style="width:320px;">
												<option value="">Pilih</option>
												<option value="BARANG">BARANG</option>
												<option value="JASA NON EKSPEDISI TRAKTOR">JASA NON EKSPEDISI TRAKTOR</option>
												<option value="JASA EKSPEDISI TRAKTOR">JASA EKSPEDISI TRAKTOR</option>
												<!-- reupload -->
												<!-- reupload -->
											</select>
										</td>
										
									</tr>
									<tr>
										<td>
											<span><label>Tax Invoice Number</label></span>
										</td>
										<td>
											
											<select name="tax_invoice_number" id="tax_status" class="form-control select2 select2-hidden-accessible" style="width:320px;">
												<option value="">Pilih</option>
												<option value="Y">YES</option>
												<option value="N">NO</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Jenis Dokumen</label></span>
										</td>
										<td>
											<select name="jenis_dokumen" id="jenis_dokumen" class="form-control select2 select2-hidden-accessible" style="width:320px;">
												<option value="">Pilih</option>
												<option value="Asli">Asli</option>
												<option value="Copy">Copy</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Info</label></span>
										</td>
										<td>
											<textarea class="form-control" size="40" type="text" name="note_admin" placeholder="Jika status PPN 'Y' namun Tax Invoice bernilai 'N' wajib isi alasan di kolom info"></textarea>
										</td>
									</tr>
								</table>
						
								<div class="col-md-12">
									<div class="col-md-12">
										<div class="col-md-6">
									
								</div>
							</div>
						</div>
						
						<div class="col-lg-8">
							<!-- <a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Invoice')?>"> -->
							<button type="reset" id="btnMICancel" class="btn btn-danger pull-left" style="margin-top: 10px;">Clear</button>
							<!-- </a> -->
							<button id="btnMISave" class="btn btn-success pull-left" style="margin-top: 10px;margin-left: 5px;" >Save</button>
						</div>
					<!-- </div> -->
				<!-- </div> -->
			</div>
		</div>
	</div>
</section>
</form>

<!-- <div class="modal fade in show" id="loadingRequest" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
  <div style="transform: translateY(50%);" class="modal-dialog modal-sm">
    <div class="">
      <div class="modal-body">
        <div class="loader"></div>
        <div clas="loader-txt">
          	<center>
          		<img id='loading12' style='width:200px ;margin-top: 2%;' src='<?php echo base_url('assets/img/gif/loadingquick.gif')?>'/>
          		<br />
          	</center><br />
        </div>
      </div>
    </div>
  </div>
</div> -->


<script type="text/javascript">

$( window ).load(function() { 
	// $('#loadingRequest').modal({
 //      backdrop: "static",
 //      show: true,
 //      keyboard: false
 //    });
 //    setTimeout(function() {
 //      $('#loadingRequest').modal('hide');
 //    }, 200);
 //    setTimeout(function() {
	  $("#nomorPOID").focus();
    // }, 500);

  // setTimeout(function(){console.log('yenk'); $("#nomorPOID").focus();},3000);
  // alert("yenk");
});



</script>
