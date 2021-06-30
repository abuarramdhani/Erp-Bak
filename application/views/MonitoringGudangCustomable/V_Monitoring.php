<section id="content">
	<div class="content">
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="box box-primary box-solid">
	        <div class="box-header with-border">
	          <h4 style="font-weight:bold;"><i class="fa fa-newspaper-o"> </i> Monitoring Gudang Cunsomable</h4>
	        </div>
	        <div class="box-body" style="background:#f0f0f0 !important;">
	              <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:15px;">
									<div class="row">
									<div class="col-md-10">
                    <label for="">Select Plan</label>
                    <select class="form-control select_MGC" id="planid" name="type" data-placeholder="Select Current Plan">
											<option value=""></option>
											<?php foreach ($data_range as $key => $range): ?>
												<option value="<?php echo $range['PLAN_ID'] ?>"><?php echo $range['COMPILE_DESIGNATOR']?></option>
											<?php endforeach; ?>
										</select>
	                </div>
									<div class="col-md-2">
										<label for="" style="color:transparent">Ini Filter</label>
                    <button type="button" onclick="getpodMGC()" style="font-size:15px" class="btn btn-primary btn-sm btn-block"> <i class="fa fa-search"></i> <strong>Filter</strong> </button>
                  </div>
								</div>
									<div class="row">
										<div class="col-md-12" style="margin-top:15px">
											<div class="area_mgc">

											</div>
										</div>
									</div>
	              </div>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
</section>
