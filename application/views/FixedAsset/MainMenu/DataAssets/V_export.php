<section class="content">
	<div class="inner">
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Data Assets</b></h1>
						
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('FixedAsset/DataAssets');?>">
                                <i class="fa fa-bookmark fa-2x"></i>
                                <span ><br /></span>
                            </a>
							
						</div>
					</div>
				</div>
			</div>
			<br />
		<div class="row">
			<table class="table table-striped table-bordered table-hover text-left" style="font-size:12px;min-width:4800px;table-layout: fixed;" id="dataTables" style="font-size:12px;">
				<thead>
					<tr class="bg-primary">
						<th width="100px"><center>Tag Number</center></th>
						<th width="200px"><center>Location</center></th>
						<th width="120px"><center>Asset Category</center></th>
						<th width="400px"><center>Item</center></th>
						<th width="15%"><center>Specification</center></th>
						<th width="15%"><center>Serial Number</center></th>
						<th width="10%"><center>Power</center></th>
						<th width="10%"><center>Old Number</center></th>
						<th width="15%"><center>Person In Charge</center></th>
						<th width="15%"><center>BPPBA Number</center></th>
						<th width="15%"><center>BPPBA Date</center></th>
						<th width="15%"><center>LPA Number</center></th>
						<th width="15%"><center>LPA Date</center></th>
						<th width="15%"><center>Transfer Number</center></th>
						<th width="15%"><center>Transfer Date</center></th>
						<th width="15%"><center>Retirement Number</center></th>
						<th width="15%"><center>Retirement Date</center></th>
						<th width="15%"><center>PP Number</center></th>
						<th width="15%"><center>PO Number</center></th>
						<th width="15%"><center>PR Number</center></th>
						<th width="15%"><center>Add-by</center></th>
						<th width="12%"><center>Add-by Date</center></th>
						<th width="12%"><center>Upload Oracle</center></th>
						<th width="15%"><center>Upload Oracle Date</center></th>
						<th width="15%"><center>Description</center></th>
						<th width="15%"><center>Insurance</center></th>
						<th width="10%"><center>Appraisal</center></th>
						<th width="12%"><center>Stock Opname</center></th>
					</tr>
				</thead>
				<tbody>
				<?php $num = 0;
				foreach ($DataAsset as $row):
				$num++;
				?>
						<tr>
							<td><?php echo $row['tag_number'];?></td>
							<td><?php echo $row['location'];?></td>
							<td><?php echo $row['asset_category'];?></td>
							<td><?php echo $row['item_code'];?></td>
							<td><?php echo $row['specification'];?></td>
							<td><?php echo $row['serial_number'];?></td>
							<td><?php echo $row['power'];?></td>
							<td><?php echo $row['old_number'];?></td>
							<td><?php echo $row['person_in_charge'];?></td>
							<td><?php echo $row['bppba_number'];?></td>
							<td><?php echo $row['bppba_date'];?></td>
							<td><?php echo $row['lpa_number'];?></td>
							<td><?php echo $row['lpa_date'];?></td>
							<td><?php echo $row['transfer_number'];?></td>
							<td><?php echo $row['transfer_date'];?></td>
							<td><?php echo $row['retirement_number'];?></td>
							<td><?php echo $row['retirement_date'];?></td>
							<td><?php echo $row['pp_number'];?></td>
							<td><?php echo $row['po_number'];?></td>
							<td><?php echo $row['pr_number'];?></td>
							<td><?php echo $row['add_by'];?></td>
							<td><?php echo $row['add_by_date'];?></td>
							<td><?php echo $row['upload_oracle'];?></td>
							<td><?php echo $row['upload_oracle_date'];?></td>
							<td><?php echo $row['description'];?></td>
							<td><?php echo $row['insurance'];?></td>
							<td><?php echo $row['appraisal'];?></td>
							<td><?php echo $row['stock_opname'];?></td>
							
						</tr>
				<?php endforeach ?>
				</tbody>
			</table>
							
		</div>
	</div>
	</div>
</div>
</div>
</section>