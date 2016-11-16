<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b>Input Data</b></h1>
							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								Input Data Faktur Pajak
							</div>
							<div class="box-body">
								<fieldset class="row2" style="background:#F8F8F8 ;">
								 	<form action="<?php echo base_URL('AccountPayables/C_Invoice/saveTaxNumber')?>" method="post" enctype="multipart/form-data" id="pph">
				                    	<div class="box-body">

					                     	<table>	
					                     		<tr>
					                     			<td width="150px">
					                     				<label for="exampleInputPassword1">Invoice ID</label>
					                     			</td>
					                     			<td>
					                     				<input type="text" id="nomor_cari" style="width:280px;" class="form-control " name="invoice_id" value="<?php echo $data[0]->INVOICE_ID; ?>" readonly="readonly">
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
					                     				<input type="text" id="nomor_cari" style="width:280px;" class="form-control " name="supplier" value="<?php echo $data[0]->VENDOR_NAME; ?>" disabled>
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
					                     				<label for="exampleInputPassword1">Invoice Date</label>
					                     			</td>
					                     			<td>
														<div class="date" data-date="" data-date-format="dd-M-yyyy" data-link-field="dtp_input2" data-link-format="dd-M-yyyy">
															<input id="tanggal_cari" onkeypress="return hanyaAngka(event, false)" class="form-control datepicker" value="<?php echo $data[0]->TODATE;  ?>" data-date-format="dd-M-yyyy" type="text" name="invoice_date" riquaite placeholder=" Date" autocomplete="off">
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
					                     				<label for="exampleInputPassword1">Product</label>
					                     			</td>
					                     			<td>
					                     				<textarea name="product" value="" class="form-control" type="text" rows="8" cols="70" disabled><?php foreach ($data as $row){
					                     					echo $row->DESCRIPTION.'&#13;&#10;';
					                     				}
					                     				?>
					                     				</textarea>
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
					                     				<label for="exampleInputPassword1">DPP</label>
					                     			</td>
					                     			<td>
					                     				<input type="text" id="nomor_cari" style="width:280px;" class="form-control " name="dpp" value="<?php echo $data[0]->DPP; ?>" disabled>
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
					                     				<label for="exampleInputPassword1">PPN</label>
					                     			</td>
					                     			<td>
					                     				<input type="text" id="nomor_cari" style="width:280px;" class="form-control " name="ppn" value="<?php echo $data[0]->PPN; ?>" disabled>
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
					                     				<label for="exampleInputPassword1">Tax Number</label>
					                     			</td>
					                     			<td>
					                     				<input type="text" id="nomor_cari" style="width:280px;" class="form-control " name="tax_number" value="<?php echo $data[0]->TAX_NUMBER_DEPAN.$data[0]->TAX_NUMBER_BELAKANG; ?>" placeholder="Tax Number" maxlength="25">
					                     			</td>
					                     		</tr>
					                     		<tr>
					                     			<td>
					                     				<br/>
					                     			</td>
					                     		</tr>
					                     	</table>
					                     	
											<!-- INPUT TAX NUMBER LAMA 
											<table>	
					                     		<tr>
					                     			<td width="150px">
					                     				<label for="exampleInputPassword1">Tax Number Awal</label>
					                     			</td>
					                     			<td>
					                     				<input type="text" id="nomor_cari" style="width:280px;" class="form-control " name="tax_number_awal" value="<?php echo $data[0]->TAX_NUMBER_DEPAN; ?>" placeholder="Tax Number">
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
					                     				<label for="exampleInputPassword1">Tax Number Akhir</label>
					                     			</td>
					                     			<td>
					                     				<input type="text" id="nomor_cari" style="width:280px;" class="form-control " name="tax_number_akhir" value="<?php echo $data[0]->TAX_NUMBER_BELAKANG; ?>" placeholder="Tax Number">
					                     			</td>
					                     		</tr>
					                     		<tr>
					                     			<td>
					                     				<br/>
					                     			</td>
					                     		</tr>
					                     	</table>
											-->
											
										</div>
							 	</fieldset>
							 	<div class="box-footer">
									<button type="submit" class="btn btn-primary btn-sm" id="save"><b>Simpan Data</b></button>
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