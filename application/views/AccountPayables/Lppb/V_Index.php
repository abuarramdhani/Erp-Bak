<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>
<section class="content">
	<div class="inner">
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>LPPB Belum Bayar</b></h1>
						
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('AccountPayables/Lppb');?>">
                                <i class="fa fa-server fa-2x"></i>
                                <span ><br /></span>
                            </a>
							
						</div>
					</div>
				</div>
			</div>
			<br />
		<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb text-right">
				<li class ="active"><?php echo date('d F Y') ?></a></li>
				<li class ="active"><span id="clockbox"><?php echo date('H:i:s') ?></span></li>
				<li class ="active">LPPB Belum Bayar</li>
			</ol>
		</div>
			<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						LPPB
					</div>
					
					<div class="box-body">
						<fieldset class="row2" style="background:#F8F8F8 ;">
							<form id="formSearch" action="<?php echo base_url('/AccountPayables/Lppb/search'); ?>" method="post">
								<div class="row">
									<div class="col-lg-12">
										<div class="panel-heading text-left">
											<!-- panel header -->
										</div>
										<div class="panel-body">
											<div class="col-lg-12">
												<div class="form-group"><!-- Supplier txtSupplier -->
													<label for="norm" class="control-label col-lg-3">Supplier</label>
													<div class="col-lg-4">
														<select id="slcSupplier" name="slcSupplier">
															<option></option>
															<?php foreach ($supplier as $spl) {?>
															<option value="<?php echo $spl['VENDOR_ID'] ; ?>"><?php echo $spl['VENDOR_NAME'] ; ?></option>
															<?php } ?>
														</select>
													</div>
												</div><br><br>
												<div class="form-group"><!-- Receipt DateRange -->
													<label for="norm" class="control-label col-lg-3">Receipt Date</label>
													<div class="col-lg-4">
														<input type="text" placeholder="Receipt Date" name="txtReceiptDate" id="txtReceiptDate" class="form-control toupper" required="required" />
													</div>
												</div><br><br>
												<div class="form-group"><!-- Inventory -->
													<label for="norm" class="control-label col-lg-3">Inventory</label>
													<div class="col-lg-4">
														<select id="slcInventory" name="slcInventory[]" multiple="multiple" style="width: 100%">
															<?php foreach ($inventory as $inv) {?>
															<option value="<?php echo $inv['ORGANIZATION_ID'] ; ?>"><?php echo $inv['ORGANIZATION_CODE'] ; ?></option>
															<?php } ?>
														</select>
													</div>
												</div><br><br><br>
												<div class="form-group"><!-- PO Number -->
													<label for="norm" class="control-label col-lg-3">PO Number</label>
													<div class="col-lg-4">
														<input type="text" placeholder="PO Number" name="txtPonum" id="txtPonum" class="form-control toupper"/>
													</div>
												</div>
											</div>
										</div><br><br>
										<div class="panel-footer">
											<div class="row text-right">
												<button type="button" id="btnSearch" class="btn btn-primary btn-lg btn-rect">SEARCH</button>
											</div>
										</div>
									</div>
								</div>
							</form>
					 	</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>
</div>
</section>