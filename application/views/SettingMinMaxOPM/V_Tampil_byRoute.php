<?php
	// echo "<pre>";
	// print_r($routeaktif);
	// exit();
?>

<section class="content">
	<div class="loader" style="position: fixed;width: 100%;height: 100%;z-index: 9999; background: url('../assets/img/gif/loadingtwo.gif') 50% 50% no-repeat rgb(249,249,249);">
	</div>
	<div class="inner">
		<div class="box box-info">
			<div class="box-header with-border">
				<h2><b><center>DATA MINMAX</center></b></h2>
			</div>
	<div class="box box-info">
		<div class="box-body">
			<form method="post" id="formlimit" action="<?php echo base_url('SettingMinMax/SaveLimit')?>">
				<input type="hidden" name="org" value="<?= $org ?>">
				<input type="hidden" name="route" value="<?= $routeaktif ?>">
			<table id="tableDataMinMax" class="table table-striped table-bordered table-responsive table-hover" >
				<thead style="background:#22aadd; color:#FFFFFF;">
					<th style="text-align:center; width: 5%">NO</th>
					<th style="text-align:center; width: 15%">ITEM CODE</th>
					<th style="text-align:center; width: 20%">DESCRIPTION</th>
					<th style="text-align:center; width: 10%">UOM</th>
					<th style="text-align:center; width: 10%">MIN</th>
					<th style="text-align:center; width: 10%">MAX</th>
					<th style="text-align:center; width: 15%">ROP</th>
					<?php
						if ($org == 'ODM') {
							echo '<th style="text-align:center; width: 10%">LIMIT JOB</th>';
						}
					?>
					<th style="text-align:center; width: 5%">ACTION</th>
				</thead>
				<tbody>
					<?php $i=1; $j=0;foreach ($minmax as $mm) { 	?>
					<tr row-id="">
						<td style="text-align:center"><?php echo $i++; ?></td>
						<td style="text-align:center"><?php echo $mm['SEGMENT1']; ?></td>
						<input type="hidden" name="seg1[<?=$j ?>]" value="<?= $mm['SEGMENT1'] ?>">
						<td style="text-align:center"><?php echo $mm['DESCRIPTION']; ?></td>
						<td style="text-align:center"><?php echo $mm['PRIMARY_UOM_CODE']; ?></td>
						<td style="text-align:center"><?php echo $mm['MIN']; ?></td>
						<td style="text-align:center"><?php echo $mm['MAX']; ?></td>
						<td style="text-align:center"><?php echo $mm['ROP']; ?></td>
						<?php
						if ($org == 'ODM') {
						?>
						<td style="text-align:center">
							<!-- <label class="switch">
							  <input type="checkbox">
							  <span class="slider"></span>
							</label> -->
							<input type="checkbox" name="limitjob[<?=$j ?>]" value="Y" data-code="<?php echo $mm['SEGMENT1']; ?>" data-value="Y" class="cekcekSMM"
						<?php
							// echo $mm['LIMITJOB'];
							if ($mm['LIMITJOB'] == 'Y') {
							 	echo ' checked="checked"';
							 }
						?>
						 >
						 <!-- <button type="button" class="checkSMM" name="button"></button> -->
						</td>
						<?php
							}
						?>
						<td style="text-align:center">

							<a class="btn btn-warning btn-xs" title="Edit" href="<?php echo base_url(); ?>SettingMinMax/EditbyRoute<?php echo '/EditItem/'.$org.'/'.$routeaktif.'/'.$mm['SEGMENT1'] ?>"><span class="icon-edit"></span> Edit</a>
						</td>
					</tr>
					<?php $j++; } ?>
				</tbody>
			</table>
			<button style="visibility: hidden;" type="submit">SAVE</button>
			</form>
		</div>
		<div class="box box-info">
			<?php
				if ($org == 'ODM') {
			?>
			<!-- <div style="padding-top: 10px; padding-bottom: 10px;">
				<center><span class="btn btn-success" id="sublimit"><span class="fa fa-floppy-o"> SAVE</span></span></center>
			</div> -->
			<?php } ?>
			<div style="padding-top: 10px; padding-bottom: 10px;">
				<center><a href="<?php echo base_url('SettingMinMax/Edit')?>" class="btn btn-danger"><span class="fa fa-arrow-left"> BACK</span></a></center>
			</div>
		</div>
	</div>
		</div>
	</div>
</section>
