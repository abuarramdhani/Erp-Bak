<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1>
									<b>
										<?= $Title ?>
									</b>
								</h1>
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('ReceivePO/History/');?>">
									<i class="fa fa-list fa-2x">
									</i>
									<span>
										<br />
									</span>
								</a>
							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-md-12">
						<div class="box box-warning box-solid">
							<div class="box-header with-border"><b>Search History</b></div>
							<div class="box-body">
								<div class="panel-body">
									<div class="col-md-1 " style="text-align: right;">
										<label>Tanggal</label>
									</div>

									<div class="col-md-3">
							                    
											<input type="text" class="form-control tanggalan"  id="datefrom" name="datefrom" placeholder="Tanggal Receive" auto-complete="off" >
										
									</div>
									<div class="col-md-1" align="center"><label> s/d </label></div>
									<div class="col-md-3">
							              <input type="text" class="form-control tanggalan"  id="dateto" name="dateto" placeholder="Tanggal Receive" auto-complete="off" >
									</div>
                                    <div style="text-align: left;" ><button onclick="getHistory(this)" class="btn btn-flat" style="background-color: inherit;text-align:center;padding:0px;padding-left:0px"><i class="fa fa-arrow-right fa-2x" ></i></button></div>
                                    
								</div>

								<div class="panel-body">
									<div class="col-md-12" id="hasil"></div>
								</div>
							</div>
						</div>
						<div class="row">
							
						</div>
					</div>
				</div>
			</div>
		</section>