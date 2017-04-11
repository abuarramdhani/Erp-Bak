<section id="showNewClaims">
	<div class="inner">
	<div class="box box-success">
	<div style="padding-top: 10px">
		<div class="box-header with-border">
			<h3 style="text-align:center;"><strong>Approved Claims Data</strong></h3>
			<div class="pull-right box-tools">
        	    <button type="button" class="btn btn-success btn-sm" data-widget="remove">
        	    	<i class="fa fa-times"></i>
        	    </button>
        	</div>
		</div>
		<div class="box-body">
			<table id="tbApprovedClaim" class="table table-striped table-bordered table-responsive table-hover">
				<thead style="background:#22852a; color:#FFFFFF;">
						<th style="text-align:center; max-width: 5%;">NO</th>
						<th style="text-align:center">CLAIM NUMBER</th>
						<th style="text-align:center">CLAIM PRIORITY</th>
						<th style="text-align:center">CUSTOMER NAME</th>
						<th style="text-align:center">OWNER NAME</th>
						<th style="text-align:center">CLAIM DATE</th>
						<th style="text-align:center" class="col-md-2">ACTION</th>
				</thead>
				<tbody>
					<?php $no=1; foreach ($header as $h) { ?>
						<tr>
							<td style="text-align:center"><?php echo $no++; ?></td>
							<td><?php echo $h['HEADER_ID']; ?></td>
							<td><?php echo $h['PRIORITY']; ?></td>
							<td><?php echo $h['PARTY_NAME']; ?></td>
							<td>
								<?php if ($h['OWNER_NAME'] == NULL) {
									$own = '<center>'.'--'.'</center>';
								}else{
									$own = $h['OWNER_NAME'];
								}
								echo $own; ?>
							</td>
							<td><?php echo $h['CREATION_DATE']; ?></td>
							<td>
								<div class="btn-group btn-group-justified">
									<a class="btn btn-default" data-toggle="modal" data-target="#show<?php echo $h['HEADER_ID']; ?>">SHOW</a>
									<a class="btn btn-default" data-toggle="modal" data-target="#closed<?php echo $h['HEADER_ID']; ?>">CLOSE</a>
									<a class="btn btn-default" href="<?php echo base_url(); ?>SalesOrder/CentralApproval/Print/<?php echo $h['HEADER_ID']; ?>">PRINT</a>
								</div>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	</div>
	</div>
</section>
