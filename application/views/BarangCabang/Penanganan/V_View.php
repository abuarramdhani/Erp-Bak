<section class="content">
	<div class="inner">
		<div class="box box-info">
			<div class="box-header with-border">
				<h2><b><center>VIEW PENGAJUAN PENANGANAN BARANG CABANG BERMASALAH</center></b></h2>
			</div>
			<div class="box-body">
			<form method="post" action="<?php echo base_url('BranchItem/PenangananBarang/View/Data')?>">
				<div class="box-header bg-info">
					<div class="form-inline">
						<div class="form-group" style="padding-left: 10px">
							<label>Tanggal Awal :</label>
							<input class="form-control datepicker_bi" id="tanggalan1" type="textDate" placeholder="Pilih Tanggal Awal" name="tanggalan1" required />	
						</div>
						<div class="form-group" style="padding-left: 40px">
							<label>Tanggal Akhir :</label>
							<input class="form-control datepicker_bi" id="tanggalan2" type="textDate" placeholder="Pilih Tanggal Akhir" name="tanggalan2" required />	
						</div>
					</div>
				</div><p>
				<div class="row">
					<div class="col-md-4" style="padding-left: 20px">
							<label>Cabang</label>
					</div>
					<div class="col-md-8">
						<div class="form-group">
						<select class="form-control select4" data-placeholder="Pilih Cabang" id="cabang"  name="cabang" >
							<option></option>
								<?php foreach ($organisasi as $organisasi) {?>
							<option value="<?php echo $organisasi['LOCATION_CODE']; ?>">
								<?php echo $organisasi['LOCATION_CODE']; ?>
							</option>
							<?php }; ?>				
						</select>
						</div>
					</div>
				</div>
				<div style="float:right">
				<button type="submit" class="btn btn-success"><span style="padding-right: 5px" class="icon-search"></span>SEARCH</button>
			</div>
			</form>
			</div>
				<div class="box box-info">
		<div class="box-body">
			<table id="ta" class="table table-striped table-bordered table-responsive table-hover" >
				<thead style="background:#22aadd; color:#FFFFFF;">
					<th style="text-align:center">NO</th>
					<th style="text-align:center">NO FPPBB</th>
					<th style="text-align:center">TANGGAL</th>
					<th style="text-align:center">CABANG</th>
					<th style="text-align:center">PILIHAN</th>
				</thead>
				<tbody>
					<?php $i=1; foreach ($PenangananHeader as $ph) { ?>
					<tr row-id="">
						<td style="text-align:center"><?php echo $i++; ?></td>
						<td style="text-align:center"><?php echo $ph['no_fppbb']; ?></td>
						<td style="text-align:center"><?php echo $ph['tanggal']; ?></td>
						<td style="text-align:center"><?php echo $ph['cabang']; ?></td>
						<td style="text-align:center" class="col-md-2">
							<div class="btn-group-justified" role="group">
								<a class="btn btn-info" href="<?php echo base_url(''); ?>BranchItem/PenangananBarang/View/<?php echo 'Detail/'.$ph['id'] ?>"><span class="icon-list-ul" style="padding-right: 5px"></span>DETAIL</a>
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