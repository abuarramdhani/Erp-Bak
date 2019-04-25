<?php
// echo "<pre>";
// print_r($No_induk);
// exit();
?>

<section class="content">
	<div class="inner">
		<div class="box box-info">
			<div class="box-header with-border">
				<h2><b><center>EDIT DATA MIN MAX</center></b></h2>
			</div>
			<div class="box-body">
			<center><form method="post" action="<?php echo base_url('SettingMinMax/SaveMinMax')?>">
				<input type="hidden" name="org" value="<?php echo $org ?>">
				<input type="hidden" name="route" value="<?php echo $routeaktif ?>">
				<input type="hidden" name="induk" class="induk" value="<?php echo $No_induk ?>">
				<div class="row">
					<div class="col-md-2 col-md-offset-2" style="text-align: right;">
							<label>ITEM CODE</label>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<input type="text" name="segment1" readonly class="form-control form-group" value="<?php echo $item_minmax[0]['SEGMENT1']?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 col-md-offset-2" style="text-align: right;">
							<label>DESCRIPTION</label>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<input type="text" name="description" readonly class="form-control form-group" value="<?php echo $item_minmax[0]['DESCRIPTION']?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 col-md-offset-2" style="text-align: right;">
							<label>UOM</label>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<input type="text" name="uom" readonly class="form-control form-group" value="<?php echo $item_minmax[0]['PRIMARY_UOM_CODE']?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 col-md-offset-2" class="form-control form-group" style="text-align: right;">
							<label>MIN</label>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<input type="number" name="min" class="form-control form-group" value="<?php echo $item_minmax[0]['MIN']?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 col-md-offset-2" style="text-align: right;">
							<label>MAX</label>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<input type="number" name="max" class="form-control form-group" value="<?php echo $item_minmax[0]['MAX']?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 col-md-offset-2" style="text-align: right;">
							<label>ROP</label>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<input type="number" name="rop" class="form-control form-group" value="<?php echo $item_minmax[0]['ROP']?>">
						</div>
					</div>
				</div>
				<div class="row">
					<center>
						<form action="<?php echo base_url('SettingMinMax/EditbyRoute')?>">
							<input type="hidden" name="routing_class" value="<?php echo $routeaktif ?>">
							<input type="hidden" name="org" value="<?php echo $org?>">
							<button class="btn btn-danger btn-lg" type="submit"><span class="fa fa-remove"></span> CANCEL</button>
						</form>
						<button class="btn btn-success btn-lg" type="submit"><span class="fa fa-save"></span> SAVE</button>
					</center>
				</div>
			</form></center>
			</div>
				
		</div>
	</div>
</section>