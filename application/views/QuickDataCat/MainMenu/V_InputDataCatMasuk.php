<!-- <script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script> -->
<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>DATA CAT MASUK</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('QuickDataCat');?>">
                                <i class="fa fa-tint fa-2x"></i>
                                <span><br/></span>	
                            </a>
						</div>
					</div>
				</div>
			</div>
			<br/>
			
			<div class="row">
				<div class="col-lg-12">
					<?php
						if($this->session->userdata('success_insert')){ 
					?>
						<div class="alert alert-success alert-dismissable"  style="width:100%;" >
								 <li class="fa fa-warning"> </li> Simpan Data Berhasil !!!
						</div>
					<?php
						}
					?>
					<div class="box box-primary box-solid">
						<div class="box-header with-border">
							<b>Insert Data Cat</b>
						</div>
					
						<form method="post" action="<?php echo site_url($action)?>" class="form-horizontal" id="form1">	
						<div class="box-body">					
							<tr>
								<div class="col-md-8">
									<div class="col-md-3">
										<label for="norm" class="control-label"><h4 class="box-title">Kode Cat</h4></label>
									</div>
									<div class="col-md-5">	
										<div class="form-group">
											<select name="slcKodeCat" id="slcKodeCat" class="form-control jsKodeCatMasuk" onchange="getDescriptionMasuk('<?php echo site_URL() ?>');disabledButtonIn()" required>
												<option value=""></option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-8">
									<div class="col-md-3">
										<label>
											<h4 class="box-title">Description</h4>
										</label>
									</div>
									<div class="col-md-5">	
										<div class="form-group">
											<input type="text" class="form-control" id="txtDescription" name="txtDescription" onkeyup="disabledButtonIn()" placeholder="Input Description">
											</input>
										</div><!-- /.form group -->
									</div>
								</div>
								<div class="col-md-7">
									<fieldset class="field_set">
										<legend>Tanggal Expired</legend>
											<table width="50%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<div class="col-md-12">
														<div class="col-md-7 text-right">
															<label class="">QTY</label>
														</div>
														<div class="col-md-2">
														</div>
														<div id="addDelButtons">
														<b><input type="button" class="btn btn-primary btn-sm fa fa-plus" style="background:#2E6DA4;" id="btnAdd" value="ADD"></b>
														<b><input type="button" class="btn btn-primary btn-sm fa fa-minus" style="background:#2E6DA4;" id="btnDel" value="REMOVE"></b>
													</div>
													</div>
													
													<div id="wrapper">
														<div class="sign-up_box">
															<form action="#" method="post" id="sign-up_area">
																<div id="entry1" class="clonedInput">
																	<br>
																		<div class="col-md-6">
																		<div class="col-md-12">
																			<div class="form-group">
																				<input class="expired_date form-control" type="text" id="txtExpiredDate" name="txtExpiredDate[]" onchange='disabledButtonIn()' placeholder="<?php echo date("d-M-Y")?>" data-date-format="dd-M-yyyy" required >
																			</div>
																		</div>
																		</div>
																		<div class="col-md-2">
																			<div class="form-group">
																				<input class="quantity form-control" type="number" id="txtQuantity" onkeyup="disabledButtonIn()" name="txtQuantity[]" placeholder="Qty" required>
																			</div>
																		</div>
																</div>
																<br>
															</form>
														</div><!-- end sign-up_box -->
													</div> <!-- end wrapper -->
												</tr>
											</table>
											<br>
									</fieldset>
								</div>
							<div class="col-md-8">
								<div class="col-md-3">
									<label>
										<h4 class="box-title">Bukti & No Bukti </h4>
									</label>
								</div>
								<div class="col-md-5">	
									<div class="form-group">
										<input class="form-control" type="text" id="txtBukti" name="txtBukti" onkeyup="disabledButtonIn()" placeholder="Input Bukti & No Bukti">
										</input>
									</div><!-- /.form group -->
								</div>
							</div>
							<div class="col-md-8">
								<div class="col-md-3">
									<label>
										<h4 class="box-title">Petugas</h4>
									</label>
								</div>
								<div class="col-md-5">	
									<div class="form-group">
										<input class="form-control" type="text" id="txtPetugas" name="txtPetugas" style="text-transform:uppercase;" onkeyup="disabledButtonIn()" placeholder="Input Petugas">
										</input>
									</div><!-- /.form group -->
								</div>
							</div>
						</div>
							<div class="box-footer">
								<table align="center">
									<td width="20%"><a href="<?php echo site_url('QuickDataCat');?>" class="btn btn-primary btn-ls col-md-10" style="background:#2E6DA4;"> BACK </a></td>
									<td width="20%"><button class="btn btn-primary btn-ls col-md-10" style="background:#2E6DA4;" type="SUBMIT" name="SUBMIT" id="SUBMIT" disabled> SAVE </button></td>
								</table>
							</div>
						</form>
					</div>
				</div>
			</div>		
		</div>		
	</div>
</div>
</section>			