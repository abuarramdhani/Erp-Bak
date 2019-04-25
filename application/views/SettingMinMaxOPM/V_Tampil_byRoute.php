<?php 
	// echo "<pre>";
	// print_r($org);
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
			<table id="tableDataMinMax" class="table table-striped table-bordered table-responsive table-hover" >
				<thead style="background:#22aadd; color:#FFFFFF;">
					<th style="text-align:center; width: 5%">NO</th>
					<th style="text-align:center; width: 15%">ITEM CODE</th>
					<th style="text-align:center; width: 20%">DESCRIPTION</th>
					<th style="text-align:center; width: 10%">UOM</th>
					<th style="text-align:center; width: 15%">MIN</th>
					<th style="text-align:center; width: 15%">MAX</th>
					<th style="text-align:center; width: 15%">ROP</th>
					<th style="text-align:center; width: 5%">ACTION</th>
				</thead>
				<tbody>
					<?php $i=1; foreach ($minmax as $mm) { 	?>
					<tr row-id="">
						<td style="text-align:center"><?php echo $i++; ?></td>
						<td style="text-align:center"><?php echo $mm['SEGMENT1']; ?></td>
						<td style="text-align:center"><?php echo $mm['DESCRIPTION']; ?></td>
						<td style="text-align:center"><?php echo $mm['PRIMARY_UOM_CODE']; ?></td>
						<td style="text-align:center"><?php echo $mm['MIN']; ?></td>
						<td style="text-align:center"><?php echo $mm['MAX']; ?></td>
						<td style="text-align:center"><?php echo $mm['ROP']; ?></td>
						<td style="text-align:center">

							<a class="btn btn-warning btn-xs" title="Edit" href="<?php echo base_url(); ?>SettingMinMax/EditbyRoute<?php echo '/EditItem/'.$org.'/'.$routeaktif.'/'.$mm['SEGMENT1'] ?>"><span class="icon-edit"></span> Edit</a>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="box box-info">
			<div style="padding-top: 10px; padding-bottom: 10px;">
				<center></span><a href="<?php echo base_url('SettingMinMax/Edit')?>" class="btn btn-success"><span class="fa fa-check-square"> SELESAI</a></center>
			</div>
		</div>
	</div>
		</div>
	</div>
</section>