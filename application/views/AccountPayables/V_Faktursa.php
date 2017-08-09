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
				                    	<input type="hidden" name="faktur_type" value="N">
				                    	<table>	
					                     		<tr>
					                     			<td width="150px">
					                     				<label for="exampleInputPassword1">Scan QR Code</label>
					                     			</td>
					                     			<td>
					                     				<input type="text" id="qr_code" style="width:280px;" class="form-control " name="qr_code"  ><div id="ldg"></div><button id="btnRst" type="button" class="btn btn-sm btn-info">RESET</button>
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
										<td>
					                     	<table>	
					                     		<tr>
					                     			<td width="150px">
					                     				<label for="exampleInputPassword1">Nomor Faktur</label>
					                     			</td>
					                     			<td>
					                     			<input type="text" id="nomorFaktur" style="width:280px;" class="form-control " name="nomorFaktur" value="" readonly="readonly">
					                     		
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
					                     				<input type="text" id="namaPenjual" style="width:280px;" class="form-control " name="namaPenjual" value="" readonly="readonly">
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
					                     				<label for="exampleInputPassword1">NPWP</label>
					                     			</td>
					                     			<td>
					                     				<input type="text" id="npwpPenjual" style="width:280px;" class="form-control " name="npwpPenjual" value="" readonly="readonly">
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
														<input type="text" id="tanggalFaktur" style="width:280px;" class="form-control " name="tanggalFaktur" value="" readonly="readonly">
														<input type="hidden" name="tanggalFakturCon" id="tanggalFakturCon">
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
					                     				<textarea id="nama" name="nama" value="" class="form-control" type="text" rows="8" cols="60" readonly>
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
					                     				<input type="text" id="jumlahDpp" style="width:280px;" class="form-control " name="jumlahDpp" value="" readonly="readonly">
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
					                     				<input type="text" id="jumlahPpn" style="width:280px;" class="form-control " name="jumlahPpn" value="" readonly="readonly">
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
					                     				<label for="exampleInputPassword1">Address</label>
					                     			</td>
					                     			<td>
					                     				<textarea type="text" id="alamatPenjual" class="form-control " rows="4" cols="60" name="alamatPenjual" value="" readonly="readonly">
					                     				</textarea>
					                     			</td>
					                     		</tr>
					                     		
					                     	</table>

											<!-- hasil scan -->
									</td>											
									</tr>
								</table>					          
										</div>
							 	</fieldset>
							 	<div class="box-footer">
									<button type="button" class="btn btn-primary btn-sm" id="save"><b>Simpan Data</b></button>
									<!-- <a class="btn btn-danger btn-sm" title="Edit" class="btn btn-default leftmargin"  onclick="test2()" > Cancel</a> -->
				            	</div>
				            <div class="modal fade" id="comentModal" role="dialog">
  							  <div class="modal-dialog">
  							  <!-- Modal content-->
  							    <div class="modal-content">
  							      <div class="modal-header">
  							        <h4 class="modal-title">Faktur Tanpa Invoice</h4>
  							      </div>
  							      <div class="modal-body">
  							        <p>Lanjutkan input Faktur tanpa Invoice</p>
  							        <label for="passwd">PASSWORD : </label>
  							        	<input type="password" name="passwd" id="passwd" style="width: 45%"><br>
  							        <label for="txaCmt">COMMENT : </label><br>
  							        	<textarea name="txaCmt" id="txaCmt" style="width: 100%"></textarea>
  							      </div>
  							      <div class="modal-footer">
  							        <button type="button" id="btnCls" class="btn btn-danger" data-dismiss="modal">Cancel</button>
  							        <button type="button" class="btn btn-info" id="btnConfirm">Proceed</button>
  							      </div>
  							    </div>
				            	</form>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	</div>
</section>