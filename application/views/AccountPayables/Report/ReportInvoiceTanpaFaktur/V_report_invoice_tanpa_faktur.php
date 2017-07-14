<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b>Report Invoice Tanpa Faktur</b></h1>
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
								 	<form action="<?php echo base_URL('AccountPayables/Report/exportInvoiceFaktur')?>" method="post" enctype="multipart/form-data" id="pph">
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
															<input id="tanggal_akhir" onkeypress="return hanyaAngka(event, false)" class="form-control datepicker" value="<?php echo date('d-m-y'); ?>"  data-date-format="dd-M-yyyy" type="text" name="tanggal_awal" riquaite placeholder=" Date" autocomplete="off">
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
															<input id="tanggal_awal" onkeypress="return hanyaAngka(event, false)" class="form-control datepicker" value="<?php echo date('d-m-y'); ?>"  data-date-format="dd-M-yyyy" type="text" name="tanggal_akhir" riquaite placeholder=" Date" autocomplete="off">
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
										</div>
							 	</fieldset>
							 	<div class="box-footer">
									<button type="submit" class="btn btn-primary btn-sm" id="save"><b>Cari Data</b></button>
				            	</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


		