<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
	#tbFilterPO tr td,#tbInvoice tr td{padding: 5px}
</style>

<!-- <form method="post" action="<?php echo base_url('AccountPayables/MonitoringInvoice/NewInvoice/addPoNumberAkt') ?>"> -->
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Add Invoice Bermasalah </b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<table id="tbInvoice" style="margin-left: 50px; margin-top: 20px" >
									<tr>
										<td>
											<span><label>Nama Vendor</label></span>
										</td>
										<td>
		                     				<select id="slcVendor" name="vendor_number" class="form-control select2 select2-hidden-accessible" style="width:320px;">
												<option value="" > Nama Vendor </option>
												<?php foreach ($allVendor as $av) { ?>
												<option value="<?php echo $av['VENDOR_ID'] ?>"><?php echo $av['VENDOR_NAME'] ?></option>
												<?php } ?>

											</select>
		                     			</td>
		                     			<td style="padding-left: 30px">
											<span><label>Nama Buyer</label></span>
										</td>
										<td>
											<input class="form-control" id="txtNamaBuyer" type="text" name="txtNamaBuyer" placeholder="Nama Buyer" >
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Invoice Number</label></span>
										</td>
										<td>
						                    <input type='text' class="form-control" id="txtInvoiceNumberIB" size="40" name="txtInvoiceNumberIB"  placeholder="Invoice Number">
										</td>
										<td style="padding-left: 30px">
											<span><label>Kelengkapan Dokumen</label></span>
										</td>
										<td>
											<select name="slcKelengkapanDokumen" id="slcKelengkapanDokumen" multiple class="form-control select2 select2-hidden-accessible" style="width:320px;">
												<option value="Invoice">Invoice</option>
												<option value="FP">FP</option>
												<option value="LPPB">LPPB</option>
												<option value="SJ">SJ</option> 
												<option value="Dokumen Lain">Dokumen Lain</option> 
											 </select>
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Nominal DPP</label></span>
										</td>
										<td>
											<input  class="form-control" type="text" name="txtNominalDPPIB" placeholder="Nominal DPP" id="txtNominalDPPIB">
										</td>
										<td style="padding-left: 30px">
											<span><label>Kategori</label></span>
										</td>
										<td >
											<select onchange="kategoriBermasalah(this)" name="slcKategori" id="slcKategori" class="form-control select2 select2-hidden-accessible" multiple style="width:320px;">
												<option value="Beda Harga">Beda Harga</option>
												<option value="Dokumen Tidak Lengkap">Dokumen Tidak Lengkap</option>
												<option value="Identitas Tidak Jelas">Identitas Tidak Jelas</option>
												<option value="LainLain">Lain Lain</option>
											 </select>
										</td>
										<td>
											<input type="text" style="width: 320px;" name="txtLainLain" id="inputLain">
										</td>
									</tr>
									<tr>
										<td>
											<span><label>Nominal DPP + PPN</label></span>
										</td>
										<td>
											<input class="form-control" type="text" name="txtNominalDPPplusPPNIB" placeholder="Nominal DPP + PPN" id="txtNominalDPPplusPPNIB" >
										</td>
										<td style="padding-left: 30px">
											<span><label>Nomor PO</label></span>
										</td>
										<td>
											<input class="form-control" type="text" name="txtNomorPO" placeholder="Nomor PO" id="txtNomorPO" >
										</td>
									</tr>
									<tr>
										<td>
											<span><label>No LPPB</label></span>
										</td>
										<td>
											<input class="form-control" type="text" name="txtNomorLPPB" placeholder="Nomor LPPB" >
										</td>
										
									</tr>
									<tr>
										<td><span><label>Keterangan</label></span></td>
									<td>
										<textarea class="form-control" id="txaKeterangan" name="txaKeterangan" placeholder="Keterangan"></textarea>
									</td>
								</tr>
								
							
								</table>
								<div class="col-md-12 pull-right">
							<button type="reset" id="btnMICancel" class="btn btn-danger pull-right" style=""><i class="fa fa-trash"></i> Clear</button>
							<button id="btnMISave" class="btn btn-success pull-right" style="margin-right:50px"><i class="fa fa-check"></i> Save</button>
								</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
</form>

<script type="text/javascript">
	
</script>