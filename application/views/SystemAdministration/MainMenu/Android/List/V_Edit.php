<section class="content">
	<div class="inner" >
			<div class="box box-header"  style="padding-left:20px">
				<h3 class="pull-left"><strong> Edit Entry </strong> - Android</h3>
			</div>
		</div>
		<div class="panel box-body" >
		<form method="post" action="<?php echo base_url('SystemAdministration/Android/updateData/'.$id); ?>" autocomplete="off">
		<table class="table table-striped table-bordered table-responsive table-hover dataTable no-footer">
		<input id="valValidasi" type="hidden" value="<?=$android[0]['validation']?>"></input>
				<tr>
					<td>Android ID</td>
					<td><input type="text" name="android_id" class="form-control" readonly value="<?php echo $android[0]['android_id']; ?>"></input> </td>
				</tr>
				<tr>
					<td>IMEI</td>
					<td><input type="text" name="imei" class="form-control" readonly value="<?php echo $android[0]['imei']; ?>"></input> </td>
				</tr>
				<tr>
					<td>Hardware Serial</td>
					<td><input type="text" name="hwserial" class="form-control" readonly value="<?php echo $android[0]['hardware_serial']; ?>"></input> </td>
				</tr>
				<tr>
					<td>GSF</td>
					<td><input type="text" name="gsf" class="form-control" readonly value="<?php echo $android[0]['gsf']; ?>"></input> </td>
				</tr>
				<tr>
					<td>Nama Karyawan</td>
					<td><input type="text" class="form-control" readonly value="<?php echo $android[0]['info_1']; ?>"></input> </td>
				</tr>
				<tr>
					<td>No Induk</td>
					<td><input type="text" name="noindukKaryawan" class="form-control" value="<?php echo $android[0]['info_2']; ?>"></input> </td>
				</tr>
				<tr>
					<td>Waktu Request</td>
					<td><input type="text" class="form-control" readonly value="<?php echo $android[0]['register_request_date']; ?>"></input> </td>
				</tr>
				<tr>
				<td><label for="erp-androedit" class="">Nama Karyawan</label></td>
				<td><select class="form-control erp-androedit" name="andro-employee" id="erp-androedit"><option value="<?php echo $android[0]['info_1'];  ?>	"><?php echo $android[0]['info_1'];  ?></option></select></td>
				</tr>

				<tr>
					<td>
						<label>Status</label>
					</td>
					<td>
						<select id="status" class="form-control" name="andro-status" style="width: 100%" required>
						<?php 
						$new="";$approve="";$reject="";

						if($android[0]['validation']==0){
							$new = "selected";
						}elseif ($android[0]['validation']==1) {
							$approve="selected";
						}else{
							$reject = "selected";
						}

						?>

						<option <?php echo $new; ?>  value="0">New Entry</option>
						<option <?php echo $approve; ?> value="1">Approve</option>
						<option <?php echo $reject; ?>  value="2">Reject</option>
						</select>
					</td>
				</tr>
				<!-- <tr> -->
					<!-- <td> -->
						
					<!-- </td> -->
					<!-- <td> -->
						<!-- <a href="<?php echo base_url('SystemAdministration/Android/akhirKontrak/'.$android[0]['info_1']); ?>">Klik</a> -->
					<!-- </td> -->
				<!-- </tr> -->


				<tr id="row_valid_until" style="display: none">
				<?php
					foreach ($akhirKontrak as $key => $valid) {
				?>
					<td>Valid Until (Default Akhir Kontrak)</td>
					<td>
						<div id="datepicker" class="input-group date" data-provide="datepicker">
						   <input type="text" id="input_valid_until" class="form-control" name="valid-until" value="<?php echo date('Y-m-d', strtotime($valid['akhkontrak'])); ?>">
						<!-- </div> -->

						    <div class="input-group-addon">
						        <span class="glyphicon glyphicon-th"></span>
						    </div>
					</td>
				<?php } ?>
				</tr>

				</table>
				<div class="col-md-2"><a href="<?php echo base_url('SystemAdministration/Android/back'); ?>" class="btn btn-default" >Back</a></div>
				<div class="col-md-2"><button type="submit" class="btn btn-primary">Submit</button></div>
				</form>
		</div>
	</div>
<script type="text/javascript">
	
$(document).ready(function(){
	$('#datepicker').datepicker({
		    format: 'yyyy/mm/dd'
		});

let valid = $('#valValidasi').val();
if(valid == 1){
	$("#row_valid_until").show();
}
	
    $('#status').on('change', function() {
    	var value = $('#status').val();
    	console.log(value)
      if ( value == 1)
      {
        $("#row_valid_until").show();
        $("#input_valid_until").attr('value','<?php echo date('Y/m/d', strtotime($valid['akhkontrak'])); ?>');

      }
      else
      {
        $("#row_valid_until").hide();
        $("#input_valid_until").attr('value','1000/01/01');
      }
    });
});
</script>