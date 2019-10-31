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
	/*.noso{
		display: none;
	}*/

	tr {
		background-color: white;
	}

	tr {
		cursor: pointer;
	}
</style>
<input type="hidden" name="kode_comp">
<input type="hidden" name="name_comp">
<input type="hidden" name="opr_comp">
<table class="table table-curved table-striped table-hover" id="" width="200%">
	<thead>
		<tr>
			<!-- <th width="2%"></th> -->
			<th width="2%"> No. </th>
			<th width="6%"> Product </th>
			<th width="6%"> Drawing Group </th>
			<th width="6%"> Drawing Code </th>
			<th width="10%"> Drawing Description </th>
			<th width="10%"> Rev </th>
			<th width="5%" class="noso"> Drawing Date </th>
			<th width="5%" class="noso"> Drawing Material </th>
			<th width="5%" class="noso"> Weight </th>
			<th width="5%" class="noso"> Status </th>
			<th width="7%" class="noso"> Changing Ref Document </th>
			<th width="10%"> Changing Explanation </th>
			<th width="8%" class="noso"> Drawing Status </th>
			<th width="5%" class="noso"> Drawing Upper Level Code </th>
			<th width="9%" class="noso"> Drawing Upper Level Description </th>
			<th width="5%"> Changing Due Date </th>
			<th width="5%"> Drawing Unit</th>
			<th width="3%"> Quantity / Unit </th>
		</tr>
	</thead>
	<tbody>
	<?php 
		// echo "<pre>"; print_r($mbuh); exit(); 
	?>
	<?php $no=1; foreach ($mbuh as $ola => $value) { 
		// echo "<pre>"; print_r($ola); ?>
		<tr class="row-comp">
			<!-- <td><center><input type="radio" name="checkrad[]" value="<?= $value['component_id'] ?>"></center> -->
				<!-- <input type="hidden" name="opr" value="<?= $value['opr'] ?>"> -->
			<!-- </td> -->
			<td><center><?= $no++ ; ?></center></td>
			<td><?= $value['product_component_code'] ?></td>
			<td><?= $value['product_component_id'] ?></td>
			<td class="d_code drw_code"><?= $value['component_code'] ?></td>
			<td class="d_desc"><?= $value['component_name'] ?></td>
			<td class="noso"><?= $value['revision'] ? date('d/m/Y',strtotime($value['revision'])) : '-' ?></td>
			<td class="noso"><?= $value['revision_date'] ?></td>
			<td class="noso"><?= $value['material_type'] ?></td>
			<td class="noso"><?= $value['weight'] ?></td>
			<td class="noso"><?= $value['memo_number'] ?></td>
			<td class="noso"><?= $value['information'] ?></td>
			<td class="noso"><?= $value['drw_status'] ? ($value['drw_status'] == 1 ? 'Mass Production' : 'Prototype' ) : '-' ?></td>
			<td class="noso"><?= $value['drw_upper_level_code'] ?></td>
			<td class="noso"><?= $value['drw_upper_level_desc'] ?></td>
			<td class="noso"><?= $value['component_status'] ? ($value['component_status'] == 1 ? 'Baru' : 'Menggantikan' ) : '-' ?></td>
			<td class="noso"><?= $value['old_drw_code'] ? : '-' ?></td>
			<td class="text-center noso">
				<?php if ($value['changing_ref_doc']) { ?>
					<a target="_blank" href="<?= base_url('assets/upload_flow_process/component/changing_ref/').'/'.$value['changing_ref_doc'] ?>">
						<button class="btn btn-xs btn-success "> <b class="fa fa-search-plus"> Open File</b> </button>
					</a>
				<?php }else{ ?>
						<button class="btn btn-xs btn-default disabled "> <b class="fa fa-search-minus"> File not found</b> </button>
				<?php } ?>
			</td>
			<td><?= $value['changing_ref_expl'] ?></td>
			<td><?= $value['changing_due_date'] ? date('d/m/Y',strtotime($value['changing_due_date'])) : '-' ?></td>
			<td class="text-center">
				<?php if ($value['gambar_kerja']) { ?>
					<a target="_blank" href="<?= base_url('assets/upload_flow_process/component/gambar_unit/').'/'.$value['gambar_kerja'] ?>">
						<button class="btn btn-xs btn-success "> <b class="fa fa-search-plus"> Open File</b> </button>
					</a>
				<?php }else{ ?>
						<button class="btn btn-xs btn-default disabled "> <b class="fa fa-search-minus"> File not found</b> </button>
				<?php } ?>
			</td>
			<td > <center><?= $value['component_qty_per_unit'] ?></center></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<!-- <div class="col-lg-9" style="margin-top: 20px">
	<button class="btn btn-md btn-success btnAddComponentFPD" data-id="<?= $product_id; ?>" ><i class="fa fa-plus "></i><b> ADD New Component</b></button>
	<button class="btn btn-md btn-success btnAddComponentFPD2" data-id="<?= $product_id; ?>" ><i class="fa fa-plus "></i><b> ADD New Component bbg</b></button>	
	<button disabled="disabled" class="btn btn-md btn-primary  btnFPDCompoDit " data-id="<?= $product_id; ?>"> <i class="fa fa-edit"></i> <b> Edit </b> </button>
	<button disabled="disabled" class="btn btn-md btn-info btnSetupOprFPD" data-nm="" data-id=""> <i class="fa fa-cogs"></i><b> Operation </b></button>
</div>
<div class="col-lg-3" style="margin-top: 20px; text-align: right;">
	<button style="display: none;" disabled="disabled" class="btn btn-md btn-danger btnFPDCompoDel " data-toggle="modal" data-target="#modalDelFPD"> <i class="fa fa-times txtbtnhehe"></i> <b class="txtbtnhehe">Set Innactive</b> </button>
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
      Menginactivekan <b id="apaajaDelFPD"></b> ?
    </center>
    <!-- <div id="apaajaDelFPD" class="text-center"> -->
    <!-- </div> -->
	
	
	
	<!-- <input type="hidden" name="component_id" > -->



  </div>
  <div class="modal-footer">
    <button class="btn btn-danger inActiveComponentFPD" data-id="<?= $product_id ?>" >Innactive Item</button>
    <button type="button" class="btn btn-default closeComponentFPD" data-dismiss="modal">Close</button>
  </div> -->
</div>
</div>
</div>

<div class="modal fade" id="modalSetupOpr" role="dialog" aria-labelledby="modalSetupOprtit" aria-hidden="true">
<div class="modal-dialog" style="min-width:800px; border-radius: 20px">
<div class="modal-content" style=" border-radius: 20px">
  <div class="modal-header" style="background-color: #5badda; border-top-right-radius: 20px; border-top-left-radius: 20px">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="modalSetupOprtit" style="color: white; font-weight: bold;">Warning</h4>
  </div>
  <div class="modal-body" >
    <center>
      Belum ada Operation terdaftar, <b>Setup Operation ?</b>
    </center>
    <!-- <div id="apaajaDelFPD" class="text-center"> -->
    <!-- </div> -->
	<input type="hidden" name="component_id" >
  </div>
  <div class="modal-footer">
    <button class="btn btn-info btnAddOperationFPD" data-id="" >YES</button>
    <button type="button" class="btn btn-default closeComponentFPD" data-dismiss="modal">NO</button>
  </div>
</div>
</div>
</div>