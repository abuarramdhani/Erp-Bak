<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b>Pencarian Invoice</b></h1>
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
								 	<form action="<?php echo base_URL('AccountPayables/C_Invoice/search')?>" method="post" enctype="multipart/form-data" id="pph">
				                    	<div class="box-body">

					                     	<table>
					                     		<tr>
					                     			<td width="150px">
					                     				<label for="exampleInputPassword1">Date Periode</label>
					                     			</td>
					                     			<td>
					                     				<div class="input-group">
														<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
														<div class="date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
															<input id="tanggal_akhir" onkeypress="return hanyaAngka(event, false)" class="form-control datepicker" value="<?php echo date('Y-m-d'); ?>"  data-date-format="yyyy-mm-dd" type="text" name="tanggal_awal" riquaite placeholder=" Date" autocomplete="off">
														</div>
														</div>
					                     			</td>
					                     			<td width="50px" align="center">
					                     			s/d
					                     			</td>
					                     			<td>
					                     				<div class="input-group">
														<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
														<div class="date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
															<input id="tanggal_awal" onkeypress="return hanyaAngka(event, false)" class="form-control datepicker" value="<?php echo date('Y-m-d'); ?>"  data-date-format="yyyy-mm-dd" type="text" name="tanggal_akhir" riquaite placeholder=" Date" autocomplete="off">
														</div>
													</div>
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
					                     				<label for="exampleInputPassword1">Supplier</label>
					                     			</td>
					                     			<td>
					                     				<select id="slcSupplier" name="supplier" class="form-control select2" style="width:265px;">
															<option value="">- pilih -</option>
														</select >
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
					                     				<label for="exampleInputPassword1">Invoice Number</label>
					                     			</td>
					                     			<td>
					                     				<select id="slcInvoiceNumber" name="invoice_number" class="form-control select2" style="width:265px;">
															<option value="">- pilih -</option>
														</select >
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
					                     				<label for="exampleInputPassword1">Invoice Status</label>
					                     			</td>
					                     			<td>
					                     				<select id="" name="invoice_status" class="form-control" style="width:265px;">
															<option value="1">All Invoice</option>
															<option value="2">With Tax Invoice</option>
															<option value="3">Without Tax Invoice</option>
														</select >
					                     			</td>
					                     		</tr>
					                     	</table>

										</div>
							 	</fieldset>
							 	<div class="box-footer">
									<button type="submit" class="btn btn-primary btn-sm" id="save"><b>Cari Data</b></button>
									<!-- <a class="btn btn-danger btn-sm" title="Edit" class="btn btn-default leftmargin"  onclick="test2()" > Cancel</a> -->
				            	</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	</div>
</section>


		