<div class="table-responsive" style="overflow:auto;">
    <table class="table table-striped table-bordered table-hover table-responsive" id="tbdataplan">
        <thead class="bg-primary">
            <tr class="text-center">
                <td>No</td>
                <td>Item</td>
                <td>Description</td>
                <td>Priority</td>
                <td>Due Time</td>
                <td>Section</td>
                <td>Need Qty</td>
                <td>Achieve Qty</td>
                <td>Status</td>
            </tr>
        </thead>
        <tbody>
			<?php foreach ($data as $dt) { ?>
				<tr>
					<input type="hidden" name="daily_plan_id" value="<?php echo $dt['daily_plan_id']; ?>">
					<td><?php echo $no++; ?></td>
					<td><?php echo $dt['item_code']; ?></td>
					<td><?php echo $dt['item_description']; ?></td>
					<td>
						<select class="form-control select4" onchange="editDailyPlan(this)" name="priority" style="width: 70px">
							<option></option>
							<option value="1" <?php if ($dt['priority']=='1') {echo "selected";} ?>>1</option>
							<option value="NORMAL" <?php if ($dt['priority']=='NORMAL') {echo "selected";} ?>>N</option>
						</select>
					</td>
					<td>
						<input type="text" name="due_time" style="width: 170px" class="form-control time-form" value="<?php echo $dt['due_time']; ?>">
					</td>
					<td><?php echo $dt['section_name']; ?></td>
					<td>
						<input type="number" name="need_qty" style="width: 80px" onchange="editDailyPlan(this)" class="form-control" value="<?php echo $dt['need_qty']; ?>">
					</td>
					<td>
						<?php
							if ($dt['achieve_qty'] == null) {
				                echo "0";
				            }else{
				                echo $dt['achieve_qty'];
				            }
						?>
					</td>
					<td><?php echo $dt['status']; ?></td>
				</tr>
			<?php } ?>
		</tbody>
    </table>
</div>
<script type="text/javascript">
    $(".select4").select2({
        placeholder: "Choose Option",
        allowClear : true,
    });
    $('.time-form').daterangepicker({
        "singleDatePicker": true,
        "showDropdowns": true,
        "timePicker": true,
        "timePicker24Hour": true,
        "timePickerSeconds": true,
        "opens": "left",
        "drops": "down",
        locale: {
            format: 'YYYY/MM/DD HH:mm:ss',
            cancelLabel: 'Clear'
        },
         "autoUpdateInput": false
    });
    $('.time-form').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY/MM/DD HH:mm:ss'));
        editDailyPlan(this);
    });
    $('.time-form').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        editDailyPlan(this);
    });
</script>