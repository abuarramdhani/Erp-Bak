<section id="showNewClaims">
	<div class="inner">
	<div class="box box-danger">
	<div style="padding-top: 10px">
		<div class="box-header with-border">
			<h3 style="text-align:center;"><strong>New Claims Data</strong></h3>
			<div class="pull-right box-tools">
        	    <button type="button" class="btn btn-danger btn-sm" data-widget="remove">
        	    	<i class="fa fa-times"></i>
        	    </button>
        	</div>
		</div>
		<div class="box-body">
			<table id="tbNewClaim" class="table table-striped table-bordered table-responsive table-hover">
				<thead style="background:#ff3333; color:#FFFFFF;">
						<th style="text-align:center" class="col-md-1">NO</th>
						<th style="text-align:center" class="col-md-1">CLAIM NUMBER</th>
						<th style="text-align:center" class="col-md-2">CUSTOMER NAME</th>
						<th style="text-align:center" class="col-md-2">OWNER NAME</th>
						<th style="text-align:center" class="col-md-1">CLAIM DATE</th>
						<th style="text-align:center" class="col-md-2">ACTION</th>
				</thead>
				<tbody>
					<?php $no=1; foreach ($header as $h) { ?>
						<tr>
							<td style="text-align:center" class="col-md-1"><?php echo $no++; ?></td>
							<td style="text-align:center" class="col-md-2"><?php echo $h['HEADER_ID']; ?></td>
							<td class="col-md-2"><?php echo $h['PARTY_NAME']; ?></td>
							<td class="col-md-2">
								<?php if ($h['OWNER_NAME'] == NULL) {
									$own = '<center>'.'--'.'</center>';
								}else{
									$own = $h['OWNER_NAME'];
								}
								echo $own; ?>
							</td>
							<td class="col-md-2"><?php echo $h['CREATION_DATE']; ?></td>
							<td class="col-md-2">
								<div class="btn-group btn-group-justified">
									<a class="btn btn-default" data-toggle="modal" data-target="#firman<?php echo $h['HEADER_ID']; ?>">SHOW</a>
									<a class="btn btn-default" href="<?php echo base_url(); ?>SalesOrder/CentralApproval/ShowPict/<?php echo $h['HEADER_ID']; ?>">PICT</a>
									<a class="btn btn-default" href="<?php echo base_url(); ?>SalesOrder/BranchApproval/NewClaims/Edit/<?php echo $h['HEADER_ID']; ?>" >EDIT</a>
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
