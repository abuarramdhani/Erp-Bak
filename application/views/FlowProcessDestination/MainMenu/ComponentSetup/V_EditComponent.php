<!-- <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datepicker/css/datepicker.css');?>" /> -->
<style type="text/css">
	.btnDelFileFPD:hover{
	cursor: pointer;
}
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<form method="post" action="<?= base_url('FlowProcess/ComponentSetup/saveEditComponent') ?>" enctype="multipart/form-data">
<div class="col-lg-12 " style=" margin-top: 20px">
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Old Drawing Unit :</label>
		</div>
		<div class="col-lg-3 tempFileOld">
		    <?php if ($component[0]['gambar_kerja']) { ?>
		    	<a class="linkOldFPD" target="_blank" href="<?= base_url('assets/upload_flow_process/component/gambar_unit/'.$component[0]['gambar_kerja']) ?>"> <b class="nameOldFileFPD">( <?= $component[0]['gambar_kerja'] ?> )</b></a>
		    <?php }else{ ?>
		    		<b>File not Found</b>
		    <?php } ?>
		</div>
		<div class="col-lg-3 tempBtnOld" data-type="2" data-mode="1">
			 <?php if ($component[0]['gambar_kerja']) { ?>
		    	<b class="text-danger btnDelFileFPD" data-nm="<?= $component[0]['gambar_kerja'] ?>" data-id="<?= $component_id ?>" data-type="2" data-mode="1" > Delete </b>
		    <?php }?>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Unit :</label>
		</div>
		<div class="col-lg-6">
		    <input type="file" class="" id="" placeholder="Changing Ref Document.. " name="fileGambarUnit">
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Code :</label>
		</div>
		<div class="col-lg-6">
		<select placeholder="Input Drawing Code.." id="selectDrawingCode" type="text" name="txtDrawingCode" class="form-control selectDrawingCode" required>
				<option value="<?= $component[0]['drw_code'] ?>" disabled selected><?= $component[0]['drw_code'] ?></option>
			</select>
			<input type="hidden" name="txtDrawingCode2" value="<?= $component[0]['drw_code'] ?>">
		    <!-- <input placeholder="Input Drawing Code.." type="text" name="txtDrawingCode" class="form-control " value="<?= $component[0]['drw_code'] ?>"> -->
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Status :</label>
		</div>
		<div class="col-lg-6">
		     <input type="radio" value="1" id="" name="slcDrawingStatus" <?= $component[0]['drw_status'] == '1' ? 'checked="checked"' : '' ?>>
			<label for="status1" class="label-checkbox" >Mass Production</label>
		    <input type="radio" value="2" id="" name="slcDrawingStatus"  <?= $component[0]['drw_status'] == '2' ? 'checked="checked"' : '' ?>>
			<label for="status2" class="label-checkbox" >Prototype</label>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Upper Level Code :</label>
		</div>
		<div class="col-lg-6">
		    <input type="text" class="form-control" id="" placeholder="Drawing Upper Level Code.. " name="txtUpperLevelCode" value="<?= $component[0]['drw_upper_level_code'] ?>">
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Upper Level Description :</label>
		</div>
		<div class="col-lg-6">
		    <input type="text" class="form-control" id="" placeholder="Drawing Upper Level Desc.. " name="txtUpperLevelDesc" value="<?= $component[0]['drw_upper_level_desc'] ?>">
		</div>
	</div>
	<div class="form-group col-lg-12 old-code" <?= $component[0]['component_status'] == '1' ? 'style="display:none"' :'' ?>>
		<div class="col-lg-4 hh">
		    <label >Changing Due Date :</label>
		</div>
		<div class="col-lg-6">
		    <input type="text" class="dtPicker form-control" style="width: 25%" id="" name="dateChangingDueDate" value="<?= ($component[0]['changing_due_date']) ? date('m/d/Y', strtotime($component[0]['changing_due_date'])) : '' ?>">
		</div>
	</div>
	<div class="form-group col-lg-12" >
		<div class="col-lg-4 hh">
		    <label >Component Qty Per Unit :</label>
		</div>
		<div class="col-lg-6">
		    <input type="number" class="form-control" id="component_qty_per_unit" style="width: 25%"  placeholder="Qty Per Unit.. " name="qtyComponent" value="<?= $component[0]['component_qty_per_unit'] ?>">
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label>Process Sheet Document:</label>
		</div>
		<div class="col-lg-6">
		<?php if ($component[0]['dokumen']) { ?>
		    	<a class="linkOldFPD" target="_blank" href="<?= base_url('assets/upload_flow_process/component/dokumen/'.$component[0]['dokumen']) ?>"> <b class="nameOldFileFPD">( <?= $component[0]['dokumen'] ?> )</b></a>
				<input type="hidden" name="fileDocument2" value="<?php echo $component[0]['dokumen'] ?>">
				<input type="file" class="" id="" placeholder="Process Sheet Document.. " name="fileDocument">
			<?php }else{ ?>
				<input type="file" class="" id="" placeholder="Process Sheet Document.. " name="fileDocument" required>
		<?php } ?>
		
		</div>
	</div>
	<!-- <div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label>Process Sheet Document:</label>
		</div>
		<div class="col-lg-6">
		<?php if ($component[0]['process_sheet_doc']) { ?>
		    	<a class="linkOldFPD" target="_blank" href="<?= base_url('assets/upload_flow_process/operation/process_sheet/'.$component[0]['process_sheet_doc']) ?>"> <b class="nameOldFileFPD">( <?= $component[0]['process_sheet_doc'] ?> )</b></a>
				<input type="hidden" name="fileProcessSheet2" value="<?php echo $component[0]['process_sheet_doc'] ?>">
				<input type="file" class="" id="" placeholder="Process Sheet Document.. " name="fileProcessSheet">
			<?php }else{ ?>
				<input type="file" class="" id="" placeholder="Process Sheet Document.. " name="fileProcessSheet" required>
		<?php } ?>
		
		</div>
	</div> -->
	<!-- <div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label>QCPC Document:</label>
		</div>
		<div class="col-lg-6">
		<?php if ($component[0]['qcpc_doc']) { ?>
		    	<a class="linkOldFPD" target="_blank" href="<?= base_url('assets/upload_flow_process/operation/qcpc/'.$component[0]['qcpc_doc']) ?>"> <b class="nameOldFileFPD">( <?= $component[0]['qcpc_doc'] ?> )</b></a>
				<input type="hidden" name="fileQCPC" value="<?php echo $component[0]['qcpc_doc'] ?>">
				<input type="file" class="" id="" placeholder="QCPC Document.. " name="fileQCPC">
			<?php }else{ ?>
				<input type="file" class="" id="" placeholder="QCPC Document.. " name="fileQCPC" required>
		<?php } ?>
		
		</div>
	</div> -->
	<!-- <div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label>CBO Document:</label>
		</div>
		<div class="col-lg-6">
		<?php if ($component[0]['qcpc_doc']) { ?>
		    	<a class="linkOldFPD" target="_blank" href="<?= base_url('assets/upload_flow_process/operation/cbo/'.$component[0]['cbo_doc']) ?>"> <b class="nameOldFileFPD">( <?= $component[0]['cbo_doc'] ?> )</b></a>
				<input type="hidden" name="filCBO" value="<?php echo $component[0]['cbo_doc'] ?>">
				<input type="file" class="" id="" placeholder="CBO Document.. " name="filCBO">
			<?php }else{ ?>
				<input type="file" class="" id="" placeholder="CBO Document.. " name="filCBO" required>
		<?php } ?>
		</div>
	</div> -->
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Group :</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Drawing Group.." id="drw_group" type="text" name="txtDrawingGroup" class="form-control " value="<?= $component[0]['drw_group'] ?>">
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Description :</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Drawing Description.." id="drw_description" type="text" name="txtDrawingDesc" class="form-control " value="<?= $component[0]['drw_description'] ?>">
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Revision :</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Revision.." id="rev" type="text" name="txtRev" class="form-control " value="<?= $component[0]['rev'] ?>">
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Date :</label>
		</div>
		<div class="col-lg-6">
		    <input type="text" class="dtPicker form-control" style="width: 25%" id="drw_date" value="<?= ($component[0]['drw_date']) ? date('m/d/Y', strtotime($component[0]['drw_date'])) : '' ?>"
		    name="dateDrawingDate"> 
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Material :</label>
		</div>
		<div class="col-lg-6">
		    <input type="text" class="form-control" id="drw_material" placeholder="Drawing Material.. " name="txtDrawingMaterial" value="<?= $component[0]['drw_material'] ?>">
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Weight :</label>
		</div>
		<div class="col-lg-6">
		    <input type="text" class="form-control" id="weight" placeholder="Weight.. " name="txtWeight" value="<?= $component[0]['weight'] ?>">
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Component Status  :</label>
		</div>
		<div class="col-lg-6">
		    <input type="radio" value="Y" id="statuscomp1" name="slcStatusComponent" <?= ($component[0]['component_status'] == 'Y') ? 'checked="checked"' : '' ?>>
			<label for="status1" class="label-checkbox" >Active</label>
		    <input type="radio" value="N" id="statuscomp2" name="slcStatusComponent" <?= ($component[0]['component_status'] == 'N') ? 'checked="checked"' : '' ?>>
			<label for="status2" class="label-checkbox" >Inactive</label>
		</div>
	</div>
	<div class="form-group col-lg-12 old-code" <?= $component[0]['component_status'] == '1' ? 'style="display:none"' :'' ?>>
		<div class="col-lg-4 hh">
		    <label >Changing Ref Document :</label>
		</div>
		<div class="col-lg-6">
		    <input type="text" class="form-control" id="changing_ref_doc" placeholder="Changing Ref Document.. " value="<?= $component[0]['changing_ref_doc'] ?>" name="fileChangingRefDoc">
		</div>
	</div>
	<!-- <div class="form-group col-lg-12 old-code" <?= $component[0]['component_status'] == '1' ? 'style="display:none"' :'' ?>>
		<div class="col-lg-4 hh">
		    <label >Old Changing Ref Document :</label>
		</div>
		<div class="col-lg-3 tempFileOld">
		    <?php if ($component[0]['changing_ref_doc']) { ?>
		    	<a class="linkOldFPD" target="_blank" href="<?= base_url('assets/upload_flow_process/component/changing_ref/'.$component[0]['changing_ref_doc']) ?>"> <b class="nameOldFileFPD">( <?= $component[0]['changing_ref_doc'] ?> )</b></a>
		    <?php }else{ ?>
		    		<b>File not Found</b>
		    <?php } ?>
		</div>
		<div class="col-lg-3 tempBtnOld" data-type="1" data-mode="1">
			 <?php if ($component[0]['changing_ref_doc']) { ?>
		    	<b class="text-danger btnDelFileFPD" data-nm="<?= $component[0]['changing_ref_doc'] ?>" data-id="<?= $component_id ?>" data-type="1" data-mode="1"> Delete </b>
		    <?php }?>
		</div>
	</div> -->
	<!-- <div class="form-group col-lg-12 old-code" <?= $component[0]['component_status'] == '1' ? 'style="display:none"' :'' ?>>
		<div class="col-lg-4 hh">
		    <label >New Changing Ref Document :</label>
		</div>
		<div class="col-lg-6">
		    <input type="file" class="" id="" placeholder="Changing Ref Document.. " name="fileChangingRefDoc">
		</div>
	</div> -->
	<div class="form-group col-lg-12 old-code" <?= $component[0]['component_status'] == '1' ? 'style="display:none"' :'' ?>>
		<div class="col-lg-4 hh">
		    <label >Changing Explanation :</label>
		</div>
		<div class="col-lg-6">
		    <input type="text" class="form-control" id="changing_ref_expl" placeholder="Changing Explanation.. " name="txtChangingExpl" value="<?= $component[0]['changing_ref_expl'] ?>">
		</div>
	</div>
	<!-- <div class="form-group col-lg-12 old-code" <?= $component[0]['component_status'] == '1' ? 'style="display:none"' :'' ?>> -->
	<div class="form-group col-lg-12 old-code" <?= $component[0]['component_status'] == '1' ?  :'' ?>>
		<div class="col-lg-4 hh">
		    <label >Old Drawing Code :</label>
		</div>
		<div class="col-lg-6">
		    <input type="text" class="form-control" id="old_drw_code" placeholder="Old Drawing Code.. " name="txtOldDrawingCode" value="<?= $component[0]['drw_code'] ?>">
		</div>
	</div>
	<input type="hidden" name="productId" id="productId" value="<?= $product_id ?>">
	<input type="hidden" name="componentId" id="componentId" value="<?= $component_id ?>">
	<div class="form-group col-lg-12" sty >
		<div class="col-lg-4"></div>
		<div class="col-lg-4" style="text-align: center;">
		<!-- <button class="btn btn-default clrFrom" type="button"><B> CLEAR </B></button> -->
		<button class="btn btn-success " type="submit" ><B> UPDATE DATA </B></button>
		</div>
	</div>
	</form>
</div>



<script type="text/javascript" src="<?= base_url('assets/js/customFPD.js') ?>"></script>
