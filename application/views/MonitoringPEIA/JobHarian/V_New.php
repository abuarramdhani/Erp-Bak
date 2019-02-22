<section class="content">
	<div class="inner"  style="padding-top: 50px">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3><b><center>ADD JOB HARIAN</center></b></h3>
				<p class="help-block" style="text-align:center;">
				Hint! : Input with complete data on each form , except for the data marked with an asterisk * , can be not filled.
				</p>
			</div>
			<div class="box-body">
			<form method="post" action="<?php echo base_url('ProductionEngineering/JobHarian/add')?>">
				<div class="row">
					<div class="col-md-4">
							<label>TANGGAL</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
						<input type="text" name="textDate" class="form-control datepicker_mp" placeholder="Pilih Tanggal" required>
						</div>
					</div>
				</div>
				<!-- <div class="row">
					<div class="col-md-4">
							<label>SEKSI</label>
					</div>
					<div class="col-md-8">
					<div class="form-group">
						<select class="form-control" name="slcseksi">
							<option></option>
							<?php foreach ($seksi as $sks) {?>
							<option><?php echo $sks['seksi']; ?></option>
							<?php }; ?>
						</select>
						</div>
					</div>
				</div> -->
				<div class="row">
					<div class="col-md-4">
							<label>NAMA</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
						<input type="text" name="textNama" class="form-control" placeholder="Isi Nama" required>
						</div>
					</div>
				</div>
				<!-- <div class="row">
					<div class="col-md-4">
							<label>TO DO</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
						<select class="form-control" name="slcorder">
							<option></option>
							<?php foreach ($order as $ord) {?>
							<option><?php echo $ord['order_']; ?></option>
							<?php }; ?>
						</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
							<label>JENIS ORDER</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
						<select class="form-control" name="slcjenis">
							<option></option>
							<?php foreach ($jenisOrder as $JO) {?>
							<option><?php echo $JO['jenis_order']; ?></option>
							<?php }; ?>
						</select>
						</div>
					</div>
				</div> -->
				<div class="row">
					<div class="col-md-4">
							<label>KETERANGAN</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
						<textarea name="textKeterangan" class="form-control" rows="10" cols="70" placeholder="Isi Keterangan" required></textarea> 
						</div>
					</div>
				</div>
				<div style="float:right">
				<a href="<?php echo base_url('ProductionEngineering/JobHarianPIEA')?>" class="btn btn-danger">BACK</a>
				<button type ='submit' class="btn btn-success">SAVE</button>
			</div>
			</form>
			</div>
			<div class="box box-info"></div>
		</div>
	</div>
</section>