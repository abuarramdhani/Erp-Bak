<section class="content">
	<div class="inner">
		<div class="box box-info">
			<div class="box-header with-border">
				<h2><b><center>DETAIL PEMINDAHAN BARANG CABANG BERMASALAH</center></b></h2>
			</div>
			<div class="box-body">
			<center><form method="post" action="<?php echo base_url('')?>">
				<div class="row">
					<div class="col-md-2 col-md-offset-2" style="text-align: right;">
							<label>NO FPBB</label>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<span class="form-control" name="no_fppb" style="width: 400px" /><?php echo $DetailPemindahan[0]['no_fppb']; ?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 col-md-offset-2" style="text-align: right;">
							<label>Tanggal</label>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<span class="form-control" name="tanggal" style="width: 400px" /><?php echo $DetailPemindahan[0]['tanggal']; ?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 col-md-offset-2" style="text-align: right;">
							<label>Cabang</label>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<span class="form-control" name="cabang" style="width: 400px" /><?php echo $DetailPemindahan[0]['cabang']; ?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 col-md-offset-2" style="text-align: right;">
							<label>Organisasi</label>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<span class="form-control" name="organisasi" style="width: 400px" /><?php echo $DetailPemindahan[0]['organisasi']; ?>
						</div>
					</div>
				</div><div class="row">
					<div class="col-md-2 col-md-offset-2" style="text-align: right;">
							<label>Gudang Asal</label>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<span class="form-control" name="gudang_asal" style="width: 400px" /><?php echo $DetailPemindahan[0]['gudang_asal']; ?>
						</div>
					</div>
				</div><div class="row">
					<div class="col-md-2 col-md-offset-2" style="text-align: right;">
							<label>Gudang Tujuan</label>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<span class="form-control" name="gudang_tujuan" style="width: 400px" /><?php echo $DetailPemindahan[0]['gudang_tujuan']; ?>
						</div>
					</div>
				</div>
			</form></center>
			</div>
				<div class="box box-info">
		<div class="box-body">
			<table id="ta" class="table table-striped table-bordered table-responsive table-hover" >
				<thead style="background:#22aadd; color:#FFFFFF;">
					<th style="text-align:center">NO</th>
					<th style="text-align:center">KODE BARANG</th>
					<th style="text-align:center">DESKRIPSI</th>
					<th style="text-align:center">JUMLAH</th>
					<th style="text-align:center">KATEGORI MASALAH</th>
				</thead>
				<tbody>
					<?php $i=1; foreach ($DetailPemindahan as $det) { ?>
					<tr row-id="">
						<td style="text-align:center"><?php echo $i++ ?></td>
						<td style="text-align:center"><?php echo $det['kode_barang']; ?></td>
						<td style="text-align:center"><?php echo $det['deskripsi']; ?></td>
						<td style="text-align:center"><?php echo $det['jumlah']; ?></td>
						<td style="text-align:center"><?php echo $det['kategori_masalah']; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="box box-info"></div>
	</div>
		</div>
	</div>
</section>