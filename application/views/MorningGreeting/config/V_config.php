<section class="content">
	<div class="inner">
	<div class="box box-info">
	<div style="padding-top: 10px">
		<div class="box-header with-border">
			<h4>Morning Greeting Configuration</h4>
		</div>
		<div class="box-body" style="padding-top:50px;">
				<table id="config" class="table table-striped table-bordered table-responsive table-hover text-center">
					<thead style="background:#22aadd; color:#FFFFFF;">
						<th style="width:5%;">No</th>
						<th>Parameter</th>
						<th>Value</th>
						<th style="width:15%;">Action</th>
					</thead>
					<tbody>
					<?php $no=1; foreach($config as $config_item){ ?>
						<tr>
							<td><?php echo $no++; ?></td>
							<td><?php echo $config_item['parameter'];?></td>
							<td><?php echo $config_item['value']; ?></td>
							<td>
							<div class="btn-group-justified" role="group">
								<a class="btn btn-warning btn-sm" href="<?php echo base_url()?>MorningGreeting/configuration/edit/<?php echo $config_item['parameter']?>" >
									<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
								</a>
							</div>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
		<div class="box box-info"></div>
		</div>
	</div>
	</div>
</section>
