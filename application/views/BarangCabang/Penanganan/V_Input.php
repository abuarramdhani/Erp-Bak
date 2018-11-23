<section class="content">
	<div class="inner box box-info" >
		<div class="row">
			<div class="col-md-12">
				<div class="text-center box-header with-border">
					<h2><b>INPUT PENGAJUAN PENANGANAN BARANG CABANG BERMASALAH</b></h2>
				</div>
			</div>
		</div>
		<div class="box-body">
			<form method="post" action="<?php echo base_url('BranchItem/PenangananBarang/Input/AddMasalah/flagging')?>">
			<div class="row">
				<div class="col-md-9">
							<h5 style="text-align:right"><b>NO FPPBB  : </b><span  id="no_fppbb"></span> <?= $regenPenanganan ?></b></h55>
							<input type="hidden" id="inp_fppbb" name= "no_fppbb" value="<?= $regenPenanganan ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-md-4" style="text-align: right;">
							<label>TANGGAL</label>
					</div>
					<div class="col-md-5">
						<?php if ($cek!=0) {
							$tglCek = $cek[0]['tanggal'];
						}else{
							$tglCek = '';
						} ?>
						<div class="form-group">
						<input id="tanggalBranch" type="text" name="textDate" class="form-control datepicker_bi" placeholder="Pilih Tanggal" value="<?php echo $tglCek; ?>" required>
						</div>
					</div>
				</div>
				<div class="row">
				
					<div class="col-md-4" style="text-align: right;">
							<label>CABANG</label>
					</div>
					<div class="col-md-5">
					<div class="form-group">
						<select class="form-control select4" data-placeholder="Pilih Cabang" id="cabang"  name="cabang" required>
							<?php if ($cek!=0) {
								echo "<option selected='selected'>".$cek[0]['cabang']."</option>";
							}else{
								echo "<option></option>";
							} ?>
							<?php foreach ($organisasi as $organisasi) {?>
							<option value="<?php echo $organisasi['LOCATION_CODE']; ?>">
								<?php echo $organisasi['LOCATION_CODE']; ?>
							</option>
							<?php }; ?>				
						</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-1" style="padding-left: 750px">
						<button class="btn btn-info btn-lg" type="submit">
						<i class="icon-plus icon-2x"></i>
						<span ><br></span>
						</a>
					</div>
				</div>
			</form>
			</div>
	<div class="box box-info">
		<div class="box-body">
			<table id="ta" class="table table-striped table-bordered table-responsive table-hover" >
				<thead style="background:#22aadd; color:#FFFFFF;">
					<th style="text-align:center">NO</th>
					<th style="text-align:center">NO FPPB</th>
					<th style="text-align:center">Kode Barang</th>
					<th style="text-align:center">Deskripsi</th>
					<th style="text-align:center">Jumlah</th>
					<th style="text-align:center">Kategori Masalah</th>
					<th style="text-align:center">Pilihan</th>
				</thead>
				<tbody>
					<?php $no = 1; foreach ($tampil as $tp) { ?>
					<tr row-id="<?php echo $tp['id'];?>">
						<td style="text-align:center;"><?php echo $no; ?></td>
						<td style="text-align:center;"><?php echo $tp['no_fppb']; ?></td>
						<td style="text-align:center;"><?php echo $tp['kode_barang']; ?></td>
						<td style="text-align:center;"><?php echo $tp['deskripsi']; ?></td>
						<td style="text-align:center;"><?php echo $tp['jumlah']; ?></td>
						<td style="text-align:center;"><?php echo $tp['kategori_masalah']; ?></td>
						<td style="text-align:center;" class="col-md-2">
							<div class="btn-group-justified" role="group">
								<a class="btn btn-warning" href="<?php echo base_url('BranchItem/PenangananBarang/Input'); ?><?php echo '/'.'edit/'.$tp['id'] ?>"><span class="icon-edit" style="padding-right: 3px"></span> EDIT</a>
								<a class="btn btn-danger hapus" onclick="DeletePemindahanLine('<?php echo $tp['id'];?>')"><span class="icon-trash" style="padding-right: 3px"></span> DELETE</a>
							</div>
						</td>
					</tr>
				<?php $no++;} ?>
				</tbody>
			</table>
			<div style="float:right">
				<button id="save_line_penanganan" type='submit' class="btn btn-success"><span class="icon-save" style="padding-right: 5px"></span>SAVE</button>
			</div>
		</div>
		<div class="box box-info"></div>
	</div>
	</div>
</section>