<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>
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
							<form method="post" action="<?php echo base_url('FixedAsset/BonAssets/search') ?>">
								<pre><label>No. PP : </label><input type="text" name="txtReceipt" placeholder="NOMOR PP">  <label>No. PO : </label><input type="text" name="txtPonum" placeholder="NOMOR PO">  <button type="submit" id="btnReceipt" class="btn btn-sm btn-info">Submit</button><br>Silahkan Masukan Salah Satu (No.PP / No.PO), Kemudian Klik Submit.</pre>
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