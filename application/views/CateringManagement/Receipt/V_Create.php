<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Catering Receipt</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/Receipt');?>">
                                <i class="icon-wrench icon-2x"></i>
                                <span><br/></span>	
                            </a>
						</div>
					</div>
				</div>
			</div>
			<br/>
			
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<b>Catering Receipt</b>
					</div>
					
					<div class="box-body">
					<form method="post" action="<?php echo base_url('CateringManagement/Receipt/Add')?>">
						<!-- INPUT GROUP 1 ROW 1 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">No.</label>
								<div class="col-lg-6">
									<input name="TxtNo" class="form-control toupper" placeholder="No." required >
								</div>
							</div>
						</div>
						<!-- INPUT GROUP 1 ROW 2 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Receipt Date</label>
								<div class="col-lg-3">
									<input name="TxtReceiptDate" class="form-control singledate" placeholder="Receipt Date" required >
								</div>
								<label class="col-lg-1 control-label" align="right">Place</label>
								<div class="col-lg-2">
									<input name="TxtPlace" class="form-control toupper" placeholder="Place" required >
								</div>
							</div>
						</div>
						<!-- INPUT GROUP 1 ROW 3 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">From</label>
								<div class="col-lg-3">
									<input name="TxtFrom" class="form-control toupper" placeholder="Company Name" value="CV. KHS" required >
								</div>
								<label class="col-lg-1 control-label" align="right">Signer</label>
								<div class="col-lg-2">
									<input name="TxtSigner" class="form-control toupper" placeholder="Signer" required >
								</div>
							</div>
						</div>
						<hr>
											
						<!-- INPUT GROUP 2 ROW 1 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Order Type</label>
								<div class="col-lg-6">
									<select class="form-control select4" name="TxtOrderType" data-placeholder="Select Order Type" required>
										<option></option>
										<?php foreach ($Type as $tp) {?>
										<option value="<?php echo $tp['type_id']?>"><?php echo $tp['type_description']?></option>
										<?php }?>
									</select>
								</div>
							</div>
						</div>
						<!-- INPUT GROUP 2 ROW 1.2 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Catering</label>
								<div class="col-lg-6">
									<select class="form-control select4" id="catering" name="TxtCatering" data-placeholder="Select Catering" required>
											<option></option>
										<?php foreach ($Catering as $cr) {?>
											<option value="<?php echo $cr['catering_id']?>"><?php echo $cr['catering_name']?></option>
										<?php }?>
									</select>
								</div>
							</div>
						</div>
						<!-- INPUT GROUP 2 ROW 2 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Order Date</label>
								<div class="col-lg-6">
									<input name="TxtOrderDate" class="form-control doubledate" placeholder="Order Date" required >
								</div>
							</div>
						</div>
						
						<!-- INPUT GROUP 2 ROW 3 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Order Qty</label>
								<div class="col-lg-3">
									<input id="orderqty" name="TxtOrderQty" class="form-control" onkeypress="return isNumberKey(event)" placeholder="Order Qty" required >
								</div>	
								<label class="col-lg-1 control-label" align="right">@</label>
								<div class="col-lg-2">
									<input id="singleprice" name="TxtSinglePrice" class="form-control" onkeypress="return isNumberKey(event)" placeholder="Price per qty" required >
								</div>
								
							</div>
						</div>
						<hr>
						
						<!-- INPUT GROUP 3 ROW 1 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Calculation</label>
								<div class="col-lg-3">
									<input id="calc" name="TxtCalc" class="form-control" onkeypress="return isNumberKey(event)" placeholder="Calc" value="0" readonly>
								</div>								
							</div>
						</div>
						<!-- INPUT GROUP 3 ROW 1 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Fine</label>
								<div class="col-lg-3">
									<input id="fine" name="TxtFine" class="form-control" onkeypress="return isNumberKey(event)" placeholder="Fine" value="0">
								</div>								
							</div>
						</div>
						<!-- INPUT GROUP 3 ROW 2 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">PPH (2%)*</label>
								<div class="col-lg-3">
									 <div class="input-group">
										<input id="pph" name="TxtPPH" class="form-control" onkeypress="return isNumberKey(event)" placeholder="PPH" readonly>
										<span class="input-group-btn">
											<a id="pphverify" data-toggle="tooltip" data-placement="right" title="Cek PPH" class="btn btn-info"><i class="fa fa-check"></i></a>								
										</span>
									</div>
								</div>
							</div>
						</div>
						<!-- INPUT GROUP 3 ROW 3 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Total</label>
								<div class="col-lg-3">
									<input id="total" name="TxtTotal" class="form-control" onkeypress="return isNumberKey(event)" placeholder="Total" readonly>
								</div>								
							</div>
						</div>
						<hr>
						
						<!-- INPUT GROUP 4 ROW 1 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Payment Nominal</label>
								<div class="col-lg-3">
									<input id="payment" name="TxtPayment" class="form-control" onkeypress="return isNumberKey(event)" placeholder="Payment Nominal">
								</div>								
							</div>
						</div>
						<hr>
						
						<div class="row" style="margin: 10px 10px">
							<b style="color:#440000">*) Pastikan anda telah men-klik tombol cek pph</b>
						</div>
						<!-- submit -->
						<div class="form-group">
							<div class="col-lg-8 text-right">
								<a href="<?php echo site_url('CateringManagement/Receipt');?>"  class="btn btn-success btn-lg btn-rect">Back</a>
								&nbsp;&nbsp;
								<button type="submit" class="btn btn-success btn-lg btn-rect">Save Data</button>
							</div>
						</div>
					<form>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
