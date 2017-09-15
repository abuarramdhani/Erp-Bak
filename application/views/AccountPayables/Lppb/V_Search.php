<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>
<section class="content">
	<div class="inner">
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>LPPB Belum Bayar</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('FixedAsset/BonAssets');?>">
                                <i class="fa fa-server fa-2x"></i>
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
				<li class ="active">LPPB Belum Bayar</li>
			</ol>
		</div>
			<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						SEARCH RESULT
					</div>
					
					<div class="box-body">
						<fieldset class="row2" style="background:#F8F8F8 ;">
								<div class="row">
									<div class="col-lg-12">
										<div class="panel-heading text-left">
											<!-- panel header -->
										</div>
										<div class="panel-body">
										<form id="formExport" action="<?php echo base_url('/AccountPayables/Lppb/export'); ?>" method="post">
											<div id="tbdiv" class="table-responsive">
											<?php $no = 0; ?>
												<table id="lppbList" class="table table-striped table-bordered table-hover" width="100%">
													<thead style="font-size: 12px">
														<tr class="bg-primary">
															<th>NO</th>
															<th>VENDOR NAME</th>
															<th>INVENTORY</th>
															<th>RECEIPT NO</th>
															<th>RECEIPT DATE</th>
															<th>PO NUMBER</th>
															<th>TERMS PO</th>
															<th>TERIMA</th>
															<th>TGL TERIMA</th>
														</tr>
													</thead>
													<tbody style="font-size: 12px">
													<?php foreach ($lppb as $lb) {
													$no++;?>
														<tr>
															<td><?php echo $no; ?></td>
															<td><?php echo $lb['VENDOR']; ?><input type="hidden" name="hdnVendor<?php echo $no; ?>" value="<?php echo $lb['VENDOR']; ?>"></td>
															<td><?php echo $lb['INVENTORY']; ?><input type="hidden" name="hdnInven<?php echo $no; ?>" value="<?php echo $lb['INVENTORY']; ?>"></td>
															<td><?php echo $lb['RECEIPT_NUM']; ?><input type="hidden" name="hdnReceiptn<?php echo $no; ?>" value="<?php echo $lb['RECEIPT_NUM']; ?>"></td>
															<td><?php echo $lb['RECEIPT_DATE']; ?><input type="hidden" name="hdnReceiptd<?php echo $no; ?>" value="<?php echo $lb['RECEIPT_DATE']; ?>"></td>
															<td><?php echo $lb['PO_NUM']; ?><input type="hidden" name="hdnPonum<?php echo $no; ?>" value="<?php echo $lb['PO_NUM']; ?>"></td>
															<td><?php echo $lb['TERMS_PO']; ?><input type="hidden" name="hdnTerm<?php echo $no; ?>" value="<?php echo $lb['TERMS_PO']; ?>"></td>
															<td>
																<input type="hidden" name="chkTerima<?php echo $no; ?>" value="TIDAK">
																<input type="checkbox" name="chkTerima<?php echo $no; ?>" value="YA" class="chkTerima" <?php if($lb['TERIMA']=="YA") echo 'checked="checked"'; ?>>
															</td>
															<td id="tgl<?= $no; ?>"><?php echo $lb['TGL_TERIMA']; ?><input type="hidden" name="hdnTerimadate<?php echo $no; ?>" class="hdnTerimadate" value="<?php echo $lb['TGL_TERIMA']; ?>"></td>
														</tr>
													<?php } ?>
													</tbody>
												</table>
												<input type="hidden" name="lastNum" value="<?php echo $no; ?>">
											</div>
										</div>
										<div class="panel-footer">
											<div style="width: 45%; float: left; text-align: left;">
												<input type="hidden" name="hdnTanggalrange" value="<?php echo $date ?>">
												<a href="<?php echo base_url('/AccountPayables/Lppb'); ?>">
													<button type="button" class="btn btn-primary btn-lg btn-rect">BACK</button>
												</a>
											</div>
											<div style="width: 45%; float: right; text-align: right;">
												<button type="submit" id="btnExportlppb" class="btn btn-primary btn-lg btn-rect">EXPORT</button>
												<button type="button" id="btnSavelppb" class="btn btn-primary btn-lg btn-rect">SAVE</button>
											</div>
										</form>
										<!-- hidden form -->
										</div>
									</div>
								</div>

							

					 	</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>
</div>
</section>