<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-md-11">
				<div class="text-right">
					<h1><b>CREDIT LIMIT</b></h1>
				</div>
			</div>
			<div class="col-md-1">
				<a class="btn btn-default btn-lg" href="<?php echo base_url('AccountReceivables/CreditLimit/New'); ?>">
					<i class="icon-plus icon-2x"></i>
					<span ><br /></span>
				</a>
			</div>
		</div>
	<div class="box box-info">
		<div class="box-body">
			<table id="creditLimit" class="table table-striped table-bordered table-responsive table-hover">
				<thead style="background:#22aadd; color:#FFFFFF;">
					<th style="text-align:center">NO</th>
					<th style="text-align:center">BRANCH</th>
					<th style="text-align:center">CUSTOMER NAME</th>
					<th style="text-align:center">ACCOUNT NUMBER</th>
					<th style="text-align:center">OVERALL CREDIT LIMIT</th>
					<th style="text-align:center">EXPIRED DATE</th>
					<th style="text-align:center">ACTION</th>
				</thead>
				<tbody>
				<?php $no = 1; foreach ($credit as $cl) { ?>
					<tr>
						<td style="text-align:center"><?php echo $no++; ?></td>
						<td style="text-align:center"><?php echo $cl['NAME']; ?></td>
						<td style="text-align:center"><?php echo $cl['PARTY_NAME']; ?></td>
						<td style="text-align:center"><?php echo $cl['ACCOUNT_NUMBER']; ?></td>
						<td style="text-align:right"><?php echo number_format($cl['OVERALL_CREDIT_LIMIT'],0,",","."); ?></td>
						<td style="text-align:center"><?php echo $cl['EXPIRED_DATE']; ?></td>
						<td style="text-align:center" class="col-md-2">
							<div class="btn-group-justified" role="group">
								<a class="btn btn-default" href="<?php echo base_url(); ?>AccountReceivables/CreditLimit/Edit/<?php echo $cl['LINE_ID'].'/'.$cl['ORG_ID']; ?>">EDIT</a>
								<a class="btn btn-default" data-toggle="modal" data-target="#delete<?php echo $cl['LINE_ID']; ?>">DELETE</a>
							</div>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="box box-info"></div>
	</div>
	</div>
</section>