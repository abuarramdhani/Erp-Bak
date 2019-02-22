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
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('FixedAsset/BonAssets');?>">
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
				<li class ="active">Bon Assets</li>
			</ol>
		</div>
			<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						CARI ASSETS
					</div>
					
					<div class="box-body">
						<div id="formdiv">
							<form  method="post" action="<?php echo base_url('FixedAsset/BonAssets/search') ?>">
								<pre><label>No. PP : </label><input type="text" name="txtReceipt" id="txtReceipt" placeholder="NOMOR PP">  <label>No. PO : </label><input type="text" name="txtPonum" id="txtPonum" placeholder="NOMOR PO">  <button type="submit" id="btnReceipt" class="btn btn-sm btn-info">Submit</button><br>Silahkan Masukan Salah Satu (No.PP / No.PO), Kemudian Klik Submit.</pre>
							</form>
						</div>
						<div id="tbdiv" class="table-responsive">
							<table class="table" id="tbReceipt" style="width: 100%; font-size: 12px;">
								<thead>
									<tr class="bg-primary">
										<th>No.</th>
										<th>Kode Barang</th>
										<th>Deskripsi barang</th>
										<th>No. PP</th>
										<th>No. PO</th>
										<th>No. Receipt</th>
										<th>Quantity</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php $num = 0;
								foreach ($assets as $ast) {
								$num++;?>
									<tr class="data-row">
										<td id="1"><?php echo $num ?></td>
										<td id="2"><?php echo $ast['KODE'] ?></td>
										<td id="3"><?php echo $ast['DESKRIPSI'] ?></td>
										<td id="4"><?php echo $ast['NO_PP'] ?></td>
										<td id="4"><?php echo $ast['NO_PO'] ?></td>
										<td id="5"><?php echo $ast['NO_RECEIPT'] ?></td>
										<td id="6"><?php echo $ast['QUANTITY'] ?></td>
										<td id="7"><button type="button" id="btnSbmt" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-edit"></i></button></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
							<form id="formInput" method="post" action="<?php echo base_url('FixedAsset/BonAssets/input') ?>">
								<input type="hidden" name="hdnKode" id="hdnKode">
								<input type="hidden" name="hdnDeskripsi" id="hdnDeskripsi">
								<input type="hidden" name="hdnPp" id="hdnPp">
								<input type="hidden" name="hdnQuantity" id="hdnQuantity">	
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