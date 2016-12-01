<section class="content">
	<div class="inner"  style="padding-top: 50px">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3><b><center>ADD NEW DATA LIMIT CREDIT</center></b></h3>
				<p class="help-block" style="text-align:center;">
				Hint! : Input with complete data on each form , except for the data marked with an asterisk * , can be not filled.
				</p>
			</div>
			<div class="box-body">
				<form method="post" action="<?php echo base_url('AccountReceivables/CreditLimit/Save'); ?>">
					<input type="hidden" value="<?php echo $this->session->userid; ?>" name="userCreate" />
					<div class="row">
						<div class="col-md-2">
							<b>Branch</b>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="glyphicon glyphicon-list"></i>
									</div>
									<select style="width:100%;" class="form-control select2" name="Branch" id="BranchCL" data-placeholder="Branch" required>
										<option value="" disabled selected></option>
										<option value="muach" disabled><-- PILIH SALAH SATU --></option>
										<?php foreach ($branch as $b) { ?>
											<option value="<?php echo $b['ORGANIZATION_ID']; ?>">
												<?php echo $b['NAME']; ?>
											</option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-2 col-md-offset-2">
							<b>*Expired Date</b>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="glyphicon glyphicon-calendar"></i>
									</div>
									<input type="text" name="Expired" id="Expired" class="form-control">
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-2">
							<b>Customer Name</b>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="glyphicon glyphicon-list"></i>
									</div>
									<select style="max-width: 100%;" class="form-control select2" name="CustomerName" data-placeholder="Customer Name" id="CustNameCL" required disabled>
										<option value="" disabled selected></option>
										<option value="muach" disabled><-- PILIH SALAH SATU --></option>
										
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-2 col-md-offset-2">
							<b>Customer Type</b>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="glyphicon glyphicon-user"></i>
									</div>
									<input type="text" class="form-control" name="CustType" readonly value="TEMPO" required>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<b>Customer Account ID</b>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="glyphicon glyphicon-user"></i>
									</div>
									<input type="text" class="form-control" name="CustAccountID" id="CustAccountID" readonly required>
								</div>
							</div>
						</div>
						<div class="col-md-2 col-md-offset-2">
							<b>Overall Credit Limit</b>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-money"></i>
									</div>
									<input type="number" class="form-control" name="OverallCreditLimit" min="1" value="1" required>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<b>Account Number</b>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="glyphicon glyphicon-user"></i>
									</div>
									<input type="text" class="form-control" name="AccountNumber" id="AccountNumber" readonly required>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<b>Party ID</b>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="glyphicon glyphicon-user"></i>
									</div>
									<input type="text" class="form-control" name="PartyID" id="PartyID" readonly required>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<b>Party Number</b>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="glyphicon glyphicon-user"></i>
									</div>
									<input type="text" class="form-control" name="PartyNumber" id="PartyNumber" readonly required>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<input type="submit" class="btn btn-info pull-right" value="SUBMIT">
							<a class="btn btn-default pull-right" href="<?php echo base_url('AccountReceivables/CreditLimit'); ?>">CANCEL</a>
						</div>
					</div>
				</form>
			</div>
			<div class="box box-info"></div>
		</div>
	</div>
</section>