<style type="text/css">
	
	.slc-20{
		width: 20% !important;
	}
	.slc-50{
		width: 50% !important;
	}
	.btnDelFileFPD:hover{
	cursor: pointer;
	}

</style>
<!-- <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datepicker/css/datepicker.css');?>" /> -->
<!-- <script type="text/javascript" src="<?= base_url('assets/js/customFPD.js') ?>"></script> -->

<form method="post" action="<?= base_url('FlowProcess/OperationSetup/saveEditOperation') ?>" enctype="multipart/form-data">
<div class="col-lg-12 " style=" margin-top: 20px">
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >End Date Active:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="End Date Active.." type="text" name="txtDateACtive" class="form-control dtPicker" 
		    value="<?= ($operation[0]['end_date_active']) ? date('d/m/Y', strtotime($operation[0]['end_date_active'])) : '' ?>">
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Operation Sequence Number:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Operation Seq Number.." type="number" name="txtSeqNumber" class="form-control slc-50" value="<?= $operation[0]['operation_seq_num'] ?>">
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Planning:</label>
		</div>
		<div class="col-lg-6">
		    <input type="radio" value="1" id="" <?= ($operation[0]['planning_make_buy']) ? (($operation[0]['planning_make_buy'] == '1') ? 'checked="checked"' : '') :'' ?> name="slcPlanning">
			<label for="status1" class="label-checkbox"  >Make</label>
		    <input type="radio" value="2" id="" <?= ($operation[0]['planning_make_buy']) ? (($operation[0]['planning_make_buy'] == '2') ? 'checked="checked"' : '') :'' ?> name="slcPlanning">
			<label for="status2" class="label-checkbox" >Buy</label>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Operation Process:</label>
		</div>
		<div class="col-lg-6">
		    <select class="slc2" style="width: 100%" data-placeholder="Select Process.." name="slcOperationProcess">
		    	<option></option>
		    	<?php foreach ($process as $key => $value) { ?>
		    		<option <?= $value['operation_process_std_id'] == $operation[0]['operation_process'] ? 'selected="selected"  ' : '' ?> value="<?= $value['operation_process_std_id'] ?>"> <?= $value['operation_process_std'].' - '.$value['operation_process_std_desc'] ?></option>
		    	<?php } ?>
		    </select>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Operation Process Detail:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Operation Detail.." type="text" name="txtProcessDetail" class="form-control "
		    value="<?= $operation[0]['operation_process_detail'] ?>">
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Machine Minimal Requirement:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Machine Req.." type="text" name="txtMachineMinReq" class="form-control "
		    value="<?= $operation[0]['machine_min_requirement'] ?>">
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Planning Tool:</label>
		</div>
		<div class="col-lg-6">
		    <input type="radio" value="1" id="" name="slcPlanningTool" <?= ($operation[0]['planning_tool']) ? (($operation[0]['planning_tool'] == '1') ? 'checked="checked"' : '') :'' ?>>
			<label for="status1" class="label-checkbox" >Yes</label>
		    <input type="radio" value="2" id="" name="slcPlanningTool" <?= ($operation[0]['planning_tool']) ? (($operation[0]['planning_tool'] == '2') ? 'checked="checked"' : '') :'' ?>>
			<label for="status2" class="label-checkbox" >No</label>
		    <input type="radio" value="3" id="" name="slcPlanningTool" <?= ($operation[0]['planning_tool']) ? (($operation[0]['planning_tool'] == '3') ? 'checked="checked"' : '') :'' ?>>
			<label for="status2" class="label-checkbox" >Modify</label>
		</div>
	</div>
	<div class="form-group col-lg-12 frmtool" <?= ($operation[0]['planning_tool']) ? (($operation[0]['planning_tool'] == '1') ? '' : 'style="display: none"') :'style="display: none"' ?> >
		<div class="col-lg-4 hh">
		    <label >Tool:</label>
		</div>
		<div class="col-lg-6">
		    <input type="radio" value="1" id="" name="slcTool" <?= ($operation[0]['tool_id']) ? (($operation[0]['tool'] == '1') ? 'checked="checked"' : '') :'' ?>>
			<label for="status1" class="label-checkbox" >Existing</label>
		    <input type="radio" value="2" id="" name="slcTool" <?= ($operation[0]['tool_id']) ? (($operation[0]['tool'] == '2') ? 'checked="checked"' : '') :'' ?>>
			<label for="status2" class="label-checkbox" >New</label>
		</div>
	</div>
	<div class="form-group col-lg-12 frmtool2" <?= ($operation[0]['tool']) ? (($operation[0]['tool'] == '1') ? '' : 'style="display: none"') :'style="display: none"' ?>>
		<div class="col-lg-4 hh">
		   
		</div>
		<div class="col-lg-6">
		    <select style="width: 100%" data-placeholder="Search Tool by name or number order" class=" slc2 slcToolExist" name="slcToolExist">
		    	<option></option>
		    	<?php if (isset($operation[0]['tool_nomor']) && ($operation[0]['tool_nomor'])) { ?>
		    		<option selected="selected" value="<?= $operation[0]['tool_nomor'] ?>"><?= $operation[0]['tool_name'] ?></option>
		    	<?php } ?>
		    </select>
		</div>
	</div>
	<div class="form-group col-lg-12 ">
		<div class="col-lg-4 hh">
		    <label >Planning Measurement Tool:</label>
		</div>
		<div class="col-lg-6">
		    <input type="radio" value="1" id="" name="slcPlannigMeasurementTool" <?= ($operation[0]['planning_measurement_tool']) ? (($operation[0]['planning_measurement_tool'] == '1') ? 'checked="checked"' : '') :'' ?>>
			<label for="status1" class="label-checkbox" >Yes</label>
		    <input type="radio" value="2" id="" name="slcPlannigMeasurementTool" <?= ($operation[0]['planning_measurement_tool']) ? (($operation[0]['planning_measurement_tool'] == '2') ? 'checked="checked"' : '') :'' ?>>
			<label for="status2" class="label-checkbox" >No</label>
		</div>
	</div>
	<div class="form-group col-lg-12 frmMeasurement" <?= $operation[0]['planning_measurement_tool'] == '1' ? '' : 'style="display: none"' ?>>
		<div class="col-lg-4 hh">
		    <label >Measurement Tool:</label>
		</div>
		<div class="col-lg-6">
		    <select style="width: 100%" data-placeholder="Search Tool by name or number order" class=" slc2 slcToolExist" name="slcMeasurementTool">
		    	<option></option>
		    	<?php if ($operation[0]['measurement_tool_id']) { ?>
		    		<option selected="selected" value="<?= $operation[0]['measurement_tool_id'] ?>"><?= $operation[0]['measurement_tool_name'] ?></option>
		    	<?php } ?>
		    </select>
		</div>
	</div>
	<!-- <div class="form-group col-lg-12" >
		<div class="col-lg-4 hh">
		    <label >Old Process Sheet Document</label>
		</div>
		<div class="col-lg-3 tempFileOld">
		    <?php if ($operation[0]['process_sheet_doc']) { ?>
		    	<a class="linkOldFPD" target="_blank" href="<?= base_url('assets/upload_flow_process/operation/process_sheet/'.$operation[0]['process_sheet_doc']) ?>"> <b class="nameOldFileFPD">( <?= $operation[0]['process_sheet_doc'] ?> )</b></a>
		    <?php }else{ ?>
		    		<b>File not Found</b>
		    <?php } ?>
		</div>
		<div class="col-lg-3 tempBtnOld" data-type="1" data-mode="2">
			 <?php if ($operation[0]['process_sheet_doc']) { ?>
		    	<b class="text-danger btnDelFileFPD" data-nm="<?= $operation[0]['process_sheet_doc'] ?>" data-id="<?= $operation_id ?>" data-type="1" data-mode="2"> Delete </b>
		    <?php }?>
		</div>
	</div>
	<div class="form-group col-lg-12" >
		<div class="col-lg-4 hh">
		    <label >New Process Sheet Document</label>
		</div>
		<div class="col-lg-6">
		    <input type="file" class="" id="" placeholder="Process Sheet Document.. " name="fileProcessSheet">
		</div>
	</div>
	<div class="form-group col-lg-12" >
		<div class="col-lg-4 hh">
		    <label >Old QCPC Document</label>
		</div>
		<div class="col-lg-3 tempFileOld">
		    <?php if ($operation[0]['qcpc_doc']) { ?>
		    	<a class="linkOldFPD" target="_blank" href="<?= base_url('assets/upload_flow_process/operation/qcpc/'.$operation[0]['qcpc_doc']) ?>"> <b class="nameOldFileFPD">( <?= $operation[0]['qcpc_doc'] ?> )</b></a>
		    <?php }else{ ?>
		    		<b>File not Found</b>
		    <?php } ?>
		</div>
		<div class="col-lg-3 tempBtnOld" data-type="2" data-mode="2">
			 <?php if ($operation[0]['qcpc_doc']) { ?>
		    	<b class="text-danger btnDelFileFPD" data-nm="<?= $operation[0]['qcpc_doc'] ?>" data-id="<?= $operation_id ?>" data-type="2" data-mode="2"> Delete </b>
		    <?php }?>
		</div>
	</div>
	<div class="form-group col-lg-12" >
		<div class="col-lg-4 hh">
		    <label >New QCPC Document</label>
		</div>
		<div class="col-lg-6">
		    <input type="file" class="" id="" placeholder="QCPC Document.. " name="fileQCPC">
		</div>
	</div>
	<div class="form-group col-lg-12" >
		<div class="col-lg-4 hh">
		    <label >Old CBO Document</label>
		</div>
		<div class="col-lg-3 tempFileOld">
		    <?php if ($operation[0]['cbo_doc']) { ?>
		    	<a class="linkOldFPD" target="_blank" href="<?= base_url('assets/upload_flow_process/operation/cbo/'.$operation[0]['cbo_doc']) ?>"> <b class="nameOldFileFPD">( <?= $operation[0]['cbo_doc'] ?> )</b></a>
		    <?php }else{ ?>
		    		<b>File not Found</b>
		    <?php } ?>
		</div>
		<div class="col-lg-3 tempBtnOld" data-type="3" data-mode="2">
			 <?php if ($operation[0]['cbo_doc']) { ?>
		    	<b class="text-danger btnDelFileFPD" data-nm="<?= $operation[0]['cbo_doc'] ?>" data-id="<?= $operation_id ?>" data-type="3" data-mode="2"> Delete </b>
		    <?php }?>
		</div>
	</div>
	<div class="form-group col-lg-12" >
		<div class="col-lg-4 hh">
		    <label >New CBO Document</label>
		</div>
		<div class="col-lg-6">
		    <input type="file" class="" id="" placeholder="CBO Document.. " name="filCBO">
		</div>
	</div> -->
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Oracle Code:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Oracle Code.." type="text" name="txtOracleCode" class="form-control "  value="<?= $operation[0]['oracle_code'] ?>">
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Oracle Description:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Oracle Description.." type="text" name="txtOracleDesc" class="form-control "  value="<?= $operation[0]['oracle_description'] ?>">
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Upper Level Oracle Code:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Upper Level Oracle Code.." type="text" name="txtUpperLvlOracleCode" class="form-control "  value="<?= $operation[0]['upper_lvl_oracle_code'] ?>">
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Upper Level Oracle Description:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Upper Level Oracle Description.." type="text" name="txtUpperLvlOracleDesc" class="form-control "  value="<?= $operation[0]['upper_lvl_oracle_desc'] ?>"> 
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Oracle Operation Sequence Number:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Oracle Operation Seq Number.." type="number" name="txtOracleSeqNumber" class="form-control slc-50"  value="<?= $operation[0]['oracle_operation_seq_num'] ?>" >
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Oracle Resource Type:</label>
		</div>
		<div class="col-lg-6">
		    <input type="radio" value="1" id="" name="slcOraResourceType" <?= ($operation[0]['oracle_resource_type']) ? (($operation[0]['oracle_resource_type'] == '1') ? 'checked="checked"' : '') :'' ?>>
			<label for="status1" class="label-checkbox" >Group</label>
		    <input type="radio" value="2" id="" name="slcOraResourceType" <?= ($operation[0]['oracle_resource_type']) ? (($operation[0]['oracle_resource_type'] == '2') ? 'checked="checked"' : '') :'' ?>>
			<label for="status2" class="label-checkbox" >LIne</label>
		</div>
	</div>


	<input type="hidden" name="operationId" value="<?= $operation_id ?>">
	<div class="form-group col-lg-12" sty >
		<div class="col-lg-4"></div>
		<div class="col-lg-4" style="text-align: center;">
			<button class="btn btn-default clrFrom" type="button"><B> CLEAR </B></button>
			<button class="btn btn-success " type="submit" ><B> UPDATE DATA </B></button>
		</div>
	</div>
	</form>
</div>



<script type="text/javascript" src="<?= base_url('assets/js/customFPD.js') ?>"></script>
