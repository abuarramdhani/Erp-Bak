<div class="row">
	<div class="col-lg-12">
		<div class="box box-primary box-solid">
			<div class="box-header with-border">
				Input Data Faktur Manual
			</div>
			<div class="box-body">
				<fieldset class="row2" style="background:#F8F8F8 ;">
				 	<form action="<?php echo base_URL('AccountPayables/Invoice/saveTaxNumberManual')?>" method="post" enctype="multipart/form-data" id="pph">
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
	                     				<input type="text" id="nomor_cari" style="width:280px;" class="form-control " name="namaPenjual" value="<?php echo $data[0]->VENDOR_NAME; ?>" readonly="readonly">
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
	                     				<label for="exampleInputPassword1">Nama Penjual di Faktur Pajak</label>
	                     			</td>
	                     			<td>
										 <!-- <input type="text" id="nomor_cari" style="width:280px;" class="form-control " name="namaPenjualOnFaktur" value="<?php echo $data[0]->VENDOR_NAME; ?>" readonly="readonly"> -->
										 <input type="text" id="nameFaktur" style="width:280px;" class="form-control " name="nameFaktur" placeholder="Name" value="<?php echo $data[0]->SELLER; ?>">
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
	                     				<label for="exampleInputPassword1">Faktur Date</label>
	                     			</td>
	                     			<td>
										<div class="date" data-date="" data-date-format="dd/M/yyyy" data-link-field="dtp_input2" data-link-format="dd/M/yyyy">
											<input id="tanggalFaktur" onkeypress="return hanyaAngka(event, false)" class="form-control datepicker" value="<?php echo $data[0]->FAKTUR_DATE;  ?>" data-date-format="dd/mm/yyyy" type="text" name="tanggalFaktur" riquaite placeholder=" Date" autocomplete="off">
											<input type="hidden" name="tanggalFakturCon" id="tanggalFakturCon">
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
	                     				<textarea name="product" value="" class="form-control" type="text" rows="8" cols="70" readonly="readonly"><?php foreach ($data as $row){
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
	                     				<input type="text" id="nomor_cari" style="width:280px;" class="form-control " name="jumlahDpp" value="<?php echo $data[0]->DPP; ?>" readonly="readonly">
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
	                     				<input type="text" id="nomor_cari" style="width:280px;" class="form-control " name="jumlahPpn" value="<?php echo $data[0]->PPN; ?>" readonly="readonly">
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
	                     				<input type="text" id="nomorFaktur" style="width:280px;" class="form-control " name="nomorFaktur" value="<?php echo $data[0]->TAX_NUMBER_DEPAN.$data[0]->TAX_NUMBER_BELAKANG; ?>" placeholder="Tax Number" maxlength="25">
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
					<button type="button" class="btn btn-primary btn-sm" id="saveManual"><b>Simpan Data</b></button>
					<!-- <a class="btn btn-danger btn-sm" title="Edit" class="btn btn-default leftmargin"  onclick="test2()" > Cancel</a> -->
            	</div>
			</div>
		</div>
	</div>
</div>