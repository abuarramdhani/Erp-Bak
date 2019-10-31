<style type="text/css">
.imgpreview {
max-width: 1500px;
height: 520px;
}
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<!-- <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datepicker/css/datepicker.css');?>" /> -->
<form id="formAddComponent" method="post" action="<?= base_url('FlowProcess/ComponentSetup/saveComponent') ?>" enctype="multipart/form-data">
<div class="col-lg-12 " style=" margin-top: 20px">
	<div class="form-group col-lg-12" >
		<div class="col-lg-4 hh">
		    <label >Drawing Unit:</label>
		</div>
		<div class="col-lg-6">
		    <!-- <input type="file" class="" id="" placeholder="Changing Ref Document.. " name="fileGambarUnit" required> -->
				<form runat="server">
					<input type='file' accept="application/pdf" id="imgInp" laceholder="Changing Ref Document.. " name="fileGambarUnit"  required/>
				</form>
		</div>
	</div>
	<br>
	<div class="form-group col-lg-12">
		<!-- <center><img style="align : center" id="blah" src="#" alt="Drawing Unit" class="imgpreview hh"/></center> -->
		<!-- <center><img style="align : center" id="blah" src="#" alt="Drawing Unit" class="imgpreview hh"/></center> -->
		<embed src="#" style="align : center; display : none;" id="blah"  type='application/pdf' alt="Drawing Unit" class="imgpreview hh" width='100%' height='300px'/>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Code:</label>
		</div>
		<div class="col-lg-6">
		    <!-- <input placeholder="Input Drawing Code.." id="drw_code" type="text" name="txtDrawingCode" class="form-control"> -->
		    <select placeholder="Input Drawing Code.." id="selectDrawingCode" type="text" name="txtDrawingCode" class="form-control selectDrawingCode" required>
				<option></option>
			</select>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Status:</label>
		</div>
		<div class="col-lg-6">
		     <input type="radio" value="1" id="Drawing_status1" name="slcDrawingStatus">
			<label for="status1" class="label-radio" >Mass Production</label>
		    <input type="radio" value="2" id="Drawing_status2" name="slcDrawingStatus">
			<label for="status2" class="label-radio" >Prototype</label>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Upper Level Code:</label>
		</div>
		<div class="col-lg-6">
		    <input type="text" class="form-control" autocomplete="off" id="drw_upper_level_code" placeholder="Drawing Upper Level Code.. " name="txtUpperLevelCode" required>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Upper Level Description:</label>
		</div>
		<div class="col-lg-6">
		    <input type="text" class="form-control" autocomplete="off" id="drw_upper_level_desc" placeholder="Drawing Upper Level Desc.. " name="txtUpperLevelDesc" required>
		</div>
	</div>
	<!-- <div class="form-group col-lg-12 old-code" style="display: none"> -->
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Changing Due Date:</label>
		</div>
		<div class="col-lg-6">
		    <input type="text" class="dtPicker form-control" placeholder="Changing Due Date.." autocomplete="off" id="changing_due_date" name="dateChangingDueDate" required>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label>Component Qty Per Unit:</label>
		</div>
		<div class="col-lg-6">
		    <input type="number" autocomplete="off" class="form-control" id="component_qty_per_unit" style="width: 25%"  placeholder="Qty Per Unit.. " name="qtyComponent" required>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label>Document:</label>
		</div>
		<div class="col-lg-6">
		<input type="file" class="" id="" placeholder="Process Sheet Document.. " name="fileDocument" required>
		</div>
	</div>
	<!-- <div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label>Process Sheet Document:</label>
		</div>
		<div class="col-lg-6">
		<input type="file" class="" id="" placeholder="Process Sheet Document.. " name="fileProcessSheet" required>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label>QCPC Document:</label>
		</div>
		<div class="col-lg-6">
		<input type="file" class="" id="" placeholder="QCPC Document.. " name="fileQCPC" required>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label>CBO Document:</label>
		</div>
		<div class="col-lg-6">
		<input type="file" class="" id="" placeholder="CBO Document.. " name="filCBO" required>
		</div>
	</div> -->
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Group:</label>
		</div>
		<div class="col-lg-6">
		    <input autocomplete="off" placeholder="Input Drawing Group.." type="text" id="drw_group" name="txtDrawingGroup" class="form-control" required>
		</div>
	</div>
	<!-- <div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    
		</div>
		<div class="col-lg-6">
		    <a id="btn-searchKomponen2" class="btn-searchKomponen2 btn btn-default"><b>Search</b></a>
		    <a id="btn-searchKomponen3" class="btn-searchKomponen3 btn btn-default"><b>Search2</b></a>
			<a id="btn-searchcomp" class="btn-searchcomp btn btn-default" data-target="#searchcomp"><b>Search BBG</b></a>
		</div>
	</div> -->
	<!-- <div class="col-md-12">
		<div class="modal fade searchcomp" id="searchcomp" tabindex="-1" role="dialog" aria-labelledby="searchcompLabel" aria-hidden="true">
  			<div class="modal-dialog modal-lg">
    			<div class="modal-content">
					<div class="modal-header">
						<h2 class="modal-title" id="searchcompLabel">Apaya</h2>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
        					<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-curved table-striped table-hover" id="" width="200%">
							<thead>
								<tr>
									<th width="2%"> No. </th>
									<th width="6%"> product_component_code </th>
									<th width="6%"> component_code </th>
									<th width="6%"> component_name </th>
									<!-- <th width="10%"> Drawing Description </th> -->
									<!-- <th width="10%"> Rev </th>
									<th width="5%" class="noso"> revision_date </th>
									<th width="5%" class="noso"> material_type </th>
									<th width="5%" class="noso"> Weight </th> -->
									<!-- <th width="5%" class="noso"> Status </th>
									<th width="7%" class="noso"> Changing Ref Document </th>
									<th width="10%"> Changing Explanation </th>
									<th width="8%" class="noso"> Drawing Status </th>
									<th width="5%" class="noso"> Drawing Upper Level Code </th>
									<th width="9%" class="noso"> Drawing Upper Level Description </th>
									<th width="5%"> Changing Due Date </th>
									<th width="5%"> Drawing Unit</th>
									<th width="3%"> Quantity / Unit </th> -->
								<!-- </tr>
							</thead>
							<tbody>
								<tr>
									<!-- <td><center><?= $no++ ; ?></center></td>
									<td><?= $value['product_component_code'] ?></td> -->
									<!-- <td><?= $value['product_component_id'] ?></td> -->
									<!-- <td class="d_code drw_code"><?= $value['component_code'] ?></td>
									<td class="d_desc"><?= $value['component_name'] ?></td>
									<td class="noso"><?= $value['revision'] ? date('d/m/Y',strtotime($value['revision'])) : '-' ?></td>
									<td class="noso"><?= $value['revision_date'] ?></td>
									<td class="noso"><?= $value['material_type'] ?></td> -->
									<!-- <td class="noso"><?= $value['weight'] ?></td>
									<td class="noso"><?= $value['memo_number'] ?></td>
									<td class="noso"><?= $value['information'] ?></td>
									<td class="noso"><?= $value['drw_status'] ? ($value['drw_status'] == 1 ? 'Mass Production' : 'Prototype' ) : '-' ?></td>
									<td class="noso"><?= $value['drw_upper_level_code'] ?></td>
									<td class="noso"><?= $value['drw_upper_level_desc'] ?></td>
									<td class="noso"><?= $value['component_status'] ? ($value['component_status'] == 1 ? 'Baru' : 'Menggantikan' ) : '-' ?></td>
									<td class="noso"><?= $value['old_drw_code'] ? : '-' ?></td> -->
								<!-- </tr>
							</tbody>
						</table>
					</div>
    			</div>
  			</div>
		</div>
    </div> --> 
	<!-- <div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Code:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Drawing Code.." id="drw_code" type="text" name="txtDrawingCode" class="form-control">
		</div>
	</div> -->
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Description:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Drawing Description.." autocomplete="off" id="drw_description" type="text" name="txtDrawingDesc" class="form-control" required>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Revision:</label>
		</div>
		<div class="col-lg-6">
		    <input type="text" placeholder="Revision.." autocomplete="off" class=" form-control" id="rev" style="width: 25%" id="" name="txtRev" required>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Date:</label>
		</div>
		<div class="col-lg-6">
		    <input type="text" autocomplete="off" placeholder="Drawing Date.." class="dtPicker form-control" id="drw_date" id="" name="dateDrawingDate" required>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Material:</label>
		</div>
		<div class="col-lg-6">
		    <input type="text" autocomplete="off" class="form-control" id="drw_material" placeholder="Drawing Material.. " name="txtDrawingMaterial" required>
		</div>
	</div>
	<div class="form-group col-lg-12" >
		<div class="col-lg-4 hh">
		    <label >Weight:</label>
		</div>
		<div class="col-lg-6">
		    <input type="text" autocomplete="off" class="form-control" id="weight" placeholder="Weight Per Unit.. " name="weightComponent" required>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Component Status:</label>
		</div>
		<div class="col-lg-6">
		    <input type="radio" value="Y" id="statuscomp1" name="slcStatusComponent">
			<label for="status1" class="label-radio" >Active</label>
		    <input type="radio" value="N" id="statuscomp2" name="slcStatusComponent">
			<label for="status2" class="label-radio" >Inactive</label>
		</div>
	</div>
	<!-- <div class="form-group col-lg-12 old-code" style="display: none"> -->
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Changing Ref Document:</label>
		</div>
		<div class="col-lg-6">
		    <input type="text" class="form-control" autocomplete="off" id="changing_ref_doc" placeholder="Changing Ref Document.. " name="txtChangingRefDoc" required>
		</div>
	</div>
	<!-- <div class="form-group col-lg-12 old-code" style="display: none"> -->
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Changing Explanation:</label>
		</div>
		<div class="col-lg-6">
		    <input type="text" class="form-control" autocomplete="off" id="changing_ref_expl" placeholder="Changing Explanation.. " name="txtChangingExpl" required>
		</div>
	</div>
	<!-- <div class="form-group col-lg-12 old-code" style="display: none"> -->
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Old Drawing Code:</label>
		</div>
		<div class="col-lg-6">
		    <input type="text" class="form-control" autocomplete="off" id="old_drw_code" placeholder="Old Drawing Code.. " name="txtOldDrawingCode" required>
		</div>
	</div>
	<input type="hidden" id="productId" name="productId" class="productId" value="<?= $product_id ?>">
	<div class="form-group col-lg-12" sty >
		<div class="col-lg-4"></div>
		<div class="col-lg-4" style="text-align: center;">
		<!-- <button class="btn btn-default clrFrom" type="button"><B> CLEAR </B></button> -->
		<!-- <button type="submit" data-id="<?= $product_id ?>" class="btn btn-md  btn-primary btnSub btnFrmFPDsub1"><B> SAVE DATA </B></button> -->
		<!-- <button class="btn btn-primary" type="submit" ><B> SAVE DATA </B></button> -->
		<button class="btn btn-primary btnSaveComp" data-id="<?= $product_id ?>" type="submit" ><B> SAVE DATA </B></button>
		</div>
	</div>
	</form>
</div>



<script type="text/javascript" src="<?= base_url('assets/js/customFPD.js') ?>"></script>
