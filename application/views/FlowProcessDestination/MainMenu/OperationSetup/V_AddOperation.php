<style type="text/css">
	.slc-20{
		width: 20% !important;
	}
	.slc-50{
		width: 50% !important;
	}
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<!-- <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datepicker/css/datepicker.css');?>" /> -->
<!-- <script type="text/javascript" src="<?= base_url('assets/js/customFPD.js') ?>"></script> -->

<form id="formAddOperation" method="post" action="<?= base_url('FlowProcess/OperationSetup/saveOperation') ?>" enctype="multipart/form-data">
<form method="post" action="<?= base_url('FlowProcess/OperationSetup/saveOperation') ?>" enctype="multipart/form-data">
<div class="col-lg-12 " style=" margin-top: 20px">
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Operation Sequence Number:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Operation Seq Number.." type="number" name="txtSeqNumber" class="form-control slc-50" required>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Planning:</label>
		</div>
		<div class="col-lg-6">
		    <input type="radio" value="1" id="" name="slcPlanning">
			<label for="status1" class="label-checkbox" >Make</label>
		    <input type="radio" value="2" id="" name="slcPlanning">
			<label for="status2" class="label-checkbox" >Buy</label>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Operation Process:</label>
		</div>
		<div class="col-lg-6">
		    <select class="slc2" style="width: 100%" data-placeholder="Select Process.." name="slcOperationProcess" required>
		    	<option></option>
		    	<?php foreach ($process as $key => $value) { ?>
		    		<option value="<?= $value['operation_process_std_id'] ?>"> <?= $value['operation_process_std'].' - '.$value['operation_process_std_desc'] ?></option>
		    	<?php } ?>
		    </select>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Operation Process Detail:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Operation Detail.." type="text" name="txtProcessDetail" class="form-control "required>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Machine Minimal Requirement:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Machine Req.." type="text" name="txtMachineMinReq" class="form-control "required>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Planning Tool:</label>
		</div>
		<div class="col-lg-6">
		    <input type="radio" value="1" id="" name="slcPlanningTool">
			<label for="status1" class="label-checkbox" >Yes</label>
		    <input type="radio" value="2" id="" name="slcPlanningTool">
			<label for="status2" class="label-checkbox" >No</label>
		    <input type="radio" value="3" id="" name="slcPlanningTool">
			<label for="status3" class="label-checkbox" >Modify</label>
		</div>
	</div>
	<div class="form-group col-lg-12 frmtool" style="display: none">
		<div class="col-lg-4 hh">
		    <label >Tool:</label>
		</div>
		<div class="col-lg-6">
		    <input type="radio" value="1" id="" name="slcTool">
			<label for="status1" class="label-checkbox" >Existing</label>
		    <input type="radio" value="2" id="" name="slcTool">
			<label for="status2" class="label-checkbox" >New</label>
		</div>
	</div>
	<div class="form-group col-lg-12 frmtool2" style="display: none">
		<div class="col-lg-4 hh">
		   
		</div>
		<div class="col-lg-6">
		    <select style="width: 100%" data-placeholder="Search Tool by name or number order" class=" slc2 slcToolExist" name="slcToolExist">
		    	<option></option>
		    </select>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Planning Measurement Tool:</label>
		</div>
		<div class="col-lg-6">
		    <input type="radio" value="1" id="" name="slcPlannigMeasurementTool">
			<label for="status1" class="label-checkbox" >Yes</label>
		    <input type="radio" value="2" id="" name="slcPlannigMeasurementTool">
			<label for="status2" class="label-checkbox" >No</label>
		</div>
	</div>
	<div class="form-group col-lg-12 frmMeasurement" style="display: none">
		<div class="col-lg-4 hh">
		    <label >Measurement Tool:</label>
		</div>
		<div class="col-lg-6">
		    <select style="width: 100%" data-placeholder="Search Tool by name or number order" class=" slc2 slcToolExist" name="slcMeasurementTool">
		    	<option></option>
		    </select>
		</div>
	</div>
	<!-- <div class="form-group col-lg-12" >
		<div class="col-lg-4 hh">
		    <label >Process Sheet Document</label>
		</div>
		<div class="col-lg-6">
		    <input type="file" class="" id="" placeholder="Process Sheet Document.. " name="fileProcessSheet" required>
		</div>
	</div>
	<div class="form-group col-lg-12" >
		<div class="col-lg-4 hh">
		    <label >QCPC Document</label>
		</div>
		<div class="col-lg-6">
		    <input type="file" class="" id="" placeholder="QCPC Document.. " name="fileQCPC" required>
		</div>
	</div>
	<div class="form-group col-lg-12" >
		<div class="col-lg-4 hh">
		    <label >CBO Document</label>
		</div>
		<div class="col-lg-6">
		    <input type="file" class="" id="" placeholder="CBO Document.. " name="filCBO" required>
		</div>
	</div> -->
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Oracle Code:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Oracle Code.." type="text" name="txtOracleCode" class="form-control " required>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Oracle Description:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Oracle Description.." type="text" name="txtOracleDesc" class="form-control " required>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Upper Level Oracle Code:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Upper Level Oracle Code.." type="text" name="txtUpperLvlOracleCode" class="form-control " required>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Upper Level Oracle Description:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Upper Level Oracle Description.." type="text" name="txtUpperLvlOracleDesc" class="form-control " required>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Oracle Operation Sequence Number:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Oracle Operation Seq Number.." type="number" name="txtOracleSeqNumber" class="form-control slc-50" required>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Oracle Resource Type:</label>
		</div>
		<div class="col-lg-6">
		    <input type="radio" value="1" id="" name="slcOraResourceType">
			<label for="status1" class="label-checkbox" >Group</label>
		    <input type="radio" value="2" id="" name="slcOraResourceType">
			<label for="status2" class="label-checkbox" >LIne</label>
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >End Date Active:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="End Date Active.." type="text" name="txtDateACtive" class="form-control dtPicker">
		</div>
	</div>


	<input type="hidden" name="componentId" value="<?= $component_id ?>">
	<div class="form-group col-lg-12" sty >
		<div class="col-lg-4"></div>
		<div class="col-lg-4" style="text-align: center;">
			<button class="btn btn-default clrFrom" type="button"><B> CLEAR </B></button>
			<button class="btn btn-success" data-id="<?= $component_id?>" id="saveOperation" type="submit"><B> SAVE DATA </B></button>
			<!-- <button target=class="btn btn-success" type="submit"><B> SAVE DATA </B></button> -->
		</div>
	</div>
	</form>
</div>



<script type="text/javascript" src="<?= base_url('assets/js/customFPD.js') ?>"></script>
