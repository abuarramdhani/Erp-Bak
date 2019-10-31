<!-- <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datepicker/css/datepicker.css');?>" /> -->
<form method="post" action="<?= base_url('FlowProcess/ComponentSetup/saveComponent') ?>" enctype="multipart/form-data">
<div class="col-lg-12 " style=" margin-top: 20px">
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Group:</label>
		</div>
		<div class="col-lg-6">
		    <input autocomplete="off" placeholder="Input Drawing Group.." type="text" id="drw_group" name="drw_group" class="form-control">
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    
		</div>
		<!-- <div class="col-lg-6">
		    <a id="btn-searchKomponen2" class="btn-searchKomponen2 btn btn-default"><b>Search</b></a>
		</div> -->
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Code:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Drawing Code.." id="drw_code" type="text" name="txtDrawingCode" class="form-control">
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Description:</label>
		</div>
		<div class="col-lg-6">
		    <input placeholder="Input Drawing Description.." id="drw_description" type="text" name="txtDrawingDesc" class="form-control">
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Date:</label>
		</div>
		<div class="col-lg-6">
		    <input type="text" class="dtPicker form-control" id="drw_date" style="width: 25%" id="" name="dateDrawingDate">
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Material:</label>
		</div>
		<div class="col-lg-6">
		    <input type="text" class="form-control" id="drw_material" placeholder="Drawing Material.. " name="txtDrawingMaterial">
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
		    <input type="text" class="form-control" id="drw_upper_level_code" placeholder="Drawing Upper Level Code.. " name="txtUpperLevelCode">
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Drawing Upper Level Description:</label>
		</div>
		<div class="col-lg-6">
		    <input type="text" class="form-control" id="drw_upper_level_desc" placeholder="Drawing Upper Level Desc.. " name="txtUpperLevelDesc">
		</div>
	</div>
	<div class="form-group col-lg-12">
		<div class="col-lg-4 hh">
		    <label >Component Status:</label>
		</div>
		<div class="col-lg-6">
		    <input type="radio" value="1" id="statuscomp1" name="slcStatusComponent">
			<label for="status1" class="label-radio" >Baru</label>
		    <input type="radio" value="2" id="statuscomp2" name="slcStatusComponent">
			<label for="status2" class="label-radio" >Menggantikan</label>
		</div>
	</div>
	<div class="form-group col-lg-12 old-code" style="display: none">
		<div class="col-lg-4 hh">
		    <label >Old Drawing Code </label>
		</div>
		<div class="col-lg-6">
		    <input type="text" class="form-control" id="old_drw_code" placeholder="Old Drawing Code.. " name="txtOldDrawingCode">
		</div>
	</div>
	<div class="form-group col-lg-12 old-code" style="display: none">
		<div class="col-lg-4 hh">
		    <label >Changing Ref Document </label>
		</div>
		<div class="col-lg-6">
		    <input type="file" class="" id="changing_ref_doc" placeholder="Changing Ref Document.. " name="fileChangingRefDoc">
		</div>
	</div>
	<div class="form-group col-lg-12 old-code" style="display: none">
		<div class="col-lg-4 hh">
		    <label >Changing Explanation </label>
		</div>
		<div class="col-lg-6">
		    <input type="text" class="form-control" id="changing_ref_expl" placeholder="Changing Explanation.. " name="txtChangingExpl">
		</div>
	</div>
	<div class="form-group col-lg-12 old-code" style="display: none">
		<div class="col-lg-4 hh">
		    <label >Changing Due Date:</label>
		</div>
		<div class="col-lg-6">
		    <input type="text" class="dtPicker form-control" style="width: 25%" id="changing_due_date" name="dateChangingDueDate">
		</div>
	</div>
	<div class="form-group col-lg-12" >
		<div class="col-lg-4 hh">
		    <label >Component Qty Per Unit</label>
		</div>
		<div class="col-lg-6">
		    <input type="number" class="form-control" id="component_qty_per_unit" style="width: 25%"  placeholder="Qty Per Unit.. " name="qtyComponent" required>
		</div>
	</div>
	<div class="form-group col-lg-12" >
		<div class="col-lg-4 hh">
		    <label >Gambar Unit</label>
		</div>
		<div class="col-lg-6">
		    <input type="file" class="" id="" placeholder="Changing Ref Document.. " name="fileGambarUnit" required>
		</div>
	</div>
	<input type="hidden" name="productId" value="<?= $product_id ?>">
	<div class="form-group col-lg-12" sty >
		<div class="col-lg-4"></div>
		<div class="col-lg-4" style="text-align: center;">
		<button class="btn btn-default clrFrom" type="button"><B> CLEAR </B></button>
		<button class="btn btn-success " type="submit" ><B> SAVE DATA </B></button>
		</div>
	</div>
	</form>
</div>



<script type="text/javascript" src="<?= base_url('assets/js/customFPD.js') ?>"></script>
