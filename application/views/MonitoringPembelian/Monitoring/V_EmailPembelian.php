<section class="content">
	<div class="inner" >
	<div class="row">
		<!------------Preloader-------------->
			<div class="preloader">
					<div class="loading">
						<p>Please Wait Loading Data Table...</p>
					</div>
			</div>
		<!------------Preloader End---------->
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								Tabel Email Pembelian
							</div>
							<div class="box-body">
							<div class="row">
								<form action="<?= base_url(); ?>MonitoringPembelian/EditData/SaveEmailPembelian" method="post">
                                	<div class="col-md-12" style="padding-top: 10px">
                                	    <div class="col-md-12"> 
	                            	        <div class="row">
	                            	            <div class="col-md-4 " style="text-align: right;">
	                            	                <label>Email</label>
	                            	            </div>
	                            	            <div class="col-md-4">
	                            	                <div class="form-group">
	                            	                    <input type="Email" id="txtEmail" name="txtEmail" class="form-control" style="width: 350px" placeholder="Input Email Baru">
	                            	                </div>
	                            	            </div>
	                            	            <div class="col-md-4 text-left">
		                        	                <button type="submit" class="btn btn-primary btn-md" id="SubmitInputEmail"> SAVE DATA </button><br>
		                        	                <span style="height: 50px"></span>
		                        	            </div>
	                            	        </div>
                                	    </div>
                                	</div>
                            	</form>
                            </div>
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover text-left " id="" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="%"><center>NO</center></th>
												<th width="%"><center>CATEGORY</center></th>
												<th width="%"><center>EMAIL</center></th>
												<th width="%"><center>ACTION</center></th>
											</tr>
										</thead>
										<tbody>
											<?php 
											$no = 0;
											foreach ($EmailPembelian as $row):
												$no++;
												$encrypted_string = $this->encrypt->encode($row['EMAIL']);
												$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											?> 		
													<tr>
														<td><center><?php echo $no ?></center></td>
														<td><center><?php echo $row['CATEGORY']?></center></td>
														<td><input type="hidden" name="email[]" id="email[]" value="<?php echo $row['EMAIL']?>"><center><?php echo $row['EMAIL']?></center></td>
														<td>
															<center>
															<a class="btn btn-danger" title="Delete Email" href="<?php echo base_url(); ?>MonitoringPembelian/EditData/<?php echo 'DeleteEmailPembelian/'.$encrypted_string ?>" onclick="return confirm('Are you sure to delete this Email ?')">
                                                            	<span class="icon-trash" style="padding-right: 5px"></span>Delete
                                                            </a>
															</center>
														</td>
													</tr>
											<?php endforeach ?>
										</tbody>
									</table>
								</div>
								<div class="col-md-12"><center><a class="btn btn-lg btn-success" href="<?= base_url(); ?>MonitoringPembelian/EditData"><span class="icon icon-check"></span> Done</a></center></div>
							</div>
						
						</div>
					</div>
					<div class="col-md-12">
						<!-- </form> -->
					</div>
				</div>
			</div>
	</div>
	</div>
</section>