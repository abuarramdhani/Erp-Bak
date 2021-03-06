<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h2><b>Update Data Faktur Masukan</b></h2>
							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
					<div class="box box-primary box-solid">
						<div class="box-header with-border">
							<b>*) Perubahan akan diterapkan terhadap semua data yang ada dalam file berikut ini</b>
						</div>
						
						<div class="box-body">
							<div class="table-responsive" style="overflow:hidden;">
								<span class="label label-success"><?php echo $filename?></span>
								<table class="table table-striped table-bordered table-hover text-left" id="tabel-retur-faktur" style="font-size:14px;">
									<thead class="bg-primary">
										<tr>
											<!--<th>FM</th>-->
											<th><div style="width:120px;">KODE JENIS TRANS</div></th>
											<th><div style="width:100px;">FG PENGGANTI</div></th>
											<th><div style="width:120px">NOMOR FAKTUR</div></th>
											<th><div style="width:80px">BULAN PAJAK</div></th>
											<th><div style="width:90px">TAHUN PAJAK</div></th>
											<!--<th><div style="width:120px">TANGGAL FAKTUR</div></th>-->
											<!--<th><div style="width:100px">NPWP</div></th>-->
											<!--<th><div style="width:140px">NAMA</div></th>-->
											<!--<th><div style="width:600px">ALAMAT LENGKAP</div></th>-->
											<!--<th><div style="width:100px">JUMLAH DPP</div></th>-->
											<!--<th><div style="width:100px">JUMLAH PPN</div></th>-->
											<!--<th><div style="width:120px">JUMLAH PPNBM</div></th>-->
											<!--<th><div style="width:100px;">IS CREDITABLE</div></th>-->
											<!--<th><div style="width:90px;">KETERANGAN</div></th>-->
											<th><div style="width:100px;">STATUS FAKTUR</div></th>
										</tr>
									</thead>
									<tbody>
											<th>N/A</th>
											<th>N/A</th>
											<th>N/A</th>
											<th>N/A</th>
											<th>N/A</th>
											<th>N/A</th>
									</tbody>																			
								</table>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<div class="col-md-offset-8 col-md-2">
										<a href="<?php echo base_url('AccountPayables/Invoice/downloadfm')?>" class="btn btn-warning btn-block">Cancel</a>
									</div>
									<form method="post" action="<?php echo base_url('AccountPayables/Invoice/confirmfm')?>" enctype="multipart/form-data">
										<input type="hidden" name="TxtFileName" class="form-control" value="<?php echo $filename ?>" readonly>
										<div class="col-md-2">
											<button class="btn btn-success btn-block">Confirm</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					</div>
				</div>	
			</div>
		</div>
	</div>
</section>