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
								Hasil Pencarian
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
														<div class="date" data-date="" data-date-format="dd-M-yyyy" data-link-field="dtp_input2" data-link-format="dd-M-yyyy">
															<input id="tanggal_akhir_pilih" onkeypress="return hanyaAngka(event, false)" class="form-control datepicker" value="<?php echo $tanggal_awal; ?>"  data-date-format="dd-M-yyyy" type="text" name="tanggal_awal" riquaite placeholder=" Date" autocomplete="off">
														</div>
														</div>
					                     			</td>
					                     			<td width="50px" align="center">
					                     			s/d
					                     			</td>
					                     			<td>
					                     				<div class="input-group">
														<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
														<div class="date" data-date="" data-date-format="dd-M-yyyy" data-link-field="dtp_input2" data-link-format="dd-M-yyyy">
															<input id="tanggal_awal_pilih" onkeypress="return hanyaAngka(event, false)" class="form-control datepicker" value="<?php echo $tanggal_akhir; ?>" data-date-format="dd-M-yyyy" type="text" name="tanggal_akhir" riquaite placeholder=" Date" autocomplete="off">
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
					                     					<?php
					                     						if($supplier == ''){
					                     							echo "<option value=''>- pilih -</option>";
					                     						}else{
					                     							echo "<option value='$supplier'>$supplier</option>";
					                     						}
					                     					?>
															
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
					                     				<input id="slcInvoiceNumber_deactive" name="invoice_number" class="form-control select2_deactive" style="width:265px; text-transform: uppercase;" value="<?php echo $invoice_number;?>">
														
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
					                     				<select id="invStat" name="invoice_status" class="form-control" style="width:265px;">
					                     					<?php
					                     						if($invoice_status == 1){
					                     							echo '<option value="1" selected>All Invoice</option>';
					                     						}else{
					                     							echo '<option value="1">All Invoice</option>';
					                     						}

					                     						if($invoice_status == 2){
					                     							echo '<option value="2" selected>With Tax Invoice</option>';
					                     						}else{
					                     							echo '<option value="2">With Tax Invoice</option>';
					                     						}

					                     						if($invoice_status == 3){
					                     							echo '<option value="3" selected>Without Tax Invoice</option>';
					                     						}else{
					                     							echo '<option value="3">Without Tax Invoice</option>';
					                     						}
					                     					?>
															<!-- <option value="1">All Invoice</option>
															<option value="2">With Tax Invoice</option>
															<option value="3">Without Tax Invoice</option> -->
														</select >
					                     			</td>
					                     		</tr>
												<tr>
													<td>
														<br>
													</td>
												</tr>
					                     	</table>
											<table>	
					                     		<tr>
					                     			<td width="150px">
					                     				<label for="exampleInputPassword1">Voucher Number</label>
					                     			</td>
					                     			<td>
					                     				<input id="slcVoucherNumber_deactive" name="voucher_number" class="form-control select2_deactive" style="width:265px;" value="<?php echo $voucher_number;?>">
															
					                     			</td>
					                     		</tr>
					                     	</table>

										</div>
							 	</fieldset>
							 	<div class="box-footer">
									<button type="submit" class="btn btn-primary btn-sm" id="sbmt"><b>Cari Data</b></button>
									<a id="ClearSearch" class="btn btn-danger btn-sm"><b>Clear</b></a>
									<!-- <a class="btn btn-danger btn-sm" title="Edit" class="btn btn-default leftmargin"  onclick="test2()" > Cancel</a> -->
									<div style="float: right;">
									<a href="<?php echo base_URL('AccountPayables/Invoice/faktursa') ?>" id="fti" class="btn btn-info btn-lg">Faktur tanpa Invoice</a>
									</div>
				            	</div>

				            	<div class="table-responsive">
									
									<table class="table table-striped table-bordered table-hover text-left" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="5%"><center>No</center></th>
												<th width="10%"><center>Invoice Number</center></th>
												<th width="10%"><center>Supplier</center></th>
												<th width="10%"><center>Invoice Date</center></th>
												<th width="10%"><center>Product</center></th>
												<th width="10%"><center>DPP</center></th>
												<th width="10%"><center>PPN</center></th>
												<th width="15%"><center>QR Code Invoice</center></th>
												<th width="15%"><center>Tax Invoice Number</center></th>
												<th width="10%"><center>Voucher Number</center></th>
												<th width="15%"><center>Action</center></th>
											</tr>
										</thead>
										<tbody>
											<?php 
												$i=1;
												$invbefore = '';
												foreach ($data as $row){
													if($row->PPN != 0){
												
												//Code to Generate QR
												$uniqpartcode = $row->INVOICE_ID;
												
												//Tax Invoice Number
												$TaxInvNum = $row->TAX_NUMBER_DEPAN.$row->TAX_NUMBER_BELAKANG;
												if($row->TAX_NUMBER_BELAKANG == NULL){$TaxInvNum = '-';}
											?>
											<?php
										
												if($invbefore == $row->INVOICE_ID){
											?>
												<tr>
													<td><?php echo $row->DESCRIPTION?></td>
												</tr>
											<?php
												}else{
											?>
											<tr class="data-row">
												<td rowspan="<?php echo $row->JML?>"><?php echo $i;?></td>
												<td rowspan="<?php echo $row->JML?>"><?php echo $row->INVOICE_NUM?></td>
												<td rowspan="<?php echo $row->JML?>"><?php echo $row->VENDOR_NAME?></td>
												<td rowspan="<?php echo $row->JML?>"><?php echo $row->INVOICE_DATE?></td>
												<td><?php echo $row->DESCRIPTION?></td>
												<td rowspan="<?php echo $row->JML?>"><?php echo number_format($row->DPP, 0 , ',' , '.' )?></td>
												<td rowspan="<?php echo $row->JML?>"><?php echo number_format($row->PPN, 0 , ',' , '.' )?></td>
												<td rowspan="<?php echo $row->JML?>" align="center">
													<a class="btn btn-success inspectqr" data-toggle="modal" data-target="#qrcode" ><i class="fa fa-qrcode"></i> Generate</a>
													<input type="hidden" class="uniqpartcode" value="<?php echo $uniqpartcode?>">
												</td>
												<td rowspan="<?php echo $row->JML?>"><?php echo $TaxInvNum?></td>
												<td rowspan="<?php echo $row->JML?>"><?php echo $row->VOUCHER_NUMBER?></td>
												<td rowspan="<?php echo $row->JML?>">											
													<a class="btn btn-info btn-sm" title="Input QR" href="<?php echo base_URL('AccountPayables/C_Invoice/inputTaxNumber/'.$row->INVOICE_ID)?>" target="blank"><i class="glyphicon glyphicon-qrcode"></i></a>		
													<a class="btn btn-warning btn-sm" title="Input Manual" href="<?php echo base_URL('AccountPayables/C_Invoice/inputTaxManual/'.$row->INVOICE_ID)?>" target="blank"><i class="glyphicon glyphicon-edit"></i></a>
													<?php $fkp = str_replace(str_split('.-'), '', $TaxInvNum); ?>
													<a class="btn btn-danger btn-sm" title="Delete" href="<?php echo base_URL('AccountPayables/C_Invoice/deleteTaxNumber/'.$row->INVOICE_ID.'/'.$fkp)?>" onclick="return confirm('Anda YAKIN menghapus data \n (<?php echo $row->INVOICE_NUM?>)..?');" target="blank"><i class="glyphicon glyphicon-trash"></i></a>					
												</td>
											</tr>
											<?php 
											$i++;
											}
											$invbefore = $row->INVOICE_ID;
											} } ?>
											<div class="modal fade modal-default" id="qrcode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<div class="col-sm-2"></div>
															<div class="col-sm-8" align="center"><b>QR Code</b></div>
															<div class="col-sm-2"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
															<br>
														</div>
														<div class="modal-body" align="center">
															<div class="qrarea">
															</div>
														</div>
													</div>
												</div>
											</div>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	</div>
</section>