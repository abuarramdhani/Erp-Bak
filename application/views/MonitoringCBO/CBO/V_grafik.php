<section class="content">
	<div class="inner"  style="padding-top: 50px">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3><b><center>GRAFIK CBO</center></b></h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-inline" style="padding:15px">
					<div class="form-group">
						<label>Tanggal awal :</label>
						<input class="form-control datepicker_mc" id="tanggal_awal" type="text" name="tanggalanawal"/>	
					</div>
					<div class="form-group" style="padding-left:50px">
						<label>Tanggal Akhir :</label>
						<input class="form-control datepicker_mc" id="tanggal_akhir" type="text" name="tanggalanakhir"/>	
					</div>
				</div>
				</div>
				<div class="row">
					<div class="col-md-4">
							<label>SHIFT</label>
					</div>
					<div class="col-md-8">
					<div class="form-group">
						<select id="shift_cbo" class="form-control" name="slc_shift">
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
						<select id="line_cbo" class="form-control" name="slc_line">
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
						<select id="komp_cbo" class="form-control select2" name="slc_komponen">
							<option></option>
							<?php foreach ($komponen as $komponen) {?>
							<option><?php echo $komponen['DESCRIPTION']; ?></option>
							<?php }; ?>
						</select>
						</div>
					</div>
				</div>
			<div style="float:right">
				<button class="btn btn-success" id="tampil_grafik" onclick="getCBOGrafik()">ACCEPT</button>
			</div>
			<div class="row">
                <div class="col-md-7">
			<canvas id="grafik_cbo" height="500"></canvas>
				</div>
			</div>
			</div>
		</div>
	</div>
</section>