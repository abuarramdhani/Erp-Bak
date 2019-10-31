<style type="text/css">
	.slc-20{
		width: 20% !important;
	}
	.slc-50{
		width: 50% !important;
	}
</style>
<!-- <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datepicker/css/datepicker.css');?>" /> -->
<!-- <script type="text/javascript" src="<?= base_url('assets/js/customFPD.js') ?>"></script> -->

<!-- <form method="post" action="<?= base_url('FlowProcess/Setup/OperationProcessStd/SaveNewOPS') ?>" enctype="multipart/form-data"> -->
<div class="col-lg-12 " style=" margin-top: 20px">
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Operation Std:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Operation Standard.." type="text" name="txtOprStd" class="form-control" >
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Operation Std Description:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Operation Standard Desc.." type="text" name="txtOprStdDesc" class="form-control" >
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Operation Std Group:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Operation Standard Group.." type="text" name="txtOprStdGroup" class="form-control" >
		</div>
	</div>

	<input type="hidden" name="componentId" value="">
	<div class="form-group col-lg-12" sty >
		<div class="col-lg-4"></div>
		<div class="col-lg-4" style="text-align: center;">
			<button class="btn btn-default clrFrom" type="button"><B> CLEAR </B></button>
			<button class="btn btn-success saveFormAdd" type="submit" ><B> SAVE DATA </B></button>
		</div>
	</div>
	<!-- </form> -->
</div>



<script type="text/javascript" src="<?= base_url('assets/js/customFPD.js') ?>"></script>
