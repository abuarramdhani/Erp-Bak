<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-md-11">
				<div class="text-right">
					<h1><b>To Do</b></h1>
				</div>
			</div>
			<div class="col-md-1">
				<a class="btn btn-default btn-lg" href="<?php echo base_url('ProductionEngineering/Order/New'); ?>">
					<i class="icon-plus icon-2x"></i>
					<span ><br /></span>
				</a>
			</div>
		</div>
	<div class="box box-info">
		<div class="box-body">
			<table id="tableorder" class="table table-striped table-bordered table-responsive table-hover" >
				<thead style="background:#22aadd; color:#FFFFFF;">
					<th style="text-align:center">NO</th>
					<th style="text-align:center">To Do</th>
					<th style="text-align:center">DESKRIPSI</th>
					<th style="text-align:center">ACTION</th>
				</thead>
				<tbody>
				<?php $no = 1; foreach ($order as $cl) { ?>
					<tr row-id="<?php echo $cl['id'];?>">
						<td style="text-align:center"><?php echo $no; ?></td>
						<td style="text-align:center"><?php echo $cl['order_']; ?></td>
						<td style="text-align:center"><?php echo $cl['deskripsi'];  ?></td>
						<td style="text-align:center" class="col-md-2">
							<div class="btn-group-justified" role="group">
								<a class="btn btn-default" href="<?php echo base_url(); ?>ProductionEngineering/Order/<?php echo 'edit/'.$cl['id'] ?>">EDIT</a>
								<a class="btn btn-default hapus" onclick="DeleteOrder('<?php echo $cl['id'];?>')">DELETE</a>
							</div>
						</td>
					</tr>
				<?php $no++;} ?>
				</tbody>
			</table>
		</div>
		<div class="box box-info"></div>
	</div>
	</div>
</section>