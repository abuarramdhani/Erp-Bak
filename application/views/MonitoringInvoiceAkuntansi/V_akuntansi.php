<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
</style>

<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>List Batch Finance</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<table id="tbListSubmit" class="table table-striped table-bordered table-hover text-center tblMI">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center">Action</th>
											<th class="text-center">Batch Number</th>
											<th class="text-center">Submited Date</th>
											<th class="text-center">Invoices</th>
											<th class="text-center">PIC</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; if($batch) { foreach($batch as $b) { ?>
										<tr>
											<td><?php echo $no ?></td>
											<td>
												<a href="<?php echo base_url('AccountPayables/MonitoringInvoice/Unprocess/unprocess/'.$b['BATCH_NUMBER'])?>">
													<button type="button" class="btn btn-default">Detail</button>
												</a>
											</td>
											<td><?php echo $b['BATCH_NUMBER']?></td>
											<td data-order="<?php echo date('Y-m-d', strtotime($b['SUBMITED_DATE']))?>"><?php echo date('d-M-Y',strtotime($b['SUBMITED_DATE']))?></td>
											<td><?php echo $b['jml_invoice']?></td>
											<td><?php echo $b['SOURCE']?></td>
										</tr>
										<?php $no++; }} ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="modal fade" id="mdlOrclReportMI">
	<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">KHS Monitoring Receipt PO</h4>
		</div>
		<form action="<?php echo base_url('AccountPayables/MonitoringInvoice/Unprocess/get_report') ?>" method="post">
			<div class="modal-body">
				<label for="org_id">Organization</label>
				<select name="organization_id" class="form-control select2" id="inpOrganizationMI" style="width: 570px;" placehoder="Select Organization">
					<!-- <option value="-" disabled>Select Organization</option> -->
					<?php
						foreach ($organization as $key => $org) {
							$code = $org['CODE'];
							$id = $org['ID'];
							echo "<option value='$id'>$code</option>";
						}
					?>
				</select>
				<label for="receipt_from">Receipt From</label>
				<input type="text" name="receipt_from" class="form-control" id="inpRcptFromMI" width="570px">
				<label for="receipt_to">Receipt To</label>
				<input type="text" name="receipt_to" class="form-control" id="inpRcptToMI" width="570px">
			</div>
			<div class="modal-footer mt-10">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" id="btnSubmitReportMI">Run</button>
			</div>
		</form>
	</div>
	</div>
</div>