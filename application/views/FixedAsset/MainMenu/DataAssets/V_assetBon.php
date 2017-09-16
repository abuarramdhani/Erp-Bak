<section class="content">
	<div class="inner">
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Bon Assets</b></h1>
						
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('FixedAsset/DataAssets');?>">
                                <i class="fa fa-bookmark fa-2x"></i>
                                <span ><br /></span>
                            </a>
							
						</div>
					</div>
				</div>
			</div>
			<br />
		<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb text-right">
				<li class ="active"><?php echo date('d F Y') ?></a></li>
				<li class ="active"><span id="clockbox"><?php echo date('H:i:s') ?></span></li>
				<li class ="active">Data Assets</li>
			</ol>
		</div>
			<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						DATA ASSETS
					</div>
					
					<div class="box-body">
						<div id="tbdiv" class="table-responsive">
							<table class="table" id="tbReceipt" style="font-size: 12px; width: 200%;">
								<thead>
									<tr class="bg-primary">
										<th>No.</th>
										<th>Action</th>
										<th>ID.</th>
										<th>No. PP</th>
										<th>Kode Barang</th>
										<th>Nama barang</th>
										<th>Spesifikasi</th>
										<th>Negara Pembuat</th>
										<th>Quantity</th>
										<th>Tgl. Digunakan</th>
										<th>Info Lain</th>
										<th>Seksi Pemakai</th>
										<th>Kota</th>
										<th>Gedung</th>
										<th>Lantai</th>
										<th>Ruang</th>
										<th>KVA</th>
										<th>Plat</th>
									</tr>
								</thead>
								<tbody>
								<?php $num = 0;
								foreach ($assets as $asset) { 
									$num++;?>
									<tr class="data-row">
										<td><?php echo $num; ?></td>
										<td id="17"><button type="button" id="btnEdt" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-edit"></i></button></td>
										<td id="01"><?php echo $asset['id'] ?></td>
										<td id="02"><?php echo $asset['no_pp'] ?></td>
										<td id="03"><?php echo $asset['kode_barang'] ?></td>
										<td id="04"><?php echo $asset['nama_barang'] ?></td>
										<td id="05"><?php echo $asset['spesifikasi'] ?></td>
										<td id="06"><?php echo $asset['negara_pembuat'] ?></td>
										<td id="07"><?php echo $asset['quantity'] ?></td>
										<td id="08"><?php echo $asset['tgl_digunakan'] ?></td>
										<td id="09"><?php echo $asset['info_lain'] ?></td>
										<td id="10"><?php echo $asset['seksi_pemakai'] ?></td>
										<td id="11"><?php echo $asset['kota'] ?></td>
										<td id="12"><?php echo $asset['gedung'] ?></td>
										<td id="13"><?php echo $asset['lantai'] ?></td>
										<td id="14"><?php echo $asset['ruang'] ?></td>
										<td id="15"><?php echo $asset['kva'] ?></td>
										<td id="16"><?php echo $asset['plat'] ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
							<form method="post" action="<?php echo base_url('FixedAsset/DataAssets/addtag'); ?>" id="formEdit">
								<input type="hidden" name="asset_id" id="asset_id">
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