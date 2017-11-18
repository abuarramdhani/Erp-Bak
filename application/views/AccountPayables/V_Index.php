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
								 	<form action="<?php echo base_URL('AccountPayables/Invoice/search')?>" method="post" enctype="multipart/form-data" id="pph">
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
															<input id="tanggal_awal" onkeypress="return hanyaAngka(event, false)" class="form-control datepicker" value="<?php echo date("d-m-y"); ?>"  data-date-format="dd-M-yyyy" type="text" name="tanggal_awal" riquaite placeholder=" Date" autocomplete="off">
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
															<input id="tanggal_akhir" onkeypress="return hanyaAngka(event, false)" class="form-control datepicker" value="<?php echo date("d-m-y"); ?>"  data-date-format="dd-M-yyyy" type="text" name="tanggal_akhir" riquaite placeholder=" Date" autocomplete="off">
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
					                     				<input type="text" id="slcInvoiceNumber" name="invoice_number" class="form-control" style="width:265px; text-transform: uppercase;" placeholder="INVOICE NUMBER"></input>
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
															<option value="1">All Invoice</option>
															<option value="2">With Tax Invoice</option>
															<option value="3">Without Tax Invoice</option>
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
					                     				<label for="exampleInputPassword1">Voucher Number</label>
					                     			</td>
					                     			<td>
					                     				<input id="slcVoucherNumber" name="voucher_number" class="form-control" style="width:265px;" placeholder="VOUCHER NUMBER"></input>
					                     			</td>
					                     		</tr>
					                     	</table>

										</div>
							 	</fieldset>
							 	<div class="box-footer">
									<button type="button" class="btn btn-primary btn-sm" id="smbt"><b>Cari Data</b></button>
									<a id="ClearSearch" class="btn btn-danger btn-sm"><b>Clear</b></a>
									<div style="float: right;">
										<button type="button" class="btn btn-info btn-lg" id="fakturSAbtn">Faktur tanpa Invoice</button>
									</div>
				            	</div><br><br><br>
				            	<div id="searchResultTableHere" style="width: 100%;"></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div id="example-modal"><!--PURRRFECT-->
				<div class="modal fade in" id="modalInputFaktur">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title">Modal Input Faktur</h4>
							</div>
							<div class="modal-body"  id="contentFakMod">
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="example-modal">
				<div class="modal fade in" id="comentModal">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title">Comment Modal</h4>
							</div>
			  			    <div class="modal-body">
			  			    	<p>Lanjutkan input Faktur</p>
			  			    	<label for="passwd">PASSWORD : </label>
			  			    		<input type="password" name="passwd" id="passwd" style="width: 45%"><br>
			  			    	<label for="txaCmt">COMMENT : </label><br>
			  			    		<textarea name="txaCmt" id="txaCmt" style="width: 100%"></textarea>
			  			    </div>
			  			    <div class="modal-footer">
			  			    	<button type="button" id="btnClsModFak" class="btn btn-danger">Cancel</button>
			  			    	<button type="button" class="btn btn-info" id="btnConfirm">Proceed</button>
			  			    </div>
			  			    </div>
						</div>
					</div>
				</div>
			</div>
	</div>
	</div>
</section>


		