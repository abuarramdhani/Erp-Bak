<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b>Report Detail Invoice</b></h1>
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="#">
									<i class="icon-file-text icon-2x"></i>
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
								Parameter Pencarian
							</div>
							<div class="box-body">
								<fieldset class="row2" style="background:#F8F8F8 ;">
								 	<form action="<?php echo base_URL('AccountPayables/Report/exportDetailInvoice')?>" method="post" enctype="multipart/form-data" id="pph">
				                    	<div class="box-body">

					                     	<table>
					                     		<tr>
					                     			<td width="150px">
					                     				<label>Date Periode</label>
					                     			</td>
					                     			<td width="200px">
					                     				<input type="text" name="DInvoiceStr" class="DInvoicePrd" style="width: 45%;"> - 
					                     				<input type="text" name="DInvoiceEnd" class="DInvoicePrd" style="width: 45%;">
					                     			</td>
					                     		</tr>
					                     		<tr>
					                     			<td>
					                     				<br/>
					                     			</td>
					                     		</tr>
					                     	</table>
					                     	<table>	
					                     		<tr>
					                     			<td width="150px">
					                     				<label for="exampleInputPassword1">Vendor Name</label>
					                     			</td>
					                     			<td>
					                     				<select id="DInvoiceVdr" name="DInvoiceVdr[]" style="width:265px;" multiple="multiple">
															<?php foreach ($Vendor as $vdr) {
																echo "<option>".$vdr['VENDOR_NAME']."</option>";
															}; ?>
														</select>
					                     			</td>
					                     		</tr>
												<tr>
													<td>
														<br>
													</td>
												</tr>
					                     	</table>
										</div>
							 	</fieldset>
							 	<div class="box-footer">
									<button type="submit" class="btn btn-primary btn-sm" id="srcDetailInvoice"><b>Cari Data</b></button>
				            	</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


		