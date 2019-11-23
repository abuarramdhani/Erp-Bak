<?php
	// echo "<pre>";
	// print_r($routeaktif);
	// exit();
?>

<section class="content">
	<div class="loader" style="position: fixed;width: 100%;height: 100%;z-index: 9999; background: url('../assets/img/gif/loading5.gif') 50% 50% no-repeat rgb(249,249,249);">
	</div>
	<div class="inner">
		<div class="box box-info">
			<div class="box-header with-border">
				<h2><b><center>DATA MINMAX</center></b></h2>
			</div>
	<div class="box box-info">
		<div class="box-body">
			<form method="post" id="formlimit" action="<?php echo base_url('SettingMinMax/SaveLimit')?>">
				<input type="hidden" id="kind" name="org" value="EDIT">
				<input type="hidden" id="org_ss" name="org" value="<?= $org ?>">
				<input type="hidden" id="routeraktif_ss" name="route" value="<?= $routeaktif ?>">
				<div class="row" id="loadingArea" style="padding-top:30px; color: #3c8dbc;  display: none;">
					<div class="col-md-12 text-center">
						<i class="fa fa-spinner fa-4x fa-pulse"></i>
					</div>
				</div>
				<div id="tablearea">

				</div>
			<!-- <button style="visibility: hidden;" type="submit">SAVE</button> -->
			</form>
		</div>
		<div class="box box-info">
			<div style="padding-top: 10px; padding-bottom: 10px;">
				<center><a href="<?php echo base_url('SettingMinMax/Edit')?>" class="btn btn-danger"><span class="fa fa-arrow-left"> BACK</span></a></center>
			</div>
		</div>
	</div>
		</div>
	</div>
</section>
