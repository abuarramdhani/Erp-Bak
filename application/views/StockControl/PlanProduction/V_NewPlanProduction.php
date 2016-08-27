<?php
	if (empty($plan_date)) {$plan_date = '';}
	if (empty($qty_plan)) {$qty_plan = '';}
?>
<section class="content-header">
	<h1>
		New Plan Production
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">	
			<div class="box box-primary">
				<div class="box-body with-border">
					<form method="post" action="<?php echo base_url('StockControl/plan-production/save') ?>">
						<div class="form-group">
							<div class="row" style="margin: 10px 10px">
								<label class="col-lg-2 control-label">Plan Date</label>
								<div class="col-lg-10">
									<input type="text" class="form-control date-picker" placeholder="Plan Date" name="txt_plan_date" value="<?php echo $plan_date ?>" required></input>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<label class="col-lg-2 control-label">Qty Plan</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" placeholder="Qty" name="txt_qty_plan" value="<?php echo $qty_plan ?>" required></input>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="col-lg-12" style="text-align: right">
									<button class="btn btn-primary">Simpan</button>
									<span class="btn btn-primary" onclick="window.history.back()">Back</span>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>