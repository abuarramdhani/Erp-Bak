<?php $plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $segment1);
	$plaintext_string = $this->encrypt->decode($plaintext_string);

echo "<pre>";
print_r($data);
exit();
?>


 



<!-- <section class="content">
	<div class="inner" >
		<div class="row">
			<form method="POST" name="total" action="<?php echo site_url('MonitoringPembelian/Monitoring/SaveUpdatePembelian/')?>" class="form-horizontal">
			<div class="col-lg-12">
				<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-11">
								<div class="text-right">
								<h1><b><?= $Title?></b></h1>

								</div>
							</div>
							<div class="col-lg-1 ">
								<div class="text-right hidden-md hidden-sm hidden-xs">
									<a class="btn btn-default btn-lg" href="<?php echo site_url('MonitoringPembelian');?>">
										<i class="icon-wrench icon-2x"></i>
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
								Header
							</div>
						<div class="box-body">
						<?php 
						foreach ($Monitoring as $row): 
						?>
							<div class="panel-body">
								<div class="row col-lg-12">
									<div class="form-group row">
									    <label for="" class="col-sm-2 col-form-label">ITEM CODE</label>
									    <div class="col-sm-10">
									      <input type="text" style="width: 100%" readonly class="form-control-plaintext" name="itemCode" id="itemCode" value="<?php echo $plaintext_string ?>">
									    </div>
									 </div>
									 <div class="form-group row">
									    <label for="" class="col-sm-2 col-form-label">DESCRIPTION</label>
									    <div class="col-sm-10">
									      <input type="text"  style="width: 100%" readonly class="form-control-plaintext" name="desc" id="description" value="<?php echo $row['DESCRIPTION'] ?>">
									    </div>
									 </div>
									 <div class="form-group row">
									    <label for="" class="col-sm-2 col-form-label">UOM1</label>
									    <div class="col-sm-10">
									      <input type="text"  style="width: 100%" readonly class="form-control-plaintext" name="uom1" id="uom1" value="<?php echo $row['PRIMARY_UOM_CODE'] ?>">
									    </div>
									 </div>
									 <div class="form-group row">
									    <label for="" class="col-sm-2 col-form-label">UOM2</label>
									    <div class="col-sm-10">
									      <input type="text"  style="width: 100%" readonly class="form-control-plaintext" name="uom2" id="uom2" value="<?php echo $row['SECONDARY_UOM_CODE'] ?>">
									    </div>
									 </div>
									 <div class="form-group row">
									    <label for="" class="col-sm-2 col-form-label">BUYER</label>
									    <div class="col-sm-10">
									      <select style="width: 50%" name="per1" id="per1" class="select4">
												  <option selected="selected"><?php echo $row['FULL_NAME'] ?></option>
												  <?php
												    foreach($MonitoringBuyer as $name) { ?>
												      <option value="<?= $name['FULL_NAME'] ?>"><?= $name['FULL_NAME'] ?></option>
												  <?php
												    } ?>
										</select> 
									    </div>
									 </div>
									 <div class="form-group row">
									    <label for="" class="col-sm-2 col-form-label">PRE-PROCESSING LEAD TIME</label>
									    <div class="col-sm-10">
									      <input type="number"   style="width: 20%" class="form-control-plaintext pro-time" name="preProc" id="preProc" value="<?php echo $row['PREPROCESSING_LEAD_TIME'] ?>">
									    </div>
									 </div>
									 <div class="form-group row">
									    <label for="" class="col-sm-2 col-form-label">TOTAL PROCESSING LEAD TIME</label>
									    <div class="col-sm-10">
									      <input type="number"  style="width: 20%" class="form-control-plaintext pro-time" name="totProc" id="totProc" value="<?php echo $row['FULL_LEAD_TIME'] ?>">
									    </div>
									 </div>
									 <div class="form-group row">
									    <label for="" class="col-sm-2 col-form-label">POST-PROCESSING LEAD TIME</label>
									    <div class="col-sm-10">
									      <input type="number"  style="width: 20%" class="form-control-plaintext pro-time" name="postProc" id="postProc" value="<?php echo $row['POSTPROCESSING_LEAD_TIME'] ?>">
									    </div>
									 </div>
									 <div class="form-group row">
									    <label for="" class="col-sm-2 col-form-label">TOTAL LEAD TIME</label>
									    <div class="col-sm-10">
									      <input type="number" readonly style="width: 20%" class="form-control-plaintext" name="totLead" id="totLead" value="<?php echo $row['TOTAL_LEADTIME'] ?>">
									    </div>
									 </div>
									 <div class="form-group row">
									    <label for="" class="col-sm-2 col-form-label">MOQ</label>
									    <div class="col-sm-10">
									      <input type="text"  style="width: 100%" readonly class="form-control-plaintext" name="moq" id="moq" value="<?php echo $row['MINIMUM_ORDER_QUANTITY'] ?>">
									    </div>
									 </div>
									 <div class="form-group row">
									    <label for="" class="col-sm-2 col-form-label">FLM</label>
									    <div class="col-sm-10">
									      <input type="text"  style="width: 100%" readonly class="form-control-plaintext" name="flm" id="flm" value="<?php echo $row['FIXED_LOT_MULTIPLIER'] ?>">
									    </div>
									 </div>
									 <div class="form-group row">
									    <label for="" class="col-sm-2 col-form-label">NAMA APPROVER</label>
									    <div class="col-sm-10">
									      <input type="text"  style="width: 100%" readonly class="form-control-plaintext" name="attr18" id="attr18" value="<?php echo $row['ATTRIBUTE18'] ?>">
									    </div>
									 </div>
								</div>
							</div>
							<div class="panel-footer">
								<div class="row text-right">
									<a href="<?php echo site_url('MonitoringPembelian/Monitoring') ?>" class="btn btn-primary btn-lg btn-rect">Close</a>
									&nbsp;&nbsp;
									<button id="btnUser" class="btn btn-primary btn-lg btn-rect">Update Data</button>
								</div>
							</div>
							<?php endforeach ?>
						</div>
						</div>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</section>  -->