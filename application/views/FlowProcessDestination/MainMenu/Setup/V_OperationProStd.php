<style type="text/css">

.form-control{
	border-radius: 20px;
}

textarea.form-control{
	border-radius: 10px;
}
	.btnHoPg{
		height: 40px;
		width: 40px;
		border-radius: 50%;
		margin-top: 20px;
	}
	.select2-selection{
		border-radius: 20px !important;
	}

	ul.select2-results__options:last-child{
		border-bottom-right-radius: 20px !important;
		border-bottom-left-radius: 20px !important;
	}

	input.select2-search__field{
		border-radius: 20px !important;
	}

	span.select2-dropdown{
		border-radius: 20px !important;
	}

.loadOSIMG{
	width: 30px;
	height: auto;
}

#label-src{
	cursor: help;
	border-radius: 20px;
}

.hh{
	text-align: right;
}

.btn {
		border-radius: 20px !important;
	}
.rs {
	background-color: whitesmoke;
	padding: 20px;
	border-radius: 20px;
	margin-top: 20px !important;
	display: none ;
}

.table-curved {
	   border-collapse: separate;
	   border: solid #ddd 1px;
	   border-radius: 6px;
	   border-left: 0px;
	   border-top: 0px;
	}

	.table-curved th {                                                                                                            
		background-color: #3c8dbc !important;
		color: white;
		text-align: center;
		vertical-align: middle !important;
	}
	.table-curved > thead:first-child > tr:first-child > th {
	    border-bottom: 0px;
	    border-top: solid #ddd 1px;

	}
	.table-curved td, .table-curved th {
	    border-left: 1px solid #ddd;
	    border-top: 1px solid #ddd;
	}
	.table-curved > :first-child > :first-child > :first-child {
	    border-top-left-radius: 6px;
	}
	.table-curved > :first-child > :first-child > :last-child {
	    border-top-right-radius: 6px;
	}
	.table-curved > :last-child > :last-child > :first-child {
	    border-bottom-left-radius: 6px;
	}
	.table-curved > :last-child > :last-child > :last-child {
	    border-bottom-right-radius: 6px;
	}

.dataTables_scroll
	{
	    overflow:auto;
	}

.btn2 {
		border-bottom-right-radius: 20px !important; 
		border-top-right-radius: 20px !important;
		border-top-left-radius: 0 !important;
		border-bottom-left-radius: 0 !important;
	}
#delFileOldDrawing:hover{
	cursor: pointer;
}


</style>
<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11" style="height: 70px">
							<div class="text-right">
								<h1><b id="titleSrcFPD">Operation Process Standard</b></h1>
							</div>
						</div>
						<div class="col-lg-1 " style="height: 70px">
							<div class="text-right ">
								<a class="" href="">
									<button class="btnHoPg btn btn-default btn-md">
										<b class="fa fa-cog "></b>
									</button>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row" >
					<div class="col-lg-12" >
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<button class="btn btn-md  btn-primary btnFrmFPDHome0"><b>List Operation Process</b></button>
								<button class="btn btn-md  btn-primary btnSub btnFrmFPDsub01" style="display: none"><b class="fa fa-chevron-right "></b> &nbsp;<b id = "subTitleSub1"></b></button>
							</div>
							<div class="box-body" style="min-height: 350px" >
								<div class="col-lg-12 res-div" >
									<table class="table table-curved table-striped table-hover tblSrcFPD">
										<thead>
											<tr>
												<th>No.</th>
												<th><input type="checkbox" name="select-all"></th>
												<th>Operation Std</th>
												<th>Operation Std Desc</th>
												<th>Operation Group</th>
												<th>Start Date Active</th>
												<th>End Date Active</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($OprProcessOpr as $key => $value) { ?>
												<tr class="row-ops">
													<td><center><?= $key+1 ?></center></td>
													<td><center><input type="checkbox" name="check[]" value="<?= $value['operation_process_std_id'] ?>"></center></td>
													<td class="opr_pro_std"><?= $value['operation_process_std'] ?></td>
													<td><?= $value['operation_process_std_desc'] ?></td>
													<td><?= $value['operation_group'] ?></td>
													<td><?= $value['start_date_active'] ?></td>
													<td><?= $value['end_date_active'] ?></td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
									<div class="col-lg-12" style="margin-top: 20px">
										<button class="btn btn-md btn-success btnFPD" data-id="" ><i class="fa fa-plus "></i><b> ADD New </b></button>
										<button disabled="disabled" class="btn btn-md btn-danger  btnFPD1 " data-toggle="modal" data-target="#modalDelFPD"> <i class="fa fa-times"></i> <b> Delete </b> </button>
										<button disabled="disabled" class="btn btn-md btn-primary  btnFPD2 " data-id=""> <i class="fa fa-edit"></i> <b> Edit </b> </button>
									</div>
									<!-- modal delete -->
									<div class="modal fade" id="modalDelFPD" role="dialog" aria-labelledby="modalDelFPDtit" aria-hidden="true">
										<div class="modal-dialog" style="min-width:800px; border-radius: 20px">
										<div class="modal-content" style=" border-radius: 20px">
										  <div class="modal-header" style="background-color: #dd4b39; border-top-right-radius: 20px; border-top-left-radius: 20px">
										    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										    <h4 class="modal-title" id="modalDelFPDtit" style="color: white; font-weight: bold;">Apakah anda Yakin?</h4>
										  </div>
										  <div class="modal-body" >
										    <center>
										      Menghapus <b id="jmlDelFPD"></b> item ?
										    </center>
										    <div id="apaajaDelFPD" class="text-center">
										    </div>
											<input type="hidden" name="ops_id" >
										  </div>
										  <div class="modal-footer">
										    <button class="btn btn-danger actionModalFPD" data-id="" >Delete</button>
										    <button type="button" class="btn btn-default closeModalFPD" data-dismiss="modal">Close</button>
										  </div>
										</div>
										</div>
									</div>
								</div>
							</div>
							<div class="box-footer">
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	</div>
</section>
<script type="text/javascript">
	var jenisFPD = 'OPRPROSTD';
</script>