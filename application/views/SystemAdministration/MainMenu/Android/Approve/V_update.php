<section class="content">
	<div class="inner" >
			<div class="box box-header"  style="padding-left:20px">
				<h3 class="pull-left"><strong> Edit Entry </strong> - Android</h3>
			</div>
		</div>
		<div class="panel box-body" >
		<form method="post" action="<?php echo base_url('SystemAdministration/Android/ApproveAtasan/updateData/'.$android[0]['gadget_id']); ?>" autocomplete="off">
		<table class="table table-striped table-bordered table-responsive table-hover dataTable no-footer">
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
					<td><input type="text" name="noindukKaryawan" class="form-control" value="<?php echo $android[0]['info_2']; ?>" <?php echo $android[0]['validation'] != '0' ? 'disabled' : '' ?> ></input> </td>
				</tr>
				<tr>
					<td>Waktu Request</td>
					<td><input type="text" class="form-control" readonly value="<?php echo $android[0]['register_request_date']; ?>"></input> </td>
				</tr>
				<tr>
				<td><label for="erp-androedit" class="">Nama Karyawan</label></td>
				<td>
					<select class="form-control erp-androedit" name="andro-employee" id="erp-androedit" style="width: 100%" <?php echo $android[0]['validation'] != '0' ? 'disabled' : '' ?> >
						<option value="<?php echo $android[0]['info_1'];  ?>	"><?php echo $android[0]['info_1'];  ?></option>
					</select>
				</td>
				</tr>
				<tr>
					<td>keterangan</td>
					<td>
						<textarea class="form-control" name='andro-ket' readonly><?php echo $android[0]['reason'] ?></textarea>
					</td>
				</tr>
				</table>
				<div class="col-lg-12">
					<div class="col-lg-4 text-center">
						<a href="<?php echo base_url('SystemAdministration/Android/ApproveAtasan'); ?>" class="btn btn-default" >Back</a>
					</div>
					<?php if($android[0]['validation'] == '3'){ ?>
					<div class="col-lg-4 text-center">
						<input type="submit" name="txtSubmit" value="Remove" class="btn btn-danger">
					</div>
					<?php }elseif($android[0]['validation'] == '4'){ ?>
					<div class="col-lg-4 text-center">
						<input type="submit" name="txtSubmit" value="Approve" class="btn btn-primary">
					</div>
					<div class="col-lg-4 text-center">
						<input type="submit" name="txtSubmit" value="Reject" class="btn btn-danger">
					</div>
				<?php } ?>
				</div>
				</form>
		</div>
	</div>