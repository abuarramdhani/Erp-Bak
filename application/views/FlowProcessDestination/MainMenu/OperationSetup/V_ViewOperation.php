<style type="text/css">
		.btn3{
		width: 30px;
		height: 30px;
		border-radius: 50%;
		background-color: #b7ffde;
		vertical-align: middle;
		text-align: center;
		padding: 5px;
		border: 1px solid #207850;
		color: #207850;
	}
	.btn4{
		width: 30px;
		height: 30px;
		border-radius: 50%;
		background-color: #eab7b5;
		vertical-align: middle;
		text-align: center;
		padding: 5px;
		border: 1px solid #9c3d3d;;
		color: #9c3d3d;
	}

	.btndis{
		background-color: #ececec;
		border: 1px solid #757575;
		color: #959595;
	}
	tr {
		background-color: white;
		cursor: pointer;
	}

	.tract {
		background-color: #b6edff !important;
	}
	/*.noso{
		display: none;
	}*/
</style>
<table class="table table-curved tblSrcFPD  table-striped" id="tblSrcFPD" width="200%">
	<thead>
		<tr>
			<th width="2%"> <input type="checkbox" name="select-all"> </th>
			<th width="2%"> No. </th>
			<th width="5%"> Sequence Number </th>
			<th width="6%"> Planning Make Buy </th>
			<th width="10%"> Operation Process </th>
			<th width="15%"> Operation Process Detail</th>
			<th width="6%">Machine Min Requirement</th>
			<th width="8%">Planning Tool</th>
			<th width="16%">Planning Measurement Tool</th>
			<!-- <th width="10%">Process Sheet Doc</th>
			<th width="10%">QCPC Doc</th>
			<th width="10%">CBO Doc</th> -->
		</tr>
	</thead>
	<tbody>
		<?php $no = 1; foreach ($operation as $key => $value): ?>
			<tr class="row-opr">
				<td><center><input type="checkbox" name="check[]" value="<?= $value['operation_id'] ?>"></center></td>
				<td><center><?= $no++; ?></center></td>
				<td class="seq_num"><?= $value['operation_seq_num']; ?></td>
				<td><?= ($value['planning_make_buy']) ? ($value['planning_make_buy'] == '1' ? 'Make' : 'Buy') : '' ; ?></td>
				<td> <a href="" ></a> <?= $value['operation_process_std'] ?></td>
				<td><?= $value['operation_process_detail'] ?></td>
				<td><?= $value['machine_min_requirement'] ?></td>
				<td class="planning_tool">
					<?php 
						if ($value['planning_tool'] == '1') {
							if ($value['tool'] == '1' ) {
								echo "( Existing )";
								echo $value['tool_name'];
								echo "<a href='#modalInfoFPD' data-id='".$value['tool_nomor']."' onclick='getInfoFPD(this)' data-toggle='modal' data-target='#modalInfoFPD'> <i class='fa fa-info-circle'></i></a>";
							}else{
								echo "( New )";
							}
						}else{
							echo "-";
						}
					?>
				</td>
				<td>
					<?php if ($value['planning_measurement_tool'] == '1') {
						echo $value['measurement_tool_name'];
						echo "<a href='#modalInfoFPD' data-id='".$value['measurement_tool_id']."' onclick='getInfoFPD(this)' data-toggle='modal' data-target='#modalInfoFPD'> <i class='fa fa-info-circle'></i></a>";
					}else{
						echo "-";
					} ?>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<div class="col-lg-12" style="margin-top: 20px">
	<button class="btn btn-md btn-success btnAddOperationFPD" data-id="<?= $component_id; ?>" ><i class="fa fa-plus "></i><b> ADD New Operation</b></button>
	<button disabled="disabled" class="btn btn-md btn-danger  btnFPDOperaDel " data-toggle="modal" data-target="#modalDelFPD"> <i class="fa fa-times"></i> <b> Delete </b> </button>
	<button disabled="disabled" class="btn btn-md btn-primary  btnFPDOperaDit " data-id="<?= $component_id; ?>"> <i class="fa fa-edit"></i> <b> Edit </b> </button>
</div>

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
	<input type="hidden" name="operation_id" >
  </div>
  <div class="modal-footer">
    <button class="btn btn-danger delOperationFPD" data-id="<?= $component_id ?>" >Delete</button>
    <button type="button" class="btn btn-default closeOperationFPD" data-dismiss="modal">Close</button>
  </div>
</div>
</div>
</div>

<div class="modal fade" id="modalInfoFPD" role="dialog" aria-labelledby="modalInfoFPD" aria-hidden="true">
<div class="modal-dialog" style="min-width:800px; border-radius: 20px">
<div class="modal-content" style=" border-radius: 20px">
  <div class="modal-header" style="background-color: #5badda; border-top-right-radius: 20px; border-top-left-radius: 20px">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="modalInfoFPDtit" style="color: white; font-weight: bold;"></h4>
  </div>
  <div class="modal-body" id="modalInfoFPDBody" >
    
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default closeOperationFPD" data-dismiss="modal">Close</button>
  </div>
</div>
</div>
</div>