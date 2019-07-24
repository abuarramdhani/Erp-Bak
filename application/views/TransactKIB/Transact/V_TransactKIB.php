<!----------------------------------------------------MODAL TRANSACT KIB-------------------------------------------------------->
			<!-- <div class="box-header with-border"> -->
			<div class="box-body" id="section2">
				<h2 title="Klik untuk Transact"><b><center>TRANSACT KIB</center></b></h2>
			<!-- </div> -->
			
				<form method="post" action="<?php echo base_url('TransactKIB/C_TransactKIB/Transaksi')?>">

					<div class="row">
						<div class="col-md-4" style="padding-left: 20px; text-align: right;">
							<label>ORGANIZATION</label>
						</div>
						<div class="col-md-8" style="width: 500px">
							<div class="form-group">
								<input type="text" name="org" class="form-control" disabled value="<?php echo $hasil; ?>">
							</div>						
						</div>
					</div>

					<div class="row"> 
						<div class="col-md-4" style="padding-left: 20px; text-align: right;">
								<label>DATE</label>
						</div>
                        <div class="col-md-8" style="width: 500px">
							<div class="form-group">
								<input value="<?php echo date('d/m/Y h:i:s'); ?>" type="text" name="date" class="form-control" disabled>
							</div>						
						</div>
					</div>

					<div class="row">
						<div class="col-md-4" style="padding-left: 20px; text-align: right;">
								<label>ITEM NUM</label>
						</div>
						<div class="col-md-8" style="width: 500px">
							<div class="form-group">
								<input type="text" name="num" class="form-control" disabled value="<?php echo $hasil1; ?>">
							</div>						
						</div>
					</div>

					<div class="row">
						<div class="col-md-4" style="padding-left: 20px; text-align: right;">
							<label>DESCRIPTION</label>
						</div>
						<div class="col-md-8" style="width: 500px">
							<div class="form-group">
								<input type="text" name="desc" class="form-control" disabled value="<?php echo $hasil2; ?>">
							</div>						
						</div>
					</div>

					<div class="row">
						<div class="col-md-4" style="padding-left: 20px; text-align: right;">
							<label>TO WAREHOUSE</label>
						</div>
						<div class="col-md-8" style="width: 500px">
							<div class="form-group">
								<input type="text" name="warehouse" id="warehouse" class="form-control" disabled value="<?php echo $hasil3; ?>">
							</div>
						</div>
					</div>
			
					<!-- <br> -->
			
					<div class="row">
						<div class="col-md-4" style="text-align: right;">
								<label>PLAN</label>
						</div>
						<div class="col-md-8" style="width: 500px">
                            <div class="form-group">
								<input type="text" name="plan" id="plan" class="form-control" disabled value="<?php echo $hasil4; ?>">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4" style="text-align: right;">
							<label>ATT</label>	
						</div>
					    <div class="col-md-8" style="width: 500px">
                            <div class="form-group">
							    <input type="text" name="att" id="att" class="form-control" disabled value="<?php echo $hasil5; ?>">
						    </div>
					    </div>
					</div>

					<div class="row">
						<div class="col-md-4" style="text-align: right;">
								<label>TO TRANSFER</label>
						</div>
						<div class="col-md-8" style="width: 500px">
							<div class="form-group">
								<input class="form-control" type="number" style="width: 100%" name="transfer" id="transfer" value="<?php echo $hasil6; ?>">
						  </div>
					  </div>
          			</div>
			
            <div class="col-md-12" style="padding-top: 5px">
                <center><button class="btn btn-primary" onclick="transactKIB(this)">TRANSACT</button></center>
            </div>
		</form>

	</div>