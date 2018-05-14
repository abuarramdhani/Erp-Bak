<section class="content">
	<div class="inner"  style="padding-top: 50px">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3><b><center>REPORT CBO</center></b></h3>
			</div>
			<form method="POST" action="<?php echo base_url('CBOPainting/CBO/ReportExcel')?>">
			<div class="box-body">
				<div class="row">
					<div class="col-md-4">
							<label>TANGGAL</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
						<input id="tgl_report" type="text" name="textDate" class="form-control datepicker_mc" required>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
							<label>SHIFT</label>
					</div>
					<div class="col-md-8">
					<div class="form-group">
						<select id="shift_report" class="form-control" name="slcshift">
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
						<select id="line_report" class="form-control" name="slcline">
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
						<select id="komp_report" class="form-control select2" name="slckomponen">
							<option></option>
							<?php foreach ($komponen as $komponen) {?>
							<option><?php echo $komponen['DESCRIPTION']; ?></option>
							<?php }; ?>
						</select>
						</div>
					</div>
				</div>
			<div style="float:right">
				<a class="btn btn-success" id="report_cbo">ACCEPT</a>
				<button type="submit" class="btn btn-warning"><i class="fa fa-file"></i>EXPORT</button>
			</div>
			</div>
			</form>
			<div id="pdf-Area"></div>
			<div id="table_report_cbo" class="table-responsive" >
			<table style="text-align:center" id="table_report" class="table table-bordered table-striped">
			<thead class="bg-primary">
				<tr>
					<td style="vertical-align:middle" class="text-center" rowspan="3">
						Tipe
					</td>
					<td  style="vertical-align:middle" class="text-center" rowspan="3">
						Hasil Cat
					</td>
					<td  class="text-center" colspan="2">
						Hasil CBO
					</td>
					<td  class="text-center" colspan="9">
						Repair Proses
					</td>
					<td  class="text-center" colspan="9">
						Repair Material
					</td>
					<td style="vertical-align:middle" class="text-center" rowspan="3">
						Lain-lain
					</td>
				</tr>
				<tr>
					<td  style="vertical-align:middle" class="text-center" rowspan="2">
						OK
					</td>
					<td  style="vertical-align:middle" class="text-center" rowspan="2">
						Reject
					</td>
					<td  class="text-center" colspan="3">
						Belang
					</td>
					<td  class="text-center" colspan="3">
						Dlewer
					</td>
					<td  class="text-center" colspan="3">
						Kasar Cat
					</td>
					<td  class="text-center" colspan="3">
						Kropos
					</td>
					<td  class="text-center" colspan="3">
						Kasar Spat
					</td>
					<td  class="text-center" colspan="3">
						kasar Mat
					</td>
				</tr>
				<tr>
					<td>A</td>
					<td>B</td>
					<td>C</td>
					<td>A</td>
					<td>B</td>
					<td>C</td>
					<td>A</td>
					<td>B</td>
					<td>C</td>
					<td>A</td>
					<td>B</td>
					<td>C</td>
					<td>A</td>
					<td>B</td>
					<td>C</td>
					<td>A</td>
					<td>B</td>
					<td>C</td>
				</tr>
				</thead>
				<tbody style="height:500px;overflow-y:auto">
					
					
				</tbody>
			</table>
			</div>
			<div class="box box-info"></div>
		</div>
	</div>
</section>