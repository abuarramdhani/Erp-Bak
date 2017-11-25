<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b>INVOICE PREPAYMENT</b></h1>
							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								LAPORAN PREPAYMENT CV. KHS<br>Branch : KHS Pusat (OU)
							</div>
							<div class="box-body">
								<form id="dummyForm_prp" action="#">
									<pre><label>PER TANGGAL : </label><input type="text" name="dateFrom" id="dateFrom" value="<?php echo date('m/d/Y'); ?>"><br><label>NO. INDUK   : </label><input type="text" name="siteSupp" id="siteSupp" placeholder="ALL" style="text-transform: uppercase;"></pre>
									<button type="submit" id="btnViewPrp" class="btn btn-info btn-sm">CARI DATA</button><br><br>
									<div id="loadingPrpData" style="text-align: center; width: 100%;"></div><br>
									<div id="viewPrpData"></div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	</div>
</section>


		