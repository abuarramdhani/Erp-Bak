<section class="content">
	<div class="inner">
		<div class="box box-info">
			<div class="box-header with-border">
				<h2><b><center>VIEW PEMINDAHAN BARANG CABANG BERMASALAH</center></b></h2>
			</div>
			<div class="box-body">
			<form method="post" action="<?php echo base_url('BranchItem/PemindahanBarang/View/Data')?>">
				<div class="box-header bg-info">
					<div class="form-inline">
						<div class="form-group" style="padding-left: 10px">
							<label>Tanggal Awal :</label>
							<input class="form-control datepicker_bi" id="tanggalan1" name="tanggalan1" type="textDate" placeholder="Pilih Tanggal Awal" />	
						</div>
						<div class="form-group" style="padding-left: 40px">
							<label>Tanggal Akhir :</label>
							<input class="form-control datepicker_bi" id="tanggalan2" name="tanggalan2" type="textDate" placeholder="Pilih Tanggal Akhir" />
						</div>
					</div>
				</div><p>
				<div class="row">
					<div class="col-md-4" style="padding-left: 30px">
							<label>Organisasi</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
						<select class="form-control select2" name="organisasi" id="organisasi" data-placeholder="Pilih Organisasi">
							<option></option>
								<?php foreach ($organisasi as $organisasi) {?>
							<option value="<?php echo $organisasi['ORGANIZATION_CODE']; ?>">
								<?php echo $organisasi['ORGANIZATION_CODE']; ?>
							</option>
							<?php }; ?>
						</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4" style="padding-left: 30px">
						<label>Gudang Asal</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
							<input type="text" class="form-control" id="gudang_asal" name="gudang_asal" placeholder="Input Gudang Asal"/>
						</div>
				</div>
				</div>
				<div class="row">
					<div class="col-md-4" style="padding-left: 30px">
							<label>Gudang Tujuan</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
							<select class="form-control select2" name="gudang_tujuan" id="gudang_tujuan" data-placeholder="Pilih Gudang Tujuan">
								<option></option>
								<option value='FG-REJECT'>FG-REJECT</option>
							</select>
						</div>
					</div>
				</div>
				<div style="float:right">
				<button type ='submit' class="btn btn-success"><span class="icon-search" style="padding-right: 3px"></span>SEARCH</button>
			</div>
			</form>
			</div>
				<div class="box box-info">
		<div class="box-body">
			<table id="ta" class="table table-striped table-bordered table-responsive table-hover" >
				<thead style="background:#22aadd; color:#FFFFFF;">
					<th style="text-align:center">NO</th>
					<th style="text-align:center">NO FPBB</th>
					<th style="text-align:center">TANGGAL</th>
					<th style="text-align:center">ORGANISASI</th>
					<th style="text-align:center">GUDANG ASAL</th>
					<th style="text-align:center">GUDANG TUJUAN</th>
					<th style="text-align:center">PILIHAN</th>
				</thead>
				<tbody>
					<?php $i=1; foreach ($LoadViewPemindahan as $lv) { ?>
					<tr row-id="">
						<td style="text-align:center"><?php echo $i++ ?></td>
						<td style="text-align:center"><?php echo $lv['no_fppb']; ?></td>
						<td style="text-align:center"><?php echo $lv['tanggal']; ?></td>
						<td style="text-align:center"><?php echo $lv['organisasi']; ?></td>
						<td style="text-align:center"><?php echo $lv['gudang_asal']; ?></td>
						<td style="text-align:center"><?php echo $lv['gudang_tujuan']; ?></td>
						<td style="text-align:center" class="col-md-2">
							<div class="btn-group-justified" role="group">
								<a class="btn btn-info" href="<?php echo base_url(); ?>BranchItem/PemindahanBarang/View/<?php echo 'Detail/'.$lv['id'] ?>"><span class="icon-list-ul" style="padding-right: 3px"></span>DETAIL</a>
							</div>
						</td>
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