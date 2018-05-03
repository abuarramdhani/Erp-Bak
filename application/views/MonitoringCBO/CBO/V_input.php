<section class="content">
	<div class="inner"  style="padding-top: 50px">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3><b><center>INPUT CBO</center></b></h3>
				<h5 style="text-align:right"><b>NO CBO :<span id="no_cbo"></span></b></h3>
				<input type="hidden" id="inp_cbo" name="no_cbo">
			</div>

			<div class="box-body">
				<div class="row">
					<div class="col-md-4">
							<label>TANGGAL</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
						<input id="tgl_cbo" type="text" name="textDate" class="form-control datepicker_mc" required>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
							<label>SHIFT</label>
					</div>
					<div class="col-md-8">
					<div class="form-group">
						<select id="shift_cbo" class="form-control" name="slcshift">
							<option></option>
							<?php foreach ($shift as $shift) {?>
							<option><?php echo $shift['shift_code']; ?></option>
							<?php }; ?>
						</select>
						</div>
					</div>
				</div>
					<div class="row">
					<div class="col-md-4">
							<label>LINE</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
						<select id="line_cbo" class="form-control" name="slcline">
							<option></option>
							<?php foreach ($line as $line) {?>
							<option><?php echo $line['line_code']; ?></option>
							<?php }; ?>
						</select>
						</div>
					</div>	
				</div>
				<div class="row">
					<div class="col-md-4">
							<label>KOMPONEN</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
						<select id="komp_cbo" class="form-control select2" name="slckomponen">
							<option></option>
							<?php foreach ($komponen as $komponen) {?>
							<option><?php echo $komponen['DESCRIPTION']; ?></option>
							<?php }; ?>
						</select>
						</div>
					</div>
				</div>
			<div style="float:right">
				<button class="btn btn-success" id="save_cbo">ACCEPT</button>
			</div>
			</div>
			<div id="table_cbo" class="table-responsive" style="display:none;over-flow:y">
			<table class="table table-bordered table-striped header-fixed" id="table-detail">
			<thead class="bg-primary" style="display:block;width:100%;text-align:center">
				<tr>
					<td rowspan="3" style="width:100px;vertical-align:middle">Type</td>
					<td rowspan="3" colspan="2" style="width:200px;vertical-align:middle">Hasil Cat</td>
					<td colspan="4" style="width:400px">Hasil CBO</td>
					<td colspan="18" style="width:1800px">Repair Proses</td>
					<td colspan="18" style="width:1800px">Repair Material</td>
					<td rowspan="3" colspan="2" style="width:200px;vertical-align:middle">Lain-lain</td>
				</tr>
				<tr>
					<td rowspan="2" colspan="2" style="width:200px;vertical-align:middle">OK</td>
					<td rowspan="2" colspan="2" style="width:200px;vertical-align:middle">Reject</td>
					<td colspan="6" style="width:600px">Belang</td>
					<td colspan="6" style="width:600px">Dlewer</td>
					<td colspan="6" style="width:600px">Kasar Cat</td>
					<td colspan="6" style="width:600px">Kropos</td>
					<td colspan="6" style="width:600px">Kasar Spat</td>
					<td colspan="6" style="width:600px">Kasar Mat</td>
				</tr>
				<tr>
					<td colspan="2" style="width:200px">A</td>
					<td colspan="2" style="width:200px">B</td>
					<td colspan="2" style="width:200px">C</td>
					<td colspan="2" style="width:200px">A</td>
					<td colspan="2" style="width:200px">B</td>
					<td colspan="2" style="width:200px">C</td>
					<td colspan="2" style="width:200px">A</td>
					<td colspan="2" style="width:200px">B</td>
					<td colspan="2" style="width:200px">C</td>
					<td colspan="2" style="width:200px">A</td>
					<td colspan="2" style="width:200px">B</td>
					<td colspan="2" style="width:200px">C</td>
					<td colspan="2" style="width:200px">A</td>
					<td colspan="2" style="width:200px">B</td>
					<td colspan="2" style="width:200px">C</td>
					<td colspan="2" style="width:200px">A</td>
					<td colspan="2" style="width:200px">B</td>
					<td colspan="2" style="width:200px">C</td>
				</tr>
				</thead>
				<tbody style="display:block;height:400px;overflow-y:auto;padding-left:13px">

				</tbody>
			</table>
			</div>
			<div class="box box-info"></div>
		</div>
	</div>
</section>