<style type="text/css">
	.select2-container {
		width: 100% !important;
		padding: 0;
	}
	.btn-real-dis{
		color: #888;
	}

	.btn-real-ena{
		cursor: pointer;
	}
</style>
<section class="content">
	<div class="box box-default color-palette-box">
		<div class="box-body" id="approvalMPA">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs pull-right">
					<li><a href="#approval-seksi" data-toggle="tab">Seksi Terkait</a></li>
					<li class="active"><a href="#approval-staff" data-toggle="tab">Staff Maintenance</a></li>
					<li class="pull-left header"><i class="fa fa-tag"></i> Approval Periodical Maintenance</li>
				</ul>
				<div class="tab-content">
					<?php 
					$desc[0]['name'] = 'Staff';
					$desc[0]['id_tab'] = 'approval-staff';
					$desc[0]['id_table'] = 'tblStaffMtn';
					$desc[0]['name_array'] = 'approval_staffmtn';
					$desc[0]['bg_color'] = 'bg-primary';

					$desc[1]['name'] = 'Seksi';
					$desc[1]['id_tab'] = 'approval-seksi';
					$desc[1]['id_table'] = 'tblSeksiTerkait';
					$desc[1]['name_array'] = 'approval_seksi';
					$desc[1]['bg_color'] = 'btn-danger';

					for ($i=0; $i < 2; $i++) {
					?>
					<div class="tab-pane <?= $i == 0 ? 'active' : '' ?>" id="<?= $desc[$i]['id_tab'] ?>">
						<div class="table-responsive">
							<table class="table table-bordered table-fit tblApprovalMPA" id="<?= $desc[$i]['id_table'] ?>">
								<thead>
									<tr class="<?= $desc[$i]['bg_color'] ?>">
										<th class="text-center" width="3%">No</th>
										<th class="text-center" width="28%">Document Number</th>
										<th class="text-center" width="20%">Nama Mesin</th>
										<th class="text-center" width="12%">Type Mesin</th>
										<th class="text-center" width="22%">Schedule Date</th>
										<th class="text-center" width="10%">Actual Date</th>
										<th class="text-center" width="5%">Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php 
                                    $no = 0;
                                     foreach ($$desc[$i]['name_array'] as $approval):; $no++ ?>
									<tr>
										<td class="text-center"><?= $no; ?></td>
										<td><?= $approval['DOCUMENT_NUMBER']; ?></td>
										<td><?= $approval['NAMA_MESIN']; ?></td>
                                        <td><?= $approval['TYPE_MESIN']; ?></td>
										<td><?= $approval['SCHEDULE_DATE']; ?></td>
										<td><?= $approval['ACTUAL_DATE']; ?></td>
										<td class="text-center">
                                            <button type="button" class="btn btn-success btn-sm" onclick="approveMPA('<?= $approval['DOCUMENT_NUMBER'] ?>','<?= $desc[$i]['id_table'] ?>')"> Approve </button> 

                                        </td>
									</tr>
                                    <?php endforeach; 
                                ?>
								</tbody>
							</table>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Modal Approval -->
<div class="modal fade" id="modalApprovalMPA" role="dialog">
    <div class="modal-dialog" style="width:60%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Approval</h3>
                </center>
            </div>
            <div class="modal-body">
				<div id="subApprovalMPA"></div>
				<div class="panel-body">                            
					<div class="col-md-4" style="text-align: right;"><label>Request Seksi Terkait : </label></div>                                        
					<div class="col-md-4">
						<select class="form-control select select2" name="reqSeksiysb" id="reqSeksiysb" data-placeholder="Approver Seksi" style="width:100%;" required>
						<option value=""></option>
						<?php foreach ($approver2 as $appr2) { ?>
							<option value="<?php echo $appr2['noind'] ?>"><?php echo $appr2['noind'] . " - " . $appr2['nama'] ?></option>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-md-12" style="text-align:right"><button class="btn btn-success btn-approve-mpa">Approve</button></div>
				</div>
            </div>
        </div>

    </div>
</div>




