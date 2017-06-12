<div class="row">
	<?php
		foreach ($search_result as $sr) {
	?>
	<div class="col-lg-6">
		<div class="row" style="margin: 10px 0">
			<div class="col-lg-4">
				<label class="control-label">IO</label>
			</div>
			<div class="col-lg-8">
				<input id="master_data_id" type="hidden" name="txt_master_data_id" class="form-control" value="<?php echo $sr['master_data_id'];?>">
				<input id="io_name" type="text" name="txt_new_io_name" class="form-control io_name" value="<?php echo $sr['io_name'];?>">
				<div class="io_name_list" style="position:absolute; width: 90%;"></div>
			</div>
		</div>
		<div class="row" style="margin: 10px 0">
			<div class="col-lg-4">
				<label class="control-label">Sub Inventory</label>
			</div>
			<div class="col-lg-8">
				<input id="sub_inventory" type="text" name="txt_new_sub_inventory" class="form-control sub_inventory" value="<?php echo $sr['sub_inventory'];?>">
				<div class="sub_inventory_list" style="position:absolute; width: 90%;"></div>
			</div>
		</div>
		<div class="row" style="margin: 10px 0">
			<div class="col-lg-4">
				<label class="control-label">Area</label>
			</div>
			<div class="col-lg-8">
				<input id="area" type="text" name="txt_new_area" class="form-control area" value="<?php echo $sr['area'];?>">
				<div class="area_list" style="position:absolute; width: 90%;"></div>
			</div>
		</div>
		<div class="row" style="margin: 10px 0">
			<div class="col-lg-4">
				<label class="control-label">Locator</label>
			</div>
			<div class="col-lg-8">
				<input id="locator" type="text" name="txt_new_locator" class="form-control locator" value="<?php echo $sr['locator'];?>">
				<div class="locator_list" style="position:absolute; width: 90%;"></div>
			</div>
		</div>
		<div class="row" style="margin: 10px 0">
			<div class="col-lg-4">
				<label class="control-label">Save Location</label>
			</div>
			<div class="col-lg-8">
				<input id="saving_place" type="text" name="txt_new_saving_place" class="form-control saving_place" value="<?php echo $sr['saving_place'];?>">
				<div class="saving_place_list" style="position:absolute; width: 90%;"></div>
			</div>
		</div>
		<div class="row" style="margin: 10px 0">
			<div class="col-lg-4">
				<label class="control-label">Cost Center</label>
			</div>
			<div class="col-lg-8">
				<input id="cost_center" type="text" name="txt_new_cost_center" class="form-control cost_center" value="<?php echo $sr['cost_center'];?>">
				<div class="cost_center_list" style="position:absolute; width: 90%;"></div>
			</div>
		</div>
		<div class="row" style="margin: 10px 0">
			<div class="col-lg-4">
				<label class="control-label">Sequence</label>
			</div>
			<div class="col-lg-8">
				<input id="seq" type="text" name="txt_new_seq" class="form-control seq" value="<?php echo $sr['seq'];?>" onkeypress="return isNumberKey(event)">
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="row" style="margin: 10px 0">
			<div class="col-lg-4">
				<label class="control-label">Component Code</label>
			</div>
			<div class="col-lg-8">
				<input id="component_code" type="text" name="txt_new_component_code" class="form-control" value="<?php echo $sr['component_code'];?>">
			</div>
		</div>
		<div class="row" style="margin: 10px 0">
			<div class="col-lg-4">
				<label class="control-label">Component Desc</label>
			</div>
			<div class="col-lg-8">
				<input id="component_desc" type="text" name="txt_new_component_desc" class="form-control" value="<?php echo $sr['component_desc'];?>">
			</div>
		</div>
		<div class="row" style="margin: 10px 0">
			<div class="col-lg-4">
				<label class="control-label">Type</label>
			</div>
			<div class="col-lg-8">
				<input id="type" type="text" name="txt_new_type" class="form-control type" value="<?php echo $sr['type'];?>">
				<div class="type_list" style="position:absolute; width: 90%;"></div>
			</div>
		</div>
		<div class="row" style="margin: 10px 0">
			<div class="col-lg-4">
				<label class="control-label">On Hand QTY</label>
			</div>
			<div class="col-lg-8">
				<input id="onhand_qty" type="text" name="txt_new_onhand_qty" class="form-control onhand_qty" value="<?php echo $sr['onhand_qty'];?>" onkeypress="return isNumberKey(event)">
			</div>
		</div>
		<div class="row" style="margin: 10px 0">
			<div class="col-lg-4">
				<label class="control-label">SO QTY</label>
			</div>
			<div class="col-lg-8">
				<input id="so_qty" type="text" name="txt_new_so_qty" class="form-control so_qty" value="<?php echo $sr['so_qty'];?>" onkeypress="return isNumberKey(event)">
			</div>
		</div>
		<div class="row" style="margin: 10px 0">
			<div class="col-lg-4">
				<label class="control-label">UOM</label>
			</div>
			<div class="col-lg-8">
				<input id="uom" type="text" name="txt_new_uom" class="form-control uom" value="<?php echo $sr['uom'];?>">
				<div class="uom_list" style="position:absolute; width: 90%;"></div>
			</div>
		</div>
	</div>
	<?php
		}
	?>
</div>