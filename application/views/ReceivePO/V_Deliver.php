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
						<div class="box box-success box-solid">
							<div class="box-header with-border"><b>Search Data</b></div>
							<div class="box-body">
								<div class="panel-body">
									<div class="col-md-1" style="text-align: right;">
										<label>LPPB</label>
									</div>

									<div class="col-md-3" style="text-align: left;">
							                    
											<input autocomplete="off" type="text" class="form-control "  id="lppbno" name="lppbno" placeholder="Nomor LPPB" >
										
									</div>

                                    <div style="text-align: left;" ><button onclick="getPO(this)" class="btn btn-flat" style="background-color: inherit;text-align:center;padding:0px;padding-left:0px"><i class="fa fa-arrow-right fa-2x" ></i></button></div>
                                    
								</div>

								<div class="panel-body">
									<div class="col-md-12" id="has"></div>
								</div>
							</div>
						</div>
						<div class="row">
							
						</div>
					</div>
				</div>
			</div>
		</section>